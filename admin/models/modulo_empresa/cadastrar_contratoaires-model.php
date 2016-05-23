<?php
	class CadastrarContratoAiresModel extends MainModel
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
		 * Insert contract
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_contrato()
		{
			// Auxiliar variables
			$arr_data = array();
			$contract_path = "";
			$count = 0;

			/**
			 * Check if information was sent from web form with a field called insere_contratoaires.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_contratoaires'] ) )
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

			// Remove insere_contratoaires field to avoid problems with PDO
			unset($_POST['insere_contratoaires']);
			unset($_POST['chk_operadora']);

			// Insert contract's head in database
			$query = $this->db->insert( 'aires.contrato', array_slice($_POST, 0, 2) );

			// Check operation
			if ( $query )
			{
				// Add last inserted ID to $_POST array
				$_POST['ID_CONTRATO'] = $this->db->last_id;

				// Insert contract's terms
				$query2 = $this->db->insert( 'aires.auxcontrato', array_slice($_POST, 2) );

				// Check operation once again
				if ( $query2 )
				{
					// Check if there are files to be uploaded
					if ( ! empty($_FILES['file_anexo']['name']) )
					{
						// Define contract's path
						$contract_path = ABSPATH . '/resources/contratos/' . $_POST['ID_EMPRESA'];

						// Define aux_contract_ID
						$arr_data['ID_AUX_CONTRATO'] = $this->db->last_id;

						// Check if contract folder exist, if not create it!
						if ( ! file_exists($contract_path) )
						{
							mkdir($contract_path, 0777, true);
						}

						// Upload files if exist
						foreach ( $_FILES['file_anexo']['name'] as $key => $name ) 
						{     
							if ( $_FILES['file_anexo']['error'][$key] == 4 )
							{
								continue; // Skip file if any error found
							}

							if ( $_FILES['file_anexo']['error'][$key] == 0 )
							{
								if ( $_FILES['file_anexo']['size'][$key] > MAX_FILE_SIZE )
								{
									$message[] = "$name é muito grande!.";
									continue; // Skip large files
								}
								else
								{ 
									// No error found! Move uploaded files 
									if( move_uploaded_file($_FILES["file_anexo"]["tmp_name"][$key], $contract_path . "/" . $_FILES['file_anexo']['name'][$key]) )
									{
										// Insert contract's attachment's
										$arr_data['ANEXO'] = $contract_path . "/" . $_FILES['file_anexo']['name'][$key];
										$query3 = $this->db->insert( 'aires.auxanexocontrato', $arr_data );
									}
									$count++; // Number of successfully uploaded file
								}
							}
						}
					}

					// Return a message
					$this->form_msg = '<p class="success">Contrato cadastrado com sucesso!</p>';

					// Redirect
					?><script>alert("Contrato cadastrado com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

					return;
				}
			} 

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
	 
		} // insert_contrato
		
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
		 * Get contract list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_contract_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT * FROM `view_contrato_aires`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_contract_list
	}
?>