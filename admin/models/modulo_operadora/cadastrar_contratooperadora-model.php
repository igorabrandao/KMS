<?php
	class CadastrarContratoOperadoraModel extends MainModel
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
		 * Load the contract general informations
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function load_contract_info( $contract_id_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `N_CONTA`, `ID_TIPO_CONTRATO`, `ID_EMPRESA`, `ID_TIPO_SERVICO`, `ID_OPERADORA`, 
				`DATA_ASSINATURA`, `DATA_ATIVACAO`, `CARENCIA`, `VALOR_TOTAL_CONTRATO` 
				FROM `operadora.contrato` 
				WHERE 
					`DATA_FECHA` IS NULL AND
					`ID_CONTRATO_OPERADORA` = ' . $contract_id_);

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetch();
		} // load_contract_info

		/**
		 * Insert contract
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_contrato_operadora()
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data2 = array();
			$arr_data3 = array();
			$arr_data4 = array();
			$arr_data5 = array();
			$arr_data6 = array();

			$arr_plan = array();

			$contract_path = "";
			$contract_ID = "";
			$count = 0;

			/**
			 * Check if information was sent from web.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] )
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

			// Remove fields to avoid problems with PDO
			unset( $_POST['layout'] );
			unset( $_POST['header'] );
			unset( $_POST['footer'] );

			// Insert contract's head in database
			$query = $this->db->insert( 'operadora.contrato', array_slice($_POST, 0, 9) );

			// Check operation
			if ( $query )
			{
				// Add last inserted ID to aux variable
				$contract_ID = $this->db->last_id;

				// ========================================================================================

					/**
					 * INSERT CONTRACT EQUIPMENT LIST
					*/

					// Split equip. array
					$equip_list = explode("//", $_POST['elem_EQUIPAMENTOS']);

					// Insert multiple registers in DB
					for ( $i = 0; $i < sizeof($equip_list); $i++ )
					{
						// Update current equipment
						$linha_list = explode("@@", $equip_list[$i]);

						if ( trim($equip_list[$i]) != "" )
						{
							$arr_data3['ID_CONTRATO_OPERADORA'] = $contract_ID;
							$arr_data3['ID_TIPO_NEGOCIACAO'] = $linha_list[0];
							$arr_data3['QTD_APARELHOS'] = $linha_list[1];
							$arr_data3['QTD_CHIPS'] = $linha_list[2];
							$arr_data3['N_PARCELAS'] = $linha_list[3];
							$arr_data3['VALOR_PARCELA_EQUIP'] = str_replace("R$", "", $linha_list[4]);

							if ( $arr_data3['ID_CONTRATO_OPERADORA'] != "" && $arr_data3['ID_TIPO_NEGOCIACAO'] != "" )
							{
								// Insert equipment register
								$query3 = $this->db->insert( 'operadora.contratoequipamentos', $arr_data3 );
							}
						}
					}

					/**
					 * INSERT CONTRACT PLAN LIST
					*/

					// Split plan array
					$plan_list = explode("//", $_POST['elem_PLANOS']);

					// Insert multiple registers in DB
					for ( $i = 0; $i < sizeof($plan_list); $i++ )
					{
						// Update current plan
						$linha_list = explode("@@", $plan_list[$i]);
						
						if ( trim($plan_list[$i]) != "" )
						{
							$arr_data4['ID_CONTRATO_OPERADORA'] = $contract_ID;
							$arr_data4['ID_TIPO_PLANO'] = $linha_list[0];
							$arr_data4['DESCRITIVO_PLANO'] = mb_strtoupper($linha_list[1], 'UTF-8');
							$arr_data4['QUANTIDADE_PLANO'] = $linha_list[2];
							$arr_data4['VALOR_ASSINATURA_PLANO'] = str_replace("R$", "", $linha_list[3]);
							$arr_data4['DESCRITIVO_PACOTE_VOZ'] = mb_strtoupper($linha_list[4], 'UTF-8');
							$arr_data4['TARIFA_LOCAL'] = str_replace("R$", "", $linha_list[5]);
							$arr_data4['VOLUME_PLANO'] = $linha_list[6];
							$arr_data4['MINUTOS'] = $linha_list[7];
							$arr_data4['VALOR_PAC_MIN'] = str_replace("R$", "", $linha_list[8]);
							$arr_data4['DESCONTO_PLANO'] = str_replace("R$", "", $linha_list[9]);
							$arr_data4['VALOR_TOTAL_PLANO'] = str_replace("R$", "", $linha_list[10]);

							if ( $arr_data4['ID_CONTRATO_OPERADORA'] != "" && $arr_data4['ID_TIPO_PLANO'] != "" )
							{
								// Insert plan register
								$query4 = $this->db->insert( 'operadora.planocontrato', $arr_data4 );
								$arr_plan[mb_strtoupper($arr_data4['DESCRITIVO_PLANO'], 'UTF-8')] = $this->db->last_id;
							}
						}
					}

					// Check if at least one plan was inserted
					if ( sizeof($arr_plan) > 0 )
					{
						/**
						 * INSERT CONTRACT MODULE LIST
						*/

						// Split equip. array
						$module_list = explode("//", $_POST['elem_MODULOS']);

						// Insert multiple registers in DB
						for ( $i = 0; $i < sizeof($module_list); $i++ )
						{
							// Update current equipment
							$linha_list = explode("@@", $module_list[$i]);

							if ( trim($module_list[$i]) != "" )
							{
								$arr_data5['ID_CONTRATO_OPERADORA'] = $contract_ID;

								if ( isset($arr_plan[$linha_list[0]]) )
									$arr_data5['ID_PLANO_CONTRATO'] = $arr_plan[$linha_list[0]];
								else
									$arr_data5['ID_PLANO_CONTRATO'] = "";

								$arr_data5['ID_TIPO_MODULO'] = $linha_list[1];
								$arr_data5['IS_COMPARTILHADO'] = $linha_list[2];
								$arr_data5['DESCRITIVO_MODULO'] = mb_strtoupper($linha_list[3], 'UTF-8');
								$arr_data5['QUANTIDADE_MODULO'] = $linha_list[4];
								$arr_data5['VOLUME_MODULO'] = mb_strtoupper($linha_list[5], 'UTF-8');
								$arr_data5['VALOR_ASSINATURA_MODULO'] = str_replace("R$", "", $linha_list[6]);
								$arr_data5['DESCONTO_MODULO'] = $linha_list[7];
								$arr_data5['VALOR_TOTAL_MODULO'] = str_replace("R$", "", $linha_list[8]);

								// Fix to ID_PLANO_CONTRATO
								if ( $arr_data5['ID_PLANO_CONTRATO'] == "" || $arr_data5['ID_PLANO_CONTRATO'] == 0 )
								{
									$arr_data5['ID_PLANO_CONTRATO'] = array_search($linha_list[0], $arr_plan);

									if ( $arr_data5['ID_PLANO_CONTRATO'] == "" || $arr_data5['ID_PLANO_CONTRATO'] == 0 )
									{
										$arr_data5['ID_PLANO_CONTRATO'] = array_values($arr_plan)[0];
									}
								}

								if ( $arr_data5['ID_CONTRATO_OPERADORA'] != "" && $arr_data5['ID_PLANO_CONTRATO'] != "" && $arr_data5['ID_TIPO_MODULO'] != "" )
								{
									// Insert module register
									$query5 = $this->db->insert( 'operadora.modulocontrato', $arr_data5 );
								}
							}
						}

						/**
						 * INSERT CONTRACT DDD LIST
						*/

						// Split DDD array
						$DDD_list = explode("//", $_POST['elem_QTDLINHAS']);

						// Insert multiple registers in DB
						for ( $i = 0; $i < sizeof($DDD_list); $i++ )
						{
							// Update current DDD
							$linha_list = explode("@@", $DDD_list[$i]);
							
							if ( trim($DDD_list[$i]) != "" )
							{
								$arr_data2['ID_CONTRATO_OPERADORA'] = $contract_ID;
								
								if ( isset($arr_plan[$linha_list[0]]) )
									$arr_data2['ID_PLANO_LINHA'] = $arr_plan[$linha_list[0]];
								else
									$arr_data2['ID_PLANO_LINHA'] = "";

								$arr_data2['DDD'] = $linha_list[1];
								$arr_data2['QTD_LINHA'] = $linha_list[2];

								// Fix to ID_PLANO_LINHA
								if ( $arr_data2['ID_PLANO_LINHA'] == "" || $arr_data2['ID_PLANO_LINHA'] == 0 )
								{
									$arr_data2['ID_PLANO_LINHA'] = array_search($linha_list[0], $arr_plan);
									
									if ( $arr_data2['ID_PLANO_LINHA'] == "" || $arr_data2['ID_PLANO_LINHA'] == 0 )
									{
										$arr_data2['ID_PLANO_LINHA'] = array_values($arr_plan)[0];
									}
								}

								if ( $arr_data2['ID_CONTRATO_OPERADORA'] != "" && $arr_data2['ID_PLANO_LINHA'] != "" )
								{
									// Insert DDD quatntity
									$query2 = $this->db->insert( 'operadora.contratoqtdlinha', $arr_data2 );
								}
							}
						}
					}

				// ========================================================================================

				// Check if there are files to be uploaded
				if ( ! empty($_FILES['file_anexo']['name']) )
				{
					// Define contract's path
					$contract_root = ABSPATH . '/resources/contratos_operadoras/' . $_POST['ID_EMPRESA'];
					$contract_path = $contract_root . '/' . $contract_ID;

					// Define aux_contract_ID
					$arr_data6['ID_CONTRATO'] = $contract_ID;

					// Check if contract folder exist, if not create it!
					if ( ! file_exists($contract_root) )
					{
						mkdir($contract_root, 0777, true);
					}

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
									$arr_data6['ANEXO'] = $contract_path . "/" . $_FILES['file_anexo']['name'][$key];
									$query6 = $this->db->insert( 'operadora.contratoanexo', $arr_data6 );
								}
								$count++; // Number of successfully uploaded file
							}
						}
					}
				}

				// Return a message
				?><script>alert("Contrato inserido com sucesso!");
				window.location.href = "<?php echo HOME_URI;?>/modulo_operadora/gerenciar_contratooperadora";</script> <?php
				return $contract_ID;
			}

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
	 
		} // insert_contrato_operadora

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
		 * Get equipment negotiation type 
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_equip_negotiation_list()
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_EQUIP_NEGOCIACAO`, `DESCRICAO` FROM `operadora.tipoequipamentonegociacao` WHERE 1 ORDER BY `ID_TIPO_EQUIP_NEGOCIACAO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_equip_negotiation_list

		/**
		 * Get module type list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_module_type_list()
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_MODULO`, `DESCRICAO` FROM `operadora.tipomodulo` WHERE 1 ORDER BY `ID_TIPO_MODULO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_module_type_list

		/**
		 * Get plan type list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_plan_type_list()
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_PLANO`, `DESCRICAO` FROM `operadora.tipoplano` WHERE 1 ORDER BY `ID_TIPO_PLANO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_plan_type_list

		/**
		 * Get contract type
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_contract_type() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_CONTRATO`, `DESCRITIVO` FROM `operadora.tipocontrato`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_contract_type

		/**
		 * Get service type
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_service_type() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_CONTRATO_TIPO_SERVICO`, `DESCRITIVO` FROM `operadora.contratotiposervico`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_service_type
	}
?>