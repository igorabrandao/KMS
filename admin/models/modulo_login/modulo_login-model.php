<?php

	class ModuloLoginModel extends MainModel
	{
		/**
		 * Class constructor
		 *
		 * Set the database, controller, parameter and user data.
		 *
		 * @since 0.1
		 * @access public
		 * @param object $db PDO Conexion object
		 * @param object $controller Controller object
		*/
		public function __construct( $db = false, $controller = null )
		{
			// Set DB (PDO)
			$this->db = $db;

			// Set the controller
			$this->controller = $controller;

			// Set the main parameters
			$this->parametros = $this->controller->parametros;

			// Set user data
			$this->userdata = $this->controller->userdata;
			
			// Define the active tab
			$GLOBALS['ACTIVE_TAB'] = "Aula";
		}

		/**
		 * Perform the login
		 *
		 * Set the properties $logged_in and $login_error. Also set an array with user and password		 
		*/
		public function do_login() 
		{
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
			else
			{
				return;
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
				$id = $fetch['ID_USUARIO'];
				$info = "";

				// Adicionando algumas informações adicionais do usuário
				$info = $info . "true//" . $_SERVER['REMOTE_ADDR'] . "//" . $_SERVER['HTTP_USER_AGENT'];

				// Criando um sessão para o usuário
				start_session($id, $info, PREFIXO . $id);

				// Criando um cookie para armazenar o id do usuário
				create_cookie($id, PREFIXO);

				// Set the URL in a variable
				$goto_url = HOME_URI;

				var_dump($info);
				var_dump($user_data);

				return;

				// Redirect to the page
				echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
				echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
				//header( 'location: ' . $goto_url );
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
	}

?>