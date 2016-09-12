<?php

	class ModuloAulaModel extends MainModel
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
			$GLOBALS['ACTIVE_TAB'] = "Aula";
		}

		/**
		 * Get all valid sensei's in database
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function getSensei()
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT `ID_USUARIO`, `PRIMEIRO_NOME`, `SOBRENOME` FROM `usuario` WHERE `ID_TIPO_USUARIO` = 2 AND `DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;

		} // getSensei

		/**
		 * Get all valid user in database
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function getStudents()
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT USR.`ID_USUARIO`, USR.`ID_TIPO_USUARIO`, FX.`NOME`, USR.`PRIMEIRO_NOME`, USR.`SOBRENOME`
				FROM 
					`usuario` AS USR
				INNER JOIN 
					`tipoUsuario` AS TUSR ON TUSR.`ID_TIPO_USUARIO` = USR.`ID_TIPO_USUARIO`
				INNER JOIN 
					`faixa` AS FX ON FX.`ID_FAIXA` = USR.`ID_FAIXA`
				WHERE 
					USR.`ID_TIPO_USUARIO` = 3 AND
					USR.`DATA_FECHA` IS NULL
				ORDER BY USR.`PRIMEIRO_NOME`, USR.`SOBRENOME`");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;

		} // getUsers

		/**
		 * Get all valid classe in database
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function getClasses()
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT AULA.`ID_AULA`, AULA.`DATA_AULA`, AULA.`CONTEUDO_MINISTRADO`,
				USR.`PRIMEIRO_NOME`, USR.`SOBRENOME`
				FROM 
					`aula` AS AULA
				INNER JOIN 
					`usuario` AS USR ON USR.`ID_USUARIO` = AULA.`ID_PROFESSOR`
				WHERE
					AULA.`DATA_FECHA` IS NULL
				ORDER BY AULA.`DATA_AULA` DESC");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;

		} // getClasses

		/**
		 * Get all valid classe in database
		 *
		 * @param class_id_ => class ID
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function get_class_info( $class_id_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT AULA.`ID_AULA`, AULA.`DATA_AULA`, AULA.`CONTEUDO_MINISTRADO`, AULA.`ID_PROFESSOR`
				FROM 
					`aula` as AULA
				WHERE
					AULA.`ID_AULA` = " . $class_id_ . " AND
					AULA.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetch();
			else
				return 0;

		} // get_class_info

		/**
		 * Get all valid frequencies in database
		 *
		 * @param class_id_ => class ID
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => ID PEC
		*/
		public function get_frequency_info( $class_id_ )
		{
			// Select the necessary data from DB
			$query = $this->db->query("SELECT FREQ.`ID_FREQUENCIA`, FREQ.`ID_ALUNO`, FREQ.`PRESENTE`
				FROM 
					`frequencia` as FREQ
				WHERE
					FREQ.`ID_AULA` = " . $class_id_ . " AND
					FREQ.`DATA_FECHA` IS NULL");

			// Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;

		} // get_frequency_info

		/**
		 * Insert classes
		 *
		 * @since 0.1
		 * @access public
		*/
		public function insert_class()
		{
			/**
			 * Check if information was sent from web form with a field called insere_empresa.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] )
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

			// Auxiliary variable to define the information position in array
			$info_position = 3;

			/*
			 * 1º step: insert the class itself
			*/
			$query = $this->db->insert( 'aula', array_slice($_POST, 0, $info_position) );

			// Check if the insertion worked
			if ( $query )
			{
				/*
				 * 2º step: insert the frequency
				*/
				$arr_data = array();

				// Add last inserted ID to aux variable
				$aux_id_aula = $this->db->last_id;

				// Split frequency array
				$user_list = explode("@@", $_POST['elem_USERS']);
				$frequency_list = explode("@@", $_POST['elem_FREQUENCY']);

				// Insert multiple registers in DB
				for ( $i = 0; $i < (sizeof($user_list) - 1); $i++ )
				{
					if ( isset($user_list) && isset($frequency_list) )
					{
						$arr_data['ID_AULA'] = $aux_id_aula;
						$arr_data['ID_ALUNO'] = $user_list[$i];
						$arr_data['PRESENTE'] = $frequency_list[$i];

						var_dump($arr_data); 

						if ( $arr_data['ID_AULA'] != "" && $arr_data['ID_AULA'] != "" )
						{
							// Insert equipment register
							$query2 = $this->db->insert( 'frequencia', $arr_data );
						}
					}
				}

				// Check if the insertion worked
				if ( $query2 )
				{
					// Redirect (success)
					?><script>window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_aula?status=success&action=insert')); ?>";</script> <?php
				}
				return;
			}

			// Redirect (error)
			?><script>window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_aula?status=error&action=insert')); ?>";</script> <?php

		} // insert_class

		/**
		 * Edit classes
		 *
		 * @since 0.1
		 * @access public
		*/
		public function edit_class( $class_id_ )
		{
			/**
			 * Check if information was sent from web form with a field called insere_empresa.
			*/
			if ( 'POST' != $_SERVER['REQUEST_METHOD'] )
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

			// Auxiliary variable to define the information position in array
			$info_position = 3;			

			/*
			 * 1º step: edit the class itself
			*/
			$query = $this->db->update( 'aula', 'ID_AULA', $class_id_, array_slice($_POST, 0, $info_position) );

			// Check if the insertion worked
			if ( $query )
			{
				/*
				 * 2º step: insert the frequency
				*/
				$arr_data = array();

				// Split frequency array
				$user_list = explode("@@", $_POST['elem_USERS']);
				$frequency_list = explode("@@", $_POST['elem_FREQUENCY']);

				// Insert multiple registers in DB
				for ( $i = 0; $i < (sizeof($user_list) - 1); $i++ )
				{
					if ( isset($user_list) && isset($frequency_list) )
					{
						$arr_data['ID_AULA'] = $class_id_;
						$arr_data['ID_ALUNO'] = $user_list[$i];
						$arr_data['PRESENTE'] = $frequency_list[$i];

						if ( $arr_data['ID_AULA'] != "" && $arr_data['ID_AULA'] != "" )
						{
							// Select the frequency ID
							$query2 = $this->db->query("SELECT `ID_FREQUENCIA` FROM `frequencia` 
							WHERE
								`ID_AULA` = " . $arr_data['ID_AULA'] . " AND
								`ID_ALUNO` = " . $arr_data['ID_ALUNO'] . " AND
								`DATA_FECHA` IS NULL");

							// Check if query worked
							if ( $query2 )
							{
								$id_frequency = $query2->fetchcolumn(0);

								// Insert equipment register
								$query3 = $this->db->update( 'frequencia', 'ID_FREQUENCIA', $id_frequency, $arr_data );
							}
						}
					}
				}

				// Check if the edition worked
				if ( $query3 )
				{
					// Redirect (success)
					?><script>window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_aula?status=success&action=edit')); ?>";</script> <?php
				}
				return;
			}

			// Redirect (error)
			?><script>window.location.href = "<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_aula?status=error&action=edit')); ?>";</script> <?php

		} // edit_class

		/**
		 * Delete an specific class
		 * 
		 * @since 0.1
		 * @access public
		 *
		 * @param $class_ID_ => class ID
		*/
		public function delete_class( $class_ID_ )
		{
			// Auxiliar variables
			$arr_data = array();
			$arr_data["DATA_FECHA"] = date("d-m-Y H:i:s");

			// Check the item type
			if ( isset($class_ID_) && $class_ID_ != "" && $class_ID_ != 0 )
			{
				// Disable the user itself
				$query = $this->db->update( 'aula', 'ID_AULA', $class_ID_, $arr_data );

				// Cascade (if it's necessary)
				$query = $this->db->update( 'frequencia', 'ID_AULA', $class_ID_, $arr_data );
			}

			echo "///";

		} // delete_class
	}

?>