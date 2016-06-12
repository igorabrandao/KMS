<?php

	/**
	 * Modulo_Usuario - Controller modulo_usuario
	 *
	 * @package KMSMVC
	 * @since 0.1
	*/
	class ModuloUsuarioController extends MainController
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
		 * Load the page "http://localhost:2380/KMS/admin/modulo_usuario/"
		*/
		public function index( )
		{
			// Page title
			$this->title = 'Gerenciar Usuários';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_usuario/modulo_usuario-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/loading_box.php
			require ABSPATH . '/views/_includes/loading_box.php';

			// /views/_includes/lock_screen.php
			require ABSPATH . '/views/_includes/lock_screen.php';

			// /views/_includes/message_box.php
			require ABSPATH . '/views/_includes/message_box.php';

			// /views/modulo_usuario/_breadcrumb_gerenciar_usuario.php
			require ABSPATH . '/views/modulo_usuario/_breadcrumb_gerenciar_usuario.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/logo_menu.php
			require ABSPATH . '/views/_includes/logo_menu.php';

			// /views/_includes/toolbar.php
			require ABSPATH . '/views/_includes/toolbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/modulo_usuario/gerenciar_usuario.php
			require ABSPATH . '/views/modulo_usuario/gerenciar_usuario-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';
		} // index

		/** Functions section
		 * Load the page "http://localhost:2380/KMS/admin/modulo_usuario/cadastrar_usuario"
		*/
		public function cadastrarusuario( )
		{
			// Page title
			$this->title = 'Cadastrar Usuário';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_usuario/modulo_usuario-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/loading_box.php
			require ABSPATH . '/views/_includes/loading_box.php';

			// /views/_includes/lock_screen.php
			require ABSPATH . '/views/_includes/lock_screen.php';

			// /views/_includes/message_box.php
			require ABSPATH . '/views/_includes/message_box.php';

			// /views/home/_breadcrumb_cadastrar_usuario.php
			require ABSPATH . '/views/modulo_usuario/_breadcrumb_cadastrar_usuario.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/logo_menu.php
			require ABSPATH . '/views/_includes/logo_menu.php';

			// /views/_includes/toolbar.php
			require ABSPATH . '/views/_includes/toolbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/modulo_usuario/cadastrar_usuario-view.php
			require ABSPATH . '/views/modulo_usuario/cadastrar_usuario-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';
		} // index
	}
?>