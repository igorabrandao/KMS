<?php
	class CadastrarCotacaoModel extends MainModel
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
		 * Insert cotation
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_cotation()
		{
			/**
			 * Check if information was sent from web form with a field called insere_cotacao.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_cotacao'] ) )
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

			// Remove insere_cotacao field to avoid problems with PDO
			unset($_POST['insere_cotacao']);

			// Insert data in database
			$query = $this->db->insert( 'cotacao.cotacao', $_POST );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Cotação cadastrada com sucesso!</p>';

				// Redirect
				?><script>alert("Cotação cadastrada com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

				return;
			}

			// Error
			$this->form_msg = '';

		} // insert_cotation

		/**
		 * Get operadora list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_operadora_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_OPERADORA`, `NOME_OPERADORA` FROM `operadora.operadora` WHERE `DATA_FECHA` IS NULL ORDER BY `ORDEM`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_operadora_list
		
		/**
		 * Get cotation type
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_cotation_type() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_COTACAO`, `DESCRITIVO` FROM `cotacao.tipocotacao` WHERE `DATA_FECHA` IS NULL ORDER BY `ID_TIPO_COTACAO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_cotation_type
		
		/**
		 * Get state type
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_state_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `UF`, `NOME` FROM `info.estados` WHERE `DATA_FECHA` IS NULL ORDER BY `ID_ESTADO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_state_list

		/**
		 * Get company list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_company_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_CLIENTE`, `CNPJ`, `RAZAO_SOCIAL` FROM `cliente.empresa` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_company_list
	}
?>