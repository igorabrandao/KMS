<?php
	class CadastrarBookModel extends MainModel
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
		public function insert_book()
		{
			/**
			 * Check if information was sent from web form with a field called insere_book.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_book'] ) || $_POST['elem_step'] != 1 )
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

			// Remove insere_book field to avoid problems with PDO
			unset($_POST['insere_book']);

			// Insert data in database
			$query = $this->db->insert( 'book.book', array_slice($_POST, 0, 2) );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Plataforma LD cadastrada com sucesso!</p>';
				return;
			}

			// Error
			$this->form_msg = '';

		} // insert_book

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
		 * Get plataforma LD list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_plataformaLD_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PLATAFORMA_LD`, `DEGRAU_LD` FROM `book.plataformald` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_plataformaLD_list
		
		/**
		 * Get tax subtype list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_book_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_BOOK`, OP.`NOME_OPERADORA`, `PERIODO_VALIDADE` FROM `book.book` B
									   INNER JOIN `operadora.operadora` OP ON OP.`ID_OPERADORA` = B.`ID_OPERADORA`
									   WHERE B.`DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_book_list

		/**
		 * Get module list
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_module_list() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_MODULO_BOOK`, `DESCRITIVO_MODULO`, `CAMPOS` FROM `book.modulobook` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchAll();
		} // get_module_list

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

		/**
		 * Insert planos
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_plano()
		{
			/**
			 * Check if information was sent from web form with a field called insere_plano.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_plano'] ) || $_POST['elem_step'] != 2 )
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

			// Remove insere_plano field to avoid problems with PDO
			unset($_POST['insere_plano']);
			unset($_POST['insere_book']);
			unset($_POST['elem_TARIFA']);
			unset($_POST['elem_TARIFA_EXCEDENTE']);

			// Insert data in database
			$query = $this->db->insert( 'book.planobook', array_slice($_POST, 2, 12) );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Plano cadastrado com sucesso!</p>';
				return;
			}

			// Error
			$this->form_msg = '';

		} // insert_plano

		/**
		 * Insert modules
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_module()
		{
			// Auxiliar variables
			$arr_data = array();

			/**
			 * Check if information was sent from web form with a field called insere_modulo.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insere_modulo'] ) || $_POST['elem_step'] != 3 )
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

			// Remove insere_modulo field to avoid problems with PDO
			unset($_POST['insere_modulo']);
			unset($_POST['insere_plano']);
			unset($_POST['elem_step']);
			unset($_POST['DYNAMIC_FIELDS']);
			unset($_POST['elem_CAMPOS']);
			
			$arr_data = array_slice($_POST, 18);
			$arr_data['ID_BOOK'] = $_POST['ID_BOOK']; 

			// Insert data in database
			$query = $this->db->insert( 'book.auxbookmodulo', $arr_data );

			// Check the query
			if ( $query )
			{
				// Return a message
				$this->form_msg = '<p class="success">Book cadastrado com sucesso!</p>';
				?><script>alert("Book cadastrado com sucesso!"); window.location.href = "<?php echo HOME_URI ?>";</script> <?php
				return;
			}

			// Error
			$this->form_msg = '<p class="error">Erro ao enviar dados!</p>';

		} // insert_module
	}
?>