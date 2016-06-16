<?php

	/**
	 * Modulo_Login - Controller modulo_login
	 *
	 * @package KMSMVC
	 * @since 0.1
	*/
	class ModuloLoginController extends MainController
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
		 * Load the page "http://localhost:2380/KMS/admin/modulo_login/"
		*/
		public function index( )
		{
			// Page title
			$this->title = 'AKC - Login';

			// Function parameter
			$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

			// /views/modulo_login/login.php
			require ABSPATH . '/views/modulo_login/login-view.php';

		} // index
	}
?>