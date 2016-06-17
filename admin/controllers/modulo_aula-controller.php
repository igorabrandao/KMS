<?php

	/**
	 * Modulo_Aula - Controller modulo_aula
	 *
	 * @package KMSMVC
	 * @since 0.1
	*/
	class ModuloAulaController extends MainController
	{
		/** 
		 * Attributes
		*/
		private $user_ID;

		/**
		 * Get's and set's
		*/
		private function setUserID( $user_ID_ )
		{
			$this->user_ID = $user_ID_;
		}

		private function getUserID()
		{
			return $this->user_ID;
		}

		/** Functions section
		 * Load the page "http://localhost:2380/KMS/admin/modulo_aula/"
		*/
		public function index( )
		{
			// Page title
			$this->title = 'Gerenciar Aulas';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_aula/modulo_aula-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/loading_box.php
			require ABSPATH . '/views/_includes/loading_box.php';

			// /views/_includes/lock_screen.php
			require ABSPATH . '/views/_includes/lock_screen.php';

			// /views/_includes/message_box.php
			require ABSPATH . '/views/_includes/message_box.php';

			// /views/modulo_aula/_breadcrumb_gerenciar_aula.php
			require ABSPATH . '/views/modulo_aula/_breadcrumb_gerenciar_aula.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/logo_menu.php
			require ABSPATH . '/views/_includes/logo_menu.php';

			// /views/_includes/toolbar.php
			require ABSPATH . '/views/_includes/toolbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/modulo_aula/gerenciar_aula.php
			require ABSPATH . '/views/modulo_aula/gerenciar_aula-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';

			//***********************************************************
            //** EVENT HANDLER'S
            //***********************************************************

            // Store the action from $_GET ( insert, login, delete, etc )
            if ( isset( $_REQUEST["action"] ) )
            {
                // Auxiliar variables
                $action = $_REQUEST["action"];

                // Check the action
                switch ( $action )
                {
                    // Update select box content
                    case 'delete':
                    {
                        // Call function from model instance
                        $modelo->delete_class( $_REQUEST["class_ID"] );
                        break;
                    }
                }
            }
		} // index

		/** Functions section
		 * Load the page "http://localhost:2380/KMS/admin/modulo_aula/cadastrar_aula"
		*/
		public function cadastraraula( )
		{
			// Page title
			$this->title = 'Cadastrar Aula';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_aula/modulo_aula-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/loading_box.php
			require ABSPATH . '/views/_includes/loading_box.php';

			// /views/_includes/lock_screen.php
			require ABSPATH . '/views/_includes/lock_screen.php';

			// /views/_includes/message_box.php
			require ABSPATH . '/views/_includes/message_box.php';

			// /views/modulo_aula/_breadcrumb_cadastrar_aula.php
			require ABSPATH . '/views/modulo_aula/_breadcrumb_cadastrar_aula.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/logo_menu.php
			require ABSPATH . '/views/_includes/logo_menu.php';

			// /views/_includes/toolbar.php
			require ABSPATH . '/views/_includes/toolbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/modulo_aula/cadastrar_aula-view.php
			require ABSPATH . '/views/modulo_aula/cadastrar_aula-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';
		} // cadastraraula

		/** Functions section
		 * Load the page "http://localhost:2380/KMS/admin/modulo_aula/editar_aula"
		*/
		public function editaraula( )
		{
			// Page title
			$this->title = 'Editar Aula';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_aula/modulo_aula-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/loading_box.php
			require ABSPATH . '/views/_includes/loading_box.php';

			// /views/_includes/lock_screen.php
			require ABSPATH . '/views/_includes/lock_screen.php';

			// /views/_includes/message_box.php
			require ABSPATH . '/views/_includes/message_box.php';

			// /views/modulo_aula/_breadcrumb_editar_aula.php
			require ABSPATH . '/views/modulo_aula/_breadcrumb_editar_aula.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/logo_menu.php
			require ABSPATH . '/views/_includes/logo_menu.php';

			// /views/_includes/toolbar.php
			require ABSPATH . '/views/_includes/toolbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/modulo_aula/editar_aula-view.php
			require ABSPATH . '/views/modulo_aula/editar_aula-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';
		} // editaraula
	}
?>