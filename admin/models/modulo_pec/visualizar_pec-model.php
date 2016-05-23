<?php

	class VisualizarPecModel extends MainModel
	{
		/** 
		 * Attributes
		*/
		private $idPEC;
		private $nConta;
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

		// INVOICE NUMBER
		public function setNConta( $nConta_ )
		{
			$this->nConta = $nConta_;
		}
		public function getNConta()
		{
			return $this->nConta;
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
					$pec_query = $query->fetch();
					$this->setNConta($pec_query["N_CONTA"]);
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
				return $query->fetchAll();
			else
				return 0;
		} // getInfo_PEC

		/**
		 * Function to add dynamically the mission information to the report
		 * this function will help to solve bottle neck problems
		 *
		 * @since 0.1
		 * @access public
		 *
		 * @id_PEC_ => ID PEC
		 * @id_PEC_service_ => ID service
		 * @qtd_ => phone number count
		 * @value_ => total value
		*/
		public function insert_chargedreport_PEC( $id_PEC_, $id_PEC_service_, $qtd_, $value_ )
		{
			$arr_data = array();
			$arr_data["QUANTIDADE"] = $qtd_;
			$arr_data["VALOR"] = $value_;

			// Check if the parameters are valid
			if ( $id_PEC_ != "" && $id_PEC_service_ != "" && $qtd_ != "" && $value_ != "" )
			{
				$query = $this->db->update( 'pec.servicos', 'ID_PEC_SERVICO', $id_PEC_service_, $arr_data );
			}

		} // insert_chargedreport_PEC

		/**
		 * Get the necessary informations to fill the charged PEC report
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function chargedreport_PEC( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT PEC.`ID_PEC`, SLINHA.`ID_PEC_SERVICO_LINHA`, SLINHA.`ID_SERVICO`, SERVICO.`ID_PEC_SERVICO`, SERVICO.`DESCRICAO`, SERVICO.`N_DIAS`,
					SERVICO.`DURACAO`, SERVICO.`VOLUME`, SERVICO.`ICMS`, SERVICO.`PIS_COFINS`, SERVICO.`VALOR`, SERVICO.`PERIODO` AS PERIODO2,
					( CASE WHEN SERVICO.`QUANTIDADE` IS NULL THEN
						(SELECT COUNT(DISTINCT(`ID_LINHA`)) FROM `pec.servicolinha` WHERE `ID_SERVICO` = SLINHA.`ID_SERVICO`)
					ELSE SERVICO.`QUANTIDADE` END ) AS QTD_LINHA, PEC.`PERIODO`,

					( CASE WHEN SERVICO.`VALOR` IS NULL THEN
						(SELECT (SUM(CAST(REPLACE(SCOBRADO.`VALOR`, ',', '') as DECIMAL(10,2)))/100) FROM `pec.servicocobrado` AS SCOBRADO
					INNER JOIN
						`pec.servicolinha` AS SSLINHA ON SSLINHA.`ID_PEC_SERVICO_LINHA` = SCOBRADO.`ID_PEC_SERVICO_LINHA`
					WHERE SSLINHA.`ID_SERVICO` = SLINHA.`ID_SERVICO`) 
					ELSE SERVICO.`VALOR` END) AS VALOR_TOTAL, SLINHA.`FRANQUIA_REAIS`
				FROM `pec.servicolinha` AS SLINHA
					INNER JOIN
				`pec.pec` AS PEC ON PEC.`ID_PEC` = SLINHA.`ID_PEC`
					INNER JOIN
				`pec.servicos` AS SERVICO ON SERVICO.`ID_PEC_SERVICO` = SLINHA.`ID_SERVICO`
				WHERE
					PEC.`ID_PEC` = " . $id_PEC_ . " AND
					PEC.`DATA_FECHA` IS NULL
				GROUP BY SLINHA.`ID_SERVICO`");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // chargedreport_PEC

		/**
		 * Get the necessary informations to fill the charged PEC report (specific for TIM)
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function chargedreport_tim_PEC( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT PEC.`ID_PEC`, SLINHA.`ID_PEC_SERVICO_LINHA`, SLINHA.`ID_SERVICO`, SERVICO.`DESCRICAO`, SERVICO.`ID_PEC_SERVICO`, SERVICO.`N_DIAS`,
					SERVICO.`DURACAO`, SERVICO.`VOLUME`, SERVICO.`ICMS`, SERVICO.`PIS_COFINS`, SERVICO.`PERIODO` AS PERIODO2,
					(SELECT COUNT(DISTINCT(`ID_LINHA`)) FROM `pec.servicolinha` WHERE `ID_SERVICO` = SLINHA.`ID_SERVICO`) AS QTD_LINHA, PEC.`PERIODO`, SLINHA.`FRANQUIA_REAIS`
				FROM `pec.servicolinha` AS SLINHA
					INNER JOIN
				`pec.pec` AS PEC ON PEC.`ID_PEC` = SLINHA.`ID_PEC`
					INNER JOIN
				`pec.servicos` AS SERVICO ON SERVICO.`ID_PEC_SERVICO` = SLINHA.`ID_SERVICO`
				WHERE
					PEC.`ID_PEC` = " . $id_PEC_ . " AND
					PEC.`DATA_FECHA` IS NULL
				GROUP BY SLINHA.`ID_SERVICO`");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // chargedreport_tim_PEC
		
		/**
		 * Get the service value list (specific for TIM)
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function chargedreport_tim_value_PEC( $id_PEC_, $id_service_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT SCOBRADO.`VALOR`
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
		} // chargedreport_tim_value_PEC

		/**
		 * Get the necessary informations to fill the charged PEC report with/without discounts
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @discount_ => true/false
		*/
		public function chargedreport_discount_PEC( $id_PEC_, $discount_ )
		{
			// Select the necessary data from DB
			$sql = "SELECT PEC.`ID_PEC`, SLINHA.`ID_PEC_SERVICO_LINHA`, SLINHA.`ID_SERVICO`, SERVICO.`DESCRICAO`, SERVICO.`ID_PEC_SERVICO`,
					(SELECT COUNT(DISTINCT(`ID_LINHA`)) FROM `pec.servicolinha` WHERE `ID_SERVICO` = SLINHA.`ID_SERVICO`) AS QTD_LINHA, PEC.`PERIODO`,
					(SELECT (SUM(CAST(REPLACE(SCOBRADO.`VALOR`, ',', '') as DECIMAL(10,2)))/100) FROM `pec.servicocobrado` AS SCOBRADO
					INNER JOIN
						`pec.servicolinha` AS SSLINHA ON SSLINHA.`ID_PEC_SERVICO_LINHA` = SCOBRADO.`ID_PEC_SERVICO_LINHA`
					WHERE SSLINHA.`ID_SERVICO` = SLINHA.`ID_SERVICO`) AS VALOR_TOTAL, SLINHA.`FRANQUIA_REAIS`
				FROM `pec.servicolinha` AS SLINHA
					INNER JOIN
				`pec.pec` AS PEC ON PEC.`ID_PEC` = SLINHA.`ID_PEC`
					INNER JOIN
				`pec.servicos` AS SERVICO ON SERVICO.`ID_PEC_SERVICO` = SLINHA.`ID_SERVICO`
				WHERE
					PEC.`ID_PEC` = " . $id_PEC_;

			if ( $discount_ == true )
				$sql .= " AND SERVICO.`DESCRICAO` LIKE 'DESCONTO%'";
			else
				$sql .= " AND SERVICO.`DESCRICAO` NOT LIKE 'DESCONTO%'";

			$sql .= " AND PEC.`DATA_FECHA` IS NULL GROUP BY SLINHA.`ID_SERVICO`";

			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // chargedreport_without_discount_PEC

		/**
		 * Get the necessary informations to fill the charged PEC report by service
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_service_ => service ID
		*/
		public function chargedbyservicereport_PEC( $id_PEC_, $id_service_ )
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
		} // chargedbyservicereport_PEC

		/**
		 * Get the phone list from PEC
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function get_phone_list( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PEC_LINHA`, `LINHA` FROM `pec.linhas` WHERE `ID_PEC` = ' . $id_PEC_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_phone_list

		/**
		 * Get the service list from PEC
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function get_service_list( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PEC_SERVICO`, `DESCRICAO` FROM `pec.servicos` WHERE `ID_PEC` = ' . $id_PEC_ . ' AND `DATA_FECHA` IS NULL ORDER BY `ID_PEC_SERVICO`');

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_service_list

		/**
		 * Get the list of PECs
		 *
		 * @since 0.1
		 * @access public
		*/
		public function get_pec_list()
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT PEC.`ID_PEC`, PEC.`N_CONTA`, EMPRESA.`RAZAO_SOCIAL`, OPERADORA.`NOME_OPERADORA`, PEC.`MES_REFERENCIA`, PEC.`DATA_VENCIMENTO`, PEC.`PERIODO`, PEC.`ANEXO` FROM `pec.pec` AS PEC
									INNER JOIN `cliente.empresa` AS EMPRESA ON EMPRESA.`ID_CLIENTE` = PEC.`ID_EMPRESA`
									INNER JOIN `operadora.operadora` AS OPERADORA ON OPERADORA.`ID_OPERADORA` = PEC.`ID_OPERADORA`
									WHERE PEC.`DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_pec_list

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
		} // get_pec_list

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
		 * Get the utilization description
		 *
		 * @since 0.1
		 * @access public
		 * @id_utilizacao_ => utilization ID
		*/
		public function get_utiilization_pec( $id_utilizacao_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `DESCRICAO` FROM `pec.dettipoutilizacao` WHERE `ID_PEC_TIPO_UTILIZACAO` = ' . $id_utilizacao_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_utiilization_pec
		
		/**
		 * Get the calling description
		 *
		 * @since 0.1
		 * @access public
		 * @calling_id_ => calling ID
		*/
		public function get_calling_pec( $calling_id_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `DESCRICAO` FROM `pec.dettipoligacao` WHERE `ID_PEC_TIPO_LIGACAO` = ' . $calling_id_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_utiilization_pec
		
		/**
		 * Get the chamada description
		 *
		 * @since 0.1
		 * @access public
		 * @calling_id_ => calling ID
		*/
		public function get_chamada_pec( $calling_id_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `DESCRICAO` FROM `pec.dettipochamada` WHERE `ID_PEC_TIPO_CHAMADA` = ' . $calling_id_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_utiilization_pec

		/**
		 * Get the info type from detail
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @tp_call_ => calling type
		 * @tp_chamada_ => chamada type
		 * @tp_utiliza_ => utilization type
		*/
		public function get_detail_type_pec( $id_PEC_, $tp_call_, $tp_chamada_, $tp_utiliza_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT AVG(DET.`TIPO_INFO_DET`)
				FROM `pec.det` AS DET
				INNER JOIN `pec.linhas` AS LINHAS ON LINHAS.`ID_PEC_LINHA` = DET.`ID_LINHA`
				WHERE
					DET.`ID_PEC` = " . $id_PEC_ . " AND
					DET.`ID_TIPO_LIGACAO` = " . $tp_call_ . " AND
					DET.`ID_TIPO_CHAMADA` = " . $tp_chamada_ . " AND
					DET.`ID_TIPO_UTILIZACAO` = " . $tp_utiliza_ . " AND
					DET.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_detail_type_pec

		/**
		 * Get the necessary informations to fill the utilization PEC report
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function utilizationreport_PEC( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT UTILIZA.`ID_PEC_TIPO_UTILIZACAO`, UTILIZA.`DESCRICAO`
				FROM `pec.det` AS DET
					INNER JOIN
						`pec.dettipoutilizacao` AS UTILIZA ON UTILIZA.`ID_PEC_TIPO_UTILIZACAO` = DET.`ID_TIPO_UTILIZACAO`
				WHERE
					DET.`ID_PEC` = " . $id_PEC_ . " AND
					DET.`DATA_FECHA` IS NULL
				GROUP BY UTILIZA.`ID_PEC_TIPO_UTILIZACAO`");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // utilizationreport_PEC

		/**
		 * Get the necessary informations to fill the utilization PEC report
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_utilizacao_ => ID UTILIZACAO
		*/
		public function detailedutilizationreport_PEC( $id_PEC_, $id_utilizacao_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT DET.`ID_PEC`, DET.`ID_TIPO_DET`, DET.`ID_TIPO_UTILIZACAO`, TP_LIGACAO.`ID_PEC_TIPO_LIGACAO`, 
					TP_CHAMADA.`ID_PEC_TIPO_CHAMADA`, TP_LIGACAO.`DESCRICAO` AS DESC_LIGACAO, TP_CHAMADA.`DESCRICAO` AS DESC_CHAMADA
				FROM `pec.det` AS DET 
					INNER JOIN
						`pec.dettipoligacao` AS TP_LIGACAO ON TP_LIGACAO.`ID_PEC_TIPO_LIGACAO` = DET.`ID_TIPO_LIGACAO`
					INNER JOIN 
						`pec.dettipochamada` AS TP_CHAMADA ON TP_CHAMADA.`ID_PEC_TIPO_CHAMADA` = DET.`ID_TIPO_CHAMADA`
				WHERE
					DET.`ID_PEC` = " . $id_PEC_ . " AND
					DET.`ID_TIPO_UTILIZACAO` = " . $id_utilizacao_ . " AND
					DET.`DATA_FECHA` IS NULL 
				GROUP BY TP_LIGACAO.`ID_PEC_TIPO_LIGACAO`, TP_CHAMADA.`ID_PEC_TIPO_CHAMADA`");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // detailedutilizationreport_PEC

		/**
		 * Get the necessary informations to fill the utilization PEC report (grouped)
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_utilizacao_ => ID UTILIZACAO
		*/
		public function detailedutilizationreportgrouped_PEC( $id_PEC_, $id_utilizacao_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT DET.`ID_PEC`, DET.`ID_TIPO_DET`, DET.`ID_TIPO_UTILIZACAO`, TP_LIGACAO.`ID_PEC_TIPO_LIGACAO`,		 TP_LIGACAO.`DESCRICAO` AS DESC_LIGACAO 
				FROM `pec.det` AS DET 
					INNER JOIN 
						`pec.dettipoligacao` AS TP_LIGACAO ON TP_LIGACAO.`ID_PEC_TIPO_LIGACAO` = DET.`ID_TIPO_LIGACAO` 
				WHERE
					DET.`ID_PEC` = " . $id_PEC_ . " AND
					DET.`ID_TIPO_UTILIZACAO` = " . $id_utilizacao_ . " AND
					DET.`DATA_FECHA` IS NULL 
				GROUP BY TP_LIGACAO.`ID_PEC_TIPO_LIGACAO`");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // detailedutilizationreportgrouped_PEC

		/**
		 * Get the necessary informations to fill the utilization PEC report
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @tp_call_ => calling type
		 * @tp_chamada_ => chamada type
		 * @tp_utiliza_ => utilization type
		*/
		public function detailedreportbyregister_PEC( $id_PEC_, $tp_call_, $tp_chamada_, $tp_utiliza_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT DET.`ID_PEC_DET`, DET.`ID_PEC`, DET.`ID_TIPO_DET`, DET.`ID_LINHA`, LINHAS.`LINHA`, LINHAS.`ID_RADIO`, DET.`ID_TIPO_UTILIZACAO`, 
				DET.`ID_TIPO_LIGACAO`, DET.`ID_TIPO_CHAMADA`, DET.`DESCRITIVO`, DET.`INCLUSO`, DET.`UTILIZADO`, DET.`EXCEDENTE`, DET.`DATA`, DET.`CSP`, 
				DET.`HORA`, DET.`ORIGEM`, DET.`DESTINO`, DET.`ORIGEM_DESTINO`, DET.`PAIS_OPERADORA`, DET.`SERVICO`, DET.`N_CHAMADO`, DET.`TARIFA`, 
				DET.`DURACAO`, DET.`TIPO`, DET.`QUANTIDADE`, DET.`VALOR`, DET.`VALOR_COBRADO`, DET.`TIPO_INFO_DET`, DET.`INTERCONEXAO`
				FROM `pec.det` AS DET
					INNER JOIN 
						`pec.linhas` AS LINHAS ON LINHAS.`ID_PEC_LINHA` = DET.`ID_LINHA`
				WHERE
					DET.`ID_PEC` = " . $id_PEC_ . " AND
					DET.`ID_TIPO_LIGACAO` = " . $tp_call_ . " AND
					DET.`ID_TIPO_CHAMADA` = " . $tp_chamada_ . " AND
					DET.`ID_TIPO_UTILIZACAO` = " . $tp_utiliza_ . " AND
					DET.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // detailedreportbyregister_PEC

		/**
		 * Get the SMS count
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @tp_call_ => calling type
		 * @tp_chamada_ => chamada type
		 * @tp_utiliza_ => utilization type
		*/
		public function get_sms_count( $id_PEC_, $tp_call_, $tp_chamada_, $tp_utiliza_ )
		{
			// Create the sql query
			$sql = "SELECT SUM(`QUANTIDADE`) AS QTD FROM `pec.det` 
				WHERE 
					`ID_PEC` = " . $id_PEC_ . " AND
					`ID_TIPO_LIGACAO` = " . $tp_call_ . " AND
					`ID_TIPO_UTILIZACAO` = " . $tp_utiliza_ . " AND ";

			// Check if the chamada's type was informed
			if ( isset($tp_chamada_) && $tp_chamada_ != "" )
			{
				$sql .= "`ID_TIPO_CHAMADA` = " . $tp_chamada_ . " AND ";
			}

			$sql .= "`DATA_FECHA` IS NULL";

			// Execute the query
			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchColumn(0);
			else
				return 0;
		} // get_sms_count

		/**
		 * Get the duration list
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @tp_call_ => calling type
		 * @tp_chamada_ => chamada type
		 * @tp_utiliza_ => utilization type
		*/
		public function get_duration_list( $id_PEC_, $tp_call_, $tp_chamada_, $tp_utiliza_ )
		{
			// Create the sql query
			$sql = "SELECT `DURACAO`, `UTILIZADO` FROM `pec.det` 
				WHERE 
				`ID_PEC` = " . $id_PEC_ . " AND 
				`ID_TIPO_UTILIZACAO` = " . $tp_utiliza_ . " AND 
				`ID_TIPO_LIGACAO` = " . $tp_call_ . " AND ";

			// Check if the chamada's type was informed
			if ( isset($tp_chamada_) && $tp_chamada_ != "" )
			{
				$sql .= "`ID_TIPO_CHAMADA` = " . $tp_chamada_ . " AND ";
			}
			else
			{
				$sql .= "`DURACAO` != '' AND ";
			}

			$sql .= " `DATA_FECHA` IS NULL";

			//echo $sql . "</br></br>";

			// Execute the query
			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_duration_list
		
		/**
		 * Get the value list
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @tp_call_ => calling type
		 * @tp_chamada_ => chamada type
		 * @tp_utiliza_ => utilization type
		*/
		public function get_value_list( $id_PEC_, $tp_call_, $tp_chamada_, $tp_utiliza_ )
		{
			// Create the sql query
			$sql = "SELECT `VALOR`, `VALOR_COBRADO`, `INTERCONEXAO` FROM `pec.det` 
				WHERE 
				`ID_PEC` = " . $id_PEC_ . " AND 
				`ID_TIPO_UTILIZACAO` = " . $tp_utiliza_ . " AND 
				`ID_TIPO_LIGACAO` = " . $tp_call_ . " AND ";

			// Check if the chamada's type was informed
			if ( isset($tp_chamada_) && $tp_chamada_ != "" )
			{
				$sql .= "`ID_TIPO_CHAMADA` = " . $tp_chamada_ . " AND ";
			}

			$sql .= "`DATA_FECHA` IS NULL";

			// Select the necessary data from DB
			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_value_list

		/**
		 * Get the traffic list in gb, mb, kb, etc... from a service
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @tp_chamada_ => chamada type
		 * @tp_det_ => detail type
		 * @tp_utiliza_ => utilization type
		*/
		public function get_traffic_list( $id_PEC_, $tp_chamada_, $tp_det_, $tp_utiliza_ )
		{
			// Create the sql query
			$sql = "SELECT `QUANTIDADE`, `UTILIZADO` FROM `pec.det` 
				WHERE 
					`ID_PEC` = " . $id_PEC_ . " AND 
					`ID_TIPO_UTILIZACAO` = " . $tp_utiliza_ . " AND 
					`ID_TIPO_DET` = " . $tp_det_ . " AND ";

			// Check if the chamada's type was informed
			if ( isset($tp_chamada_) && $tp_chamada_ != "" )
			{
				$sql .= "`ID_TIPO_CHAMADA` = " . $tp_chamada_ . " AND ";
			}

			$sql .= "`DATA_FECHA` IS NULL";

			// Select the necessary data from DB
			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_traffic_list

		/**
		 * Get the traffic list in gb, mb, kb, etc... from a service
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_PEC_det_ => ID PEC register
		*/
		public function get_traffic_list2( $id_PEC_, $id_PEC_det_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT `QUANTIDADE` FROM `pec.det` WHERE `ID_PEC` = " . $id_PEC_ . " AND 
				`ID_PEC_DET` = " . $id_PEC_det_ . " AND `DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_traffic_list

		/**
		 * Get the list values from a detail item to be added
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @tp_utiliza_ => utilization type
		 * @tp_call_ => calling type
		 * @tp_chamada_ => chamada type
		*/
		public function get_detail_value_list( $id_PEC_, $tp_utiliza_, $tp_call_, $tp_chamada_ )
		{
			// Check wich parameter was filled
			if ( $id_PEC_ != "" && $tp_utiliza_ != "" ) // Values by utilization type
			{
				// Select the necessary data from DB
				$query = $this->db->query("SELECT `VALOR`, `VALOR_COBRADO`, `INTERCONEXAO`
					FROM `pec.det` 
					WHERE `ID_PEC` = " . $id_PEC_ . " AND 
					`ID_TIPO_UTILIZACAO` = " . $tp_utiliza_ . " AND 
					`DATA_FECHA` IS NULL");
			}
			else if ( $id_PEC_ != "" && $tp_utiliza_ != "" && $tp_call_ != "" && $tp_chamada_ != "" ) // Values by utilization, calling and chamada typing
			{
				// Select the necessary data from DB
				$query = $this->db->query("SELECT `VALOR` 
					FROM `pec.det` 
					WHERE
						`ID_PEC` = " . $id_PEC_ . " AND 
						`ID_TIPO_UTILIZACAO` = " . $tp_utiliza_ . " AND 
						`ID_TIPO_LIGACAO` = " . $tp_call_ . " AND 
						`ID_TIPO_CHAMADA` = " . $tp_chamada_ . " AND 
						`DATA_FECHA` IS NULL");
			}
			else
			{
				// Null value
				$query = 0;
			}

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_detail_value_list

		/**
		 * Get the necessary informations to fill the other entries PEC report
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function otherentriesreport_PEC( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT `ID_PEC_OUTRO_LANCAMENTO`, `ID_PEC`, `DESCRICAO` 
				FROM `pec.outroslancamentos` 
				WHERE
					`ID_PEC` = " . $id_PEC_ . " AND
					`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // otherentriesreport_PEC

		/**
		 * Get the necessary informations to fill the other entries PEC report
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @$id_lancamento_ => ID OUTROS LANÇAMENTOS
		 * @$accept_null_phone_ => Define if the function will acept values from null phones
		*/
		public function get_otherentries_value_list( $id_PEC_, $id_lancamento_, $accept_null_phone_ )
		{
			// Query creation
			$sql = "SELECT `VALOR` FROM `pec.outroslancamentosdet` WHERE
					`ID_PEC` = " . $id_PEC_ . " AND
					`ID_LANCAMENTO` = " . $id_lancamento_ . " AND ";

			// Accept values from null phones
			if ( $accept_null_phone_ == false )
				$sql .= "`ID_LINHA` != 0 AND ";

			$sql .= "`DATA_FECHA` IS NULL";

			// Select the necessary data from DB
			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_otherentries_value_list

		/**
		 * Get the description from current entries
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @$id_lancamento_ => ID OUTROS LANÇAMENTOS
		*/
		public function get_lancamento_description( $id_PEC_, $id_lancamento_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `DESCRICAO` FROM `pec.outroslancamentos` WHERE `ID_PEC` = ' . $id_PEC_ . ' AND 
				`ID_PEC_OUTRO_LANCAMENTO` = ' . $id_lancamento_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_lancamento_description

		/**
		 * Get the entries detailment
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @$id_lancamento_ => ID OUTROS LANÇAMENTOS
		 * @$accept_null_phone_ => Define if the function will acept values from null phones
		*/
		public function get_otherentries_detail( $id_PEC_, $id_lancamento_, $accept_null_phone_ )
		{
			$sql = "SELECT LDET.`ID_OUTROS_LANCAMENTOS_DET`, LDET.`ID_PEC`, OL.`DESCRICAO` AS DESCRICAO_LANCAMENTO, 
				TPL.`DESCRICAO`, LINHA.`LINHA`, LDET.`DESCRITIVO`, LDET.`PERIODO`, LDET.`TIPO`, LDET.`DATA_PAGAMENTO`, LDET.`DATA_CREDITO`, LDET.`UTILIZADO`,
				LDET.`DADOS`, LDET.`SMS`, LDET.`VALOR`, LDET.`N_SOLICITACAO`, LDET.`IMEI_APARELHO`, LDET.`IMEI_SIM`, LDET.`LOCAL`, LDET.`NOTA_FISCAL`,
				LDET.`PARCELA`, LDET.`VALOR_DESCONTO`, LDET.`VALOR_TOTAL`, LDET.`VALOR_PARCELA`, LDET.`DATA`, LDET.`DURACAO`, LDET.`VOLUME`, LDET.`ICMS`, LDET.`PIS_COFINS`
				FROM `pec.outroslancamentosdet` AS LDET
				INNER JOIN `pec.outroslancamentos` AS OL ON OL.`ID_PEC_OUTRO_LANCAMENTO` = LDET.`ID_LANCAMENTO`
				INNER JOIN `pec.tipolancamento` AS TPL ON TPL.`ID_TIPO_LANCAMENTO` = LDET.`ID_TIPO_LANCAMENTO`
				LEFT JOIN `pec.linhas` AS LINHA ON LINHA.`ID_PEC_LINHA` = LDET.`ID_LINHA`
				WHERE 
					LDET.`ID_PEC` =  " . $id_PEC_ . "  AND 
					LDET.`ID_LANCAMENTO` = " . $id_lancamento_ . " AND ";

			// Accept value form null phone
			if ( $accept_null_phone_ == false )
				$sql .= "LDET.`ID_LINHA` != 0 AND ";

			$sql .= "LDET.`DATA_FECHA` IS NULL ORDER BY LINHA.`LINHA`";

			// Select the necessary data from DB
			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_otherentries_detail

		/**
		 * Get the entries detailment groupped by phone
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @$id_lancamento_ => ID OUTROS LANÇAMENTOS
		 * @$accept_null_phone_ => Define if the function will acept values from null phones
		*/
		public function get_otherentries_detail_groupped( $id_PEC_, $id_lancamento_, $accept_null_phone_ )
		{
			// Create the sql query
			$sql = "SELECT LDET.`ID_OUTROS_LANCAMENTOS_DET`, LDET.`ID_PEC`, LINHA.`LINHA`,
					GROUP_CONCAT(OL.`DESCRICAO` SEPARATOR '///') AS DESCRICAO_LANCAMENTO,
					GROUP_CONCAT(TPL.`DESCRICAO` SEPARATOR '///') AS DESCRICAO,
					GROUP_CONCAT(LDET.`DESCRITIVO` SEPARATOR '///') AS DESCRITIVO,
					GROUP_CONCAT(LDET.`PERIODO` SEPARATOR '///') AS PERIODO,
					GROUP_CONCAT(LDET.`TIPO` SEPARATOR '///') AS TIPO,
					GROUP_CONCAT(LDET.`DATA_PAGAMENTO` SEPARATOR '///') AS DATA_PAGAMENTO,
					GROUP_CONCAT(LDET.`DATA_CREDITO` SEPARATOR '///') AS DATA_CREDITO,
					GROUP_CONCAT(LDET.`UTILIZADO` SEPARATOR '///') AS UTILIZADO,
					GROUP_CONCAT(LDET.`DADOS` SEPARATOR '///') AS DADOS,
					GROUP_CONCAT(LDET.`SMS` SEPARATOR '///') AS SMS,
					GROUP_CONCAT(LDET.`VALOR` SEPARATOR '///') AS VALOR,
					GROUP_CONCAT(LDET.`N_SOLICITACAO` SEPARATOR '///') AS N_SOLICITACAO,
					GROUP_CONCAT(LDET.`IMEI_APARELHO` SEPARATOR '///') AS IMEI_APARELHO,
					GROUP_CONCAT(LDET.`IMEI_SIM` SEPARATOR '///') AS IMEI_SIM,
					GROUP_CONCAT(LDET.`LOCAL` SEPARATOR '///') AS LOCAL,
					GROUP_CONCAT(LDET.`NOTA_FISCAL` SEPARATOR '///') AS NOTA_FISCAL,
					GROUP_CONCAT(LDET.`PARCELA` SEPARATOR '///') AS PARCELA,
					GROUP_CONCAT(LDET.`VALOR_DESCONTO` SEPARATOR '///') AS VALOR_DESCONTO,
					GROUP_CONCAT(LDET.`VALOR_TOTAL` SEPARATOR '///') AS VALOR_TOTAL,
					GROUP_CONCAT(LDET.`VALOR_PARCELA` SEPARATOR '///') AS VALOR_PARCELA,
					GROUP_CONCAT(LDET.`DATA` SEPARATOR '///') AS DATA,
					GROUP_CONCAT(LDET.`DURACAO` SEPARATOR '///') AS DURACAO,
					GROUP_CONCAT(LDET.`VOLUME` SEPARATOR '///') AS VOLUME,
					GROUP_CONCAT(LDET.`ICMS` SEPARATOR '///') AS ICMS,
					GROUP_CONCAT(LDET.`PIS_COFINS` SEPARATOR '///') AS PIS_COFINS
				FROM 
					`pec.outroslancamentosdet` AS LDET 
				INNER JOIN 
					`pec.outroslancamentos` AS OL ON OL.`ID_PEC_OUTRO_LANCAMENTO` = LDET.`ID_LANCAMENTO`
				INNER JOIN 
					`pec.tipolancamento` AS TPL ON TPL.`ID_TIPO_LANCAMENTO` = LDET.`ID_TIPO_LANCAMENTO`
				LEFT JOIN 
					`pec.linhas` AS LINHA ON LINHA.`ID_PEC_LINHA` = LDET.`ID_LINHA`
				WHERE 
					LDET.`ID_PEC` =  " . $id_PEC_ . "  AND 
					LDET.`ID_LANCAMENTO` = " . $id_lancamento_ . " AND ";

			// Accept value form null phone
			if ( $accept_null_phone_ == false )
				$sql .= "LDET.`ID_LINHA` != 0 AND ";

			$sql .= "LDET.`DATA_FECHA` IS NULL GROUP BY LINHA.`LINHA`";

			// Select the necessary data from DB
			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_otherentries_detail_groupped

		/**
		 * Get the description from current entries
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @$id_lancamento_ => ID OUTROS LANÇAMENTOS
		*/
		public function get_lancamento_type( $id_PEC_, $id_lancamento_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_LANCAMENTO` FROM `pec.outroslancamentosdet` WHERE `ID_PEC` = ' . $id_PEC_ . ' AND 
				`ID_LANCAMENTO` = ' . $id_lancamento_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} // get_lancamento_type

		/**
		 * Get the plan phone list
		 *
		 * @since 0.1
		 * @access public
		 * @param phone_ => phone number
		*/
		public function get_phone_plan_list( $phone_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT ASL.`ID_ASSOC`, ASL.`N_CONTA`, ASL.`LINHA`, ASL.`ID_PLANO_CONTRATO`, OPC.`DESCRITIVO_PLANO`
				FROM 
					`operadora.assoclinha` AS ASL 
				INNER JOIN 
					`operadora.planocontrato` as OPC ON OPC.`ID_PLANO_CONTRATO` = ASL.`ID_PLANO_CONTRATO` 
				WHERE 
					ASL.`N_CONTA` = " . $this->getNConta() . " AND 
					ASL.`LINHA` = '" . $phone_ . "' AND 
					ASL.`ID_PLANO_CONTRATO` IS NOT NULL AND
					ASL.`DATA_FECHA` IS NULL AND 
					OPC.`DATA_FECHA` IS NULL 
				GROUP BY 
					ASL.`ID_PLANO_CONTRATO`");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_phone_plan_list

		/**
		 * Get the phone's contracted services from PEC
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function get_phoneservice_list( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT SLINHA.`ID_PEC`, SLINHA.`ID_SERVICO`, LINHA.`LINHA`, SLINHA.`ID_LINHA`, 
				(SUM( CAST( REPLACE( SCOBRADO.`VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) AS VALOR, SLINHA.`MINUTOS`
				FROM 
					`pec.servicolinha` AS SLINHA
				INNER JOIN 
					`pec.servicocobrado` AS SCOBRADO ON SCOBRADO.`ID_PEC_SERVICO_LINHA` = SLINHA.`ID_PEC_SERVICO_LINHA`
				INNER JOIN 
					`pec.linhas` AS LINHA ON LINHA.`ID_PEC_LINHA` = SLINHA.`ID_LINHA`
				WHERE 
					SLINHA.`ID_PEC` = ' . $id_PEC_ . ' AND 
					SLINHA.`DATA_FECHA` IS NULL
				GROUP BY 
					SLINHA.`ID_SERVICO`, SLINHA.`ID_LINHA`
				ORDER BY
					SLINHA.`ID_LINHA` , SLINHA.`ID_SERVICO`');

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_phoneservice_list

		/**
		 * Get the hierarchy between calling type and chamadas
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @tp_call_ => calling type
		 * @id_utilizacao_ => utilization ID
		*/
		public function get_callinghierarchy_list( $id_PEC_, $tp_call_, $id_utilizacao_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT DET.`ID_PEC`, DET.`ID_TIPO_LIGACAO`, DET.`ID_TIPO_CHAMADA`, TP_LIGACAO.`DESCRICAO` AS DESCRICAO_LIGACAO, TP_CHAMADA.`DESCRICAO` AS DESCRICAO_CHAMADA, DET.`ID_TIPO_DET`
				FROM 
					`pec.det` AS DET 
				INNER JOIN 
					`pec.dettipoligacao` AS TP_LIGACAO ON TP_LIGACAO.`ID_PEC_TIPO_LIGACAO` = DET.`ID_TIPO_LIGACAO`
				INNER JOIN 
					`pec.dettipochamada` AS TP_CHAMADA ON TP_CHAMADA.`ID_PEC_TIPO_CHAMADA` = DET.`ID_TIPO_CHAMADA`
				WHERE 
					DET.`ID_PEC` = ' . $id_PEC_ . ' AND 
					DET.`ID_TIPO_UTILIZACAO` = ' . $id_utilizacao_ . ' AND 
					DET.`ID_TIPO_LIGACAO` = ' . $tp_call_ . ' AND 
					DET.`DATA_FECHA` IS NULL
				GROUP BY 
					TP_LIGACAO.`DESCRICAO`, TP_CHAMADA.`DESCRICAO`
				ORDER BY 
					DET.`ID_TIPO_LIGACAO`, DET.`ID_TIPO_CHAMADA`');

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_callinghierarchy_list

		/**
		 * Get the pec detail by phone ordered by calling type
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_phone_ => ID phone number
		 * @id_utilizacao_ => utilization ID
		 * @tp_call_ => calling type
		 * @tp_chamada_ => chamada type
		*/
		public function get_pecdet_byphone_callingordered( $id_PEC_, $id_phone_, $id_utilizacao_, $tp_call_, $tp_chamada_ )
		{
			// Select the necessary data from DB
			$sql = 'SELECT DET.`ID_PEC_DET`, DET.`ID_PEC`, DET.`ID_TIPO_DET`, DET.`ID_LINHA`, DET.`ID_TIPO_UTILIZACAO`, DET.`ID_TIPO_LIGACAO`, DET.`ID_TIPO_CHAMADA`, DET.`DESCRITIVO`, DET.`INCLUSO`, DET.`UTILIZADO`, DET.`EXCEDENTE`, DET.`CSP`, DET.`DATA`, DET.`HORA`, DET.`ORIGEM`, DET.`DESTINO`, DET.`ORIGEM_DESTINO`, DET.`PAIS_OPERADORA`, DET.`SERVICO`, DET.`N_CHAMADO`, DET.`TARIFA`, DET.`DURACAO`, DET.`TARIFADO`, DET.`TIPO`, DET.`QUANTIDADE`, DET.`VALOR`, DET.`VALOR_COBRADO`, DET.`INTERCONEXAO`, DET.`TIPO_INFO_DET`, DET.`DATA_FECHA` 
				FROM 
					`pec.det` AS DET 
				WHERE 
					DET.`ID_PEC` = ' . $id_PEC_ . ' AND 
					DET.`ID_LINHA` = ' . $id_phone_ . ' AND 
					DET.`ID_TIPO_UTILIZACAO` = ' . $id_utilizacao_ . ' AND
					DET.`ID_TIPO_LIGACAO` = ' . $tp_call_ . ' AND ';

			if ( isset($tp_chamada_) && $tp_chamada_ != "" )
			{
				$sql .= 'DET.`ID_TIPO_CHAMADA` = ' . $tp_chamada_ . ' AND ';
			}

			$sql .= 'DET.`DATA_FECHA` IS NULL ORDER BY DET.`ID_TIPO_LIGACAO`, DET.`ID_TIPO_CHAMADA`';

			$query = $this->db->query($sql);

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_pecdet_byphone_callingordered

		/**
		 * Get the summary report by phone from PEC
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function get_summary_report_byphone( $id_PEC_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT LINHA.`LINHA`, (SUM( CAST( REPLACE( SCOBRADO.`VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) AS VALOR_CONTRATADO,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.outroslancamentosdet` 
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND 
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_LINHA` != 0 AND
						`ID_TIPO_LANCAMENTO` = 4 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_DESCONTO,
				(
					SELECT `PERIODO` FROM `pec.outroslancamentosdet` 
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_LANCAMENTO` = 6 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS PARCELA,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.outroslancamentosdet` 
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_LANCAMENTO` = 6 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_PARCELA,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 3 AND 
						`ID_TIPO_DET` = 2 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_ACIMA_VOZ,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 3 AND 
						`ID_TIPO_DET` = 3 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_ACIMA_DADOS,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 3 AND 
						`ID_TIPO_DET` = 4 AND 
						`DATA_FECHA` IS NULL
					GROUP BY  `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_ACIMA_SMS,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 4 AND 
						`ID_TIPO_DET` = 2 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_PERIODO_ANTERIOR_VOZ,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 4 AND 
						`ID_TIPO_DET` = 3 AND 
						`DATA_FECHA` IS NULL
					GROUP BY  `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_PERIODO_ANTERIOR_DADOS,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 4 AND 
						`ID_TIPO_DET` = 4 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_PERIODO_ANTERIOR_SMS,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 5 AND 
						`ID_TIPO_DET` = 2 AND 
						`DATA_FECHA` IS NULL
					GROUP BY  `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_TELEFONICA_DATA_VOZ,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100) FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 5 AND 
						`ID_TIPO_DET` = 3 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_TELEFONICA_DATA_DADOS,
				(
					SELECT (SUM( CAST( REPLACE( `VALOR` ,  ",",  "" ) AS DECIMAL( 10, 2 ) ) ) /100)
					FROM `pec.det`
					WHERE 
						`ID_PEC` = ' . $id_PEC_ . ' AND
						`ID_LINHA` = LINHA.`ID_PEC_LINHA` AND 
						`ID_TIPO_UTILIZACAO` = 5 AND 
						`ID_TIPO_DET` = 4 AND 
						`DATA_FECHA` IS NULL
					GROUP BY `ID_LINHA` ORDER BY `ID_LINHA`
				) AS VALOR_TELEFONICA_DATA_SMS

				FROM 
					`pec.linhas` AS LINHA

				INNER JOIN
					`pec.servicolinha` AS SLINHA ON LINHA.`ID_PEC_LINHA` = SLINHA.`ID_LINHA`

				INNER JOIN
					`pec.servicocobrado` AS SCOBRADO ON SLINHA.`ID_PEC_SERVICO_LINHA` = SCOBRADO.`ID_PEC_SERVICO_LINHA`

				WHERE 
					SLINHA.`ID_PEC` = ' . $id_PEC_ . ' AND
					LINHA.`DATA_FECHA` IS NULL

				GROUP BY 
					SLINHA.`ID_LINHA`

				ORDER BY LINHA.`ID_PEC_LINHA`');

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_summary_report_byphone

		/**
		 * Get the empty phones info from summary report
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		 * @id_PEC_ => ID PEC
		*/
		public function get_summary_report_emptyentries( $id_PEC_, $id_entry_type )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT `PERIODO`, `VALOR` FROM `pec.outroslancamentosdet` 
				WHERE 
					`ID_PEC` = " . $id_PEC_ . " AND 
					`ID_LINHA` = 0 AND 
					`ID_TIPO_LANCAMENTO` = " . $id_entry_type . " AND 
					`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} // get_summary_report_emptyentries
	}
?>