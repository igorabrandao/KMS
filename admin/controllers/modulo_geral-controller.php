<?php
	/**
	 * modulo_geral - Controller modulo_geral
	 *
	 * @package AiresMVC
	 * @since 0.1
	*/
	class ModuloGeralController extends MainController
	{
		/** Functions section
		 * Load the page "http://www.airessolucoes.com.br/modulo_geral/visualizararquivo"
		*/
		public function visualizarfatura( )
		{
			// Page title
			$this->title = 'Visualizador de Faturas';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_geral/modulo_geral-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/_includes/style_selector.php
			require ABSPATH . '/views/_includes/style_selector.php';

			// /views/modulo_geral/_breadcrumb_modulo_geral.php
			require ABSPATH . '/views/modulo_geral/_breadcrumb_visualizador_fatura.php';

			// /views/_includes/search_box.php
			require ABSPATH . '/views/_includes/search_box.php';

			// /views/modulo_geral/visualizar_fatura-view.php
			require ABSPATH . '/views/modulo_geral/visualizador_fatura-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';
		} // index

	} // class HomeController
?>