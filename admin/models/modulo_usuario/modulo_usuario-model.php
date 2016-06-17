<?php

	class ModuloUsuarioModel extends MainModel
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
			$GLOBALS['ACTIVE_TAB'] = "Usuario";
		}

		/**
		 * Get belts list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_belt_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_FAIXA`, `NOME` FROM `faixa` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_belt_list

		/**
		 * Get state list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_state_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_ESTADO`, `NOME` FROM `estados` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_state_list

		/**
		 * Get user type list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_user_type_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_USUARIO`, `DESCRICAO` FROM `tipoUsuario` 
				WHERE `ID_TIPO_USUARIO` != 1 AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_user_type_list

		/**
		 * Get user list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_user_list() 
		{
			// Select the necessary data from DB
			$sql = "SELECT USR.`ID_USUARIO`, USR.`ID_TIPO_USUARIO`, USR.`FOTO`, TUSR.`DESCRICAO` AS TP_USUARIO, USR.`ID_FAIXA`, FX.`NOME` AS FAIXA, USR.`PRIMEIRO_NOME`, USR.`SOBRENOME`, USR.`CPF`, USR.`DATA_CADASTRO`, USR.`DATA_FECHA` 
				FROM 
					`usuario` AS USR
				INNER JOIN 
					`tipoUsuario` AS TUSR ON TUSR.`ID_TIPO_USUARIO` = USR.`ID_TIPO_USUARIO`
				INNER JOIN 
					`faixa` AS FX ON FX.`ID_FAIXA` = USR.`ID_FAIXA`
				WHERE 
					USR.`DATA_FECHA` IS NULL";

			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_user_list

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
				USR.`CPF`, USR.`DATA_NASCIMENTO`, USR.`SEXO`, USR.`EMAIL`, USR.`SENHA`, USR.`CHAVE`, USR.`TELEFONE`, 
				USR.`CELULAR`, USR.`ID_ENDERECO`, USR.`TIPO_SANGUINEO`, USR.`FOTO`, USR.`DATA_CADASTRO`,
				ADDR.`CEP`, ADDR.`LOGRADOURO`, ADDR.`NUMERO`, ADDR.`COMPLEMENTO`, ADDR.`BAIRRO`, ADDR.`CIDADE`, ADDR.`ID_UF`
				FROM 
					`usuario` as USR 
				INNER join
					`endereco` as ADDR ON ADDR.`ID_ENDERECO` = USR.`ID_ENDERECO`
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
		 * Get user info
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_user_info_complete( $id_user_ ) 
		{
			// Select the necessary data from DB
			$sql = "SELECT USR.`ID_USUARIO`, USR.`ID_TIPO_USUARIO`, USR.`ID_FAIXA`, USR.`PRIMEIRO_NOME`, USR.`SOBRENOME`, 
				USR.`CPF`, USR.`DATA_NASCIMENTO`, USR.`SEXO`, USR.`EMAIL`, USR.`SENHA`, USR.`CHAVE`, USR.`TELEFONE`, 
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
		} // get_user_info_complete

		/**
		 * Upload the user profile image
		 *
		 * @param $file_ 	=> file upload object
		 * @return string 	=> filename
		 *
		 * @since 0.1
		 * @access public
		*/
		public function upload_user_image( $file_ )
		{
			// AUxiliary variables
			$uploaddir = "resources/user_profile/";	//! Directory to storage the file

			// Check if the object exists
			if ( isset($file_) )
			{
				//! Define the file name
				$ip = get_client_ip();

				if ( $ip == "::1" )
					$ip = "127.0.0.1";

				$file_name = $ip;

				//!****************************************IMAGE'S UPLOAD***************************************//!

				//! Search for the file extension
				$path = $file_['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);

				//! Control file name version
				$file_counter_name = 1;

				//! File's full pathname
				$full_pathname = $uploaddir . $file_name . "." . $ext;

				//! Check if the file name already exists
				while ( file_exists($full_pathname) )
				{
					$file_name = $ip . "[" . $file_counter_name . "]";
					$file_counter_name += 1;

					//! Update file's full pathname
					$full_pathname = $uploaddir . $file_name . "." . $ext;
				}

				//! Define the directory where the file'll be saved
				$uploadfile = $uploaddir . $file_name . "." . $ext;

				//! File upload
				move_uploaded_file($file_['tmp_name'], $uploadfile);
				chmod($uploadfile, FULL_PERMISSION);
				return $uploadfile;

				//!*********************************************************************************************//!
			}

			return "";
		} // upload_user_image

		/**
		 * Insert users
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_user()
		{
			/**
			 * Check if information was sent from web form with a field called insere_empresa.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] )
			{
				return;
			}

			/**
			 * Verify if some information is being updated
			*/
			if ( is_numeric( chk_array( $this->parametros, 1 ) ) )
			{
				return;
			}

			// Auxiliary variable to define the information position in array
			$info_position = 15;

			// Generate a standard password to the user
			$auxiliary_array = array();

			// ******************************* HASH MODULE *******************************
			// Base-2 logarithm of the iteration count used for password stretching
			$hash_cost_log2 = 8;

			// Do we require the hashes to be portable to older systems (less secure)?
			$hash_portable = FALSE;

			$phpass = new PasswordHash($hash_cost_log2, $hash_portable);
			// ***************************************************************************

			$password = $phpass->HashPassword("mudar123");

			// Handle the user profile image
			if ( isset($_FILES['FOTO']) && strcmp($_FILES['FOTO']['name'], "") != 0 )
			{
				$auxiliary_array["FOTO"] = "";
				$auxiliary_array["FOTO"] = $this->upload_user_image($_FILES['FOTO']);
				$info_position += 1; // Added one more column
			}

			$auxiliary_array["SENHA"] = $password;
			$auxiliary_array["CHAVE"] = "";
			$auxiliary_array["ID_ENDERECO"] = 0;
			$auxiliary_array["DATA_CADASTRO"] = date("d-m-Y H:i:s");

			$_POST = $auxiliary_array + $_POST;

			/*
			 * 1º step: insert the address
			*/
			$query = $this->db->insert( 'endereco', array_slice($_POST, $info_position) );

			// Check if the insertion worked
			if ( $query )
			{
				/*
				 * 2º step: insert the user
				*/
				// Add last inserted ID to aux variable
				$_POST["ID_ENDERECO"] = $this->db->last_id;

				$query2 = $this->db->insert( 'usuario', array_slice($_POST, 0, $info_position) );

				// Check if the insertion worked
				if ( $query2 )
				{
					// Redirect (success)
					?><script>window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario?status=success&action=insert')); ?>";</script> <?php
				}
				return;
			}

			// Redirect (error)
			?><script>window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario?status=error&action=insert')); ?>";</script> <?php

		} // insert_user

		/**
		 * Edit users
		 *
		 * @param id_addr_ => user addres ID
		 * @param id_user_ => user ID
		 *
		 * @since 0.1
		 * @access public
		*/
		public function edit_user( $id_addr_, $id_user_ )
		{
			/**
			 * Check if information was sent from web form with a field called insere_empresa.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] )
			{
				return;
			}

			/**
			 * Verify if some information is being updated
			*/
			if ( is_numeric( chk_array( $this->parametros, 1 ) ) )
			{
				return;
			}

			// Auxiliary variable to define the information position in array
			$info_position = 11;

			// Generate a standard password to the user
			$auxiliary_array = array();

			// Handle the user profile image
			if ( isset($_FILES['FOTO']) && strcmp($_FILES['FOTO']['name'], "") != 0 )
			{
				$auxiliary_array["FOTO"] = "";
				$auxiliary_array["FOTO"] = $this->upload_user_image($_FILES['FOTO']);
				$info_position += 1; // Added one more column
			}

			$_POST = $auxiliary_array + $_POST;

			/*
			 * 1º step: insert the address
			*/
			$query = $this->db->update( 'endereco', 'ID_ENDERECO', $id_addr_, array_slice($_POST, $info_position) );

			// Check if the insertion worked
			if ( $query )
			{
				/*
				 * 2º step: insert the user
				*/
				$query2 = $this->db->update( 'usuario', 'ID_USUARIO', $id_user_, array_slice($_POST, 0, $info_position) );

				// Check if the insertion worked
				if ( $query2 )
				{
					// Redirect (success)
					?><script>window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario?status=success&action=edit')); ?>";</script> <?php
				}
				return;
			}

			// Redirect (error)
			?><script>window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario?status=error&action=edit')); ?>";</script> <?php

		} // insert_user

		/**
		 * Delete an specific user
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param $user_ID_ => user ID
		*/
		public function delete_user( $user_ID_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["DATA_FECHA"] = date("d-m-Y H:i:s");

			// Check the item type
			if ( isset($user_ID_) && $user_ID_ != "" && $user_ID_ != 0 )
			{
				// Disable the user itself
				$query = $this->db->update( 'usuario', 'ID_USUARIO', $user_ID_, $arr_data );

				// Cascade (if it's necessary)
			}

			echo "///";

		} // delete_user
	}

?>