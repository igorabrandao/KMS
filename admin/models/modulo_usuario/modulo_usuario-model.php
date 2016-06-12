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
		 * Get all valid user in database
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function getUsers()
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT USR.`ID_USUARIO`, USR.`ID_TIPO_USUARIO`, USR.`ID_FAIXA`, USR.`PRIMEIRO_NOME`, USR.`SOBRENOME`, 
				USR.`CPF`, USR.`DATA_CADASTRO`, USR.`DATA_FECHA` 
				FROM 
					`usuario` AS USR
				INNER JOIN 
					`tipoUsuario` AS TUSR ON TUSR.`ID_TIPO_USUARIO` = USR.`ID_TIPO_USUARIO`
				INNER JOIN 
					`faixa` AS FX ON FX.`ID_FAIXA` = USR.`ID_FAIXA`
				WHERE 
					USR.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;

		} // getUsers

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

			// Generate a standard password to the user
			$auxiliary_array = array();
			$password = hashSSHA("mudar123");

			$auxiliary_array["SENHA"] = $password["encrypted"];
			$auxiliary_array["CHAVE"] = $password["key"];
			$auxiliary_array["ID_ENDERECO"] = 0;

			$_POST = $auxiliary_array + $_POST;

			/*
			 * 1º step: insert the address
			*/
			$query = $this->db->insert( 'endereco', array_slice($_POST, 14) );

			// Check if the insertion worked
			if ( $query )
			{
				/*
				 * 2º step: insert the user
				*/
				// Add last inserted ID to aux variable
				$_POST["ID_ENDERECO"] = $this->db->last_id;
				$query2 = $this->db->insert( 'usuario', array_slice($_POST, 0, 14) );

				// Check if the insertion worked
				if ( $query2 )
				{
					// Redirect (success)
					?><script>alert(window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/cadastrar_usuario?status=success')); ?>";</script> <?php
				}
				return;
			}

			// Redirect (error)
			?><script>alert(window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/cadastrar_usuario?status=error')); ?>";</script> <?php

		} // insert_user
	}

?>