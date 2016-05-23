<?php
	/**
	 * Home - Index Controller
	 *
	 * @package KMSMVC
	 * @since 0.1
	*/
	class HomeController extends MainController
	{
		/**
		 * Load the page "http://www.karatecidadao.com.br/home-view.php"
		*/
		public function index( )
		{
			// Page title
			$this->title = 'Painel de Controle';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/loading_box.php
			require ABSPATH . '/views/_includes/loading_box.php';

			// /views/_includes/lock_screen.php
			require ABSPATH . '/views/_includes/lock_screen.php';

			// /views/_includes/message_box.php
			require ABSPATH . '/views/_includes/message_box.php';

			// /views/home/_breadcrumb_home.php
			require ABSPATH . '/views/home/_breadcrumb_home.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/logo_menu.php
			require ABSPATH . '/views/_includes/logo_menu.php';

			// /views/_includes/toolbar.php
			require ABSPATH . '/views/_includes/toolbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/home/home-view.php
			require ABSPATH . '/views/home/home-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';
		} // index
	} // class HomeController
?>