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
						if (isset($_GET['idLancamento']) && $_GET['idLancamento'] != '')
						{
							$pec_id = decrypted_url($_GET['idPEC'] , "**");
							$lancamento_id = decrypted_url($_GET['idLancamento'] , "**");
							$info_pec = $modelo->getInfo_PEC($pec_id);
							$n_conta = $info_pec["N_CONTA"];
						}
						else
						{
							?><script>alert("Houve um problema com o identificador do lançamento. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/otherentriesreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Get entries description
						$entry_description = $modelo2->get_lancamento_description($modelo->getIdPEC(), $lancamento_id);

						// Get entries type
						$entry_type = $modelo2->get_lancamento_type($modelo->getIdPEC(), $lancamento_id);

						// Get carrier ID
						$carrier = $modelo2->get_carrier_pec($modelo->getIdPEC());

						// General auxiliary variable
						$total_value = 0;
						$subtotal_value = 0;
						$count = 0;

						// Get the entire report
						$data_value = $modelo->get_otherentries_detail($modelo->getIdPEC(), $lancamento_id);
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
												<?php echo "<h4 title='" . $entry_description . " )'>" . $entry_description . "</h4>"; ?>
											</div>
										</div>
									</div>
									<?php if ( strpos($entry_description, "Parcelamento") !== false ) { ?>
										<div class="row">
											<div class="col-md-12 space20">
												<button id="contestFilter" title="Validar/contestar todos os acessos filtrados" class="btn btn-blue add-row" type="button">
													<i class="fa fa-filter"></i> Validar/contestar com filtro
												</button>

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

										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;" title="PERÍODO">PERÍODO</th>
														<th style="white-space: nowrap; text-align: center;" title=""></th>
														<th style="text-align: center;" title="ACESSO">JUSTIFICATIVA</th>
														<th style="white-space: nowrap; text-align: center;" title="ACESSO">ACESSO</th>
														<th style="white-space: nowrap; text-align: center;" title="DESCRITIVO DO LANÇAMENTO">DESCRITIVO</th>
														<th style="white-space: nowrap; text-align: center;" title="TIPO DE LANÇAMENTO">CLASSIFICAÇÃO</th>
														<th style="white-space: nowrap; text-align: center;" title="PERÍODO CONTRATO">PERÍODO CONTRATO</th>
														<th style="white-space: nowrap; text-align: center;" title="VALOR DO LANÇAMENTO">VALOR(R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php

														// Auxiliary variable
														$colspan = 7;
														$print = 1;
														$is_contestation = 0;
														$phone_list = "";
														$classification_list = "";
														$period = "";
														$hidden_field_list = "";
														$array_period = array();
														$counter = 0;
														$periodo = "";
														$installment = 0;
														$installment_array = array();
														$contract_match_id = array();
														$installment_values_list = array();
														$installment_contract_status = array();
														$mes_ref = "";
														$current_period = "";
														$subtotal_value2 = 0;
														$flag_phone_dont_exist = 0;

														// Get the contract list from the oldest to the newest
														$contract_list = $modelo->get_contract_list_by_order($n_conta);

														// Match the contract accordling to the period
														foreach ( $contract_list as $c_list )
														{
															if ( abs($contract_list[0]["CARENCIA"] - dateDifference("m", $contract_list[0]["DATA_ATIVACAO"], $c_list["DATA_ATIVACAO"])) < 10 )
																$array_period[$counter]["PERIOD"] = "0" . floor(abs($contract_list[0]["CARENCIA"] - dateDifference("m", $contract_list[0]["DATA_ATIVACAO"], $c_list["DATA_ATIVACAO"]))) .  "/" . $contract_list[0]["CARENCIA"];
															else
																$array_period[$counter]["PERIOD"] = floor(abs($contract_list[0]["CARENCIA"] - dateDifference("m", $contract_list[0]["DATA_ATIVACAO"], $c_list["DATA_ATIVACAO"]))) .  "/" . $contract_list[0]["CARENCIA"];

															$array_period[$counter]["CONTRACT_ID"] = $c_list["ID_CONTRATO_OPERADORA"];
															$array_period[$counter]["REFERENCE_MONTH"] = substr($c_list["DATA_ATIVACAO"], 3, 7);
															$counter++;
														}

														/*echo "Período do contrato: " . $contract_list[0]["DATA_ATIVACAO"] . " a " . date('d-m-Y', strtotime("+" . $contract_list[0]["CARENCIA"] . " month", strtotime($contract_list[0]["DATA_ATIVACAO"]))) . "</br>";
														echo "Referência PEC: " . $info_pec["MES_REFERENCIA"] . "</br></br>";*/
														$counter = 0;

														/*echo "</br>";
														var_dump($contract_list);
														echo "</br>";*/

														foreach ( $contract_list as $c_list )
														{
															/*echo "Mês ref: " . $info_pec["MES_REFERENCIA"] . "</br>";
															echo "Diff mês ref: " . dateDifference("m", "01-" . str_replace("/", "-", $info_pec["MES_REFERENCIA"]), ("01-01-" . substr($info_pec["MES_REFERENCIA"], -4)) ) . "</br>";
															echo "Carência: " . $contract_list[0]["CARENCIA"] . "</br>";
															echo "Data de ativação: " . $c_list["DATA_ATIVACAO"] . "</br>";
															echo "Diff data ativação: " . dateDifference("m", $contract_list[0]["DATA_ATIVACAO"], $c_list["DATA_ATIVACAO"]) . "</br>";
															echo "Parcela: " . floor($contract_list[0]["CARENCIA"] - dateDifference("m", $contract_list[0]["DATA_ATIVACAO"], $c_list["DATA_ATIVACAO"])) .  "/" . $contract_list[0]["CARENCIA"] . "</br>";*/

															$contract_match_id = array();

															// Installmment calculation: [(contract period - difference between the first contract activation and the actual one) + (difference between PEC reference's month and the first month of the year)]
															$installment = ( floor($contract_list[0]["CARENCIA"] - dateDifference("m", $contract_list[0]["DATA_ATIVACAO"], $c_list["DATA_ATIVACAO"])) + dateDifference("m", "01-" . str_replace("/", "-", $info_pec["MES_REFERENCIA"]), ("01-01-" . substr($info_pec["MES_REFERENCIA"], -4)) ) ) ;

															//! Concatenate the entire install
															if ( $installment < 10 )
																$installment = "0" . $installment . "/" . $contract_list[0]["CARENCIA"];
															else
																$installment = $installment . "/" . $contract_list[0]["CARENCIA"];

															//echo "Parcela2: " . $installment . "</br>";

															//! Increment the installment array
															array_push($installment_array, $installment);

															/* Reference month calculation: ([pec reference month - (contract total period - installment) + 1])
															 * Note that, we add 1 because the carrier just charge the current month in the next one
															*/
															$mes_ref = substr($c_list["DATA_ATIVACAO"], 3, 7);

															//echo "Mês ref2: " . $mes_ref . "</br></br></br>";

															/*echo "</br></br>Mês atual: " . $info_pec["MES_REFERENCIA"] . "</br>";
															echo "Parcela: " . ($contract_list[0]["CARENCIA"] - dateDifference("m", $contract_list[0]["DATA_ATIVACAO"], $c_list["DATA_ATIVACAO"])) . "</br>";
															echo "Mês/ano contrato: " . $mes_ref . "</br>";

															echo $c_list["ID_CONTRATO_OPERADORA"] . " = " . $c_list["DATA_ATIVACAO"] . " - " . ($contract_list[0]["CARENCIA"] - $installment) .  "/" . $contract_list[0]["CARENCIA"] . " - " . $info_pec["MES_REFERENCIA"];
															echo "</br></br>";*/

															// Check if the current period match with at least one contract activation date
															foreach ( $contract_list as $c_list2 )
															{
																if ( strcmp($mes_ref, substr($c_list2["DATA_ATIVACAO"], 3)) == 0 )
																{
																	// The register could exist in this contract
																	array_push($contract_match_id, $c_list["ID_CONTRATO_OPERADORA"]);
																	//echo " match! " . $array_period[$counter]["PERIOD"] . "</br>";
																}
																//echo "</br>";
															}

															// Run through the matched contracts
															$installment_contract_status[$array_period[$counter]["PERIOD"]] = 0;
															for ( $i = 0; $i < sizeof($contract_match_id); $i++ )
															{
																// Exist a link between the register and the contract
																$installment_contract_status[$array_period[$counter]["PERIOD"]] = 1;

																// Get the equipment list related to the contract ID
																$equipment_list = $modelo->get_contract_equipment_list($contract_match_id[$i]);

																// Run through equipment list and add the value into array (the key is the installment)
																for ( $j = 0; $j < sizeof($equipment_list); $j++ )
																{
																	$installment_values_list[$array_period[$counter]["PERIOD"]] = $equipment_list[0]["VALOR_PARCELA_EQUIP"];
																}
															}

															$counter++;
														}

														/*echo "</br></br>";
														var_dump($installment_contract_status);
														echo "</br></br>";*/

														//! Remove the duplicated itens
														$installment_array = array_unique($installment_array);

														/*echo "</br></br>";
														var_dump($installment_array);
														echo "</br></br>";*/

														// Run through service list
														foreach ( $data_value as $value )
														{
															// Initialize the flags
															$flag_phone_dont_exist = 0;
															$is_contestation = 0;
															$print = 1;

															// Get the phone number contestation history
															$phone_contestation = $modelo->get_phone_contestation_other_entries($modelo->getIdPEC(), $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false), $value["ID_OUTROS_LANCAMENTOS_DET"]);

															//! =================================[ FILTERS ]=================================

															// Check if the register has a link with the contract
															if ( in_array(trim($value["PERIODO"]), $installment_contract_status) == 1 || in_array(trim($value["PERIODO"]), $installment_array) == 1 )
															{
																$print = 0;
															}
															else
															{
																// If the item was already validated, than it's don't need to appear 
																if ( isset($phone_contestation[0]["IS_CONTESTACAO"]) && $phone_contestation[0]["IS_CONTESTACAO"] == 0 )
																{
																	$print = 0;
																}

																// Check if the contract has expired
																if ( substr($installment, 0, 2) > $contract_list[0]["CARENCIA"] )
																{
																	$print = 0;
																}

																// Check if it has a phone number
																if ( $value["LINHA"] == "" )
																{
																	$is_contestation = 1;
																	$print = 1;
																}
															}

															//! =============================================================================

															// Check the contract period
															foreach ( $array_period as $a_period )
															{
																if ( strcmp($a_period["PERIOD"], str_replace("_a_", " a ", $value["PERIODO"])) == 0 )
																{
																	$periodo = $a_period["PERIOD"];
																	$print = 0;
																	break;
																}
															}

															// Print just the contestation registers
															if ( $print == 1 )
															{
																// Check if the current period is different from before
																if ( strcmp( trim($value["PERIODO"]), $current_period ) != 0 )
																{//echo "XXX: " . trim($value["PERIODO"]) . " --> " . $current_period . "</br>";
																	// Initial status color
																	$status_color = "";
																	$status_color_text = "";
																	$subtotal_value2 = 0;

																	// Call the function to compare the installment group value
																	$data_value_list = $modelo->get_otherentries_detail_period_value_list($modelo->getIdPEC(), $lancamento_id, $value["PERIODO"]);

																	foreach ($data_value_list as $value_list)
																	{
																		$subtotal_value2 = real_sum($subtotal_value2, $value_list["VALOR"]);
																	}

																	// Check if the installment total value is the same of the contract
																	if ( isset( $installment_values_list[trim($value["PERIODO"])] ) )
																	{
																		if ( compare_float( currency_operation( $installment_values_list[trim($value["PERIODO"])], real_currency($subtotal_value2), "-" ), 0 ) == false )
																		{
																			//echo "</br>" . trim($value["PERIODO"]) . " - DIFERENTE: " . $installment_values_list[trim($value["PERIODO"])] . " = " . real_currency($subtotal_value2) . "</br>";
																			$status_color = "#ffeb9c";
																			$status_color_text = "#cf7e00";
																		}
																		else
																		{
																			//echo "</br>" . trim($value["PERIODO"]) . " - IGUAL: " . $installment_values_list[trim($value["PERIODO"])] . " = " . real_currency($subtotal_value2) . "</br>";
																		}
																	}
																	
																	// Check if the register has a link with the contract
																	if ( !isset($installment_contract_status[trim($value["PERIODO"])]) || $installment_contract_status[trim($value["PERIODO"])] == 0 )
																	{
																		$status_color = "#ffc7ce";
																		$status_color_text = "#cf2d06";
																	}
																}

																// Get the current period
																$current_period = trim($value["PERIODO"]);

																// Init row
																echo "<tr style='background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center;'>";

																// Period
																if ( isset($value["PERIODO"]) && $value["PERIODO"] != "" )
																{
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . str_replace("_a_", " a ", $value["PERIODO"]) . "' >" . str_replace("_a_", " a ", $value["PERIODO"]) . "</td>";
																	$period = str_replace("_a_", " a ", $value["PERIODO"]);
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Action buttons
																echo "<td class='center'>";

																if ( isset($value["ID_OUTROS_LANCAMENTOS_DET"]) && $value["ID_OUTROS_LANCAMENTOS_DET"] != 0 && $value["LINHA"] != "" )
																{
																	echo "<div class='visible-md visible-lg hidden-sm hidden-xs'>";

																	if ( isset($phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"]) && $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] != 0 )
																	{
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", ". $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . ", 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", ". $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . ", 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																	}
																	else
																	{
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", 0, 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", 0, 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																	}
																	
																	echo "</div>";
																}

																echo "</td>";

																// Justify
																if ( isset($phone_contestation[0]["JUSTIFICATIVA"]) && $phone_contestation[0]["JUSTIFICATIVA"] != "" )
																	echo "<td style='text-align: center;' title='" . $phone_contestation[0]["JUSTIFICATIVA"] . "'>" . $phone_contestation[0]["JUSTIFICATIVA"] . "</td>";
																else
																{
																	if ( $value["LINHA"] == "" )
																	{
																		echo "<td style='text-align: center;' title='NÃO POSSUI UM ACESSO'>NÃO POSSUI UM ACESSO</td>";
																		$flag_phone_dont_exist = 1;
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";
																}

																// Phone number
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																{
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
																	$phone_list .= "<option value='" . $value["LINHA"] . "'>" . $value["LINHA"] . "</option>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Description
																if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["DESCRITIVO"] . "' >" . $value["DESCRITIVO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Entry type
																if ( isset($value["DESCRICAO"]) && $value["DESCRICAO"] != "" )
																{
																	echo "<td style='text-align: center;' title='" . $value["DESCRICAO"] . "' >" . $value["DESCRICAO"] . "</td>";
																	$classification_list .= "<option value='" . $value["DESCRICAO"] . "'>" . $value["DESCRICAO"] . "</option>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Contract period
																if ( isset($value["PERIODO"]) && $value["PERIODO"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["PERIODO"] . "' >" . $value["PERIODO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Value
																if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																{
																	//! Ignore the values from entries without phone
																	/*if ( $flag_phone_dont_exist == 1 )
																		$value["VALOR"] = 0;*/

																	$aux_value = str_replace(",", ".", $value["VALOR"]);
																	$aux_value = remove_double_dots($aux_value);
																	$subtotal_value = real_sum($subtotal_value, $aux_value);

																	if ( isset($subtotal_value) )
																	{
																		echo "<td style='text-align: center;' title='" . real_currency($subtotal_value) . "'>" . real_currency($subtotal_value) . "</td>";

																		// Total sum
																		$total_value = real_sum($total_value, $subtotal_value);

																		echo '<input type="hidden" name="hidden_value' . $value["PERIODO"] . '" value="' . real_currency($subtotal_value) . '" />';
																	}
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																if ( isset($phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"]) && $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] != 0 )
																{
																	$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' 
																	data-vl-fat='" . real_currency($subtotal_value) . "' data-vl-contract='0,00' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . 
																	$value["ID_OUTROS_LANCAMENTOS_DET"] . "@@" . $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . "'/>";
																}
																else
																{
																	$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' 
																	data-vl-fat='" . real_currency($subtotal_value) . "' data-vl-contract='0,00' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . 
																	$value["ID_OUTROS_LANCAMENTOS_DET"] . "@@0'/>";
																}

																// End content
																echo "</tr>";
																$count += 1;
																$subtotal_value = 0;
															}
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
														<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_value); ?></h4></td>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											</table>
										</div>
									<?php } else if ( strpos($entry_description, "Descontos") !== false ) { ?>
										<div class="row">
											<div class="col-md-12 space20">
												<button id="contestFilter" title="Validar/contestar todos os acessos filtrados" class="btn btn-blue add-row" type="button">
													<i class="fa fa-filter"></i> Validar/contestar com filtro
												</button>

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

										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;" title="DESCRITIVO DO LANÇAMENTO">DESCRITIVO</th>
														<th style="white-space: nowrap; text-align: center;" title=""></th>
														<th style="text-align: center;" title="ACESSO">JUSTIFICATIVA</th>
														<th style="white-space: nowrap; text-align: center;" title="ACESSO">ACESSO</th>
														<th style="white-space: nowrap; text-align: center;" title="PERÍODO">PERÍODO</th>
														<th style="white-space: nowrap; text-align: center;" title="TIPO DE LANÇAMENTO">CLASSIFICAÇÃO</th>
														<th style="white-space: nowrap; text-align: center;" title="VALOR DO LANÇAMENTO">VALOR(R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php

														// Auxiliary variable
														$colspan = 6;
														$print = 1;
														$is_contestation = 0;
														$phone_list = "";
														$classification_list = "";
														$period = "";
														$hidden_field_list = "";
														$flag_phone_dont_exist = 0;

														// Run through service list
														foreach ( $data_value as $value )
														{
															// Initialize the flags
															$flag_phone_dont_exist = 0;
															$is_contestation = 0;
															$print = 1;

															// Get the phone number contestation history
															$phone_contestation = $modelo->get_phone_contestation_other_entries($modelo->getIdPEC(), $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false), $value["ID_OUTROS_LANCAMENTOS_DET"]);

															// If the item was already validated, than it's don't need to appear 
															if ( isset($phone_contestation[0]["IS_CONTESTACAO"]) && $phone_contestation[0]["IS_CONTESTACAO"] == 0 )
															{
																$print = 0;
															}

															// Check if it has a phone number
															if ( $value["LINHA"] == "" )
															{
																$is_contestation = 1;
															}

															// Print just the contestation registers
															if ( $print == 1 )
															{
																// Init row
																echo "<tr>";

																// Description
																if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																{
																	// Type
																	if ( isset($value["TIPO"]) && $value["TIPO"] != "" )
																		echo "<td style='text-align: center;' title='" . $value["TIPO"] . "' >" . $value["DESCRITIVO"] . ": " . $value["TIPO"] . "</td>";
																	else
																		echo "<td style='text-align: center;' title='" . $value["DESCRITIVO"] . "' >" . $value["DESCRITIVO"] . "</td>";
																}
																else
																	echo "<td style='text-align: center;'> SEM DESCRIÇÃO </td>";

																// Action buttons
																echo "<td class='center'>";

																if ( isset($value["ID_OUTROS_LANCAMENTOS_DET"]) && $value["ID_OUTROS_LANCAMENTOS_DET"] != 0 && $value["LINHA"] != "" )
																{
																	echo "<div class='visible-md visible-lg hidden-sm hidden-xs'>";

																	if ( isset($phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"]) && $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] != 0 )
																	{
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", ". $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . ", 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", ". $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . ", 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																	}
																	else
																	{
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", 0, 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", 0, 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																	}
																	
																	echo "</div>";
																}

																echo "</td>";

																// Justify
																if ( isset($phone_contestation[0]["JUSTIFICATIVA"]) && $phone_contestation[0]["JUSTIFICATIVA"] != "" )
																	echo "<td style='text-align: center;' title='" . $phone_contestation[0]["JUSTIFICATIVA"] . "'>" . $phone_contestation[0]["JUSTIFICATIVA"] . "</td>";
																else
																{
																	if ( $value["LINHA"] == "" )
																	{
																		echo "<td style='text-align: center;' title='NÃO POSSUI UM ACESSO'>NÃO POSSUI UM ACESSO</td>";
																		$flag_phone_dont_exist = 1;
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";
																}

																// Phone number
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																{
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
																	$phone_list .= "<option value='" . $value["LINHA"] . "'>" . $value["LINHA"] . "</option>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Period
																if ( isset($value["PERIODO"]) && $value["PERIODO"] != "" )
																{
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . str_replace("_a_", " a ", $value["PERIODO"]) . "' >" . str_replace("_a_", " a ", $value["PERIODO"]) . "</td>";
																	$period = str_replace("_a_", " a ", $value["PERIODO"]);
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Entry type
																if ( isset($value["DESCRICAO"]) && $value["DESCRICAO"] != "" )
																{
																	echo "<td style='text-align: center;' title='" . $value["DESCRICAO"] . "' >" . $value["DESCRICAO"] . "</td>";
																	$classification_list .= "<option value='" . $value["DESCRICAO"] . "'>" . $value["DESCRICAO"] . "</option>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Value
																if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																{
																	//! Ignore the values from entries without phone
																	if ( $flag_phone_dont_exist == 1 )
																		$value["VALOR"] = 0;

																	$aux_value = str_replace(",", ".", $value["VALOR"]);
																	$aux_value = remove_double_dots($aux_value);
																	$subtotal_value = real_sum($subtotal_value, $aux_value);

																	if ( isset($subtotal_value) )
																	{
																		echo "<td style='text-align: center;' title='" . real_currency($subtotal_value) . "'>" . real_currency($subtotal_value) . "</td>";

																		// Total sum
																		$total_value = real_sum($total_value, $subtotal_value);

																		if ( isset($value["TIPO"]) && $value["TIPO"] != "" )
																			echo '<input type="hidden" name="hidden_value' . preg_replace('/\s+/', '', $value["DESCRITIVO"] . ": " . $value["TIPO"]) . '" value="' . real_currency($subtotal_value) . '" />';
																		else
																			echo '<input type="hidden" name="hidden_value' . preg_replace('/\s+/', '', $value["DESCRITIVO"]) . '" value="' . real_currency($subtotal_value) . '" />';
																	}
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																if ( isset($phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"]) && $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] != 0 )
																{
																	$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' 
																	data-vl-fat='" . real_currency($subtotal_value) . "' data-vl-contract='0,00' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . 
																	$value["ID_OUTROS_LANCAMENTOS_DET"] . "@@" . $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . "'/>";
																}
																else
																{
																	$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' 
																	data-vl-fat='" . real_currency($subtotal_value) . "' data-vl-contract='0,00' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . 
																	$value["ID_OUTROS_LANCAMENTOS_DET"] . "@@0'/>";
																}

																// End content
																echo "</tr>";
																$count += 1;
																$subtotal_value = 0;
															}
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
														<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_value); ?></h4></td>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											</table>
										</div>
									<?php } else { ?>
										<div class="row">
											<div class="col-md-12 space20">
												<button id="contestFilter" title="Validar/contestar todos os acessos filtrados" class="btn btn-blue add-row" type="button">
													<i class="fa fa-filter"></i> Validar/contestar com filtro
												</button>
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

										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="sample_2">
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;" title=""></th>
														<th style="text-align: center;" title="ACESSO">JUSTIFICATIVA</th>
														<th style="white-space: nowrap; text-align: center;" title="ACESSO">ACESSO</th>
														<th style="white-space: nowrap; text-align: center;" title="DESCRITIVO DO LANÇAMENTO">DESCRITIVO</th>
														<th style="white-space: nowrap; text-align: center;" title="PERÍODO">PERÍODO</th>
														<th style="white-space: nowrap; text-align: center;" title="TIPO DE LANÇAMENTO">CLASSIFICAÇÃO</th>
														<th style="white-space: nowrap; text-align: center;" title="TIPO">TIPO</th>
														<th style="white-space: nowrap; text-align: center;" title="VALOR DO LANÇAMENTO">VALOR(R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php

														// Auxiliary variable
														$colspan = 7;
														$print = 1;
														$is_contestation = 0;
														$phone_list = "";
														$classification_list = "";
														$period = "";
														$hidden_field_list = "";

														// Run through service list
														foreach ( $data_value as $value )
														{
															// Initialize the flags
															$is_contestation = 0;
															$print = 1;

															// Get the phone number contestation history
															$phone_contestation = $modelo->get_phone_contestation_other_entries($modelo->getIdPEC(), $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false), $value["ID_OUTROS_LANCAMENTOS_DET"]);

															// If the item was already validated, than it's don't need to appear 
															if ( isset($phone_contestation[0]["IS_CONTESTACAO"]) && $phone_contestation[0]["IS_CONTESTACAO"] == 0 )
															{
																$print = 0;
															}

															// Check if it has a phone number
															if ( $value["LINHA"] == "" )
															{
																$is_contestation = 1;
															}

															// Print just the contestation registers
															if ( $print == 1 )
															{
																// Init row
																echo "<tr>";

																// Action buttons
																echo "<td class='center'>";

																if ( isset($value["ID_OUTROS_LANCAMENTOS_DET"]) && $value["ID_OUTROS_LANCAMENTOS_DET"] != 0 && $value["LINHA"] != "" )
																{
																	echo "<div class='visible-md visible-lg hidden-sm hidden-xs'>";

																	if ( isset($phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"]) && $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] != 0 )
																	{
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", ". $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . ", 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", ". $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . ", 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																	}
																	else
																	{
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", 0, 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																		echo "<a onClick='contestRegister(" . $pec_id . ", " . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_OUTROS_LANCAMENTOS_DET"] . ", 0, 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																	}
																	
																	echo "</div>";
																}

																echo "</td>";

																// Justify
																if ( isset($phone_contestation[0]["JUSTIFICATIVA"]) && $phone_contestation[0]["JUSTIFICATIVA"] != "" )
																	echo "<td style='text-align: center;' title='" . $phone_contestation[0]["JUSTIFICATIVA"] . "'>" . $phone_contestation[0]["JUSTIFICATIVA"] . "</td>";
																else
																{
																	if ( $value["LINHA"] == "" )
																		echo "<td style='text-align: center;' title='NÃO POSSUI UM ACESSO'>NÃO POSSUI UM ACESSO</td>";
																	else
																		echo "<td style='text-align: center;'>-</td>";
																}

																// Phone number
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																{
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
																	$phone_list .= "<option value='" . $value["LINHA"] . "'>" . $value["LINHA"] . "</option>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Description
																if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["DESCRITIVO"] . "' >" . $value["DESCRITIVO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> SEM DESCRIÇÃO </td>";

																// Period
																if ( isset($value["PERIODO"]) && $value["PERIODO"] != "" )
																{
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . str_replace("_a_", " a ", $value["PERIODO"]) . "' >" . str_replace("_a_", " a ", $value["PERIODO"]) . "</td>";
																	$period = str_replace("_a_", " a ", $value["PERIODO"]);
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Entry type
																if ( isset($value["DESCRICAO"]) && $value["DESCRICAO"] != "" )
																{
																	echo "<td style='text-align: center;' title='" . $value["DESCRICAO"] . "' >" . $value["DESCRICAO"] . "</td>";
																	$classification_list .= "<option value='" . $value["DESCRICAO"] . "'>" . $value["DESCRICAO"] . "</option>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Type
																if ( isset($value["TIPO"]) && $value["TIPO"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["TIPO"] . "' >" . $value["TIPO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Value
																if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																{
																	$aux_value = str_replace(",", ".", $value["VALOR"]);
																	$aux_value = remove_double_dots($aux_value);
																	$subtotal_value = real_sum($subtotal_value, $aux_value);

																	if ( isset($subtotal_value) )
																	{
																		echo "<td style='text-align: center;' title='" . real_currency($subtotal_value) . "'>" . real_currency($subtotal_value) . "</td>";

																		// Total sum
																		$total_value = real_sum($total_value, $subtotal_value);
																	}
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																if ( isset($phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"]) && $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] != 0 )
																{
																	$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' 
																	data-vl-fat='" . real_currency($subtotal_value) . "' data-vl-contract='0,00' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . 
																	$value["ID_OUTROS_LANCAMENTOS_DET"] . "@@" . $phone_contestation[0]["ID_OUTROS_LANCAMENTOS_CONTESTACAO"] . "'/>";
																}
																else
																{
																	$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden' data-ref='" . $period . "' 
																	data-vl-fat='" . real_currency($subtotal_value) . "' data-vl-contract='0,00' value='" . $pec_id . "@@" . $modelo->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . 
																	$value["ID_OUTROS_LANCAMENTOS_DET"] . "@@0'/>";
																}

																// End content
																echo "</tr>";
																$count += 1;
																$subtotal_value = 0;
															}
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
														<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_value); ?></h4></td>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											</table>
										</div>
									<?php } ?>

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
			 * @param other_entry_ID_ => plan ID
			 * @param id_phone_contest_ => phone contestation ID
			 * @param contest_type_ => contestation type: 0 => VALID / 1 => CONTESTATION
			*/
			function contestRegister( pec_ID_, phone_ID_, other_entry_ID_, id_phone_contest_, contest_type_ )
			{
				var justify;

				if ( contest_type_ == 0 )
					justify = prompt("Informe uma justificativa para a contestação", "");
				else
					justify = prompt("Informe uma justificativa para a validação", "");

				if ( justify != "" && justify != null )
				{
					// Callback to delete the element
					sendRequest( '<?php echo HOME_URI;?>/modulo_pec/contestacaootherentriesbyregister_pec', 'action=contest&phone_ID=' + phone_ID_ + '&pec_ID=' + pec_ID_ + 
						'&other_entry_ID=' + other_entry_ID_ + '&contest_ID=' + id_phone_contest_ + '&contest_type=' + contest_type_ + 
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
				var JUSTIFICATIVA = document.getElementById("JUSTIFICATIVA");
				var phone_id = "";
				var list_value = "";
				var contest_array;
				var aux_info;

				// Validate the filter
				if ( SELECT_ACESSOS.value == "" && DATA_INICIAL.value == "" && DATA_FINAL.value == "" && VALOR_FATURA.value == "" )
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
							results.push( sendRequestAjax( '<?php echo HOME_URI;?>/modulo_pec/contestacaootherentriesbyregister_pec?action=contest&phone_ID=' + aux_info[1] + 
								'&pec_ID=' + aux_info[0] +  '&other_entry_ID=' + aux_info[2] + '&contest_ID=' + aux_info[3] + '&contest_type=' + contest_type + 
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