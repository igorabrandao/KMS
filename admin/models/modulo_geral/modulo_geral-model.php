<?php

	class ModuloGeralModel extends MainModel
	{
		/** 
		 * Attributes
		*/
		private $idPEC;

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
			//$GLOBALS['ACTIVE_TAB'] = "PEC";
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
				$query = $this->db->query('SELECT `ID_PEC` FROM `pec.pec` WHERE `ID_PEC` = ' . $this->getIdPEC());

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
	}

?>