<?php
	class CadastrarOSModel extends MainModel
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

			// Set controller
			$this->controller = $controller;

			// Set parameters
			$this->parametros = $this->controller->parametros;

			// Set user data
			$this->userdata = $this->controller->userdata;
		}

		/**
		 * Insert atendimentos
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_OS()
		{
			/**
			 * Check if information was sent from web form with a field called insere_OS.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_OS'] ) )
			{
				return;
			}

			/**
			 * Looking for avoiding conflicts, this function insert just values if parameter 'edit' is unset.
			*/
			if ( chk_array( $this->parametros, 0 ) == 'edit' )
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

			// Remove insere_OS field to avoid problems with PDO
			unset($_POST['insere_OS']);
			unset($_POST['N_DIAS']);

			// Insert data in database
			$query = $this->db->insert( 'os.ordemservico', $_POST );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">OS cadastrada com sucesso!</p>';

				// Redirect
				?><script>alert("OS cadastrada com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

				return;
			}

			// Error
			$this->form_msg = '';

		} // insert_OS

		/**
		 * Get operadora list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_operadora_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_OPERADORA`, `NOME_OPERADORA` FROM `operadora.operadora` WHERE 1 ORDER BY `ORDEM`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_operadora_list
		
		/**
		 * Get service type
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_service_type() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_SERVICO`, `NOME_SERVICO` FROM `os.tiposervico` WHERE 1 ORDER BY `ID_TIPO_SERVICO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_service_type

		/**
		 * Get company list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_company_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_CLIENTE`, `CNPJ`, `RAZAO_SOCIAL` FROM `cliente.empresa`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_company_list
	}
?>