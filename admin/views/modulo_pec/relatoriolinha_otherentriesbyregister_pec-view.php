							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Detalhamento por lançamento">Detalhamento por lançamento <small>relatório </small></h1>
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
							$lancamento_id = decrypted_url($_GET['idLancamento'] , "**");
						}
						else
						{
							?><script>alert("Houve um problema com o identificador do lançamento. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/otherentriesreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Get entries description
						$entry_description = $modelo->get_lancamento_description($modelo->getIdPEC(), $lancamento_id);

						// Get entries type
						$entry_type = $modelo->get_lancamento_type($modelo->getIdPEC(), $lancamento_id);

						// Get carrier ID
						$carrier = $modelo->get_carrier_pec($modelo->getIdPEC());

						// Auxiliary variable
						$total_installment = 0;
						$total_discount = 0;
						$total_valuet = 0;
						$total_value = 0;
						$total_time = 0;
						$total_traffic = 0;
						$total_sms = 0;
						$subtotal_value = 0;
						$subtotal_value2 = 0;
						$subtotal_value3 = 0;
						$subtotal_value4 = 0;
						$show_minutes = 0;
						$count = 0;

						// Get the entire report
						$data_value = $modelo->get_otherentries_detail_groupped($modelo->getIdPEC(), $lancamento_id, true);
					?>

					<?php 

						/**
						 * Auxiliar function to split the information with line break in the sam row
						 *
						 * @since 0.1
						 * @access public
						 * @info_ => Information to be splitted
						 * @alignment_ => The print alignment
						*/
						function print_splitted_values( $info_, $alignment_ )
						{
							// Array with each information
							$array_info = explode("///", $info_);

							// Print the <td> structure
							echo "<td style='text-align: " . $alignment_ . "; white-space: nowrap;'>";

							// Run through the information array
							for ( $i = 0; $i < sizeof($array_info); $i++ )
							{
								if ( isset($array_info[$i]) )
									echo $array_info[$i] . "</br>";
							}

							// Close the <td>
							echo "</td>";
						}

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
										//! Check the entry type
										if ( $carrier == 6 ) //! TIM
										{
									?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;" title="ACESSO">ACESSO</th>
														<th style="white-space: nowrap; text-align: center;" title="DESCRITIVO DO LANÇAMENTO">DESCRITIVO</th>
														<th style="white-space: nowrap; text-align: center;" title="CLASSIFICAÇÃO DO REGISTRO">CLASSIFICAÇÃO</th>
														<th style="white-space: nowrap; text-align: center;" title="DURAÇÃO">DURAÇÃO</th>
														<th style="white-space: nowrap; text-align: center;" title="VOLUME DE DADOS">DADOS</th>
														<th style="white-space: nowrap; text-align: center;" title="ICMS">ICMS</th>
														<th style="white-space: nowrap; text-align: center;" title="PIS/COFINS">PIS/COFINS</th>
														<th style="white-space: nowrap; text-align: center;" title="VALOR DO LANÇAMENTO">VALOR(R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$colspan = 3;

														// Run through service list
														foreach ( $data_value as $value )
														{
															// Init row
															echo "<tr>";

															// Phone number
															if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																echo "<td style='text-align: left; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Description
															if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																echo "<td style='text-align: left;' title='" . $value["DESCRITIVO"] . "' >" . $value["DESCRITIVO"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Entry type
															if ( isset($value["DESCRICAO"]) && $value["DESCRICAO"] != "" )
																echo "<td style='text-align: center;' title='" . $value["DESCRICAO"] . "' >" . $value["DESCRICAO"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Duration
															if ( isset($value["DURACAO"]) && $value["DURACAO"] != "" )
															{
																$value["DURACAO"] = str_replace("Min:", "", $value["DURACAO"]);
																$value["DURACAO"] = str_replace("min", "m", $value["DURACAO"]);

																// Check the time format (hh:mm:ss)
																if ( strlen($value["DURACAO"]) == 8 )
																{
																	if ( strpos($value["DURACAO"], "m") === false || strpos($value["DURACAO"], "s") === false )
																	{
																		echo "<td style='text-align: center;' title='" . format_mm_ss(format_hh_mm_ss($value["DURACAO"])) . "'>" . format_mm_ss(format_hh_mm_ss($value["DURACAO"])) . "</td>";
																		$value["DURACAO"] = format_mm_ss(format_hh_mm_ss($value["DURACAO"]));
																	}
																	else
																		echo "<td style='text-align: center;' title='" . $value["DURACAO"] . "'>" . $value["DURACAO"] . "</td>";
																}
																else if ( strpos($value["DURACAO"], ",") !== false )
																{
																	$value["DURACAO"] = str_replace("m", "", $value["DURACAO"]);
																	$value["DURACAO"] = str_replace(",", "m", $value["DURACAO"]);
																	$value["DURACAO"] .= "s";

																	echo "<td style='text-align: center;' title='" . $value["DURACAO"] . "'>" . $value["DURACAO"] . "</td>";
																}
																else
																{
																	//! Add the seconds to the utilization
																	if ( strpos($value["DURACAO"], "s") === false && $value["DURACAO"] != "" && $value["DURACAO"] != "-" )
																	{
																		$value["DURACAO"] .= "00s";
																	}

																	echo "<td style='text-align: center;' title='" . $value["DURACAO"] . "'>" . $value["DURACAO"] . "</td>";
																}

																if ( $value["DURACAO"] != "" && $value["DURACAO"] != "-" )
																{
																	if ( strpos($value["DURACAO"], "m") === false )
																	{
																		// Total duration
																		if ( $count != 0 )
																			$total_time = min_sec_sum($total_time, $value["DURACAO"]);
																		else
																			$total_time = $value["DURACAO"];
																	}
																	else
																	{
																		// Total duration
																		if ( $count != 0 )
																			$total_time = min_sec_sum($total_time, format_min_sec($value["DURACAO"]));
																		else
																			$total_time = format_min_sec($value["DURACAO"]);
																		$total_time = str_replace(".", "", $total_time);
																		$show_minutes = 1;
																	}
																}
															}
															else
															{
																echo "<td style='text-align: center;'>-</td>";
															}

															// Volume
															if ( isset($value["VOLUME"]) && $value["VOLUME"] != "" )
															{
																$aux_traffic = "";
																$subtotal_traffic = 0;
																$aux_traffic = preg_replace("/MB+\s+/", ",", $value["VOLUME"]);
																$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																$aux_traffic = str_replace(",", ".", $aux_traffic);
																$subtotal_traffic = real_sum($subtotal_traffic, ($aux_traffic * 1000));

																echo "<td style='text-align: center;' title='" . formatMbKb($subtotal_traffic) . "'>" . formatMbKb($subtotal_traffic) . "</td>";
																$total_traffic = real_sum($total_traffic, $subtotal_traffic);
															}
															else
															{
																echo "<td style='text-align: center;'>-</td>";
															}

															// ICMS
															if ( isset($value["ICMS"]) && $value["ICMS"] != "" )
																echo "<td style='text-align: center;' title='" . $value["ICMS"] . "' >" . $value["ICMS"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// PIS/COFINS
															if ( isset($value["PIS_COFINS"]) && $value["PIS_COFINS"] != "" )
																echo "<td style='text-align: center;' title='" . $value["PIS_COFINS"] . "' >" . $value["PIS_COFINS"] . "</td>";
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

															// End content
															echo "</tr>";
															$count += 1;
															$subtotal_value = 0;
														}

														// Format the time (if necessary)
														if ( $total_time == "00:00" || $total_time == "0:00" )
															$total_time = "0:00";
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4><?php if ( $show_minutes == 0 ) echo str_replace(".", "", format_mm_ss($total_time)); else echo str_replace("ms", "m00s", format_mm_ss($total_time)); ?></h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4><?php echo formatMbKb($total_traffic); ?></h4></td>
														<td colspan="2" style="text-align: center; white-space: nowrap;"></h4></td>
														<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_value); ?></h4></td>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											</table>
										</div>
									<?php } else { //! OTHERS CARRIERS ?>
										<?php
											//! Check the entry type
											if ( $entry_type != 9 ) //! DIFFERENT FROM DEVICES
											{
										?>
											<div class="table-responsive">
												<table class="table table-striped table-bordered table-hover" id="sample_1">
													<thead>
														<tr>
															<th style="white-space: nowrap; text-align: center;" title="ACESSO">ACESSO</th>
															<th style="white-space: nowrap; text-align: center;" title="DESCRITIVO DO LANÇAMENTO">DESCRITIVO</th>
															<th style="white-space: nowrap; text-align: center;" title="TIPO DE LANÇAMENTO">CLASSIFICAÇÃO</th>
															<th style="white-space: nowrap; text-align: center;" title="PERÍODO">PERÍODO</th>
															<th style="white-space: nowrap; text-align: center;" title="TIPO">TIPO</th>
															<th style="white-space: nowrap; text-align: center;" title="DATA DE PAGAMENTO">DATA_PAG.</th>
															<th style="white-space: nowrap; text-align: center;" title="DATA DE CRÉDITO">DATA_CRED.</th>
															<th style="white-space: nowrap; text-align: center;" title="UTILIZAÇÃO">UTILIZADO</th>
															<th style="white-space: nowrap; text-align: center;" title="UTILIZAÇÃO DE DADOS">DADOS</th>
															<th style="white-space: nowrap; text-align: center;" title="UTILIZAÇÃO DE SMS">SMS</th>
															<th style="white-space: nowrap; text-align: center;" title="VALOR DO LANÇAMENTO">VALOR(R$)</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$colspan = 7;
															$total_value = 0;
															$flag_null_phone = 0;

															// Run through service list
															foreach ( $data_value as $value )
															{
																// Initialize the auxiliary variables
																$flag_null_phone = 0;

																// Init row
																echo "<tr>";

																// Phone number
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																	echo "<td style='text-align: left; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
																else
																{
																	echo "<td style='text-align: center;'> - </td>";
																	$flag_null_phone = 1;
																}

																// Description
																if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																	print_splitted_values( $value["DESCRITIVO"], "left" );
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Entry type
																if ( isset($value["DESCRICAO"]) && $value["DESCRICAO"] != "" )
																	print_splitted_values( $value["DESCRICAO"], "center" );
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Period
																if ( isset($value["PERIODO"]) && $value["PERIODO"] != "" )
																{
																	$value["PERIODO"] = str_replace("R$", "", $value["PERIODO"]);
																	print_splitted_values( str_replace("_a_", " a ", $value["PERIODO"]), "center" );
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Type
																if ( isset($value["TIPO"]) && $value["TIPO"] != "" )
																	print_splitted_values( $value["TIPO"], "center" );
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Payment date
																if ( isset($value["DATA_PAGAMENTO"]) && $value["DATA_PAGAMENTO"] != "" )
																	print_splitted_values( $value["DATA_PAGAMENTO"], "center" );
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Credit date
																if ( isset($value["DATA_CREDITO"]) && $value["DATA_CREDITO"] != "" )
																	print_splitted_values( $value["DATA_CREDITO"], "center" );
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Utilization
																if ( isset($value["UTILIZADO"]) && $value["UTILIZADO"] != "" )
																{
																	$value["UTILIZADO"] = str_replace("min", "m", $value["UTILIZADO"]);

																	// Array with each information
																	$array_info = explode("///", $value["UTILIZADO"]);

																	// Print the <td> structure
																	echo "<td style='text-align: center; white-space: nowrap;'>";

																	// Run through the information array
																	for ( $i = 0; $i < sizeof($array_info); $i++ )
																	{
																		if ( isset($array_info[$i]) )
																		{
																			// Check the time format (hh:mm:ss)
																			if ( strlen($array_info[$i]) == 8 )
																			{
																				echo format_mm_ss(format_hh_mm_ss($array_info[$i])) . "</br>";

																				$array_info[$i] = format_mm_ss(format_hh_mm_ss($array_info[$i]));
																			}
																			else if ( strpos($array_info[$i], ",") !== false )
																			{
																				$array_info[$i] = str_replace("m", "", $array_info[$i]);
																				$array_info[$i] = str_replace(",", "m", $array_info[$i]);
																				$array_info[$i] .= "s";

																				echo $array_info[$i] . "</br>";
																			}
																			else
																			{
																				//! Add the seconds to the utilization
																				if ( strpos($array_info[$i], "s") === false && $array_info[$i] != "" && $array_info[$i] != "-" )
																				{
																					$array_info[$i] .= "00s";
																				}

																				echo $array_info[$i] . "</br>";
																			}

																			if ( $array_info[$i] != "" && $array_info[$i] != "-" )
																			{
																				if ( strpos($array_info[$i], "m") === false )
																				{
																					// Total duration
																					if ( $count != 0 )
																						$total_time = min_sec_sum($total_time, $array_info[$i]);
																					else
																						$total_time = $array_info[$i];
																				}
																				else
																				{
																					// Total duration
																					if ( $count != 0 )
																						$total_time = min_sec_sum($total_time, format_min_sec($array_info[$i]));
																					else
																						$total_time = format_min_sec($array_info[$i]);
																					$total_time = str_replace(".", "", $total_time);
																					$show_minutes = 1;
																				}
																			}
																		}
																	}

																	// Close the <td>
																	echo "</td>";
																}
																else
																{
																	echo "<td style='text-align: center;'>-</td>";
																}

																// Data
																if ( isset($value["DADOS"]) && $value["DADOS"] != "" )
																{
																	// Array with each information
																	$array_info = explode("///", $value["DADOS"]);

																	// Print the <td> structure
																	echo "<td style='text-align: center; white-space: nowrap;'>";

																	// Run through the information array
																	$aux_traffic = "";
																	$subtotal_traffic = 0;
																	for ( $i = 0; $i < sizeof($array_info); $i++ )
																	{
																		$aux_traffic = preg_replace("/MB+\s+/", ",", $value["DADOS"]);
																		$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																		$aux_traffic = str_replace(",", ".", $aux_traffic);
																		$subtotal_traffic = real_sum($subtotal_traffic, ($aux_traffic * 1000));
																		echo formatMbKb($aux_traffic) . "</br>";
																	}

																	echo "<strong>" . formatMbKb($subtotal_traffic)  . "</strong>";
																	$total_traffic = real_sum($total_traffic, $subtotal_traffic);

																	// Close the <td>
																	echo "</td>";
																}
																else
																{
																	echo "<td style='text-align: center;'>-</td>";
																}

																// SMS
																if ( isset($value["SMS"]) && $value["SMS"] != "" )
																{
																	// Array with each information
																	$array_info = explode("///", $value["SMS"]);

																	// Print the <td> structure
																	echo "<td style='text-align: center; white-space: nowrap;'>";

																	// Run through the information array
																	$subtotal_sms = 0;
																	for ( $i = 0; $i < sizeof($array_info); $i++ )
																	{
																		$value["SMS"] = str_replace(",", ".", $value["SMS"]);
																		$value["SMS"] = str_replace(".", "", $value["SMS"]);
																		$subtotal_sms = real_sum($subtotal_sms, $value["SMS"]);
																		echo $value["SMS"] . "</br>";
																	}

																	echo "<strong>" . $subtotal_sms . "</strong>";
																	$total_sms = real_sum($total_sms, $subtotal_sms);

																	// Close the <td>
																	echo "</td>";
																}
																else
																	echo "<td style='text-align: center;'>-</td>";

																// Value
																if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																{
																	// Array with each information
																	$array_info = explode("///", $value["VALOR"]);

																	// Print the <td> structure
																	echo "<td style='text-align: center; white-space: nowrap;'>";

																	// Run through the information array
																	for ( $i = 0; $i < sizeof($array_info); $i++ )
																	{
																		$aux_value = str_replace(",", ".", $array_info[$i]);
																		$aux_value = remove_double_dots($aux_value);
																		$subtotal_value = real_sum($subtotal_value, $aux_value);
																		echo real_currency($aux_value) . "</br>";
																	}

																	echo "<strong>" . real_currency($subtotal_value) . "</strong>";

																	/*!
																	 * RULE: If the entries are related to discount and the phone number
																	 * is null, ignore the value
																	*/
																	if ( $flag_null_phone == 1 && strpos(strtolower($entry_description), "desconto") !== false )
																	{
																		$subtotal_value = 0;
																	}

																	$total_value = real_sum($total_value, $subtotal_value);

																	// Close the <td>
																	echo "</td>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// End content
																echo "</tr>";
																$count += 1;
																$subtotal_value = 0;
															}

															// Format the time (if necessary)
															if ( $total_time == "00:00" || $total_time == "0:00" )
																$total_time = "0:00";
														?>
													</tbody>
													<tfoot>
														<tr>
															<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
															<td style="text-align: center; white-space: nowrap;"><h4><?php if ( $show_minutes == 0 ) echo str_replace(".", "", format_mm_ss($total_time)); else echo str_replace("ms", "m00s", format_mm_ss($total_time)); ?></h4></td>
															<td style="text-align: center; white-space: nowrap;"><h4><?php echo formatMbKb($total_traffic); ?></h4></td>
															<td style="text-align: center; white-space: nowrap;"><h4><?php echo $total_sms; ?></h4></td>
															<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_value); ?></h4></td>
														</tr>
													</tfoot>
													<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
												</table>
											</div>
										<?php } else { ?>
											<div class="table-responsive">
												<table class="table table-striped table-bordered table-hover" id="sample_1">
													<thead>
														<tr>
															<th style="white-space: nowrap; text-align: center;" title="DATA">DATA</th>
															<th style="white-space: nowrap; text-align: center;" title="Nº DA SOLICITAÇÃO">SOLICITAÇÃO</th>
															<th style="white-space: nowrap; text-align: center;" title="DESCRIÇÃO">DESCRIÇÃO</th>
															<th style="white-space: nowrap; text-align: center;" title="IMEI/SIM CARD">IMEI/SIM</th>
															<th style="white-space: nowrap; text-align: center;" title="IMEI/APARELHO">IMEI/APARELHO</th>
															<th style="white-space: nowrap; text-align: center;" title="LOCAL">LOCAL</th>
															<th style="white-space: nowrap; text-align: center;" title="NOTA FISCAL">NOTA FISCAL</th>
															<th style="white-space: nowrap; text-align: center;" title="PARCELA">PARCELA</th>
															<th style="white-space: nowrap; text-align: center;" title="VALOR DA PARCELA(R$)">VALOR PARCELA</th>
															<th style="white-space: nowrap; text-align: center;" title="VALOR(R$)">VALOR</th>
															<th style="white-space: nowrap; text-align: center;" title="VALOR DO DESCONTO(R$)">DESCONTO</th>
															<th style="white-space: nowrap; text-align: center;" title="VALOR TOTAL(R$)">VALOR TOTAL</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$colspan = 8;

															// Run through service list
															foreach ( $data_value as $value )
															{
																// Init row
																echo "<tr>";

																// Date
																if ( isset($value["DATA"]) && $value["DATA"] != "" )
																	echo "<td style='text-align: left; white-space: nowrap;' title='" . $value["DATA"] . "' >" . $value["DATA"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// N_solicitacao
																if ( isset($value["N_SOLICITACAO"]) && $value["N_SOLICITACAO"] != "" )
																	echo "<td style='text-align: left;' title='" . $value["N_SOLICITACAO"] . "' >" . $value["N_SOLICITACAO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Description
																if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																	echo "<td style='text-align: left;' title='" . $value["DESCRITIVO"] . "' >" . $value["DESCRITIVO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Imei SIM
																if ( isset($value["IMEI_SIM"]) && $value["IMEI_SIM"] != "" )
																{
																	//! Get each value
																	$aux_imei_sim = explode("//", $value["IMEI_SIM"]);

																	echo "<td style='text-align: center;' title='IMEI/SIM CARD' >";
																	for ( $i = 0; $i < sizeof($aux_imei_sim); $i++)
																	{
																		echo $aux_imei_sim[$i] . "</br>";
																	}
																	echo "</td>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Imei SIM
																if ( isset($value["IMEI_APARELHO"]) && $value["IMEI_APARELHO"] != "" )
																{
																	//! Get each value
																	$aux_imei_sim = explode("//", $value["IMEI_APARELHO"]);

																	echo "<td style='text-align: center;' title='IMEI/SIM CARD' >";
																	for ( $i = 0; $i < sizeof($aux_imei_sim); $i++)
																	{
																		echo $aux_imei_sim[$i] . "</br>";
																	}
																	echo "</td>";
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Local
																if ( isset($value["LOCAL"]) && $value["LOCAL"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["LOCAL"] . "' >" . $value["LOCAL"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";
																
																// Invoice number
																if ( isset($value["NOTA_FISCAL"]) && $value["NOTA_FISCAL"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["NOTA_FISCAL"] . "' >" . $value["NOTA_FISCAL"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Installment
																if ( isset($value["PARCELA"]) && $value["PARCELA"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["PARCELA"] . "' >" . $value["PARCELA"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Installment value it's swapped with Value
																if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																{
																	$aux_value = str_replace(",", ".", $value["VALOR"]);
																	$aux_value = remove_double_dots($aux_value);
																	$subtotal_value2 = real_sum($subtotal_value2, $aux_value);

																	if ( isset($subtotal_value2) )
																	{
																		echo "<td style='text-align: center;' title='" . real_currency($subtotal_value2) . "'>" . real_currency($subtotal_value2) . "</td>";

																		// Total sum
																		$total_installment = real_sum($total_installment, $subtotal_value2);
																	}
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Value it's swapped with Total Value
																if ( isset($value["VALOR_TOTAL"]) && $value["VALOR_TOTAL"] != "" )
																{
																	$aux_value = str_replace(",", ".", $value["VALOR_TOTAL"]);
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

																// Discount value
																if ( isset($value["VALOR_DESCONTO"]) && $value["VALOR_DESCONTO"] != "" )
																{
																	$aux_value = str_replace(",", ".", $value["VALOR_DESCONTO"]);
																	$aux_value = remove_double_dots($aux_value);
																	$subtotal_value3 = real_sum($subtotal_value3, $aux_value);

																	if ( isset($subtotal_value3) )
																	{
																		echo "<td style='text-align: center;' title='" . real_currency($subtotal_value3) . "'>" . real_currency($subtotal_value3) . "</td>";

																		// Total sum
																		$total_discount = real_sum($total_discount, $subtotal_value3);
																	}
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Total value it's swapped with Value
																if ( isset($value["VALOR_PARCELA"]) && $value["VALOR_PARCELA"] != "" )
																{
																	$aux_value = str_replace(",", ".", $value["VALOR_PARCELA"]);
																	$aux_value = remove_double_dots($aux_value);
																	$subtotal_value4 = real_sum($subtotal_value4, $aux_value);

																	if ( isset($subtotal_value4) )
																	{
																		echo "<td style='text-align: center;' title='" . real_currency($subtotal_value4) . "'>" . real_currency($subtotal_value4) . "</td>";

																		// Total sum
																		$total_valuet = real_sum($total_valuet, $subtotal_value4);
																	}
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// End content
																echo "</tr>";
																$subtotal_value = 0;
																$subtotal_value2 = 0;
																$subtotal_value3 = 0;
																$subtotal_value4 = 0;
															}
														?>
													</tbody>
													<tfoot>
														<tr>
															<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
															<td style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_installment); ?></h4></td>
															<td style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_value); ?></h4></td>
															<td style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_discount); ?></h4></td>
															<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_valuet); ?></h4></td>
														</tr>
													</tfoot>
													<input type="hidden" id="total_value" value="<?php echo real_currency($total_valuet); ?>" />
												</table>
											</div>
										<?php } ?>
									<?php } ?>
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