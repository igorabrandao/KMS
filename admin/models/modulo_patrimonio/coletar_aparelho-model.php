<?php
	class ColetarAparelhoModel extends MainModel
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
		 * Insert cotation
		 *
		 * @since 0.1
		 * @access public
		*/
		public function garbage_device()
		{
			// Auxiliar variables
			$arr_data = array();
			$aux_error = 0;

			/**
			 * Check if information was sent from web form with a field called coleta_aparelho.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['coleta_aparelho'] ) )
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

			// Remove coleta_aparelho field to avoid problems with PDO
			unset($_POST['coleta_aparelho']);

			// Split IMEI array
			$IMEI_list = explode("//", $_POST['IMEI']);
			unset($_POST['IMEI']);

			// Insert multiple registers in DB
			for ( $i = 0; $i < sizeof($IMEI_list); $i++ )
			{
				// Update datetime
				date_default_timezone_set('America/Sao_Paulo');
				$date = date('d/m/Y h:i:s a', time());
				$arr_data["DATA_COLETA"] = $date;

				// Update garbage data
				$query = $this->db->update( 'patrimonio.patrimonio', 'IMEI', $IMEI_list[$i], $arr_data );

				// Check operation once again
				if ( !$query )
					$aux_error += 1;
			}

			// Check operation status
			if ( $aux_error == 0 )
			{
				// Return a message
				$this->form_msg = '<p class="success">Coleta realizada com sucesso!</p>';

				// Redirect
				?><script>alert("Coleta realizada com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php
			}
			else
			{
				// Error
				$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
			}

			return;

		} // garbage_device

		/**
		 * Get device list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_device_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT * FROM `view_patrimonio_aparelho`');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_device_list
	}
?>