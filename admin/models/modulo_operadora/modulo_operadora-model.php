<?php

	class ModuloOperadoraModel extends MainModel
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

			// Set the controller
			$this->controller = $controller;

			// Set the main parameters
			$this->parametros = $this->controller->parametros;

			// Set user data
			$this->userdata = $this->controller->userdata;

			// Define the active tab
			$GLOBALS['ACTIVE_TAB'] = "Operadora";
		}

		/**
		 * Get carrier contract list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_carrier_contract_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT OC.`ID_CONTRATO_OPERADORA`, OC.`N_CONTA`, OT.`DESCRITIVO` AS TIPO_CONTRATO, OCTS.`DESCRITIVO` AS TIPO_SERVICO, 
				OO.`NOME_OPERADORA`, OC.`DATA_ASSINATURA`, OC.`DATA_ATIVACAO`, OC.`CARENCIA`, OC.`VALOR_TOTAL_CONTRATO`,
				( 
					SELECT SUM(OCEP.`QTD_CHIPS`) 
					FROM 
						`operadora.contratoequipamentos` AS OCEP 
					WHERE 
						OCEP.`ID_CONTRATO_OPERADORA` = OC.`ID_CONTRATO_OPERADORA` AND
						OCEP.`DATA_FECHA` IS NULL
				) AS QTD_LINHAS
				FROM 
					`operadora.contrato` AS OC
				INNER JOIN 
					`operadora.tipocontrato` AS OT ON OT.`ID_TIPO_CONTRATO` = OC.`ID_TIPO_CONTRATO`
				INNER JOIN 
					`operadora.contratotiposervico` AS OCTS ON OCTS.`ID_CONTRATO_TIPO_SERVICO` = OC.`ID_TIPO_SERVICO`
				INNER JOIN 
					`operadora.operadora` AS OO ON OO.`ID_OPERADORA` = OC.`ID_OPERADORA`
				WHERE 
					OC.`DATA_FECHA` IS NULL');

			// Check if query worked
			if ( !$query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_carrier_contract_list

		/**
		 * Get plataforma LD list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_plataforma_LD() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT LD.`ID_PLATAFORMA_LD`, OPR.`NOME_OPERADORA`, OPC.`DESCRITIVO_PLANO`, BTP.`DESCRITIVO` AS DESC_TIPO_TARIFA, 
				BSTP.`DESCRITIVO` AS DESC_SUBTIPO_TARIFA
				FROM 
					`book.plataformald` AS LD
				INNER JOIN 
					`operadora.operadora` AS OPR ON OPR.`ID_OPERADORA` = LD.`ID_OPERADORA`
				INNER JOIN 
					`operadora.planocontrato` AS OPC ON OPC.`ID_PLANO_CONTRATO` = LD.`ID_DEGRAU_LD`
				INNER JOIN 
					`book.tarifa` AS BT ON BT.`ID_PLATAFORMA_LD` = LD.`ID_PLATAFORMA_LD`
				INNER JOIN 
					`book.tipotarifa` AS BTP ON BTP.`ID_TIPO_TARIFA` = BT.`ID_TIPO_TARIFA`
				INNER JOIN 
					`book.subtipotarifa` AS BSTP ON BSTP.`ID_SUBTIPO_TARIFA` = BT.`ID_SUBTIPO_TARIFA`
				WHERE 
					LD.`DATA_FECHA` IS NULL');

			// Check if query worked
			if ( !$query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_carrier_contract_list

		/**
		 * Get plataforma LD list
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param $platformLD_ID_ => platform LD ID
		*/
		public function get_plataforma_LD_byID( $platformLD_ID_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT LD.`ID_PLATAFORMA_LD`, OPR.`NOME_OPERADORA`, OPC.`DESCRITIVO_PLANO`, BTP.`DESCRITIVO` AS DESC_TIPO_TARIFA, 
				BSTP.`DESCRITIVO` AS DESC_SUBTIPO_TARIFA
				FROM 
					`book.plataformald` AS LD
				INNER JOIN 
					`operadora.operadora` AS OPR ON OPR.`ID_OPERADORA` = LD.`ID_OPERADORA`
				INNER JOIN 
					`operadora.planocontrato` AS OPC ON OPC.`ID_PLANO_CONTRATO` = LD.`ID_DEGRAU_LD`
				INNER JOIN 
					`book.tarifa` AS BT ON BT.`ID_PLATAFORMA_LD` = LD.`ID_PLATAFORMA_LD`
				INNER JOIN 
					`book.tipotarifa` AS BTP ON BTP.`ID_TIPO_TARIFA` = BT.`ID_TIPO_TARIFA`
				INNER JOIN 
					`book.subtipotarifa` AS BSTP ON BSTP.`ID_SUBTIPO_TARIFA` = BT.`ID_SUBTIPO_TARIFA`
				WHERE 
					LD.`ID_PLATAFORMA_LD` = ' . $platformLD_ID_ . ' AND
					LD.`DATA_FECHA` IS NULL');

			// Check if query worked
			if ( !$query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_plataforma_LD_byID

		/**
		 * Delete an specific LD platform
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param $platformLD_ID_ => platform LD ID
		*/
		public function delete_platformLD( $platformLD_ID_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["DATA_FECHA"] = date("d-m-Y H:i:s");

			// Check the item type
			if ( isset($platformLD_ID_) && $platformLD_ID_ != "" && $platformLD_ID_ != 0 )
			{
				// Disable the contract itself
				$query = $this->db->update( 'book.plataformald', 'ID_PLATAFORMA_LD', $platformLD_ID_, $arr_data );
			}

			echo "///";

		} // delete_platformLD
		
		/**
		 * Delete an specific carrier contract
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param $contract_ID_ => contract ID
		*/
		public function delete_contract( $contract_ID_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["DATA_FECHA"] = date("d-m-Y H:i:s");

			// Check the item type
			if ( isset($contract_ID_) && $contract_ID_ != "" && $contract_ID_ != 0 )
			{
				// Disable the contract itself
				$query = $this->db->update( 'operadora.contrato', 'ID_CONTRATO_OPERADORA', $contract_ID_, $arr_data );

				// Disable equipment register
				$query2 = $this->db->update( 'operadora.contratoequipamentos', 'ID_CONTRATO_OPERADORA', $contract_ID_, $arr_data );

				// Disable plan register
				$query3 = $this->db->update( 'operadora.planocontrato', 'ID_CONTRATO_OPERADORA', $contract_ID_, $arr_data );

				// Disable module register
				$query4 = $this->db->update( 'operadora.modulocontrato', 'ID_CONTRATO_OPERADORA', $contract_ID_, $arr_data );

				// Disable DDD register
				$query5 = $this->db->update( 'operadora.contratoqtdlinha', 'ID_CONTRATO_OPERADORA', $contract_ID_, $arr_data );

				// Disable attachment register
				$query6 = $this->db->update( 'operadora.contratoanexo', 'ID_CONTRATO', $contract_ID_, $arr_data );
			}

			echo "///";

		} // delete_item
	}

?>