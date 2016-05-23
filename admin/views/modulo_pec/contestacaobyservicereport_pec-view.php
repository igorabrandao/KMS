							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Avaliação dos itens contestados">Avaliação dos itens contestados <small>relatório </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php

						// Check if PEC ID is valid
						$modelo->checkValidit_PEC();

						// Check if service ID is valid
						if ( isset($_GET['idService']) && $_GET['idService'] != '' )
						{
							$pec_id = decrypted_url($_GET['idPEC'] , "**");
							$service_id = encrypt_decrypt('decrypt', $_GET['idService']);
							$service_id = explode("//", $service_id);
							$service_name = $modelo->get_service_pec($service_id[0]);
							$is_plan = encrypt_decrypt('decrypt', $_GET['isPlan']);
							$period = $modelo->getPeriod($pec_id);

							if ( isset($_GET['idContestation']) && $_GET['idContestation'] != '' )
							{
								$contestation_id = decrypted_url($_GET['idContestation'] , "**");
							}
						}
						else
						{
							?><script>alert("Houve um problema com o identificador do serviço. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/menu_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Get PEC's carrier
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
												<?php echo "<h4 title='" . $service_name . "'>" . $service_name . "</h4>"; ?>
											</div>
											<div class="btn-group pull-right">
												<button data-toggle="dropdown" class="btn btn-light-grey dropdown-toggle">
													Exportar para... <i class="fa fa-angle-down"></i>
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
													<li><a href="#" class="export-pdf" data-table="#sample_1"> Exportar para PDF </a></li>
													<li><a href="#" class="export-excel" data-table="#sample_1"> Exportar para Excel </a></li>
													<li><a href="#" class="export-powerpoint" data-table="#sample_1"> Exportar para PowerPoint </a></li>
												</ul>
											</div>
										</div>
									</div>

									<?php

										// Check if the plan/module was associated in the equivalence table
										if ( !isset($contestation_id) || $contestation_id == '' )
										{
											if ( $is_plan == 1 )
											{
												echo '<div class="row"><div class="col-sm-12"><div class="alert alert-warning">
												O plano ' . $service_name . ' não está associado ao nº de conta na tabela de equivalência.
												<a title="Clique aqui para visualizar os acessos da PEC." href="' . encrypted_url($pec_id, HOME_URI . "/modulo_pec/chargedbyservicereport_pec?idPEC=") . encrypted_url($service_id[0], HOME_URI . "&idService=") . '">Clique aqui para visualizar os acessos da PEC.</a>
												</div></div></div>';
											}
											else if ( $is_plan == 0 )
											{
												echo '<div class="row"><div class="col-sm-12"><div class="alert alert-warning">
												O módulo ' . $service_name . ' não está associado ao nº de conta na tabela de equivalência.
												<a title="Clique aqui para visualizar os acessos da PEC." href="' . encrypted_url($pec_id, HOME_URI . "/modulo_pec/chargedbyservicereport_pec?idPEC=") . encrypted_url($service_id[0], HOME_URI . "&idService=") . '">Clique aqui para visualizar os acessos da PEC.</a>
												</div></div></div>';
											}
											else
											{
												echo '<div class="row"><div class="col-sm-12"><div class="alert alert-warning">
												O item ' . $service_name . ' não está associado ao nº de conta na tabela de equivalência.
												<a title="Clique aqui para visualizar os acessos da PEC." href="' . encrypted_url($pec_id, HOME_URI . "/modulo_pec/chargedbyservicereport_pec?idPEC=") . encrypted_url($service_id[0], HOME_URI . "&idService=") . '">Clique aqui para visualizar os acessos da PEC.</a>
												</div></div></div>';
											}
										}

									?>

									<div class="row">
										<div class="col-md-12 space20">
											<button id="contestFilter" title="Validar/contestar todos os acessos filtrados" class="btn btn-blue add-row" type="button">
												<i class="fa fa-filter"></i> Validar/contestar com filtro
											</button>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="sample_2">
											<thead>
												<tr>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
													<th style="text-align: center; width: 8%;" title="ACESSO">JUSTIFICATIVA</th>
													<th style="white-space: nowrap; text-align: center; width: 7%;" title="ACESSO">ACESSO</th>
													<?php
														// Check if it's a Nextel report
														if ( isset($carrier) && $carrier == 10 ) { ?>
															<th style="white-space: nowrap; text-align: center; width: 15%;">RÁDIO ID</th>
													<?php } ?>
													<th style="width: 12%; text-align: center;" title="LINHA ASSOCIADA">LINHA ASSOCIADA</th>
													<th style="text-align: center; width: 10%;" title="PERÍODO DE REFERÊNCIA">PERÍODO DE REFERÊNCIA</th>
													<th style="text-align: center; width: 10%;" title="MINUTOS">MINUTOS</th>
													<th style="text-align: center; width: 10%;" title="VALOR PROPORCIONAL AO PERÍODO (R$)">VALOR PROPORCIONAL (R$)</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="VALOR FATURA (R$)">VALOR FATURA (R$)</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="VALOR CONTRATO (R$)">VALOR CONTRATO (R$)</th>
												</tr>
											</thead>
											<tbody>
												<?php

													// Auxiliary variable
													$standard_period = 30; // 30 days in a month
													$days_diff = 0;
													$current_number = "";
													$subtotal = 0;
													$total_value = 0;
													$total_value2 = 0;
													$total_value3 = 0;
													$colspan = 9;
													$flag_assoc = 0;
													$assoc_counter = 0;
													$is_contestation = 0;
													$assoc_list = "";
													$aux_id_plan = "";
													$aux_id_module = "";
													$print = 1;
													$hidden_field_list = "";
													$phone_list = "";
													$period = "";
													$phone_contestation_id = "";
													$qtd_valid = 0;

													// Set footer's colspan
													if ( isset($carrier) && $carrier == 10 )
														$colspan = 10;

													for ( $x = 0; $x < sizeof($service_id); $x++ )
													{
														if ( isset($service_id[$x]) && $service_id[$x] != "" )
														{
															// Get the entire report
															$data_value = $modelo->contestationbyservicereport_PEC($modelo->getIdPEC(), $service_id[$x]);

															// Check if the page has a valid equivalence ID
															if ( isset($contestation_id) && $contestation_id != '' )
															{
																$data_contract = $modelo->get_contract_info($contestation_id);
															}

															// Run through service list
															foreach ( $data_value as $i => $value )
															{
																// Initialize the association flag
																$flag_assoc = 0;
																$is_contestation = 0;
																$print = 1;

																// Determine if the register is contestation or not
																if ( isset($data_contract[0]) )
																{
																	// Check contestation plan
																	if ( isset($data_contract[0]["VALOR_ASSINATURA_PLANO"]) )
																	{
																		// Get the phone number association list
																		$assoc_list = $modelo->get_phone_assoc_list($value["LINHA"], $data_contract[0]["ID_PLANO_CONTRATO"], "");

																		// Get the phone number contestation history
																		$phone_contestation = $modelo->get_phone_contestation($modelo->getIdPEC(), $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false), $data_contract[0]["ID_PLANO_CONTRATO"], "");

																		// Run through association list
																		foreach ( $assoc_list as $assoc_value )
																		{
																			// Check if the phone number is associated with a module
																			if ( strcmp(trim($assoc_value["LINHA"]), trim($value["LINHA"])) == 0 )
																				$flag_assoc = 1;
																		}

																		// If the phone number is associated
																		if ( $flag_assoc == 1 )
																		{
																			// Compare the values
																			if ( compare_float( currency_operation( $value["VALOR"], $data_contract[0]["VALOR_ASSINATURA_PLANO"], "-" ), 0 ) == false )
																			{
																				// Set to print the first case
																				$status_color = "#ffc7ce";
																				$status_color_text = "#cf2d06";
																				$is_contestation = 1;
																			}
																		}
																		else
																			$is_contestation = 1;
																	}
																	// Check contestation module
																	else if ( isset($data_contract[0]["VALOR_ASSINATURA_MODULO"]) )
																	{
																		// Get the phone number association list
																		$assoc_list = $modelo->get_phone_assoc_list($value["LINHA"], "", $data_contract[0]["ID_MODULO_CONTRATO"]);

																		// Get the phone number contestation history
																		$phone_contestation = $modelo->get_phone_contestation($modelo->getIdPEC(), $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false), "", $data_contract[0]["ID_MODULO_CONTRATO"]);

																		// Run through association list
																		foreach ( $assoc_list as $assoc_value )
																		{
																			// Check if the phone number is associated with a module
																			if ( strcmp(trim($assoc_value["LINHA"]), trim($value["LINHA"])) == 0 )
																				$flag_assoc = 1;
																		}

																		// If the phone number is associated
																		if ( $flag_assoc == 1 )
																		{
																			// Compare the values
																			if ( compare_float( currency_operation( $value["VALOR"], $data_contract[0]["VALOR_ASSINATURA_MODULO"], "-" ), 0 ) == false )
																			{
																				// Set to print the first case
																				$status_color = "#ffc7ce";
																				$status_color_text = "#cf2d06";
																				$is_contestation = 1;
																			}
																		}
																		else
																			$is_contestation = 1;
																	}
																}

																// If the item was already validated, than it's don't need to appear 
																if ( isset($phone_contestation[0]["IS_CONTESTACAO"]) && $phone_contestation[0]["IS_CONTESTACAO"] == 0 )
																{
																	$print = 0;
																	$qtd_valid++;
																}

																// Print just the contestation registers
																if ( $is_contestation == 1 && $print == 1 )
																{
																	if ( $value["LINHA"] != $current_number )
																	{
																		// Init row
																		echo "<tr>";

																		// Action buttons
																		echo "<td class='center'>";
																		echo "<div class='visible-md visible-lg hidden-sm hidden-xs'>";

																		// Use an auxiliary variable to save the plan ID
																		if ( $data_contract[0]["ID_PLANO_CONTRATO"] == "" )
																			$aux_id_plan = 0;
																		else
																			$aux_id_plan = $data_contract[0]["ID_PLANO_CONTRATO"];

																		// Use an auxiliary variable to save the plan ID
																		if ( $data_contract[0]["ID_MODULO_CONTRATO"] == "" )
																			$aux_id_module = 0;
																		else
																			$aux_id_module = $data_contract[0]["ID_MODULO_CONTRATO"];

																		if ( isset($phone_contestation[0]["ID_LINHA_CONTESTACAO"]) && $phone_contestation[0]["ID_LINHA_CONTESTACAO"] != "" )
																		{
																			echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $aux_id_plan . ", " . $aux_id_module . ", " . $phone_contestation[0]["ID_LINHA_CONTESTACAO"] . ", 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																			echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $aux_id_plan . ", " . $aux_id_module . ", " . $phone_contestation[0]["ID_LINHA_CONTESTACAO"] . ", 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																			$phone_contestation_id = $phone_contestation[0]["ID_LINHA_CONTESTACAO"];
																		}
																		else
																		{
																			echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $aux_id_plan . ", " . $aux_id_module . ", 0, 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																			echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $aux_id_plan . ", " . $aux_id_module . ", 0, 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																			$phone_contestation_id = 0;
																		}

																		echo "</div></td>";

																		// Justify
																		if ( isset($phone_contestation[0]["JUSTIFICATIVA"]) && $phone_contestation[0]["JUSTIFICATIVA"] != "" )
																			echo "<td style='text-align: center;' title='" . $phone_contestation[0]["JUSTIFICATIVA"] . "'>" . $phone_contestation[0]["JUSTIFICATIVA"] . "</td>";
																		else
																			echo "<td style='text-align: center;'>-</td>";

																		// Acesso
																		if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																		{
																			echo "<td style='width: 15%; text-align: center;' title='" . $value["LINHA"] . "'><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/chargedbyservicereport_pec?idPEC=") . encrypted_url($value["ID_SERVICO"], "?idServico=") . "' title='" . $value["LINHA"] . "'>" . $value["LINHA"] . "</a></td>";
																			$phone_list .= "<option value='" . $value["LINHA"] . "'>" . $value["LINHA"] . "</option>";
																		}
																		else
																			echo "<td style='width: 15%; text-align: center; white-space: nowrap;'> - </td>";

																		// Radio ID
																		if ( $carrier == 10 ) // Just to Nextel carrier
																		{
																			if ( isset($value["ID_RADIO"]) && $value["ID_RADIO"] != "" && strpos($value["ID_RADIO"], "-") === false )
																				echo "<td style='text-align: center;' title='" . $value["ID_RADIO"] . "'>" . $value["ID_RADIO"] . "</td>";
																			else
																				echo "<td style='text-align: center;'>-</td>";
																		}

																		// Is associated
																		if ( $flag_assoc == 0 )
																			echo "<td style='background-color: #ffc7ce; font-weight: bold; color: #cf2d06; text-align: center; white-space: nowrap;' title='Acesso sem associação ao plano/módulo' ><div class='form-group'>N</div></td>";
																		else
																			echo "<td style='background-color: #c6efce; font-weight: bold; color: #2c6100; text-align: center; white-space: nowrap;' title='Acesso associado ao plano/módulo' ><div class='form-group'>S</div></td>";

																		// Income period
																		echo "<td style='text-align: center; title='" . $value["PERIODO"] . "'>" . $value["PERIODO"];
																		$period = $value["PERIODO"];
																		while ( isset($data_value[($i+1)][4]) && ($data_value[$i][4] == $data_value[($i+1)][4]) ) 
																		{
																			//echo "</br>" . $data_value[($i+1)][5];
																			$period .= $data_value[($i+1)][5];
																			$i += 1;
																		}
																		echo "</td>";

																		// Minutes
																		if ( isset($value["MINUTOS"]) && $value["MINUTOS"] != "" )
																			echo "<td style='text-align: center;' title='" . $value["MINUTOS"] . "'>" . $value["MINUTOS"] . "</td>";
																		else
																			echo "<td style='text-align: center;'>-</td>";

																		// Proporcional value value
																		if ( isset($data_contract[0]) )
																		{
																			if ( isset($data_contract[0]["VALOR_ASSINATURA_PLANO"]) && $data_contract[0]["VALOR_ASSINATURA_PLANO"] != "" )
																			{
																				// If the phone number is associated
																				if ( isset($flag_assoc) && $flag_assoc == 1 )
																				{
																					// Compare the values
																					if ( compare_float( currency_operation( $value["VALOR"], $data_contract[0]["VALOR_ASSINATURA_PLANO"], "-" ), 0 ) == false )
																					{
																						// Handle the period itself
																						$periods = explode(" a ", $period);
																						$days_diff = dateDifference("d", str_replace("00", "20", DateTime::createFromFormat('d/m/Y', $periods[0])->format('Y-m-d')), str_replace("00", "20", DateTime::createFromFormat('d/m/Y', substr($periods[1], 0, 8))->format('Y-m-d')));

																						$prop_value01 = format_number_precision(currency_operation( $data_contract[0]["VALOR_ASSINATURA_PLANO"], $standard_period, "/" ));
																						$prop_value02 = real_currency($prop_value01 * $days_diff);

																						echo "<td style='font-weight: bold;text-align: center; white-space: nowrap;' title='" . $prop_value02 . "' >" . $prop_value02 . "</td>";

																						// Total sum
																						//$total_value2 = (currency_operation( $total_value2, str_replace(",", "", $data_contract[0]["VALOR_ASSINATURA_PLANO"]), "+" ));
																					}
																				}
																				else
																				{
																					// Compare the values
																					if ( compare_float( currency_operation( $value["VALOR"], 0, "-" ), 0 ) == false )
																					{
																						echo "<td style='font-weight: bold;text-align: center;' title='0,00'>0,00</td>";
																					}
																				}
																			}
																			else if ( isset($data_contract[0]["VALOR_ASSINATURA_MODULO"]) && $data_contract[0]["VALOR_ASSINATURA_MODULO"] != "" )
																			{
																				// If the phone number is associated
																				if ( isset($flag_assoc) && $flag_assoc == 1 )
																				{
																					// Compare the values
																					if ( compare_float( currency_operation( $value["VALOR"], $data_contract[0]["VALOR_ASSINATURA_MODULO"], "-" ), 0 ) == false )
																					{
																						// Handle the period itself
																						$periods = explode(" a ", $period);
																						$days_diff = dateDifference("d", str_replace("00", "20", DateTime::createFromFormat('d/m/Y', $periods[0])->format('Y-m-d')), str_replace("00", "20", DateTime::createFromFormat('d/m/Y', substr($periods[1], 0, 8))->format('Y-m-d')));

																						$prop_value01 = format_number_precision(currency_operation( $data_contract[0]["VALOR_ASSINATURA_MODULO"], $standard_period, "/" ));
																						$prop_value02 = real_currency($prop_value01 * $days_diff);

																						echo "<td style='font-weight: bold;text-align: center; white-space: nowrap;' title='" . $prop_value02 . "' >" . $prop_value02 . "</td>";

																						// Total sum
																						//$total_value2 = (currency_operation( $total_value2, str_replace(",", "", $data_contract[0]["VALOR_ASSINATURA_MODULO"]), "+" ));
																					}
																				}
																				else
																				{
																					// Compare the values
																					if ( compare_float( currency_operation( $value["VALOR"], 0, "-" ), 0 ) == false )
																					{
																						echo "<td style='font-weight: bold;text-align: center;' title='0,00'>0,00</td>";	
																					}
																				}
																			}
																			else
																				echo "<td style='font-weight: bold; text-align: center;'>0,00</td>";																
																		}
																		else
																		{
																			echo "<td style='font-weight: bold; text-align: center;'>0,00</td>";
																		}

																		// Invoice value
																		if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																		{
																			$subtotal = str_replace(',', '.', $value["VALOR"]);

																			// Total value
																			echo "<td style='font-weight: bold; text-align: center;' title='" . real_currency($subtotal) . "'>" . real_currency($subtotal) . "</td>";

																			// Total sum
																			$total_value = (currency_operation( $total_value, str_replace(",", "", $value["VALOR"]), "+" ));
																		}
																		else
																		{
																			echo "<td style='font-weight: bold; text-align: center;'>0,00</td>";
																		}

																		// Contract value
																		if ( isset($data_contract[0]) )
																		{
																			if ( isset($data_contract[0]["VALOR_ASSINATURA_PLANO"]) && $data_contract[0]["VALOR_ASSINATURA_PLANO"] != "" )
																			{
																				// If the phone number is associated
																				if ( isset($flag_assoc) && $flag_assoc == 1 )
																				{
																					// Compare the values
																					if ( compare_float( currency_operation( $value["VALOR"], $data_contract[0]["VALOR_ASSINATURA_PLANO"], "-" ), 0 ) == false )
																					{
																						// Set to print the first case
																						$status_color = "#ffc7ce";
																						$status_color_text = "#cf2d06";
																						echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center; white-space: nowrap;' title='" . $data_contract[0]["VALOR_ASSINATURA_PLANO"] . "' >" . $data_contract[0]["VALOR_ASSINATURA_PLANO"] . "</td>";

																						// Total sum
																						$total_value2 = (currency_operation( $total_value2, str_replace(",", "", $data_contract[0]["VALOR_ASSINATURA_PLANO"]), "+" ));
																						$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' data-vl-fat='" . real_currency($subtotal) . "' data-vl-contract='" . $data_contract[0]["VALOR_ASSINATURA_PLANO"] . "' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . $aux_id_plan . "@@" . $aux_id_module . "@@" . $phone_contestation_id . "'/>";
																					}
																				}
																				else
																				{
																					// Compare the values
																					if ( compare_float( currency_operation( $value["VALOR"], 0, "-" ), 0 ) == false )
																					{
																						// Set to print the first case
																						$status_color = "#ffc7ce";
																						$status_color_text = "#cf2d06";

																						echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center;' title='0,00'>0,00</td>";	
																						$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' data-vl-fat='" . real_currency($subtotal) . "' data-vl-contract='0,00' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . $aux_id_plan . "@@" . $aux_id_module . "@@" . $phone_contestation_id . "'/>";
																					}
																				}
																			}
																			else if ( isset($data_contract[0]["VALOR_ASSINATURA_MODULO"]) && $data_contract[0]["VALOR_ASSINATURA_MODULO"] != "" )
																			{
																				// If the phone number is associated
																				if ( isset($flag_assoc) && $flag_assoc == 1 )
																				{
																					// Compare the values
																					if ( compare_float( currency_operation( $value["VALOR"], $data_contract[0]["VALOR_ASSINATURA_MODULO"], "-" ), 0 ) == false )
																					{
																						// Set to print the first case
																						$status_color = "#ffc7ce";
																						$status_color_text = "#cf2d06";

																						echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center; white-space: nowrap;' title='" . $data_contract[0]["VALOR_ASSINATURA_MODULO"] . "' >" . $data_contract[0]["VALOR_ASSINATURA_MODULO"] . "</td>";

																						// Total sum
																						$total_value2 = (currency_operation( $total_value2, str_replace(",", "", $data_contract[0]["VALOR_ASSINATURA_MODULO"]), "+" ));
																						$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' data-vl-fat='" . real_currency($subtotal) . "' data-vl-contract='" . $data_contract[0]["VALOR_ASSINATURA_MODULO"] . "' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . $aux_id_plan . "@@" . $aux_id_module . "@@" . $phone_contestation_id . "'/>";
																					}
																				}
																				else
																				{
																					// Compare the values
																					if ( compare_float( currency_operation( $value["VALOR"], 0, "-" ), 0 ) == false )
																					{
																						// Set to print the first case
																						$status_color = "#ffc7ce";
																						$status_color_text = "#cf2d06";

																						echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center;' title='0,00'>0,00</td>";	
																						$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' data-vl-fat='" . real_currency($subtotal) . "' data-vl-contract='0,00' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . $aux_id_plan . "@@" . $aux_id_module . "@@" . $phone_contestation_id . "'/>";
																					}
																				}
																			}
																			else
																				echo "<td style='font-weight: bold; text-align: center;'>0,00</td>";																
																		}
																		else
																		{
																			echo "<td style='font-weight: bold; text-align: center;'>0,00</td>";
																		}

																		// End content
																		echo "</tr>";
																	}

																	$current_number = $value["LINHA"];
																}

																$assoc_counter++;
															}

															// Check if all itens was validated
															$qtd_itens = $modelo->get_service_qtd($service_id[0]);

															//echo $service_id[0] . " - " . $qtd_itens . " - " . $qtd_valid . "</br>";
															
															if ( $qtd_itens == $qtd_valid )
															{
																$modelo->update_contestation_service_status($service_id[$x]);
															}
														}
													}

												?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="<?php echo $colspan - 2; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
													<td id="foot_total" style="text-align: center;"><h4><?php echo real_currency($total_value/100); ?></h4></td>
													<td id="foot_total2" style="text-align: right;"><h4><?php echo real_currency($total_value2/100); ?></h4></td>
												</tr>
											</tfoot>
											<input type="hidden" id="total_value" value="<?php echo real_currency($total_value/100); ?>" />
											<input type="hidden" id="total_value2" value="<?php echo real_currency($total_value2/100); ?>" />
										</table>
									</div>

									<?php echo $hidden_field_list; ?>
									<input type="hidden" id="elem_DUMMY" value=""/>

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

		<script type="text/javascript">

			var results = [];

			/** Function to send the contestation
			 * @param pec_ID_ => pec ID
			 * @param phone_ID_ => phone ID
			 * @param plan_ID_ => plan ID
			 * @param module_ID_ => module ID
			 * @param id_phone_contest_ => phone contestation ID
			 * @param contest_type => contestation type: 0 => VALID / 1 => CONTESTATION
			*/
			function contestRegister( pec_ID_, phone_ID_, plan_ID_, module_ID_, id_phone_contest_, contest_type )
			{
				var justify;

				if ( contest_type == 0 )
					justify = prompt("Informe uma justificativa para a contestação", "");
				else
					justify = prompt("Informe uma justificativa para a validação", "");

				if ( justify != "" && justify != null )
				{
					// Callback to delete the element
					sendRequest( '<?php echo HOME_URI;?>/modulo_pec/contestacaobyservicereport_pec', 'action=contest&phone_ID=' + phone_ID_ + '&pec_ID=' + pec_ID_ + 
						'&plan_ID=' + plan_ID_ + '&module_ID=' + module_ID_ + '&contest_ID=' + id_phone_contest_ + '&contest_type=' + contest_type + 
						'&contest_justify=' + justify, 'POST', '///', document.getElementById('elem_DUMMY'), 'delete' );

					// Realod the page with parameters
					location.reload();
				}
				else
				{
					if ( contest_type == 0 )
						alert("Informe uma justificativa para realizar a contestação.");
					else
						alert("Informe uma justificativa para realizar a validação.");

					return false;
				}
			}

			/** Function to send the contestation
			 * @param contest_type => contestation type: 0 => VALID / 1 => CONTESTATION
			*/
			function contestAll( contest_type )
			{
				// Auxiliary variables
				var elem_CONTEST = document.getElementsByName("elem_CONTEST");
				var SELECT_ACESSOS = document.getElementById("SELECT_ACESSOS");
				var DATA_INICIAL = document.getElementById("DATA_INICIAL");
				var DATA_FINAL = document.getElementById("DATA_FINAL");
				var VALOR_FATURA = document.getElementById("VALOR_FATURA");
				var VALOR_CONTRATO = document.getElementById("VALOR_CONTRATO");
				var JUSTIFICATIVA = document.getElementById("JUSTIFICATIVA");
				var phone_id = "";
				var list_value = "";
				var contest_array;
				var aux_info;

				// Validate the filter
				if ( SELECT_ACESSOS.value == "" && DATA_INICIAL.value == "" && DATA_FINAL.value == "" && VALOR_FATURA.value == "" && VALOR_CONTRATO.value == "" )
				{
					alert("Preencha ao menos um parâmetro e a justificativa para realizar o filtro!");
					SELECT_ACESSOS.focus();
					return false;
				}
				else
				{
					// Validate the period
					if ( DATA_INICIAL.value == "" && DATA_FINAL.value != "" )
					{
						alert("Informe a data inicial e a data final.");
						DATA_INICIAL.focus();
						return false;
					}
					else if ( DATA_INICIAL.value != "" && DATA_FINAL.value == "" )
					{
						alert("Informe a data inicial e a data final.");
						DATA_FINAL.focus();
						return false;
					}

					// Validate the justify
					if ( JUSTIFICATIVA.value == "" )
					{
						alert("Informe a justificativa.");
						JUSTIFICATIVA.focus();
						return false;
					}
					else
					{
						// Run through all registers
						for ( z = 0; z < elem_CONTEST.length; z++ )
						{
							phone_id = elem_CONTEST[z].id.toString().replace("elem_CONTEST", "");

							// Check if it's selectec
							if ( SELECT_ACESSOS.value != "" )
							{
								for ( x = (z + 1); x < SELECT_ACESSOS.options.length; x++ )
								{
									if ( SELECT_ACESSOS.options[x].selected == true )
									{
										// If the phone list was informed
										if ( SELECT_ACESSOS.options[x].value.localeCompare( phone_id ) == 0 )
										{
											// Get the specific attributes
											var data_ref = elem_CONTEST[z].getAttribute("data-ref");
											var vl_fat = elem_CONTEST[z].getAttribute("data-vl-fat");
											var vl_contract = elem_CONTEST[z].getAttribute("data-vl-contract");

											// Filter the period
											if ( DATA_INICIAL.value != "" && DATA_FINAL.value != "" )
											{
												var data_ref_split = data_ref.split(" a ");

												if ( trim(data_ref_split[0]).localeCompare(trim(DATA_INICIAL.value.replaceAll("-", "/"))) != 0 || trim(data_ref_split[1]).localeCompare(trim(DATA_FINAL.value.replaceAll("-", "/"))) != 0 )
													break;
											}

											// Invoice value
											if ( VALOR_FATURA.value != "" && VALOR_FATURA.value != vl_fat )
												break;

											// Contract value
											if ( VALOR_CONTRATO.value != "" && VALOR_CONTRATO.value != vl_contract )
												break;

											list_value += elem_CONTEST[z].value + "//";
											break;
										}
									}
								}
							}
							// If the phone list wasn't informed
							else
							{
								// Get the specific attributes
								var data_ref = elem_CONTEST[z].getAttribute("data-ref");
								var vl_fat = elem_CONTEST[z].getAttribute("data-vl-fat");
								var vl_contract = elem_CONTEST[z].getAttribute("data-vl-contract");

								// Filter the period
								if ( DATA_INICIAL.value != "" && DATA_FINAL.value != "" )
								{
									var data_ref_split = data_ref.split(" a ");

									if ( trim(data_ref_split[0]).localeCompare(trim(DATA_INICIAL.value.replaceAll("-", "/"))) != 0 || trim(data_ref_split[1]).localeCompare(trim(DATA_FINAL.value.replaceAll("-", "/"))) != 0 )
										continue;
								}

								// Invoice value
								if ( VALOR_FATURA.value != "" && VALOR_FATURA.value != vl_fat )
									continue;

								// Contract value
								if ( VALOR_CONTRATO.value != "" && VALOR_CONTRATO.value != vl_contract )
									continue;

								list_value += elem_CONTEST[z].value + "//";
							}
						}
					}
				}

				contest_array = list_value.split("//");

				if ( parseInt(contest_array.length) != 0 )
				{
					for ( var i = 0; i < contest_array.length; i++ )
					{
						if ( contest_array[i] != "" )
						{
							aux_info = contest_array[i].split("@@");

							// Callback to delete the element
							results.push( sendRequestAjax( '<?php echo HOME_URI;?>/modulo_pec/contestacaobyservicereport_pec?action=contest&phone_ID=' + aux_info[1] + '&pec_ID=' + aux_info[0] + 
								'&plan_ID=' + aux_info[2] + '&module_ID=' + aux_info[3] + '&contest_ID=' + aux_info[4] + '&contest_type=' + contest_type + 
								'&contest_justify=' + JUSTIFICATIVA.value, 'POST', 'text' ) );
						}
					}

					return true;
				}
				else
				{
					alert("Nenhum item foi localizado com os parâmetros informados.")
					return false;
				}
			}

		</script>