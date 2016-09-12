<?php

	class ModuloHomeModel extends MainModel
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

			// Set the controller
			$this->controller = $controller;

			// Set the main parameters
			$this->parametros = $this->controller->parametros;

			// Set user data
			$this->userdata = $this->controller->userdata;
			
			// Define the active tab
			$GLOBALS['ACTIVE_TAB'] = "Dashboard";
		}

		/**
		 * Get the site's statistcs
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_users_count() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT COUNT(`ID_USUARIO`) FROM `usuario` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchColumn(0);
		} // get_users_count

		public function get_class_count() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT COUNT(`ID_AULA`) FROM `aula` WHERE `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchColumn(0);
		} // get_class_count

		public function get_sensei_count() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT COUNT(`ID_USUARIO`) FROM `usuario` WHERE `ID_TIPO_USUARIO` = 2 AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchColumn(0);
		} // get_sensei_count

		public function get_student_count() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT COUNT(`ID_USUARIO`) FROM `usuario` WHERE `ID_TIPO_USUARIO` = 3 AND `DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchColumn(0);
		} // get_student_count

		public function get_last_class() 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT `DATA_AULA` FROM `aula` WHERE `DATA_FECHA` IS NULL ORDER BY `ID_AULA` DESC LIMIT 1');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchColumn(0);
		} // get_student_count

		/**
		 * Get the site's statistcs
		 * 
		 * @since 0.1
		 * @access public
		*/
		public function get_users_count_by_period( $month_year_ ) 
		{
			// Select the necessary data from DB
			$query = $this->db->query('SELECT COUNT(`ID_USUARIO`) FROM `usuario` 
			WHERE 
				`DATA_CADASTRO` LIKE "%' . $month_year_ . '%" AND 
				`DATA_FECHA` IS NULL');

			// Check if query worked
			if ( ! $query )
				return array();

			// Return data to view
			return $query->fetchColumn(0);
		} // get_users_count
	}

?>