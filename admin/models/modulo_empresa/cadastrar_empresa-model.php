<?php
	class CadastrarEmpresaModel extends MainModel
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
		 * Insert companies
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_company()
		{
			/**
			 * Check if information was sent from web form with a field called insere_empresa.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_empresa'] ) )
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

			// Remove insere_empresa field to avoid problems with PDO
			unset($_POST['insere_empresa']);

			// Insert data in database
			$query = $this->db->insert( 'cliente.empresa', $_POST );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Empresa cadastrada com sucesso!</p>';

				// Redirect
				?><script>alert("Empresa cadastrada com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

				return;
			} 

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
	 
		} // insert_company
		
		/**
		 * Get state list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_state_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_ESTADO`, `UF` FROM `info.estados` WHERE `DATA_FECHA` IS NULL');

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
			$query = $this->db->query("SELECT EMP.`CNPJ`, EMP.`INSCRICAO_ESTADUAL`, EMP.`RAZAO_SOCIAL`, EMP.`NOME_FANTASIA`, 
									   CASE EMP.`MODALIDADE_EMPRESA` WHEN 1 THEN 'Matriz' WHEN 2 THEN 'Filial' END AS `MODALIDADE_EMPRESA`,
									   EMP.`DATA_ABERTURA`, EMP.`N_FUNCIONARIOS`, EMP.`CIDADE`, EMP.`UF` FROM `cliente.empresa` AS EMP 
									   WHERE EMP.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_company_list
	}
?>