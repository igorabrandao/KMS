<?php
	class CadastrarRepresentanteModel extends MainModel
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

			// Configura os parâmetros
			$this->parametros = $this->controller->parametros;

			// Configura os dados do usuário
			$this->userdata = $this->controller->userdata;

			// Define the active tab
			$GLOBALS['ACTIVE_TAB'] = "Empresa";
		}

		/**
		 * Insert representative
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_representante()
		{
			// Auxiliar variables
			$arr_data = array();

			/**
			 * Check if information was sent from web form with a field called insere_representante.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_representante'] ) )
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

			// Remove insere_representante field to avoid problems with PDO
			unset($_POST['insere_representante']);
			unset($_POST['chk_tipo_representante']);

			// Insert data in database
			$query = $this->db->insert( 'cliente.representante', array_slice($_POST, 1) );

			// Check the query
			if ( $query )
			{
				// Add last inserted ID to $_POST array
				$arr_data['ID_EMPRESA'] = $_POST['ID_EMPRESA'];
				$arr_data['ID_REPRESENTANTE'] = $this->db->last_id;

				// Insert relation between representative and company
				$query2 = $this->db->insert( 'cliente.auxempresarepresentante', $arr_data );

				// Check operation once again
				if ( $query2 )
				{
					// Return a message
					$this->form_msg = '<p class="success">Representante cadastrado com sucesso!</p>';

					// Redirect
					?><script>alert("Representante cadastrado com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

					return;
				}
			}

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
	 
		} // insert_representante

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

		/**
		 * Get representative list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_type_representante() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_REPRESENTANTE`, `DESCRICAO` FROM `cliente.tiporepresentante`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_company_list

		/**
		 * Get representante list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_representante_list()
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT CLI.`CPF`, CLI.`NOME_COMPLETO`, TPR.`DESCRICAO`, CLI.`CARGO`, CLI.`EMAIL` 
									   FROM `cliente.representante` AS CLI INNER JOIN `cliente.tiporepresentante` AS TPR ON 
									   TPR.`ID_TIPO_REPRESENTANTE` = CLI.`TIPO_REPRESENTANTE` WHERE CLI.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_representante_list
	}
?>