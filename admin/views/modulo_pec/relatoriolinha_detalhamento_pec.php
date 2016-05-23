							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Relatório de detalhamento por linhas">Relatório de detalhamento por linhas <small>relatório </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php

						// Check if PEC ID is valid
						$modelo->checkValidit_PEC();
						$calling_name = "";

						// Check if service ID is valid
						if ( isset($_GET['idUtilizacao']) && $_GET['idUtilizacao'] != '' )
						{
							$utilization_id = decrypted_url($_GET['idUtilizacao'] , "**");
							$utilization_name = $modelo->get_utiilization_pec($utilization_id);
						}
						else
						{
							?><script>alert("Houve um problema com o identificador da utilização. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/detailreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Check calling type ID is valid
						if ( isset($_GET['idTipoLigacao']) && $_GET['idTipoLigacao'] != '' )
						{
							$calling_id = decrypted_url($_GET['idTipoLigacao'] , "**");
							$calling_name = $modelo->get_calling_pec($calling_id);
							$calling_name = mb_strtoupper($calling_name, 'UTF-8');
						}
						else
						{
							?><script>alert("Houve um problema com o identificador do tipo de ligação. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/detailreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Get carrier ID
						$carrier = $modelo->get_carrier_pec($modelo->getIdPEC());

					?>

					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> </a>
										<a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="fa fa-refresh"></i> </a>
										<a class="btn btn-xs btn-link panel-expand" href="#"> <i class="fa fa-resize-full"></i> </a>
										<a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
									</div>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12 space20">
											<div class="btn-group pull-left">
												<?php echo "<h4 title='" . $calling_name . "'>" . $calling_name . "</h4>"; ?>
											</div>
											<div class="btn-group pull-right">
												<button data-toggle="dropdown" class="btn btn-light-grey dropdown-toggle">
													Exportar para... <i class="fa fa-angle-down"></i>
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
													<li><a href="#" class="export-pdf" data-table="#sample_1"> Exportar para PDF </a></li>
													<li><a href="#" class="export-excel" data-table="#sample_1"> Exportar para Excel </a></li>
													<li><a href="#" class="export-csv" data-table="#sample_1"> Exportar para CSV </a></li>
													<li><a href="#" class="export-powerpoint" data-table="#sample_1"> Exportar para PowerPoint </a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<form action="#" role="form" id="frmAssocLinha" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<thead>
													<?php

														//!*******************************************************************
														//! ** COLUMNS GENERATOR 
														//!*******************************************************************

														// Auxiliary variable
														$total_value = 0;
														$subtotal_value = 0;
														$item_value = 0;
														$total_traffic = 0;
														$subtotal_traffic = 0;
														$item_traffic = 0;
														$total_min = 0;
														$subtotal_min = 0;
														$item_min = 0;
														$total_sms = 0;
														$item_sms = 0;
														$colspan = 0;

														// Variables related to the calling type
														$total_column = 0;
														$column_list_id = array();
														$column_list_description = array();
														$column_list_type = array();
														$colspan_column_list = array();
														$aux_columns = "";

														// Variables related to the "chamadas" type
														$total_subcolumn = 0;
														$i = 0;
														$subcolumn_list_id = array();
														$subcolumn_list_description = array();
														$colspan_subcolumn_list = array();
														$subcolumn_list_type = array();

														// Variables related to the information columns
														$total_sub_subcolumn = 0;
														$aux_type = 0;

														/* Array to storage the information columns definition
														 * 2 => VOICE
														 * 3 => DATA
														 * 4 => SMS
														*/
														$data_columns = array();
														$data_columns[2][0] = "CSP";
														$data_columns[2][1] = "DATA";
														$data_columns[2][2] = "HORA";
														$data_columns[2][3] = "LOCALIDADE";
														$data_columns[2][4] = "NÚMERO";
														$data_columns[2][5] = "TARIFA";
														$data_columns[2][6] = "DURAÇÃO";
														$data_columns[2][7] = "VALOR (R$)";

														$data_columns[3][0] = "DATA";
														$data_columns[3][1] = "HORA";
														$data_columns[3][2] = "TIPO";
														$data_columns[3][3] = "QUANTIDADE";
														$data_columns[3][4] = "VALOR (R$)";

														$data_columns[4][0] = "DATA";
														$data_columns[4][1] = "HORA";
														$data_columns[4][2] = "NÚMERO";
														$data_columns[4][3] = "TIPO";
														$data_columns[4][4] = "QUANTIDADE";
														$data_columns[4][5] = "VALOR (R$)";

														// Get the hierarchy list between calling and chamadas
														$column_list = $modelo->get_callinghierarchy_list($modelo->getIdPEC(), $calling_id, $utilization_id);

														// *******TOP COLUMNS*******

														// Open the superior column
														echo "<tr>";

														// Print the columns
														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Run through calling list
														foreach ( $column_list as $column_value )
														{
															// Check if the register exists
															if ( isset($column_value["DESCRICAO_LIGACAO"]) )
															{
																$column_value["DESCRICAO_LIGACAO"] = mb_strtoupper($column_value["DESCRICAO_LIGACAO"], 'UTF-8');

																// Check the current register is different from the previous one
																if ( $aux_columns != "" && strcmp($column_value["DESCRICAO_LIGACAO"], $aux_columns) != 0 )
																{
																	// Increment the column counter
																	$total_column += 1;

																	// Get the informations related to the column
																	$column_list_id[$total_column] = $column_value["ID_TIPO_LIGACAO"];
																	$column_list_description[$total_column] = $column_value["DESCRICAO_LIGACAO"];
																	$column_list_type[$total_column] = $column_value["ID_TIPO_DET"];
																}
																else if ( trim($aux_columns) == "" )
																{
																	// Get the informations related to the column
																	$column_list_id[$total_column] = $column_value["ID_TIPO_LIGACAO"];
																	$column_list_description[$total_column] = $column_value["DESCRICAO_LIGACAO"];
																	$column_list_type[$total_column] = $column_value["ID_TIPO_DET"];
																}

																// Check if the colspan attribute already exists
																if ( isset($colspan_column_list[$total_column]) )
																	$colspan_column_list[$total_column] += 1;
																else
																	$colspan_column_list[$total_column] = 1;

																// Receive the column description to compare with the next iteration
																$aux_columns = $column_value["DESCRICAO_LIGACAO"];
															}
														}

														// Calculate the column size
														$column_size = 100/($total_column + 2);

														// Print all the columns
														for ( $column_counter = 0; $column_counter < $total_column + 1; $column_counter++ )
														{
															if ( isset($colspan_column_list[$column_counter]) )
															{
																// Print each column
																echo "<th colspan='" . ( $colspan_column_list[$column_counter] * sizeof($data_columns[$column_list_type[$column_counter]]) ) . "' style='width: " . $column_size . "%; white-space: nowrap; text-align: center' title='" . $column_list_description[$column_counter] . "' >" . $column_list_description[$column_counter] . "</th>";
															}
															else
															{
																// Print each column
																echo "<th colspan='" . ( sizeof($data_columns[$column_list_type[$column_counter]]) ) . "' style='width: " . $column_size . "%; white-space: nowrap; text-align: center' title='" . $column_list_description[$column_counter] . "' >" . $column_list_description[$column_counter] . "</th>";
															}
														}

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Close the superior columns
														echo "</tr><tr>";

														// *******MIDDLE COLUMNS*******

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Run through plan list
														foreach ( $column_list as $column_value )
														{
															// Check if the register exists
															if ( isset($column_value["DESCRICAO_CHAMADA"]) )
															{
																$column_value["DESCRICAO_CHAMADA"] = mb_strtoupper($column_value["DESCRICAO_CHAMADA"], 'UTF-8');

																// Check if the column is called 'NÃO DEFINIDA'
																if ( strcmp(trim($column_value["DESCRICAO_CHAMADA"]), "NÃO DEFINIDA") == 0 )
																	$column_value["DESCRICAO_CHAMADA"] = "";

																// Print each columns
																echo "<th colspan='" . sizeof($data_columns[$column_value["ID_TIPO_DET"]]) . "'style='white-space: nowrap; text-align: center' title='" . $column_value["DESCRICAO_CHAMADA"] . "' >" . $column_value["DESCRICAO_CHAMADA"] .  "</th>";

																// Get the informations related to the subcolumn
																$subcolumn_list_id[$total_subcolumn] = $column_value["ID_TIPO_CHAMADA"];
																$subcolumn_list_description[$total_subcolumn] = $column_value["DESCRICAO_CHAMADA"];
																$subcolumn_list_type[$total_subcolumn] = $column_value["ID_TIPO_DET"];
																$colspan_subcolumn_list[$total_subcolumn] = sizeof($data_columns[$column_value["ID_TIPO_DET"]]);

																// Increment the subcolumn counter
																$total_subcolumn += 1;
															}
														}

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Close the middle columns
														echo "</tr><tr>";
														$colspan = ($total_column * 2) + 1;

														// *******BOTTOM COLUMNS*******

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap' title='ACESSOS'>ACESSOS</th>";

														// Run through plan list
														foreach ( $column_list as $column_value )
														{
															// Check if the register exists
															if ( isset($column_value["DESCRICAO_CHAMADA"]) )
															{
																for ( $info_column_counter = 0; $info_column_counter < sizeof($data_columns[$column_value["ID_TIPO_DET"]]); $info_column_counter++ )
																{
																	echo "<th style='text-align: center'; white-space: nowrap; title='Volume' >" . $data_columns[$column_value["ID_TIPO_DET"]][$info_column_counter] . "</th>";

																	// Increase the sub subcolumns counter
																	$total_sub_subcolumn += 1;
																}
															}
														}

														echo "<th style='width: 10%; white-space: nowrap; text-align: center; white-space: nowrap' title='VALOR TOTAL POR ACESSO (R$)'>VALOR TOTAL (R$)</th>";

														echo "</tr>";

													?>
												</thead>
												<tbody>
													<?php

														//!*******************************************************************
														//! ** CONTENT GENERATOR 
														//!*******************************************************************

														// Auxiliary variable
														$count = 0;
														$colspan = 1;

														// store the value by line
														$value_by_line = 0;
														$total_value = 0;

														// Get the contracted services relates to a phone number
														$phone_list = $modelo->get_phone_list($modelo->getIdPEC());

														// Run through phone number list
														foreach ( $phone_list as $value )
														{
															// Check if it's the same phone number
															if ( isset($value["LINHA"]) )
															{
																// Clear the total variables
																$item_value = 0;
																$subtotal_value = 0;

																// New phone number (Init row)
																echo "</tr><tr id='row" . $count . "'>";

																// Phone numer
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Get the detailment by phone
																$phone_detailment_general = $modelo->get_pecdet_byphone_callingordered($modelo->getIdPEC(), $value["ID_PEC_LINHA"], $utilization_id, $calling_id, "");

																// Check if the phone number has at least one detailment register
																if ( sizeof($phone_detailment_general) == 0 )
																{
																	// Fill the information columns with hifen
																	for ( $i = 0; $i < $total_sub_subcolumn; $i++ )
																	{
																		echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																	}
																	echo "<td style='text-align: center; white-space: nowrap;' title='0,00'>0,00</td>";
																}
																else
																{
																	// Run through all subcolumns
																	for ( $i = 0; $i < $total_subcolumn; $i++ )
																	{
																		// Check if the queery returned some register
																		if ( isset( $phone_detailment_general[$i]["ID_TIPO_CHAMADA"] ) )
																		{
																			// Check if the service, has at least one register
																			$count_registers = 0;
																			foreach ( $phone_detailment_general as $detail )
																			{
																				if ( $detail["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] )
																				{
																					$count_registers++;
																				}
																			}

																			// Check the alignment between the subolumns and the detailment
																			if ( isset($phone_detailment_general[$i]) && $count_registers != 0 )
																			{
																				$register_counter = 0;

																				// Get the detailment by phone
																				$phone_detailment = $modelo->get_pecdet_byphone_callingordered($modelo->getIdPEC(), $value["ID_PEC_LINHA"], $utilization_id, $calling_id, $subcolumn_list_id[$i]);

																				// Check the detailment type
																				switch ( $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																				{
																					// VOICE
																					case 2:

																						// Local auxiliary variable
																						$aux_count_reg = 1;

																						// CSP
																						if ( isset($phone_detailment[$register_counter]["CSP"]) && $phone_detailment[$register_counter]["CSP"] != "" )
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["CSP"];
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["CSP"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// DATA
																						if ( isset($phone_detailment[$register_counter]["DATA"]) && $phone_detailment[$register_counter]["DATA"] != "" )
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["DATA"];
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["DATA"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// HORA
																						if ( isset($phone_detailment[$register_counter]["HORA"]) && $phone_detailment[$register_counter]["HORA"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["HORA"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["HORA"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// LOCATION
																						if ( isset($phone_detailment[$register_counter]["ORIGEM"]) && $phone_detailment[$register_counter]["ORIGEM"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["ORIGEM"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["ORIGEM"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// CALLED NUMBER
																						if ( isset($phone_detailment[$register_counter]["N_CHAMADO"]) && $phone_detailment[$register_counter]["N_CHAMADO"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["N_CHAMADO"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["N_CHAMADO"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// TAX TYPE
																						if ( isset($phone_detailment[$register_counter]["TARIFA"]) && $phone_detailment[$register_counter]["TARIFA"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["TARIFA"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["TARIFA"];

																							$aux_count_reg += 1;
																						}

																						echo "</br><strong>Subtotal:</strong>";
																						echo "</td>";
																						$aux_count_reg = 1;

																						// DURATION
																						if ( isset($phone_detailment[$register_counter]["DURACAO"]) && $phone_detailment[$register_counter]["DURACAO"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["DURACAO"];

																							// Total duration (sum)
																							if ( strpos($phone_detailment[$register_counter]["DURACAO"], "m") === false )
																							{
																								// Total duration
																								$subtotal_min = $phone_detailment[$register_counter]["DURACAO"];
																							}
																							else
																							{
																								// Total duration
																								$subtotal_min = format_min_sec($phone_detailment[$register_counter]["DURACAO"]);

																								$subtotal_min = str_replace(".", "", $subtotal_min);
																								$show_minutes = 1;
																							}
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						$show_minutes = 0;
																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							$item_min = $phone_detailment[($register_counter + $aux_count_reg)]["DURACAO"];

																							// Total duration (print)
																							if ( strlen($item_min) == 8 )
																							{
																								echo "</br>"  . format_mm_ss(format_hh_mm_ss($item_min));

																								$item_min = format_mm_ss(format_hh_mm_ss($item_min));
																							}
																							else
																							{
																								echo "</br>" . $item_min;
																							}

																							// Total duration (sum)
																							if ( strpos($item_min, "m") === false )
																							{
																								// Total duration
																								$subtotal_min = min_sec_sum($subtotal_min, $item_min);
																							}
																							else
																							{
																								// Total duration
																								$subtotal_min = min_sec_sum($subtotal_min, format_min_sec($item_min));

																								$subtotal_min = str_replace(".", "", $subtotal_min);
																								$show_minutes = 1;
																							}

																							$aux_count_reg += 1;
																						}

																						// Print the duration sum
																						echo "</br><strong>";

																						if ( $show_minutes == 0 ) 
																							echo str_replace(".", "", format_mm_ss($subtotal_min)); 
																						else 
																							echo format_mm_ss($subtotal_min);

																						// Subtotal duration (sum)
																						if ( strpos($subtotal_min, "m") === false )
																						{
																							// Total duration
																							$total_min = min_sec_sum($total_min, $subtotal_min);
																						}
																						else
																						{
																							// Total duration
																							$total_min = min_sec_sum($total_min, format_min_sec($subtotal_min));

																							$total_min = str_replace(".", "", $total_min);
																							$show_minutes = 1;
																						}

																						echo "</strong></td>";
																						$aux_count_reg = 1;

																						// VALUE
																						$item_value = 0;
																						if ( isset($phone_detailment[$register_counter]["VALOR"]) && $phone_detailment[$register_counter]["VALOR"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["VALOR"];

																							// Total register sum
																							$item_value = real_sum($item_value, str_replace(",", ".", $phone_detailment[$register_counter]["VALOR"]));
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["VALOR"];

																							// Total register sum
																							$item_value = real_sum($item_value, str_replace(",", ".", $phone_detailment[($register_counter + $aux_count_reg)]["VALOR"]));

																							$aux_count_reg += 1;
																						}

																						// Print the register sum
																						echo "</br><strong>" . real_currency($item_value) . "</strong>";

																						// Total phone sum
																						$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $item_value));

																						$total_value = real_sum($total_value, str_replace(",", ".", $subtotal_value));

																						echo "</td>";
																						$aux_count_reg = 1;

																						break;

																					// INTERNET
																					case 3:

																						// Local auxiliary variable
																						$aux_count_reg = 1;

																						// DATA
																						if ( isset($phone_detailment[$register_counter]["DATA"]) && $phone_detailment[$register_counter]["DATA"] != "" )
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["DATA"];
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[$register_counter]["DATA"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// HORA
																						if ( isset($phone_detailment[$register_counter]["HORA"]) && $phone_detailment[$register_counter]["HORA"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["HORA"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["HORA"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// TIPO
																						if ( isset($phone_detailment[$register_counter]["TIPO"]) && $phone_detailment[$register_counter]["TIPO"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["TIPO"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["TIPO"];

																							$aux_count_reg += 1;
																						}

																						echo "</br><strong>Subtotal:</strong>";
																						echo "</td>";
																						$aux_count_reg = 1;

																						// QUANTIDADE
																						$aux_traffic = "";
																						$subtotal_traffic = "";
																						$item_traffic = "";
																						if ( isset($phone_detailment[$register_counter]["QUANTIDADE"]) && $phone_detailment[$register_counter]["QUANTIDADE"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["QUANTIDADE"];

																							$aux_traffic = preg_replace("/MB+\s+/", ",", $phone_detailment[$register_counter]["QUANTIDADE"]);
																							$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																							$aux_traffic = str_replace(",", ".", $aux_traffic);
																							$item_traffic = real_sum($item_traffic, ($aux_traffic));
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["QUANTIDADE"];

																							$aux_traffic = preg_replace("/MB+\s+/", ",", $phone_detailment[($register_counter + $aux_count_reg)]["QUANTIDADE"]);
																							$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																							$aux_traffic = str_replace(",", ".", $aux_traffic);
																							$item_traffic = real_sum($item_traffic, ($aux_traffic));

																							$aux_count_reg += 1;
																						}

																						// Print the register sum
																						echo "</br><strong>" . formatMbKb($item_traffic) . "</strong>";

																						// Total traffic sum
																						$subtotal_traffic = real_sum($subtotal_traffic, $item_traffic);

																						$total_traffic = real_sum($total_traffic, $subtotal_traffic);

																						echo "</td>";
																						$aux_count_reg = 1;

																						// VALUE
																						$item_value = 0;
																						if ( isset($phone_detailment[$register_counter]["VALOR"]) && $phone_detailment[$register_counter]["VALOR"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["VALOR"];

																							// Total register sum
																							$item_value = real_sum($item_value, str_replace(",", ".", $phone_detailment[$register_counter]["VALOR"]));
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[$register_counter]["VALOR"];

																							// Total register sum
																							$item_value = real_sum($item_value, str_replace(",", ".", $phone_detailment[($register_counter + $aux_count_reg)]["VALOR"]));

																							$aux_count_reg += 1;
																						}

																						// Print the register sum
																						echo "</br><strong>" . real_currency($item_value) . "</strong>";

																						// Total phone sum
																						$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $item_value));

																						$total_value = real_sum($total_value, str_replace(",", ".", $subtotal_value));

																						echo "</td>";

																						break;

																					// SMS
																					case 4:

																						// Local auxiliary variable
																						$aux_count_reg = 1;

																						// DATA
																						if ( isset($phone_detailment[$register_counter]["DATA"]) && $phone_detailment[$register_counter]["DATA"] != "" )
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["DATA"];
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["DATA"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// HORA
																						if ( isset($phone_detailment[$register_counter]["HORA"]) && $phone_detailment[$register_counter]["HORA"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["HORA"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["HORA"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// CALLED NUMBER
																						if ( isset($phone_detailment[$register_counter]["N_CHAMADO"]) && $phone_detailment[$register_counter]["N_CHAMADO"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["N_CHAMADO"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[($register_counter + $aux_count_reg)]["N_CHAMADO"];

																							$aux_count_reg += 1;
																						}

																						echo "</br></br></td>";
																						$aux_count_reg = 1;

																						// TIPO
																						if ( isset($phone_detailment[$register_counter]["TIPO"]) && $phone_detailment[$register_counter]["TIPO"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["TIPO"];
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[$register_counter]["TIPO"];

																							$aux_count_reg += 1;
																						}

																						echo "</br><strong>Subtotal:</strong>";
																						echo "</td>";
																						$aux_count_reg = 1;

																						// QUANTIDADE
																						$item_sms = 0;
																						if ( isset($phone_detailment[$register_counter]["QUANTIDADE"]) && $phone_detailment[$register_counter]["QUANTIDADE"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["QUANTIDADE"];

																							// Total sms count
																							$item_sms = real_sum($item_sms, $phone_detailment[$register_counter]["QUANTIDADE"]);
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[$register_counter]["QUANTIDADE"];

																							// Total sms count
																							$item_sms = real_sum($item_sms, $phone_detailment[($register_counter + $aux_count_reg)]["QUANTIDADE"]);

																							$aux_count_reg += 1;
																						}

																						// Print the SMS sum
																						echo "</br><strong>" . $item_sms . "</strong>";

																						// Total SMS sum
																						$total_sms = real_sum($total_sms, $item_sms);

																						echo "</td>";
																						$aux_count_reg = 1;

																						// VALUE
																						$item_value = 0;
																						if ( isset($phone_detailment[$register_counter]["VALOR"]) && $phone_detailment[$register_counter]["VALOR"] != "" )
																						{
																							echo "<td style='white-space: nowrap; text-align: center;'>" . $phone_detailment[$register_counter]["VALOR"];

																							// Total register sum
																							$item_value = real_sum($item_value, str_replace(",", ".", $phone_detailment[$register_counter]["VALOR"]));
																						}
																						else
																							echo "<td style='text-align: center; white-space: nowrap;'> - ";

																						while ( isset($phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"]) && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_CHAMADA"] == $subcolumn_list_id[$i] && $phone_detailment[($register_counter + $aux_count_reg)]["ID_TIPO_DET"] == $phone_detailment[$register_counter]["ID_TIPO_DET"] )
																						{
																							echo "</br>" . $phone_detailment[$register_counter]["VALOR"];

																							// Total register sum
																							$item_value = real_sum($item_value, str_replace(",", ".", $phone_detailment[($register_counter + $aux_count_reg)]["VALOR"]));

																							$aux_count_reg += 1;
																						}

																						// Print the register sum
																						echo "</br><strong>" . real_currency($item_value) . "</strong>";

																						// Total phone sum
																						$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $item_value));

																						$total_value = real_sum($total_value, str_replace(",", ".", $subtotal_value));

																						echo "</td>";

																						break;
																				}
																			}
																			else
																			{
																				// Fill the information columns with hifen
																				for ( $j = 0; $j < $colspan_subcolumn_list[$i]; $j++ )
																				{
																					echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																				}
																			}
																		}
																		else
																		{
																			// Fill the information columns with hifen
																			for ( $j = 0; $j < $colspan_subcolumn_list[$i]; $j++ )
																			{
																				echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																			}
																		}
																	}

																	// Add the last column
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . real_currency($subtotal_value) . "'>" . real_currency($subtotal_value) . "</td>";
																}

															}

															// Increase the counter
															$count += 1;
														}

														// End of line
														echo "</tr>";

														// Clear the total variables
														$item_value = 0;
														$subtotal_value = 0;
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo ($total_sub_subcolumn - 4); ?>" style="text-align: center;"></td>
														<!-- Total Duration -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4>Duração total: 
															<?php
																if ( isset($show_minutes) && $show_minutes == 0 ) 
																	echo str_replace(".", "", format_mm_ss($total_min)); 
																else 
																	echo format_mm_ss($total_min);
															?>
														</h4></td>
														<!-- Total Traffic -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4>Tráfego total: <?php echo formatMbKb($total_traffic) ?></h4></td>
														<!-- Total SMS -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4>SMS total: <?php echo $total_sms ?></h4></td>
														<!-- Total value -->
														<td id="foot_total" colspan="1" style="text-align: right; white-space: nowrap;"><h4>Subtotal: R$ <?php echo real_currency($total_value); ?></h4></td>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											</table>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->