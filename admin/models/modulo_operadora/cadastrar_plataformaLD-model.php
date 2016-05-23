<?php
	class CadastrarPlataformaLDModel extends MainModel
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
			$GLOBALS['ACTIVE_TAB'] = "Operadora";
		}

		/**
		 * Insert taxes
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_tax()
		{
			/**
			 * Check if information was sent from web form with a field called insere_plataformaLD.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_plataformaLD'] ) || $this->form_msg  != "" )
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

			// Remove insere_plataformaLD field to avoid problems with PDO
			unset($_POST['insere_plataformaLD']);

			// Insert data in database
			$query = $this->db->insert( 'book.plataformaLD', array_slice($_POST, 0, 2) );

			// Check the query
			if ( $query )
			{
				// Add last inserted ID to $_POST array
				$_POST['ID_PLATAFORMA_LD'] = $this->db->last_id;

				// Return a message
				$this->form_msg = '<p class="success">Plataforma LD cadastrada com sucesso!</p>';
				return;
			} 

			// Error
			$this->form_msg = '';

		} // insert_tax

		/**
		 * Edit taxes
		 *
		 * @since 0.1
		 * @access public
		 *
		 * @param $platformLD_ID_ => platform LD ID
		*/
		public function edit_tax( $platformLD_ID_ )
		{
			/**
			 * Check if information was sent from web form with a field called insere_plataformaLD.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_plataformaLD'] ) || $this->form_msg  != "" )
			{
				return;
			}

			// Remove insere_plataformaLD field to avoid problems with PDO
			unset($_POST['insere_plataformaLD']);

			// Remove fields to avoid problems with PDO
			unset( $_POST['layout'] );
			unset( $_POST['header'] );
			unset( $_POST['footer'] );

			// Update contract's head in database
			if ( isset($platformLD_ID_) && $platformLD_ID_ != "" && $platformLD_ID_ != 0 )
			{
				$query = $this->db->update( 'book.plataformaLD', 'ID_PLATAFORMA_LD', $platformLD_ID_, array_slice($_POST, 0, 2) );
			}

		} // edit_tax

		/**
		 * Insert taxes by state
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_state_tax()
		{
			/**
			 * Check if information was sent from web form with a field called insere_taxes.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_taxes'] ) )
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

			// Remove insere_taxes field to avoid problems with PDO
			unset($_POST['insere_taxes']);
			unset($_POST['insere_plataformaLD']);
			unset($_POST['TARIFA_ESTADO']);
			unset($_POST['FLAGLD']);

			// Insert data in database
			$query = $this->db->insert( 'book.tarifa', array_slice($_POST, 2) );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Plataforma LD cadastrada com sucesso!</p>';
				?><script>alert("Plataforma LD cadastrada com sucesso!"); window.location.href = "<?php echo HOME_URI ?>/modulo_operadora/gerenciar_plataformaLD";</script> <?php
				return;
			}

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';

		} // insert_state_tax

		/**
		 * Edit taxes by state
		 *
		 * @since 0.1
		 * @access public
		 *
		 * @param $platformLD_ID_ => platform LD ID
		*/
		public function edit_state_tax( $platformLD_ID_ )
		{
			/**
			 * Check if information was sent from web form with a field called insere_taxes.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_taxes'] ) )
			{
				return;
			}

			// Remove insere_taxes field to avoid problems with PDO
			unset($_POST['insere_taxes']);
			unset($_POST['insere_plataformaLD']);
			unset($_POST['TARIFA_ESTADO']);
			unset($_POST['FLAGLD']);

			// Update contract's head in database
			if ( isset($platformLD_ID_) && $platformLD_ID_ != "" && $platformLD_ID_ != 0 )
			{
				$query = $this->db->update( 'book.tarifa', 'ID_PLATAFORMA_LD', $platformLD_ID_, array_slice($_POST, 2) );

				// Check the query
				if ( $query )
				{
					// Return a message
					$this->form_msg = '<p class="success">Plataforma LD editada com sucesso!</p>';
					?><script>alert("Plataforma LD editada com sucesso!"); window.location.href = "<?php echo HOME_URI ?>/modulo_operadora/gerenciar_plataformaLD";</script> <?php
					return;
				}
			}

		} // edit_state_tax

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
		 * Get tax list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_tax_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TIPO_TARIFA`, `DESCRITIVO` FROM `book.tipotarifa` WHERE 1 ORDER BY `ID_TIPO_TARIFA`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_tax_list

		/**
		 * Get the plataforma LD list accordling to te carrier
		 *
		 * @param id_carrier_ => Carrier ID
		*/
		public function get_plataformaLD_list_DDL( $id_carrier_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT DISTINCT PC.`ID_PLANO_CONTRATO`, PC.`DESCRITIVO_PLANO` 
				FROM `operadora.planocontrato` AS PC
				INNER JOIN `operadora.contrato` AS OC ON OC.`ID_CONTRATO_OPERADORA` = PC.`ID_CONTRATO_OPERADORA`
				WHERE OC.`ID_OPERADORA` = ' . $id_carrier_ . ' AND OC.`DATA_FECHA` IS NULL
				GROUP BY PC.`DESCRITIVO_PLANO`');

			// Check if query worked
			if ( $query )
			{
				echo "///";
				echo "<option value=''>Selecione...</option>";

				// Print the search result
				foreach ( $query->fetchAll() as $value )
				{
					echo "<option value='" . $value["ID_PLANO_CONTRATO"] . "'>" . $value["DESCRITIVO_PLANO"] . "</option>";
				}
			}
			else
			{
				echo "<option value=''>Nenhum termo na busca dinâmica...</option>";
			}

		} // get_plataformaLD_list_DDL
		
		/**
		 * Get the plataforma LD list accordling to te carrier
		 *
		 * @param id_carrier_ => Carrier ID
		*/
		public function get_plataformaLD_list_DDL_array( $id_carrier_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT DISTINCT PC.`ID_PLANO_CONTRATO`, PC.`DESCRITIVO_PLANO` 
				FROM `operadora.planocontrato` AS PC
				INNER JOIN `operadora.contrato` AS OC ON OC.`ID_CONTRATO_OPERADORA` = PC.`ID_CONTRATO_OPERADORA`
				WHERE OC.`ID_OPERADORA` = ' . $id_carrier_ . ' AND OC.`DATA_FECHA` IS NULL
				GROUP BY PC.`DESCRITIVO_PLANO`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_plataformaLD_list_DDL_array

		/**
		 * Get the state list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_state_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_ESTADO`, `UF`, `NOME` FROM `info.estados` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_state_list
		
		/**
		 * Get tax subtype list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_tax_subtype_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_SUBTIPO_TARIFA`, `DESCRITIVO` FROM `book.subtipotarifa` WHERE 1 ORDER BY `ID_SUBTIPO_TARIFA`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_operadora_list

		/**
		 * Load the informations from a specific LD platform
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param $platformLD_ID_ => platform LD ID
		*/
		public function load_platformLD_info( $platformLD_ID_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PLATAFORMA_LD`, `ID_OPERADORA`, `ID_DEGRAU_LD` 
				FROM 
					`book.plataformald` 
				WHERE 
					`ID_PLATAFORMA_LD` = ' . $platformLD_ID_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( !$query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // load_platformLD_info

		/**
		 * Load the informations from a specific LD platform
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param $platformLD_ID_ => platform LD ID
		*/
		public function load_platformLD_tax_info( $platformLD_ID_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_TARIFA`, `ID_PLATAFORMA_LD`, `ID_TIPO_TARIFA`, `ID_SUBTIPO_TARIFA`, `TARIFA_UNICA`, 
				`TARIFA_EXCEDENTE`, `TARIFA_AC`, `TARIFA_AP`, `TARIFA_AM`, `TARIFA_BA`, `TARIFA_AL`, `TARIFA_CE`, `TARIFA_DF`, 
				`TARIFA_ES`, `TARIFA_GO`, `TARIFA_MA`, `TARIFA_MS`, `TARIFA_MT`, `TARIFA_MG`, `TARIFA_PA`, `TARIFA_PB`, 
				`TARIFA_PR`, `TARIFA_PE`, `TARIFA_PI`, `TARIFA_RJ`, `TARIFA_RN`, `TARIFA_RS`, `TARIFA_RO`, `TARIFA_RR`, `TARIFA_SC`, 
				`TARIFA_SP`, `TARIFA_SE`, `TARIFA_TO` FROM `book.tarifa`
				WHERE 
					`ID_PLATAFORMA_LD` = ' . $platformLD_ID_ . ' AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( !$query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // load_platformLD_tax_info
	}
?>