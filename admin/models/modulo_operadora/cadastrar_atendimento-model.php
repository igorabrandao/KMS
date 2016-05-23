<?php
	class CadastrarAtendimentoModel extends MainModel
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

			// Define the active tab
			$GLOBALS['ACTIVE_TAB'] = "Operadora";
		}

		/**
		 * Insert atendimentos
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_atendimento()
		{
			/**
			 * Check if information was sent from web form with a field called insere_atendimento.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_atendimento'] ) )
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

			// Remove insere_atendimento field to avoid problems with PDO
			unset($_POST['insere_atendimento']);
			unset($_POST['N_DIAS']);

			// Insert data in database
			$query = $this->db->insert( 'atendimento.atendimento', $_POST );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Atendimento cadastrado com sucesso!</p>';

				// Redirect
				?><script>alert("Atendimento cadastrado com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

				return;
			}

			// Error
			$this->form_msg = '';

		} // insert_atendimento

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
			$query = $this->db->query('SELECT `ID_TIPO_SERVICO`, `DESCRITIVO` FROM `atendimento.tiposervico` WHERE 1 ORDER BY `ID_TIPO_SERVICO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_service_type
	}
?>