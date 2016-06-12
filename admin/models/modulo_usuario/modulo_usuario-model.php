<?php

	class ModuloUsuarioModel extends MainModel
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
			$GLOBALS['ACTIVE_TAB'] = "Usuario";
		}

		/**
		 * Get all valid user in database
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function getUsers()
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT USR.`ID_USUARIO`, USR.`ID_TIPO_USUARIO`, USR.`ID_FAIXA`, USR.`PRIMEIRO_NOME`, USR.`SOBRENOME`, 
				USR.`CPF`, USR.`DATA_CADASTRO`, USR.`DATA_FECHA` 
				FROM 
					`usuario` AS USR
				INNER JOIN 
					`tipoUsuario` AS TUSR ON TUSR.`ID_TIPO_USUARIO` = USR.`ID_TIPO_USUARIO`
				INNER JOIN 
					`faixa` AS FX ON FX.`ID_FAIXA` = USR.`ID_FAIXA`
				WHERE 
					USR.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;

		} // getUsers
	}

?>