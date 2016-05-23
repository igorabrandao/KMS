<?php
	/**
	 * UserLogin - Handle user data
	 *
	 * Handle use data, do login and logout, check permission and redirect page for logged user.
	 *
	 * @package KMSMVC
	 * @since 0.1
	*/
	class UserLogin
	{
		/**
		 * User logged or not
		 *
		 * True if logged.
		 *
		 * @public
		 * @access public
		 * @var bol
		*/
		public $logged_in;

		/**
		 * User data
		 *
		 * @public
		 * @access public
		 * @var array
		*/
		public $userdata;

		/**
		 * Error messagem for login form
		 *
		 * @public
		 * @access public
		 * @var string
		*/
		public $login_error;

		/**
		 * Verify login
		 *
		 * Set the properties $logged_in and $login_error. Also set an array with user and password		 
		*/
		public function check_userlogin () 
		{
			/*
			 * Verify if exists a session with userdata key
			 * The parameter most be an array instead an HTTP POST
			*/
			if ( isset( $_SESSION['userdata'] )
				 && ! empty( $_SESSION['userdata'] )
				 && is_array( $_SESSION['userdata'] ) 
				 && ! isset( $_POST['userdata'] )
				)
			{
				// Set user data
				$userdata = $_SESSION['userdata'];

				// Make sure that ins't a HTTP POST
				$userdata['post'] = false;
			}

			/*
			 * Verify if exists a session with userdata key
			 * The parameter most be an array instead an HTTP POST
			*/
			if ( isset( $_POST['userdata'] )
				 && ! empty( $_POST['userdata'] )
				 && is_array( $_POST['userdata'] ) 
				)
			{
				// Set user data
				$userdata = $_POST['userdata'];

				// Make sure that ins't a HTTP POST
				$userdata['post'] = true;
			}

			// Check if it's necessary analise some user information
			if ( ! isset( $userdata ) || ! is_array( $userdata ) )
			{
				// Kill user session
				$this->logout();
				return;
			}

			// Set a variable with a post value
			if ( $userdata['post'] === true ) 
				$post = true;
			else
				$post = false;

			// Remove a chave post do array userdata
			unset( $userdata['post'] );

			// Check if it's necessary analise some user information
			if ( empty( $userdata ) )
			{
				$this->logged_in = false;
				$this->login_error = null;

				// Kill user session
				$this->logout();
				return;
			}

			// Extract variables from user data
			extract( $userdata );

			// Check if exists an user and password
			if ( ! isset( $user ) || ! isset( $user_password ) )
			{
				$this->logged_in = false;
				$this->login_error = null;

				// Unset any existent user session
				$this->logout();
				return;
			}

			// Check if user exists in the database
			$query = $this->db->query( 'SELECT * FROM users WHERE user = ? LIMIT 1', array( $user ) );

			// Check the query
			if ( ! $query )
			{
				$this->logged_in = false;
				$this->login_error = 'Internal error.';

				// Unset any existent user session
				$this->logout();
				return;
			}

			// Get data from user database
			$fetch = $query->fetch(PDO::FETCH_ASSOC);

			// Get user ID
			$user_id = (int) $fetch['user_id'];

			// Check if user ID exists
			if ( empty( $user_id ) )
			{
				$this->logged_in = false;
				$this->login_error = 'User do not exists.';

				// Unset any existent user session
				$this->logout();
				return;
			}

			// Compare the password with HASH from DB
			if ( $this->phpass->CheckPassword( $user_password, $fetch['user_password'] ) )
			{
				// Compare the sessionID with DB session
				if ( session_id() != $fetch['user_session_id'] && ! $post )
				{
					$this->logged_in = false;
					$this->login_error = 'Wrong session ID.';

					// Unset any existent user session
					$this->logout();
					return;
				}

				// If it's a post session
				if ( $post )
				{
					// Generate new ID to session
					session_regenerate_id();
					$session_id = session_id();

					// Send the data to the session
					$_SESSION['userdata'] = $fetch;

					// Update password
					$_SESSION['userdata']['user_password'] = $user_password;

					// Update session ID
					$_SESSION['userdata']['user_session_id'] = $session_id;

					// Update session ID in database
					$query = $this->db->query( 'UPDATE users SET user_session_id = ? WHERE user_id = ?', array( $session_id, $user_id ) );
				}

				// Get an array with user permission
				$_SESSION['userdata']['user_permissions'] = unserialize( $fetch['user_permissions'] );

				// Set the property logged_in as logged
				$this->logged_in = true;

				// Set $this->userdata 
				$this->userdata = $_SESSION['userdata'];

				// Check if exists an URL to redirect user to another page
				if ( isset( $_SESSION['goto_url'] ) )
				{
					// Set the URL in a variable
					$goto_url = urldecode( $_SESSION['goto_url'] );

					// Remove URL session
					unset( $_SESSION['goto_url'] );

					// Redirect to the page
					echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
					echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
					//header( 'location: ' . $goto_url );
				}

				return;
			}
			else
			{
				// User isn't logged
				$this->logged_in = false;

				// Password doesn't match
				$this->login_error = 'Password does not match.';

				// Remove all
				$this->logout();
				return;
			}
		}

		/**
		 * Logout
		 *
		 * Unset everything about user.
		 *
		 * @param bool $redirect If true, redirect to login page
		 * @final
		*/
		protected function logout( $redirect = false )
		{
			// Remove all data from $_SESSION['userdata']
			$_SESSION['userdata'] = array();

			// Only to make sure (it isn't really needed)
			unset( $_SESSION['userdata'] );

			// Regenerates the session ID
			session_regenerate_id();

			if ( $redirect === true )
			{
				// Send the user to the login page
				$this->goto_login();
			}
		}

		/**
		 * Go to login page
		*/
		protected function goto_login()
		{
			// Check if HOME URI is setted
			if ( defined( 'HOME_URI' ) )
			{
				// Set login URL
				$login_uri  = HOME_URI . '/login/';

				// Set the current page
				$_SESSION['goto_url'] = urlencode( $_SERVER['REQUEST_URI'] );

				// Redirection
				echo '<meta http-equiv="Refresh" content="0; url=' . $login_uri . '">';
				echo '<script type="text/javascript">window.location.href = "' . $login_uri . '";</script>';
				// header('location: ' . $login_uri);
			}

			return;
		}

		/**
		 * Redirect to any page
		 *
		 * @final
		*/
		final protected function goto_page( $page_uri = null )
		{
			if ( isset( $_GET['url'] ) && ! empty( $_GET['url'] ) && ! $page_uri )
			{
				// Set URL
				$page_uri  = urldecode( $_GET['url'] );
			}

			if ( $page_uri )
			{ 
				// Redirect
				echo '<meta http-equiv="Refresh" content="0; url=' . $page_uri . '">';
				echo '<script type="text/javascript">window.location.href = "' . $page_uri . '";</script>';
				//header('location: ' . $page_uri);
				return;
			}
		}

		/**
		 * Check permission
		 *
		 * @param string $required The permission is required
		 * @param array $user_permissions User permissions
		 * @final
		*/
		final protected function check_permissions(
			$required = 'any', 
			$user_permissions = array('any')
		) {
			if ( ! is_array( $user_permissions ) ) {
				return;
			}

			// If user doesn't have the necessary permission
			if ( ! in_array( $required, $user_permissions ) ) {
				// Return false
				return false;
			} else {
				return true;
			}
		}
	}
?>