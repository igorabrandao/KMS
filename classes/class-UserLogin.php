<?php
	/**
	 * UserLogin - Handle user data
	 *
	 * Handle use data, do login and logout, check permission and redirect page for logged user.
	 *
	 * @package KMSMVC
	 * @since 0.1
	*/
	class UserLogin extends MainModel
	{
		/**
		 * Class constructor
		 *
		 * Set the database, controller, parameter and user data.
		 *
		 * @since 0.1
		 * @access public
		 * @param object $db PDO Conexion object
		*/
		public function __construct( $db )
		{
			// Set DB (PDO)
			$this->db = $db;
		}

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
		 * Error message for login form
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
		public function check_userlogin() 
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

			/*
			 * Verify if it's a POST request
			 * Login case (HTTP POST)
			*/
			if ( strcmp('POST', $_SERVER['REQUEST_METHOD']) == 0 )
			{
				// Set user data
				$userdata = $_POST;

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
			$query = $this->db->query('SELECT `ID_USUARIO`, `ID_TIPO_USUARIO`, `PRIMEIRO_NOME`, `SOBRENOME`, `DATA_NASCIMENTO`, `EMAIL`, `SENHA`, `SESSION_ID` FROM `usuario` WHERE `EMAIL` = "' . $user . '" LIMIT 1');

			// Check the query
			if ( !$query )
			{
				$this->logged_in = false;
				$this->login_error = 'Erro interno.';

				// Unset any existent user session
				$this->logout();
				return;
			}

			// Get data from user database
			$fetch = $query->fetch(PDO::FETCH_ASSOC);

			// Get user ID
			$user_id = (int) $fetch['ID_USUARIO'];

			// Check if user ID exists
			if ( empty( $user_id ) )
			{
				$this->logged_in = false;
				$this->login_error = 'Usuário não existente.';

				// Unset any existent user session
				$this->logout();
				return;
			}

			// ******************************* HASH MODULE *******************************
			// Base-2 logarithm of the iteration count used for password stretching
			$hash_cost_log2 = 8;

			// Do we require the hashes to be portable to older systems (less secure)?
			$hash_portable = FALSE;

			$phpass = new PasswordHash($hash_cost_log2, $hash_portable);
			// ***************************************************************************

			// Compare the password with HASH from DB
			if ( $phpass->CheckPassword( $user_password, $fetch['SENHA'] ) )
			{
				// Compare the sessionID with DB session
				if ( session_id() != $fetch['SESSION_ID'] && ! $post )
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
					$query = $this->db->query( 'UPDATE usuario SET SESSION_ID = ? WHERE ID_USUARIO = ?', array( $session_id, $user_id ) );
				}

				// Get an array with user permission
				//$_SESSION['userdata']['user_permissions'] = unserialize( $fetch['user_permissions'] );
				$_SESSION['userdata']['user_permissions'] = "";

				// Set the property logged_in as logged
				$this->logged_in = true;

				// Set $this->userdata 
				$this->userdata = $_SESSION['userdata'];

				// **** CREATE COOKIE ****
				$id = $fetch['ID_USUARIO'];
				//create_cookie( $phpass->HashPassword($id), "USR");
				create_cookie( $id, "USR");

				// Check if exists an URL to redirect user to another page
				if ( isset( $_SESSION['goto_url'] ) )
				{
					// Set the URL in a variable
					$goto_url = urldecode( $_SESSION['goto_url'] );
					$goto_url = str_replace("?action=logout", "", $goto_url);

					// Remove URL session
					unset( $_SESSION['goto_url'] );

					// Redirect to the page
					echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
					//header( 'location: ' . $goto_url );
				}
				else if ( defined( 'HOME_URI' ) )
				{
					// Set the URL in a variable
					$goto_url = HOME_URI;

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
				$this->login_error = 'Usuário ou senha incorreto.';

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
			// The login page cannot redirect to itself
			if ( strpos($_SERVER['REQUEST_URI'], "modulo_login") === false )
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
				$login_uri  = HOME_URI . '/modulo_login/';

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
		 * Get user info
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_user_info( $id_user_ ) 
		{
			// Select the necessary data from DB
			$sql = "SELECT USR.`ID_USUARIO`, USR.`ID_TIPO_USUARIO`, USR.`ID_FAIXA`, USR.`PRIMEIRO_NOME`, USR.`SOBRENOME`, 
				USR.`CPF`, USR.`DATA_NASCIMENTO`, USR.`SEXO`, USR.`EMAIL`, USR.`SENHA`, USR.`TELEFONE`, 
				USR.`CELULAR`, USR.`ID_ENDERECO`, USR.`TIPO_SANGUINEO`, USR.`FOTO`, USR.`DATA_CADASTRO`,
				ADDR.`CEP`, ADDR.`LOGRADOURO`, ADDR.`NUMERO`, ADDR.`COMPLEMENTO`, ADDR.`BAIRRO`, ADDR.`CIDADE`, ADDR.`ID_UF`,
				FX.`NOME` AS FAIXA, EST.`NOME` AS ESTADO
				FROM 
					`usuario` as USR 
				INNER JOIN
					`endereco` as ADDR ON ADDR.`ID_ENDERECO` = USR.`ID_ENDERECO`
				INNER JOIN
					`faixa` as FX ON FX.`ID_FAIXA` = USR.`ID_FAIXA`
				INNER JOIN
					`estados` as EST ON EST.`ID_ESTADO` = ADDR.`ID_UF`
				WHERE 
					USR.`ID_USUARIO` = " . $id_user_ . " AND
					USR.`DATA_FECHA` IS NULL";

			$query = $this->db->query($sql);

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetch();
		} // get_user_info

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