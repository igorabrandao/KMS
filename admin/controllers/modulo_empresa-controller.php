<?php
	/**
	 * Modulo_Empresa - Controller modulo_empresa
	 *
	 * @package AiresMVC
	 * @since 0.1
	*/
	class ModuloEmpresaController extends MainController
	{
		/** 
		 * Attributes
		*/
		private $contract_ID;

		/**
		 * Get's and set's
		*/
		private function setContractID( $contract_ID_ )
		{
			$this->contract_ID = $contract_ID_;
		}

		private function getContractID()
		{
			return $this->contract_ID;
		}

		/** Functions section
		 * Load the page "http://www.airessolucoes.com.br/modulo_empresa/"
		*/
		public function index( )
		{
			// Page title
			$this->title = 'Módulo Empresa';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_empresa/modulo_empresa-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/_includes/style_selector.php
			require ABSPATH . '/views/_includes/style_selector.php';

			// /views/modulo_empresa/_breadcrumb_modulo_empresa.php
			require ABSPATH . '/views/modulo_empresa/_breadcrumb_modulo_empresa.php';

			// /views/_includes/search_box.php
			require ABSPATH . '/views/_includes/search_box.php';

			// /views/modulo_empresa/modulo_empresa-view.php
			require ABSPATH . '/views/modulo_empresa/modulo_empresa-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';
		} // index

		/**
		 * Load the page "http://www.airessolucoes.com.br/Detail_Data/modulo_empresa/gerenciar_empresa"
		*/
		public function gerenciarempresa()
		{
			// Page title
			$this->title = 'Gerenciar Empresas';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_empresa/cadastrar_empresa-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/_includes/style_selector.php
			require ABSPATH . '/views/_includes/style_selector.php';

			// /views/modulo_empresa/_breadcrumb_gerenciar_empresa.php
			require ABSPATH . '/views/modulo_empresa/_breadcrumb_gerenciar_empresa.php';

			// /views/_includes/search_box.php
			require ABSPATH . '/views/_includes/search_box.php';

			// /views/modulo_empresa/gerenciar_empresa-view.php
			require ABSPATH . '/views/modulo_empresa/gerenciar_empresa-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';

			// /views/modulo_empresa/_include_gerenciar_empresa.php
			require ABSPATH . '/views/modulo_empresa/_include_gerenciar_empresa.php';
		}
		
		/**
		 * Load the page "http://www.airessolucoes.com.br/Detail_Data/modulo_empresa/cadastrar_empresa"
		*/
		public function cadastrarempresa()
		{
			// Page title
			$this->title = 'Cadastrar Empresa';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_empresa/cadastrar_empresa-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/_includes/style_selector.php
			require ABSPATH . '/views/_includes/style_selector.php';

			// /views/modulo_empresa/_breadcrumb_cadastrar_empresa.php
			require ABSPATH . '/views/modulo_empresa/_breadcrumb_cadastrar_empresa.php';

			// /views/_includes/search_box.php
			require ABSPATH . '/views/_includes/search_box.php';

			// /views/modulo_empresa/cadastrar_empresa-view.php
			require ABSPATH . '/views/modulo_empresa/cadastrar_empresa-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';

			// /views/modulo_empresa/_include_cadastrar_empresa.php
			require ABSPATH . '/views/modulo_empresa/_include_cadastrar_empresa.php';
		}
		
		/**
		 * Load the page "http://www.airessolucoes.com.br/Detail_Data/modulo_empresa/gerenciar_contratoaires"
		*/
		public function gerenciarcontratoaires()
		{
			// Page title
			$this->title = 'Gerenciar Contrato Aires';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_empresa/cadastrar_contratoaires-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/_includes/style_selector.php
			require ABSPATH . '/views/_includes/style_selector.php';

			// /views/modulo_empresa/_breadcrumb_gerenciar_contratoaires.php
			require ABSPATH . '/views/modulo_empresa/_breadcrumb_gerenciar_contratoaires.php';

			// /views/_includes/search_box.php
			require ABSPATH . '/views/_includes/search_box.php';

			// /views/modulo_empresa/gerenciar_contratoaires-view.php
			require ABSPATH . '/views/modulo_empresa/gerenciar_contratoaires-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';

			// /views/modulo_empresa/_include_gerenciar_contratoaires.php
			require ABSPATH . '/views/modulo_empresa/_include_gerenciar_contratoaires.php';
		}
		
		/**
		 * Load the page "http://www.airessolucoes.com.br/Detail_Data/modulo_empresa/cadastrar_contratoaires"
		*/
		public function cadastrarcontratoaires()
		{
			// Page title
			$this->title = 'Cadastrar Contrato Aires';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_empresa/cadastrar_contratoaires-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/_includes/style_selector.php
			require ABSPATH . '/views/_includes/style_selector.php';

			// /views/modulo_empresa/_breadcrumb_cadastrar_contratoaires.php
			require ABSPATH . '/views/modulo_empresa/_breadcrumb_cadastrar_contratoaires.php';

			// /views/_includes/search_box.php
			require ABSPATH . '/views/_includes/search_box.php';

			// /views/modulo_empresa/cadastrar_contratoaires-view.php
			require ABSPATH . '/views/modulo_empresa/cadastrar_contratoaires-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';

			// /views/modulo_empresa/_include_cadastrar_contratoaires.php
			require ABSPATH . '/views/modulo_empresa/_include_cadastrar_contratoaires.php';
		}

		/**
		 * Load the page "http://www.airessolucoes.com.br/Detail_Data/modulo_empresa/gerenciar_representante"
		*/
		public function gerenciarrepresentante()
		{
			// Page title
			$this->title = 'Gerenciar Representantes';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_empresa/cadastrar_representante-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/_includes/style_selector.php
			require ABSPATH . '/views/_includes/style_selector.php';

			// /views/modulo_empresa/_breadcrumb_gerenciar_representante.php
			require ABSPATH . '/views/modulo_empresa/_breadcrumb_gerenciar_representante.php';

			// /views/_includes/search_box.php
			require ABSPATH . '/views/_includes/search_box.php';

			// /views/modulo_empresa/gerenciar_representante-view.php
			require ABSPATH . '/views/modulo_empresa/gerenciar_representante-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';

			// /views/modulo_empresa/_include_gerenciar_representante.php
			require ABSPATH . '/views/modulo_empresa/_include_gerenciar_representante.php';
		}

		/**
		 * Load the page "http://www.airessolucoes.com.br/Detail_Data/modulo_empresa/cadastrar_representante"
		*/
		public function cadastrarrepresentante()
		{
			// Page title
			$this->title = 'Cadastrar Representante';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			/** Load files from view **/

			// Load model
			$modelo = $this->load_model('modulo_empresa/cadastrar_representante-model');

			// /views/_includes/header.php
			require ABSPATH . '/views/_includes/header.php';

			// /views/_includes/navbar.php
			require ABSPATH . '/views/_includes/navbar.php';

			// /views/_includes/sidebar.php
			require ABSPATH . '/views/_includes/sidebar.php';

			// /views/_includes/style_selector.php
			require ABSPATH . '/views/_includes/style_selector.php';

			// /views/modulo_empresa/_breadcrumb_cadastrar_representante.php
			require ABSPATH . '/views/modulo_empresa/_breadcrumb_cadastrar_representante.php';

			// /views/_includes/search_box.php
			require ABSPATH . '/views/_includes/search_box.php';

			// /views/modulo_empresa/cadastrar_representante-view.php
			require ABSPATH . '/views/modulo_empresa/cadastrar_representante-view.php';

			// /views/_includes/footer.php
			require ABSPATH . '/views/_includes/footer.php';

			// /views/modulo_empresa/_include_cadastrar_representante.php
			require ABSPATH . '/views/modulo_empresa/_include_cadastrar_representante.php';
		}
	} // class HomeController
?>