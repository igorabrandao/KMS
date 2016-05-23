<?php
class AssociarLinhasModel extends MainModel
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
	 * Delete the phone numbers association
	 * related to a contract number
	 * 
	 * @since 0.1
	 * @access public
	 *
	 * @param $contract_ID_ => contract ID
	*/
	public function delete_assoc( $contract_ID_ )
	{
		// Auxiliar variables
		$arr_data = array();
		$arr_data["DATA_FECHA"] = date("d-m-Y H:i:s");

		// Check the item type
		if ( isset($contract_ID_) && $contract_ID_ != "" && $contract_ID_ != 0 )
		{
			// Disable the phone number associations
			$query = $this->db->update( 'operadora.assoclinha', 'N_CONTA', $contract_ID_, $arr_data );
		}

		echo "///";

	} // delete_assoc
	
	/**
	 * Exclude totally the phone number association
	 * related to a contract number
	 * 
	 * @since 0.1
	 * @access public
	 *
	 * @param $contract_ID_ => contract ID
	*/
	public function remove_assoc( $contract_ID_ )
	{
		// Check the item type
		if ( isset($contract_ID_) && $contract_ID_ != "" && $contract_ID_ != 0 )
		{
			// Disable the phone number associations
			$query = $this->db->delete( 'operadora.assoclinha', 'N_CONTA', $contract_ID_ );
		}

		echo "///";

	} // remove_assoc

	/**
	 * Get carrier contract count list of phones, modules and plans
	 * 
	 * @since 0.1
	 * @access public
	*/
	public function get_contract_list() 
	{
		// Select the necessary data from DB
		$query = $this->db->query('SELECT OPCP.`N_CONTA` FROM `operadora.contrato` AS OPCP WHERE OPCP.`DATA_FECHA` IS NULL GROUP BY OPCP.`N_CONTA`');

		// Check if query worked
		if ( !$query )
			return array();

		// Return data to view
		return $query->fetchAll();

	} // get_contract_list

	/**
	 * Get carrier contract count list of phones, modules and plans
	 * 
	 * @since 0.1
	 * @access public
	 * @param $contract_ID_ => contract ID
	*/
	public function get_contract_list_count( $contract_ID_ ) 
	{
		// Select the necessary data from DB
		$query = $this->db->query('SELECT OPCP.`N_CONTA`, 
			(SELECT COUNT(DISTINCT PECL.`LINHA`) FROM `pec.pec` AS PEC
			INNER JOIN `operadora.contrato` AS OP ON OP.`N_CONTA` = PEC.`N_CONTA`
			INNER JOIN `pec.linhas` AS PECL ON PEC.`ID_PEC` = PECL.`ID_PEC`
			WHERE OP.`N_CONTA` = ' . $contract_ID_ . ' AND OP.`DATA_FECHA` IS NULL) AS QTD_LINHAS, 

			(SELECT COUNT(DISTINCT OPC.`DESCRITIVO_PLANO`) FROM `operadora.contrato` AS OP
			INNER JOIN `operadora.planocontrato` AS OPC ON OP.`ID_CONTRATO_OPERADORA` = OPC.`ID_CONTRATO_OPERADORA`
			WHERE OP.`N_CONTA` = ' . $contract_ID_ . ' AND OP.`DATA_FECHA` IS NULL) AS QTD_PLANO_CONTRATO, 

			(SELECT COUNT(DISTINCT OMC.`DESCRITIVO_MODULO`) FROM `operadora.contrato` AS OP
			INNER JOIN `operadora.modulocontrato` AS OMC ON OMC.`ID_CONTRATO_OPERADORA` = OP.`ID_CONTRATO_OPERADORA`
			WHERE OP.`N_CONTA` = ' . $contract_ID_ . ' AND OP.`DATA_FECHA` IS NULL) AS QTD_MODULO_CONTRATO

			FROM `operadora.contrato` AS OPCP

			WHERE OPCP.`N_CONTA` = ' . $contract_ID_ . ' AND OPCP.`DATA_FECHA` IS NULL

			GROUP BY OPCP.`N_CONTA`');

		// Check if query worked
		if ( !$query )
			return array();

		// Return data to view
		return $query->fetchAll();
	} // get_contract_list_count

	/**
	 * Load the phone numbers related to the contract ID
	 * 
	 * @since 0.1
	 * @access public
	 *
	 * @param $contract_ID_ => contract ID
	*/
	public function load_phone_numbers_assoc( $contract_ID_ ) 
	{
		// Select the necessary data from DB
		$query = $this->db->query('SELECT PEC.`N_CONTA`, PECL.`ID_PEC_LINHA`, PECL.`ID_PEC`, PECL.`LINHA`, PECL.`ID_RADIO` 
		FROM 
			`pec.linhas` AS PECL
		INNER JOIN 
			`pec.pec` AS PEC ON PEC.`ID_PEC` = PECL.`ID_PEC`
		WHERE 
			PEC.`N_CONTA` = ' . $contract_ID_ . ' AND
			PECL.`DATA_FECHA` IS NULL
		GROUP BY
			PECL.`LINHA`');

		// Check if query worked
		if ( !$query )
			return array();

		// Return data to view
		return $query->fetchAll();
	} // load_phone_numbers_assoc

	/**
	 * Load the plans related to the contract ID
	 * 
	 * @since 0.1
	 * @access public
	 *
	 * @param $contract_ID_ => contract ID
	*/
	public function load_plans_assoc( $contract_ID_ ) 
	{
		// Select the necessary data from DB
		$query = $this->db->query('SELECT OC.`N_CONTA`, OPC.`DESCRITIVO_PLANO`, OPC.`ID_PLANO_CONTRATO`, SUM(OPC.`QUANTIDADE_PLANO`) AS QUANTIDADE_PLANO
		FROM 
			`operadora.planocontrato` AS OPC
		INNER JOIN 
			`operadora.contrato` AS OC ON OC.`ID_CONTRATO_OPERADORA` = OPC.`ID_CONTRATO_OPERADORA`
		WHERE 
			OC.`N_CONTA` = ' . $contract_ID_ . ' AND
			OC.`DATA_FECHA` IS NULL AND
			OPC.`DATA_FECHA` IS NULL
		GROUP BY
			OPC.`DESCRITIVO_PLANO`');

		// Check if query worked
		if ( !$query )
			return array();

		// Return data to view
		return $query->fetchAll();
	} // load_plans_assoc

	/**
	 * Load the modules related to the contract ID
	 * 
	 * @since 0.1
	 * @access public
	 *
	 * @param $contract_ID_ => contract ID
	*/
	public function load_modules_assoc( $contract_ID_ ) 
	{
		// Select the necessary data from DB
		$query = $this->db->query('SELECT OC.`N_CONTA`, OMC.`ID_MODULO_CONTRATO`, OMC.`ID_CONTRATO_OPERADORA`, OMC.`DESCRITIVO_MODULO`, SUM(OMC.`QUANTIDADE_MODULO`) AS QUANTIDADE_MODULO
		FROM 
			`operadora.modulocontrato` AS OMC
		INNER JOIN 
			`operadora.contrato` AS OC ON OC.`ID_CONTRATO_OPERADORA` = OMC.`ID_CONTRATO_OPERADORA`
		WHERE 
			OC.`N_CONTA` = ' . $contract_ID_ . ' AND
			OC.`DATA_FECHA` IS NULL AND
			OMC.`DATA_FECHA` IS NULL
		GROUP BY
			OMC.`DESCRITIVO_MODULO`');

		// Check if query worked
		if ( !$query )
			return array();

		// Return data to view
		return $query->fetchAll();
	} // load_plans_assoc

	/**
	 * Get the count of phone numbers associtation
	 * related to a specific contract number
	 *
	 * @since 0.1
	 * @access public
	 * @param $contract_ID_ => contract ID
	*/
	public function count_phone_assocs( $contract_ID_ )
	{
		// Select the necessary data from DB
		$query = $this->db->query('SELECT COUNT(`N_CONTA`) AS QTD_ASSOC 
			FROM `operadora.assoclinha` 
			WHERE `N_CONTA` = ' . $contract_ID_ . ' AND `DATA_FECHA` IS NULL');

		// Check if query worked
		if ( $query )
			return $query->fetchcolumn(0);
		else
			return 0;
	} // count_phone_assocs

	/**
	 * Load the modules related to the contract ID
	 * 
	 * @since 0.1
	 * @access public
	 *
	 * @param $contract_ID_ => contract ID
	*/
	public function load_assocs( $contract_ID_ ) 
	{
		// Select the necessary data from DB
		$query = $this->db->query('SELECT `ID_ASSOC`, `N_CONTA`, `LINHA`, `ID_PLANO_CONTRATO`, `ID_MODULO_CONTRATO`
			FROM 
				`operadora.assoclinha` 
			WHERE 
				`N_CONTA` = ' . $contract_ID_ . ' AND 
				`DATA_FECHA` IS NULL');

		// Check if query worked
		if ( !$query )
			return array();

		// Return data to view
		return $query->fetchAll();
	} // load_plans_assoc

	/**
	 * Insert/Edit phone numbers association
	 *
	 * @since 0.1
	 * @access public
	 *
	 * @param $contract_ID_ => contract ID
	 * @param $data_ => the data itself
	*/
	public function insert_assoc_linha( $contract_ID_, $data_ )
	{
		// Auxiliar variables
		$arr_data = array();
		$assoc_ID = "";

		/**
		 * Check if the contract ID appears in query string
		*/
		if ( isset($contract_ID_) && isset($data_) )
		{
			// Get the contract ID
			$contract_ID = $contract_ID_;
			$data = $data_;

			// Check if the contract ID is valid
			/*if ( isset($_GET['action']) && $_GET['action'] == 'edit' )
			{
				// Disable the phone number associations
				$query = $this->db->delete( 'operadora.assoclinha', 'N_CONTA', $contract_ID );
			}*/
		}
		else
		{
			return false;
		}

			// ========================================================================================

			/**
			 * INSERT/UPDATE PHONE NUMBERS ASSOCIATION
			*/

			// Split associationn array
			$assoc_list = explode("//", $data_);				

			// Update multiple registers in DB
			for ( $i = 0; $i < sizeof($assoc_list); $i++ )
			{
				// Update current equipment
				$linha_list = explode("@@", $assoc_list[$i]);

				if ( trim($assoc_list[$i]) != "" )
				{
					$arr_data['N_CONTA'] = $contract_ID;

					if ( isset($linha_list[0]) &&  $linha_list[0] != "" )
						$arr_data['LINHA'] = $linha_list[0];
					else
						return;

					// PLAN
					if ( strpos($linha_list[1], "P") !== false )
						$arr_data['ID_PLANO_CONTRATO'] = str_replace("P", "", $linha_list[1]);
					else
						$arr_data['ID_PLANO_CONTRATO'] = null;

					// MODULE
					if ( strpos($linha_list[1], "M") !== false )
						$arr_data['ID_MODULO_CONTRATO'] = str_replace("M", "", $linha_list[1]);
					else
						$arr_data['ID_MODULO_CONTRATO'] = null;

					// Insert equipment register
					$query = $this->db->insert( 'operadora.assoclinha', $arr_data );
				}
			}

			echo "///";

		// ========================================================================================

		// Return a message
		/*?><script>alert("Associação registrada com sucesso!");
		window.location.href = "<?php echo HOME_URI;?>/modulo_operadora/gerenciar_assoclinha_contratooperadora";</script> <?php
		return $contract_ID;

		// Error
		$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';*/

	} // insert_assoc_linha
}