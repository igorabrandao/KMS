<?php
	class ContestarPecModel extends MainModel
	{
		/** 
		 * Attributes
		*/
		private $idPEC;
		private $carrier;

		/** 
		 * Get's and set's
		*/

		// ID PEC
		public function setIdPEC( $idPEC_ )
		{
			$this->idPEC = $idPEC_;
		}
		public function getIdPEC()
		{
			return $this->idPEC;
		}

		// Carrier
		public function setCarrier( $carrier_ )
		{
			$this->carrier = $carrier_;
		}
		public function getCarrier()
		{
			return $this->carrier;
		}

		/**
		 * Class constructor
		 *
		 * Set the database, controller, parameter and user data.
		 *
		 * @since 0.1
		 * @access public
		 * @param => object $db PDO Conexion object
		 * @param => object $controller Controller object
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
			$GLOBALS['ACTIVE_TAB'] = "PEC";
		}

		/**
		 * Check if PEC session is valid
		 *
		 * @since 0.1
		 * @access public
		*/
		public function checkValidit_PEC()
		{
			// Check if PEC ID is valid
			if (isset($_GET['idPEC']) && $_GET['idPEC'] != '')
			{
				$this->setIdPEC(decrypted_url($_GET['idPEC'] , "**"));

				// Select the necessary data from DB
				$query = $this->db->query('SELECT `ID_PEC`, `N_CONTA` FROM `pec.pec` WHERE `ID_PEC` = ' . $this->getIdPEC());

				// Check if query worked
				if ( $query )
				{
					//echo "IDx: " . $this->getIdPEC();
					return true;
				}
				else
				{
					?><script>alert("Houve um problema com o identificador da PEC. Por favor, tente novamente.");
					window.location.href = "<?php echo HOME_URI;?>/modulo_pec/upload_pec";</script> <?php
					return false;
				}
			}
			else
			{
				?><script>alert("Houve um problema com o identificador da PEC. Por favor, tente novamente.");
				window.location.href = "<?php echo HOME_URI;?>/modulo_pec/upload_pec";</script> <?php
				return false;
			}
		} // checkValidit_PEC

		/**
		 * Insert equivalence table
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_equivalence_table()
		{
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
			if ( isset($_GET['idPEC']) )
			{
				// Get PEC info
				$pec_info = $this->getInfo_PEC($this->getIdPEC());

				// Get the contract ID
				$contract_ID = $pec_info["N_CONTA"];

				// Check if the contract ID is valid
				if ( !isset($contract_ID) || $contract_ID == "" || $contract_ID == 0 )
					return;
			}

			/**
			 * Check if it's an update
			*/
			if ( isset($_GET["action"]) && $_GET["action"] == "edit" )
			{
				// Delete the registers
				if ( isset($contract_ID) && $contract_ID != "" )
				{
					$query = $this->db->delete( 'contestacao.equivalencia', "N_CONTA", $contract_ID  );
				}
			}

			// Remove fields to avoid problems with PDO
			unset( $_POST['layout'] );
			unset( $_POST['header'] );
			unset( $_POST['footer'] );
			
				// ========================================================================================

					/**
					 * UPDATE CONTRACT EQUIPMENT LIST
					*/

					// Split equip. array
					$assoc_list = explode("//", $_POST['elem_ASSOC']);

					// Update multiple registers in DB
					for ( $i = 0; $i < sizeof($assoc_list); $i++ )
					{
						$arr_data = array();

						// Update current equipment
						$linha_list = explode("@@", $assoc_list[$i]);

						if ( trim($assoc_list[$i]) != "" )
						{
							$arr_data['N_CONTA'] = $contract_ID;

							if ( isset($linha_list[0]) && $linha_list[0] != "" )
								$arr_data['DESC_SERVICO'] = rtrim(ltrim($linha_list[0]));
							else
								$arr_data['DESC_SERVICO'] = NULL;

							if ( isset($linha_list[1]) )
							{
								// Plan
								if ( strpos($linha_list[1], "P") !== false )
								{
									$arr_data['ID_PLANO_CONTRATO'] = v_num($linha_list[1]);
								}
								// Module
								else if ( strpos($linha_list[1], "M") !== false )
								{
									$arr_data['ID_MODULO_CONTRATO'] = v_num($linha_list[1]);
								}
								else
								{
									$arr_data['ID_PLANO_CONTRATO'] = NULL;
									$arr_data['ID_MODULO_CONTRATO'] = NULL;
								}
							}

							// Check if the register is ready to be insert
							if ( $arr_data['N_CONTA'] != "" && $arr_data['DESC_SERVICO'] != "" )
							{
								// Insert equipment register
								$query = $this->db->insert( 'contestacao.equivalencia', $arr_data );
							}
						}
					}

				// ========================================================================================

				// Return a message
				?><script>window.location.href = "<?php echo encrypted_url($this->getIdPEC(), HOME_URI . "/modulo_pec/contestacaocontratado_pec?idPEC=");?>";</script> <?php

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';

		} // insert_equivalence_table

		/**
		 * Check if PEC session is valid
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function getInfo_PEC( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT PEC.`ID_PEC`, PEC.`N_CONTA`, PEC.`CENTRO_CUSTO`, EMPRESA.`RAZAO_SOCIAL`, OPERADORA.`NOME_OPERADORA`, 
									  PEC.`MES_REFERENCIA`, PEC.`DATA_VENCIMENTO`, PEC.`PERIODO`, PEC.`ANEXO` 
									  FROM `pec.pec` AS PEC
									  INNER JOIN `cliente.empresa` AS EMPRESA ON EMPRESA.`ID_CLIENTE` = PEC.`ID_EMPRESA`
									  INNER JOIN `operadora.operadora` AS OPERADORA ON OPERADORA.`ID_OPERADORA` = PEC.`ID_OPERADORA`
									  WHERE PEC.`ID_PEC` = " . $id_PEC_ . " AND PEC.`DATA_FECHA` IS NULL");
			// Check if query worked
			if ( $query )
				return $query->fetch();
			else
				return 0;
		} // getInfo_PEC

		/**
		 * Get the carrier related to PEC
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function get_carrier_pec( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_OPERADORA` FROM `pec.pec` WHERE `ID_PEC` = ' . $id_PEC_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_carrier_pec

		/**
		 * Get the contestation table
		 *
		 * @since 0.1
		 * @access public
		 * @n_conta_ => PEC invoice number
		*/
		public function get_contestation_equivalence( $n_conta_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_EQUIVALENCIA`, `N_CONTA`, `DESC_SERVICO`, `ID_PLANO_CONTRATO`, `ID_MODULO_CONTRATO` 
				FROM 
					`contestacao.equivalencia` 
				WHERE 
					`N_CONTA` = ' . $n_conta_ . ' 
					AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( !$query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_contestation_equivalence

		/**
		 * Get the list of services
		 *
		 * @since 0.1
		 * @access public
		 * @id_service_PEC_ => ID service
		*/
		public function get_service_pec_list( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PEC_SERVICO`, `DESCRICAO` FROM `pec.servicos` WHERE `ID_PEC` = ' . $id_PEC_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_service_pec_list
		
		/**
		 * Load the contract plan list
		 * 
		 * @since 0.1
		 * @access public
		 * @n_conta_ => PEC invoice number
		*/
		public function get_contract_plan( $n_conta_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT OP.`ID_PLANO_CONTRATO`, OP.`DESCRITIVO_PLANO`, CONCAT("_", OP.`DESCRITIVO_PACOTE_VOZ`)
				FROM `operadora.planocontrato` AS OP
				INNER JOIN 
					`operadora.contrato` AS OC ON OC.`ID_CONTRATO_OPERADORA` = OP.`ID_CONTRATO_OPERADORA`
				WHERE 
					OC.`N_CONTA` = ' . $n_conta_ . ' 
					AND OP.`DATA_FECHA` IS NULL
					GROUP BY(OP.`DESCRITIVO_PLANO`)');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_contract_plan

		/**
		 * Load the contract module list
		 * 
		 * @since 0.1
		 * @access public
		 * @n_conta_ => PEC invoice number
		*/
		public function get_contract_module( $n_conta_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT OM.`ID_MODULO_CONTRATO`, OM.`DESCRITIVO_MODULO` 
				FROM 
					`operadora.modulocontrato` AS OM
				INNER JOIN 
					`operadora.contrato` AS OC ON OC.`ID_CONTRATO_OPERADORA` = OM.`ID_CONTRATO_OPERADORA`
				WHERE 
					OC.`N_CONTA` = ' . $n_conta_ . ' 
					AND OM.`DATA_FECHA` IS NULL
					GROUP BY(OM.`DESCRITIVO_MODULO`)');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_contract_module
		
		/**
		 * Load the equivalence table
		 * 
		 * @since 0.1
		 * @access public
		 * @n_conta_ => PEC invoice number
		*/
		public function get_equivalence_table( $n_conta_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_EQUIVALENCIA`, `N_CONTA`, `DESC_SERVICO`, `ID_PLANO_CONTRATO`, `ID_MODULO_CONTRATO` 
				FROM 
					`contestacao.equivalencia` 
				WHERE 
					`N_CONTA` = ' . $n_conta_ . ' 
					AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( !$query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_equivalence_table

		/**
		 * Load the contestation itens
		 * 
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function get_contestation_report( $id_PEC_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT SERVICO.`ID_PEC_SERVICO`, PEC.`N_CONTA`, SERVICO.`DESCRICAO`, SERVICO.`QUANTIDADE`, SERVICO.`IS_CONTESTADO`, PEC.`PERIODO`, 
				SERVICO.`VALOR`,
				EQUIV.`ID_PLANO_CONTRATO`, EQUIV.`ID_MODULO_CONTRATO`, EQUIV.`ID_EQUIVALENCIA`, PCONTRATO.`VALOR_TOTAL_PLANO`, MCONTRATO.`VALOR_TOTAL_MODULO`,
				PCONTRATO.`QUANTIDADE_PLANO`, PCONTRATO.`VALOR_ASSINATURA_PLANO`, PCONTRATO.`VALOR_PAC_MIN`, MCONTRATO.`QUANTIDADE_MODULO`, MCONTRATO.`VALOR_ASSINATURA_MODULO`
				FROM 
					`pec.servicos` AS SERVICO 
				INNER JOIN 
					`pec.pec` AS PEC ON PEC.`ID_PEC` = SERVICO.`ID_PEC` 
				INNER JOIN 
					`operadora.contrato` AS CONTRATO ON CONTRATO.`N_CONTA` = PEC.`N_CONTA`
				LEFT JOIN 
					`contestacao.equivalencia` AS EQUIV ON TRIM(EQUIV.`DESC_SERVICO`) = TRIM(SERVICO.`DESCRICAO`)
				LEFT JOIN 
					`operadora.planocontrato` AS PCONTRATO ON PCONTRATO.`ID_PLANO_CONTRATO` = EQUIV.`ID_PLANO_CONTRATO`
				LEFT JOIN 
					`operadora.modulocontrato` AS MCONTRATO ON MCONTRATO.`ID_MODULO_CONTRATO` = EQUIV.`ID_MODULO_CONTRATO`
				WHERE
					PEC.`ID_PEC` = ' . $id_PEC_ . ' AND
					SERVICO.`DATA_FECHA` IS NULL
				GROUP BY 
					SERVICO.`DESCRICAO`
				ORDER BY 
					EQUIV.`ID_PLANO_CONTRATO`, EQUIV.`ID_MODULO_CONTRATO` ASC');

			/*EQUIV.`ID_PLANO_CONTRATO` IS NULL AND 
			EQUIV.`ID_MODULO_CONTRATO` IS NULL AND*/

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_contestation_report

		/**
		 * Get the equivalence ID from the equivalence table
		 *
		 * @since 0.1
		 * @access public
		 * @service_desc_ => the service description
		*/
		public function get_contestation_equivalence_id( $service_desc_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_EQUIVALENCIA` FROM `contestacao.equivalencia` WHERE `DESC_SERVICO` = "' . $service_desc_ . '" AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_contestation_equivalence_id

		/**
		 * Get the service name
		 *
		 * @since 0.1
		 * @access public
		 * @id_service_PEC_ => ID service
		*/
		public function get_service_pec( $id_service_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `DESCRICAO` FROM `pec.servicos` WHERE `ID_PEC_SERVICO` = ' . $id_service_PEC_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_service_pec

		/**
		 * Get the service name
		 *
		 * @since 0.1
		 * @access public
		 * @id_service_PEC_ => ID service
		*/
		public function get_service_qtd( $id_service_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `QUANTIDADE` FROM `pec.servicos` WHERE `ID_PEC_SERVICO` = ' . $id_service_PEC_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_service_qtd

		/**
		 * Get the service name
		 *
		 * @since 0.1
		 * @access public
		 * @id_service_PEC_ => ID service
		*/
		public function update_contestation_service_status( $id_service_PEC_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["IS_CONTESTADO"] = 1;

			// The contestation item already exist
			if ( isset($id_service_PEC_) && $id_service_PEC_ != "" && $id_service_PEC_ != 0 )
			{
				// Update the contestation item
				$query = $this->db->update( 'pec.servicos', 'ID_PEC_SERVICO', $id_service_PEC_, $arr_data );
			}

		} // update_contestation_service_status

		/**
		 * Get the necessary informations to fill the charged PEC report by service
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_service_ => service ID
		*/
		public function contestationbyservicereport_PEC( $id_PEC_, $id_service_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT SLINHA.`ID_PEC`, SLINHA.`ID_SERVICO`, SLINHA.`ID_LINHA`, SERVICO.`DESCRICAO`, 
					LINHA.`LINHA`, SCOBRADO.`PERIODO`, SCOBRADO.`VALOR`, SLINHA.`MINUTOS`, LINHA.`ID_RADIO`,
					SCOBRADO.`DURACAO`, SCOBRADO.`VOLUME`, SCOBRADO.`ICMS`, SCOBRADO.`PIS_COFINS`, SCOBRADO.`DESCRITIVO`
					FROM `pec.servicolinha` AS SLINHA
						LEFT JOIN `pec.linhas` AS LINHA ON LINHA.`ID_PEC_LINHA` = SLINHA.`ID_LINHA`
						INNER JOIN `pec.servicos` AS SERVICO ON SERVICO.`ID_PEC_SERVICO` = SLINHA.`ID_SERVICO`
						INNER JOIN `pec.servicocobrado` AS SCOBRADO ON SCOBRADO.`ID_PEC_SERVICO_LINHA` = SLINHA.`ID_PEC_SERVICO_LINHA`
					WHERE 
						SLINHA.`ID_PEC` = " . $id_PEC_ . " AND SLINHA.`ID_SERVICO` = " . $id_service_ . " AND SLINHA.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // contestationbyservicereport_PEC

		/**
		 * Get the contract info to confront with the invoice
		 *
		 * @since 0.1
		 * @access public
		 * @id_equiv_ => equivalcence table ID
		*/
		public function get_contract_info( $id_equiv_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT EQUIV.`ID_EQUIVALENCIA`, EQUIV.`N_CONTA`, EQUIV.`DESC_SERVICO`, EQUIV.`ID_PLANO_CONTRATO`, EQUIV.`ID_MODULO_CONTRATO`, 
				PCONTRATO.`VALOR_ASSINATURA_PLANO`, PCONTRATO.`QUANTIDADE_PLANO`, MCONTRATO.`VALOR_ASSINATURA_MODULO`, MCONTRATO.`QUANTIDADE_MODULO`
			FROM 
				`contestacao.equivalencia` AS EQUIV
			LEFT JOIN 
				`operadora.planocontrato` AS PCONTRATO ON PCONTRATO.`ID_PLANO_CONTRATO` = EQUIV.`ID_PLANO_CONTRATO`
			LEFT JOIN 
				`operadora.modulocontrato` AS MCONTRATO ON MCONTRATO.`ID_MODULO_CONTRATO` = EQUIV.`ID_MODULO_CONTRATO`
			WHERE 
				EQUIV.`ID_EQUIVALENCIA` = " . $id_equiv_ . " AND 
				EQUIV.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_contract_info

		/**
		 * Get the phone number association list
		 *
		 * @since 0.1
		 * @access public
		 * @phone_number_ => the phone number itself
		 * @id_plan_ => plan ID
		 * @id_module_ => module ID
		*/
		public function get_phone_assoc_list( $phone_number_, $id_plan_, $id_module_ )
		{
			// Select by plan ID
			if ( $id_plan_ != "" )
			{
				// Select the necessary data from DB
				$query = $this->db->query("SELECT `ID_ASSOC`, `N_CONTA`, `LINHA`, `ID_PLANO_CONTRATO`, `ID_MODULO_CONTRATO` 
					FROM 
						`operadora.assoclinha` 
					WHERE
						`LINHA` = '" . trim($phone_number_) . "' AND 
						`ID_PLANO_CONTRATO` = " . $id_plan_ . " AND 
						`DATA_FECHA` IS NULL");
			}
			// Select by module ID
			else if ( $id_module_ != "" )
			{
				// Select the necessary data from DB
				$query = $this->db->query("SELECT `ID_ASSOC`, `N_CONTA`, `LINHA`, `ID_PLANO_CONTRATO`, `ID_MODULO_CONTRATO` 
					FROM 
						`operadora.assoclinha` 
					WHERE 
						`LINHA` = '" . trim($phone_number_) . "' AND 
						`ID_MODULO_CONTRATO` = " . $id_module_ . " AND 
						`DATA_FECHA` IS NULL");
			}
			// Parameters not filled
			else
			{
				return false;
			}

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_phone_assoc_list
		
		/**
		 * Get the phone number association list
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @phone_number_ => the phone number itself
		 * @id_plan_ => plan ID
		 * @id_module_ => module ID
		*/
		public function get_phone_contestation( $id_PEC_, $id_phone_number_, $id_plan_, $id_module_ )
		{
			// Select by plan ID
			if ( $id_plan_ != "" )
			{
				// Select the necessary data from DB
				$query = $this->db->query("SELECT `ID_LINHA_CONTESTACAO`, `ID_PEC`, `ID_LINHA`, `ID_PLANO_CONTRATO`, `ID_MODULO_CONTRATO`, `IS_CONTESTACAO`, `JUSTIFICATIVA`
					FROM 
						`pec.linhascontestacao` 
					WHERE
						`ID_PEC` = " . $id_PEC_ . " AND 
						`ID_LINHA` = " . $id_phone_number_ . " AND 
						`ID_PLANO_CONTRATO` = " . $id_plan_ . " AND 
						`DATA_FECHA` IS NULL");
			}
			// Select by module ID
			else if ( $id_module_ != "" )
			{
				// Select the necessary data from DB
				$query = $this->db->query("SELECT `ID_LINHA_CONTESTACAO`, `ID_PEC`, `ID_LINHA`, `ID_PLANO_CONTRATO`, `ID_MODULO_CONTRATO`, `IS_CONTESTACAO`, `JUSTIFICATIVA`
					FROM 
						`pec.linhascontestacao` 
					WHERE 
						`ID_PEC` = " . $id_PEC_ . " AND 
						`ID_LINHA` = " . $id_phone_number_ . " AND 
						`ID_MODULO_CONTRATO` = " . $id_module_ . " AND 
						`DATA_FECHA` IS NULL");
			}
			// Parameters not filled
			else
			{
				return false;
			}

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_phone_contestation

		/**
		 * Get the other entries contestation
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_phone_number_ => the phone number itself
		 * @id_other_entry_ => other entry ID
		*/
		public function get_phone_contestation_other_entries( $id_PEC_, $id_phone_number_, $id_other_entry_ )
		{
			// Select by other entry ID
			if ( $id_other_entry_ != "" && $id_phone_number_ != "" )
			{
				// Select the necessary data from DB
				$query = $this->db->query("SELECT `ID_OUTROS_LANCAMENTOS_CONTESTACAO`, `ID_PEC`, `ID_LINHA`, `ID_OUTROS_LANCAMENTOS_DET`, `IS_CONTESTACAO`, `JUSTIFICATIVA`
					FROM 
						`pec.outroslancamentoscontestacao`
					WHERE
						`ID_PEC` = " . $id_PEC_ . " AND 
						`ID_LINHA` = " . $id_phone_number_ . " AND 
						`ID_OUTROS_LANCAMENTOS_DET` = " . $id_other_entry_ . " AND 
						`DATA_FECHA` IS NULL");
			}
			// Parameters not filled
			else
			{
				return false;
			}

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_phone_contestation_other_entries

		/**
		 * Get the phone number association list
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_phone_number_ => the phone number itself
		 * @id_PEC_det_ => pec detail ID
		*/
		public function get_phone_contestation_detailment( $id_PEC_, $id_phone_number_, $id_PEC_det_ )
		{
			// Select by other entry ID
			if ( $id_PEC_det_ != "" && $id_phone_number_ != "" )
			{
				// Select the necessary data from DB
				$query = $this->db->query("SELECT `ID_DETALHAMENTO_CONTESTACAO`, `ID_PEC`, `ID_LINHA`, `ID_PEC_DET`, `IS_CONTESTACAO`, `JUSTIFICATIVA`
					FROM 
						`pec.detcontestacao`
					WHERE
						`ID_PEC` = " . $id_PEC_ . " AND 
						`ID_LINHA` = " . $id_phone_number_ . " AND 
						`ID_PEC_DET` = " . $id_PEC_det_ . " AND 
						`DATA_FECHA` IS NULL");
			}
			// Parameters not filled
			else
			{
				return false;
			}

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_phone_contestation_detailment

		/*!
		 * Get the phone ID from database
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @phone_ => the phone number to be searched
		 * @is_radio => false: phone number / true: nextel radio ID
		*/
		public function getPhoneID( $id_PEC_, $phone_, $is_radio )
		{
			//! Select the necessary data from DB
			if ( $is_radio == false )
			{
				$query = $this->db->query('SELECT `ID_PEC_LINHA` FROM `pec.linhas` WHERE `ID_PEC` = ' . $id_PEC_ . '
									  AND `LINHA` = "' . rtrim(ltrim($phone_)) . '" AND `DATA_FECHA` IS NULL');
			}
			else
			{
				$query = $this->db->query('SELECT `ID_PEC_LINHA` FROM `pec.linhas` WHERE `ID_PEC` = ' . $id_PEC_ . '
									  AND `ID_RADIO` = "' . rtrim(ltrim($phone_)) . '" AND `DATA_FECHA` IS NULL');
			}

			//! Check if query worked
			if ( $query )
				return $query->fetchColumn(0);
			else
				return 0;
		} //! getPhoneID

		/*!
		 * Get the phone ID from database
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function getPeriod( $id_PEC_ )
		{
			//! Select the necessary data from DB
			$query = $this->db->query("SELECT PEC.`PERIODO`
			FROM 
				`pec.pec` AS PEC
			WHERE 
				PEC.`ID_PEC` = " . $id_PEC_ . " AND PEC.`DATA_FECHA` IS NULL");

			//! Check if query worked
			if ( $query )
				return $query->fetchColumn(0);
			else
				return 0;
		} //! getPeriod

		/**
		 * Update/insert the contestation
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param pec_ID_ => pec ID
		 * @param phone_ID_ => phone ID
		 * @param plan_ID_ => plan ID
		 * @param module_ID_ => module ID
		 * @param contest_ID_ => reference to the contestation
		 * @param contest_type_ => contestation type: 0 => VALID / 1 => CONTESTATION
		 * @param contest_justify_ => the justify to the contestation
		*/
		public function updateContestation( $pec_ID_, $phone_ID_, $plan_ID_, $module_ID_, $contest_ID_, $contest_type_, $contest_justify_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["ID_PEC"] = $pec_ID_;
			$arr_data["ID_LINHA"] = $phone_ID_;

			if ( isset($plan_ID_) && $plan_ID_ != 0 )
				$arr_data["ID_PLANO_CONTRATO"] = $plan_ID_;
			else
				$arr_data["ID_PLANO_CONTRATO"] = NULL;

			if ( isset($module_ID_) && $module_ID_ != 0 )
				$arr_data["ID_MODULO_CONTRATO"] = $module_ID_;
			else
				$arr_data["ID_MODULO_CONTRATO"] = NULL;

			$arr_data["IS_CONTESTACAO"] = $contest_type_;
			$arr_data["JUSTIFICATIVA"] = mb_strtoupper($contest_justify_, 'UTF-8');

			// The contestation item already exist
			if ( isset($contest_ID_) && $contest_ID_ != "" && $contest_ID_ != 0 )
			{
				// Update the contestation item
				$query = $this->db->update( 'pec.linhascontestacao', 'ID_LINHA_CONTESTACAO', $contest_ID_, $arr_data );
			}
			// The contestation not exist yet
			else
			{
				// Insert the contestation item
				$query = $this->db->insert( 'pec.linhascontestacao', $arr_data );
			}

			echo "///";
			print_r($arr_data);

		} // updateContestation

		/**
		 * Update/insert the contestation in other entries register
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param pec_ID_ => pec ID
		 * @param phone_ID_ => phone ID
		 * @param other_entry_ID_ => other entry ID
		 * @param contest_ID_ => reference to the contestation
		 * @param contest_type_ => contestation type: 0 => VALID / 1 => CONTESTATION
		 * @param contest_justify_ => the justify to the contestation
		*/
		public function updateContestationOtherEntry( $pec_ID_, $phone_ID_, $other_entry_ID_, $contest_ID_, $contest_type_, $contest_justify_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["ID_PEC"] = $pec_ID_;
			$arr_data["ID_LINHA"] = $phone_ID_;

			if ( isset($other_entry_ID_) && $other_entry_ID_ != 0 )
				$arr_data["ID_OUTROS_LANCAMENTOS_DET"] = $other_entry_ID_;
			else
				return false;

			$arr_data["IS_CONTESTACAO"] = $contest_type_;
			$arr_data["JUSTIFICATIVA"] = mb_strtoupper($contest_justify_, 'UTF-8');

			// The contestation item already exist
			if ( isset($contest_ID_) && $contest_ID_ != "" && $contest_ID_ != 0 )
			{
				// Update the contestation item
				$query = $this->db->update( 'pec.outroslancamentoscontestacao', 'ID_OUTROS_LANCAMENTOS_CONTESTACAO', $contest_ID_, $arr_data );
			}
			// The contestation not exist yet
			else
			{
				// Insert the contestation item
				$query = $this->db->insert( 'pec.outroslancamentoscontestacao', $arr_data );
			}

			echo "///";
			print_r($arr_data);

		} // updateContestationOtherEntry
		
		/**
		 * Get the entries detailment
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_lancamento_ => ID OUTROS LANÇAMENTOS
		*/
		public function get_otherentries_detail( $id_PEC_, $id_lancamento_ )
		{
			// Sql query
			$sql = "SELECT LDET.`ID_OUTROS_LANCAMENTOS_DET`, LDET.`ID_PEC`, OL.`DESCRICAO` AS DESCRICAO_LANCAMENTO, 
				TPL.`DESCRICAO`, LINHA.`LINHA`, LDET.`DESCRITIVO`, LDET.`PERIODO`, LDET.`TIPO`, LDET.`DATA_PAGAMENTO`, LDET.`DATA_CREDITO`, LDET.`UTILIZADO`,
				LDET.`DADOS`, LDET.`SMS`, (SUM(CAST(REPLACE(LDET.`VALOR`, ',', '') as DECIMAL(10,2)))/100) AS VALOR, LDET.`N_SOLICITACAO`, LDET.`IMEI_APARELHO`, LDET.`IMEI_SIM`, LDET.`LOCAL`, LDET.`NOTA_FISCAL`,
				LDET.`PARCELA`, LDET.`VALOR_DESCONTO`, LDET.`VALOR_TOTAL`, LDET.`VALOR_PARCELA`, LDET.`DATA`, LDET.`DURACAO`, LDET.`VOLUME`, LDET.`ICMS`, LDET.`PIS_COFINS`
				FROM `pec.outroslancamentosdet` AS LDET
				INNER JOIN `pec.outroslancamentos` AS OL ON OL.`ID_PEC_OUTRO_LANCAMENTO` = LDET.`ID_LANCAMENTO`
				INNER JOIN `pec.tipolancamento` AS TPL ON TPL.`ID_TIPO_LANCAMENTO` = LDET.`ID_TIPO_LANCAMENTO`
				LEFT JOIN `pec.linhas` AS LINHA ON LINHA.`ID_PEC_LINHA` = LDET.`ID_LINHA`
				WHERE 
					LDET.`ID_PEC` =  " . $id_PEC_ . "  AND 
					LDET.`ID_LANCAMENTO` = " . $id_lancamento_ . " AND 
					LDET.`DATA_FECHA` IS NULL
				GROUP BY 
					LINHA.`LINHA`, LDET.`PERIODO`
				ORDER BY
					LDET.`PERIODO`";

			// Select the necessary data from DB
			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_otherentries_detail

		/**
		 * Get the value from entries detailment by period
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_lancamento_ => ID OUTROS LANÇAMENTOS
		 * @period_ => the period itself
		*/
		public function get_otherentries_detail_period_value_list( $id_PEC_, $id_lancamento_, $period_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT (SUM(CAST(REPLACE(LDET.`VALOR`, ',', '') as DECIMAL(10,2)))/100) AS VALOR
				FROM `pec.outroslancamentosdet` AS LDET
				INNER JOIN `pec.outroslancamentos` AS OL ON OL.`ID_PEC_OUTRO_LANCAMENTO` = LDET.`ID_LANCAMENTO`
				INNER JOIN `pec.tipolancamento` AS TPL ON TPL.`ID_TIPO_LANCAMENTO` = LDET.`ID_TIPO_LANCAMENTO`
				LEFT JOIN `pec.linhas` AS LINHA ON LINHA.`ID_PEC_LINHA` = LDET.`ID_LINHA`
				WHERE 
					LDET.`ID_PEC` =  " . $id_PEC_ . "  AND 
					LDET.`ID_LANCAMENTO` = " . $id_lancamento_ . " AND 
					LDET.`PERIODO` = '" . $period_ . "' AND 
					LDET.`DATA_FECHA` IS NULL
				GROUP BY 
					LINHA.`LINHA`, LDET.`PERIODO`");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_otherentries_detail_period_value_list

		/**
		 * Get the entries detailment
		 *
		 * @since 0.1
		 * @access public
		 * @n_conta_ => PEC invoice number
		*/		
		public function get_contract_list_by_order( $n_conta_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT `ID_CONTRATO_OPERADORA`, `N_CONTA`, `ID_TIPO_CONTRATO`, `ID_EMPRESA`, `ID_TIPO_SERVICO`, `ID_OPERADORA`, 
				`DATA_ASSINATURA`, `DATA_ATIVACAO`, `CARENCIA`, `VALOR_TOTAL_CONTRATO` 
				FROM 
					`operadora.contrato` 
				WHERE 
					`N_CONTA` = " . $n_conta_ . " AND 
					`DATA_FECHA` IS NULL 
				ORDER BY
					SUBSTR( `DATA_ATIVACAO`, 7, 4), 
					SUBSTR( `DATA_ATIVACAO`, 4, 2),
					SUBSTR( `DATA_ATIVACAO`, 1, 2)");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_contract_list_by_order
		
		/**
		 * Get the equipment entries related to a contract ID
		 *
		 * @since 0.1
		 * @access public
		 * @contract_ID_ => contract ID
		*/		
		public function get_contract_equipment_list( $contract_ID_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT `ID_CONTRATO_EQUIPAMENTO`, `ID_CONTRATO_OPERADORA`, `ID_TIPO_NEGOCIACAO`, `QTD_APARELHOS`, `QTD_CHIPS`, 
				`N_PARCELAS`, `VALOR_PARCELA_EQUIP` 
				FROM
					`operadora.contratoequipamentos` 
				WHERE 
					`ID_CONTRATO_OPERADORA` = " . $contract_ID_ . " AND 
					`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_contract_equipment_list

		/**
		 * Get the LD platform related to the register
		 *
		 * @since 0.1
		 * @access public
		 * @carrier_ => carrier ID
		 * @plan_desc_ => plan description
		 * @tax_type_ => tax type: VC1 / VC2 / VC3
		 * @tax_subtype_ => tax subtype: Normal / Reduzida / Super Reduzida / ETC...
		*/
		public function get_platform_LD( $carrier_, $plan_desc_, $tax_type_, $tax_subtype_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT LD.`ID_PLATAFORMA_LD`,  LD.`ID_OPERADORA`, OPC.`DESCRITIVO_PLANO`, BTP.`DESCRITIVO` AS DESC_TIPO_TARIFA, 
			BSTP.`DESCRITIVO` AS DESC_SUBTIPO_TARIFA,
			BT.`TARIFA_AC`, BT.`TARIFA_AP`, BT.`TARIFA_AM`, BT.`TARIFA_BA`, BT.`TARIFA_AL`, BT.`TARIFA_CE`, BT.`TARIFA_DF`, BT.`TARIFA_ES`,
			BT.`TARIFA_GO`, BT.`TARIFA_MA`, BT.`TARIFA_MS`, BT.`TARIFA_MT`, BT.`TARIFA_MG`, BT.`TARIFA_PA`, BT.`TARIFA_PB`, BT.`TARIFA_PR`,
			BT.`TARIFA_PE`, BT.`TARIFA_PI`, BT.`TARIFA_RJ`, BT.`TARIFA_RN`, BT.`TARIFA_RS`, BT.`TARIFA_RO`, BT.`TARIFA_RR`, BT.`TARIFA_SC`,
			BT.`TARIFA_SP`, BT.`TARIFA_SE`, BT.`TARIFA_TO`
			FROM
				`book.plataformald` AS LD
			INNER JOIN 
				`operadora.planocontrato` AS OPC ON OPC.`ID_PLANO_CONTRATO` = LD.`ID_DEGRAU_LD`
			INNER JOIN 
				`book.tarifa` AS BT ON BT.`ID_PLATAFORMA_LD` = LD.`ID_PLATAFORMA_LD`
			INNER JOIN 
				`book.tipotarifa` AS BTP ON BTP.`ID_TIPO_TARIFA` = BT.`ID_TIPO_TARIFA`
			INNER JOIN 
				`book.subtipotarifa` AS BSTP ON BSTP.`ID_SUBTIPO_TARIFA` = BT.`ID_SUBTIPO_TARIFA`
			WHERE
				LD.`ID_OPERADORA` = " . $carrier_ . " AND 
            	OPC.`DESCRITIVO_PLANO` = '" . $plan_desc_ . "' AND 
                BTP.`DESCRITIVO` = '" . $tax_type_ . "' AND
				BSTP.`DESCRITIVO` = '" . $tax_subtype_ . "' AND
				LD.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_platform_LD

		/**
		 * Get the LD platform related to the register
		 *
		 * @since 0.1
		 * @access public
		 * @carrier_ => carrier ID
		*/
		public function get_UF_by_DDD( $ddd_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT `ID_ESTADO`, `UF`, `NOME`, `LISTA_DDD` 
				FROM 
					`info.estados` 
				WHERE 
					`LISTA_DDD` LIKE '%" . $ddd_ . "%' AND 
					`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_UF_by_DDD

		/**
		* Function to calculate the carrier charged value, accordling to the tax and the duration.
		* This function presents 2 methods to calculate the total amount
		* 1) If duration > 1 minute, then first calculate the full minutes value, after do the same with the seconds (proportionally)
		* 2) If duration <= 1 minute, then apply the full minute tax in 30 seconds, and after that calculate the remaining time in groups of 6 seconds
		*
		* @duration_ => duration in minutes and seconds (mm:ss)
		* @tax_ => the tax charged in a full minute
		*/
		function calculate_charged_amount( $time_, $tax_ )
		{
			// Auxiliary variable
			$total = 0;
			$total_amount = 0;

			// Split the values by :
			$time_ = explode(':', $time_);
			$total += $time_[0] * 60;

			if ( isset($time_[1]) )
			{
				// Convert to mm:ss
				$mins = $time_[0];
				$secs = $time_[1];
				$total += $time_[1];
			}
			else
				return 0;

			// Check if the duration is smaller or greater than 1 minute
			if ( $total >= 60 ) // GREATER
			{
				// 1st method

				// Calculates the full minutes
				$total_amount01 = currency_operation( $mins, $tax_, "*" );

				// Calculates the seconds
				$total_amount02 = currency_operation( ($secs/60), $tax_, "*" )/10;

				// Calculates the final amount
				$total_amount = real_sum($total_amount01, $total_amount02);

				// Return the result
				return real_currency($total_amount);
			}
			else // SMALLER
			{
				// 2nd method

				// Check if the duration has at least 30 seconds
				if ( $total > 30 )
				{
					// Remove the first 30 seconds
					$remaining_time = $total - 30;
					$n_groups = floor($remaining_time/6);
					$tax_ = str_replace(",", ".", $tax_);

					// Calculates the final amount
					$total_amount = real_sum($tax_, ($n_groups * ($tax_/10)));

					// Return the result
					return real_currency($total_amount);
				}
				else
				{
					// Return the tax itself
					return $tax_;
				}

				return 0;
			}

		} // calculate_charged_amount

		/**
		 * Update/insert the contestation in detail
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param pec_ID_ => pec ID
		 * @param phone_ID_ => phone ID
		 * @param $id_pec_det_ => other entry ID
		 * @param contest_ID_ => reference to the contestation
		 * @param contest_type_ => contestation type: 0 => VALID / 1 => CONTESTATION
		 * @param contest_justify_ => the justify to the contestation
		*/
		public function updateContestationDetail( $pec_ID_, $phone_ID_, $id_pec_det_, $contest_ID_, $contest_type_, $contest_justify_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["ID_PEC"] = $pec_ID_;
			$arr_data["ID_LINHA"] = $phone_ID_;

			if ( isset($id_pec_det_) && $id_pec_det_ != 0 )
				$arr_data["ID_PEC_DET"] = $id_pec_det_;
			else
				return false;

			$arr_data["IS_CONTESTACAO"] = $contest_type_;
			$arr_data["JUSTIFICATIVA"] = mb_strtoupper($contest_justify_, 'UTF-8');


			echo "///";
			
			// The contestation item already exist
			if ( isset($contest_ID_) && $contest_ID_ != "" && $contest_ID_ != 0 )
			{echo "</br>atualiza: " . $contest_ID_ . "</br>";
				// Update the contestation item
				$query = $this->db->update( 'pec.detcontestacao', 'ID_DETALHAMENTO_CONTESTACAO', $contest_ID_, $arr_data );
			}
			// The contestation not exist yet
			else
			{echo "</br>cadastra</br>";
				// Insert the contestation item
				$query = $this->db->insert( 'pec.detcontestacao', $arr_data );
			}
			print_r($arr_data);

		} // updateContestationDetail
	}
?>