<?php
	class CadastrarChipModel extends MainModel
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
			$GLOBALS['ACTIVE_TAB'] = "Patrimonio";
		}

		/**
		 * Insert chip
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_chip()
		{
			// Auxiliar variables
			$arr_data = array();
			$contract_path = "";
			$count = 0;

			/**
			 * Check if information was sent from web form with a field called insere_chip.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_chip'] ) )
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

			// Remove insere_chip field to avoid problems with PDO
			unset($_POST['insere_chip']);
			unset($_POST['QTD_CHIP']);
			unset($_POST['chip']);

			// Insert contract's head in database
			$query = $this->db->insert( 'patrimonio.lotechip', array_slice($_POST, 0, 1) );

			// Check operation
			if ( $query )
			{
				// Add last inserted ID to $_POST array
				$_POST['ID_LOTE_CHIP'] = $this->db->last_id;

				// Split CHIP array
				$CHIP_list = explode("//", $_POST['elem_chip']);
				unset($_POST['elem_chip']);

				// Insert multiple registers in DB
				for ( $i = 0; $i < sizeof($CHIP_list); $i++ )
				{
					// Update current CHIP
					$_POST['N_CHIP'] = $CHIP_list[$i];

					// Insert contract's terms
					$query2 = $this->db->insert( 'patrimonio.chip', array_slice($_POST, 1) );

					// Check operation once again
					if ( $query2 )
					{
						// Check if there are files to be uploaded
						if ( ! empty($_FILES['file_anexo']['name']) )
						{
							// Define device's path
							$contract_path = ABSPATH . '/resources/patrimonio/chip/' . $_POST['ID_LOTE_CHIP'];

							// Check if chip folder exist, if not create it!
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
											$arr_data['ID_LOTE_CHIP'] = $_POST['ID_LOTE_CHIP'];
											$arr_data['ANEXO'] = $contract_path . "/" . $_FILES['file_anexo']['name'][$key];
											$query3 = $this->db->insert( 'patrimonio.lotechipanexo', $arr_data );
										}
										$count++; // Number of successfully uploaded file
									}
								}
							}
						}
					}
				}
				// Return a message
				$this->form_msg = '<p class="success">Chip(s) cadastrado com sucesso!</p>';

				// Redirect
				?><script>alert("Chip(s) cadastrado com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

				return;
			}

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';

		} // insert_chip

		/**
		 * Get contract list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_contract_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT OC.`ID_CONTRATO_OPERADORA`, OC.`N_CONTA`, OTC.`DESCRITIVO` FROM `operadora.contrato` AS OC
									INNER JOIN `operadora.tipocontrato` AS OTC ON OC.`TIPO_CONTRATO` = OTC.`ID_TIPO_CONTRATO`
									WHERE OC.`DATA_FECHA` IS NULL AND OTC.`DATA_FECHA` IS NULL ORDER BY OC.`ID_CONTRATO_OPERADORA`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_operadora_list
		
		/**
		 * Get brand list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_brand_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_MARCA`, `NOME` FROM `patrimonio.marca` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_brand_list

		/**
		 * Get asset type
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_asset_type() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_ATIVO`, `DESCRICAO` FROM `patrimonio.tipoativo` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_asset_type

		/**
		 * Get acquiring mode
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_acquiring_mode() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_FORMA_AQUISICAO`, `DESCRICAO` FROM `patrimonio.formaaquisicao` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_acquiring_mode
	}
?>