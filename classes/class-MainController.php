<?php
	/**
	 * MainController - All controllers derivate from this class
	 *
	 * @package KMSMVC
	 * @since 0.1
	*/
	class MainController extends UserLogin
	{
		/**
		 * $db
		 *
		 * Database connection. Keeps the PDO's object
		 *
		 * @access public
		 */
		public $db;

		/**
		 * $phpass
		 *
		 * Classe phpass 
		 *
		 * @see http://www.openwall.com/phpass/
		 * @access public
		*/
		public $phpass;

		/**
		 * $title
		 *
		 * Pages title
		 *
		 * @access public
		*/
		public $title;

		/**
		 * $login_required
		 *
		 * If the page needs authentication (login)
		 *
		 * @access public
		*/
		public $login_required = false;

		/**
		 * $permission_required
		 *
		 * Permission needed (security level control)
		 *
		 * @access public
		*/
		public $permission_required = 'any';

		/**
		 * $parametros
		 *
		 * @access public
		*/
		public $parametros = array();

		public $user_info = array();

		/**
		 * Class constructor
		 *
		 * Set the properties and class's method
		 *
		 * @since 0.1
		 * @access public
		*/
		public function __construct ( $parametros = array() )
		{
			// DB instance
			$this->db = new KMSDB();

			// Phpass
			$this->phpass = new PasswordHash(8, false);

			// Parameters
			$this->parametros = $parametros;

			// Check logout
			if ( isset($_GET["action"]) && strcmp($_GET["action"], "logout") == 0 )
			{
				// Remove o cookie com as informações do visitante
				if (isset($_COOKIE["USR"])) 
				{
					setcookie("USR", false, (time() - 3600), '/');
					unset($_COOKIE["USR"]);
				}

				$this->logout(true);
			}
			else
			{
				// Check login
				$this->check_userlogin();

				// Check the cookie
				if (isset($_COOKIE["USR"])) 
				{
					$this->user_info = $this->get_user_info($_COOKIE["USR"]);
				}
				else
				{
					$this->logout(true);
				}
			}
		} // __construct

		/**
		 * Load model
		 *
		 * Load models present in the folder /models/.
		 *
		 * @since 0.1
		 * @access public
		*/
		public function load_model( $model_name = false )
		{
			// A file should be sent
			if ( ! $model_name ) return;

			// Make sure that model's name is lower-case
			$model_name =  strtolower( $model_name );

			// Include the file
			$model_path = ABSPATH . '/models/' . $model_name . '.php';

			// Check if file exists
			if ( file_exists( $model_path ) ) 
			{
				// Include the file
				require_once $model_path;

				// Remove the file path (if exists)
				$model_name = explode('/', $model_name);

				// Get just the final of the path
				$model_name = end( $model_name );

				// Remove invalid characters from file name
				$model_name = preg_replace( '/[^a-zA-Z0-9]/is', '', $model_name );

				// Check if class exists
				if ( class_exists( $model_name ) )
				{
					// Return a object from class
					return new $model_name( $this->db, $this );
				}

				return;
			}
		} // load_model

	} // class MainController
?>