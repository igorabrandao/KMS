<?php
	class CadastrarModuloBookModel extends MainModel
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
		 * Insert book module
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_modulobook()
		{
			/**
			 * Check if information was sent from web form with a field called insere_modulobook.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_modulobook'] ) )
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

			// Remove insere_modulobook field to avoid problems with PDO
			unset($_POST['insere_modulobook']);
			unset($_POST['chk_field']);

			// Insert data in database
			$query = $this->db->insert( 'book.modulobook', $_POST );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Módulo cadastrado com sucesso!</p>';

				// Redirect
				?><script>alert("Módulo cadastrado com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php

				return;
			}

			// Error
			$this->form_msg = '';

		} // insert_modulobook

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
		 * Get field list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_field_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_MODULO_BOOK_CAMPO`, `DESCRITIVO` FROM `book.modulobookcampos` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_field_list
	}
?>