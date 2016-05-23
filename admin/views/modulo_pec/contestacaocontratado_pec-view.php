							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Contestação dos Serviços Contratados">Contestação dos Serviços Contratados <small>relatório </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Check if PEC ID is valid
						$modelo->checkValidit_PEC();

						// Get PEC info
						$pec_info = $modelo->getInfo_PEC($modelo->getIdPEC());

						// Get carrier ID
						$carrier = $modelo->get_carrier_pec($modelo->getIdPEC());

						// Check if the equivalence table was already settled
						$pec_contestation_table = $modelo->get_contestation_equivalence($pec_info["N_CONTA"]);
					?>

					<!-- start: PAGE CONTENT -->
					<?php 
					//! Create an equivalence table
					if ( sizeof($pec_contestation_table) == 0 || ( isset($_GET["action"]) && $_GET["action"] == "edit" ) ) { ?>
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
													<h4 title="TABELA DE EQUIVALÊNCIA">TABELA DE EQUIVALÊNCIA</h4>
												</div>
											</div>
										</div>
										
										<form action="#" role="form" id="frmTabelaEquivalencia" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
											<div class="table-responsive">
												<table class="table table-striped table-bordered table-hover" id="sample_1">
													<thead>
														<tr>
															<th style="width: 50%; white-space: nowrap; text-align: center;" title="SERVIÇOS DA FATURA">SERVIÇOS DA FATURA</th>
															<th style="width: 50%; white-space: nowrap; text-align: center;" title="PLANO / MÓDULO DO CONTRATO">PLANO / MÓDULO DO CONTRATO</th>
														</tr>
													</thead>
													<tbody>
														<?php
															// Auxiliary variable
															$total_value = 0;
															$total_discount = 0;
															$colspan = 2;
															$row_count = 0;
															$selected = -1;
															$flag_selected = 0;
															$string_similarity = 0;
															$string_similarity2 = 0;
															$fixed_string_similarity = (float)85; // CONSTANT TO DEFINE THE STRING SIMILARITY PARAMETER (%)
															$equivalence_id = "";

															// Insert the equivalence table
															$modelo->insert_equivalence_table();

															// Load the equivalence table (edit mode)
															if ( isset($_GET["action"]) && $_GET["action"] == "edit" )
																$equivalence_table = $modelo->get_equivalence_table($pec_info["N_CONTA"]);

															// Get the invoice service list
															$service_list = $modelo->get_service_pec_list($modelo->getIdPEC());

															// Run through service list
															foreach ( $service_list as $s_list )
															{
																// Init row
																echo "<tr>";

																// Service description
																if ( isset($s_list["DESCRICAO"]) && $s_list["DESCRICAO"] != "" )
																	echo "<td style='text-align: left; white-space: nowrap;' title='" . $s_list["DESCRICAO"] . "' ><div class='form-group'>" . $s_list["DESCRICAO"] . "</div></td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Plan/module list
																echo '<td class="center"><div class="form-group">';
																echo '<select style="width: 400px !important;" id="SERVICE_MODULE' . $s_list["ID_PEC_SERVICO"] . '" name="SERVICE_MODULE" class="form-control search-select" onChange="parseTableFields( \'elem_ASSOC\', this.name );">';
																//echo '<select id="SERVICE_MODULE' . $s_list["ID_PEC_SERVICO"] . '" name="SERVICE_MODULE" class="form-control" onChange="parseTableFields( \'elem_ASSOC\', this.name );">';
																echo '<option value="">Selecione...</option>';
																echo '<optgroup label="PLANOS">';

																	// Plan list
																	$lista = $modelo->get_contract_plan($pec_info["N_CONTA"]);

																	// Load the equivalence table choice
																	if ( isset($equivalence_table) )
																	{
																		$selected = -1;
																		$row_count = 0;
																		$string_similarity = 0;
																		$flag_selected = 0;

																		// Check the equivalences between associate plan and service description
																		foreach ( $equivalence_table as $e_table )
																		{
																			// Calculates the similarity between strings
																			$string_similarity = ( ( (float)similar_text(trim($s_list["DESCRICAO"]), trim($e_table["DESC_SERVICO"]))/(float)strlen(trim($s_list["DESCRICAO"])) ) * 100 );

																			// If the strings are exaclty the same
																			if ( strcmp( trim($s_list["DESCRICAO"]), trim($e_table["DESC_SERVICO"]) ) == 0 )
																			{
																				if ( $modelo->get_contestation_equivalence_id($s_list["DESCRICAO"]) != "" )
																				{
																					$selected = $row_count;
																					break;
																				}
																			}
																			// If the first one contain the other
																			else if ( strpos(trim($s_list["DESCRICAO"]), trim($e_table["DESC_SERVICO"])) !== false )
																			{
																				if ( $modelo->get_contestation_equivalence_id($s_list["DESCRICAO"]) != "" )
																				{
																					$selected = $row_count;
																					break;
																				}
																			}
																			// If they are really similar
																			else if ( ( $string_similarity >= $fixed_string_similarity ) || ( $string_similarity > $string_similarity2 ) )
																			{
																				if ( $modelo->get_contestation_equivalence_id($s_list["DESCRICAO"]) != "" )
																				{
																					$selected = $row_count;
																					$string_similarity2 = $string_similarity;
																				}
																			}
																			$row_count++;
																		}

																		// Add the plan description
																		foreach ( $lista as $value )
																		{
																			// Plan description
																			if ( $selected != -1 && $equivalence_table[$selected]["ID_PLANO_CONTRATO"] == $value[0] && strpos($equivalence_table[$selected]["DESC_SERVICO"], "_") === false )
																			{
																				echo "<option selected value='" . $s_list["DESCRICAO"] . "@@P" . $value[0] . "' title='" . $value[1] . "'>" .  $value[1] . "</option>";
																				$flag_selected = 1;
																			}
																			else
																				echo "<option value='" . $s_list["DESCRICAO"] . "@@P" . $value[0] . "' title='" . $value[1] . "'>" . $value[1] . "</option>";

																			// Voice package description
																			if ( $value[2] != "_" )
																			{
																				$value[2] = trim(mb_strtoupper($value[2], 'UTF-8'));

																				if ( $selected != -1 && $equivalence_table[$selected]["ID_PLANO_CONTRATO"] === $value[0] && $flag_selected == 0 )
																					echo "<option selected value='" . $value[2] . "@@P" . $value[0] . "' title='" . $value[2] . "'>" . $value[2] . "</option>";
																				else
																					echo "<option value='" . $value[2] . "@@P" . $value[0] . "' title='" . $value[2] . "'>" . $value[2] . "</option>";
																			}
																		}
																	}
																	// Load the select without a choice
																	else
																	{
																		// Add the plan description
																		foreach ( $lista as $value )
																		{
																			echo "<option value='" . $s_list["DESCRICAO"] . "@@P" . $value[0] . "' title='" . $value[1] . "'>" . $value[1] . "</option>";
																		}
																	}

																echo '</optgroup>';
																echo '<optgroup label="MÓDULOS">';

																	// Module list
																	$lista = $modelo->get_contract_module($pec_info["N_CONTA"]);

																	// Load the equivalence table choice
																	if ( isset($equivalence_table) )
																	{
																		$selected = -1;
																		$row_count = 0;

																		foreach ( $equivalence_table as $e_table )
																		{
																			// If the first one contain the other
																			if ( strpos($s_list["DESCRICAO"], $e_table["DESC_SERVICO"]) !== false )
																			{
																				if ( $modelo->get_contestation_equivalence_id($s_list["DESCRICAO"]) != "" )
																				{
																					$selected = $row_count;
																					break;
																				}
																			}
																			$row_count++;
																		}

																		// Add the module description
																		foreach ( $lista as $value )
																		{
																			if ( $selected != -1 && $equivalence_table[$selected]["ID_MODULO_CONTRATO"] == $value[0] )
																				echo "<option selected value='" . $s_list["DESCRICAO"] . "@@M" . $value[0] . "' title='" . $value[1] . "'>" . $value[1] . "</option>";
																			else
																				echo "<option value='" . $s_list["DESCRICAO"] . "@@M" . $value[0] . "' title='" . $value[1] . "'>" . $value[1] . "</option>";
																		}
																	}
																	// Load the select without a choice
																	else
																	{
																		// Add the module description
																		foreach ( $lista as $value )
																		{
																			echo "<option value='" . $s_list["DESCRICAO"] . "@@M" . $value[0] . "' title='" . $value[1] . "'>" . $value[1] . "</option>";
																		}
																	}

																echo '</optgroup>';
																echo '</select></div></td>';

																// End content
																echo "</tr>";
															}
														?>
													</tbody>
												</table>

												<input type="hidden" name="elem_ASSOC" id="elem_ASSOC" value=""/>

											</div>
											<?php if ( isset($_GET["action"]) && $_GET["action"] == "edit" ) { ?>
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-4">
																<button onClick="parseTableFields( \'elem_ASSOC\', 'SERVICE_MODULE' );" class="btn btn-blue btn-block" type="submit" title="Cadastrar tabela de equivalência">
																	Atualizar tabela de equivalência <i class="fa fa-arrow-circle-right"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
											<?php } else { ?>
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-4">
																<button class="btn btn-blue btn-block" type="submit" title="Cadastrar tabela de equivalência">
																	Cadastrar tabela de equivalência <i class="fa fa-arrow-circle-right"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
											<?php } ?>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- end: PAGE CONTENT-->
					<?php } else { ?>

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
												<button class="btn btn-blue add-row" onClick="javascript:window.location.href='<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/contestacaocontratado_pec?action=edit&idPEC=") ?>';">
													Editar tabela de equivalência <i class="fa fa-pencil"></i>
												</button>
											</div>
										</div>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="sample_2">
												<thead>
													<tr>
														<th style="width: 10%; text-align: center;" title="Nº DE CONTA">Nº DE CONTA</th>
														<th style="width: 10%; text-align: center;" title="ASSOCIADO">ASSOCIADO</th>
														<th style="width: 30%; text-align: center;" title="DESCRITIVO">DESCRITIVO</th>
														<th style="width: 10%; text-align: center;" title="QUANTIDADE DE LINHAS">QUANTIDADE DE LINHAS</th>
														<th style="width: 10%; text-align: center;" title="PERÍODO">PERÍODO</th>
														<th style="width: 10%; white-space: nowrap; text-align: center;" title="VALOR FATURA (R$)">VALOR FATURA (R$)</th>
														<th style="width: 10%; white-space: nowrap; text-align: center;" title="VALOR CONTRATO (R$)">VALOR CONTRATO (R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
														// Auxiliary variable
														$inter_value = 0;
														$total_value = 0;
														$total_value2 = 0;
														$total_discount = 0;
														$colspan = 5;
														$status_color = "";
														$status_color_text = "";
														$print_row = "000"; // Each position represent one contestation case
														$string_similarity = 0;
														$fixed_string_similarity = (float)85; // CONSTANT TO DEFINE THE STRING SIMILARITY PARAMETER (%)
														$id_plano = 0;
														$id_modulo = 0;
														$flag_group = 0;
														$reg_counter = 0;
														$jump_next = 0;
														$is_plan = 0;

														// Get the invoice service list
														$contestation_list = $modelo->get_contestation_report($modelo->getIdPEC());

														// Get the equivalence table (specific cases)
														$equivalence_table = $modelo->get_equivalence_table($pec_info["N_CONTA"]);

														foreach ( $contestation_list as $c_list )
														{
															// By default the item will be printed
															$print_row = "000";
															$id_plano = $c_list["ID_PLANO_CONTRATO"];
															$id_modulo = $c_list["ID_MODULO_CONTRATO"];
															$flag_group = 0;

															// Check if it's necessary group or not the value
															if ( isset($id_plano) && $id_plano != "" ) // Group by plan
															{
																if ( isset($contestation_list[($reg_counter + 1)]["ID_PLANO_CONTRATO"]) && $id_plano == $contestation_list[($reg_counter + 1)]["ID_PLANO_CONTRATO"] )
																	$flag_group = 1;
																else
																	$id_plano = $c_list["ID_PLANO_CONTRATO"];
															}
															else // Group by module
															{
																if ( isset($contestation_list[($reg_counter + 1)]["ID_MODULO_CONTRATO"]) && $id_modulo == $contestation_list[($reg_counter + 1)]["ID_MODULO_CONTRATO"] )
																	$flag_group = 1;
																else
																	$id_modulo = $c_list["ID_MODULO_CONTRATO"];
															}

															//echo $reg_counter . ") flag: " . $flag_group . " " . $id_modulo . " ---> " . $contestation_list[($reg_counter + 1)]["ID_MODULO_CONTRATO"] . "</br>";

															// Initial status color
															$status_color = "";
															$status_color_text = "";
	
															/** First contestation case: 
															 *  If the service ins't associate with the contract equivalence
															 *
															*/
															if ( !isset($c_list["ID_PLANO_CONTRATO"]) && $c_list["ID_PLANO_CONTRATO"] == "" && 
																!isset($c_list["ID_MODULO_CONTRATO"]) && $c_list["ID_MODULO_CONTRATO"] == "" )
															{
																// Set to print the first case
																$print_row[0] = "1";
															}
															else
															{
																// Set to not print the first case
																$print_row[0] = "0";
															}

															if ( $modelo->get_contestation_equivalence_id($c_list["DESCRICAO"]) != "" )
															{
																// Check the equivalences between associate plan and service description
																foreach ( $equivalence_table as $e_table )
																{
																	// Calculates the similarity between strings
																	$string_similarity = ( ( (float)similar_text(trim($c_list["DESCRICAO"]), trim($e_table["DESC_SERVICO"]))/(float)strlen(trim($c_list["DESCRICAO"])) ) * 100 );
																	//echo trim($c_list["DESCRICAO"]) . " = " . trim($e_table["DESC_SERVICO"]) . " = " . $string_similarity . "% ---------------- " . ( $string_similarity > $fixed_string_similarity ? 'true' : 'false' ). "</br>";

																	// If they are really similar
																	if ( $string_similarity >= $fixed_string_similarity )
																	{
																		// Set to not print the first case
																		$print_row[0] = "0";
																		break;
																	}
																}
															}
															/*else
															{
																// Set to print the first case
																$print_row[0] = "1";
															}*/

															/** Second contestation case: 
															 *  If the service value are different from contract
															 *
															*/
															// Check if the comparation will be with the plan or module
															if ( isset($c_list["ID_PLANO_CONTRATO"]) && $c_list["ID_PLANO_CONTRATO"] != "" )
															{
																$is_plan = 1;
																$inter_value = (currency_operation( $c_list["QUANTIDADE_PLANO"], str_replace(",", "", $c_list["VALOR_ASSINATURA_PLANO"]), "*" ))/100;
																
																// Compare the values
																if ( $c_list["VALOR_ASSINATURA_PLANO"] != "" && compare_float( currency_operation( $c_list["VALOR"], real_currency($inter_value), "-" ), 0 ) == false )
																{
																	// Set to print the first case
																	$print_row[1] = "1";
																	$status_color = "#ffc7ce";
																	$status_color_text = "#cf2d06";
																}
																else if ( $c_list["VALOR_PAC_MIN"] != "" && compare_float( currency_operation( $c_list["VALOR_PAC_MIN"], real_currency($inter_value), "-" ), 0 ) == false )
																{
																	// Set to print the first case
																	$print_row[1] = "0";
																	$status_color = "#c6efce";
																	$status_color_text = "#2c6100";
																}
																else
																{
																	// Set not to print the first case
																	$print_row[1] = "0";
																	$status_color = "#c6efce";
																	$status_color_text = "#2c6100";
																}
															}
															else if ( isset($c_list["ID_MODULO_CONTRATO"]) && $c_list["ID_MODULO_CONTRATO"] != "" )
															{
																$is_plan = 0;
																$inter_value = (currency_operation( $c_list["QUANTIDADE_MODULO"], str_replace(",", "", $c_list["VALOR_ASSINATURA_MODULO"]), "*" ))/100;

																// Compare the values
																if ( compare_float( currency_operation( $c_list["VALOR"], real_currency($inter_value), "-" ), 0 ) == false )
																{
																	// Set to print the first case
																	$print_row[1] = "1";
																	$status_color = "#ffc7ce";
																	$status_color_text = "#cf2d06";
																}
																else
																{
																	// Set not to print the first case
																	$print_row[1] = "0";
																	$status_color = "#c6efce";
																	$status_color_text = "#2c6100";
																}
															}
															else
															{
																$is_plan = 2;

																// Set to print the first case
																$print_row[1] = "1";
																$status_color = "#ffc7ce";
																$status_color_text = "#cf2d06";
															}

															// Check if the service has some situation to be contested
															if ( strpos($print_row, "1") !== false && $jump_next == 0 )
															{
																// Init row
																echo "<tr>";

																// Invoice number
																if ( isset($c_list["N_CONTA"]) && $c_list["N_CONTA"] != "" )
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . $c_list["N_CONTA"] . "' ><div class='form-group'>" . $c_list["N_CONTA"] . "</div></td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Is associated
																if ( isset($print_row[0]) && $print_row[0] == "1" )
																	echo "<td style='background-color: #ffc7ce; font-weight: bold; color: #cf2d06; text-align: center; white-space: nowrap;' title='Registro sem associação ao contrato' ><div class='form-group'>N</div></td>";
																else
																	echo "<td style='background-color: #c6efce; font-weight: bold; color: #2c6100; text-align: center; white-space: nowrap;' title='Registro associado ao contrato' ><div class='form-group'>S</div></td>";

																// Service description
																if ( $flag_group == 1 )
																{
																	$service_list = $c_list["ID_PEC_SERVICO"] . "//" . $contestation_list[($reg_counter + 1)]["ID_PEC_SERVICO"];

																	if ( isset($c_list["DESCRICAO"]) && $c_list["DESCRICAO"] )
																		echo "<td><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/contestacaobyservicereport_pec?idPEC=") . "&idService=" . encrypt_decrypt('encrypt', $service_list) . "&isPlan=" . encrypt_decrypt('encrypt', $is_plan) . encrypted_url($c_list["ID_EQUIVALENCIA"], "&idContestation=") . "' title='" . $c_list["DESCRICAO"] . "'>" . $c_list["DESCRICAO"] . "</a></td>";
																	else
																		echo "<td style='text-align: center;'> - </td>";
																}
																else
																{
																	if ( isset($c_list["DESCRICAO"]) && $c_list["DESCRICAO"] )
																		echo "<td><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/contestacaobyservicereport_pec?idPEC=") . "&idService=" . encrypt_decrypt('encrypt', $c_list["ID_PEC_SERVICO"] . "//") . "&isPlan=" . encrypt_decrypt('encrypt', $is_plan) . encrypted_url($c_list["ID_EQUIVALENCIA"], "&idContestation=") . "' title='" . $c_list["DESCRICAO"] . "'>" . $c_list["DESCRICAO"] . "</a></td>";
																	else
																		echo "<td style='text-align: center;'> - </td>";
																}

																// Phone quantity
																if ( $flag_group == 1 )
																	$c_list["QUANTIDADE"] += $contestation_list[($reg_counter + 1)]["QUANTIDADE"];

																if ( isset($c_list["QUANTIDADE"]) && $c_list["QUANTIDADE"] != "" )
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . $c_list["QUANTIDADE"] . "' ><div class='form-group'>" . $c_list["QUANTIDADE"] . "</div></td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Period
																if ( isset($c_list["PERIODO"]) && $c_list["PERIODO"] != "" )
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . $c_list["PERIODO"] . "' ><div class='form-group'>" . $c_list["PERIODO"] . "</div></td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Total value invoice
																if ( $flag_group == 1 )
																{
																	$c_list["VALOR"] = real_currency(currency_operation( $c_list["VALOR"], $contestation_list[($reg_counter + 1)]["VALOR"], "+" ));

																	if ( $contestation_list[($reg_counter + 1)]["IS_CONTESTADO"] == 1 && $c_list["IS_CONTESTADO"] )
																	{
																		$status_color = "#ffeb9c";
																		$status_color_text = "#cf7e00";
																	}
																}
																else
																{
																	if ($c_list["IS_CONTESTADO"] )
																	{
																		$status_color = "#ffeb9c";
																		$status_color_text = "#cf7e00";
																	}
																}

																if ( isset($c_list["VALOR"]) && $c_list["VALOR"] != "" )
																{
																	if ( $c_list["VALOR"] == "0,00" && !isset($c_list["ID_PLANO_CONTRATO"]) && !isset($c_list["ID_MODULO_CONTRATO"]) )
																		echo "<td style='font-weight: bold; background-color: #c6efce; color: #2c6100;text-align: center;'>0,00</td>";
																	else if ( $status_color != "" )
																		echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . "; text-align: center; white-space: nowrap;' title='" . $c_list["VALOR"] . "' >" . $c_list["VALOR"] . "</td>";
																	else
																		echo "<td style='font-weight: bold; text-align: center; white-space: nowrap;' title='" . $c_list["VALOR"] . "' >" . $c_list["VALOR"] . "</td>";

																	// Total sum
																	$total_value = (currency_operation( $total_value, str_replace(",", "", $c_list["VALOR"]), "+" ));
																}
																else
																{
																	if ( $status_color != "" )
																		echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center;'>0,00</td>";
																	else	
																		echo "<td style='font-weight: bold; text-align: center;'>0,00</td>";
																}

																// Check if the print will be with the plan or module
																if ( isset($c_list["ID_PLANO_CONTRATO"]) && $c_list["ID_PLANO_CONTRATO"] != "" )
																{
																	// Total value contract
																	if ( isset($c_list["VALOR_ASSINATURA_PLANO"]) && $c_list["VALOR_ASSINATURA_PLANO"] != "" && isset($c_list["QUANTIDADE_PLANO"]) && $c_list["QUANTIDADE_PLANO"] != "" )
																	{
																		$inter_value = (currency_operation( $c_list["QUANTIDADE_PLANO"], str_replace(",", "", $c_list["VALOR_ASSINATURA_PLANO"]), "*" ))/100;

																		if ( $status_color != "" )
																			echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . "; text-align: center; white-space: nowrap;' title='" . real_currency($inter_value) . "' >" . real_currency($inter_value) . "</td>";
																		else
																			echo "<td style='font-weight: bold; text-align: center; white-space: nowrap;' title='" . real_currency($inter_value) . "' >" . real_currency($inter_value) . "</td>";

																		// Total sum
																		$total_value2 = (currency_operation( $total_value2, str_replace(",", "", usd_currency($inter_value)), "+" ));
																	}
																	// Minutes package value
																	else if ( isset($c_list["VALOR_PAC_MIN"]) && $c_list["VALOR_PAC_MIN"] != "" )
																	{
																		$inter_value = $c_list["VALOR_PAC_MIN"];

																		if ( $status_color != "" )
																			echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . "; text-align: center; white-space: nowrap;' title='" . $inter_value . "' >" . $inter_value . "</td>";
																		else
																			echo "<td style='font-weight: bold; text-align: center; white-space: nowrap;' title='" . $inter_value . "' >" . $inter_value . "</td>";

																		// Total sum
																		$total_value2 = (currency_operation( $total_value2, str_replace(",", ".", str_replace(".", "", $inter_value)), "+" ));
																	}
																	else
																	{
																		if ( $status_color != "" )
																			echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center;'>0,00</td>";
																		else	
																			echo "<td style='font-weight: bold; text-align: center;'>0,00</td>";
																	}
																}
																else if ( isset($c_list["ID_MODULO_CONTRATO"]) && $c_list["ID_MODULO_CONTRATO"] != "" )
																{
																	// Total value contract
																	if ( isset($c_list["QUANTIDADE_MODULO"]) && $c_list["QUANTIDADE_MODULO"] != "" && isset($c_list["VALOR_ASSINATURA_MODULO"]) && $c_list["VALOR_ASSINATURA_MODULO"] != "" )
																	{
																		$inter_value = (currency_operation( $c_list["QUANTIDADE_MODULO"], str_replace(",", "", $c_list["VALOR_ASSINATURA_MODULO"]), "*" ))/100;

																		if ( $status_color != "" )
																			echo "<td style='font-weight: bold; background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center; white-space: nowrap;' title='" . real_currency($inter_value) . "' >" . real_currency($inter_value) . "</td>";
																		else
																			echo "<td style='font-weight: bold; text-align: center; white-space: nowrap;' title='" . real_currency($inter_value) . "' >" . real_currency($inter_value) . "</td>";

																		// Total sum
																		$total_value2 = (currency_operation( $total_value2, str_replace(",", "", usd_currency($inter_value)), "+" ));
																	}
																	else
																		echo "<td style='font-weight: bold; text-align: center;'>0,00</td>";
																}
																else
																{
																	if ( $c_list["VALOR"] == "0,00" )
																		echo "<td style='font-weight: bold; background-color: #c6efce; color: #2c6100;text-align: center;'>0,00</td>";
																	else	
																		echo "<td style='font-weight: bold; background-color: #ffc7ce; color: #cf2d06;text-align: center;'>0,00</td>";
																}

																// End content
																echo "</tr>";
															}

															$reg_counter++;
															
															if ( $flag_group == 1 )
																$jump_next = 1;
															else
																$jump_next = 0;
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
														<td id="foot_total" style="text-align: right;"><h4><?php echo real_currency($total_value); ?></h4></td>
														<td id="foot_total2" style="text-align: center;"><h4><?php echo real_currency($total_value2); ?></h4></td>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value/100); ?>" />
												<input type="hidden" id="total_value2" value="<?php echo real_currency($total_value2/100); ?>" />
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					<?php } ?>
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->

		<script type="text/javascript">

			/** Function to parse an array of fields in a table
			 * @param elem_ => element to receive the parse result
			 * @param fieldToParse_ => ID table to be parsed
			*/
			function parseTableFields( elem_, fieldToParse_ )
			{
				/* Get the HTML inputs */
				var fieldToParse = document.getElementsByName( fieldToParse_ );
				var field = document.getElementById( elem_ );

				/* Clear the initial value */
				field.value = "";

				/* Run through field array */
				for ( var i = 0; i < fieldToParse.length; i++ )
				{
					field.value += fieldToParse[i].value + "//";
				}
			}

		</script>