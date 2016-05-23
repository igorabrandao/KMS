<?php
	class EditarContratoOperadoraModel extends MainModel
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
		 * Load the contract equipment list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function load_contract_equipment( $contract_id_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_CONTRATO_EQUIPAMENTO`, `ID_CONTRATO_OPERADORA`, `ID_TIPO_NEGOCIACAO`, 
				`QTD_APARELHOS`, `QTD_CHIPS`, `N_PARCELAS`, `VALOR_PARCELA_EQUIP` 
				FROM 
					`operadora.contratoequipamentos` 
				WHERE
					`DATA_FECHA` IS NULL AND
					`ID_CONTRATO_OPERADORA` = ' . $contract_id_);

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // load_contract_equipment

		/**
		 * Load the contract plan list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function load_contract_plan( $contract_id_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PLANO_CONTRATO`, `ID_CONTRATO_OPERADORA`, `ID_TIPO_PLANO`, `DESCRITIVO_PLANO`, `QUANTIDADE_PLANO`, 
				`DESCRITIVO_PACOTE_VOZ`, `TARIFA_LOCAL`, `VOLUME_PLANO`, `MINUTOS`, `VALOR_PAC_MIN`, `VALOR_ASSINATURA_PLANO`, `DESCONTO_PLANO` 
				FROM
					`operadora.planocontrato` 
				WHERE
					`DATA_FECHA` IS NULL AND
					`ID_CONTRATO_OPERADORA` = ' . $contract_id_);

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // load_contract_plan
		
		/**
		 * Load the contract module list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function load_contract_module( $contract_id_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_MODULO_CONTRATO`, `ID_CONTRATO_OPERADORA`, `ID_PLANO_CONTRATO`, `ID_TIPO_MODULO`, 
				`IS_COMPARTILHADO`, `DESCRITIVO_MODULO`, `QUANTIDADE_MODULO`, `VOLUME_MODULO`, `VALOR_ASSINATURA_MODULO`, `DESCONTO_MODULO` 
				FROM 
					`operadora.modulocontrato`
				WHERE
					`DATA_FECHA` IS NULL AND
					`ID_CONTRATO_OPERADORA` = ' . $contract_id_);

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // load_contract_plan
		
		/**
		 * Load the contract DDD list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function load_contract_DDD( $contract_id_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_CONTRATO_QTD_LINHA`, `ID_CONTRATO_OPERADORA`, `ID_PLANO_LINHA`, `DDD`, `QTD_LINHA` 
				FROM 
					`operadora.contratoqtdlinha` 
				WHERE
					`DATA_FECHA` IS NULL AND
					`ID_CONTRATO_OPERADORA` = ' . $contract_id_);

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // load_contract_DDD

		/**
		 * Load the attachment list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function load_contract_attachment( $contract_id_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_ANEXO_CONTRATO`, `ID_CONTRATO`, `ANEXO` 
				FROM 
					`operadora.contratoanexo`
				WHERE
					`DATA_FECHA` IS NULL AND
					`ID_CONTRATO` = ' . $contract_id_);

			// Check if query worked
			if ( !$query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // load_contract_attachment

		/**
		 * Edit carrier contract
		 *
		 * @since 0.1
		 * @access public
		*/
		public function edit_contrato_operadora()
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
			 * Check if the contract ID appears in query string
			*/
			if ( isset($_GET['n_contract']) )
			{
				// Get the contract ID
				$contract_ID = decrypted_url($_GET['n_contract'] , "**");

				// Check if the contract ID is valid
				if ( !isset($contract_ID) || $contract_ID == "" || $contract_ID == 0 )
					return;
			}

			// Remove fields to avoid problems with PDO
			unset( $_POST['layout'] );
			unset( $_POST['header'] );
			unset( $_POST['footer'] );

			// Update contract's head in database
			$query = $this->db->update( 'operadora.contrato', 'ID_CONTRATO_OPERADORA', $contract_ID, array_slice($_POST, 0, 9) );

			// Check operation
			if ( $query )
			{
				// ========================================================================================

					/**
					 * UPDATE CONTRACT EQUIPMENT LIST
					*/

					// Split equip. array
					$equip_list = explode("//", $_POST['elem_EQUIPAMENTOS']);
					$equip_list_ID = explode("//", $_POST['elem_EQUIPAMENTOSID']);

					// Update multiple registers in DB
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
							$arr_data3['VALOR_PARCELA_EQUIP'] = $linha_list[4];

							// Check if the register already exist
							if ( isset($equip_list_ID[$i]) && $equip_list_ID[$i] != "" )
							{
								// Update equipment register
								$query3 = $this->db->update( 'operadora.contratoequipamentos', 'ID_CONTRATO_EQUIPAMENTO', $equip_list_ID[$i], $arr_data3 );
							}
							else
							{
								if ( $arr_data3['ID_CONTRATO_OPERADORA'] != "" && $arr_data3['ID_TIPO_NEGOCIACAO'] != "" )
								{
									// Insert equipment register
									$query3 = $this->db->insert( 'operadora.contratoequipamentos', $arr_data3 );
								}
							}
						}
					}

					/**
					 * UPDATE CONTRACT PLAN LIST
					*/

					// Split plan array
					$plan_list = explode("//", $_POST['elem_PLANOS']);
					$plan_list_ID = explode("//", $_POST['elem_PLANOSID']);

					// Update multiple registers in DB
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

							// Check if the register already exist
							if ( isset($plan_list_ID[$i]) && $plan_list_ID[$i] != "" )
							{
								// Update plan register
								$query4 = $this->db->update( 'operadora.planocontrato', 'ID_PLANO_CONTRATO', $plan_list_ID[$i], $arr_data4 );
								$arr_plan[mb_strtoupper($arr_data4['DESCRITIVO_PLANO'], 'UTF-8')] = $plan_list_ID[$i];
							}
							else
							{
								if ( $arr_data4['ID_CONTRATO_OPERADORA'] != "" && $arr_data4['ID_TIPO_PLANO'] != "" )
								{
									// Insert plan register
									$query4 = $this->db->insert( 'operadora.planocontrato', $arr_data4 );
									$arr_plan[mb_strtoupper($arr_data4['DESCRITIVO_PLANO'], 'UTF-8')] = $this->db->last_id;
								}
							}
						}
					}

					// Check if at least one plan was inserted
					if ( sizeof($arr_plan) > 0 )
					{
						/**
						 * UPDATE CONTRACT MODULE LIST
						*/

						// Split equip. array
						$module_list = explode("//", $_POST['elem_MODULOS']);
						$module_list_ID = explode("//", $_POST['elem_MODULOSID']);

						// Update multiple registers in DB
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
								{
									if ( is_numeric($linha_list[0]) )
										$arr_data5['ID_PLANO_CONTRATO'] = $linha_list[0];
									else
										$arr_data5['ID_PLANO_CONTRATO'] = "";
								}

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

								// Check if the register already exist
								if ( isset($module_list_ID[$i]) && $module_list_ID[$i] != "" )
								{
									// Update module register
									$query5 = $this->db->update( 'operadora.modulocontrato', 'ID_MODULO_CONTRATO', $module_list_ID[$i], $arr_data5 );
								}
								else
								{
									if ( $arr_data5['ID_CONTRATO_OPERADORA'] != "" && $arr_data5['ID_PLANO_CONTRATO'] != "" && $arr_data5['ID_TIPO_MODULO'] != "" )
									{
										// Insert module register
										$query5 = $this->db->insert( 'operadora.modulocontrato', $arr_data5 );
									}
								}
							}
						}

						/**
						 * INSERT CONTRACT DDD LIST
						*/

						// Split DDD array
						$DDD_list = explode("//", $_POST['elem_QTDLINHAS']);
						$DDD_list_ID = explode("//", $_POST['elem_QTDLINHASID']);

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
								{
									if ( is_numeric($linha_list[0]) )
										$arr_data2['ID_PLANO_LINHA'] = $linha_list[0];
									else
										$arr_data2['ID_PLANO_LINHA'] = "";
								}

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

								// Check if the register already exist
								if ( isset($DDD_list_ID[$i]) && $DDD_list_ID[$i] != "" )
								{
									// Update DDD register
									$query2 = $this->db->update( 'operadora.contratoqtdlinha', 'ID_CONTRATO_QTD_LINHA', $DDD_list_ID[$i], $arr_data2 );
								}
								else
								{
									if ( $arr_data2['ID_CONTRATO_OPERADORA'] != "" && $arr_data2['ID_PLANO_LINHA'] != "" )
									{
										// Insert DDD register
										$query2 = $this->db->insert( 'operadora.contratoqtdlinha', $arr_data2 );
									}
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
				?><script>alert("Contrato atualizado com sucesso!");
				window.location.href = "<?php echo HOME_URI;?>/modulo_operadora/gerenciar_contratooperadora";</script> <?php
				return $contract_ID;
			}

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';

		} // edit_contrato_operadora

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
		 * Get equipment negotiation type 
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_equip_negotiation_list()
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_EQUIP_NEGOCIACAO`, `DESCRICAO` FROM `operadora.tipoequipamentonegociacao` WHERE `DATA_FECHA` IS NULL ORDER BY `ID_TIPO_EQUIP_NEGOCIACAO`');

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
			$query = $this->db->query('SELECT `ID_TIPO_MODULO`, `DESCRICAO` FROM `operadora.tipomodulo` WHERE `DATA_FECHA` IS NULL ORDER BY `ID_TIPO_MODULO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_module_type_list

		/**
		 * Get equipment negotiation type 
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_plan_type_list()
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_PLANO`, `DESCRICAO` FROM `operadora.tipoplano` WHERE `DATA_FECHA` IS NULL ORDER BY `ID_TIPO_PLANO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_plan_type_list
		
		/**
		 * Get equipment negotiation type 
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_plan_list( $contract_id_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PLANO_CONTRATO`, `DESCRITIVO_PLANO` 
				FROM 
					`operadora.planocontrato`
				WHERE
					`DATA_FECHA` IS NULL AND
					`ID_CONTRATO_OPERADORA` = ' . $contract_id_ .
				' ORDER BY `ID_PLANO_CONTRATO`');

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
			$query = $this->db->query('SELECT `ID_CONTRATO_TIPO_SERVICO`, `DESCRITIVO` FROM `operadora.contratotiposervico` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_service_type

		/**
		 * Delete an specific item
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function delete_item( $item_type_, $item_ID_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["DATA_FECHA"] = date("d-m-Y H:i:s");

			// Check the item type
			if ( $item_type_ == "equipment" )
			{
				// Update the item
				$query = $this->db->update( 'operadora.contratoequipamentos', 'ID_CONTRATO_EQUIPAMENTO', $item_ID_, $arr_data );
			}
			else if ( $item_type_ == "plan" )
			{
				// Update the item
				$query = $this->db->update( 'operadora.planocontrato', 'ID_PLANO_CONTRATO', $item_ID_, $arr_data );
			}
			else if ( $item_type_ == "module" )
			{
				// Update the item
				$query = $this->db->update( 'operadora.modulocontrato', 'ID_MODULO_CONTRATO', $item_ID_, $arr_data );
			}
			else if ( $item_type_ == "ddd" )
			{
				// Update the item
				$query = $this->db->update( 'operadora.contratoqtdlinha', 'ID_CONTRATO_QTD_LINHA', $item_ID_, $arr_data );
			}
			else if ( $item_type_ == "attach" )
			{
				// Update the item
				$query = $this->db->update( 'operadora.contratoanexo', 'ID_ANEXO_CONTRATO', $item_ID_, $arr_data );
			}

			echo "///";

		} // delete_item
	}
?>