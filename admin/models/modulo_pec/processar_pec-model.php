<?php

	class ProcessarPecModel extends MainModel
	{
		/*!
		 * Attributes
		*/
		private $content;
		private $carrier;
		private $attachment;
		private $idPEC;
		private $period;
		private $status_processing; //! Define if the PEC was extract
		private $shared_consume; //! Specific for Claro and OI
		private $arr_tpdet; //! Define the type of detailed info
		private $time_elapsed_secs;
		public $arr_service_type;
		public $arr_service_list;

		/*! 
		 * Get's and set's
		*/

		//! Content
		public function setContent( $content_ )
		{
			//! Clean the content before pass
			$content_ = str_replace("AEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE", "", $content_);
			$content_ = str_replace("CEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE", "", $content_);
			$content_ = str_replace("EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE", "", $content_);
			$content_ = str_replace("AEEEEEEEEEEEEEE", "", $content_);
			$content_ = str_replace("CEEEEEEEEEEEEE", "", $content_);
			$content_ = preg_replace("/B\s+ED\s+/", "", $content_);
			$content_ = preg_replace("/F\s+F\s+/", " ", $content_);
			$content_ = preg_replace("/F\s+ED\s+/", " ", $content_);
			$content_ = preg_replace("/\s+F\s+/", " ", $content_);
			$content_ = preg_replace("/\s+EDE\s+/", " ", $content_);
			$content_ = preg_replace("/\s+ED\s+/", " ", $content_);

			$this->content = $content_;
		}
		public function getContent()
		{
			return $this->content;
		}

		//! Carrier
		public function setCarrier( $carrier_ )
		{
			$this->carrier = $carrier_;
		}
		public function getCarrier()
		{
			return $this->carrier;
		}

		//! Attachment
		public function setAttachment( $attachment_ )
		{
			$this->attachment = $attachment_;
		}
		public function getAttachment()
		{
			return $this->attachment;
		}

		//! ID PEC
		public function setIdPEC( $idPEC_ )
		{
			$this->idPEC = $idPEC_;
		}
		public function getIdPEC()
		{
			return $this->idPEC;
		}

		//! Period
		public function setPeriod( $idPeriod_ )
		{
			$this->period = $idPeriod_;
		}
		public function getPeriod()
		{
			return $this->period;
		}

		//! Processing status
		public function setStatusProcessing( $status_processing_ )
		{
			$this->status_processing = $status_processing_;
		}
		public function getStatusProcessing()
		{
			return $this->status_processing;
		}

		//! Shared consume
		public function setSharedConsume( $shared_consume_ )
		{
			$this->shared_consume = $shared_consume_;
		}
		public function getSharedConsume()
		{
			return $this->shared_consume;
		}

		//! Detailed type info array
		public function setDetailType( $arr_tpdet_ )
		{
			$this->arr_tpdet = $arr_tpdet_;
		}
		public function getDetailType()
		{
			return $this->arr_tpdet;
		}

		//! Processed time
		public function setProcessedTime( $time_elapsed_secs_ )
		{
			$this->time_elapsed_secs = $time_elapsed_secs_;
		}
		public function getProcessedTime()
		{
			return $this->time_elapsed_secs;
		}

		/*!
		 * Class constructor
		 *
		 * Set the database, controller, parameter and user data.
		 *
		 * @since 0.1
		 * @access public
		 * @param => object $db PDO Conexion object
		 * @param => object $controller Controller object
		*/
		public function __construct( $db = false, $controller = null )
		{
			//! Set DB (PDO)
			$this->db = $db;

			//! Set controller
			$this->controller = $controller;

			//! Set parameters
			$this->parametros = $this->controller->parametros;

			//! Set user data
			$this->userdata = $this->controller->userdata;
			
			//! Define the active tab
			$GLOBALS['ACTIVE_TAB'] = "PEC";

			//! Set status processing false
			$this->setStatusProcessing(false);

			//! Set initial processing time
			$this->setProcessedTime(microtime(true));
		}

		/*!
		 * Extract PEC content
		 *
		 * @since 0.1
		 * @access public
		*/
		public function extract_PEC()
		{
			//! Set a limit to processing time
			ini_set('MAX_EXECUTION_TIME', -1);

			/*! =========CONSTANTS======== */
			$uploaddir = "resources/faturas/";	//! Directory to storage the file
			$no_security = "D"; 				//! Constant to differentiate between file deprotected
			/*! ========================== */

			//! Check if file exists
			if ( !isset($_FILES['FILE_ANEXO']) )
			{
				?><script>alert("Houve um problema no upload da fatura. Por favor, tente novamente.");
				window.location.href = "<?php echo HOME_URI;?>/modulo_pec/upload_pec";</script> <?php
				return false;
			}

			//! Define the file name
			$ip = get_client_ip();

			if ( $ip == "::1" )
				$ip = "127.0.0.1";

			$file_name = $ip;

			//! Control file name version
			$contador = 1;

			//!****************************************INVOICE'S UPLOAD***************************************//!

				//! Search for the file extension
				$path = $_FILES['FILE_ANEXO']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);

				//! Check if the file name already exists
				while ( file_exists($uploaddir . $no_security . $file_name . "." . $ext) || file_exists($uploaddir . $file_name . "." . $ext) )
				{
					$file_name = $ip . "[" . $contador . "]";
					$contador += 1;
				}

				//! Define the directory where the file'll be saved
				$uploadfile = $uploaddir . $file_name . "." . $ext;

				//! File upload
				move_uploaded_file($_FILES['FILE_ANEXO']['tmp_name'], $uploadfile);
				chmod($uploadfile, 0777);
				$this->setAttachment($uploadfile);

			//!*************************************PDF CONVERSION TO TEXT************************************//!

				//! Initialize the content variable
				$content = "";

				// =========================[ Remove file's protection ]========================= //

					// Check the OS
					if ( strcmp(OS, "LIN") == 0 ) //!< LINUX
					{
						shell_exec("qpdf --decrypt " . $uploadfile . " " . $uploaddir . $no_security . $file_name . "." . $ext);

						// Check if the file exists and give access permission to read
						if ( file_exists($uploaddir . $no_security . $file_name . "." . $ext) )
						{
							chmod($uploaddir . $no_security . $file_name . "." . $ext, 0777);
						}
					}
					else //!< WINDOWS
					{
						shell_exec("assets\PDFextractor\PsExec.exe -accepteula " . ABSPATH . "\assets\PDFextractor\QPDF\qpdf.exe --decrypt " . $uploadfile . " " . $uploaddir . $no_security . $file_name . "." . $ext);
					}

					//! Check if it worked
					if ( file_exists($uploaddir . $no_security . $file_name . "." . $ext) )
					{
						//! Remove the original
						unlink($uploadfile);

						//! Update the file name
						$file_name = $no_security . $file_name;
						$uploadfile = str_replace_last( "/" , "/" . $no_security , $uploadfile );
						$this->setAttachment($uploadfile);
					}

				// ============================================================================== //

				// =======================[ PDF file conversion to TEXT ]======================== //

					//! Try to use HTMLtoPDF to convert the file

					// Check the OS
					if ( strcmp(OS, "LIN") == 0 ) //!< LINUX
					{
						echo "</br>PDFextractor/pdftohtml</br>";
						echo "pdftohtml -i " . $uploadfile . " " . $file_name . ".html</br></br>";

						//shell_exec("./assets/PDFextractor/pdftohtml.exe -i " . $uploadfile . " " . $file_name . ".html");
						shell_exec("pdftohtml -i " . $uploadfile . " " . $file_name . ".html");
					}
					else //!< WINDOWS
					{
						shell_exec("assets\PDFextractor\PsExec.exe -accepteula " . ABSPATH . "\assets\PDFextractor\pdftohtml.exe -i " . $uploadfile . " " . $file_name . ".html");
					}

					//! Check if it worked
					if ( file_exists($file_name . "s.html") )
					{
						//! Retrieve the information from file generated
						$content = file_get_contents($file_name . "s.html", FILE_TEXT);
						//$content = utf8_encode($content);
						$content = strip_tags($content);
						$enc = mb_detect_encoding($content, "UTF-8,ISO-8859-1");

						//! Clean up the files generated in this operation
						unlink($file_name . ".html");
						unlink($file_name . "_ind.html");
						unlink($file_name . "s.html");
					}
					//! In case of HTMLtoPDF not work, try to use PDFtoText
					else
					{
						// Check the OS
						if ( strcmp(OS, "LIN") == 0 ) //!< LINUX
						{
							echo "</br>PDFextractor/pdftotext.exe</br>";
							echo "./assets/PDFextractor/pdftotext.exe " . $uploadfile . "</br></br>";

							shell_exec("./assets/PDFextractor/pdftotext.exe " . $uploadfile);
						}
						else
						{
							shell_exec("assets\PDFextractor\PsExec.exe -accepteula " . ABSPATH . "\assets\PDFextractor\pdftotext.exe " . $uploadfile);
						}

						//! Retrieve the information from file generated
						if ( file_exists($file_name . ".txt") )
						{
							$content = file_get_contents($file_name . ".txt", FILE_TEXT);
							$enc = mb_detect_encoding($content, "UTF-8,ISO-8859-1");
						}
						else
						{
							//! In case nothing works, try to use XPDF
							if ( strcmp(OS, "LIN") == 0 ) //!< LINUX
							{
								echo "</br>XPDF_LINUX/pdftotext</br>";
								echo "./assets/PDFextractor/XPDF_LINUX/pdftotext " . $uploadfile . " " . $file_name . ".txt</br></br>";

								shell_exec("./assets/PDFextractor/XPDF_LINUX/pdftotext " . $uploadfile . " " . $file_name . ".txt");
							}
							else
							{
								shell_exec("assets\PDFextractor\PsExec.exe -accepteula " . ABSPATH . "\assets\PDFextractor\XPDF\pdftotext.exe " . $uploadfile . " " . $file_name . ".txt");
							}
						}

						//! Try for the last time read the generated file
						if ( file_exists($file_name . ".txt") )
						{
							$content = file_get_contents($file_name . ".txt", FILE_TEXT);
							$enc = mb_detect_encoding($content, "UTF-8,ISO-8859-1");

							//! Clean up the files generated in this operation
							unlink($file_name . ".txt");
						}
						else
						{
							$content = "";

							//! Handler a error message to the user
							echo "Infelizmente não foi possível ler a fatura solicitada.";
						}
					}

				// ============================================================================== //

			//!***********************************************************************************************//!

			//! Check if the extraction worked
			if ( isset($enc) )
			{
				//! Return the result
				$this->setContent( asciify(iconv($enc, "UTF-8", $content)) );
			}

		} //! extract_PEC

		/*!
		 * Identify to which carrier the income belong
		 *
		 * @since 0.1
		 * @access public
		 * @content_ => the content to be analysed
		*/
		public function getCarrier_PEC( $content_ )
		{
			/*!
			 * Define the carrier
			*/
			if ( strpos($content_, "Atendimento Claro") !== false )
			{
				$this->setCarrier("claro"); //! CLARO
			}
			else if ( strpos($content_, "vivo.com.br") !== false )
			{
				$this->setCarrier("vivo"); //! VIVO
			}
			else if ( (strpos($content_, "nextel") !== false || strpos($content_, "Nextel") !== false) ) 
			{
				$this->setCarrier("nextel"); //! NEXTEL
			}
			else if ( strpos($content_, "tim.com.br") !== false )
			{
				$this->setCarrier("tim"); //! TIM
			}
		} //! getCarrier_PEC

		/*!
		 * Get the service list from PEC content
		 *
		 * @since 0.1
		 * @access public
		 * @content_ => the content to be analysed
		*/
		public function getInfo_PEC( $content_ )
		{
			//! Set a limit to processing time
			ini_set('MAX_EXECUTION_TIME', -1);

			//! Auxiliary variables
			$str_begin = "";
			$str_end = "";
			//!--------------------
			$arr_data = array();
			$arr_data["N_CONTA"] = "";
			$arr_data["ID_EMPRESA"] = 1; //! Dummy value, it's necessary to fix when login system working
			$arr_data["ID_OPERADORA"] = ""; //! Compare with the carrier in database
			$arr_data["CENTRO_CUSTO"] = "";
			$arr_data["MES_REFERENCIA"] = "";
			$arr_data["DATA_VENCIMENTO"] = "";
			$arr_data["PERIODO"] = "";
			$arr_data["ANEXO"] = "";

			//! Regex Period => E.g:(24/10/2014 à 01/11/2014)
			$regex_period = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s+a+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';

			//! Carrier value
			$query = $this->db->query('SELECT `ID_OPERADORA` FROM `operadora.operadora` WHERE lower(`NOME_OPERADORA`) LIKE "%' . $this->getCarrier() . '%"
									   AND `DATA_FECHA` IS NULL');

			//! Check if query worked
			if ( $query )
			{
				//! Passing values that don't depend from a specific carrier
				$arr_data["ID_OPERADORA"] = $query->fetchColumn(0); //! value
				$arr_data["ANEXO"] = $this->getAttachment(); //! value

				//! Check the carrier
				switch( strtolower($this->getCarrier()) )
				{
					//! ---------------------------------------------------------------------------
					case "claro":
					//! ---------------------------------------------------------------------------

						//! Define the anchors
						$str_begin = "Nº do Cliente";
						$str_end = "Veja aqui o que está sendo cobrado";

						//! Get the necessary content according the limiters 
						$break01 = explode($str_begin, $content_); //! begin
						$break02 = explode($str_end, $break01[1]); //! end

						//! Invoice number
						$break03 = explode("Nº da Conta", $break02[0]); //! begin
						$break04 = explode(":", $break03[1]); //! end
						$arr_data["N_CONTA"] = v_num($break04[1]); //! value

						//! Period
						$break05 = explode("Período de Uso", $break02[0]); //! begin
						$break06 = explode("R$", $break05[1]); //! end
						$this->setPeriod(substr(trim($break06[0]), -35, -10));

						$arr_data["DATA_VENCIMENTO"] = substr(trim($break06[0]), -10); //! value
						$arr_data["MES_REFERENCIA"] = substr($arr_data["DATA_VENCIMENTO"], -7); //! value
						$arr_data["PERIODO"] = $this->getPeriod(); //! value

						break;

					//! ---------------------------------------------------------------------------
					case "vivo":
					//! ---------------------------------------------------------------------------

						//! Define the anchors
						$str_begin = "Nº da Conta";
						$str_end = "O que está sendo cobrado";

						//! Get the necessary content according the limiters 
						$break01 = explode($str_begin, $content_); //! begin
						$break02 = explode($str_end, $break01[1]); //! end

						//! Invoice number
						if ( strpos($break02[0], "Mês de referência:") !== false )
						{
							$break03 = explode("Mês de referência:", $break02[0]); //! begin and end
							$arr_data["N_CONTA"] = v_num($break03[0]); //! value
						}
						else
						{
							$break03 = explode("Mês de referência:", $break02[1]); //! begin and end
							$arr_data["N_CONTA"] = v_num($break03[0]); //! value
						}

						//! Expire date
						if ( strpos($break02[0], "Vencimento") !== false )
						{
							$break04 = explode("Vencimento", $break02[0]); //! begin
							$break05 = explode("R$", $break04[1]); //! end
						}
						else
						{
							$break04 = explode("Vencimento", $break02[1]); //! begin
							$break05 = explode("R$", $break04[1]); //! end
						}

						// Check if it's a valid value
						if ( isset($break05[0]) && $break05[0] != "" )
							$arr_data["DATA_VENCIMENTO"] = mask_string("##/##/####", substr(v_num($break05[0]), 0, 8)); //! value
						else
							$arr_data["DATA_VENCIMENTO"] = "";

						//! Reference month
						if ( strpos($break02[0], "Mês de referência:") !== false )
						{
							$break06 = explode("Mês de referência:", $break02[0]); //! begin
							$break07 = explode(":", $break06[1]); //! end
						}
						else
						{
							$break06 = explode("Mês de referência:", $break02[1]); //! begin
							$break07 = explode(":", $break06[1]); //! end
						}

						$arr_data["MES_REFERENCIA"] = mask_string("##/####", v_num($break07[0])); //! value

						//! Period
						if ( strpos($break02[0], "Mês de referência:") !== false )
						{
							$break08 = explode("Período:", $break02[0]); //! begin
							$break09 = explode(":", $break08[1]); //! end
						}
						else
						{
							$break08 = explode("Período:", $break02[1]); //! begin
							$break09 = explode(":", $break08[1]); //! end
						}

						$arr_data["PERIODO"] = mask_string("##/##/#### a ##/##/####", v_num($break09[0])); //! value

						var_dump($arr_data);

						break;

					//! ---------------------------------------------------------------------------
					case "nextel":
					//! ---------------------------------------------------------------------------

						$str_end = "SUAS VANTAGENS";

						//! Define the anchors
						if( strpos($content_, "CódigodaConta:") !== false )
						{
							$str_begin = "CódigodaConta:";

							//! Get the necessary content according the limiters 
							$break01 = explode($str_begin, $content_); //! begin
							$break02 = explode($str_end, $break01[1]); //! end

							//! Invoice number
							$break03 = explode(",", $break02[0]); //! begin and end
							$arr_data["N_CONTA"] = v_num($break03[0]); //! value

							//! Reference month and expire date
							$break04 = explode($arr_data["N_CONTA"], $break02[0]); //! begin and end
							$arr_data["DATA_VENCIMENTO"] = substr(trim($break04[2]), 0, 10); //! value
							$arr_data["MES_REFERENCIA"] = substr($arr_data["DATA_VENCIMENTO"], -7); //! value

							//! Period
							if( strpos($break02[0], "PeríododeUtilização:") !== false )
								$break05 = explode("PeríododeUtilização:", $break02[0]); //! begin
							else if( strpos($break02[0], "Período de Utilização:") !== false )
								$break05 = explode("Período de Utilização:", $break02[0]); //! begin

							$break06 = explode(":", $break05[1]); //! end
							$arr_data["PERIODO"] = mask_string("##/##/#### a ##/##/####", v_num($break06[0])); //! value

							//! Customer ID
							$break07 = explode("IdentificaçãodoCliente:", $content_); //! begin and end
							$break08 = preg_split('/\s+/', rtrim(ltrim($break07[1])));
							$arr_data["CENTRO_CUSTO"] = $break08[0]; //! value
						}
						else
						{
							$str_begin = "Código da Conta:";

							if( strpos($content_, $str_end) !== false )
							{
								//! Get the necessary content according the limiters 
								$break01 = explode($str_begin, $content_); //! begin
								$break02 = explode($str_end, $break01[1]); //! end

								//! Invoice number
								$break03 = explode("CEP", $break02[0]); //! begin and end
								$arr_data["N_CONTA"] = v_num($break03[0]); //! value

								//! Reference month and expire date
								$break04 = explode($arr_data["N_CONTA"], $break03[1]); //! begin and end
								$arr_data["DATA_VENCIMENTO"] = substr(trim($break04[1]), 0, 10); //! value
								$arr_data["MES_REFERENCIA"] = substr($arr_data["DATA_VENCIMENTO"], -7); //! value

								//! Period
								if( strpos($break02[0], "PeríododeUtilização:") !== false )
									$break05 = explode("PeríododeUtilização:", $break02[0]); //! begin
								else if( strpos($break02[0], "Período de Utilização:") !== false )
									$break05 = explode("Período de Utilização:", $break02[0]); //! begin

								$break06 = explode(":", $break05[1]); //! end
								$arr_data["PERIODO"] = mask_string("##/##/#### a ##/##/####", v_num($break06[0])); //! value

								//! Customer ID
								$break07 = explode("Identificação do Cliente:", $content_); //! begin and end
								$break08 = preg_split('/\s+/', rtrim(ltrim($break07[1])));
								$arr_data["CENTRO_CUSTO"] = $break08[0]; //! value
							}
							else if( strpos($content_, "O QUE FOI CONTRATADO") !== false )
							{
								$str_end = "O QUE FOI CONTRATADO";

								//! Get the necessary content according the limiters 
								$break01 = explode($str_begin, $content_); //! begin
								$break02 = explode($str_end, $break01[1]); //! end

								//! Invoice number
								$break03 = preg_split('/\s+/', rtrim(ltrim($break02[0]))); //! begin and end
								$arr_data["N_CONTA"] = v_num($break03[0]); //! value

								//! Reference month and expire date
								$break04 = preg_split($regex_period, $break02[0]);
								$arr_data["DATA_VENCIMENTO"] = substr(trim($break04[1]), 0, 10); //! value
								$arr_data["MES_REFERENCIA"] = substr($arr_data["DATA_VENCIMENTO"], -7); //! value

								//! Period
								$break05 = preg_split('/Valor\s+a\s+pagar/', $break02[0]);
								$break06 = preg_split('/\s+/', ltrim(rtrim($break05[1])));
								$arr_data["PERIODO"] = $break06[1] . " " . $break06[2] . " " . $break06[3]; //! value

								//! Customer ID
								$break07 = explode("Valor a pagar", $content_); //! begin and end
								$break08 = preg_split('/\s+/', rtrim(ltrim($break07[1])));
								$arr_data["CENTRO_CUSTO"] = $break08[0]; //! value
							}
						}

						//! Get the service type list
						$service_type = "";

						//! Check the correct term
						if( strpos($content_, "SUBTOTAL UTILIZADO") !== false )
						{
							$break01_service = explode("O QUE FOI UTILIZADO", $content_); //! begin
							$break02_service = explode("SUBTOTAL UTILIZADO", $break01_service[1]); //! end

							//! Remove unnecessary information
							$break04_service = explode(",", $break02_service[0]);
						}
						else if( strpos($content_, "SUBTOTAL DE SERVIÇOS") !== false )
						{
							$break01_service = explode("SUBTOTAL MENSALIDADE", $content_); //! begin
							$break02_service = explode("SUBTOTAL DE SERVIÇOS", $break01_service[1]); //! end

							//! Remove unnecessary information
							$break03_service = explode("Serviços", $break02_service[0], 2);
							$break04_service = explode(",", $break03_service[1]);
						}
						else
						{
							$break04_service = "";
							$this->arr_service_type[0] = "Planos";
						}

						//! Add Rádio Nextel to service array
						$this->arr_service_type[0] = "Rádio Nextel";

						for ( $i = 0; $i < (sizeof($break04_service) - 1); $i++ )
						{
							//! Split the service name type to remove the unnecessary information
							if ( $i == 0 )
								$break05_service = preg_split('/\s+/', $break04_service[$i]);
							else
								$break05_service = preg_split('/\s+/', substr($break04_service[$i], 3));

							$this->arr_service_type[($i+1)] = "";
							for( $j = 0; $j < (sizeof($break05_service) - 1); $j++ )
							{
								//! Concatenate every part from the service name type
								$this->arr_service_type[($i+1)] .= $break05_service[$j] . " ";
							}
						}
						break;

					//! ---------------------------------------------------------------------------
					case "tim":
					//! ---------------------------------------------------------------------------

						//! Define the anchors
						$str_begin = '/Número+\s+da+\s+Fatura:/';
						$str_end = '/Total+\s+Nota/';

						//! Get the necessary content according the limiters 
						$break01 = preg_split($str_begin, $content_); //! begin
						$break02 = preg_split($str_end, $break01[1]); //! end
						$break02[0] = rtrim(ltrim($break02[0]));

						//! Invoice number
						$break03 = preg_split('/\s+/', $break02[0]); //! begin and end
						$arr_data["N_CONTA"] = v_num($break03[0]); //! value

						//! Expire date
						$break04 = explode("VENCIMENTO", $break02[0]); //! begin
						$break05 = preg_split('/\s+/', rtrim(ltrim($break04[1]))); //! end
						$arr_data["DATA_VENCIMENTO"] = mask_string("##/##/##", v_num($break05[1])); //! value

						//! Reference month
						$break06 = explode("Referência", $break02[0]); //! begin
						$break07 = preg_split('/\s+/', rtrim(ltrim($break06[1]))); //! end

						//! Adjust the reference month format
						$break07_aux = explode("/", $break07[0]);

						//! Convert the month initial in number
						switch ( $break07_aux[0] )
						{
							case "JAN": $break07[0] = str_replace($break07_aux[0], "01", $break07[0]); break;	//!< January
							case "FEV": $break07[0] = str_replace($break07_aux[0], "02", $break07[0]); break;	//!< February
							case "MAR": $break07[0] = str_replace($break07_aux[0], "03", $break07[0]); break;	//!< March
							case "ABR": $break07[0] = str_replace($break07_aux[0], "04", $break07[0]); break;	//!< April
							case "MAI": $break07[0] = str_replace($break07_aux[0], "05", $break07[0]); break;	//!< May
							case "JUN": $break07[0] = str_replace($break07_aux[0], "06", $break07[0]); break;	//!< June
							case "JUL": $break07[0] = str_replace($break07_aux[0], "07", $break07[0]); break;	//!< July
							case "AGO": $break07[0] = str_replace($break07_aux[0], "08", $break07[0]); break;	//!< August
							case "SET": $break07[0] = str_replace($break07_aux[0], "09", $break07[0]); break;	//!< September
							case "OUT": $break07[0] = str_replace($break07_aux[0], "10", $break07[0]); break;	//!< October
							case "NOV": $break07[0] = str_replace($break07_aux[0], "11", $break07[0]); break;	//!< November
							case "DEZ": $break07[0] = str_replace($break07_aux[0], "12", $break07[0]); break;	//!< December
						}

						$arr_data["MES_REFERENCIA"] = mask_string("##/##", v_num($break07[0])); //! value

						//! Period
						$break08 = explode("Período:", $break02[0]); //! begin
						$break09 = explode("CNPJ:", $break08[1]); //! end
						$arr_data["PERIODO"] = mask_string("##/##/## a ##/##/##", v_num($break09[0])); //! value

						break;
				}
			}

			//! Insert PEC head in database
			$query = $this->db->insert('pec.pec', $arr_data);

			//! Check operation
			if ( $query )
			{
				//! Add last inserted ID to the attribute
				$this->setIdPEC($this->db->last_id);
				return true;
			}
			else
			{
				return false;
			}

		} //! getInfo_PEC

		/*!
		 * Get the service list from PEC content
		 *
		 * @since 0.1
		 * @access public
		 * @content_ => the content to be analysed
		*/
		public function getServices_PEC( $content_ )
		{
			//! Set a limit to processing time
			ini_set('MAX_EXECUTION_TIME', -1);

			//! Auxiliary variables
			$str_begin = "";
			$str_end = "";
			$content_block = "";
			$flag_stop = 0; //! 0 => Keep running 1 => Stop
			$flag_sharedconsume = 0; //! 0 => Keep running 1 => Stop
			$cont_services = 0;
			//!--------------------
			$arr_services = array();
			$arr_data = array();
			$arr_data["ID_PEC"] = $this->getIdPEC();
			$arr_data["DESCRICAO"] = "";
			$arr_data["TIPO"] = "";

			//! Check the carrier
			switch( strtolower($this->getCarrier()) )
			{
				//! ---------------------------------------------------------------------------
				case "claro":
				//! ---------------------------------------------------------------------------

					//! Define the anchors
					$str_begin = "Veja aqui o que está sendo cobrado";
					$str_end = "Total do Mês";

					//! Define the service type
					$service_type = array("Compartilhados", "Individuais");

					//! Get the necessary content according the limiters 
					$break01 = explode($str_begin, $content_); //! begin

					//! Link the page break information 
					for ( $x = 1; $x < sizeof($break01); $x++ )
					{
						if ( (strpos($break01[$x], $str_end) !== false ) ) 
						{
							$break02 = explode($str_end, $break01[$x]); //! end
							$content_block .= " " . $break02[0];
							break;
						}
						else
						{
							$content_block .= " " . $break01[$x];
						}
					}

					//! Check if it's necessary remove unnecessary information from page break
					if ( (strpos($content_block, "(Continuação)") !== false ) ) 
					{
						$break02 = explode("Pague sua conta nos Bancos e Locais credenciados", $content_block); //! end previous page
						$aux_break = explode("(Continuação)", $content_block); //! begin next page
						$break02[0] .= " " . $aux_break[1];
					}

					for ( $x = 0; $x < sizeof($service_type); $x++ )
					{
						//! Check if the services are separated by service type
						if ( (strpos($break02[0] , "Compartilhados") !== false ) || (strpos($break02[0] , "Individuais") !== false ) )
						{
							//! Shared services
							if ( $service_type[$x] == "Compartilhados" )
							{
								$break03 = explode("Compartilhados", $break02[0]); //! begin
								$break04 = explode("Individuais", $break03[1]); //! end
								$break05 = preg_split('/([0-9])+,+([0-9])/', $break04[0]);
								$arr_data["TIPO"] = "Compartilhado";

								//! Get shared consume value
								if ( $flag_sharedconsume == 0 )
								{
									$break_sharedconsume = preg_split('/\s+/', rtrim(ltrim($break04[0])));
									$this->setSharedConsume($break_sharedconsume[(sizeof($break_sharedconsume) - 1)]);
									$flag_sharedconsume = 1;
								}
							}
							//! Individual services
							else if ( $service_type[$x] == "Individuais" )
							{
								$break03 = explode("Individuais", $break02[0]); //! begin
								$break04 = explode($str_end, $break03[1]); //! end
								$break05 = preg_split('/([0-9])+,+([0-9])/', $break04[0]);
								$arr_data["TIPO"] = "Individual";
							}
							$flag_stop = 0;
						}
						//! Without service distinction
						else
						{
							$break05 = preg_split('/([0-9])+,+([0-9])/', $break02[0]); //! end
							$flag_stop = 1;
							$arr_data["TIPO"] = "";
						}

						//! Clean up the service name
						for( $i = 0; $i < (sizeof($break05) - 1); $i++ )
						{
							//! Split the service name to remove the unnecessary information
							if ( $i == 0 )
								$break06 = preg_split('/\s+/', $break05[$i]);
							else
								$break06 = preg_split('/\s+/', substr($break05[$i], 3));

							for( $j = 0; $j < (sizeof($break06) - 2); $j++ )
							{
								//! Concatenate every part from the service name
								$arr_data["DESCRICAO"] .= $break06[$j] . " ";
							}
							$arr_data["DESCRICAO"] = mb_strtoupper($arr_data["DESCRICAO"], 'UTF-8');

							//! Insert the service list in database
							$query = $this->db->insert('pec.servicos', $arr_data);

							//! Check operation
							if ( !$query )
							{
								return false;
							}

							$arr_data["DESCRICAO"] = "";
						}

						//! Check if it'll keep running or stop
						if ( $flag_stop == 1 )
							break;
					}

					break;

				//! ---------------------------------------------------------------------------
				case "vivo":
				//! ---------------------------------------------------------------------------

					//! Define the anchors
					$str_begin = "O que está sendo cobrado";
					$str_end = "Subtotal";

					//! Get the necessary content according the limiters 
					$break01 = explode($str_begin, $content_); //! begin
					$break02 = explode($str_end, $break01[1]); //! end
					$break03 = explode("Serviços Contratados", $break02[0]);

					//! Separate de services by line
					$break04 = explode(",", $break03[1]);

					//! Service list
					for( $i = 0; $i < (sizeof($break04) - 1); $i++ )
					{
						//! Split the service name to remove the unnecessary information
						if ( $i == 0 )
							$break05 = preg_split('/\s+/', $break04[$i]);
						else
							$break05 = preg_split('/\s+/', substr($break04[$i], 3));

						for( $j = 0; $j < (sizeof($break05) - 3); $j++ )
						{
							//! Concatenate every part from the service name
							$arr_data["DESCRICAO"] .= $break05[$j] . " ";
						}

						$arr_data["DESCRICAO"] = rtrim(ltrim($arr_data["DESCRICAO"]));

						//! Insert the service list in database
						$query = $this->db->insert('pec.servicos', $arr_data);

						//! Check operation
						if ( !$query )
						{
							return false;
						}

						$arr_data["DESCRICAO"] = "";
					}

					break;

				//! ---------------------------------------------------------------------------
				case "nextel":
				//! ---------------------------------------------------------------------------

					//! Regex Period => E.g:(24/10/2014 à 01/11/2014)
					$regex_period = '/([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+([0-9])\w+\s+à+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+([0-9])\w+\s/';

					//! Define the anchors
					$str_begin = "O QUE FOI CONTRATADO";
					$str_end = "Subtotal";
					$str_end2 = "O QUE FOI UTILIZADO";
					$str_end3 = "Total do Nº:";

					//! Get the necessary content according the limiters 
					$break01 = explode($str_begin, $content_); //! begin

					//! Remove the additional header
					if ( strpos($break01[1], "Planos Período Plano de Serviço Valor") !== false )
						$x = 1;
					else
						$x = 2;

					//! Link the page break information 
					for ( $x; $x < sizeof($break01); $x++ )
					{
						//! Delimit the information block
						if ( strpos($break01[$x], $str_end2) !== false )
							$break02 = explode($str_end2, $break01[$x]); //! end
						else if ( strpos($break01[$x], $str_end3) !== false )
							$break02 = explode($str_end3, $break01[$x]); //! end
						else
							$break02 = explode($str_end, $break01[$x]); //! end

						//! Check the quantity of services in a single line
						$break03 = preg_split($regex_period, $break02[0]);

						//! Loop to get the service name
						for ( $i = 1; $i < sizeof($break03); $i++ )
						{
							//! Separate service name from value
							$break04 = explode(",", $break03[$i]); //! end
							$break05 = preg_split('/\s+/', $break04[0]);

							//! Remove the unnecessary value
							for( $j = 0; $j < (sizeof($break05) - 1); $j++ )
							{
								//! Concatenate every part from the service name
								$arr_data["DESCRICAO"] .= $break05[$j] . " ";
							}
							$arr_services[$cont_services] = rtrim(ltrim(mb_strtoupper($arr_data["DESCRICAO"], 'UTF-8')));
							$cont_services += 1;
							$arr_data["DESCRICAO"] = "";
						}
					}

					//! Remove repeated elements
					$arr_services = array_values(array_unique($arr_services));

					//! Insert services in database
					for ( $i = 0; $i <= sizeof($arr_services); $i++ )
					{
						//! Add service "SEM MENSALIDADE"
						if ( $i == sizeof($arr_services) )
							$arr_data["DESCRICAO"] = "SEM MENSALIDADE";
						else
							$arr_data["DESCRICAO"] = $arr_services[$i];

						//! Insert the service list in database
						$query = $this->db->insert('pec.servicos', $arr_data);

						//! Check operation
						if ( !$query )
						{
							return false;
						}
					}

					break;

				//! ---------------------------------------------------------------------------
				case "tim":
				//! ---------------------------------------------------------------------------

					$service_counter = 0;
					$arr_data2 = array();
					$arr_data2["ID_PEC"] = $this->getIdPEC();

					//! Define the anchors
					$str_begin = "/Quantidade+\s+de+\s+Acessos:+\s+([0-9])+\s+QUANTIDADE/";
					$str_end = "/TOTAL+\s+TIM/";

					//! Get the necessary content according the limiters 
					$break01 = preg_split($str_begin, $content_); //! begin
					$break02 = preg_split($str_end, $break01[1]); //! end
					//$break03 = explode("Serviços Contratados", $break02[0]);

					//! Get back the first column
					$break02[0] = "QUANTIDADE " . $break02[0];

					//! Split the content section
					$break03 = preg_split("/QUANTIDADE/", $break02[0]);

					//! Run through registers block
					for( $i = 1; $i < sizeof($break03); $i++ )
					{
						//! Separe the register from columns
						$aux_data = preg_split("/VALOR/", $break03[$i], 2);

						//! Adjust the columns name
						$aux_data[0] = "QUANTIDADE " . $aux_data[0] . " VALOR";
						$aux_data[0] = str_replace("Nº DIAS", "N_DIAS", $aux_data[0]);
						$aux_data[0] = str_replace("PIS/COFINS", "PIS_COFINS", $aux_data[0]);
						$aux_data[0] = str_replace("DURAÇÃO/VOLUME", "DURACAO_VOLUME", $aux_data[0]);
						$aux_data[0] = str_replace(" KB", "KB", $aux_data[0]);
						$aux_data[0] = str_replace(" MB", "MB", $aux_data[0]);
						$aux_data[0] = str_replace(" GB", "GB", $aux_data[0]);

						//! Adjust the register block (when it possible)
						if ( strpos($aux_data[1], "IMPOSTO") !== false )
						{
							$aux_data2 = preg_split("/IMPOSTO/", $aux_data[1]);
							$aux_data[1] = $aux_data2[0];
						}

						//! REMOVE "OUTROS CRÉDITOS" SECTION
						if ( strpos($aux_data[1], "OUTROS CRÉDITOS/DÉBITOS") === false )
						{
							//! Separate each register
							preg_match_all('/(([0-9])+,+([0-9])[^%])+\s[^KB MB GB TB]/', $aux_data[1], $match_values);
							$registers = preg_split('/(([0-9])+,+([0-9])[^%])+\s[^KB MB GB TB]/', $aux_data[1]);

							//! Run through each register
							for( $j = 1; $j < (sizeof($registers)); $j++ )
							{
								//! Check if it's a valid register
								if ( preg_match('/([0-9]),([0-9])\w/', $registers[$j]) )
								{
									//! Add value
									if ( isset($match_values[0][$j]) )
										$registers[$j] .= $match_values[0][$j];

									//! Remove some characters
									if ( $j != 0 )
										$registers[$j] = substr($registers[$j], 3);

									//! Prepare the register to be splited
									$registers[$j] = str_replace(" a ", "_a_", $registers[$j]);
									$registers[$j] = str_replace(" KB", "KB", $registers[$j]);
									$registers[$j] = str_replace(" MB", "MB", $registers[$j]);
									$registers[$j] = str_replace(" GB", "GB", $registers[$j]);
									$registers[$j] = str_replace(" TB", "TB", $registers[$j]);
									$arr_data["PIS_COFINS"] = "";
									$arr_data["DESCRICAO"] = "";
									$arr_data["N_DIAS"] = "";

									//! Split the register in columns to save in DB
									$break04 = preg_split('/\s+/', $registers[$j]);

									for ( $k = (sizeof($break04) - 1); $k >= 0; $k-- )
									{
										//! ICMS / PIS & COFINS
										if ( strpos($break04[$k], "%") !== false )
										{
											if ( trim($arr_data["PIS_COFINS"]) == "" )
												$arr_data["PIS_COFINS"] = trim($break04[$k]);
											else
												$arr_data["ICMS"] = trim($break04[$k]);
										}
										//! PERIOD
										else if ( preg_match('/([0-9])\/([0-9])\w+/', $break04[$k]) )
											$arr_data["PERIODO"] = trim($break04[$k]);
										//! DURATION
										else if ( preg_match('/([0-9])m([0-9])\w+/', $break04[$k]) )
											$arr_data["DURACAO"] = trim($break04[$k]);
										//! VOLUME
										else if ( (strpos($break04[$k], "KB") !== false || strpos($break04[$k], "MB") !== false || 
												  strpos($break04[$k], "GB") !== false || strpos($break04[$k], "TB") !== false) && strpos($break04[$k], ",") !== false )
											$arr_data["VOLUME"] = trim($break04[$k]);
										//! Nº DAYS / QUANTITY
										else if ( is_numeric($break04[$k]) )
										{
											if ( strpos($aux_data[0], "N_DIAS") !== false && trim($arr_data["N_DIAS"]) == "" )
												$arr_data["N_DIAS"] = trim($break04[$k]);
											else
												$arr_data["QUANTIDADE"] = trim($break04[$k]);
										}
										//! VALUE
										else if ( preg_match('/(([0-9])+,+([0-9]))/', $break04[$k]) )
											$arr_data["VALOR"] = trim($break04[$k]);
										//! DESCRIPTION
										else
										{
											$arr_data["DESCRICAO"] .= trim($break04[$k]) . " ";
										}
									}

									//! Reverse the description
									$arr_data["DESCRICAO"] = reverse_sentence($arr_data["DESCRICAO"]);

									//! Remove unnecessary characters from description
									if ( substr(trim($arr_data["DESCRICAO"]), -1) == "-" )
									{
										$arr_data["DESCRICAO"] = substr(rtrim(ltrim($arr_data["DESCRICAO"] )), 0, strlen(rtrim(ltrim($arr_data["DESCRICAO"]))) - 1);
									}

									//! Just monthly services will be saved
									if ( strpos($aux_data[1], "MENSALIDADES") !== false )
									{
										//! Storage the service to use later
										$this->arr_service_list[$service_counter] = $arr_data["DESCRICAO"];

										//! Insert the service list in database
										$query = $this->db->insert('pec.servicos', $arr_data);

										//! Check operation
										if ( !$query )
										{
											return false;
										}

										$service_counter++;
									}

									//! Insert the calling type (detailment)
									if ( strpos($aux_data[1], "OUTROS CRÉDITOS/DÉBITOS") === false && strpos($aux_data[1], "MENSALIDADES") === false )
									{
										//! Dummy variable
										$aux_id = 0;

										//$aux_id = $this->checkChamada_PEC(rtrim(ltrim( $arr_data["DESCRICAO"] )));
									}

									//! Clean up array
									$arr_data["VALOR"] = "";
									$arr_data["PIS_COFINS"] = "";
									$arr_data["ICMS"] = "";
									$arr_data["PERIODO"] = "";
									$arr_data["DURACAO"] = "";
									$arr_data["VOLUME"] = "";
									$arr_data["N_DIAS"] = "";
									$arr_data["DESCRICAO"] = "";
								}
							}

							//! Insert the calling type (detailment)
							if ( strpos($aux_data[1], "OUTROS CRÉDITOS/DÉBITOS") === false && strpos($aux_data[1], "MENSALIDADES") === false )
							{
								//! Dummy variable
								$aux_id = 0;

								//! Get the calling type
								$aux_data[1] = remove_accent($aux_data[1]);
								preg_match_all('/(?=[A-Z])([A-Z\s]{10,})/', $aux_data[1], $match_calling_type);

								for ( $z = 0; $z < sizeof($match_calling_type[0]); $z++ )
								{
									//$aux_id = $this->checkLigacao_PEC(rtrim(ltrim($match_calling_type[0][$z])), 0);
								}
							}
						}
					}

					break;
			}

		} //! getServices_PEC

		/*!
		 * Get the phone list from PEC content
		 *
		 * @since 0.1
		 * @access public
		 * @content_ => the content to be analysed
		*/
		public function getPhones_PEC( $content_ )
		{
			//! Set a limit to processing time
			ini_set('MAX_EXECUTION_TIME', -1);

			//! Auxiliary variables
			$str_begin = "";
			$str_end = "";
			$cont_phones = 0;
			//!--------------------
			$arr_phone = array();
			$arr_radio = array();
			$arr_data = array();
			$arr_data["ID_PEC"] = $this->getIdPEC();
			$arr_data["LINHA"] = "";
			$arr_data["ID_RADIO"] = "";

			//! Check the carrier
			switch( strtolower($this->getCarrier()) )
			{
				//! ---------------------------------------------------------------------------
				case "tim":
				//! ---------------------------------------------------------------------------
				//! ---------------------------------------------------------------------------
				case "claro":
				//! ---------------------------------------------------------------------------
				//! ---------------------------------------------------------------------------
				case "vivo":
				//! ---------------------------------------------------------------------------

					//! Define the anchors
					if ( $this->getCarrier() == "vivo" )
						$str_begin = "VEJA O USO DETALHADO DO VIVO ";
					else if ( $this->getCarrier() == "claro" )
						$str_begin = "Detalhamento de ligações e serviços do celular";
					else if ( $this->getCarrier() == "tim" )
						$str_begin = "Detalhamento de Serviços nº:";

					//! Get the necessary content according the limiters 
					$break01 = explode($str_begin, $content_); //! begin

					//! Phone list
					for ( $x = 1; $x < sizeof($break01); $x++ )
					{
						//! Separate de phone number
						if ( $this->getCarrier() == "tim" )
							$arr_phone[$cont_phones] = v_num(substr(trim($break01[$x]), 1, 15));
						else
							$arr_phone[$cont_phones] = v_num(substr(trim($break01[$x]), 0, 15));

						//! Check if the phone number have the 9 digit
						if ( strlen($arr_phone[$cont_phones]) == 10 )
							$arr_phone[$cont_phones] = mask_string("##-####-####", $arr_phone[$cont_phones]);
						else
							$arr_phone[$cont_phones] = mask_string("##-#####-####", $arr_phone[$cont_phones]);

						$cont_phones += 1;
					}

					//! Remove repeated elements
					$arr_phone = array_values(array_unique($arr_phone));

					//! Get the phone number list
					for ( $i = 0; $i < sizeof($arr_phone); $i++ )
					{
						$arr_data["LINHA"] = $arr_phone[$i];

						//! Insert the phone numbers list in database
						$query = $this->db->insert('pec.linhas', $arr_data);

						//! Check operation
						if ( !$query )
						{
							return false;
						}

						$arr_data["LINHA"] = "";
					}

					break;

				//! ---------------------------------------------------------------------------
				case "nextel":
				//! ---------------------------------------------------------------------------

					//! Define the anchors
					$str_begin = "DADOS DO CLIENTE";
					$str_end = "DEMONSTRATIVO DE SERVIÇOS";

					//! Get the necessary content according the limiters 
					$break01 = explode($str_begin, $content_); //! begin

					//! Phone list
					for ( $x = 1; $x < sizeof($break01); $x++ )
					{
						//! Delimit the information block 
						$break02 = explode($str_end, $break01[$x]);

						//! Separate de phone number
						$break03 = explode("TELEFONE:", $break02[0]);
						$arr_phone[$cont_phones] = v_num(substr(trim($break03[1]), 0, 15));

						//! Separate de radio ID
						if ( strpos($break02[0], "URBAN*FLEET*ID:") !== false )
							$break03 = explode("URBAN*FLEET*ID:", $break02[0]);
						else if ( strpos($break02[0], "N° RÁDIO:") !== false )
							$break03 = explode("N° RÁDIO:", $break02[0]);

						$break04 = explode("TELEFONE:", $break03[1]);
						$arr_radio[$cont_phones] = trim($break04[0]);

						//! Check if the phone number have the 9 digit
						if ( strlen($arr_phone[$cont_phones]) == 10 )
							$arr_phone[$cont_phones] = mask_string("##-####-####", $arr_phone[$cont_phones]);
						else
							$arr_phone[$cont_phones] = mask_string("##-#####-####", $arr_phone[$cont_phones]);

						$cont_phones += 1;
					}

					//! Remove repeated elements
					$arr_phone = array_values(array_unique($arr_phone));
					$arr_radio = array_values(array_unique($arr_radio));

					//! Get the phone number list
					for ( $i = 0; $i < sizeof($arr_phone); $i++ )
					{
						$arr_data["LINHA"] = $arr_phone[$i];
						$arr_data["ID_RADIO"] = $arr_radio[$i];

						//! Insert the service list in database
						$query = $this->db->insert('pec.linhas', $arr_data);

						//! Check operation
						if ( !$query )
						{
							return false;
						}

						$arr_data["LINHA"] = "";
						$arr_data["ID_RADIO"] = "";
					}

					break;
			}

		} //! getPhones_PEC

		/*!
		 * Get the others entries from PEC content
		 *
		 * @since 0.1
		 * @access public
		 * @content_ => the content to be analysed
		*/
		public function getOtherEntries_PEC( $content_ )
		{
			//! Set a limit to processing time
			ini_set('MAX_EXECUTION_TIME', -1);

			//! Auxiliary variables
			$str_begin = "";
			$str_end = "";
			$cont_phones = 0;
			//!--------------------
			$arr_entry_type = array();
			$arr_entry_id = array();

			$arr_data = array();
			$arr_data["ID_PEC"] = $this->getIdPEC();

			$arr_data2 = array();
			$arr_data2["ID_PEC"] = $this->getIdPEC();

			//! Regex Money with space => E.g:(64,75 )
			$regex_money = '/([0-9])+,([0-9])+([0-9])\s+/';

			//! Regex Money with R$ => E.g:(R$ 1)
			$regex_money2 = '/R\$+\s+([0-9])/';

			//! Regex Money with R$ => E.g:(R$ 10)
			$regex_money3 = '/R\$+\s+([0-9])\w+/';

			//! Regex Money with R$ => E.g:(R$1)
			$regex_money4 = '/R\$+([0-9])/';

			//! Regex Money with R$ => E.g:(R$10)
			$regex_money5 = '/R\$+([0-9])\w+/';

			//! Regex Money with R$ and decimals => E.g:(R$10,00)
			$regex_money6 = '/R\$+([0-9])\w+,+([0-9])\w/';

			//! Regex Money with R$, decimals and extra numbers => E.g:(R$20,00 00)
			$regex_money7 = '/R\$+([0-9])\w+,+([0-9])+\s+\w+\w/';

			//! Regex phone number => E.g:(22-99787-9542)
			$regex_phone = '/([0-9])+-+([0-9])+-+([0-9])\w+/';

			//! Regex Date => E.g:(24/10/2014)
			$regex_date = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';

			//! Regex Period => E.g:(24/10/14 a 01/11/14)
			$regex_period = '/([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s+a+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s/';

			//! Regex Period => E.g:(24/10/2014 à 01/11/2014)
			$regex_period2 = '/([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+([0-9])\w+\s+à+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+([0-9])\w+\s/';

			//! Check the carrier
			switch( strtolower($this->getCarrier()) )
			{
				//! ---------------------------------------------------------------------------
				case "claro":
				//! ---------------------------------------------------------------------------

					/*
					 * FIRST STEP
					 * Get the entries type and detailment
					*/

					//! Auxiliary variables
					$discount_description = "";

					//! Array containing the itens to be extracted
					$array_entries = array();
					$array_entries[0] = "Juros e Multa";
					$array_entries[1] = "Parcelamento de Aparelho";
					$array_entries[2] = "Descontos";

					//! Define the anchors
					$str_begin = "Veja aqui o que está sendo cobrado";
					$str_end = "Total a Pagar";

					//! Get the necessary content according the limiters 
					$break01 = explode($str_begin, $content_, 2); 	//! begin
					$break02 = explode($str_end, $break01[1]); 		//! end

					//! Get the discount description (very specific case)
					$break_discount = explode("Descontos", $break02[1]);
					$discount_description = $break_discount[(sizeof($break_discount) - 1)];
					$discount_description = explode("R$", $discount_description);
					$discount_description = rtrim(ltrim($discount_description[0]));

					//! Run through itens array
					for ( $i = 0; $i < sizeof($array_entries); $i++ )
					{
						//! Extract the item
						if ( strpos($break02[0], $array_entries[$i]) !== false )
						{
							//! Get just the value
							$break03 = explode($array_entries[$i], $break02[0]);
							$break04 = explode("R$", $break03[1]);
							$break05 = preg_split('/\s+/', rtrim(ltrim($break04[1])));

							//! Prepare the info to save in DB
							$arr_data["DESCRICAO"] = $array_entries[$i];

							//! Insert the entry list in DB
							$query = $this->db->insert('pec.outroslancamentos', $arr_data);

							//! Check if the insertion worked
							if ( $query )
							{
								//! Define the register classification
								if ( strpos(mb_strtoupper($array_entries[$i], 'UTF-8'), "FINANCEIRO") !== false ) 			//!< FINANCEIRO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 2;
								else if ( strpos(mb_strtoupper($array_entries[$i], 'UTF-8'), "JURO") !== false ) 			//!< FINANCEIRO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 2;
								else if ( strpos(mb_strtoupper($array_entries[$i], 'UTF-8'), "CANCELAMENTO") !== false )	//!< CANCELAMENTO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 3;
								else if ( strpos(mb_strtoupper($array_entries[$i], 'UTF-8'), "DESCONTO") !== false )		//!< DESCONTO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 4;
								else if ( strpos(mb_strtoupper($array_entries[$i], 'UTF-8'), "DIVERSO") !== false )			//!< DIVERSOS
									$arr_data2["ID_TIPO_LANCAMENTO"] = 5;
								else if ( strpos(mb_strtoupper($array_entries[$i], 'UTF-8'), "PARCELAMENTO") !== false )	//!< PARCELAMENTO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 6;
								else if ( strpos(mb_strtoupper($array_entries[$i], 'UTF-8'), "CONTESTAÇÃO") !== false )		//!< CONTESTAÇÃO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 7;
								else
									$arr_data2["ID_TIPO_LANCAMENTO"] = 1;						//!< NÃO DEFINIDO

								//!======================================================================================

									/*!
									 * INSERT THE DETAIILMENT
									*/

									//! Check if the item is a discount
									if ( strpos(mb_strtoupper($array_entries[$i], 'UTF-8'), "DESCONTO") !== false )
										$arr_data2["DESCRITIVO"] = $discount_description;
									else
										$arr_data2["DESCRITIVO"] = $arr_data["DESCRICAO"];

									//! Prepare the info to save in DB
									$arr_data2["ID_LANCAMENTO"] = $this->db->last_id;
									$arr_data2["ID_LINHA"] = 0;
									$arr_data2["VALOR"] = $break05[0];

									if ( strpos($arr_data2["VALOR"] , ",") === false )
									{
										$arr_data2["VALOR"] .= ",00";
									}

									//! Insert the entry detail in DB
									$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);

								//!======================================================================================
							}

							//! Clean up the data array
							$arr_data["DESCRICAO"] = "";
							$arr_data2["DESCRITIVO"] = "";
							$arr_data2["ID_LANCAMENTO"] = 0;
							$arr_data2["ID_TIPO_LANCAMENTO"] = 1;
							$arr_data2["ID_LINHA"] = 0;
							$arr_data2["VALOR"] = 0;
						}
					}

					/*
					 * SECOND STEP
					 * Get the roll-over and other entries
					*/

					$arr_data = array();
					$arr_data["ID_PEC"] = $this->getIdPEC();

					//! Array containing the titles
					$array_titles = array();
					$array_titles[0] = "Créditos para chamadas de meses anteriores";
					$array_titles[1] = "Ligações e serviços excedentes";
					$array_titles[2] = "Créditos ou minutos de meses anteriores";
					$array_titles[3] = "Sobra de créditos ou minutos";
					$array_titles[4] = "O que você tem direito no seu plano";
					$array_titles[5] = "Sobra de créditos para chamadas de meses anteriores";
					$array_titles[6] = "O que você usou do seu plano";

					//! Define the anchors
					$str_begin = "/Veja+\s+aqui+\s+os+\s+detalhes+\s+do+\s+seu+\s+plano+\s+e+\s+serviços/";
					$str_begin2 = "/Veja+\s+aqui+\s+o+\s+que+\s+foi+\s+utilizado/";
					$str_end = "Autorização para Débito em Conta";
					$str_end2 = "Regras de Suspensões";

					//! Get the necessary content according the limiters 
					if ( preg_match($str_begin, $content_) )
						$break01 = preg_split($str_begin, $content_, 2); 	//! begin
					else
						$break01 = preg_split($str_begin2, $content_, 2); 	//! begin

					$break02 = explode($str_end, $break01[1]); 		//! end

					//! If it's necessary, remove the suspension rules box
					if ( strpos($break02[0], $str_end2) !== false )
						$break02 = explode($str_end2, $break02[0]);

					//! Run through title array
					for ( $i = 0; $i < sizeof($array_titles); $i++ )
					{
						//! Prepare the info to save in DB
						$arr_data["DESCRICAO"] = $array_titles[$i];
						$arr_data2["ID_TIPO_LANCAMENTO"] = 8;
						$arr_data2["ID_LINHA"] = 0;

						//! Insert the entry list in DB
						$query = $this->db->insert('pec.outroslancamentos', $arr_data);
						$arr_data2["ID_LANCAMENTO"] = $this->db->last_id;

						//! Check if the insertion worked
						if ( $query )
						{
							if ( strpos($break02[0], $array_titles[$i]) !== false )
							{
								$break03 = explode($array_titles[$i], $break02[0], 2);	//!< Info block

								//!======================================================================================

									/*!
									 * PARSE THE HORIZONTAL INFORMATION BLOCK
									*/

									//! Clean the information block
									$break03[1] = str_replace("Valor", "", $break03[1]);
									$break03[1] = str_replace("Utilização", "", $break03[1]);
									$break03[1] = str_replace("Cobrado (R$)", "", $break03[1]);
									$break03[1] = preg_replace('/F+\s+/', "", $break03[1]);

									//! Clean the information block
									for ( $j = 0; $j < sizeof($array_titles); $j++ )
									{
										//! Cannot remove the current item
										if ( $j != $i && $j!= 6 )
											$break03[1] = str_replace($array_titles[$j], "", $break03[1]);
									}

									$break03[1] = ltrim(rtrim($break03[1]));

									//! Deal specifically with each situation
									if ( $i == 0 )		//!< Créditos para chamadas de meses anteriores
									{
										//! Remove the initial "F"
										$break03[1] = substr($break03[1], 2);

										//! Separe the registers
										if ( preg_match('/\s+F/', $break03[1]) )
										{
											//! Get just the info related to the block
											$reg_entry = preg_split('/\s+F/', $break03[1], 2);
											$reg_entry_break = preg_split('/\s+/', rtrim(ltrim($reg_entry[0])));

											//! Separe each register individually
											$reg_entry = explode($reg_entry_break[0], rtrim(ltrim($reg_entry[0])));

											//! Adjust the info
											for ( $k = 0; $k < sizeof($reg_entry); $k++ )
											{
												if ( trim($reg_entry[$k]) != "" )
												{
													$reg_entry[$k] = $reg_entry_break[0] . " " . $reg_entry[$k];

													if ( strpos($reg_entry[$k], "MB") !== false )
													{
														$reg_entry2 = explode("MB", $reg_entry[$k]);
														$reg_entry[$k] = ltrim(rtrim($reg_entry2[0])) . "MB";
													}

													//! Split the information to save in DB
													$reg_entry_aux = preg_split('/\s+/', rtrim(ltrim($reg_entry[$k])));

													//! Prepare the info to save in DB
													$arr_data2["DADOS"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
													$arr_data2["VALOR"] = "0,00";
													$arr_data2["DESCRITIVO"] = "";

													for ( $l = 0; $l < sizeof($reg_entry_aux) - 1; $l++ )
													{
														$arr_data2["DESCRITIVO"] .= $reg_entry_aux[$l] . " ";
													}

													if ( strpos($arr_data2["VALOR"] , ",") === false )
													{
														$arr_data2["VALOR"] .= ",00";
													}

													//! Insert the entry list in DB
													$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);
												}
											}
										}
									}
									else if ( $i == 1 )	//!< Ligações e serviços excedentes
									{
										//! Search terms (if necessary add more)
										$arr_search_terms = array();
										$arr_search_terms[0] = "Ligações";
										$arr_search_terms[1] = "Torpedos";
										$arr_search_terms[2] = "Dados";
										$arr_search_terms[3] = "Outros";

										//! Limit the info block
										$break04 = explode("Total", $break03[1]);

										//! Explode the information with an array
										$break05 = multi_explode($arr_search_terms, $break04[0], true);
										$break06 = array();
										$break07 = array();
										$break08 = array();
										$aux_counter = 1;

										//! Link and clean up each register
										for ( $k = 1; $k < sizeof($break05); $k+=2 )
										{
											//! Link
											$break06[$k] = rtrim(ltrim($break05[$k])) . " " .  rtrim(ltrim($break05[($k+1)]));

											//! Clean
											$break07 = explode(",", $break06[$k], 2);
											$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 2);

											//! Split the information to save in DB
											$reg_entry_aux = preg_split('/\s+/', rtrim(ltrim($break08[$aux_counter])));

											//! Prepare the info to save in DB
											$arr_data2["VALOR"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
											$arr_data2["UTILIZADO"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 2)];
											$arr_data2["DESCRITIVO"] = "";

											for ( $l = 0; $l < sizeof($reg_entry_aux) - 2; $l++ )
											{
												$arr_data2["DESCRITIVO"] .= $reg_entry_aux[$l] . " ";
											}

											if ( strpos($arr_data2["VALOR"] , ",") === false )
											{
												$arr_data2["VALOR"] .= ",00";
											}

											//! Insert the entry list in DB
											$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);

											$aux_counter++;
										}
									}
									else if ( $i == 2 )	//!< Créditos ou minutos de meses anteriores
									{
										//! Search terms (if necessary add more)
										$arr_search_terms = array();
										$arr_search_terms[0] = "Bonus";
										$arr_search_terms[1] = "Consumo";

										//! Fix to get the correct information
										$break03[1] = str_replace("FOutros", "F Outros", $break03[1]);
										$break03[1] = preg_replace('/R\$+\s/', '', $break03[1]);
										$break03[1] = str_replace_nth('FBonus', 'F Bonus', $break03[1], (2 - 1));

										//! Remove the initial "F"
										if ( strpos(substr($break03[1], 0, 1), "F") !== false )
											$break03[1] = substr($break03[1], 2);

										//! Limit the info block
										$break04 = preg_split('/\s+F+\s/', $break03[1], 2);

										//! Ultra mega super specific case (almost never used)
										if ( preg_match('/Dados+\s+\(MB\)+\s+-+\s+\d{3},\d{2}\s+FTorpedos/', $break04[0]) )
										{
											$break04_aux = preg_split('/Dados+\s+\(MB\)+\s+-+\s+\d{3},\d{2}\s+FTorpedos/', $break04[0]);
											$break04[0] = $break04_aux[0];
										}

										//! Explode the information with an array
										$break05 = multi_explode($arr_search_terms, $break04[0], true);
										$break06 = array();
										$break07 = array();
										$break08 = array();
										$aux_counter = 1;
										$repetition_counter = 0;

										//! Link and clean up each register
										for ( $k = 1; $k < sizeof($break05); $k+=2 )
										{
											//! Link
											$break06[$k] = rtrim(ltrim($break05[$k])) . " " .  rtrim(ltrim($break05[($k+1)]));

											//! Clean
											$break07 = explode(",", $break06[$k], 2);
											$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 2);

											//! Count the repetitions to remove later
											if ( strpos($break08[$aux_counter], "Bonus ") !== false )
												$repetition_counter++;

											//! Limit the bonus entries
											if ( $repetition_counter <= 3 )
											{
												//! Split the information to save in DB
												$reg_entry_aux = preg_split('/\s+/', rtrim(ltrim($break08[$aux_counter])));

												//! Prepare the info to save in DB
												$arr_data2["VALOR"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["DESCRITIVO"] = "";

												for ( $l = 0; $l < sizeof($reg_entry_aux) - 1; $l++ )
												{
													$arr_data2["DESCRITIVO"] .= $reg_entry_aux[$l] . " ";
												}

												if ( strpos($arr_data2["VALOR"] , ",") === false )
												{
													$arr_data2["VALOR"] .= ",00";
												}

												//! Insert the entry list in DB
												$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);
											}

											$aux_counter++;
										}
									}
									else if ( $i == 3 )	//!< Sobra de créditos ou minutos
									{
										//! Search terms (if necessary add more)
										$arr_search_terms = array();
										$arr_search_terms[0] = "FBonus";
										$arr_search_terms[1] = "FConsumo";

										//! Fix to get the correct information
										$break03[1] = preg_replace('/Bonus+\s+Intra-Rede+\s+R\$+\s+10.00+\s+R\$+\s+20,00/', 'FBonus Intra-Rede R$ 10.00 R$ 20,00', $break03[1]);
										$break03[1] = str_replace("FF", "F", $break03[1]);
										$break03[1] = preg_replace('/R\$+\s/', '', $break03[1]);

										//! Explode the information with an array
										$break05 = multi_explode($arr_search_terms, $break03[1], true);
										$break06 = array();
										$break07 = array();
										$break08 = array();
										$aux_counter = 1;

										//! Link and clean up each register
										for ( $k = 1; $k < sizeof($break05); $k+=2 )
										{
											//! Link
											$break06[$k] = rtrim(ltrim($break05[$k])) . " " .  rtrim(ltrim($break05[($k+1)]));

											//! Clean
											$break07 = explode(",", $break06[$k], 2);
											$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 2);

											//! Adjust the register
											$break08[$aux_counter] = str_replace("FBonus", "Bonus", $break08[$aux_counter]);
											$break08[$aux_counter] = str_replace("FConsumo", "Consumo", $break08[$aux_counter]);
											
											//! Split the information to save in DB
											$reg_entry_aux = preg_split('/\s+/', rtrim(ltrim($break08[$aux_counter])));

											//! Prepare the info to save in DB
											$arr_data2["VALOR"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
											$arr_data2["DESCRITIVO"] = "";

											for ( $l = 0; $l < sizeof($reg_entry_aux) - 1; $l++ )
											{
												$arr_data2["DESCRITIVO"] .= $reg_entry_aux[$l] . " ";
											}

											if ( strpos($arr_data2["VALOR"] , ",") === false )
											{
												$arr_data2["VALOR"] .= ",00";
											}

											//! Insert the entry list in DB
											$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);

											$aux_counter++;
										}
									}
									else if ( $i == 4 )	//!< O que você tem direito no seu plano
									{
										//! Search terms (if necessary add more)
										$arr_search_terms = array();
										$arr_search_terms[0] = "Bonus";
										$arr_search_terms[1] = "Consumo";
										$arr_search_terms[2] = "Serviço";
										$arr_search_terms[3] = "Pacote";
										$arr_search_terms[4] = "Plano";

										//! Fix to get the correct information
										$break03[1] = preg_replace('/Bonus+\s+Intra-Rede+\s+R\$+\s+10.00+\s+R\$+\s+20,00/', 'FBonus Intra-Rede R$ 10.00 R$ 20,00', $break03[1]);
										$break03[1] = str_replace("FBonus", "", $break03[1]);
										$break03[1] = str_replace("FConsumo", "", $break03[1]);
										$break03[1] = str_replace("FServiço", "", $break03[1]);
										$break03[1] = str_replace("FPacote", "", $break03[1]);
										$break03[1] = str_replace("FPlano", "", $break03[1]);
										$break03[1] = str_replace("Serviços no exterior", "", $break03[1]);
										$break03[1] = str_replace("Serviço s no exterior", "", $break03[1]);
										$break03[1] = str_replace("Outros serviços", "", $break03[1]);
										$break03[1] = preg_replace('/R\$+\s/', '', $break03[1]);

										//! Limit the info block
										$break03[1] = preg_replace('/\s+MB/', 'MB', $break03[1]);
										$break03[1] = preg_replace('/\s+min/', 'min', $break03[1]);
										$break04 = preg_split('/O\s+que\s+você\s+usou\s+do\s+seu\s+plano/', $break03[1], 2);

										//! Explode the information with an array
										$break05 = multi_explode($arr_search_terms, $break04[0], true);
										$break06 = array();
										$break07 = array();
										$break08 = array();
										$aux_counter = 1;

										//! Link and clean up each register
										for ( $k = 1; $k < sizeof($break05); $k+=2 )
										{
											//! Link
											$break06[$k] = rtrim(ltrim($break05[$k])) . " " .  rtrim(ltrim($break05[($k+1)]));

											//! Clean
											$break07 = explode(",", $break06[$k], 2);

											if ( isset($break07[1]) )
											{
												//! Specific for data(MB)
												if ( strpos($break07[1], "MB") !== false )
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 5);
												//! Specific for min
												else if ( strpos($break07[1], "min") !== false )
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 5);
												//! Generic case
												else
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 2);

												//! Remove unnecessary info
												if ( strpos($break08[$aux_counter], "SMS") !== false && strpos($break08[$aux_counter], "Ilimitado") !== false )
												{
													$break08_aux = explode("Ilimitado ", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0];
												}
												else if ( strpos($break08[$aux_counter], "MB") !== false )
												{
													$break08_aux = explode("MB", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0] . "MB";
												}
												else if ( strpos($break08[$aux_counter], "min") !== false )
												{
													$break08_aux = explode("min", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0] . "min";
												}
											}
											else
												$break08[$aux_counter] = $break07[0];

											//! Adjust the register
											$break08[$aux_counter] = str_replace("FBonus", "Bonus", $break08[$aux_counter]);
											$break08[$aux_counter] = str_replace("FConsumo", "Consumo", $break08[$aux_counter]);

											//! Split the information to save in DB
											$break08[$aux_counter] = preg_replace('!\s+!', ' ', $break08[$aux_counter]);
											$reg_entry_aux = preg_split('/\s+/', rtrim(ltrim($break08[$aux_counter])));

											//! Remove the last position (if it's invalid)
											if ( strlen( $reg_entry_aux[(sizeof($reg_entry_aux) - 1)] ) <= 2 )
												unset( $reg_entry_aux[(sizeof($reg_entry_aux) - 1)] );

											//! Prepare the info to save in DB
											if ( strpos($break08[$aux_counter], "SMS") !== false )
											{
												$arr_data2["SMS"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["DADOS"] = "";
											}
											else if ( strpos($break08[$aux_counter], "MB") !== false )
											{
												$arr_data2["DADOS"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["SMS"] = "";
											}
											else if ( strpos($break08[$aux_counter], "min") !== false )
											{
												$arr_data2["UTILIZADO"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["SMS"] = "";
												$arr_data2["DADOS"] = "";
											}
											else
											{
												$arr_data2["VALOR"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["SMS"] = "";
												$arr_data2["DADOS"] = "";
											}
											$arr_data2["DESCRITIVO"] = "";

											for ( $l = 0; $l < sizeof($reg_entry_aux) - 1; $l++ )
											{
												$arr_data2["DESCRITIVO"] .= $reg_entry_aux[$l] . " ";
											}

											if ( strpos($arr_data2["VALOR"] , ",") === false )
											{
												$arr_data2["VALOR"] .= ",00";
											}

											//! Insert the entry list in DB
											$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);

											$aux_counter++;
										}
									}
									else if ( $i == 5 )	//!< Sobra de créditos para chamadas de meses anteriores
									{
										//! Search terms (if necessary add more)
										$arr_search_terms = array();
										$arr_search_terms[0] = "FPacote";

										$break03[1] = preg_replace('/\s+MB/', 'MB', $break03[1]);

										//! Explode the information with an array
										$break05 = multi_explode($arr_search_terms, $break03[1], true);
										$break06 = array();
										$break07 = array();
										$break08 = array();
										$aux_counter = 1;

										//! Link and clean up each register
										for ( $k = 1; $k < sizeof($break05); $k+=2 )
										{
											//! Link
											$break06[$k] = rtrim(ltrim($break05[$k])) . " " .  rtrim(ltrim($break05[($k+1)]));

											//! Clean
											$break07 = explode(",", $break06[$k], 2);
											$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 2);

											if ( isset($break07[1]) )
											{
												//! Specific for data(MB)
												if ( strpos($break07[1], "MB") !== false )
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 5);
												//! Specific for min
												else if ( strpos($break07[1], "min") !== false )
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 5);
												//! Generic case
												else
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 2);

												//! Remove unnecessary info
												if ( strpos($break08[$aux_counter], "SMS") !== false && strpos($break08[$aux_counter], "Ilimitado") !== false )
												{
													$break08_aux = explode("Ilimitado ", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0];
												}
												else if ( strpos($break08[$aux_counter], "MB") !== false )
												{
													$break08_aux = explode("MB", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0] . "MB";
												}
												else if ( strpos($break08[$aux_counter], "min") !== false )
												{
													$break08_aux = explode("min", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0] . "min";
												}
											}
											else
												$break08[$aux_counter] = $break07[0];

											//! Adjust the register
											$break08[$aux_counter] = str_replace("FPacote", "Pacote", $break08[$aux_counter]);
											
											//! Split the information to save in DB
											$reg_entry_aux = preg_split('/\s+/', rtrim(ltrim($break08[$aux_counter])));

											//! Prepare the info to save in DB
											if ( strpos($break08[$aux_counter], "SMS") !== false )
											{
												$arr_data2["SMS"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["DADOS"] = "";
											}
											else if ( strpos($break08[$aux_counter], "MB") !== false )
											{
												$arr_data2["DADOS"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["SMS"] = "";
											}
											else if ( strpos($break08[$aux_counter], "min") !== false )
											{
												$arr_data2["UTILIZADO"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["SMS"] = "";
												$arr_data2["DADOS"] = "";
											}
											else
											{
												$arr_data2["VALOR"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["SMS"] = "";
												$arr_data2["DADOS"] = "";
											}
											$arr_data2["DESCRITIVO"] = "";

											for ( $l = 0; $l < sizeof($reg_entry_aux) - 1; $l++ )
											{
												$arr_data2["DESCRITIVO"] .= $reg_entry_aux[$l] . " ";
											}

											if ( strpos($arr_data2["VALOR"] , ",") === false )
											{
												$arr_data2["VALOR"] .= ",00";
											}

											//! Insert the entry list in DB
											$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);

											$aux_counter++;
										}
									}
									else if ( $i == 6 )	//!< O que você usou do seu plano
									{
										//! Search terms (if necessary add more)
										$arr_search_terms = array();
										$arr_search_terms[0] = "Bonus";
										$arr_search_terms[1] = "Consumo";
										$arr_search_terms[2] = "Ligações";
										$arr_search_terms[3] = "Serviço Tarifa";
										$arr_search_terms[4] = "Pacote";
										$arr_search_terms[5] = "Plano";
										$arr_search_terms[6] = "Outros Serviços";
										$arr_search_terms[7] = "Interurbanas e Rec.";
										$arr_search_terms[8] = "Dados";
										$arr_search_terms[9] = "Torpedos";

										//! Fix to get the correct information
										$break03[1] = str_replace("FBonus", "", $break03[1]);
										$break03[1] = str_replace("FConsumo", "", $break03[1]);
										$break03[1] = str_replace("FServiço", "", $break03[1]);
										$break03[1] = str_replace("FPacote", "", $break03[1]);
										$break03[1] = str_replace("FPlano", "", $break03[1]);
										$break03[1] = str_replace("(MB)", "", $break03[1]);
										$break03[1] = preg_replace('/\s+MB/', 'MB', $break03[1]);
										$break03[1] = preg_replace('/\s+min/', 'min', $break03[1]);
										$break03[1] = preg_replace('/R\$+\s/', '', $break03[1]);

										//! Explode the information with an array
										$break05 = multi_explode($arr_search_terms, $break03[1], true);
										$break06 = array();
										$break07 = array();
										$break08 = array();
										$aux_counter = 1;

										//! Link and clean up each register
										for ( $k = 1; $k < sizeof($break05); $k+=2 )
										{
											//! Link
											$break06[$k] = rtrim(ltrim($break05[$k])) . " " .  rtrim(ltrim($break05[($k+1)]));

											//! Clean
											$break07 = explode(",", $break06[$k], 2);

											if ( isset($break07[1]) )
											{
												//! Specific for data(MB)
												if ( strpos($break07[1], "MB") !== false )
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 5);
												//! Specific for min
												else if ( strpos($break07[1], "min") !== false )
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 5);
												//! Generic case
												else
													$break08[$aux_counter] = $break07[0] . "," . substr($break07[1], 0, 2);

												//! Remove unnecessary info
												if ( strpos($break08[$aux_counter], "SMS") !== false && strpos($break08[$aux_counter], "Ilimitado") !== false )
												{
													$break08_aux = explode("Ilimitado ", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0];
												}
												else if ( strpos($break08[$aux_counter], "MB") !== false )
												{
													$break08_aux = explode("MB", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0] . "MB";
												}
												else if ( strpos($break08[$aux_counter], "min") !== false )
												{
													$break08_aux = explode("min", $break08[$aux_counter]);
													$break08[$aux_counter] = $break08_aux[0] . "min";
												}
											}
											else
												$break08[$aux_counter] = $break07[0];

											//! Adjust the register
											$break08[$aux_counter] = str_replace("FBonus", "Bonus", $break08[$aux_counter]);
											$break08[$aux_counter] = str_replace("FConsumo", "Consumo", $break08[$aux_counter]);
											$break08[$aux_counter] = str_replace("Dados", "Dados (MB)", $break08[$aux_counter]);
											
											//! Split the information to save in DB
											$reg_entry_aux = preg_split('/\s+/', rtrim(ltrim($break08[$aux_counter])));

											//! Prepare the info to save in DB
											if ( strpos($break08[$aux_counter], "Torpedos") !== false && strpos($break08[$aux_counter], ",") === false )
											{
												$arr_data2["SMS"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["DADOS"] = "";
											}
											else if ( strpos($break08[$aux_counter], "Dados (MB)") !== false )
											{
												$arr_data2["VALOR"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["SMS"] = "";
												$arr_data2["DADOS"] = "";
											}
											else if ( strpos($break08[$aux_counter], "SMS") !== false )
											{
												$arr_data2["SMS"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["DADOS"] = "";
											}
											else if ( strpos($break08[$aux_counter], "MB") !== false )
											{
												$arr_data2["DADOS"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["SMS"] = "";
											}
											else if ( strpos($break08[$aux_counter], "min") !== false )
											{
												$arr_data2["UTILIZADO"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["VALOR"] = "0,00";
												$arr_data2["SMS"] = "";
												$arr_data2["DADOS"] = "";
											}
											else
											{
												$arr_data2["VALOR"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
												$arr_data2["UTILIZADO"] = "";
												$arr_data2["SMS"] = "";
												$arr_data2["DADOS"] = "";
											}
											$arr_data2["DESCRITIVO"] = "";

											for ( $l = 0; $l < sizeof($reg_entry_aux) - 1; $l++ )
											{
												$arr_data2["DESCRITIVO"] .= $reg_entry_aux[$l] . " ";
											}

											if ( strpos($arr_data2["VALOR"] , ",") === false )
											{
												$arr_data2["VALOR"] .= ",00";
											}

											//! Insert the entry list in DB
											$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);

											$aux_counter++;
										}
									}

								//!======================================================================================
							}
						}

						//! Clean up the data array
						$arr_data["DESCRICAO"] = "";
						$arr_data2["DESCRITIVO"] = "";
						$arr_data2["ID_LANCAMENTO"] = 0;
						$arr_data2["ID_TIPO_LANCAMENTO"] = 1;
						$arr_data2["ID_LINHA"] = 0;
						$arr_data2["UTILIZADO"] = "";
						$arr_data2["DADOS"] = "";
						$arr_data2["SMS"] = "";
						$arr_data2["VALOR"] = 0;
					}

					break;

				//! ---------------------------------------------------------------------------
				case "vivo":
				//! ---------------------------------------------------------------------------

					/*
					 * FIRST STEP
					 * Get the entries type
					*/

					//! Define the anchors
					$str_begin = "Outros Lançamentos";
					$str_end = "Subtotal";

					//! Get the necessary content according the limiters
					if ( strpos($content_, "Outros Lançamentos") !== false )
						$break01 = explode($str_begin, $content_); //! begin
					else
						return;

					//! Delimit the information block 
					$break02 = explode($str_end, $break01[1]);

					//! Remove the header and get just the entires list
					if ( strpos($break02[0], "Plano/Pacote") !== false )
					{
						$break03 = explode("Plano/Pacote", $break02[0]);
						$break03 = $break03[(sizeof($break03) - 1)];
					}

					//! Split the entry type
					$break04 = preg_split($regex_money, $break03);

					//! Entry list
					for( $i = 0; $i < (sizeof($break04) - 1); $i++ )
					{
						//! Remove the unnecessary characters from entry list
						$arr_data["DESCRICAO"] = rtrim(ltrim( substr($break04[$i], 0, (strlen($break04[$i]) - 2)) ));

						//! Remove hifen
						if ( substr($arr_data["DESCRICAO"], -1) == "-" )
							$arr_data["DESCRICAO"] = rtrim(ltrim( substr($arr_data["DESCRICAO"], 0, (strlen($arr_data["DESCRICAO"]) - 2)) ));

						//! Check if the description brings something unnecessary
						if ( is_numeric( substr($arr_data["DESCRICAO"], -1) ) )
							$arr_data["DESCRICAO"] = substr($arr_data["DESCRICAO"], 0, (strlen($arr_data["DESCRICAO"]) - 2));

						//! Fill the entry list array
						$arr_entry_type[$i] = $arr_data["DESCRICAO"];

						//! Insert the entry list in database
						$query = $this->db->insert('pec.outroslancamentos', $arr_data);
						$arr_entry_id[$i] = $this->db->last_id;

						$arr_data["DESCRICAO"] = "";
					}

					if ( strpos($content_, "CANCELAMENTO DE CONTRATO") !== false )
					{
						$arr_entry_type[(sizeof($break04) - 1)] = "Cancelamento de Contrato";

						//! Fill the entry list array
						$arr_data["DESCRICAO"] = $arr_entry_type[(sizeof($break04) - 1)] ;

						//! Insert the entry list in database
						$query = $this->db->insert('pec.outroslancamentos', $arr_data);
						$arr_entry_id[(sizeof($break04) - 1)] = $this->db->last_id;
					}

					/*
					 * SECOND STEP
					 * Get the entries type
					*/

					$arr_data = array();
					$arr_data["ID_PEC"] = $this->getIdPEC();

					// Define the anchors
					$str_begin = "OUTROS LANÇAMENTOS";
					$str_end = "TOTAL DE OUTROS LANÇAMENTOS";

					//! Get the necessary content according the limiters 
					$break01 = explode($str_begin, $content_, 2); //! begin

					//! Delimit the information block 
					$break02 = explode($str_end, $break01[1]);

					//! Entry list
					for( $i = 0; $i < sizeof($arr_entry_type); $i++ )
					{
						//! Adjust the term
						if ( $arr_entry_type[$i] == "Descontos/Promoções" )
							$arr_entry_type[$i] = "Descontos e Promoções";
						else if ( strpos($arr_entry_type[$i], "Descontos/Promoções") !== false )
							$arr_entry_type[$i] = "Descontos e Promoções";
						else if ( strpos($arr_entry_type[$i], "Diversos (Crédito ou Débito)") !== false )
							$arr_entry_type[$i] = "Diversos (Créditos e Débitos)";
						else if ( strpos($arr_entry_type[$i], "Parcelamento") !== false )
							$arr_entry_type[$i] = "Parcelamentos";

						//! Break the info by entry type
						$break03 = explode(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), $break02[0]);

						//! Run through the entry info block
						for( $j = 1; $j < sizeof($break03); $j++ )
						{
							$break04 = explode("Subtotal", $break03[$j]);

							//! Divide the data block into registers
							$registers = explode(",", $break04[0]);
							$registers_coluna = "";

							//! Run trough call type
							for ( $k = 0; $k < ( sizeof($registers) - 1 ); $k++ )
							{
								$jump_reg = 0;

								//! Add value
								if ( isset($registers[($k+1)]) )
									$registers[$k] .= "," . substr($registers[($k+1)], 0, 2);

								//! Remove some characters
								if ( $k != 0 )
									$registers[$k] = substr($registers[$k], 2);

								//! Specific case "DESCONTO VIVO INTERNET"
								if ( strpos($registers[$k], "DESCONTO VIVO INTERNET") !== false )
								{
									if ( isset($registers[($k+1)]) )
									{
										$registers[$k] .= " " . $registers[($k+1)];
										$jump_reg = 1;
									}
								}

								//! Get the columns
								if ( $k == 0 )
								{
									if ( strpos($registers[$k], "Valor Total R$") !== false )
										$aux_registers = explode("Valor Total R$", $registers[$k]);
									else if ( strpos($registers[$k], "Total R$") !== false )
										$aux_registers = explode("Total R$", $registers[$k]);
									else if ( strpos($registers[$k], "Valor R$") !== false )
										$aux_registers = explode("Valor R$", $registers[$k]);
									else if ( strpos($registers[$k], "Desconto do Número") !== false )
										$aux_registers = explode("Desconto do Número", $registers[$k]);

									if ( trim($aux_registers[0]) != "" )
										$registers_coluna = $aux_registers[0] . " VALOR";
									else
										$registers_coluna = "DESCRITIVO VALOR";

									$registers[$k] = rtrim(ltrim( $aux_registers[1] ));

									//! Adjust the colunms
									$registers_coluna = str_replace("Desconto do Número", "DESCRITIVO", $registers_coluna);
									$registers_coluna = str_replace("Período", "PERIODO", $registers_coluna);
									$registers_coluna = str_replace("Descrição", "DESCRITIVO", $registers_coluna);
									$registers_coluna = str_replace("Parcela", "PERIODO", $registers_coluna);
									$registers_coluna = str_replace("Data do Pagamento", "DATA_PAGAMENTO", $registers_coluna);
									$registers_coluna = str_replace("Data do Crédito", "DATA_CREDITO", $registers_coluna);
									$registers_coluna = str_replace("Referência", "PERIODO", $registers_coluna);
								}

								//! Adjust the registers
								$registers[$k] = preg_replace('/\s+a\s+/', '_a_', $registers[$k]);

								//! Break the register by space
								$reg_item = preg_split('/\s+/', rtrim(ltrim($registers[$k])));
								$reg_column = preg_split('/\s+/', rtrim(ltrim($registers_coluna)));
								$count_column = sizeof($reg_column);
								$count_item = sizeof($reg_item);
								
								//!======================================================================================

									/*!
									 * PREPARE THE DATE TO SEND TO DATABASE
									*/

									//! Define the register classification
									if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "FINANCEIRO") !== false ) 			//!< FINANCEIRO
										$arr_data["ID_TIPO_LANCAMENTO"] = 2;
									else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "CANCELAMENTO") !== false )	//!< CANCELAMENTO
										$arr_data["ID_TIPO_LANCAMENTO"] = 3;
									else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "DESCONTO") !== false )		//!< DESCONTO
										$arr_data["ID_TIPO_LANCAMENTO"] = 4;
									else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "DIVERSO") !== false )			//!< DIVERSOS
										$arr_data["ID_TIPO_LANCAMENTO"] = 5;
									else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "PARCELAMENTO") !== false )	//!< PARCELAMENTO
										$arr_data["ID_TIPO_LANCAMENTO"] = 6;
									else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "CONTESTAÇÃO") !== false )		//!< CONTESTAÇÃO
										$arr_data["ID_TIPO_LANCAMENTO"] = 7;
									else
										$arr_data["ID_TIPO_LANCAMENTO"] = 1;						//!< NÃO DEFINIDO

									//! Fill all the columns except description
									$counter = 1;
									for ( $l = ($count_column - 1); $l >= 1; $l-- )
									{
										$arr_data[rtrim(ltrim( $reg_column[($l)] ))] = $reg_item[($count_item - $counter)];
										$counter++;
									}

									//! Description column
									$arr_data["DESCRITIVO"] = "";
									for ( $l = 0; $l <= ($count_item - $count_column); $l++ )
									{
										$arr_data["DESCRITIVO"] .= " " . $reg_item[$l];
										$counter++;
									}
									$arr_data["DESCRITIVO"] = rtrim(ltrim($arr_data["DESCRITIVO"]));

									//! Remove unnecessary from description
									if ( preg_match($regex_money7, $arr_data["DESCRITIVO"]) )
										$arr_data["DESCRITIVO"] = preg_replace($regex_money7, '', $arr_data["DESCRITIVO"]);
									else if ( preg_match($regex_money6, $arr_data["DESCRITIVO"]) )
										$arr_data["DESCRITIVO"] = preg_replace($regex_money6, '', $arr_data["DESCRITIVO"]);
									else if ( preg_match($regex_money5, $arr_data["DESCRITIVO"]) )
										$arr_data["DESCRITIVO"] = preg_replace($regex_money5, '', $arr_data["DESCRITIVO"]);
									else if ( preg_match($regex_money4, $arr_data["DESCRITIVO"]) )
										$arr_data["DESCRITIVO"] = preg_replace($regex_money4, '', $arr_data["DESCRITIVO"]);
									else if ( preg_match($regex_money3, $arr_data["DESCRITIVO"]) )
										$arr_data["DESCRITIVO"] = preg_replace($regex_money3, '', $arr_data["DESCRITIVO"]);
									else if ( preg_match($regex_money2, $arr_data["DESCRITIVO"]) )
										$arr_data["DESCRITIVO"] = preg_replace($regex_money2, '', $arr_data["DESCRITIVO"]);

									//! Specific case "INTERNET"
									if ( strpos($arr_data["DESCRITIVO"], "INTERNET") !== false )
									{
										$arr_data["DESCRITIVO"] = str_replace("INTERNET", "", $arr_data["DESCRITIVO"]);
										$arr_data["TIPO"] = "INTERNET";
									}

									//! Remove double spaces
									$arr_data["DESCRITIVO"] = preg_replace('!\s+!', ' ', $arr_data["DESCRITIVO"]);

									//! Check the phone number
									if ( preg_match($regex_phone, $arr_data["DESCRITIVO"]) )
									{
										$aux_phone = preg_split('/\s+/', rtrim(ltrim($arr_data["DESCRITIVO"])));
										$aux_phone = $aux_phone[(sizeof($aux_phone) - 1)];
										$arr_data["DESCRITIVO"] = str_replace($aux_phone, "", $arr_data["DESCRITIVO"]);

										$arr_data["ID_LINHA"] = $this->getPhoneID($aux_phone, false);
										$arr_data2["ID_LINHA"] = $this->getPhoneID($aux_phone, false);
									}
									else
									{
										$arr_data["ID_LINHA"] = 0;
										$arr_data2["ID_LINHA"] = 0;
									}

									//! Prepare to inser LANCAMENTO X LINHA
									$arr_data["ID_LANCAMENTO"] = $arr_entry_id[$i];
									$arr_data2["ID_OUTRO_LANCAMENTO"] = $arr_entry_id[$i];

									//! Insert the entry x phone
									$query = $this->db->insert('pec.outrolancamentolinha', $arr_data2);

									//! Check operation
									if ( $query )
									{
										//! Insert the entry detailment
										$query = $this->db->insert('pec.outroslancamentosdet', $arr_data);
									}

								//!======================================================================================

								if ( $jump_reg == 1 )
									$k++;

								//! Clean up the data array
								$arr_data["ID_LINHA"] = "";
								$arr_data["DESCRITIVO"] = "";
								$arr_data["PERIODO"] = "";
								$arr_data["TIPO"] = "";
								$arr_data["DATA_PAGAMENTO"] = "";
								$arr_data["DATA_CREDITO"] = "";
								$arr_data["VALOR"] = "";
								$arr_data["ID_LANCAMENTO"] = "";
								$arr_data["ID_TIPO_LANCAMENTO"] = 1;
								$arr_data2["ID_OUTRO_LANCAMENTO"] = "";
								$arr_data2["ID_LINHA"] = "";
							}
						}
					}

					break;

				//! ---------------------------------------------------------------------------
				case "nextel":
				//! ---------------------------------------------------------------------------

					//! Select the number list
					$query = $this->db->query('SELECT `ID_PEC_LINHA`, `LINHA` FROM `pec.linhas` WHERE `ID_PEC` = ' . $arr_data["ID_PEC"] . ' AND `DATA_FECHA` IS NULL');

					//! Check if query worked
					if ( $query )
					{
						//! Pass the information from database to array
						$arr_phone = $query->fetchAll();
					}
					else
					{
						return false;
					}

					/*
					 * FIRST STEP
					 * Get the device rent
					*/

					//! Save the information header
					$arr_data["DESCRICAO"] = "Locação de Aparelhos";

					//! Insert the entry list in database
					$query = $this->db->insert('pec.outroslancamentos', $arr_data);

					//! If the operation worked
					if ( $query )
					{
						$arr_data2["ID_LANCAMENTO"] = $this->db->last_id;

						//! Run through all phone numbers section
						foreach ( $arr_phone as $value )
						{
							if ( strlen(v_num($value[1])) == 10 )
							{
								$value[1] = mask_string("##-########", v_num($value[1]));
								$value[2] = mask_string("##-####-####", v_num($value[1]));
							}
							else
							{
								$value[1] = mask_string("##-#########", v_num($value[1]));
								$value[2] = mask_string("##-#####-####", v_num($value[1]));
							}

							//! Separate the information block by phone number
							$break01 = preg_split('/TELEFONE:+\s+' . $value[1] . '/', $content_); //! phone divider
							$content_block = "";

							//! Fill the detail block
							for ( $x = 1; $x < (sizeof($break01)); $x++ )
							{
								//! Check last position
								if ( $x == (sizeof($break01) - 1) && strpos($break01[$x], "DETALHAMENTO DE SERVIÇOS") !== false )
								{
									//! Split information from different phone numbers
									$aux_block = explode("DADOS DO CLIENTE", $break01[$x]);
									$content_block .= $aux_block[0];
								}
								else
								{
									$content_block .= $break01[$x];
								}
							}

							//! Define the anchors
							$str_begin = "O QUE FOI CONTRATADO";
							$str_begin2 = "/DEMONSTRATIVO+\s+DE+\s+SERVIÇOS/";
							$str_end = "Total do Nº:";

							//! Get the necessary part of the information block
							if ( strpos($content_block, $str_begin) !== false )
								$break02 = explode($str_begin, $content_block, 2);		//! begin
							else
								$break02 = preg_split($str_begin2, $content_block, 2);	//! begin

							$break03 = explode($str_end, $break02[1]);				//! end

							//! Select just de device renting section
							if ( strpos($break03[0], "Locação de Aparelhos") !== false )
							{
								//! Prepare the info to save in database
								$arr_data2["ID_TIPO_LANCAMENTO"] = 10;
								$arr_data2["ID_LINHA"] = $this->getPhoneID($value[2], false);

								//! Limit the renting block
								$break04 = explode("Locação", $break03[0], 2);
								$break05 = explode("Subtotal", "Locação " . $break04[1]);

								$registers = explode(",", $break05[0]);

								//! Run trough call type
								for ( $j = 0; $j < ( sizeof($registers) - 1 ); $j++ )
								{
									//! Add value
									if ( isset($registers[($j+1)]) )
										$registers[$j] .= "," . substr($registers[($j+1)], 0, 2);

									//! Remove some characters
									if ( $j != 0 )
										$registers[$j] = substr($registers[$j], 2);

									//! PERIOD
									if ( preg_match_all($regex_period, $registers[$j], $match_period) )
									{
										$reg_entry_aux = explode($match_period[0][0], $registers[$j]);
										$arr_data2["PERIODO"] = $match_period[0][0];
									}
									else if ( preg_match_all($regex_period2, $registers[$j], $match_period) )
									{
										$reg_entry_aux = explode($match_period[0][0], $registers[$j]);
										$arr_data2["PERIODO"] = $match_period[0][0];
									}

									//! Split the information to get the others field
									$reg_entry_aux2 = preg_split('/\s+/', rtrim(ltrim($reg_entry_aux[1])));

									//! Prepare the info to save in DB
									$arr_data2["VALOR"] = $reg_entry_aux2[(sizeof($reg_entry_aux2) - 1)];
									$arr_data2["DESCRITIVO"] = "";

									for ( $l = 0; $l < sizeof($reg_entry_aux2) - 1; $l++ )
									{
										$arr_data2["DESCRITIVO"] .= $reg_entry_aux2[$l] . " ";
									}

									if ( strpos($arr_data2["VALOR"] , ",") === false )
									{
										$arr_data2["VALOR"] .= ",00";
									}

									//! Insert the entry list in DB
									$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);
								}

								//! Clean up the data array
								$arr_data2["DESCRITIVO"] = "";
								$arr_data2["PERIODO"] = "";
								$arr_data2["VALOR"] = 0;
								$arr_data2["ID_LINHA"] = "";
							}
						}
					}

					/*
					 * SECOND STEP
					 * Get the entries type
					*/

					//! Search terms (if necessary add more)
					$arr_search_terms = array();
					$arr_search_terms[0] = "Nota";
					$arr_search_terms[1] = "Equipamentos, Acessórios";
					$arr_search_terms[2] = "Créditos";
					$arr_search_terms[3] = "Juros";

					//! Define the anchors
					$str_begin = "Outros Lançamentos em Sua Fatura";
					$str_begin2 = "OUTROS LANÇAMENTOS";
					$str_end = "SUBTOTAL";
					$str_end2 = "";

					//! Get the necessary content according the limiters
					if ( strpos($content_, $str_begin) !== false )
						$break01 = explode($str_begin, $content_); 		//! begin
					else
						$break01 = explode($str_begin2, $content_); 	//! begin

					if ( isset($break01[1]) )
					{
						//! Delimit the information block 
						$break02 = explode($str_end, $break01[1], 2);		//! end

						//! Split the entry type
						$break04 = preg_split($regex_money, $break02[0]);

						//! Entry list
						for( $i = 0; $i < (sizeof($break04) - 1); $i++ )
						{
							//! Remove the unnecessary characters from entry list
							$arr_data["DESCRICAO"] = rtrim(ltrim( substr($break04[$i], 0, (strlen($break04[$i]) - 2)) ));

							//! Remove hifen
							if ( substr($arr_data["DESCRICAO"], -1) == "-" )
								$arr_data["DESCRICAO"] = rtrim(ltrim( substr($arr_data["DESCRICAO"], 0, (strlen($arr_data["DESCRICAO"]) - 2)) ));

							//! Fix the description
							if ( strpos($arr_data["DESCRICAO"], "Equipamentos") !== false )
								$arr_data["DESCRICAO"] = "Equipamentos, Acessórios e Reparos";
							else if ( strpos($arr_data["DESCRICAO"], "Juros") !== false )
								$arr_data["DESCRICAO"] = "Juros, Multas e Ajustes";
							else if ( strpos($arr_data["DESCRICAO"], "Nota") !== false )
								$arr_data["DESCRICAO"] = "Nota de Débito e Multa Contratual";
							else if ( strpos($arr_data["DESCRICAO"], "Créditos") !== false )
								$arr_data["DESCRICAO"] = "Créditos";

							//! Fill the entry list array
							$arr_entry_type[$i] = $arr_data["DESCRICAO"];

							//! Insert the entry list in database
							$query = $this->db->insert('pec.outroslancamentos', $arr_data);
							$arr_entry_id[$i] = $this->db->last_id;

							$arr_data["DESCRICAO"] = "";
						}

						/*
						 * THIRD STEP
						 * Get the entries detailment
						*/

						$arr_data = array();
						$arr_data2 = array();
						$arr_data2["ID_PEC"] = $this->getIdPEC();

						//! Entry list
						for( $i = 0; $i < sizeof($arr_entry_type); $i++ )
						{
							if ( isset($arr_entry_type[$i]) && $arr_entry_type[$i] != "" )
							{
								//! Get the necessary content according the limiters
								if ( strpos($break02[1], $arr_entry_type[$i]) !== false )
									$break01_detail = explode($arr_entry_type[$i], $break02[1], 2); //! begin
								else if ( strpos($break02[1], mb_strtoupper($arr_entry_type[$i], 'UTF-8')) !== false )
									$break01_detail = explode(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), $break02[1], 2); //! begin
								else
									$break01_detail = explode(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), $content_); //! begin

								//! Delimit the information block 
								$break02_detail = explode("SubTotal", $break01_detail[1]);	//! end

								//! Define the register classification
								if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "NOTA") !== false 
									 || strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "JUROS") !== false
									 || strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "MULTA") !== false ) 			//!< FINANCEIRO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 2;
								else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "CANCELAMENTO") !== false )	//!< CANCELAMENTO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 3;
								else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "DESCONTO") !== false )		//!< DESCONTO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 4;
								else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "DIVERSO") !== false 
									 || strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "CRÉDITO") !== false)			//!< DIVERSOS
									$arr_data2["ID_TIPO_LANCAMENTO"] = 5;
								else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "PARCELAMENTO") !== false )	//!< PARCELAMENTO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 6;
								else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "CONTESTAÇÃO") !== false )	//!< CONTESTAÇÃO
									$arr_data2["ID_TIPO_LANCAMENTO"] = 7;
								else if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "EQUIPAMENTO") !== false )	//!< EQUIPAMENTOS
									$arr_data2["ID_TIPO_LANCAMENTO"] = 9;
								else
									$arr_data2["ID_TIPO_LANCAMENTO"] = 1;													//!< NÃO DEFINIDO

								//! Prepare information to insert in database
								$arr_data2["ID_LANCAMENTO"] = $arr_entry_id[$i];

								//! Organize the information
								if ( strpos(mb_strtoupper($arr_entry_type[$i], 'UTF-8'), "EQUIPAMENTOS") === false ) //!< All cases except Equipamentos, Acessórios e Reparos
								{
									//! Divide the data section into registers
									$aux_data = explode("(R$)", $break02_detail[0]);
									$registers = explode(",", $aux_data[(sizeof($aux_data) - 1)]);

									//! Run trough call type
									for ( $j = 0; $j < ( sizeof($registers) - 1 ); $j++ )
									{
										//! Add value
										if ( isset($registers[($j+1)]) )
											$registers[$j] .= "," . substr($registers[($j+1)], 0, 2);

										//! Remove some characters
										if ( $j != 0 )
											$registers[$j] = substr($registers[$j], 2);

										//! Split the information to save in DB
										$reg_entry_aux = preg_split('/\s+/', rtrim(ltrim($registers[$j])));

										$arr_data2["VALOR"] = $reg_entry_aux[(sizeof($reg_entry_aux) - 1)];
										$arr_data2["PERIODO"] = $reg_entry_aux[0];
										$arr_data2["DESCRITIVO"] = "";

										for ( $l = 1; $l < sizeof($reg_entry_aux) - 1; $l++ )
										{
											$arr_data2["DESCRITIVO"] .= $reg_entry_aux[$l] . " ";
										}

										if ( strpos($arr_data2["VALOR"] , ",") === false )
										{
											$arr_data2["VALOR"] .= ",00";
										}

										//! Insert the entry detailment
										$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);
									}
								}
								else //!< Case Equipamentos, Acessórios e Reparos
								{
									$column_counter = 0;
									$arr_column_list = array();
									$arr_column_list[0] = "DATA";
									$arr_column_list[1] = "N_SOLICITACAO";
									$arr_column_list[2] = "NOTA_FISCAL";
									$arr_column_list[3] = "VALOR";
									$arr_column_list[4] = "VALOR_DESCONTO";
									$arr_column_list[5] = "VALOR_TOTAL";
									$arr_column_list[6] = "PARCELA";
									$arr_column_list[7] = "VALOR_PARCELA";

									//! Get all registers
									if ( preg_match_all($regex_date, $break02_detail[0], $match_value) )
									{
										//! Divide the data section into registers
										$break03 = preg_split($regex_date, $break02_detail[0]);

										//! Run trough each complete register
										for ( $j = 1; $j < sizeof($break03); $j++ )
										{
											//! Fix do LOCAL field
											$break03[$j] = preg_replace('/\s+VENDAVEL/', "_VENDAVEL", $break03[$j]);

											//! Add the first field
											$break03[$j] = trim($match_value[0][($j - 1)]) . " " . $break03[$j];

											//! Get IMEI SIM
											if ( preg_match_all('/([0-9]){20}/', $break03[$j], $match_imei_sim) )
											{
												//! Save the IMEI SIM
												$arr_data2["IMEI_SIM"] = "";
												for ( $k = 0; $k < sizeof($match_imei_sim[0]); $k++ )
												{
													$arr_data2["IMEI_SIM"] .= $match_imei_sim[0][$k] . "//";
													$break03[$j] = str_replace($match_imei_sim[0][$k], "", $break03[$j]);
												}
											}

											//! Get IMEI DEVICE
											if ( preg_match_all('/([0-9]){15}/', $break03[$j], $match_imei_device) )
											{
												//! Save the IMEI SIM
												$arr_data2["IMEI_APARELHO"] = "";
												for ( $k = 0; $k < sizeof($match_imei_device[0]); $k++ )
												{
													$arr_data2["IMEI_APARELHO"] .= $match_imei_device[0][$k] . "//";
													$break03[$j] = str_replace($match_imei_device[0][$k], "", $break03[$j]);
												}
											}

											//! Split the block to get the others info
											$break04 = preg_split('/\s+/', rtrim(ltrim($break03[$j])));

											//! Run trough each part to complete the info
											$arr_data2["DESCRITIVO"] = "";
											for ( $l = 0; $l < sizeof($break04); $l++ )
											{
												//! Check if the info is part of description or a value (warning $l == 2 inconsistent)
												if ( !is_numeric( str_replace(",", "", v_num($break04[$l])) ) || $l == 2 ) //! PART OF DESCRIPTION
												{
													$arr_data2["DESCRITIVO"] .= $break04[$l] . " ";
												}
												else if ( strpos($break04[$l], "VENDAVEL") !== false ) //! LOCAL
												{
													$arr_data2["LOCAL"] = $break04[$l];
												}
												else //! VALUE
												{
													if ( isset($arr_column_list[$column_counter]) )
														$arr_data2[ $arr_column_list[$column_counter] ] = $break04[$l];

													$column_counter++;
												}
											}

											//! Fix the value sequence (Value -> Total value -> Installment value)
											$aux_value = 0;
											$aux_value = $arr_data2["VALOR"];
											$arr_data2["VALOR"] = $arr_data2["VALOR_TOTAL"];
											$arr_data2["VALOR_TOTAL"] = $aux_value;
											$aux_value = $arr_data2["VALOR"];
											$arr_data2["VALOR"] = $arr_data2["VALOR_PARCELA"];
											$arr_data2["VALOR_PARCELA"] = $aux_value;

											if ( strpos($arr_data2["VALOR"] , ",") === false )
											{
												$arr_data2["VALOR"] .= ",00";
											}

											//! Insert the entry detailment
											$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);
										}
									}
								}
							}

							//! Clean up the data array
							$arr_data2["DATA"] = "";
							$arr_data2["DESCRITIVO"] = "";
							$arr_data2["PERIODO"] = "";
							$arr_data2["VALOR"] = 0;
							$arr_data2["ID_TIPO_LANCAMENTO"] = 1;
							$arr_data2["N_SOLICITACAO"] = "";
							$arr_data2["NOTA_FISCAL"] = "";
							$arr_data2["VALOR_DESCONTO"] = "";
							$arr_data2["VALOR_TOTAL"] = "";
							$arr_data2["PARCELA"] = "";
							$arr_data2["VALOR_PARCELA"] = "";
							$arr_data2["LOCAL"] = "";
						}
					}

					break;
					
				//! ---------------------------------------------------------------------------
				case "tim":
				//! ---------------------------------------------------------------------------

					/*
					 * FIRST STEP
					 * Get the entries detailment (beginning)
					*/

					$arr_data2 = array();
					$arr_data2["ID_PEC_SERVICO_LINHA"] = $this->getIdPEC();

					$arr_data3 = array();
					$arr_data3["ID_PEC"] = $this->getIdPEC();

					//! Define the anchors
					$str_begin = "/Quantidade+\s+de+\s+Acessos:+\s+([0-9])+\s+QUANTIDADE/";
					$str_end = "/TOTAL+\s+TIM/";

					//! Get the necessary content according the limiters 
					$break01 = preg_split($str_begin, $content_); //! begin
					$break02 = preg_split($str_end, $break01[1]); //! end
					//$break03 = explode("Serviços Contratados", $break02[0]);

					//! Get back the first column
					$break02[0] = "QUANTIDADE " . $break02[0];

					//! Split the content section
					$break03 = preg_split("/QUANTIDADE/", $break02[0]);

					//! Run through registers block
					for( $i = 1; $i < sizeof($break03); $i++ )
					{
						//! Separe the register from columns
						$aux_data = preg_split("/VALOR/", $break03[$i], 2);

						//! Adjust the columns name
						$aux_data[0] = "QUANTIDADE " . $aux_data[0] . " VALOR";
						$aux_data[0] = str_replace("Nº DIAS", "N_DIAS", $aux_data[0]);
						$aux_data[0] = str_replace("PIS/COFINS", "PIS_COFINS", $aux_data[0]);
						$aux_data[0] = str_replace("DURAÇÃO/VOLUME", "DURACAO_VOLUME", $aux_data[0]);
						$aux_data[0] = str_replace(" KB", "KB", $aux_data[0]);
						$aux_data[0] = str_replace(" MB", "MB", $aux_data[0]);
						$aux_data[0] = str_replace(" GB", "GB", $aux_data[0]);

						//! Adjust the register block (when it possible)
						if ( strpos($aux_data[1], "IMPOSTO") !== false )
						{
							$aux_data2 = preg_split("/IMPOSTO/", $aux_data[1]);
							$aux_data[1] = $aux_data2[0];
						}

						//! "OUTROS CRÉDITOS" SECTION
						if ( strpos($aux_data[1], "OUTROS CRÉDITOS/DÉBITOS") !== false )
						{
							//! Prepare the info to save in DB
							$arr_data["DESCRICAO"] = "Outros Créditos/Débitos";

							//! Insert the entry list in DB
							$query = $this->db->insert('pec.servicos', $arr_data);
							$arr_data3["ID_SERVICO"] = $this->db->last_id;

							//! Check if the insertion worked
							if ( $query )
							{
								//! Get the calling type
								$aux_data[1] = remove_accent($aux_data[1]);
								preg_match_all('/(?=[A-Z])([A-Z\s]{10,})/', $aux_data[1], $match_calling_type);

								for ( $z = 0; $z < sizeof($match_calling_type[0]); $z++ )
								{
									$aux_id = $this->checkLigacao_PEC(rtrim(ltrim($match_calling_type[0][$z])), 0);
								}

								//!======================================================================================

									/*!
									 * INSERT THE DETAIILMENT
									*/

									//! Separate each register
									preg_match_all('/(([0-9])+,+([0-9])[^%])+\s[^KB MB GB TB]/', $aux_data[1], $match_values);
									$registers = preg_split('/(([0-9])+,+([0-9])[^%])+\s[^KB MB GB TB]/', $aux_data[1]);

									//! Run through each register
									for( $j = 1; $j < (sizeof($registers) - 1); $j++ )
									{
										//! Add value
										if ( isset($match_values[0][$j]) )
											$registers[$j] .= $match_values[0][$j];

										//! Remove some characters
										if ( $j != 0 )
											$registers[$j] = substr($registers[$j], 3);

										//! Split the register in columns to save in DB
										$break04 = preg_split('/\s+/', $registers[$j]);

										$arr_data2["PIS_COFINS"] = "";
										$arr_data2["DESCRITIVO"] = "";
										$arr_data3["ID_LINHA"] = 0;

										for ( $k = (sizeof($break04) - 1); $k >= 0; $k-- )
										{
											//! ICMS / PIS & COFINS
											if ( strpos($break04[$k], "%") !== false )
											{
												if ( trim($arr_data2["PIS_COFINS"]) == "" )
													$arr_data2["PIS_COFINS"] = trim($break04[$k]);
												else
													$arr_data2["ICMS"] = trim($break04[$k]);
											}
											//! PHONE
											else if ( preg_match('/([0-9])+-+([0-9])+-+([0-9])\w+/', $break04[$k]) )
												$arr_data3["ID_LINHA"] = $this->getPhoneID(substr(trim($break04[$k]), 1), false);
											//! PERIOD
											else if ( preg_match('/([0-9])\/([0-9])\w+/', $break04[$k]) )
												$arr_data2["PERIODO"] = trim($break04[$k]);
											//! DURATION
											else if ( preg_match('/([0-9])m([0-9])\w+/', $break04[$k]) )
												$arr_data2["DURACAO"] = trim($break04[$k]);
											//! VOLUME
											else if ( (strpos($break04[$k], "KB") !== false || strpos($break04[$k], "MB") !== false || 
													  strpos($break04[$k], "GB") !== false || strpos($break04[$k], "TB") !== false) && strpos($break04[$k], ",") !== false )
												$arr_data2["VOLUME"] = trim($break04[$k]);
											//! Nº DAYS / QUANTITY
											else if ( is_numeric($break04[$k]) )
												$arr_data4["QUANTIDADE"] = trim($break04[$k]);												
											//! VALUE
											else if ( preg_match('/(([0-9])+,+([0-9]))/', $break04[$k]) )
												$arr_data2["VALOR"] = trim($break04[$k]);
											//! DESCRIPTION
											else
											{
												$arr_data2["DESCRITIVO"] .= trim($break04[$k]) . " ";
											}
										}

										//! Reverse the description
										$arr_data2["DESCRITIVO"] = reverse_sentence($arr_data2["DESCRITIVO"]);

										//! Adjust the description
										if ( strpos($arr_data2["DESCRITIVO"], "Pct") !== false )
											$arr_data2["DESCRITIVO"] = "Pacote de minutos";

										//! Insert the entry detail in DB
										$query3 = $this->db->insert('pec.servicolinha', $arr_data3);

										if ( $query3 )
										{
											$arr_data2["ID_PEC_SERVICO_LINHA"] = $this->db->last_id;

											//! Insert the entry detail in DB
											$query2 = $this->db->insert('pec.servicocobrado', $arr_data2);
										}

										//! Clean up array
										$arr_data2["VALOR"] = "";
										$arr_data2["PIS_COFINS"] = "";
										$arr_data2["ICMS"] = "";
										$arr_data2["VOLUME"] = "";
										$arr_data2["DURACAO"] = "";
										$arr_data2["PERIODO"] = "";
										$arr_data4["QUANTIDADE"] = "";
									}

								//!======================================================================================
							}
						}
					}

					/*
					 * SECOND STEP
					 * Get the entries detailment (ending)
					*/

					$arr_services = array();
					$arr_data = array();
					$arr_data["ID_PEC"] = $this->getIdPEC();

					$arr_data2 = array();
					$arr_data2["ID_PEC"] = $this->getIdPEC();

					$content_block = "";

					//! Define the anchors
					$str_begin = "RESUMO DO DETALHAMENTO";
					$str_end = "Total FATURA";

					//! Get the necessary content according the limiters 
					$break01 = explode($str_begin, $content_); //! begin

					//! Run through registers block
					for( $i = 1; $i < sizeof($break01); $i++ )
					{
						$content_block .= $break01[$i] . " ";
					}

					//! Limit the information block
					$break02 = explode($str_end, $content_block); //! end

					//! Get all the entries type
					$arr_services = preg_split('/([0-9])\s+Total/', $break02[0]);

					//! Remove all unnecessary info
					for( $i = 1; $i < sizeof($arr_services); $i++ )
					{
						$aux_arr_services = explode("Acesso", $arr_services[$i]);
						$arr_services[$i] = "Total " . $aux_arr_services[0];
					}

					//! Remove repeated elements
					$arr_services = array_values(array_unique($arr_services));

					//! Run through the service list
					for( $i = 1; $i < sizeof($arr_services); $i++ )
					{
						//! Prepare a custom regex to check if the service exists in this register
						$arr_services[$i] = preg_replace('!\s+!', ' ', $arr_services[$i]);
						$aux_service = str_replace("/", "\/", $arr_services[$i]);
						$aux_service = '/' . str_replace(' ', '\s+', $aux_service) . '/';

						//! Check if the service is contained inside the register
						if ( preg_match($aux_service, $break02[0]) )
						{
							//! Prepare the info to save in DB
							$arr_data["DESCRICAO"] = str_replace('  ', ' ', $arr_services[$i]);

							//! Insert the entry list in DB
							$query = $this->db->insert('pec.outroslancamentos', $arr_data);

							//! Check if the operation worked
							if ( $query )
							{
								//! Define the register classification
								$arr_data2["ID_TIPO_LANCAMENTO"] = 5;	//!< DIVERSOS
								$arr_data2["ID_LANCAMENTO"] = $this->db->last_id;

								//! Split the information accordling to the service name
								$break03 = explode($arr_services[$i], $break02[0]);

								//! Run through all registers related to service
								for ( $j = 1; $j < sizeof($break03); $j++ )
								{
									$break04 = explode(",", $break03[$j]);
									$aux_register = $break04[0] . "," . substr($break04[1], 0, 2);
									$aux_register = str_replace("Acesso", "", $aux_register);

									//! Split the register in columns to save in DB
									$break04 = preg_split('/\s+/', $aux_register);

									$arr_data2["DESCRITIVO"] = "";
									$arr_data2["ID_LINHA"] = 0;

									for ( $k = (sizeof($break04) - 1); $k >= 0; $k-- )
									{
										//! PHONE
										if ( preg_match('/([0-9])+-+([0-9])+-+([0-9])\w+/', $break04[$k]) )
											$arr_data2["ID_LINHA"] = $this->getPhoneID(substr(trim($break04[$k]), 1), false);
										//! VALUE
										else if ( preg_match('/(([0-9])+,+([0-9]))/', $break04[$k]) )
											$arr_data2["VALOR"] = trim($break04[$k]);
									}

									$arr_data2["DESCRITIVO"] = str_replace('  ', ' ', $arr_services[$i]);

									if ( strpos($arr_data2["VALOR"] , ",") === false )
									{
										$arr_data2["VALOR"] .= ",00";
									}

									//! Insert the entry detail in DB
									$query2 = $this->db->insert('pec.outroslancamentosdet', $arr_data2);
								}
							}
						}
					}

					break;
			}

		} //! getOtherEntries_PEC

		/*!
		 * Associate the phone number list with the services from PEC content
		 *
		 * @since 0.1
		 * @access public
		 * @content_ => the content to be analysed
		*/
		public function associatePhoneService_PEC( $content_ )
		{
			//! Set a limit to processing time
			ini_set('MAX_EXECUTION_TIME', -1);

			//! Auxiliary variables
			$str_begin = "";
			$str_end = "";
			$aux_service = "";
			$aux_period = "";
			$aux_value = "";
			$content_block = "";
			$content_detail_block = "";
			//!--------------------
			$arr_service = array();
			$arr_phone = array();
			$arr_data = array();
			$arr_data["ID_PEC"] = $this->getIdPEC();
			$arr_data["ID_SERVICO"] = "";
			$arr_data["ID_LINHA"] = "";
			$arr_data["MINUTOS"] = "";
			$arr_data["FRANQUIA_REAIS"] = "";

			//! Regex Period => E.g:(24/10/14 a 01/11/14)
			$regex_period = '/([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s+a+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s/';

			//! Regex Period => E.g:(24/10/2014 à 01/11/2014)
			$regex_period2 = '/([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+([0-9])\w+\s+à+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+([0-9])\w+\s/';

			//! Regex min => E.g:(min -)
			$regex_min = '/\s+min+\s+-+\s/';

			//! Select the number list
			$query = $this->db->query('SELECT `ID_PEC_LINHA`, `LINHA` FROM `pec.linhas` WHERE `ID_PEC` = ' . $arr_data["ID_PEC"] . ' AND `DATA_FECHA` IS NULL');

			//! Check if query worked
			if ( $query )
			{
				//! Pass the information from database to array
				$arr_phone = $query->fetchAll();
			}
			else
			{
				return false;
			}

			//! Get the types of detailed data
			$this->setDetailType($this->get_detail_type_list());

			//! Check the carrier
			switch( strtolower($this->getCarrier()) )
			{
				//! ---------------------------------------------------------------------------
				case "claro":
				//! ---------------------------------------------------------------------------

					foreach ( $arr_phone as $value )
					{
						if ( strlen(v_num($value[1])) == 10 )
							$value[1] = mask_string("(##) #### ####", v_num($value[1]));
						else
							$value[1] = mask_string("(##) ##### ####", v_num($value[1]));

						//! Define the anchors
						$str_begin = "Detalhamento de ligações e serviços do celular " . $value[1];
						$str_aux = "Mensalidades e Pacotes Promocionais";
						$str_aux2 = "Detalhamento de ligações";
						$str_end = '/\s+Total+\s+R\$+\s/';
						
						//! Get the necessary content according the limiters 
						if ( strpos($content_, $str_begin) !== false )
						{
							$break01 = explode($str_begin, $content_); //! begin

							//! Run trough pages
							$break01[0] = "";
							$content_detail_block = "";
							for( $x = 1; $x < (sizeof($break01)); $x++ )
							{
								//! Check if the information is related to charges
								if ( strpos($break01[$x], $str_aux) !== false )
									$break01[0] .= $break01[$x];
								else
									break;
							}

							//! Generate the detail block
							for( $x = 1; $x < (sizeof($break01)); $x++ )
							{
								//! Check if the information is related to detail
								if ( strpos($break01[$x], $str_aux2) === false )
									$content_detail_block .= " " . $break01[$x];
								else
								{
									$aux_break01 = explode($str_aux2, $break01[$x]);
									$content_detail_block .= " " . $aux_break01[0];
									break;
								}
							}

							//! Limit the information block
							if( preg_match($str_end, $break01[0]) )
								$break02 = preg_split($str_end, $break01[0]); //! end
							else
								continue;

							//! Separate the service name
							$break03 = preg_split('/([0-9])+,+([0-9])/', $break02[0]); //! end
							$break_value = explode(",", $break02[0]); //! end

							//! Clean up the service name
							for( $i = 0; $i < (sizeof($break03) - 1); $i++ )
							{
								//! Get the value from service
								$break_aux = preg_split('/\s+/', $break_value[$i]);
								$aux_value = $break_aux[sizeof($break_aux)-1];
								$break_aux = preg_split('/\s+/', $break_value[($i+1)]);
								$aux_value .= "," . $break_aux[0];

								//! Split the service name to remove the unnecessary information
								if ( $i == 0 )
									$break05 = preg_split('/\s+/', $break03[$i]);
								else
									$break05 = preg_split('/\s+/', substr($break03[$i], 3));

								//! Service list
								for( $j = 0; $j < (sizeof($break05) - 1); $j++ )
								{
									//! Concatenate every part from the service name
									$aux_service .= $break05[$j] . " ";
								}

								//! Remove unnecessary information
								if ( strpos($aux_service, "(R$)") !== false )
								{
									$aux_service = explode("(R$)", $aux_service);
									$aux_service = mb_strtoupper($aux_service[1], 'UTF-8');
								}
								else
								{
									$aux_service = mb_strtoupper($aux_service, 'UTF-8');
								}
								
								//! Prepare information to save in database
								$arr_data["ID_SERVICO"] = $this->getServiceID($aux_service);
								$arr_data["ID_LINHA"] = $value[0];

								//! Check if it's a shared consume
								if ( trim(strtoupper($aux_service)) == trim("CONSUMO COMPARTILHADO") )
									$arr_data["FRANQUIA_REAIS"] = $this->getSharedConsume();
								else
									$arr_data["FRANQUIA_REAIS"] = "";

								//! Insert the association in database
								if ( $arr_data["ID_SERVICO"] != "" )
								{
									$query = $this->db->insert('pec.servicolinha', $arr_data);

									//! Check operation
									if ( !$query )
									{
										return false;
									}
									else
									{
										//! Save the detail information
										$arr_data2["ID_PEC_SERVICO_LINHA"] = $this->db->last_id;
										$arr_data2["PERIODO"] = $this->getPeriod();
										$arr_data2["VALOR"] = $aux_value;

										$query2 = $this->db->insert('pec.servicocobrado', $arr_data2);

										//! Check operation
										if ( !$query2 )
											return false;
									}
								}
								$aux_service = "";
							}
							//! Save the detailed information
							$content_detail_block = preg_split($str_end, $content_detail_block); //! end
							$this->getDetail_PEC($content_detail_block[1], $value[0]);
							$content_detail_block = "";
						}
					}

					break;

				//! ---------------------------------------------------------------------------
				case "vivo":
				//! ---------------------------------------------------------------------------

					//! Set a limit to processing time
					ini_set('MAX_EXECUTION_TIME', -1);

					foreach ( $arr_phone as $value )
					{
						//! Define the anchors
						$str_begin = "VEJA O USO DETALHADO DO VIVO " . $value[1];
						$str_begin2 = "VEJA O USO DETALHADO DO VIVO " . str_replace("-", "", $value[1]);
						$str_end = "VALOR DO VIVO " . $value[1];
						$str_end2 = "VALOR DO VIVO " . str_replace("-", "", $value[1]);

						//! Get the necessary content according the limiters 
						if ( strpos($content_, $str_begin) !== false || strpos($content_, $str_begin2) !== false )
						{
							if ( strpos($content_, $str_begin) !== false  )
								$break01 = explode($str_begin, $content_); //! begin
							else
								$break01 = explode($str_begin2, $content_); //! begin

							//! Run trough pages
							for ( $z = 1; $z < sizeof($break01); $z++ )
							{
								if ( strpos($content_, $str_begin) !== false  )
									$break02 = explode($str_end, $break01[$z]); //! end
								else
									$break02 = explode($str_end2, $break01[$z]); //! end

								//! Separate the service detail individually
								$break03 = explode("Valor R$ Plano/Pacote", $break02[0]);

								//! Service list
								for ( $x = 1; $x < sizeof($break03); $x++ )
								{
									//! Get the service name
									if( preg_match($regex_period, $break03[$x]) )
										$break04 = preg_split($regex_period, $break03[$x]);
									else if( preg_match($regex_period2, $break03[$x]) )
										$break04 = preg_split($regex_period2, $break03[$x]);
									else
										$break04 = explode("-", $break03[$x]);

									//! Get the minutes
									if( preg_match($regex_min, $break03[$x]) )
									{
										$break_min = preg_split($regex_min, $break03[$x]);
										$aux_min = preg_split('/\s+/', $break_min[0]);
										$arr_data["MINUTOS"] = $aux_min[(sizeof($aux_min) - 1)];
									}

									//! Prepare information to save in database
									$arr_data["ID_SERVICO"] = $this->getServiceID($break04[0]);
									$arr_data["ID_LINHA"] = $value[0];

									//! Insert the association in database
									if ( $arr_data["ID_SERVICO"] != "" )
									{
										$query = $this->db->insert('pec.servicolinha', $arr_data);

										//! Check operation
										if ( !$query )
										{
											return false;
										}
										else
										{
											//! Save the period information
											$this->getServicesPeriod_PEC($break03[$x], $this->db->last_id);
										}
									}
									$arr_data["MINUTOS"] = "";
								}
								$content_detail_block .= $break02[0]; 
							}

							//! Set a limit to processing time
							ini_set('MAX_EXECUTION_TIME', -1);

							//! Save the detailed information
							$this->getDetail_PEC($content_detail_block, $value[0]);
							$content_detail_block = "";
						}
					}

					break;

				//! ---------------------------------------------------------------------------
				case "nextel":
				//! ---------------------------------------------------------------------------

					foreach ( $arr_phone as $value )
					{
						if ( strlen(v_num($value[1])) == 10 )
							$value[1] = mask_string("##-########", v_num($value[1]));
						else
							$value[1] = mask_string("##-#########", v_num($value[1]));

						//! Separate the information block by phone number
						$break01 = preg_split('/TELEFONE:+\s+' . $value[1] . '/', $content_); //! phone divider

						//! Define the anchors
						$str_begin = "O QUE FOI CONTRATADO";
						$str_end = "O QUE FOI UTILIZADO";
						$str_end2 = "Total do Nº:";

						//! Auxiliary variables
						$content_block = "";
						$utilization_block = "";
						$status_stop = 0;
						$status_content = 0;
						$have_detail = 0;

						//! Fill the detail block
						for ( $x = 1; $x < (sizeof($break01)); $x++ )
						{
							//! Check last position
							if ( $x == (sizeof($break01) - 1) && strpos($break01[$x], "DETALHAMENTO DE SERVIÇOS") !== false )
							{
								//! Split information from different phone numbers
								$aux_block = explode("DADOS DO CLIENTE", $break01[$x]);
								$utilization_block .= $aux_block[0];
							}
							else
							{
								$utilization_block .= $break01[$x];
							}
						}

						//! Fill the content block
						for ( $x = 1; $x < (sizeof($break01)); $x++ )
						{
							//! Delimit the content block
							if ( strpos($break01[$x], $str_end) !== false )
							{
								$aux_break01 = explode($str_end, $break01[$x]);
								$status_stop = 1;
							}
							else if ( strpos($break01[$x], $str_end2) !== false )
							{
								$aux_break01 = explode($str_end2, $break01[$x]);
								$status_stop = 1;
							}
							else
							{
								$aux_break01[0] = $break01[$x];
								$status_stop = 0;
							}

							//! Get the necessary content according the limiters 
							if ( strpos($aux_break01[0], $str_begin) !== false )
							{
								$break02 = explode($str_begin, $aux_break01[0]); //! begin
								$content_block .= $break02[1];

								if ( $status_stop == 1 )
									break;
							}
						}

						//! BR: THE LINE DOESN'T HAVE A MONTHLY PAYMENT
						if ( strpos($utilization_block, $str_begin) === false && sizeof($break01) <= 2 )
						{
							//! Prepare information to save in database
							$arr_data["ID_SERVICO"] = $this->getServiceID("SEM MENSALIDADE");
							$arr_data["ID_LINHA"] = $value[0];

							//! Save the association between service X line
							$query = $this->db->insert('pec.servicolinha', $arr_data);

							//! Check if the operation was successful
							if ( !$query )
							{
								return false; //! ERROR
							}
							else
							{
								//! Save the detail information
								$arr_data2["ID_PEC_SERVICO_LINHA"] = $this->db->last_id;
								$arr_data2["PERIODO"] = "";
								$arr_data2["VALOR"] = "0,00";

								$query2 = $this->db->insert('pec.servicocobrado', $arr_data2);

								//! Check operation
								if ( !$query2 )
									return false;
							}
						}
						//! BR: THE LINE HAS A MONTHLY PAYMENT
						else
						{
							//! Check if the phone number has detail info
							if ( strpos($utilization_block, "DETALHAMENTO DE SERVIÇOS") !== false && strpos($utilization_block, "Data") !== false )
							{
								//! Service with detail info
								$utilization_block = explode("DETALHAMENTO DE SERVIÇOS", $utilization_block, 2);
								$have_detail = 1;
							}
							else
							{
								//! Service without detail info
								$utilization_block = explode($str_end2, $utilization_block);
								$have_detail = 0;
							}

							$break02 = explode("Subtotal", $content_block);

							for ( $x = 0; $x < (sizeof($break02) - 1); $x++ )
							{
								//! Check the quantity of services in a single line
								$break03 = preg_split($regex_period2, $break02[$x]);
								$break_period = preg_split('/\s+à+\s+/', $break02[$x]);

								//! Loop to get the service name
								for ( $i = 1; $i < sizeof($break03); $i++ )
								{
									//! Separate service name from value
									$break04 = explode(",", $break03[$i]); //! end
									$break05 = preg_split('/\s+/', $break04[0]);

									//! Get the value from service
									$aux_value = $break05[sizeof($break05)-1];
									$break_aux = preg_split('/\s+/', $break04[1]);
									$aux_value .= "," . $break_aux[0];

									//! Get the period from service
									$break_aux = preg_split('/\s+/', $break_period[($i-1)]);
									$aux_period = $break_aux[sizeof($break_aux) - 1];
									$break_aux = preg_split('/\s+/', $break_period[($i)]);
									$aux_period .= " à " . $break_aux[0];

									//! Remove the unnecessary value
									for( $j = 0; $j < (sizeof($break05) - 1); $j++ )
									{
										//! Concatenate every part from the service name
										$aux_service .= $break05[$j] . " ";
									}
									$aux_service = rtrim(ltrim(mb_strtoupper($aux_service, 'UTF-8')));

									//! Prepare information to save in database
									$arr_data["ID_SERVICO"] = $this->getServiceID($aux_service);
									$arr_data["ID_LINHA"] = $value[0];

									//! Save the association between service X line
									$query = $this->db->insert('pec.servicolinha', $arr_data);

									//! Check if the operation was successful
									if ( !$query )
									{
										return false; //! ERROR
									}
									else
									{
										//! Save the detail information
										$arr_data2["ID_PEC_SERVICO_LINHA"] = $this->db->last_id;
										$arr_data2["PERIODO"] = $aux_period;
										$arr_data2["VALOR"] = $aux_value;

										$query2 = $this->db->insert('pec.servicocobrado', $arr_data2);

										//! Check operation
										if ( !$query2 )
											return false;
									}

									$aux_service = "";
									$aux_period = "";
								}
							}
						}

						//! Save the detailed information
						if ( $have_detail == 1 )
						{
							/*! Information with detail
							 * "@@@" ezpression means the division between
							 * the detailment and the general info related to the radio
							*/
							$this->getDetail_PEC("SIM" . trim($utilization_block[0]) . "@@@" . trim($utilization_block[1]), $value[0]);
						}
						else
						{
							//! Information without detail
							$this->getDetail_PEC("NAO" . trim($utilization_block[0]), $value[0]);
						}
					}
					break;

				//! ---------------------------------------------------------------------------
				case "tim":
				//! ---------------------------------------------------------------------------

					foreach ( $arr_phone as $value )
					{
						$flag_block = 0;
						$content_detail_block = "";

						//! Define the anchors
						$str_begin = "Detalhamento de Serviços nº: " . $value[1];
						$value[1] = "0" . $value[1];
						$str_begin2 = "Detalhamento de Serviços nº: " . $value[1];
						$str_end = "Total de Uso";
						$str_end2 = "/\s+Total+\s+de+\s+Uso/";
						$str_end3 = "Tipo: N - Normal";
						$str_end4 = "/\s+Tipo:+\s+N+\s+-+\s+Normal/";

						//! Get the necessary content according the limiters 
						if ( strpos($content_, $str_begin) !== false || strpos($content_, $str_begin2) !== false )
						{
							if ( strpos($content_, $str_begin) !== false  )
								$break01 = explode($str_begin, $content_); //! begin
							else
								$break01 = explode($str_begin2, $content_); //! begin

							//! Run trough pages
							for ( $z = 1; $z < sizeof($break01); $z++ )
							{
								//! Prepare the block to get the detail
								$content_detail_block .= $break01[$z] . " ";

								if ( strpos($break01[$z], $str_end) !== false  )
								{
									$break02 = explode($str_end, $break01[$z]); 	//! end
									$flag_block = 1;
								}
								else if ( preg_match($str_end2, $break01[$z]) )
								{
									$break02 = preg_split($str_end2, $break01[$z]); //! end
									$flag_block = 1;
								}

								//! Get just the page with the information
								if ( $flag_block == 1 )
								{
									if ( strpos($break02[1], $str_end3) !== false  )
										$break02 = explode($str_end3, $break02[1]); 		//! end
									else if ( preg_match($str_end4, $break02[1]) )
										$break02 = preg_split($str_end4, $break02[1]); 	//! end

									$flag_ass = 0;

									//! Run through the service list
									for ( $i = 0; $i < sizeof($this->arr_service_list); $i++ )
									{
										//! Prepare a custom regex to check if the service exists in this register
										$aux_service = str_replace("/", "\/", $this->arr_service_list[$i]);
										$aux_service = '/' . str_replace(' ', '\s+', $aux_service) . '/';

										//! Check if the service is contained inside the register
										if ( preg_match($aux_service, $break02[0]) || strpos($this->arr_service_list[$i], "Ass.") !== false && $flag_ass == 0 )
										{
											//! Split the register using the service name as the parameter
											if ( strpos($this->arr_service_list[$i], "Ass.") !== false )
											{
												$break03 = preg_split('/Total\s+de\s+Assinatura\s+do\s+Plano/', $break02[0]);
												$flag_ass = 1;
											}
											else
												$break03 = preg_split($aux_service , $break02[0]);

											$break04 = preg_split('/\s+/', rtrim(ltrim($break03[1])));
											$aux_value = $break04[0];

											//! Prepare information to save in database
											$arr_data["ID_SERVICO"] = $this->getServiceID($this->arr_service_list[$i]);
											$arr_data["ID_LINHA"] = $value[0];

											//! Save the association between service X line
											$query = $this->db->insert('pec.servicolinha', $arr_data);

											//! Check if the operation was successful
											if ( !$query )
											{
												return false; //! ERROR
											}
											else
											{
												//! Save the detail information
												$arr_data2["ID_PEC_SERVICO_LINHA"] = $this->db->last_id;
												$arr_data2["PERIODO"] = "";
												$arr_data2["VALOR"] = $aux_value;

												$query2 = $this->db->insert('pec.servicocobrado', $arr_data2);

												//! Check operation
												if ( !$query2 )
													return false;
											}

											$aux_service = "";
											$aux_period = "";
										}
									}
								}

								//! Get out of the loop
								if ( $flag_block == 1 )
								{
									$flag_block = 0;
									break;
								}
							}

							//! Limit the detail block
							if ( strpos($content_detail_block, $str_end) !== false  )
							{
								$aux_content_detail_block = explode($str_end, $content_detail_block); 	//! end
								$content_detail_block = $aux_content_detail_block[0];
							}
							else if ( preg_match($content_detail_block, $break01[$z]) )
							{
								$aux_content_detail_block = preg_split($str_end2, $content_detail_block); //! end
								$content_detail_block = $aux_content_detail_block[0];
							}

							//! Save the detailed information
							$this->getDetail_PEC($content_detail_block, $value[0]);
							$content_detail_block = "";
						}
					}

					break;
			}

		} //! associatePhoneService_PEC
		
		/*!
		 * Get the detail from the services
		 *
		 * @since 0.1
		 * @access public
		 * @content_ => the content to be analysed
		 * @id_service_phone_ => ID of phone x service association
		*/
		public function getServicesPeriod_PEC( $content_, $id_service_phone_ )
		{
			//! Set a limit to processing time
			ini_set('MAX_EXECUTION_TIME', -1);

			//! Auxiliary variables
			$str_begin = "";
			$str_end = "";
			$aux_cont = 1;
			//!--------------------
			$arr_data = array();
			$arr_data["ID_PEC_SERVICO_LINHA"] = $id_service_phone_;
			$arr_data["PERIODO"] = "";
			$arr_data["VALOR"] = "";

			//! Regex Period => E.g:(24/10/2014 à 01/11/2014)
			$regex_period = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s+a+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';

			//! Regex Money with space => E.g:(64,75 )
			$regex_money = '/([0-9])+([0-9])+,([0-9])+([0-9])\s+/';
			$regex_money2 = '/([0-9])+,([0-9])+([0-9])\s+/';

			//! Check the carrier
			switch( strtolower($this->getCarrier()) )
			{
				//! ---------------------------------------------------------------------------
				case "claro":
				//! ---------------------------------------------------------------------------

					break;

				//! ---------------------------------------------------------------------------
				case "vivo":
				//! ---------------------------------------------------------------------------

					//! Define the anchors
					$str_begin = "/Período\s+Incluso/";
					$str_end = "/\s+Utilização\s+Dentro\s+do\s+Plano\/Pacote/";
					$str_end2 = "/\s+Total\s+Plano/";
					$str_end3 = "/\s+Incluso\s+Plano\/Pacote/";
					$str_end4 = "/\s+UTILIZAÇÃO\s+ACIMA\s+DO\s+CONTRATADO/";
					$str_end5 = "/\s+SERVIÇOS\s+/";
					$str_end6 = "/\s+NO\s+BRASIL\s+-\s+EM\s+ROAMING/";
					$break01 = preg_split($str_begin, $content_); //! begin

					//! Remove all detail
					if ( preg_match($str_end2, $break01[0]) )
						$break02 = preg_split($str_end2, $break01[0]); //! end
					else if ( preg_match($str_end, $break01[0]) )
						$break02 = preg_split($str_end, $break01[0]); //! end
					else if ( preg_match($regex_money, $break01[0]) || preg_match($regex_money2, $break01[0]) )
					{
						if ( preg_match($regex_money, $break01[0]) )
							preg_match_all($regex_money, $break01[0], $match_value);
						else
							preg_match_all($regex_money2, $break01[0], $match_value);

						//! Has multiple periods
						if ( preg_match("/-\s+-/", $break01[0]) )
						{
							$break02 = explode($match_value[0][( sizeof($match_value[0]) - 1 )], $break01[0]); //! end with value
							$break02[0] .= $match_value[0][( sizeof($match_value[0]) - 1 )]; // add the value to the content
						}
						else
						{
							$break02 = explode($match_value[0][0], $break01[0]); //! end with value
							$break02[0] .= $match_value[0][0]; // add the value to the content
						}
					}
					else
						$break02 = $break01;

					//! If it's still necessary, remove the detail
					if ( preg_match($str_end3, $break02[0]) )
						$break02 = preg_split($str_end3, $break02[0]); //! end
					else if ( preg_match($str_end4, $break02[0]) )
						$break02 = preg_split($str_end4, $break02[0]); //! end
					else if ( preg_match($str_end5, $break02[0]) )
						$break02 = preg_split($str_end5, $break02[0]); //! end
					if ( preg_match($str_end6, $break02[0]) )
						$break02 = preg_split($str_end6, $break02[0]); //! end

					//! Remove page footer
					if ( preg_match("/Número\s+da\s+Conta:/", $break02[0]) )
						$break03 = preg_split("/Número\s+da\s+Conta:/", $break02[0]); //! end
					else
						$break03 = $break02;

					//! Analyse individually each period from service
					$break04 = preg_split($regex_period, $break03[0], NULL, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY); //! period
					$break05 = preg_split($regex_period, $break03[0]); //! period infos

					//! Check if the register has at least one period
					if ( sizeof($break04) == 1 )
					{
						//! Check if it has a subtotal
						if ( preg_match("/-\s+-\s+-/", $break04[0]) )
							$break06 = preg_split("/-\s+-\s+-/", $break04[0]);
						else if ( preg_match("/-\s+-/", $break04[0]) )
							$break06 = preg_split("/-\s+-\s+-/", $break04[0]);
						else
							$break06[0] = $break04[0];

						$arr_data["PERIODO"] = "";
						$arr_data["VALOR"] = $break06[sizeof($break06) - 1];

						//! Insert the association in database
						if ( $arr_data["ID_PEC_SERVICO_LINHA"] != "" )
						{
							$query = $this->db->insert('pec.servicocobrado', $arr_data);

							//! Check operation
							if ( !$query )
							{
								return false;
							}
						}
					}
					else
					{
						//! Divide the periods in single registers
						for ( $i = 1; $i < sizeof($break04); $i++ )
						{
							//! Remove unnecessary information
							if ( $break04[$i] != 1 && $break04[$i] != 0 )
							{
								//! Check if the register exists
								if ( isset($break05[$aux_cont]) )
								{
									//! Check if it has a subtotal
									if ( preg_match("/Total\s+Plano/", $break05[$aux_cont]) )
										$break06 = preg_split("/Total\s+Plano/", $break05[$aux_cont]);
									else
										$break06[0] = $break05[$aux_cont];

									$break07 = preg_split('/\s+/', rtrim(ltrim($break06[0])));
									$arr_data["PERIODO"] = $break04[$i];
									$arr_data["VALOR"] = $break07[sizeof($break07) - 1];

									//! Insert the association in database
									if ( $arr_data["ID_PEC_SERVICO_LINHA"] != "" )
									{
										$query = $this->db->insert('pec.servicocobrado', $arr_data);

										//! Check operation
										if ( !$query )
										{
											return false;
										}
									}

									$aux_cont += 1;
								}
							}
						}
					}

					break;

				//! ---------------------------------------------------------------------------
				case "nextel":
				//! ---------------------------------------------------------------------------

					break;
			}

		} //! getServicesPeriod_PEC
		
		/*!
		 * Get the phone list from PEC content
		 *
		 * @since 0.1
		 * @access public
		 * @content_ => the content to be analysed
		 * @id_phone_number_ => the line ID related to the detail
		*/
		public function getDetail_PEC( $content_, $id_phone_number_ )
		{
			//! Set a limit to processing time
			ini_set('MAX_EXECUTION_TIME', -1);

			//! Auxiliary variables
			$str_begin = "";
			$str_end = "";
			$detail_block = "";
			$duplicated_reg = "";
			$tipo_ligacao = "";
			$aux_tp_ligacao = "";
			$flag = 0;
			$csp = 0;
			$zerar_csp = 0;
			//!--------------------
			$arr_data = array();
			$arr_data["ID_PEC"] = $this->getIdPEC();
			$arr_data["ID_LINHA"] = $id_phone_number_;
			$arr_data["ID_TIPO_UTILIZACAO"] = 1;
			$arr_data["ID_TIPO_LIGACAO"] = "";
			$arr_data["ID_TIPO_CHAMADA"] = "";
			$arr_data["CSP"] = "";
			$arr_data["DATA"] = "";
			$arr_data["HORA"] = "";
			$arr_data["ORIGEM"] = "";
			$arr_data["ORIGEM_DESTINO"] = "";
			$arr_data["N_CHAMADO"] = "";
			$arr_data["TARIFA"] = "";
			$arr_data["DURACAO"] = "";
			$arr_data["VALOR"] = "";
			$arr_data["VALOR_COBRADO"] = "";
			$arr_data["INTERCONEXAO"] = "";
			$arr_data["PAIS_OPERADORA"] = "";
			$arr_data["SERVICO"] = "";

			//! Regex Period => E.g:(24/10/2014 à 01/11/2014)
			$regex_period = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s+a+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';
			$regex_period2 = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s+à+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';

			//! Regex Date => E.g:(24/10/2014)
			$regex_date = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';

			//! Check the carrier
			switch( strtolower($this->getCarrier()) )
			{
				//! ---------------------------------------------------------------------------
				case "claro":
				//! ---------------------------------------------------------------------------

					//! Check if it has the detail
					if ( strpos($content_, "Subtotal") !== false )
					{
						//! Get just the detail block
						$break01 = explode("Subtotal", $content_); //! begin

						//! Run trough detail block
						for ( $x = 0; $x < (sizeof($break01) - 1); $x++ )
						{
							//! Split information, columns, titles
							if ( strpos($break01[$x], "Cobrado (R$)") !== false )
							{
								$break02 = explode("Cobrado (R$)", $break01[$x]);

								//! Check if it has a continuation in the next page
								if ( (substr_count($break01[$x], "(Continuação)") > 1) || (substr_count($break01[$x], "(Continuação)") == 1) && (strpos($break01[$x], "números especiais") !== false) ) //! the section continues next page
								{
									$aux_cont = 2;

									//! Concatenate the information block
									while ( isset($break02[$aux_cont]) )
									{
										$break02[1] .= " " . $break02[$aux_cont];
										$aux_cont += 1;
									}
								}

								//! Get the columns
								if ( strpos($break02[0], "Data") !== false ) //! Voice
								{
									$arr_data["ID_TIPO_DET"] = 2;
									$break03 = explode("Data", $break02[0]);

									if ( strpos($break03[0], "Ligações") !== false )
									{
										//! Define tipo chamada e tipo de ligação
										if ( substr_count($break03[0], "Ligações") == 2 )
										{
											$tipo_ligacao = explode("Ligações", $break03[0]);
											$tipo_chamada = "Ligações " . $tipo_ligacao[2];
											$tipo_ligacao = "Ligações " . $tipo_ligacao[1];
										}
										//! Define tipo de chamada
										else
										{
											$tipo_chamada = explode("Ligações", $break03[0]);
											$tipo_chamada = "Ligações " . $tipo_chamada[1];
										}
									}
									else if ( strpos($break03[0], "Dados (MB)") !== false )
									{
										$tipo_ligacao = "Serviços (Torpedos, Hits, Jogos, etc.)";
										$tipo_chamada = "Dados (MB)";
									}
									else if ( strpos($break03[0], "Dados (cobrança diária ou por MB)") !== false )
									{
										$tipo_ligacao = "Ligações e Serviços no exterior";
										$tipo_chamada = "Dados (cobrança diária ou por MB)";
									}
									else if ( strpos($break03[0], "Torpedos") !== false )
									{
										$tipo_ligacao = "Serviços (Torpedos, Hits, Jogos, etc.)";
										$tipo_chamada = "Torpedos";
									}
								}
								else if ( strpos($break02[0], "Dados (MB)") !== false ) //! SMS
								{
									$arr_data["ID_TIPO_DET"] = 4;
									$break03 = explode("Dados (MB)", $break02[0]);

									//! Service name
									$tipo_ligacao = "Serviços (Torpedos, Hits, Jogos, etc.)";
									$tipo_chamada = "Dados (MB)";
								}
								else if ( strpos($break02[0], "Dados (cobrança diária ou por MB)") !== false ) //! SMS 2
								{
									$arr_data["ID_TIPO_DET"] = 4;
									$break03 = explode("Dados (cobrança diária ou por MB)", $break02[0]);

									$tipo_ligacao = "Ligações e Serviços no exterior";
									$tipo_chamada = "Dados (cobrança diária ou por MB)";
								}
								else if ( strpos($break02[0], "exterior") !== false || strpos($break02[0], "Exterior") !== false ) //! SMS INTERNATIONAL
								{
									$arr_data["ID_TIPO_DET"] = 4;
									$break03 = explode("País-Operadora", $break02[0]);

									//! Service name
									$tipo_ligacao = "Ligações e Serviços no exterior";

									if ( strpos($break03[0], "Ligações") !== false )
									{
										$tipo_chamada = explode("Ligações", $break03[0]);
										$tipo_chamada = "Ligações " . $tipo_chamada[1];
									}
									else if ( strpos($break03[0], "Torpedos") !== false )
									{
										$tipo_chamada = "Torpedos Enviados no Exterior ";
									}
								}
								else if ( strpos($break02[0], "Torpedos") !== false ) //! SMS
								{
									$arr_data["ID_TIPO_DET"] = 4;
									$break03 = explode("Torpedos", $break02[0]);

									//! Service name
									$tipo_ligacao = "Serviços (Torpedos, Hits, Jogos, etc.)";
									$tipo_chamada = "Torpedos";
								}
								else if ( strpos($break02[0], "Serviço") !== false ) //! DADOS
								{
									$arr_data["ID_TIPO_DET"] = 3;
									$break03 = explode("Serviço", $break02[0]);

									//! Service name
									$tipo_ligacao = "Serviços (Torpedos, Hits, Jogos, etc.)";
									$tipo_chamada = "Dados (MB)";
								}
								else
								{
									continue;
								}

								//! Define the info classification
								$tipo_ligacao = str_replace("(Continuação)", "", $tipo_ligacao);
								$tipo_ligacao = str_replace("  ", " ", $tipo_ligacao);
								$tipo_chamada = str_replace("(Continuação)", "", $tipo_chamada);
								$tipo_chamada = str_replace("  ", " ", $tipo_chamada);

								$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC(rtrim(ltrim($tipo_ligacao)), 0);
								$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($tipo_chamada)));

								//! Clean-up service classification
								$tipo_ligacao = str_replace("(Continuação)", "", $tipo_ligacao);

								//! INFO TYPE
								$arr_data["TIPO_INFO_DET"] = 2;

								//! Get the detailed informations
								if ( strpos($tipo_chamada, "Ligações") !== false && strpos($tipo_chamada, "Exterior") !== false && $tipo_ligacao != "Dados (MB)" && 
									 strpos($break02[1], "Dados (cobrança diária ou por MB)") === false ) //! LIGAÇÕES NO EXTERIOR
								{
									//! Columns terms (if necessary add more)
									$arr_columns[0] = "DATA";
									$arr_columns[1] = "HORA";
									$arr_columns[2] = "PAIS_OPERADORA";
									$arr_columns[3] = "N_CHAMADO";
									$arr_columns[4] = "DURACAO";
									$arr_columns[5] = "TIPO";
									$arr_columns[6] = "VALOR";
									$arr_columns[7] = "VALOR_COBRADO";

									//! Define the detail type
									$arr_data["ID_TIPO_DET"] = 2;

									//! Break the registers and get the date value
									$registers = preg_split('/([0-9])+([0-9])+\/+([0-9])+([0-9])+\s/', $break02[1]);
									preg_match_all('/([0-9])+([0-9])+\/+([0-9])+([0-9])+\s/', $break02[1], $dates);

									//! Run trough registers
									for ( $i = 1; $i < sizeof($registers); $i++ )
									{
										//! Remove unnecessary information
										if ( strpos($registers[$i], "Pág.") !== false )
										{
											$aux_register = explode("Pág.", $registers[$i]);
											$registers[$i] = $aux_register[0];
										}

										//! Breaking spaces
										$registers[$i] = $dates[0][($i - 1)] . $registers[$i];
										$aux_registers = preg_split('/\s+/', ltrim(rtrim($registers[$i])));

										/*!
										 * To print each register individually, use $registers[$i]
										*/

										//! Reset the status variables
										$aux_cont = 0;
										$flag_str = 0;

										//! Allocate the values dynamically into the array data position
										for ( $m = 0; $m < sizeof($aux_registers); $m++ )
										{
											if ( v_num($aux_registers[$m]) == "" )
											{
												if ( $flag_str == 0 )
													$aux_cont += 1;

												$arr_data[$arr_columns[$aux_cont]] .= " " . $aux_registers[$m];
												$flag_str = 1;
											}
											else
											{
												if ( $m != 0 )
													$aux_cont += 1;

												$arr_data[$arr_columns[$aux_cont]] = $aux_registers[$m];
												$flag_str = 0;
											}
										}

										//! Classification fix to allocate correctly the values in data array
										if ( strpos($arr_data["DURACAO"], ",") !== false )
										{
											$arr_data["VALOR"] = $arr_data["DURACAO"];
											$arr_data["DURACAO"] = $arr_data["N_CHAMADO"];
											$arr_data["N_CHAMADO"] = "";
											$arr_data["VALOR_COBRADO"] = $arr_data["TIPO"];
											$arr_data["TIPO"] = "";
										}
										else if ( strpos($arr_data["TIPO"], ",") !== false )
										{
											$arr_data["VALOR_COBRADO"] = $arr_data["VALOR"];
											$arr_data["VALOR"] = $arr_data["TIPO"];
											$arr_data["TIPO"] = "";
										}

										//! Define the utilization type
										$aux_valor = str_replace(",", ".", $arr_data["VALOR_COBRADO"]);

										if ( strpos($arr_data["SERVICO"], "meses anteriores") !== false ) //! Períodos anteriores
											$arr_data["ID_TIPO_UTILIZACAO"] = 4;
										else if ( !compare_float($aux_valor, 0) ) //! Acima do contratado
											$arr_data["ID_TIPO_UTILIZACAO"] = 3;
										else if ( compare_float($aux_valor, 0) ) //! Dentro do plano/pacote
											$arr_data["ID_TIPO_UTILIZACAO"] = 2;
										else //! Não definido
											$arr_data["ID_TIPO_UTILIZACAO"] = 1;

										//! Send data to DB
										$query = $this->db->insert('pec.det', $arr_data);

										//! Clean array
										$arr_data["ID_TIPO_UTILIZACAO"] = 1;
										$arr_data["DATA"] = "";
										$arr_data["HORA"] = "";
										$arr_data["PAIS_OPERADORA"] = "";
										$arr_data["N_CHAMADO"] = "";
										$arr_data["DURACAO"] = "";
										$arr_data["TIPO"] = "";
										$arr_data["VALOR"] = "";
										$arr_data["VALOR_COBRADO"] = "";
									}
								}
								else if ( strpos($break02[1], "/") !== false && ($tipo_chamada == "Dados (MB)" || $tipo_chamada == "Dados (cobrança diária ou por MB)") ) //! DADOS NO EXTERIOR
								{
									//! Columns terms (if necessary add more)
									$arr_columns[0] = "DATA";
									$arr_columns[1] = "SERVICO";
									$arr_columns[2] = "PAIS_OPERADORA";
									$arr_columns[3] = "QUANTIDADE";
									$arr_columns[4] = "VALOR";
									$arr_columns[5] = "VALOR_COBRADO";
									
									//! Define the detail type
									$arr_data["ID_TIPO_DET"] = 3;

									//! Break the registers and get the date value
									$registers = preg_split('/([0-9])+([0-9])+\/+([0-9])+([0-9])+\s/', $break02[1]);
									preg_match_all('/([0-9])+([0-9])+\/+([0-9])+([0-9])+\s/', $break02[1], $dates);

									//! Run trough registers
									for ( $i = 1; $i < sizeof($registers); $i++ )
									{
										//! Remove unnecessary information
										if ( strpos($registers[$i], "Pág.") !== false )
										{
											$aux_register = explode("Pág.", $registers[$i]);
											$registers[$i] = $aux_register[0];
										}

										//! Breaking spaces
										$registers[$i] = $dates[0][($i - 1)] . $registers[$i];

										$registers[$i] = str_replace(" / ", "/", $registers[$i]);
										$registers[$i] = str_replace(" /", "/", $registers[$i]);
										$registers[$i] = str_replace("/ ", "/", $registers[$i]);
										$aux_registers = preg_split('/\s+/', ltrim(rtrim($registers[$i])));

										/*!
										 * To print each register individually, use $registers[$i]
										*/

										//! Reset the status variables
										$aux_cont = 0;
										$flag_str = 0;

										//! Allocate the values dynamically into the array data position
										for ( $m = 0; $m < sizeof($aux_registers); $m++ )
										{
											if ( v_num($aux_registers[$m]) == "" )
											{
												if ( $flag_str == 0 )
													$aux_cont += 1;
												else if ( $flag_str == 1 && $aux_cont == 1 )
													$aux_cont += 1;

												if ( isset($arr_columns[$aux_cont]) )
													$arr_data[$arr_columns[$aux_cont]] .= " " . $aux_registers[$m];

												$flag_str = 1;
											}
											else
											{
												if ( $m != 0 )
													$aux_cont += 1;

												if ( isset($arr_columns[$aux_cont]) )
													$arr_data[$arr_columns[$aux_cont]] = $aux_registers[$m];

												$flag_str = 0;
											}
										}

										//! Define the utilization type
										$aux_valor = str_replace(",", ".", $arr_data["VALOR_COBRADO"]);

										if ( strpos($arr_data["SERVICO"], "meses anteriores") !== false ) //! Períodos anteriores
											$arr_data["ID_TIPO_UTILIZACAO"] = 4;
										else if ( !compare_float($aux_valor, 0) ) //! Acima do contratado
											$arr_data["ID_TIPO_UTILIZACAO"] = 3;
										else if ( compare_float($aux_valor, 0) ) //! Dentro do plano/pacote
											$arr_data["ID_TIPO_UTILIZACAO"] = 2;
										else //! Não definido
											$arr_data["ID_TIPO_UTILIZACAO"] = 1;

										//! Send data to DB
										$query = $this->db->insert('pec.det', $arr_data);

										//! Clean array
										$arr_data["ID_TIPO_UTILIZACAO"] = 1;
										$arr_data["DATA"] = "";
										$arr_data["SERVICO"] = "";
										$arr_data["PAIS_OPERADORA"] = "";
										$arr_data["QUANTIDADE"] = "";
										$arr_data["VALOR"] = "";
										$arr_data["VALOR_COBRADO"] = "";
									}
								}
								else if ( strpos($break02[1], "/") !== false && strpos($tipo_chamada, "Torpedo") === false ) //! VOZ
								{
									//! Auxiliary counter
									$date_counter = 0;
									$aux_date = "";

									//! Break the registers and get the date value
									$registers = preg_split('/([0-9])+([0-9])+\/+([0-9])+([0-9])+\s/', $break02[1]);
									$dates = explode("/", $break02[1]);

									//! Define the detail type
									$arr_data["ID_TIPO_DET"] = 2;

									//! Run trough registers
									for ( $i = 1; $i < sizeof($registers); $i++ )
									{
										//! Add date
										if ( isset($registers[($i-1)]) )
										{
											//! Get the string date
											$aux_date = substr(rtrim(ltrim($dates[$date_counter])), -2) . "/" . substr($dates[($date_counter+1)], 0, 2);

											//! Fix to 4/ date problem
											if ( strlen(rtrim(ltrim($aux_date))) < 3 )
											{
												//! Concatenate the date with the register (with fix)
												$date_counter+=1;
												$aux_date = substr(rtrim(ltrim($dates[$date_counter])), -2) . "/" . substr($dates[($date_counter+1)], 0, 2);
												$registers[$i] = $aux_date . $registers[$i];
											}
											else
											{
												//! Concatenate the date with the register
												$registers[$i] = $aux_date . $registers[$i];
											}
										}

										//! Remove unnecessary information
										if ( strpos($registers[$i], "Pág.") !== false )
										{
											$aux_register3 = explode('Pág.', rtrim(ltrim($registers[$i])));
											$registers[$i] = $aux_register3[0];
										}

										$aux_register = substr($registers[$i], 0, (strlen($registers[$i]) - 2));
										$aux_register = preg_replace('/\s+Pág.+\s+\w+/', '', $aux_register);
										$aux_register2 = explode(':', rtrim(ltrim($aux_register)));
										$aux_register = preg_split('/\s+/', rtrim(ltrim($aux_register)));
										
										//! Prepare the array to save in DB
										$arr_data["DATA"] = iif($aux_register[0]);	//! DATA
										$arr_data["HORA"] = iif($aux_register[1]);	//! HORA

										//! ORIGEM
										$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_register2[2])));

										for ( $c = 1; $c < (sizeof($aux_register3) - 2); $c++ )
											$arr_data["ORIGEM"] .= " " . $aux_register3[$c];

										//! NÚMERO CHAMADO
										if ( is_numeric(v_num($aux_register3[(sizeof($aux_register3) - 2)])) )
											$arr_data["N_CHAMADO"] = iif($aux_register3[(sizeof($aux_register3) - 2)]);
										else
											$arr_data["N_CHAMADO"] = iif($aux_register3[(sizeof($aux_register3) - 1)]);

										//! DURACAO
										$arr_data["DURACAO"] = iif(substr($aux_register2[2], -2) . ":" . $aux_register2[3] . ":" . substr($aux_register2[4], 0, 2));

										//! Check the time format (hh:mm:ss)
										if ( strlen($arr_data["DURACAO"]) == 8 )
										{
											$arr_data["DURACAO"] = rtrim(ltrim(format_mm_ss(format_hh_mm_ss($arr_data["DURACAO"]))));
										}

										$aux_tarifa = preg_split('/\s+/', rtrim(ltrim($aux_register2[4])));
										$arr_data["TARIFA"] = iif($aux_tarifa[1]);	//! TARIFA

										if ( isset($aux_tarifa[3]) )
										{
											$arr_data["VALOR"] = iif($aux_tarifa[2]);	//! VALOR
											$arr_data["VALOR_COBRADO"] = iif($aux_tarifa[3]);	//! VALOR COBRADO
											$aux_valor = str_replace(",", ".", $arr_data["VALOR_COBRADO"]);
										}
										else
										{
											$arr_data["VALOR"] = "";	//! VALOR
											$arr_data["VALOR_COBRADO"] = iif($aux_tarifa[2]);	//! VALOR COBRADO
											$aux_valor = str_replace(",", ".", $arr_data["VALOR_COBRADO"]);
										}

										//! Define the utilization type
										if ( strpos($arr_data["SERVICO"], "meses anteriores") !== false ) //! Períodos anteriores
											$arr_data["ID_TIPO_UTILIZACAO"] = 4;
										else if ( !compare_float($aux_valor, 0) ) //! Acima do contratado
											$arr_data["ID_TIPO_UTILIZACAO"] = 3;
										else if ( compare_float($aux_valor, 0) ) //! Dentro do plano/pacote
											$arr_data["ID_TIPO_UTILIZACAO"] = 2;
										else //! Não definido
											$arr_data["ID_TIPO_UTILIZACAO"] = 1;

										//! Send data to DB
										$query = $this->db->insert('pec.det', $arr_data);

										//! Clean array
										$arr_data["ID_TIPO_UTILIZACAO"] = 1;
										$arr_data["DATA"] = "";
										$arr_data["HORA"] = "";
										$arr_data["ORIGEM"] = "";
										$arr_data["N_CHAMADO"] = "";
										$arr_data["TARIFA"] = "";
										$arr_data["DURACAO"] = "";
										$arr_data["VALOR"] = "";
										$arr_data["TIPO"] = "";
										$arr_data["QUANTIDADE"] = "";
										$arr_data["VALOR_COBRADO"] = "";
										$arr_data["SERVICO"] = "";

										//! Increment the date counter
										$date_counter++;
										$aux_date = "";
									}
								}
								else //! TORPEDOS
								{
									//! Search terms (if necessary add more)
									$arr_search_terms = array();
									$arr_search_terms[0] = "Dados GPRS";
									$arr_search_terms[1] = "Navegação Web";
									$arr_search_terms[2] = "Torpedo";
									$arr_search_terms[3] = "Interatividade Globo";
									$arr_search_terms[4] = "Estados Unidos";

									//! Columns terms (if necessary add more)
									$arr_columns[0] = "SERVICO";
									$arr_columns[1] = "QUANTIDADE";
									$arr_columns[2] = "TARIFA";
									$arr_columns[3] = "VALOR";
									$arr_columns[4] = "VALOR_COBRADO";

									//! Explode the information with an array
									$arr_registers = multi_explode($arr_search_terms, $break02[1], true);

									//! Run trough register array (Optimized)
									for ( $i = 1; $i < sizeof($arr_registers); $i+=2 )
									{
										//! Define the detail type
										if ( strpos($tipo_chamada, "Torpedo") !== false )
											$arr_data["ID_TIPO_DET"] = 4; //! SMS
										else
											$arr_data["ID_TIPO_DET"] = 3; //! DATA

										//! Check if it's null
										if ( isset($arr_registers[$i]) && isset($arr_registers[($i+1)]) )
										{
											$aux_registers = iif($arr_registers[$i]) . " " . iif($arr_registers[($i+1)]);
											$registers = $aux_registers;
											$aux_registers = preg_split('/\s+/', ltrim(rtrim($aux_registers)));

											//! Remove unnecessary information
											if ( strpos($aux_registers[(sizeof($aux_registers) - 1)], ",") === false )
											{
												$registers = "";
												for ( $l = 0; $l < (sizeof($aux_registers) - 1); $l++ )
												{
													$registers .= " " . $aux_registers[$l];
												}
											}

											//! Breaking spaces
											$registers = preg_split('/\s+/', ltrim(rtrim($registers)));

											$aux_cont = 0;
											for ( $m = 0; $m < sizeof($registers); $m++ )
											{
												if ( v_num($registers[$m]) == "" )
													$arr_data[$arr_columns[$aux_cont]] .= " " . $registers[$m];
												else
												{
													$aux_cont += 1;
													$arr_data[$arr_columns[$aux_cont]] = $registers[$m];
												}
											}

											//! Define the utilization type
											$aux_valor = str_replace(",", ".", $arr_data["VALOR_COBRADO"]);

											if ( strpos($arr_data["SERVICO"], "meses anteriores") !== false ) //! Períodos anteriores
												$arr_data["ID_TIPO_UTILIZACAO"] = 4;
											else if ( !compare_float($aux_valor, 0) ) //! Acima do contratado
												$arr_data["ID_TIPO_UTILIZACAO"] = 3;
											else if ( compare_float($aux_valor, 0) ) //! Dentro do plano/pacote
												$arr_data["ID_TIPO_UTILIZACAO"] = 2;
											else //! Não definido
												$arr_data["ID_TIPO_UTILIZACAO"] = 1;

											//! Fix to charged value
											if ( $arr_data["VALOR_COBRADO"] == "" )
											{
												$arr_data["VALOR_COBRADO"] = $arr_data["TARIFA"];

												//! Fix to value
												if ( $arr_data["VALOR"] == "" )
													$arr_data["VALOR"] = $arr_data["VALOR_COBRADO"];

												//! Check the utilization type
												if ( !compare_float($arr_data["VALOR_COBRADO"], 0) ) //! Acima do contratado
													$arr_data["ID_TIPO_UTILIZACAO"] = 3;
											}

											//! Send data to DB
											$query = $this->db->insert('pec.det', $arr_data);

											//! Clean array
											$arr_data["ID_TIPO_UTILIZACAO"] = 1;
											$arr_data["TARIFA"] = "";
											$arr_data["VALOR"] = "";
											$arr_data["QUANTIDADE"] = "";
											$arr_data["VALOR_COBRADO"] = "";
											$arr_data["SERVICO"] = "";
										}
									}
								}
							}
						}
					}

					break;

				//! ---------------------------------------------------------------------------
				case "vivo":
				//! ---------------------------------------------------------------------------

					//! Set a limit to processing time
					ini_set('MAX_EXECUTION_TIME', -1);

					//! Run through service list
					foreach ( $this->getDetailType() as $type )
					{
						//! Check if the type exists inside the information block
						if ( preg_match($type["REGEX"], $content_) )
						{
							//! Get just the detail block
							$break01 = preg_split($type["REGEX"], $content_); //! begin

							//! Run trough pages
							$detail_block = "";
							for ( $x = 1; $x < (sizeof($break01)); $x++ )
							{
								//! Limit the info block
								if ( $type["DELIMITADOR"] != "" && strpos($break01[$x], $type["DELIMITADOR"]) !== false )
									$break02 = explode($type["DELIMITADOR"], $break01[$x]); //! end
								else if ( $type["DELIMITADOR2"] != "" && strpos($break01[$x], $type["DELIMITADOR2"]) !== false )
									$break02 = explode($type["DELIMITADOR2"], $break01[$x]); //! end
								else if ( $type["DELIMITADOR3"] != "" && preg_match($type["DELIMITADOR3"], $break01[$x]) )
									$break02 = preg_split($type["DELIMITADOR3"], $break01[$x]); //! end
								else
								{
									//! Look for duplicated itens
									foreach ( $this->getDetailType() as $type2 )
									{
										//! Check if the type exists inside the information block
										if ( preg_match($type2["REGEX"], $break01[$x]) )
										{
											//! Remove duplicated itens
											$aux_break01 = preg_split($type2["REGEX"], $break01[$x], 2);
											$break01[$x] = $aux_break01[0];
										}
									}

									$break02[0] = $break01[$x];
								}

								$detail_block .= " " . $break02[0];
							}

							//! Get the call types info
							$break03 = explode("Subtotal", $detail_block );

							//! Run trough the content sub-block
							$aux_tp_ligacao = "";
							for ( $x = 0; $x < (sizeof($break03) - 1); $x++ )
							{
								/*! 
								 * Check if the data is "espelho" or "detalhamento".
								 * To be processed, the info block must be a detailment
								*/
								if ( strpos($break03[$x], "Período") !== false )
								{
									//! Check if it's possible remove the detailment
									if ( strpos($break03[$x], "Ligações") !== false )
									{
										$aux3_break03 = explode("Ligações", $break03[$x], 2);
										$break03[$x] = "Ligações " . $aux3_break03[1];
									}
								}

								//! Remove the footer
								if ( strpos($break03[$x], "Número da Conta:") !== false )
								{
									$aux_break03 = preg_split('/Número+\s+da+\s+Conta:/', $break03[$x]);

									//! Check if the register has a header or footer
									if( preg_match($regex_date, $aux_break03[0]) || strpos($break03[$x], "(Continuação)") !== false ) //!< FOOTER AND CONTINUATION
									{
										//! Remove the info that still unnecessary
										if ( preg_match('/Utilizado+\s+Minutos\/Unidades+\s+Valor+\s+R\$+\s+Plano\/Pacote/', $break03[$x]) )
										{
											$aux2_break03 = preg_split('/Utilizado+\s+Minutos\/Unidades+\s+Valor+\s+R\$+\s+Plano\/Pacote/', $break03[$x]);

											//! Generally the term "Plano/Pacote" is duplicated
											$break03[$x] = $aux2_break03[(sizeof($aux2_break03) - 1)]; //!< The content is already adjusted
											$aux_break03 = preg_split('/Número+\s+da+\s+Conta:/', $break03[$x]);
											$break03[$x] = "";

											for ( $d = 0; $d < sizeof($aux_break03); $d++ )
											{
												//! Remove the header
												if ( isset($aux_break03[$d]) && strpos($aux_break03[$d], "(Continuação)") !== false )
												{
													$aux_break04 = explode("(Continuação)", $aux_break03[$d]);
													$break03[$x] .= " " . $aux_break04[1];
												}
												else
												{
													$break03[$x] .= " " . $aux_break03[$d]; //!< first page
												}
											}
										}
										else
										{
											$break03[$x] = "";

											for ( $d = 0; $d < sizeof($aux_break03); $d++ )
											{
												//! Remove the header
												if ( isset($aux_break03[$d]) && strpos($aux_break03[$d], "(Continuação)") !== false )
												{
													$aux_break04 = explode("(Continuação)", $aux_break03[$d]);
													$break03[$x] .= " " . $aux_break04[1];
												}
												else
												{
													$break03[$x] .= " " . $aux_break03[$d]; //!< first page
												}
											}
										}
									}
									else //!< HEADER WITHOUT CONTINUATION
									{
										//! Remove unnecessary info from header
										if ( strpos($break03[$x], "SEGURANCA") !== false )
										{
											$aux_break03 = explode("SEGURANCA", $break03[$x]);
											$break03[$x] = $aux_break03[1];
										}
										else if ( strpos($break03[$x], "OPERADORA") !== false )
										{
											$aux_break03 = explode("OPERADORA", $break03[$x]);
											$break03[$x] = "Ligações de Longa Distância OPERADORA " . $aux_break03[1];
										}
										else if ( strpos($break03[$x], "NO BRASIL") !== false )
										{
											$aux_break03 = explode("NO BRASIL", $break03[$x]);
											$break03[$x] = "NO BRASIL " . $aux_break03[1];
										}
										else if ( strpos($break03[$x], "Ligações") !== false )
										{
											$aux_break03 = explode("Ligações", $break03[$x]);
											$break03[$x] = "Ligações " . $aux_break03[1];
										}
										else if ( strpos($break03[$x], "Internet") !== false )
										{
											$aux_break03 = explode("Internet", $break03[$x]);
											$break03[$x] = "Internet " . $aux_break03[1];
										}
										else if ( strpos($break03[$x], "Torpedo") !== false )
										{
											$aux_break03 = explode("Torpedo", $break03[$x]);
											$break03[$x] = "Torpedo " . $aux_break03[1];
										}
									}
								}
								//! Remove the info that still unnecessary from "espelho da conta"
								else if ( preg_match('/Utilizado+\s+Minutos\/Unidades+\s+Valor+\s+R\$+\s+Plano\/Pacote/', $break03[$x]) )
								{
									$aux_break03 = preg_split('/Utilizado+\s+Minutos\/Unidades+\s+Valor+\s+R\$+\s+Plano\/Pacote/', $break03[$x]);

									//! Generally the term "Plano/Pacote" is duplicated
									$break03[$x] = $aux_break03[(sizeof($aux_break03) - 1)]; //!< The content is already adjusted
								}

								//! Replace terms to keep standard
								$break03[$x] = str_replace("Localidade", "Origem", $break03[$x]);

								//! Get the call types header
								$aux_data = explode("Data", $break03[$x]); //!< $aux_data[0] => columns / $aux_data[1] => data with registers
								$aux_call_type = $aux_data[0];

								//! Remove the columns name
								$aux_columns = "";
								if ( isset($aux_data[1]) && strpos($aux_data[1], "Valor R$") !== false )
								{
									$aux_columns = explode("Valor R$", $aux_data[1]);
									$aux_columns[0] = "Data " . $aux_columns[0] . "Valor(R$)"; //! Columns
								}
								else
								{
									//! The register doesn't have columns
									continue;
								}

								//! Merge registers in other pages
								$aux_info_data = "";
								for ( $b = 1; $b < sizeof($aux_data); $b++ )
								{
									//! Remove the columns name
									if ( strpos($aux_data[$b], "Valor R$") !== false )
									{
										$aux_info_data2 = explode("Valor R$", $aux_data[$b]);
										$aux_info_data .= $aux_info_data2[1];
									}
									else
									{
										$aux_info_data .= $aux_data[$b];
									}
								}

								//! Get the information (registers section)
								$aux_data[1] = $aux_info_data;

								//!======================================================================================

									//! Set a limit to processing time
									ini_set('MAX_EXECUTION_TIME', -1);

									/*!
									 * CLEAN-UP THE CALL TYPES HEADER
									*/
									$very_specific_fix = 0;

									//! Remove the unnecessary info from numeric values in header
									if ( preg_match('/([0-9])+,+([0-9])/', $aux_call_type) )
									{
										$aux_call_type = preg_split('/([0-9])+,+([0-9])/', $aux_call_type);
										$aux_call_type = $aux_call_type[1];
									}

									//! Remove unnecessary numbers from call type
									if ( is_numeric(substr(ltrim($aux_call_type), 0, 1)) )
									{
										$aux_call_type = substr($aux_call_type, 2);
									}

									//! Remove an specific case (if it's necessary)
									if( preg_match('/\s+Incluso+\s+Plano\/Pacote+\s+Utilizado+\s+Minutos\/Unidades+\s+SERVICO+\s+GESTAO+\s+-+\s+[0-9]+\w+\s/', $aux_call_type) )
									{
										$aux_call_type = preg_split('/\s+Incluso+\s+Plano\/Pacote+\s+Utilizado+\s+Minutos\/Unidades+\s+SERVICO+\s+GESTAO+\s+-+\s+[0-9]+\w+\s/', $aux_call_type);
										$aux_call_type = $aux_call_type[0] . " " . $aux_call_type[1];

										//! Very specific fix for "NO BRASIL EM ROAMING - Acesso a Caixa Postal"
										if ( strpos($aux_call_type, "NO BRASIL - EM ROAMING") !== false && strpos($aux_call_type, "Acesso a Caixa Postal") !== false )
										{
											//! Add 1 column to change the register type
											$aux_break03 = explode("*", $aux_data[1]);
											$aux_data[1] = $aux_break03[0] . " DDD *" . $aux_break03[1];
											$aux_columns[0] = str_replace("Hora", "Hora Localidade", $aux_columns[0]);
											$very_specific_fix = 1;
										}
									}
									//! Remove the info that still unnecessary
									else if ( strpos($aux_call_type, "Plano/Pacote") !== false )
									{
										$aux_call_type = explode("Plano/Pacote", $aux_call_type);

										//! Generally the term "Plano/Pacote" is duplicated
										if ( isset($aux_call_type[2]) )
											$aux_call_type = $aux_call_type[2];
										else
											$aux_call_type = $aux_call_type[1];
									}

									//! Very specific fix for "NO BRASIL EM ROAMING - Acesso a Caixa Postal"
									if ( strpos($aux_call_type, "NO BRASIL - EM ROAMING") !== false && strpos($aux_call_type, "Acesso a Caixa Postal") !== false && $very_specific_fix == 0 )
									{
										//! Add 1 column to change the register type
										$aux_break03 = explode("*", $aux_data[1]);
										$aux_data[1] = $aux_break03[0] . " DDD *" . $aux_break03[1];
										$aux_columns[0] = str_replace("Hora", "Hora Localidade", $aux_columns[0]);
									}

									//! Remove the period if necessary
									if( preg_match($regex_period, $aux_call_type) )
									{
										$aux_call_type = preg_split($regex_period, $aux_call_type);
										$aux_call_type = $aux_call_type[0];
									}
									else if( preg_match($regex_period2, $aux_call_type) )
									{
										$aux_call_type = preg_split($regex_period2, $aux_call_type);
										$aux_call_type = $aux_call_type[0];
									}

									/*!
									 * Check data consistence
									*/

									//! Check if the register is duplicated
									if ( $x != 0 )
									{									
										//! Duplicated situation
										if ( $aux_data[1] == $duplicated_reg )
										{
											//! Next loop
											continue;
										}
										else
										{
											$duplicated_reg = $aux_data[1];
										}
									}
									else
									{
										$duplicated_reg = $aux_data[1];
									}

								//!======================================================================================

								//! Check the calling division
								if ( strpos($aux_call_type, "-") !== false )
								{
									//! Classify the callings
									$aux_call = explode("-", $aux_call_type);
								}
								else
								{
									$aux_call[0] = $aux_call_type;
									$aux_call[1] = "";
								}

								//! Check the CSP number
								if ( preg_match('/OPERADORA+\s+([0-9])\w+/', $aux_call[0]) )
								{
									$aux_csp = explode("OPERADORA", $aux_call[0]);
									$csp = trim(substr($aux_csp[1], 0, 3));
								}

								//! Set CSP number
								if ( trim($csp) != "" )
									$arr_data["CSP"] = $csp;
								else
									$arr_data["CSP"] = 0;

								//!======================================================================================

									//! Set a limit to processing time
									ini_set('MAX_EXECUTION_TIME', -1);

									/*!
									 * FIXES TO CALLING CLASSIFICATION
									*/

									/*!
									 * General cases
									*/
									//! Cases with CSP is different from 0
									if ( strpos($aux_call[0], "Para") !== false && $arr_data["CSP"] != 0 )
									{
										//! Divide just in the first occurrence
										$aux_call2 = explode("Para", $aux_call_type, 2);
										$aux_call[0] = rtrim(ltrim($aux_call2[0]));
										$aux_call[1] = "Para " . rtrim(ltrim($aux_call2[1]));
									}
									//! Generic case for "Serviços de Terceiros"
									else if ( strpos($aux_call_type, "Ligações para Serviços de Terceiros") !== false )
									{
										$aux_call[0] = "SERVIÇOS";
										$aux_call[1] = "Ligações para Serviços de Terceiros";
									}
									//! Specific case for "Loja de Serviços Vivo"
									else if ( strpos($aux_call_type, "Loja de Serviços Vivo") !== false )
									{
										$aux_call[0] = "SERVIÇOS";
										$aux_call[1] = "Loja de Serviços Vivo";
									}
									//! Generic case for "NO EXTERIOR - PACOTE VOZ VIVO MUNDO"
									else if ( strpos($aux_call_type, "PACOTE VOZ VIVO MUNDO") !== false )
									{
										$aux_call[0] = "NO EXTERIOR";
										$aux_call[1] = "Ligações Realizadas / Recebidas";
									}
									//! Generic case for "NO BRASIL - EM ROAMING"
									else if ( strpos($aux_call_type, "NO BRASIL - EM ROAMING") !== false )
									{
										$aux_call2 = explode("NO BRASIL - EM ROAMING", $aux_call_type);
										$aux_call[0] = "NO BRASIL EM ROAMING";
										$aux_call[1] = rtrim(ltrim($aux_call2[1]));
									}
									//! Specific case for "Torpedo SMS"
									else if ( strpos($aux_call_type, "Torpedo SMS para Outros Serviços") !== false )
									{
										$aux_call[0] = "SERVIÇOS";
										$aux_call[1] = "Torpedo SMS para Outros Serviços";
									}
									//! Generic case for "Torpedo SMS"
									else if ( strpos($aux_call_type, "Torpedo SMS") !== false )
									{
										$aux_call2 = explode("Torpedo SMS", $aux_call_type);
										$aux_call[0] = rtrim(ltrim($aux_call2[0]));
										$aux_call[1] = "Torpedo SMS";
									}
									//! Generic case for "Foto Torpedo"
									else if ( strpos($aux_call_type, "Foto Torpedo") !== false )
									{
										$aux_call2 = explode("Foto Torpedo", $aux_call_type);
										$aux_call[0] = rtrim(ltrim($aux_call2[0]));
										$aux_call[1] = "Foto Torpedo " . rtrim(ltrim($aux_call2[1]));
									}
									//! Generic case for "Torpedo MMS"
									else if ( strpos($aux_call_type, "Torpedo MMS") !== false )
									{
										$aux_call[0] = "Serviços";
										$aux_call[1] = "Foto Torpedo MMS";
									}
									//! Generic case for "NO EXTERIOR"
									else if ( strpos($aux_call_type, "NO EXTERIOR") !== false )
									{
										$aux_call2 = explode("NO EXTERIOR", $aux_call_type);
										$aux_call[0] = "NO EXTERIOR";
										$aux_call[1] = rtrim(ltrim($aux_call2[1]));
									}
									//! Generic case for "NO EXTERIOR"
									else if ( strpos($aux_call_type, "TELEFÔNICA DATA") !== false )
									{
										$aux_call2 = explode("TELEFÔNICA DATA", $aux_call_type);
										$aux_call[0] = $aux_call2[0] . " TELEFÔNICA DATA";
										$aux_call[1] = rtrim(ltrim($aux_call2[1]));
									}
									//! Generic case for "Internet"
									else if ( strpos($aux_call_type, "Internet") !== false )
									{
										$aux_call2 = explode("Internet", $aux_call_type);
										$aux_call[0] = "Internet";
										$aux_call[1] = rtrim(ltrim($aux_call2[1]));
										$aux_call[1] = str_replace("-", "", $aux_call[1]);
									}

									//! Generic case for "NO BRASIL EM ROAMING"
									if ( strpos($aux_call[0], "Ligações") !== false && $aux_tp_ligacao == "NO BRASIL EM ROAMING" && $arr_data["CSP"] != 0 )
									{
										//! This case doesn't need hifen to separate the terms
										if ( strpos($aux_call[0], "Adicional") === false && strpos($aux_call[0], "Ligações Recebidas em Roaming") === false )
											$aux_call[1] = $aux_call[0] . " - " . $aux_call[1];
										else
											$aux_call[1] = $aux_call[0] . "" . $aux_call[1];

										$aux_call[0] = "";
									}

									//! Cases with CSP is different from 0 and carrier shown
									if ( strpos($aux_call[0], "OPERADORA") !== false && $arr_data["CSP"] != 0 && strpos($aux_call[0], "Ligações") === false )
										$aux_call[0] = "Ligações de Longa Distância " . rtrim(ltrim($aux_call[0]));

									/*!
									 * In this situation, the calling type is the same to the previous and actual register,
									 * but it's not possible recover the actual, so we just copy the previous one
									*/
									if ( strpos($aux_call[0], "Caixa Postal") === false && $aux_call[1] == "" ) //!< All cases except "Acesso a caixa postal"
									{
										$aux_call[1] = $aux_call[0];
										$aux_call[0] = $aux_tp_ligacao; //!< recover the previous calling type
									}
									else if ( $aux_call[0] == "" )
										$aux_call[0] = $aux_tp_ligacao; //!< recover the previous calling type
									else
										$aux_tp_ligacao = $aux_call[0]; //!< save the calling type to the next register (if necessary)

								//!======================================================================================

								//! Remove blank spaces
								$aux_call[0] = rtrim(ltrim($aux_call[0]));
								$aux_call[1] = rtrim(ltrim($aux_call[1]));

								//! Save in database DB the calling type
								if ( isset($aux_call[0]) && $aux_call[0] != "" )
									$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC(rtrim(ltrim($aux_call[0])), $csp);
								else
									$arr_data["ID_TIPO_LIGACAO"] = 1;

								if ( isset($aux_call[1]) && $aux_call[1] != "" )
									$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($aux_call[1])));
								else
									$arr_data["ID_TIPO_CHAMADA"] = 1;

								/*! Verify the type of information
								 * 5 columns => INTERNET
								 * 6 columns => SMS
								 * 7 columns => VOICE
								*/
								$count_column = preg_split('/\s+/', rtrim(ltrim($aux_columns[0])));
								$count_column = sizeof($count_column);

								//! Divide the data section into registers
								$registers = explode(",", $aux_data[1]);

								//! Prepare information to insert in database
								$arr_data["ID_PEC"] = $this->getIdPEC();
								$arr_data["ID_LINHA"] = $id_phone_number_;

								//! Set a limit to processing time
								ini_set('MAX_EXECUTION_TIME', -1);

								//! Run trough call type
								for ( $i = 0; $i < ( sizeof($registers) - 1 ); $i++ )
								{
									//! Add value
									if ( isset($registers[($i+1)]) )
										$registers[$i] .= "," . substr($registers[($i+1)], 0, 2);

									//! Remove some characters
									if ( $i != 0 )
										$registers[$i] = substr($registers[$i], 2);

									//! Break the register by space
									$aux_register = preg_split('/\s+/', rtrim(ltrim($registers[$i])));

									//! INFO TYPE
									$arr_data["TIPO_INFO_DET"] = 2;

									//! Check the information type
									if ( $count_column == 8 && strlen($registers[$i]) > 10 ) //!< VOICE NO EXTERIOR
									{
										$aux_count_c = 0;
										$arr_data["ID_TIPO_DET"] = 2;
										$arr_data["ID_TIPO_UTILIZACAO"] = 3;
										$arr_data["DATA"] = $aux_register[0];			//! DATA
										$arr_data["HORA"] = $aux_register[1];			//! HORA

										//! Check if the location name has more than 1 word
										for ( $c = 2; $c < (sizeof($aux_register) - 2); $c++ )
										{
											//! Check if it's a name or number
											if ( !is_numeric($aux_register[$c]) )
											{
												$arr_data["ORIGEM"] .= " " . $aux_register[$c]; //! LOCALIDADE
												$aux_count_c = ($c+1);
											}
											else
											{
												break;
											}
										}

										$arr_data["N_CHAMADO"] = $aux_register[$aux_count_c];		//! NUMERO CHAMADO
										$arr_data["TARIFA"] = $aux_register[($aux_count_c + 1)];	//! TARIFA
										$arr_data["TIPO"] = $aux_register[($aux_count_c + 2)];		//! TIPO
										$arr_data["DURACAO"] = $aux_register[($aux_count_c + 3)];	//! DURACAO
										$arr_data["VALOR"] = $aux_register[($aux_count_c + 4)];		//! VALOR
										$arr_data["CSP"] = 0;

										//! Send data to DB
										$query = $this->db->insert('pec.det', $arr_data);
									}
									else if ( $count_column == 7 && strlen($registers[$i]) > 10 ) //!< VOICE
									{
										$arr_data["ID_TIPO_DET"] = 2;
										$arr_data["DATA"] = $aux_register[0];	//! DATA
										$arr_data["HORA"] = $aux_register[1];	//! HORA

										//! Check if the register doesn't have a number
										if ( strpos($registers[$i], "-") !== false )
										{
											//! ORIGEM
											$aux_origem = explode("-", $registers[$i]);
											$aux_origem2 = explode(":", substr($aux_origem[0], 0, (sizeof($aux_origem[0])-4)));
											$arr_data["ORIGEM"] = ltrim(rtrim(substr($aux_origem2[2], 3)));

											//! Check if the calling number doesn't have "-"
											if ( sizeof($aux_origem) >= 3 )
											{
												//! NÚMERO CHAMADO
												$arr_data["N_CHAMADO"] = substr($aux_origem[0], -2) . "-" . $aux_origem[1] . "-" . rtrim(substr($aux_origem[2], 0, 5));

												//! TARIFA
												$aux_tarifa = preg_split('/\s+/', rtrim(ltrim($aux_origem[2])));
												$arr_data["QUANTIDADE"] = "";

												if ( is_numeric($aux_tarifa[1]) )
													$arr_data["QUANTIDADE"] = $aux_tarifa[1];
												else
													$arr_data["TARIFA"] = $aux_tarifa[1];

												//! DURAÇÃO
												if ( strpos($aux_tarifa[2], "m") !== false ) //! minutes
												{
													$arr_data["DURACAO"] = $aux_tarifa[2];
												}
												//! QUANTIDADE
												else if ( $arr_data["QUANTIDADE"] == "" )
												{
													$arr_data["DURACAO"] = "";
													$arr_data["QUANTIDADE"] = $aux_tarifa[2];
												}

												//! VALOR
												if ( isset($aux_tarifa[3]) )
													$arr_data["VALOR"] = $aux_tarifa[3];
												else if ( isset($aux_tarifa[2]) )
													$arr_data["VALOR"] = $aux_tarifa[2];
											}
											else
											{
												//! Break the register by space
												$aux_register2 = preg_split('/\s+/', rtrim(ltrim($aux_origem[0])));
												$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_origem[1])));

												$arr_data["N_CHAMADO"] = $aux_register2[2];	//! NÚMERO CHAMADO
												$arr_data["TARIFA"] = $aux_register2[3];	//! TARIFA

												//! TIPO
												for ( $c = 4; $c < (sizeof($aux_register2)); $c++ )
													$arr_data["TIPO"] .= " " . $aux_register2[$c];
												$arr_data["TIPO"] .= " - " . $aux_register3[0];

												//! DURAÇÃO
												if ( strpos($aux_register3[1], "m") !== false ) //! minutes
												{
													$arr_data["DURACAO"] = $aux_register3[1];
												}
												//! QUANTIDADE
												else
												{
													$arr_data["DURACAO"] = "";
													$arr_data["QUANTIDADE"] = $aux_register3[1];
												}

												//! VALOR
												$arr_data["VALOR"] = $aux_register3[2];
											}
										}
										else
										{
											$aux_register2 = explode(",", rtrim(ltrim($registers[$i])));
											$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_register2[0])));

											//! TIPO
											if ( !isset($arr_data["TIPO"]) )
												$arr_data["TIPO"] = "";

											for ( $c = 3; $c < (sizeof($aux_register3) - 2); $c++ )
												$arr_data["TIPO"] .= " " . $aux_register3[$c];

											//! DURAÇÃO
											if ( strpos($aux_register3[(sizeof($aux_register3) - 2)], "m") !== false ) //! minutes
											{
												$arr_data["DURACAO"] = $aux_register3[(sizeof($aux_register3) - 2)];
											}
											//! QUANTIDADE
											else
											{
												$arr_data["DURACAO"] = "";
												$arr_data["QUANTIDADE"] = $aux_register3[(sizeof($aux_register3) - 2)];
											}

											//! VALOR
											$arr_data["VALOR"] = $aux_register3[(sizeof($aux_register3) - 1)] . "," . $aux_register2[1];
										}

										$arr_data["ID_TIPO_UTILIZACAO"] = $type["ID_PEC_TIPO_UTILIZACAO"];

										//! Set a limit to processing time
										ini_set('MAX_EXECUTION_TIME', -1);

										//! Check if the calling type is related to Distant calls
										if ( strpos(substr(rtrim(ltrim($aux_call_type)), 0, 4), "Para") !== false && rtrim(ltrim($aux_call[0])) != "NO BRASIL EM ROAMING - Ligações de Longa Distância" )
										{
											$arr_data["ID_TIPO_UTILIZACAO"] = 3; //! Utilização acima do contratado
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Ligações de Longa Distância", 0);
											$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($aux_call_type)));
										}
										//! Fix the register classification
										else if ( strpos($aux_call_type, "Longa") !== false )
											$arr_data["ID_TIPO_UTILIZACAO"] = 3; //! Utilização acima do contratado
										else if ( strpos($break03[$x], "TERCEIROS") !== false )
											$arr_data["ID_TIPO_UTILIZACAO"] = 5; //! Serviços de terceiros
										else if ( $arr_data["VALOR"] != "0,00" && $arr_data["ID_TIPO_UTILIZACAO"] == 2 )
											$arr_data["ID_TIPO_UTILIZACAO"] = 3; //! Utilização acima do contratado

										if ( $arr_data["ID_TIPO_UTILIZACAO"] == $type["ID_PEC_TIPO_UTILIZACAO"] )
										{
											//! Check if it's necessary put an zero to CSP
											if ( $zerar_csp == 1 )
												$arr_data["CSP"] = 0;
											else
												$arr_data["CSP"] = $csp;

											//! Send data to DB
											$query = $this->db->insert('pec.det', $arr_data);
										}
									}
									else if ( $count_column == 6 && strlen($registers[$i]) > 10 ) //!< SMS
									{
										$arr_data["ID_TIPO_DET"] = 4;
										$arr_data["DATA"] = $aux_register[0];		//! DATA
										$arr_data["HORA"] = $aux_register[1];		//! HORA
										$arr_data["N_CHAMADO"] = $aux_register[2];	//! NÚMERO CHAMADO
										$arr_data["TIPO"] = "";

										$aux_register2 = explode(",", rtrim(ltrim($registers[$i])));
										$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_register2[0])));

										//! Check if it's a voice mail or SMS
										if ( rtrim(ltrim($arr_data["N_CHAMADO"])) == "*555" || rtrim(ltrim($aux_call_type)) == "Acesso a Caixa Postal" )
										{
											//! TARIFA
											for ( $c = 3; $c < (sizeof($aux_register3) - 2); $c++ )
												$arr_data["TARIFA"] .= " " . $aux_register3[$c];
										}
										else
										{
											//! TIPO
											for ( $c = 3; $c < (sizeof($aux_register3) - 2); $c++ )
												$arr_data["TIPO"] .= " " . $aux_register3[$c];
										}

										//! QUANTIDADE
										if ( rtrim(ltrim($aux_call_type)) == "Acesso a Caixa Postal" )
											$arr_data["DURACAO"] = $aux_register3[(sizeof($aux_register3) - 2)];
										else
											$arr_data["QUANTIDADE"] = $aux_register3[(sizeof($aux_register3) - 2)];

										//! VALOR
										$arr_data["VALOR"] = $aux_register3[(sizeof($aux_register3) - 1)] . "," . $aux_register2[1];

										$arr_data["ID_TIPO_UTILIZACAO"] = $type["ID_PEC_TIPO_UTILIZACAO"];

										//! Check if it's "Acesso a Caixa Postal" and "No Brasil em Roaming"
										if ( rtrim(ltrim($aux_call_type)) == "Acesso a Caixa Postal" && $arr_data["CSP"] != 0 && $arr_data["CSP"] != "" )
										{
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("NO BRASIL EM ROAMING - Acesso a Caixa Postal", 0);
										}

										//! Fix the utilization type
										if ( strpos($break03[$x], "TERCEIROS") !== false )
											$arr_data["ID_TIPO_UTILIZACAO"] = 5; //! Serviços de terceiros

										if ( rtrim(ltrim($aux_call_type)) == "Acesso a Caixa Postal" )
											$arr_data["ID_TIPO_DET"] = 2; //! Voz

										if ( $arr_data["ID_TIPO_UTILIZACAO"] == $type["ID_PEC_TIPO_UTILIZACAO"] )
										{
											//! Send data to DB
											$query = $this->db->insert('pec.det', $arr_data);
										}
									}
									else if ( $aux_call[1] == "Loja de Serviços Vivo" ) //!< Special case, treats like SMS
									{
										$arr_data["ID_TIPO_DET"] = 4;
										$arr_data["DATA"] = $aux_register[0]; //! DATA
										$arr_data["HORA"] = $aux_register[1]; //! HORA
										$arr_data["TIPO"] = "";

										$aux_register2 = explode(",", rtrim(ltrim($registers[$i])));
										$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_register2[0])));

										//! TIPO
										for ( $c = 2; $c < (sizeof($aux_register3) - 2); $c++ )
											$arr_data["TIPO"] .= " " . $aux_register3[$c];

										//! QUANTIDADE
										$arr_data["QUANTIDADE"] = $aux_register3[(sizeof($aux_register3) - 1)];

										//! VALOR
										$arr_data["VALOR"] = $aux_register3[(sizeof($aux_register3) - 1)] . "," . $aux_register2[1];

										$arr_data["ID_TIPO_UTILIZACAO"] = $type["ID_PEC_TIPO_UTILIZACAO"];

										//! Fix the utilization type
										if ( strpos($break03[$x], "TERCEIROS") !== false )
											$arr_data["ID_TIPO_UTILIZACAO"] = 5; //! Serviços de terceiros

										if ( $arr_data["ID_TIPO_UTILIZACAO"] == $type["ID_PEC_TIPO_UTILIZACAO"] )
										{
											//! Send data to DB
											$query = $this->db->insert('pec.det', $arr_data);
										}
									}
									else if ( $count_column == 5 && strlen($registers[$i]) > 10 ) //!< DADOS
									{
										$arr_data["ID_TIPO_DET"] = 3;
										$arr_data["DATA"] = $aux_register[0]; //! DATA
										$arr_data["HORA"] = $aux_register[1]; //! HORA
										$arr_data["TIPO"] = "";

										$aux_register2 = explode(",", rtrim(ltrim($registers[$i])));
										$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_register2[0])));

										//! TIPO
										for ( $c = 2; $c < (sizeof($aux_register3) - 3); $c++ )
											$arr_data["TIPO"] .= " " . $aux_register3[$c];

										//! QUANTIDADE
										$arr_data["QUANTIDADE"] = $aux_register3[(sizeof($aux_register3) - 3)] . " " . $aux_register3[(sizeof($aux_register3) - 2)];

										//! VALOR
										$arr_data["VALOR"] = $aux_register3[(sizeof($aux_register3) - 1)] . "," . $aux_register2[1];

										$arr_data["ID_TIPO_UTILIZACAO"] = $type["ID_PEC_TIPO_UTILIZACAO"];

										//! Fix the utilization type
										if ( strpos($break03[$x], "TERCEIROS") !== false )
											$arr_data["ID_TIPO_UTILIZACAO"] = 5; //! Serviços de terceiros

										if ( $arr_data["ID_TIPO_UTILIZACAO"] == $type["ID_PEC_TIPO_UTILIZACAO"] )
										{
											//! Send data to DB
											$query = $this->db->insert('pec.det', $arr_data);
										}
									}

									//! Set a limit to processing time
									ini_set('MAX_EXECUTION_TIME', -1);

									//! Clean array
									$arr_data["ID_TIPO_DET"] = 1;
									$arr_data["DATA"] = "";
									$arr_data["CSP"] = 0;
									$arr_data["HORA"] = "";
									$arr_data["ORIGEM"] = "";
									$arr_data["N_CHAMADO"] = "";
									$arr_data["TARIFA"] = "";
									$arr_data["DURACAO"] = "";
									$arr_data["VALOR"] = "";
									$arr_data["TIPO"] = "";
									$arr_data["QUANTIDADE"] = "";
									$arr_data["TIPO_INFO_DET"] = 0;
									$arr_data["ID_TIPO_UTILIZACAO"] = 1;
									$flag = 0;
									$zerar_csp = 0;
								}
							}
							//! Content clearing
							$detail_block = "";
						}
					}

					break;

				//! ---------------------------------------------------------------------------
				case "nextel":
				//! ---------------------------------------------------------------------------

					//! Prepare information to insert in database
					$arr_data["ID_PEC"] = $this->getIdPEC();
					$arr_data["ID_LINHA"] = $id_phone_number_;
					$arr_data["ID_TIPO_UTILIZACAO"] = 1;
					$is_detailed = 0;
					$status_interconexao = 0;

					//! Regex Date => E.g:(24/10/2014)
					$regex_date = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';

					//! Regex Period => E.g:(24/10/2014 à 01/11/2014)
					$regex_period = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s+a+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';
					$regex_period2 = '/(([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s+à+\s+([0-9])\w+\/+([0-9])\w+\/+([0-9])\w+\s)/';

					//! Check if the line is detailed
					if ( strpos($content_, "NAO") !== false )
						$is_detailed = 0;
					else
						$is_detailed = 1;

					//! Add Rádio Nextel to service array
					//!$this->arr_service_type[sizeof($this->arr_service_type)] = "Rádio Nextel";

					//! Divide the info and detailment block
					if ( strpos($content_, "@@@") !== false )
					{
						$aux_content = explode("@@@", $content_);
						$info_content_ = substr($aux_content[0], 3);
						//$content_ = substr($aux_content[1], 2);
						$content_ = $aux_content[1];
					}

					//! Remove the footer from content_
					if( preg_match('/SERVIÇOS+\s+([0-9])+\/+([0-9])+\s/', $content_) )
					{
						//! Needs to clean the block
						$aux_content_ = preg_split('/SERVIÇOS+\s+([0-9])+\/+([0-9])+\s/', $content_);
						$content_ = $aux_content_[0];

						//! Connect all pages
						for ( $a = 1; $a < sizeof($aux_content_); $a++ )
						{
							if ( strpos($aux_content_[$a], "DETALHAMENTO DE SERVIÇOS") !== false )
							{
								$aux_content2_ = explode("DETALHAMENTO DE SERVIÇOS", $aux_content_[$a], 2);
								$content_ .= " " . $aux_content2_[1];
							}
							else if ( strpos($aux_content_[$a], "DEMONSTRATIVO DE SERVIÇOS") !== false )
							{
								$aux_content2_ = explode("DEMONSTRATIVO DE SERVIÇOS", $aux_content_[$a], 2);
								$content_ .= " " . $aux_content2_[1];
							}
						}
					}

					//! Fix to services identification
					$content_ = str_replace("Dentro da área de registro", "Chamadas Dentro da área de registro", $content_);
					$content_ = str_replace("Roaming Nacional Dentro da Rede Nextel", "Chamadas em Roaming Nacional Dentro da Rede Nextel", $content_);

					//!********************************************************************************
					//! ***************************** INFORMATION SECTION *****************************
					//!********************************************************************************

					//! Limit the information block
					if ( isset($info_content_) )
						$aux_break_info = explode("Total do Nº:", $info_content_);
					else
						$aux_break_info = explode("Total do Nº:", $content_);

					//! Check if the header has valid information
					if ( strpos($aux_break_info[0], "O QUE FOI UTILIZADO") !== false )
					{
						//! Remove the contracted itens
						$aux_break_info2 = explode("O QUE FOI UTILIZADO", $aux_break_info[0], 2);
						$aux_break_info[0] = $aux_break_info2[1];

						//! Break info by calling type
						$break02_info = explode("Subtotal", $aux_break_info[0]);

						//! Check if the service type has just one calling type
						$steps = 0;
						if ( sizeof($break02_info) == 1 )
							$steps = 1;
						else
							$steps = (sizeof($break02_info) - 1);

						//! Run through all header services
						for ( $i = 0; $i < $steps; $i++ )
						{
							$arr_data["ID_TIPO_UTILIZACAO"] = 2; //! Dentro do plano/pacote

							/*! Ignore the following itens because they are extracted from detailment:
							 * radio location (not used)
							 * general callings
							 * data services
							 * sms
							 * roaming
							*/
							if ( ( $is_detailed == 0 && strpos($break02_info[$i], "Locação") === false && strpos($break02_info[$i], "Aluguel") === false ) 
								|| ( $is_detailed == 1 && ( strpos($break02_info[$i], "Locação") === false && strpos($break02_info[$i], "Aluguel") === false && 
								strpos($break02_info[$i], "Dentro da área de") === false && strpos($break02_info[$i], "Serviços de Dados") === false &&
								strpos($break02_info[$i], "SMS") === false && strpos($break02_info[$i], "Roaming") === false && strpos($break02_info[$i], "Outras Chamadas") === false ) ) )
							{
								$additional_column = 0;

								//! Break info in sub-itens
								$break01_info = explode("Subtotal", $break02_info[$i]);
								$break03_info = explode(",", $break01_info[0]);

								//! Check if the service type has just one calling type
								$sub_itens = 0;
								if ( sizeof($break03_info) == 1 )
									$sub_itens = 1;
								else
									$sub_itens = (sizeof($break03_info) - 1);

								//! Process all the sub-itens
								for ( $j = 0; $j < $sub_itens; $j++ )
								{
									//! Check if the register is valid
									if ( !preg_match('/[A-Z]+[a-z]+/', $break03_info[$j]) )
									{
										continue;
									}

									//! Remove unnecessary info from string 
									$break03_info[$j] = str_replace("registro", "", $break03_info[$j]);

									//! Merge the cents with the actual value
									if ( isset($break03_info[($j+1)]) )
									{
										$break03_info[$j] .= "," . substr($break03_info[($j+1)], 0, 2);
										$break03_info[($j+1)] = substr($break03_info[($j+1)], 2, strlen($break03_info[($j+1)]));
									}

									//! Check if the column "Ilimitadas ou Grátis (Minutos)" exists
									if ( strpos($break03_info[$j], "Grátis") !== false )
										$additional_column = 1;

									//! Remove the columns (if necessary)
									$status_chance = 0;
									if ( strpos($break03_info[$j], "Valor R$") !== false )
									{
										$aux_break02_d = explode("Valor R$", $break03_info[$j]);
										$break03_info[$j] = $aux_break02_d[1];

										//! Fix the service name (if it's necessary)
										if ( strpos($break03_info[$j], "Prip") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Rádio Nextel", 0);
											$break03_info[$j] = str_replace("Rádio Nextel", "", $break03_info[$j]);
											$status_chance = 1;
											$arr_data["ID_TIPO_DET"] = 2; //! VOICE
										}
										else if ( strpos($break03_info[$j], "Serviços Adicionais") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Serviços Adicionais", 0);
											//$break03_info[$j] = str_replace("Serviços Adicionais", "", $break03_info[$j]);
											$status_chance = 1;

											if ( strpos($break03_info[$j], "SMS") !== false )
												$arr_data["ID_TIPO_DET"] = 4; //! SMS
											else
												$arr_data["ID_TIPO_DET"] = 3; //! DATA
										}
										else if ( strpos($break03_info[$j], "SMS Nextel") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("SMS Nextel", 0);
											$break03_info[$j] = str_replace("Serviços de Dados", "", $break03_info[$j]);
											$status_chance = 1;
											$arr_data["ID_TIPO_DET"] = 4; //! SMS
										}
										else if ( strpos($break03_info[$j], "Serviços de Dados") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Serviços de Dados", 0);
											//$break03_info[$j] = str_replace("Serviços de Dados", "", $break03_info[$j]);
											$status_chance = 1;
											$arr_data["ID_TIPO_DET"] = 3; //! DATA
										}
										else if ( strpos($break03_info[$j], "Rádio Digital") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Rádio Nextel", 0);
											$break03_info[$j] = str_replace("Rádio Nextel", "", $break03_info[$j]);
											$status_chance = 1;
											$arr_data["ID_TIPO_DET"] = 2; //! VOICE
										}
										else if ( strpos($break03_info[$j], "Chamadas Dentro da área de") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Chamadas Dentro da área de registro", 0);
											$break03_info[$j] = str_replace("Chamadas Dentro da área de", "", $break03_info[$j]);
											$status_chance = 1;
											$arr_data["ID_TIPO_DET"] = 2; //! VOICE
										}
										else if ( strpos($break03_info[$j], "Outras Chamadas") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Outras Chamadas", 0);
											$break03_info[$j] = str_replace("Outras Chamadas", "", $break03_info[$j]);
											$status_chance = 1;
											$arr_data["ID_TIPO_DET"] = 2; //! VOICE
										}
										else if ( strpos($break03_info[$j], "Chamadas em Roaming") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Chamadas em Roaming Nacional Dentro da Rede", 0);
											$break03_info[$j] = str_replace("Chamadas em Roaming", "", $break03_info[$j]);
											$status_chance = 1;
											$arr_data["ID_TIPO_DET"] = 2; //! VOICE
										}
										else if ( strpos($break03_info[$j], "APN") !== false )
										{
											//! Get Calling Type ID
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Serviços Adicionais", 0);
											$break03_info[$j] = str_replace("Serviços Adicionais", "", $break03_info[$j]);
											$status_chance = 1;
											$arr_data["ID_TIPO_DET"] = 3; //! DATA
										}
									}

									//! Check if the calling ID was changed
									if ( $status_chance == 0 )
									{
										//! Get Calling Type ID
										if ( !is_numeric($arr_data["ID_TIPO_LIGACAO"]) )
											$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC(rtrim(ltrim($arr_data["ID_TIPO_LIGACAO"])), 0);
										$arr_data["ID_TIPO_DET"] = 2; //! VOICE
									}

									/*! Handle different cases
									 * Header with time
									*/
									if ( strpos($break03_info[$j], ":") !== false )
									{
										$aux_break02_info = explode(":", $break03_info[$j], 2);
										$aux_break03_info = preg_split('/\s+/', rtrim(ltrim($aux_break02_info[1])));
										$aux_descritivo = preg_split('/\s+/', rtrim(ltrim($aux_break02_info[0])));

										//! DESCRITIVO
										$arr_data["DESCRITIVO"] = "";
										for ( $m = 0; $m < (sizeof($aux_descritivo) - 1); $m++ )
											$arr_data["DESCRITIVO"] .= " " . $aux_descritivo[$m];

										//! FIX to remove unnecessary info from calling type
										if ( strpos($arr_data["DESCRITIVO"], "Chamadas") !== false )
										{
											$aux_chamada = explode("Chamadas", $arr_data["DESCRITIVO"]);
											$arr_data["DESCRITIVO"] = "Chamadas " . $aux_chamada[1];
										}

										//! Get Calling Type ID
										$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($arr_data["DESCRITIVO"])));

										//! INCLUSO
										$arr_data["INCLUSO"] = iif($aux_descritivo[(sizeof($aux_descritivo) - 1)] . ":" . $aux_break03_info[0]);

										if ( $additional_column == 0 )
										{
											//! UTILIZAD0
											$arr_data["UTILIZADO"] = iif($aux_break03_info[1]);

											//! EXCEDENTE
											$arr_data["EXCEDENTE"] = iif($aux_break03_info[2]);

											//! VALOR
											$arr_data["VALOR"] = iif($aux_break03_info[3]);

											//! INFO TYPE
											$arr_data["TIPO_INFO_DET"] = 1;
										}
										else
										{
											//! UTILIZAD0
											$arr_data["UTILIZADO"] = iif($aux_break03_info[2]);

											//! EXCEDENTE
											$arr_data["EXCEDENTE"] = iif($aux_break03_info[3]);

											//! VALOR
											$arr_data["VALOR"] = iif($aux_break03_info[4]);

											//! INFO TYPE
											$arr_data["TIPO_INFO_DET"] = 1;
										}
									}
									/*! Specific case
									 * Header with APN
									*/
									else if ( strpos($break03_info[$j], "_ APN") !== false )
									{
										$aux_break02_info = explode("MB", $break03_info[$j], 2);
										$aux_break03_info = preg_split('/\s+/', rtrim(ltrim($aux_break02_info[1])));
										$aux_descritivo = preg_split('/\s+/', rtrim(ltrim($aux_break02_info[0])));

										//! DESCRITIVO
										$arr_data["DESCRITIVO"] = "_ APN";

										//! Get Calling Type ID
										$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($arr_data["DESCRITIVO"])));

										//! INCLUSO
										$arr_data["INCLUSO"] = iif($aux_descritivo[(sizeof($aux_descritivo) - 1)] . "MB " . $aux_break03_info[0] . "KB");

										//! UTILIZAD0
										$arr_data["UTILIZADO"] = iif($aux_break03_info[2] . " " . $aux_break03_info[3] . "KB");

										//! EXCEDENTE
										$arr_data["EXCEDENTE"] = iif($aux_break03_info[5] . " " . $aux_break03_info[6] . "KB");

										//! VALOR
										$arr_data["VALOR"] = iif($aux_break03_info[8]);

										//! INFO TYPE
										$arr_data["TIPO_INFO_DET"] = 1;
									}
									/*! Specific case
									 * Header with Serviços Adicionais
									*/
									else if ( strpos($break03_info[$j], "Serviços Adicionais") !== false )
									{
										$m = 0;
										$break03_info[$j] = str_replace("Serviços Adicionais", "", $break03_info[$j]);
										$aux_descritivo = preg_split('/\s+/', rtrim(ltrim($break03_info[$j])));

										//! DESCRITIVO
										$arr_data["DESCRITIVO"] = "";
										for ( ; $m < (sizeof($aux_descritivo) - 1); $m++ )
										{
											if ( !is_numeric($aux_descritivo[$m]) )
												$arr_data["DESCRITIVO"] .= " " . $aux_descritivo[$m];
											else
												break;
										}

										//! Get Calling Type ID
										$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($arr_data["DESCRITIVO"])));

										//! INCLUSO
										$arr_data["INCLUSO"] = iif($aux_descritivo[($m)]);

										//! UTILIZAD0
										$arr_data["UTILIZADO"] = iif($aux_descritivo[($m + 1)]);

										//! EXCEDENTE
										$arr_data["EXCEDENTE"] = iif($aux_descritivo[($m + 2)]);

										//! VALOR
										$arr_data["VALOR"] = iif($aux_descritivo[($m + 3)]);

										//! INFO TYPE
										$arr_data["TIPO_INFO_DET"] = 1;
									}
									/*! Specific case
									 * Header with SMS Nextel
									*/
									else if ( strpos($break03_info[$j], "SMS Nextel") !== false )
									{
										$aux_descritivo = preg_split('/\s+/', rtrim(ltrim($break03_info[$j])));

										//! DESCRITIVO
										$arr_data["DESCRITIVO"] = iif($aux_descritivo[0]) . " " . iif($aux_descritivo[1]);

										//! Get Calling Type ID
										$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($arr_data["DESCRITIVO"])));

										//! INCLUSO
										$arr_data["INCLUSO"] = iif($aux_descritivo[2]);

										//! UTILIZAD0
										$arr_data["UTILIZADO"] = iif($aux_descritivo[3]);

										//! EXCEDENTE
										$arr_data["EXCEDENTE"] = iif($aux_descritivo[4]);

										//! VALOR
										$arr_data["VALOR"] = iif($aux_descritivo[5]);

										//! INFO TYPE
										$arr_data["TIPO_INFO_DET"] = 1;
									}
									/*! Specific case
									 * Header with Serviços de Dados
									*/
									else if ( strpos($break03_info[$j], "Serviços de Dados") !== false )
									{
										$break03_info[$j] = str_replace("Serviços de Dados", "", $break03_info[$j]);
										$aux_descritivo = preg_split('/\s+/', rtrim(ltrim($break03_info[$j])));

										//! DESCRITIVO
										$arr_data["DESCRITIVO"] = iif($aux_descritivo[0]);

										//! Get Calling Type ID
										$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($arr_data["DESCRITIVO"])));

										//! INCLUSO
										$arr_data["INCLUSO"] = iif($aux_descritivo[1]);

										//! UTILIZAD0
										$arr_data["UTILIZADO"] = iif($aux_descritivo[2]);

										//! EXCEDENTE
										$arr_data["EXCEDENTE"] = iif($aux_descritivo[3]);

										//! VALOR
										$arr_data["VALOR"] = iif($aux_descritivo[4]);

										//! INFO TYPE
										$arr_data["TIPO_INFO_DET"] = 1;
									}

									//! FIX related to Digital Radio
									if ( rtrim(ltrim($arr_data["DESCRITIVO"])) == "Rádio Digital - Individual" )
									{
										$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Rádio Nextel", 0);
									}

									//! Check if the Utilization is aligned with the register value
									if ( $arr_data["VALOR"] == "0,00" || $arr_data["VALOR"] == "" )
										$arr_data["ID_TIPO_UTILIZACAO"] = 2;
									else
										$arr_data["ID_TIPO_UTILIZACAO"] = 3;

									//! Send data to DB
									$query = $this->db->insert('pec.det', $arr_data);
								}
							}

							//! Clean array
							$arr_data["ID_TIPO_UTILIZACAO"] = 1;
							$arr_data["ID_TIPO_DET"] = 1;
							$arr_data["ID_TIPO_LIGACAO"] = 1;
							$arr_data["ID_TIPO_CHAMADA"] = 1;
							$arr_data["DATA"] = "";
							$arr_data["HORA"] = "";
							$arr_data["ORIGEM"] = "";
							$arr_data["N_CHAMADO"] = "";
							$arr_data["TARIFA"] = "";
							$arr_data["DURACAO"] = "";
							$arr_data["VALOR"] = "";
							$arr_data["TIPO"] = "";
							$arr_data["QUANTIDADE"] = "";
							$arr_data["TIPO_INFO_DET"] = 0;
							$arr_data["INCLUSO"] = "";
							$arr_data["UTILIZADO"] = "";
						}
					}
					//!< If the line doesn't have any utilization, it needs to post the Radio data
					else
					{
						$arr_data["ID_TIPO_DET"] = 2; //! VOICE
						$arr_data["ID_TIPO_UTILIZACAO"] = 2; //! Dentro do plano/pacote

						//! Get Calling Type ID
						$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Rádio Nextel", 0);						
						$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC("Rádio Digital - Individual");

						//! DESCRITIVO
						$arr_data["DESCRITIVO"] = "Rádio Digital - Individual";

						//! INCLUSO
						$arr_data["INCLUSO"] = "00:00";

						//! UTILIZAD0
						$arr_data["UTILIZADO"] = "00:00";

						//! EXCEDENTE
						$arr_data["EXCEDENTE"] = "00:00";

						//! VALOR
						$arr_data["VALOR"] = "0,00";

						//! INFO TYPE
						$arr_data["TIPO_INFO_DET"] = 1;

						//! Send data to DB
						$query = $this->db->insert('pec.det', $arr_data);

						//! Clean array
						$arr_data["ID_TIPO_UTILIZACAO"] = 1;
						$arr_data["ID_TIPO_DET"] = 1;
						$arr_data["ID_TIPO_LIGACAO"] = 1;
						$arr_data["ID_TIPO_CHAMADA"] = 1;
						$arr_data["DATA"] = "";
						$arr_data["HORA"] = "";
						$arr_data["ORIGEM"] = "";
						$arr_data["N_CHAMADO"] = "";
						$arr_data["TARIFA"] = "";
						$arr_data["DURACAO"] = "";
						$arr_data["VALOR"] = "";
						$arr_data["TIPO"] = "";
						$arr_data["QUANTIDADE"] = "";
						$arr_data["TIPO_INFO_DET"] = 0;
						$arr_data["INCLUSO"] = "";
						$arr_data["UTILIZADO"] = "";
					}

					//!********************************************************************************
					//! ****************************** DETAILMENT SECTION *****************************
					//!********************************************************************************
					for ( $x = 0; $x < sizeof($this->arr_service_type); $x++ )
					{
						//! Check if the service type is inside the content
						if ( strpos($content_, rtrim(ltrim($this->arr_service_type[$x]))) !== false )
						{
							// Detailment block
							$break01_detail = explode(rtrim(ltrim($this->arr_service_type[$x])), $content_);
							$arr_data["ID_TIPO_LIGACAO"] = $this->arr_service_type[$x];
							$content_block_detail = "";

							//! Solve the exception of "Outras chamadas"
							if ( rtrim(ltrim($this->arr_service_type[$x])) == "Outras Chamadas" && sizeof($break01_detail) >= 4 )
							{
								$content_block_detail = "Outras Chamadas" . $break01_detail[(sizeof($break01_detail) - 1)];
							}
							else
							{
								//! Merge the detailment block
								for ( $i = 1; $i < sizeof($break01_detail); $i++ )
								{
									$content_block_detail .= " " . $break01_detail[$i];
								}
							}

							//! Limit the detailment block
							$aux_break_detail = explode("Total Geral", $content_block_detail);

							//! Break info by calling type
							$break02_detail = explode("Subtotal", $aux_break_detail[0]);

							//! Check if the service type has just one calling type
							$steps = 0;
							if ( sizeof($break02_detail) == 1 )
								$steps = 1;
							else
								$steps = (sizeof($break02_detail) - 1);

							for ( $i = 0; $i < $steps; $i++ )
							{
								//! Update the calling type
								$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC($this->arr_service_type[$x], 0);

								//! Check if service has a detailed section
								if ( strpos($break02_detail[$i], "Data") !== false )
								{
									//! Split the calling type from columns
									$break03_detail = explode("Data", $break02_detail[$i]);

									//! Connect break03_detail itens and remove the page footer/header
									$break04_detail = "";

									for ( $u = 0; $u < sizeof($break03_detail); $u++ )
									{
										//! Concatenate the information block and remove the unnecessary info
										if ( strpos($break03_detail[$u], "SERVIÇOS") !== false )
										{
											//! Remove footer from page
											$aux_break04_detail = explode("SERVIÇOS", $break03_detail[$u]);
											$break04_detail .= rtrim(ltrim($aux_break04_detail[0])) . " ";

											//! Get the Calling Type
											if ( preg_match("/DETALHAMENTO\s+DE\s+SERVIÇOS/", $break03_detail[$u]) )
											{
												/*!! Add the calling type to the information block */
												$aux_break04_detail = explode("DETALHAMENTO DE SERVIÇOS", $break03_detail[$u]);
												$break04_detail .= "" . rtrim(ltrim($aux_break04_detail[1])) . " ";
											}
										}
										/*! Cannot be the first item because the information block needs to have at least
										one colum ocurrence*/
										else if ( (strpos($break03_detail[$u], "Valor R$") !== false) && $u > 1 )
										{
											$aux_break04_detail = explode("Valor R$", $break03_detail[$u]);
											$break04_detail .= rtrim(ltrim($aux_break04_detail[1])) . " ";
										}
										else
										{
											$break04_detail .= rtrim(ltrim($break03_detail[$u])) . " ";
										}
									}

									//! Check if the information block has s previous register in the beginning
									if ( strpos(substr($break04_detail, 0, 20), ",") !== false )
									{
										$aux_call_type = explode(",", $break04_detail);
										$arr_data["ID_TIPO_CHAMADA"] = substr(rtrim(ltrim($aux_call_type[1])), 3);

										//! Get just the information related to the Calling Type
										if ( strpos( strtoupper($arr_data["ID_TIPO_CHAMADA"]), "HORA") !== false )
										{
											$aux_call_type = explode("Hora", $arr_data["ID_TIPO_CHAMADA"]);
											$arr_data["ID_TIPO_CHAMADA"] = $aux_call_type[0];										
										}
									}
									//! Get just the information related to the Calling Type
									else
									{
										$aux_call_type = explode("Hora", $break04_detail);
										$arr_data["ID_TIPO_CHAMADA"] = $aux_call_type[0];										
									}

									//! Split the columns from contents
									$aux_columns = explode("Valor R$", $break04_detail);

									//! Get the content
									if ( isset($aux_columns[1]) )
										$registers = explode(",", $aux_columns[1]);
									else
										$registers = explode(",", $aux_columns[0]);

									//! Get the columns
									$aux_columns = explode("Hora", $aux_columns[0]);
									$columns = "Data Hora " . $aux_columns[1] . " Valor";
									$columns = mb_strtoupper($columns, 'UTF-8');
									$columns = str_replace("Nº CHAMADO", "N_CHAMADO", $columns);
									$columns = str_replace("TIPO DE TARIFA", "TIPO_TARIFA", $columns);
									$count_column = preg_split('/\s+/', rtrim(ltrim($columns)));

									//! FIX to Chamadas Chamadas case
									if ( preg_match("/Chamadas\s+Chamadas/", $arr_data["ID_TIPO_CHAMADA"]) )
									{
										$arr_data["ID_TIPO_CHAMADA"] = preg_replace("/Chamadas\s+Chamadas/", "Chamadas", $arr_data["ID_TIPO_CHAMADA"]);
									}

									//! Get Calling Type ID
									$aux_calling_type = $arr_data["ID_TIPO_CHAMADA"];

									//! Remove Not defined cases

									/*!! Check if ID_TIPO_CHAMADA is equivalent to "Outras Chamadas (Outras Chamadas)" */
									if ( ( rtrim(ltrim($arr_data["ID_TIPO_CHAMADA"])) == "" || is_numeric(rtrim(ltrim($arr_data["ID_TIPO_CHAMADA"]))) ) && strpos($arr_data["ID_TIPO_LIGACAO"], "Outras Chamadas") !== false )
									{
										$arr_data["ID_TIPO_CHAMADA"] = "Outras Chamadas";
									}

									//! Correct a specific case
									if ( strpos($arr_data["ID_TIPO_CHAMADA"], "DADOS DO CLIENTENOME:") !== false )
									{
										//$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC("Chamadas Dentro da área de registro", 0);
										$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC("Chamadas para celulares de Outras Operadoras");	
									}
									else
									{
										$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($arr_data["ID_TIPO_CHAMADA"])));
									}

									//! Run trough the registers block
									for ( $j = 0; $j < (sizeof($registers) - 1); $j++ )
									{
										//! Add value to the register line
										if ( isset($registers[($j+1)]) )
											$registers[$j] .= "," . substr($registers[($j+1)], 0, 2);

										//! Remove some characters
										if ( $j != 0 )
											$registers[$j] = substr($registers[$j], 2);

										//! Remove the header information from register
										if ( strpos($registers[$j], "Interconexão") === false )
										{
											preg_match($regex_date, $registers[$j], $reg_date);			//!< get the register date
											$aux_reg = explode(trim($reg_date[1]), $registers[$j]); 	//!< split the register to remove the header info
											$registers[$j] = $reg_date[1] . " " . trim($aux_reg[1]);	//!< merge the clean data with the date											
										}

										//! Break the register by space
										$aux_register = preg_split('/\s+/', rtrim(ltrim($registers[$j])));

										//! Define the type of info
										$arr_data["TIPO_INFO_DET"] = 2;

										//! Check the information type
										if ( strlen($registers[$j]) != 21 && sizeof($count_column) == 8 ) //! VOICE
										{
											//! Define the detail type
											$arr_data["ID_TIPO_DET"] = 2;

											//! Check if it has interconnection
											if ( strpos($registers[$j], "Interconexão") !== false || ( isset($registers[($j+1)]) && strpos($registers[($j+1)], "Interconexão") !== false ) )
											{
												$registers[$j] = str_replace("Interconexão", "", $registers[$j]);

												//! Get the interconnection value
												if ( strpos($registers[$j], "Interconexão") !== false )
													$aux_interconnection = explode("Interconexão", $registers[$j]);
												else
													$aux_interconnection = explode("Interconexão", $registers[($j+1)] . "," . rtrim(ltrim(substr($registers[($j+2)], 0, 2))));

												//! Check if the value of interconnection was found
												if ( isset($aux_interconnection[1]) )
												{
													$arr_data["INTERCONEXAO"] = rtrim(ltrim($aux_interconnection[1])); 
													$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC( rtrim(ltrim($aux_calling_type . " - Interconexão")) );
													$arr_data["ID_TIPO_UTILIZACAO"] = 3; //! Acima do contratado
													$status_interconexao = 1;
												}
											}

											$arr_data["DATA"] = iif($aux_register[0]);	//! DATA
											$arr_data["HORA"] = iif($aux_register[1]);	//! HORA

											$aux_register2 = explode(",", rtrim(ltrim($registers[$j])));
											$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_register2[0])));

											//! TIPO
											$arr_data["TIPO"] = iif($aux_register3[(sizeof($aux_register3) - 3)]);

											//! ORIGEM_DESTINO
											$arr_data["ORIGEM_DESTINO"] = "";
											for ( $c = 2; $c < (sizeof($aux_register3) - 4); $c++ )
												$arr_data["ORIGEM_DESTINO"] .= " " . iif($aux_register3[$c]);

											//! N_CHAMADO
											$arr_data["N_CHAMADO"] = iif($aux_register3[(sizeof($aux_register3) - 4)]);

											//! DURAÇÃO
											if ( strpos($aux_register3[(sizeof($aux_register3) - 2)], ":") !== false ) //! minutes
											{
												$arr_data["DURACAO"] = iif($aux_register3[(sizeof($aux_register3) - 2)]);
											}

											//! VALOR
											$arr_data["VALOR"] = iif($aux_register3[(sizeof($aux_register3) - 1)] . "," . $aux_register2[1]);

											//! Check the "Utilization Type" register by register
											if ( $arr_data["VALOR"] == "0,00" && $status_interconexao == 0 )
												$arr_data["ID_TIPO_UTILIZACAO"] = 2; //! Dentro do pacote
											else
												$arr_data["ID_TIPO_UTILIZACAO"] = 3; //! Acima do contratado

											//! Send data to DB
											$query = $this->db->insert('pec.det', $arr_data);
										}
										else if ( strlen($registers[$j]) != 21 && sizeof($count_column) == 7 && $aux_calling_type == "Outras Chamadas" ) //! OTHER CALLINGS
										{
											//! Define the detail type
											$arr_data["ID_TIPO_DET"] = 2;

											$arr_data["DATA"] = iif($aux_register[0]);	//! DATA
											$arr_data["HORA"] = iif($aux_register[1]);	//! HORA

											$aux_register2 = explode(",", rtrim(ltrim($registers[$j])));
											$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_register2[0])));

											//! TIPO
											$arr_data["TIPO"] = iif($aux_register3[(sizeof($aux_register3) - 2)]);

											//! ORIGEM_DESTINO
											$arr_data["ORIGEM_DESTINO"] = "";
											for ( $c = 2; $c < (sizeof($aux_register3) - 3); $c++ )
												$arr_data["ORIGEM_DESTINO"] .= " " . iif($aux_register3[$c]);

											//! N_CHAMADO
											$arr_data["N_CHAMADO"] = iif($aux_register3[(sizeof($aux_register3) - 3)]);

											//! VALOR
											$arr_data["VALOR"] = iif($aux_register3[(sizeof($aux_register3) - 1)] . "," . $aux_register2[1]);

											//! Check the "Utilization Type" register by register
											if ( $arr_data["VALOR"] == "0,00" && $status_interconexao == 0 )
												$arr_data["ID_TIPO_UTILIZACAO"] = 2; //! Dentro do pacote
											else
												$arr_data["ID_TIPO_UTILIZACAO"] = 3; //! Acima do contratado

											//! Send data to DB
											$query = $this->db->insert('pec.det', $arr_data);
										}
										else if ( strlen($registers[$j]) != 21 && sizeof($count_column) == 7 ) //! DATA
										{
											if ( strpos($aux_calling_type, "SMS") !== false )
											{
												//! Define the detail type
												$arr_data["ID_TIPO_DET"] = 4;
												$arr_data["QUANTIDADE"] = 1;
											}
											else
											{
												//! Define the detail type
												$arr_data["ID_TIPO_DET"] = 3;
											}

											$arr_data["DATA"] = iif($aux_register[0]);	//! DATA
											$arr_data["HORA"] = iif($aux_register[1]);	//! HORA

											$aux_register2 = explode(",", rtrim(ltrim($registers[$j])));
											$aux_register3 = preg_split('/\s+/', rtrim(ltrim($aux_register2[0])));

											//! TIPO
											$arr_data["TIPO"] = iif($aux_register3[(sizeof($aux_register3) - 2)]);

											//! ORIGEM_DESTINO
											$arr_data["ORIGEM_DESTINO"] = "";
											for ( $c = 2; $c < (sizeof($aux_register3) - 3); $c++ )
												$arr_data["ORIGEM_DESTINO"] .= " " . iif($aux_register3[$c]);

											//! Change the value column
											if ( strpos($arr_data["ORIGEM_DESTINO"], "Jogos e") !== false )
											{
												//! ORIGEM_DESTINO
												$arr_data["ORIGEM_DESTINO"] = str_replace("Jogos e", "", $arr_data["ORIGEM_DESTINO"]);

												//! N_CHAMADO
												$arr_data["N_CHAMADO"] = "Jogos e Aplicativos";
											}
											else
											{
												//! N_CHAMADO
												$arr_data["N_CHAMADO"] = iif($aux_register3[(sizeof($aux_register3) - 3)]);
											}

											//! VALOR
											$arr_data["VALOR"] = iif($aux_register3[(sizeof($aux_register3) - 1)] . "," . $aux_register2[1]);

											//! Check the "Utilization Type" register by register
											if ( $arr_data["VALOR"] == "0,00" && $status_interconexao == 0 )
												$arr_data["ID_TIPO_UTILIZACAO"] = 2; //! Dentro do pacote
											else
												$arr_data["ID_TIPO_UTILIZACAO"] = 3; //! Acima do contratado

											//! Send data to DB
											$query = $this->db->insert('pec.det', $arr_data);
										}
									}

									//! Clean array
									$arr_data["ID_TIPO_UTILIZACAO"] = 1;
									$arr_data["ID_TIPO_DET"] = 1;
									$arr_data["ID_TIPO_LIGACAO"] = 1;
									$arr_data["ID_TIPO_CHAMADA"] = 1;
									$arr_data["DATA"] = "";
									$arr_data["HORA"] = "";
									$arr_data["ORIGEM"] = "";
									$arr_data["N_CHAMADO"] = "";
									$arr_data["TARIFA"] = "";
									$arr_data["DURACAO"] = "";
									$arr_data["VALOR"] = "";
									$arr_data["TIPO"] = "";
									$arr_data["QUANTIDADE"] = "";
									$arr_data["TIPO_INFO_DET"] = 0;
									$arr_data["INTERCONEXAO"] = "";
									$status_interconexao = 0;
								}
							}
						}
					}
					break;

				//! ---------------------------------------------------------------------------
				case "tim":
				//! ---------------------------------------------------------------------------

					//! Auxiliary variables
					$tipo_chamada = "";
					$tipo_ligacao = "";
					$columns = "";
					$information = "";

					//! Remove trash from content block
					$content_ = preg_replace('/([0-9]{8})\s+-\s+([0-9]{6})\s+\/\s+([0-9]{6})/', '', $content_);

					//! Check if the detail block has registers
					if ( strpos($content_, "Valor") !== false )
					{
						//! Get just the detail block
						$break01 = explode("Valor", $content_); //! begin

						//! Adjust the info block to classify the registers
						for ( $x = 1; $x < (sizeof($break01) - 1); $x++ )
						{
							//! Get the calling type (tipo de ligação)
							if ( strpos($break01[($x - 1)], "DETALHAMENTO") !== false )
							{
								//! Split just the calling type part
								$aux_break01 = explode("DETALHAMENTO", $break01[($x - 1)]);
								$aux_break01[1] = "DETALHAMENTO " . ltrim( rtrim($aux_break01[1]) );

								if ( strpos($aux_break01[1], "Chamadas") !== false )
									$aux_tipo_ligacao = explode("Chamadas", $aux_break01[1]);
								else if ( strpos($aux_break01[1], "Conexões") !== false )
									$aux_tipo_ligacao = explode("Conexões", $aux_break01[1]);
								else if ( strpos($aux_break01[1], "Torpedo") !== false )
									$aux_tipo_ligacao = explode("Torpedo", $aux_break01[1]);
								else
									$aux_tipo_ligacao[0] = $break01[($x - 1)];

								$tipo_ligacao = str_replace("DETALHAMENTO DE", "", $aux_tipo_ligacao[0]);

								//! Adjust the informatiomm
								if ( strpos($tipo_ligacao, "SERVIÇOS TIM") !== false )
									$tipo_ligacao = "SERVIÇOS TIM";
							}

							//! Get the calling type (tipo de chamada)
							if ( strpos($break01[($x - 1)], "Liberty Passport Voz:") !== false )
							{
								$aux_break01 = explode("Liberty Passport Voz:", $break01[($x - 1)]);
								$tipo_chamada = "Liberty Passport Voz: " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 2;	//! VOICE
							}
							else if ( strpos($break01[($x - 1)], "Conexões Liberty Passport Web:") !== false )
							{
								$aux_break01 = explode("Conexões Liberty Passport Web:", $break01[($x - 1)]);
								$tipo_chamada = "Conexões Liberty Passport Web: " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 3;	//! DATA
							}
							else if ( strpos($break01[($x - 1)], "Liberty Passport Web:") !== false )
							{
								$aux_break01 = explode("Liberty Passport Web:", $break01[($x - 1)]);
								$tipo_chamada = "Liberty Passport Web: " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 3;	//! DATA
							}
							else if ( strpos($break01[($x - 1)], "TIM Connect Fast") !== false )
							{
								$aux_break01 = explode("TIM Connect Fast", $break01[($x - 1)]);
								$tipo_chamada = "TIM Connect Fast " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 3;	//! DATA
							}
							else if ( strpos($break01[($x - 1)], "TIM VideoMensagem/FotoMensagem para Celular") !== false )
							{
								$aux_break01 = explode("TIM VideoMensagem/FotoMensagem para Celular", $break01[($x - 1)]);
								$tipo_chamada = "TIM VideoMensagem/FotoMensagem para Celular " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 4;	//! SMS
							}
							else if ( strpos($break01[($x - 1)], "Cham. Originada no Exterior - Europa") !== false )
							{
								$aux_break01 = explode("Cham. Originada no Exterior - Europa", $break01[($x - 1)]);
								$tipo_chamada = "Cham. Originada no Exterior - Europa " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 2;	//! VOICE
							}
							else if ( strpos($break01[($x - 1)], "Conexões") !== false )
							{
								$aux_break01 = explode("Conexões", $break01[($x - 1)]);
								$tipo_chamada = "Conexões " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 3;	//! DATA
							}
							else if ( strpos($break01[($x - 1)], "Liberty") !== false )
							{
								$aux_break01 = explode("Liberty", $break01[($x - 1)]);
								$tipo_chamada = "Liberty " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 3;	//! DATA
							}
							else if ( strpos($break01[($x - 1)], "Torpedo") !== false )
							{
								$aux_break01 = explode("Torpedo", $break01[($x - 1)]);
								$tipo_chamada = "Torpedo " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 4;	//! SMS
							}
							else if ( strpos($break01[($x - 1)], "Chamadas") !== false )
							{
								$aux_break01 = explode("Chamadas", $break01[($x - 1)]);
								$tipo_chamada = "Chamadas " . ltrim( rtrim($aux_break01[(sizeof($aux_break01) - 1)]) );
								$arr_data["ID_TIPO_DET"] = 2;	//! VOICE
							}
							else
								$arr_data["ID_TIPO_DET"] = 1;	//! NOT DEFINED

							$tipo_chamada = str_replace("Duração/Volume", "", $tipo_chamada);

							//! Specific case: remove from duration
							if ( preg_match('/([0-9]{1,5})m([0-9]{2})s/', $tipo_chamada) )
							{
								$aux_tipo_chamada = preg_split('/([0-9]{1,5})m([0-9]{2})s/', $tipo_chamada, 2);
								$tipo_chamada = explode_last_occurrence ('/\s+/', rtrim(ltrim($aux_tipo_chamada[0])), true);
							}
							//! Specific case: remove from value
							else if ( preg_match('/([0-9]{1,5}),([0-9]{2})/', $tipo_chamada) )
							{
								$aux_tipo_chamada = preg_split('/([0-9]{1,5}),([0-9]{2})/', $tipo_chamada, 2);
								$tipo_chamada = explode_last_occurrence ('/\s+/', rtrim(ltrim($aux_tipo_chamada[0])), true);
							}
							//! Specific case: remove from phone
							else if ( strpos($tipo_chamada, "Fixos") !== false )
							{
								$aux_tipo_chamada = explode("Fixos", $tipo_chamada);
								$tipo_chamada = $aux_tipo_chamada[0] . " Fixos";
							}

							//! Split the columns from calling type
							if ( strpos($tipo_chamada, "Data") !== false )
							{
								$aux_break01 = explode("Data", $tipo_chamada);
								$columns = "Data " . rtrim(ltrim($aux_break01[1])) . " Valor";
								$tipo_chamada = rtrim(ltrim($aux_break01[0]));
							}

							//! Prepare the register block
							if ( preg_match('/([0-9]){1,5},([0-9])\w/', $break01[$x]) )
							{
								$information = explode_last_occurrence('/([0-9]){1,5},([0-9])\w/', $break01[$x], true);
							}

							//! Check if it's a special case
							if ( strpos($information, "Chamadas recebidas em Roaming Nacional") !== false )
							{
								$tipo_chamada = "Chamadas recebidas em Roaming Nacional";
								$columns = "Quantidade Realizado Tarifado Valor";

								$aux_info = explode("Chamadas recebidas em Roaming Nacional", $information);
								$information = rtrim(ltrim($aux_info[1]));
							}
							else if ( strpos($information, "Conexões Liberty Passport Web: Américas") !== false )
							{
								$tipo_chamada = "Conexões Liberty Passport Web: Américas";
								$columns = "Quantidade Realizado Tarifado Valor";

								$aux_info = explode("Conexões Liberty Passport Web: Américas", $information);
								$information = rtrim(ltrim($aux_info[1]));
							}

							//! Adjust the columns name
							$columns = str_replace("Data", "DATA", $columns);
							$columns = str_replace("Hora", "HORA", $columns);
							$columns = preg_replace('/Origem\s+Destino/', 'ORIGEM_DESTINO', $columns);
							$columns = str_replace("Número Chamado", "N_CHAMADO", $columns);
							$columns = str_replace("Tipo", "TIPO", $columns);
							$columns = str_replace("Realizado", "REALIZADO", $columns);
							$columns = str_replace("Valor", "VALOR", $columns);
							$columns = str_replace("Quantidade", "QUANTIDADE", $columns);
							$columns = str_replace("Tarifado", "TARIFADO", $columns);

							//! Count the columns
							$count_columns = preg_split('/\s+/', rtrim(ltrim($columns)));
							$count_columns = sizeof($count_columns);

							//!======================================================================================

								/*!
								 * INSERT THE DETAIILMENT
								*/

								//! Separate each register
								$information .= " 9999"; //!< Fix to regex below
								preg_match_all('/([0-9]{0,5}),([0-9]{0,2})+\s[^% KB MB GB TB]/', $information, $match_values);
								$registers = preg_split('/([0-9]{0,5}),([0-9]{0,2})+\s[^% KB MB GB TB]/', rtrim(ltrim($information)));

								//! Prepare the information to save in DB
								$arr_data["ID_TIPO_LIGACAO"] = $this->checkLigacao_PEC(rtrim(ltrim($tipo_ligacao)), 0);
								$arr_data["ID_TIPO_CHAMADA"] = $this->checkChamada_PEC(rtrim(ltrim($tipo_chamada)));
								$arr_data["TIPO_INFO_DET"] = 2;

								//! Run through each register
								for ( $i = 0; $i < sizeof($registers) - 1; $i++ )
								{
									//! Check if the register exists
									if ( isset($match_values[0][$i]) )
									{
										//! Add value
										$match_values[0][$i] = preg_replace('/\s+9/', '', $match_values[0][$i]); //!< Remove the fix
										$registers[$i] .= $match_values[0][$i];

										//! Remove some characters
										if ( $i != 0 )
											$registers[$i] = substr($registers[$i], 4);
										else
											$registers[$i] = substr($registers[$i], 3);

										//! Adjust the register
										$registers[$i] = preg_replace('/\sB\s/', 'B ', $registers[$i]);		//!< Byte
										$registers[$i] = preg_replace('/\sKB\s/', 'KB ', $registers[$i]);	//!< Kbyte
										$registers[$i] = preg_replace('/\sMB\s/', 'MB ', $registers[$i]);	//!< Megabyte
										$registers[$i] = preg_replace('/\sGB\s/', 'GB ', $registers[$i]);	//!< Gigabyte
										$registers[$i] = preg_replace('/\sTB\s/', 'TB ', $registers[$i]);	//!< Terabyte

										//! Split the register in columns to save in DB
										$break02 = preg_split('/\s+/', rtrim(ltrim($registers[$i])));

										//! Check if it's a valid register (handler to incomplete data)
										if ( ( ( preg_match('/([0-9]{1})+\/+([0-9]{2})/', $break02[0]) && strlen($break02[0]) > 4 ) || $count_columns == 4 ) && sizeof($break02) > 3 )
										{
											//! If the register is a SMS
											if ( $arr_data["ID_TIPO_DET"] == 4 )
												$arr_data["QUANTIDADE"] = 1;

											//! Prepare the information to save in DB
											$arr_data["TARIFADO"] = "";
											for ( $j = (sizeof($break02) - 1); $j >= 0; $j-- )
											{
												//! TYPE
												if ( strlen(trim($break02[$j])) == 1 && !is_numeric(trim($break02[$j])) && strpos(trim($break02[$j]), "-") === false )
													$arr_data["TIPO"] = trim($break02[$j]);
												//! PHONE
												else if ( preg_match('/([0-9])+-+([0-9])+-+([0-9])\w+/', $break02[$j]) || preg_match('/([0-9]{4,5})-([0-9]{4})/', $break02[$j]) )
													$arr_data["N_CHAMADO"] = trim($break02[$j]);
												else if ( preg_match('/\*+([0-9])\w+/', $break02[$j]) && trim($arr_data["N_CHAMADO"]) == "" )
													$arr_data["N_CHAMADO"] = trim($break02[$j]);
												//! VOLUME
												else if ( preg_match('/([0-9])B/', $break02[$j]) || ((strpos($break02[$j], "KB") !== false || strpos($break02[$j], "MB") !== false || 
														  strpos($break02[$j], "GB") !== false || strpos($break02[$j], "TB") !== false) && strpos($break02[$j], ",") !== false) )
												{
													if ( trim($arr_data["TARIFADO"]) == "" )
														$arr_data["TARIFADO"] = trim($break02[$j]);
													else
														$arr_data["QUANTIDADE"] = trim($break02[$j]);
												}
												//! VALUE
												else if ( preg_match('/(([0-9])+,+([0-9]))/', $break02[$j]) )
													$arr_data["VALOR"] = trim($break02[$j]);
												//! PERIOD
												else if ( preg_match('/([0-9])\/([0-9])\w+/', $break02[$j]) )
													$arr_data["DATA"] = trim($break02[$j]);
												//! HOUR
												else if ( preg_match('/([0-9]){1,2}:([0-9]){1,2}:([0-9]){1,2}\w+/', $break02[$j]) )
													$arr_data["HORA"] = trim($break02[$j]);
												//! DURATION
												else if ( preg_match('/([0-9])m([0-9])\w+/', $break02[$j]) )
												{
													if ( trim($arr_data["TARIFADO"]) == "" )
														$arr_data["TARIFADO"] = trim($break02[$j]);
													else
														$arr_data["DURACAO"] = trim($break02[$j]);
												}
												//! VALUE
												else if ( preg_match('/(([0-9])+,+([0-9]))/', $break02[$j]) )
													$arr_data["VALOR"] = trim($break02[$j]);
												//! ORIGIN - DESTINY
												else
													$arr_data["ORIGEM_DESTINO"] .= trim($break02[$j]) . " ";
											}

											//! Check the "Utilization Type" register by register
											if ( $arr_data["VALOR"] == "0,00" )
												$arr_data["ID_TIPO_UTILIZACAO"] = 2; //! Dentro do pacote
											else
												$arr_data["ID_TIPO_UTILIZACAO"] = 3; //! Acima do contratado

											//! Reverse the description
											$arr_data["ORIGEM_DESTINO"] = reverse_sentence($arr_data["ORIGEM_DESTINO"]);
											$arr_data["ORIGEM_DESTINO"] = str_replace(" - ", "", $arr_data["ORIGEM_DESTINO"]);

											//! Send data to DB (bottle neck!)
											$query = $this->db->insert('pec.det', $arr_data);

											//! Clean up the array
											$arr_data["DATA"] = "";
											$arr_data["HORA"] = "";
											$arr_data["ORIGEM"] = "";
											$arr_data["N_CHAMADO"] = "";
											$arr_data["TARIFA"] = "";
											$arr_data["DURACAO"] = "";
											$arr_data["VALOR"] = "";
											$arr_data["TIPO"] = "";
											$arr_data["QUANTIDADE"] = "";
											$arr_data["ORIGEM_DESTINO"] = "";
										}
									}
								}

							//!======================================================================================

							//! Clean up the array (entire array)
							$arr_data["ID_TIPO_UTILIZACAO"] = 1;
							$arr_data["ID_TIPO_DET"] = 1;
							$arr_data["ID_TIPO_LIGACAO"] = 1;
							$arr_data["ID_TIPO_CHAMADA"] = 1;
							$arr_data["DATA"] = "";
							$arr_data["HORA"] = "";
							$arr_data["ORIGEM"] = "";
							$arr_data["N_CHAMADO"] = "";
							$arr_data["TARIFA"] = "";
							$arr_data["DURACAO"] = "";
							$arr_data["VALOR"] = "";
							$arr_data["TIPO"] = "";
							$arr_data["QUANTIDADE"] = "";
							$arr_data["TIPO_INFO_DET"] = 0;
							$arr_data["ORIGEM_DESTINO"] = "";
						}
					}

					break;
			}

		} //! getDetail_PEC

		/*!
		 * Get the phone ID from database
		 *
		 * @since 0.1
		 * @access public
		 * @phone_ => the phone number to be searched
		 * @is_radio => false: phone number / true: nextel radio ID
		*/
		public function getPhoneID( $phone_, $is_radio )
		{
			//! Select the necessary data from DB
			if ( $is_radio == false )
			{
				$query = $this->db->query('SELECT `ID_PEC_LINHA` FROM `pec.linhas` WHERE `ID_PEC` = ' . $this->getIdPEC() . '
									  AND `LINHA` = "' . rtrim(ltrim($phone_)) . '" AND `DATA_FECHA` IS NULL');
			}
			else
			{
				$query = $this->db->query('SELECT `ID_PEC_LINHA` FROM `pec.linhas` WHERE `ID_PEC` = ' . $this->getIdPEC() . '
									  AND `ID_RADIO` = "' . rtrim(ltrim($phone_)) . '" AND `DATA_FECHA` IS NULL');
			}

			//! Check if query worked
			if ( $query )
				return $query->fetchColumn(0);
			else
				return 0;
		} //! getPhoneID

		/*!
		 * Get the service ID from database
		 *
		 * @since 0.1
		 * @access public
		 * @service_ => service description
		*/
		public function getServiceID( $service_ )
		{
			//! Specific fixes
			$service_ = str_replace('PACOTE LD 1', 'PACOTE LD 01', $service_);

			//! Remove multiple spaces
			$service_ = preg_replace('!\s+!', ' ', $service_);

			//! Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PEC_SERVICO` FROM `pec.servicos` WHERE `ID_PEC` = ' . $this->getIdPEC() . '
									  AND upper(`DESCRICAO`) LIKE "%' . rtrim(ltrim($service_)) . '%" AND `DATA_FECHA` IS NULL');

			//! Check if query returned some value
			if ( $query->rowCount() != 0 )
			{
				//! Return ID
				return $query->fetchColumn(0);
			}
			else
			{
				//! Insert a new register
				$arr_data = array();
				$arr_data["ID_PEC"] = $this->getIdPEC();
				$arr_data["DESCRICAO"] = rtrim(ltrim($service_));
				$query2 = $this->db->insert('pec.servicos', $arr_data);

				//! Check if query worked
				if ( $query2 )
				{
					//! Return the last ID
					return $this->db->last_id;
				}
				else
				{
					//! Not defined
					return 0;
				}
			}
		} //! getServiceID

		/*!
		 * Get the type of detailed info
		 *
		 * @since 0.1
		 * @access public
		*/
		public function get_detail_type_list()
		{
			//! Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PEC_TIPO_UTILIZACAO`, `DESCRICAO`, `REGEX`, `DELIMITADOR`, `DELIMITADOR2`, `DELIMITADOR3` FROM `pec.dettipoutilizacao` WHERE `DATA_FECHA` IS NULL');

			//! Check if query worked
			if ( $query )
				return $query->fetchAll();
			else
				return 0;
		} //! get_detail_type_list

		/*!
		 * Check if PEC's calls exist
		 *
		 * @since 0.1
		 * @access public
		 * @call_ => call description
		 * @csp_ => csp number
		*/
		public function checkLigacao_PEC( $call_, $csp_ )
		{
			//! Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PEC_TIPO_LIGACAO` FROM `pec.dettipoligacao` WHERE `DESCRICAO` LIKE "%' . $call_ . '%"');

			//! Check if query returned some value
			if ( $query->rowCount() != 0 )
			{
				//! Return ID
				return $query->fetchColumn(0);
			}
			else
			{
				//! Insert a new register
				$arr_data = array();
				$arr_data["DESCRICAO"] = $call_;
				$arr_data["CSP"] = $csp_;
				$query2 = $this->db->insert('pec.dettipoligacao', $arr_data);

				//! Check if query worked
				if ( $query2 )
				{
					//! Return the last ID
					return $this->db->last_id;
				}
				else
				{
					//! Not defined
					return 1;
				}
			}
		} //! checkLigacao_PEC
		
		/*!
		 * Check if PEC's calls exist
		 *
		 * @since 0.1
		 * @access public
		 * @call_ => call description
		*/
		public function checkChamada_PEC( $call_ )
		{
			//! Select the necessary data from DB
			$query = $this->db->query('SELECT `ID_PEC_TIPO_CHAMADA` FROM `pec.dettipochamada` WHERE `DESCRICAO` LIKE "%' . $call_ . '%"');

			//! Check if query returned some value
			if ( $query->rowCount() != 0 )
			{
				//! Return ID
				return $query->fetchColumn(0);
			}
			else
			{
				//! Insert a new register
				$arr_data = array();
				$arr_data["DESCRICAO"] = $call_;
				$query2 = $this->db->insert('pec.dettipochamada', $arr_data);

				//! Check if query worked
				if ( $query2 )
				{
					//! Return the last ID
					return $this->db->last_id;
				}
				else
				{
					//! Not defined
					return 1;
				}
			}
		} //! checkChamada_PEC
		
		/*!
		 * Get the calling description
		 *
		 * @since 0.1
		 * @access public
		 * @calling_id_ => calling ID
		*/
		public function get_calling_pec( $calling_id_ )
		{
			//! Select the necessary data from DB
			$query = $this->db->query('SELECT `DESCRICAO` FROM `pec.dettipoligacao` WHERE `ID_PEC_TIPO_LIGACAO` = ' . $calling_id_ . ' AND `DATA_FECHA` IS NULL');

			//! Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} //! get_utiilization_pec
		
		/*!
		 * Get the chamada description
		 *
		 * @since 0.1
		 * @access public
		 * @calling_id_ => calling ID
		*/
		public function get_chamada_pec( $calling_id_ )
		{
			//! Select the necessary data from DB
			$query = $this->db->query('SELECT `DESCRICAO` FROM `pec.dettipochamada` WHERE `ID_PEC_TIPO_CHAMADA` = ' . $calling_id_ . ' AND `DATA_FECHA` IS NULL');

			//! Check if query worked
			if ( $query )
				return $query->fetchcolumn(0);
			else
				return 0;
		} //! get_utiilization_pec
		
		/*!
		 * Save a log related to PEC processing
		 *
		 * @since 0.1
		 * @access public
		 * @id_PEC_ => id PEC
		 * @description_ => description about
		 * @processing_time_ => call description
		 * @date_time_ => call description
		*/
		public function insertLog_PEC( $id_PEC_, $description_, $processing_time_, $date_time_, $status_ )
		{
			//! Array with log information
			$arr_data = array();
			$arr_data["ID_PEC"] = $id_PEC_;
			$arr_data["DESCRICAO"] = $description_;
			$arr_data["TEMPO_PROCESSAMENTO"] = $processing_time_;
			$arr_data["DATA_HORA"] = $date_time_;
			$arr_data["STATUS"] = $status_;

			//! Send data to DB
			$query = $this->db->insert('pec.log', $arr_data);

		} //! insertLog_PEC
	}

?>