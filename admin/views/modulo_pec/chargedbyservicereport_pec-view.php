							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="O que está sendo cobrado por serviço">O que está sendo cobrado por serviço <small>relatório </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Check if PEC ID is valid
						$modelo->checkValidit_PEC();

						// Check if service ID is valid
						if (isset($_GET['idService']) && $_GET['idService'] != '')
						{
							$service_id = decrypted_url($_GET['idService'] , "**");
							$service_name = $modelo->get_service_pec($service_id);
						}
						else
						{
							?><script>alert("Houve um problema com o identificador do serviço. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/menu_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
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
										// Get PEC's carrier
										$carrier = $modelo->get_carrier_pec($modelo->getIdPEC());
									?>

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
														<th style="white-space: nowrap; text-align: center;" title="DURAÇÃO">DURAÇÃO</th>
														<th style="white-space: nowrap; text-align: center;" title="VOLUME DE DADOS">DADOS</th>
														<th style="white-space: nowrap; text-align: center;" title="ICMS">ICMS</th>
														<th style="white-space: nowrap; text-align: center;" title="PIS/COFINS">PIS/COFINS</th>
														<th style="white-space: nowrap; text-align: center;" title="VALOR DO LANÇAMENTO">VALOR(R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
													
														// Auxiliary variable
														$total_value = 0;
														$total_time = 0;
														$total_traffic = 0;
														$total_sms = 0;
														$subtotal_value = 0;
														$show_minutes = 0;
														$count = 0;
														$colspan = 2;

														// Get the entire report
														$data_value = $modelo->chargedbyservicereport_PEC($modelo->getIdPEC(), $service_id);

														// Run through service list
														foreach ( $data_value as $value )
														{
															// Init row
															echo "<tr>";

															// Phone number
															if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																echo "<td style='text-align: center;' title='" . $value["LINHA"] . "'><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/chargedbyservicereport_pec?idPEC=") . encrypted_url($value["ID_SERVICO"], "?idServico=") . "' title='" . $value["LINHA"] . "'>" . $value["LINHA"] . "</a></td>";
															else
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

															// Description
															if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																echo "<td style='text-align: left;' title='" . $value["DESCRITIVO"] . "' >" . $value["DESCRITIVO"] . "</td>";
															else
															{
																if ( isset($value["DESCRICAO"]) && $value["DESCRICAO"] != "" )
																	echo "<td style='text-align: left;' title='" . $value["DESCRICAO"] . "' >" . $value["DESCRICAO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";
															}

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
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center; width: 20%;">ACESSO</th>
														<?php
															// Check if it's a Nextel report
															if ( isset($carrier) && $carrier == 10 ) { ?>
																<th style="white-space: nowrap; text-align: center; width: 20%;">RÁDIO ID</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center; width: 20%;">PERÍODO DE REFERÊNCIA</th>
														<th style="white-space: nowrap; text-align: center; width: 20%;">MINUTOS</th>
														<th style="white-space: nowrap; text-align: center; width: 20%;">VALOR (R$)</th>
														<th style="white-space: nowrap; text-align: center; width: 20%;">VALOR TOTAL (R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
														// Auxiliary variable
														$current_number = "";
														$subtotal = 0;
														$total_value = 0;
														$colspan = 5;

														// Set footer's colspan
														if ( isset($carrier) && $carrier == 10 )
															$colspan = 6;

														// Get the entire report
														$data_value = $modelo->chargedbyservicereport_PEC($modelo->getIdPEC(), $service_id);

														// Run through service list
														foreach ( $data_value as $i => $value )
														{
															$c = $i;

															if ( $value["LINHA"] != $current_number )
															{
																// Init row
																echo "<tr>";

																// Acesso
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["LINHA"] . "'><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/chargedbyservicereport_pec?idPEC=") . encrypted_url($value["ID_SERVICO"], "?idServico=") . "' title='" . $value["LINHA"] . "'>" . $value["LINHA"] . "</a></td>";
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Radio ID
																if ( $carrier == 10 ) // Just to Nextel carrier
																{
																	if ( isset($value["ID_RADIO"]) && $value["ID_RADIO"] != "" && strpos($value["ID_RADIO"], "-") === false )
																		echo "<td style='text-align: center;' title='" . $value["ID_RADIO"] . "'>" . $value["ID_RADIO"] . "</td>";
																	else
																		echo "<td style='text-align: center;'>-</td>";
																}

																// Income period
																echo "<td style='text-align: center; width: 20%;' title='" . $value["PERIODO"] . "'>" . $value["PERIODO"];
																while ( isset($data_value[($i+1)][4]) && ($data_value[$i][4] == $data_value[($i+1)][4]) ) 
																{
																	echo "</br>" . $data_value[($i+1)][5];
																	$i += 1;
																}
																echo "</td>";

																// Minutes
																if ( isset($value["MINUTOS"]) && $value["MINUTOS"] != "" )
																	echo "<td style='text-align: center; width: 20%;' title='" . $value["MINUTOS"] . "'>" . $value["MINUTOS"] . "</td>";
																else
																	echo "<td style='text-align: center;'>-</td>";

																// Value
																echo "<td style='text-align: center; width: 20%;' title='" . $value["VALOR"] . "'>" . $value["VALOR"];
																$subtotal = str_replace(',', '.', $value["VALOR"]);

																while ( isset($data_value[($c+1)][4]) && ($data_value[$c][4] == $data_value[($c+1)][4]) )
																{
																	echo "</br>" . $data_value[($c+1)][6];
																	$subtotal = real_sum($subtotal, $data_value[($c+1)][6]);
																	$c += 1;
																}
																echo "</td>";

																// Total value
																echo "<td style='text-align: center; width: 20%;' title='" . real_currency($subtotal) . "'>" . real_currency($subtotal) . "</td>";

																// Total sum
																$total_value = real_sum($total_value, $subtotal);

																// End content
																echo "</tr>";
															}

															$current_number = $value["LINHA"];
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan - 1; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
														<td id="foot_total" style="text-align: right;"><h4>Subtotal: R$ <?php echo real_currency($total_value); ?></h4></td>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											</table>
										</div>
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