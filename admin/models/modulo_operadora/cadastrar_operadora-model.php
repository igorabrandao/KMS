<?php
	class CadastrarOperadoraModel extends MainModel
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
			$GLOBALS['ACTIVE_TAB'] = "Operadora";
		}

		/**
		 * Insert operadoras
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_operadora()
		{
			/**
			 * Check if information was sent from web form with a field called insere_operadora.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_operadora'] ) )
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

			// Remove insere_operadora field to avoid problems with PDO
			unset($_POST['insere_operadora']);

			// Insert data in database
			$query = $this->db->insert( 'operadora.operadora', $_POST );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Operadora cadastrada com sucesso!</p>';

				// Redirect
				?><script>alert("Operadora cadastrada com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

				return;
			} 

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
	 
		} // insert_operadora
	}
?>