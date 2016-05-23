							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Detalhamento por registro">Detalhamento por registro <small>relatório </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Check if PEC ID is valid
						$modelo->checkValidit_PEC();

						// Check if service ID is valid
						if (isset($_GET['idUtilizacao']) && $_GET['idUtilizacao'] != '')
						{
							$utilization_id = decrypted_url($_GET['idUtilizacao'] , "**");
						}
						else
						{
							?><script>alert("Houve um problema com o identificador da utilização. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/detailreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Check calling type ID is valid
						if (isset($_GET['idTipoLigacao']) && $_GET['idTipoLigacao'] != '')
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

						// Check chamada type ID is valid
						if (isset($_GET['idTipoChamada']) && $_GET['idTipoChamada'] != '')
						{
							$chamada_id = decrypted_url($_GET['idTipoChamada'] , "**");
							$chamada_name = $modelo->get_chamada_pec($chamada_id);
						}
						else
						{
							?><script>alert("Houve um problema com o identificador do tipo de chamada. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/detailreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Get carrier ID
						$carrier = $modelo->get_carrier_pec($modelo->getIdPEC());

						// Get the detail type
						$detail_type = $modelo->get_detail_type_pec($modelo->getIdPEC(), $calling_id, $chamada_id, $utilization_id);
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
												<?php
													// Remove NOT DEFINED values
													if ( $chamada_name != "NÃO DEFINIDA" )
														echo "<h4 title='" . $calling_name . " ( " . $chamada_name . " )'>" . $calling_name . " ( " . $chamada_name . " )</h4>";
													else
														echo "<h4 title='" . $calling_name . "'>" . $calling_name . "</h4>";
												?>
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
										// Auxiliary variable
										$total_value = 0;
										$total_value2 = 0;
										$total_interconnection = 0;
										$total_tax = 0;
										$total_qtd = 0;
										$total_qtdI = 0;
										$total_qtdU = 0;
										$total_qtdE = 0;
										$total_time = 0;
										$total_time2 = 0;
										$total_time3 = 0;
										$total_traffic = 0;
										$total_trafficI = 0;
										$total_trafficU = 0;
										$total_trafficE = 0;
										$subtotal_traffic = 0;
										$show_minutes = 0;
										$count = 0;

										// Get the entire report
										$data_value = $modelo->detailedreportbyregister_PEC($modelo->getIdPEC(), $calling_id, $chamada_id, $utilization_id);
									?>

									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="sample_1">
											<?php if ( $detail_type != 1 ) { // DETALHAMENTO ?>
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;">ACESSO</th>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<th style="white-space: nowrap; text-align: center;">RÁDIO</th>
														<?php } ?>
														<?php if ( $carrier == 1 ) { // CLARO ?>
															<th style="white-space: nowrap; text-align: center;">SERVIÇO</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center;">CSP</th>
														<th style="white-space: nowrap; text-align: center;">DATA</th>
														<th style="white-space: nowrap; text-align: center;">HORA</th>
														<th style="white-space: nowrap; text-align: center;">LOCALIDADE</th>
														<th style="white-space: nowrap; text-align: center;">NÚMERO</th>
														<th style="white-space: nowrap; text-align: center;">TARIFA</th>
														<th style="white-space: nowrap; text-align: center;">DURAÇÃO</th>
														<th style="white-space: nowrap; text-align: center;">TIPO</th>
														<th style="white-space: nowrap; text-align: center;">QUANTIDADE</th>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<th style="white-space: nowrap; text-align: center;">INTERCONEXÃO</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center;">VALOR (R$)</th>
														<?php if ( $carrier == 1 ) { // CLARO ?>
															<th style="white-space: nowrap; text-align: center;">VALOR COBRADO (R$)</th>
														<?php } ?>
													</tr>
												</thead>
												<tbody>
													<?php
														// Run through service list
														$total_elements = count($data_value);
														foreach ( $data_value as $value )
														{
															// Init row
															echo "<tr>";

															// Acesso
															if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																echo "<td style='text-align: left; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
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

															// Service
															if ( $carrier == 1 ) // Just to Claro carrier
															{
																if ( isset($value["SERVICO"]) && $value["SERVICO"] != "" )
																	echo "<td style='text-align: left;' title='" . $value["SERVICO"] . "' >" . $value["SERVICO"] . "</td>";
																else
																{
																	echo "<td style='text-align: center;'> - </td>";
																}
															}
															
															// CSP
															if ( isset($value["CSP"]) && $value["CSP"] != "" && $value["CSP"] != 0 )
																echo "<td style='text-align: center;' title='" . $value["CSP"] . "' >" . $value["CSP"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Date
															if ( isset($value["DATA"]) && $value["DATA"] != "" )
																echo "<td style='text-align: center;' title='" . $value["DATA"] . "' >" . $value["DATA"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Time
															if ( isset($value["HORA"]) && $value["HORA"] != "" )
																echo "<td style='text-align: center;' title='" . $value["HORA"] . "' >" . $value["HORA"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Location
															if ( isset($value["ORIGEM"]) && $value["ORIGEM"] != "" )
																echo "<td style='text-align: center;' title='" . $value["ORIGEM"] . "' >" . $value["ORIGEM"] . "</td>";
															else
															{
																if ( isset($value["PAIS_OPERADORA"]) && $value["PAIS_OPERADORA"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["PAIS_OPERADORA"] . "' >" . $value["PAIS_OPERADORA"] . "</td>";
																else if ( isset($value["ORIGEM_DESTINO"]) && $value["ORIGEM_DESTINO"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["ORIGEM_DESTINO"] . "' >" . $value["ORIGEM_DESTINO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";
															}

															// Phone Number
															if ( isset($value["N_CHAMADO"]) && $value["N_CHAMADO"] != "" )
																echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["N_CHAMADO"] . "' >" . $value["N_CHAMADO"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Taxes
															if ( isset($value["TARIFA"]) && $value["TARIFA"] != "" )
															{
																echo "<td style='text-align: center;' title='" . str_replace(",", ".", $value["TARIFA"]) . "'>" . str_replace(",", ".", $value["TARIFA"]) . "</td>";

																// Total sum
																$total_tax = real_sum($total_tax, str_replace(",", ".", $value["TARIFA"]));
															}
															else
															{
																echo "<td style='text-align: center;'>-</td>";
															}

															// Duration
															if ( isset($value["DURACAO"]) && $value["DURACAO"] != "" )
															{
																// Check the time format (hh:mm:ss)
																if ( strlen($value["DURACAO"]) == 8 )
																{
																	echo "<td style='text-align: center;' title='" . format_mm_ss(format_hh_mm_ss($value["DURACAO"])) . "'>" . format_mm_ss(format_hh_mm_ss($value["DURACAO"])) . "</td>";
																	$value["DURACAO"] = format_mm_ss(format_hh_mm_ss($value["DURACAO"]));
																}
																else
																{
																	echo "<td style='text-align: center;' title='" . $value["DURACAO"] . "'>" . $value["DURACAO"] . "</td>";
																}

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
															else
															{
																echo "<td style='text-align: center;'>-</td>";
															}

															// Type
															if ( isset($value["TIPO"]) && $value["TIPO"] != "" )
																echo "<td style='text-align: center;' title='" . $value["TIPO"] . "' >" . $value["TIPO"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Check the service type
															switch ( $value["ID_TIPO_DET"] )
															{
																// ---------------------------------------------------------------------------
																case 1: // NOT DEFINED
																// ---------------------------------------------------------------------------

																	// Quantity
																	if ( isset($value["QUANTIDADE"]) && $value["QUANTIDADE"] != "" && $value["QUANTIDADE"] != 0 )
																	{
																		echo "<td style='text-align: center;' title='" . $value["QUANTIDADE"] . "'>" . $value["QUANTIDADE"] . "</td>";

																		// Total quantity
																		$total_qtd = real_sum($total_qtd, str_replace(",", ".", $value["QUANTIDADE"]));
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	break;

																// ---------------------------------------------------------------------------
																case 2: // VOICE
																// ---------------------------------------------------------------------------

																	// Quantity
																	if ( isset($value["QUANTIDADE"]) && $value["QUANTIDADE"] != "" && $value["QUANTIDADE"] != 0 )
																	{
																		echo "<td style='text-align: center;' title='" . $value["QUANTIDADE"] . "'>" . $value["QUANTIDADE"] . "</td>";

																		// Total quantity
																		$total_qtd = real_sum($total_qtd, str_replace(",", ".", $value["QUANTIDADE"]));
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	break;

																// ---------------------------------------------------------------------------
																case 3: // DATA
																// ---------------------------------------------------------------------------

																	// Quantity
																	$traffic_list = $modelo->get_traffic_list2($modelo->getIdPEC(), iif($value["ID_PEC_DET"]));

																	// Run through service list
																	$aux_traffic = "";
																	foreach ( $traffic_list as $tf_list )
																	{
																		$aux_traffic = preg_replace("/MB+\s+/", ",", $tf_list["QUANTIDADE"]);
																		$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																		$aux_traffic = str_replace(",", ".", $aux_traffic);
																		$subtotal_traffic = real_sum($subtotal_traffic, ($aux_traffic));
																	}

																	echo "<td style='text-align: center;' title='" . formatMbKb($subtotal_traffic) . "'>" . formatMbKb($subtotal_traffic) . "</td>";
																	$total_traffic = real_sum($total_traffic, $subtotal_traffic);

																	break;

																// ---------------------------------------------------------------------------
																case 4: // SMS
																// ---------------------------------------------------------------------------

																	// Quantity
																	if ( isset($value["QUANTIDADE"]) && $value["QUANTIDADE"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["QUANTIDADE"] . "'>" . $value["QUANTIDADE"] . "</td>";

																		// Total quantity
																		if ( strpos($value["QUANTIDADE"], ",") !== false )
																		{
																			// Format string value
																			$value["QUANTIDADE"] = preg_replace('/\./', '', $value["QUANTIDADE"], 1);
																			$value["QUANTIDADE"] = str_replace(",", ".", $value["QUANTIDADE"]);

																			// Total quantity																		
																			$total_qtd = real_sum($total_qtd, $value["QUANTIDADE"]);

																			// Check if it's the last loop
																			if( $count === ($total_elements - 1) )
																				$total_qtd = formatMbKb($total_qtd);
																		}
																		else if ( strpos($value["QUANTIDADE"], "m") === false )
																		{
																			$total_qtd = real_sum($total_qtd, str_replace(",", ".", $value["QUANTIDADE"]));
																		}
																		else
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time2 = min_sec_sum($total_time2, format_min_sec($value["QUANTIDADE"]));
																			else
																				$total_time2 = format_min_sec($value["QUANTIDADE"]);
																			$total_time2 = str_replace(".", "", $total_time2);
																		}
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	break;
															}

															// Interconnection
															if ( $carrier == 10 ) // Just to Nextel carrier
															{
																if ( isset($value["INTERCONEXAO"]) && $value["INTERCONEXAO"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["INTERCONEXAO"] . "'>" . $value["INTERCONEXAO"] . "</td>";
																else
																	echo "<td style='text-align: center;'>-</td>";

																// Total interconnection
																$total_interconnection = real_sum($total_interconnection, str_replace(",", ".", $value["INTERCONEXAO"]));
															}

															// Total value
															if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
															{
																$value["VALOR"] = str_replace(":", ",", $value["VALOR"]);
																
																if ( strpos($value["VALOR"], ".") === false )
																	echo "<td style='text-align: center;' title='" . real_currency(str_replace(",", ".", $value["VALOR"])) . "'>" . real_currency(str_replace(",", ".", $value["VALOR"])) . "</td>";
																else
																	echo "<td style='text-align: center;' title='" . $value["VALOR"] . "'>" . $value["VALOR"] . "</td>";

																// Total sum
																$total_value = real_sum($total_value, str_replace(",", ".", $value["VALOR"]));
															}
															else
															{
																echo "<td style='text-align: center;'>-</td>";
															}

															// Charged value
															if ( $carrier == 1 ) // Just to Claro carrier
															{
																if ( isset($value["VALOR_COBRADO"]) && $value["VALOR_COBRADO"] != "" )
																{
																	echo "<td style='text-align: center;' title='" . real_currency(str_replace(",", ".", $value["VALOR_COBRADO"])) . "'>" . real_currency(str_replace(",", ".", $value["VALOR_COBRADO"])) . "</td>";

																	// Total sum
																	$total_value2 = real_sum($total_value2, str_replace(",", ".", $value["VALOR_COBRADO"]));
																}
																else
																{
																	echo "<td style='text-align: center;'>-</td>";
																}
															}

															// End content
															echo "</tr>";
															$count += 1;
															$subtotal_traffic = 0;
														}

														// Format the time (if necessary)
														if ( $total_time == "00:00" || $total_time == "0:00" )
															$total_time = "0:00";

														if ( $total_time2 == "00:00" || $total_time2 == "0:00" )
															$total_time2 = "0:00";
													?>
												</tbody>
												<tfoot>
													<tr>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<td colspan="7" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } else if ( $carrier == 1 ) { // CLARO ?>
															<td colspan="7" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } else { ?>
															<td colspan="6" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } ?>
														<td style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_tax); ?></h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4><?php formatMbKb($total_traffic); if ( $show_minutes == 0 ) echo str_replace(".", "", format_mm_ss($total_time)); else echo format_mm_ss($total_time); ?></h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4>-</h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4>
														<?php
															// Check which information is necessary to print 
															if ( $total_qtd != 0 && $total_time2 != "0:00" && $total_traffic != 0 ) // Numeric total + time + traffic
																echo $total_qtd . " / " . $total_time2 . " / " . formatMbKb($total_traffic);
															else if ( $total_qtd != 0 && $total_time2 != "0:00" ) // Numeric total + time 
																echo $total_qtd . " / " . $total_time2;
															else if ( $total_qtd != 0 ) // Numeric total
																echo $total_qtd;
															else if ( $total_traffic != 0 ) // Traffic
																echo formatMbKb($total_traffic);
															else if ( $total_time2 != "0:00" ) // MM:SS time
																echo format_mm_ss($total_time2);
															else
																echo "-";
														?>
														</h4></td>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<td style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_interconnection); ?></h4></td>
														<?php } ?>
														<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value); ?></h4></td>
														<?php if ( $carrier == 1 ) { // CLARO ?>
															<td style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value2); ?></h4></td>
														<?php } ?>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											<?php } else if ( $detail_type == 1 ) { // SUBTOTAL ?>
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;">ACESSO</th>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<th style="white-space: nowrap; text-align: center;">RÁDIO</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center;">DESCRITIVO</th>
														<th style="white-space: nowrap; text-align: center;">INCLUSO</th>
														<th style="white-space: nowrap; text-align: center;">UTILIZADO</th>
														<th style="white-space: nowrap; text-align: center;">EXCEDENTE</th>
														<th style="white-space: nowrap; text-align: center;">VALOR (R$)</th>
														<?php if ( $carrier == 1 ) { // Claro ?>
															<th style="white-space: nowrap; text-align: center;">VALOR COBRADO (R$)</th>
														<?php } ?>
													</tr>
												</thead>
												<tbody>
													<?php
														// Run through service list
														$total_elements = count($data_value);
														foreach ( $data_value as $value )
														{
															// Init row
															echo "<tr>";

															// Acesso
															if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																echo "<td style='text-align: left; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
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

															// Description
															if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																echo "<td style='text-align: left;' title='" . $value["DESCRITIVO"] . "' >" . $value["DESCRITIVO"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Check the service type
															switch ( $value["ID_TIPO_DET"] )
															{
																// ---------------------------------------------------------------------------
																case 1: // NOT DEFINED
																// ---------------------------------------------------------------------------

																	// Quantity
																	if ( isset($value["QUANTIDADE"]) && $value["QUANTIDADE"] != "" && $value["QUANTIDADE"] != 0 )
																	{
																		echo "<td style='text-align: center;' title='" . $value["QUANTIDADE"] . "'>" . $value["QUANTIDADE"] . "</td>";

																		// Total quantity
																		$total_qtd = real_sum($total_qtd, str_replace(",", ".", $value["QUANTIDADE"]));
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	break;

																// ---------------------------------------------------------------------------
																case 2: // VOICE
																// ---------------------------------------------------------------------------

																	// Included
																	if ( isset($value["INCLUSO"]) && $value["INCLUSO"] != "" && $value["INCLUSO"] != "0:00" )
																	{
																		if ( $value["INCLUSO"] == "00:00" )
																		{
																			echo "<td style='text-align: center;'>-</td>";
																		}
																		else
																		{
																			$value["INCLUSO"] = format_mm_ss($value["INCLUSO"]);
																			echo "<td style='text-align: center;' title='" . $value["INCLUSO"] . "'>" . $value["INCLUSO"] . "</td>";
																		}

																		if ( strpos($value["INCLUSO"], "m") === false )
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time = min_sec_sum($total_time, $value["INCLUSO"]);
																			else
																				$total_time = $value["INCLUSO"];
																		}
																		else
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time = min_sec_sum($total_time, format_min_sec($value["INCLUSO"]));
																			else
																				$total_time = format_min_sec($value["INCLUSO"]);
																		}
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>-</td>";
																	}

																	// Used
																	if ( isset($value["UTILIZADO"]) && $value["UTILIZADO"] != "" && $value["UTILIZADO"] != "0:00" )
																	{
																		if ( $value["UTILIZADO"] == "00:00" )
																		{
																			echo "<td style='text-align: center;'>-</td>";
																		}
																		else
																		{
																			$value["UTILIZADO"] = format_mm_ss($value["UTILIZADO"]);
																			echo "<td style='text-align: center;' title='" . $value["UTILIZADO"] . "'>" . $value["UTILIZADO"] . "</td>";
																		}

																		if ( strpos($value["UTILIZADO"], "m") === false )
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time2 = min_sec_sum($total_time2, $value["UTILIZADO"]);
																			else
																				$total_time2 = $value["UTILIZADO"];
																		}
																		else
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time2 = min_sec_sum($total_time2, format_min_sec($value["UTILIZADO"]));
																			else
																				$total_time2 = format_min_sec($value["UTILIZADO"]);
																			$total_time2 = str_replace(".", "", $total_time2);
																		}
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>-</td>";
																	}

																	// Excess
																	if ( isset($value["EXCEDENTE"]) && $value["EXCEDENTE"] != "" && $value["EXCEDENTE"] != "0:00" )
																	{
																		if ( $value["EXCEDENTE"] == "00:00" )
																		{
																			echo "<td style='text-align: center;'>-</td>";
																		}
																		else
																		{
																			$value["EXCEDENTE"] = format_mm_ss($value["EXCEDENTE"]);
																			echo "<td style='text-align: center;' title='" . $value["EXCEDENTE"] . "'>" . $value["EXCEDENTE"] . "</td>";
																		}
																		
																		if ( strpos($value["EXCEDENTE"], "m") === false )
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time3 = min_sec_sum($total_time3, $value["EXCEDENTE"]);
																			else
																				$total_time3 = $value["EXCEDENTE"];
																		}
																		else
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time3 = min_sec_sum($total_time3, format_min_sec($value["EXCEDENTE"]));
																			else
																				$total_time3 = format_min_sec($value["EXCEDENTE"]);
																			$total_time3 = str_replace(".", "", $total_time3);
																		}
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>-</td>";
																	}

																	break;

																// ---------------------------------------------------------------------------
																case 3: // DATA
																// ---------------------------------------------------------------------------

																	// Included
																	if ( isset($value["INCLUSO"]) && $value["INCLUSO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["INCLUSO"] . "'>" . $value["INCLUSO"] . "</td>";

																		// Total traffic
																		$aux_traffic = "";
																		$subtotal_traffic = 0;
																		$aux_traffic = str_replace(".", "", $value["INCLUSO"]);
																		$aux_traffic = preg_replace("/MB+\s+/", ",", $value["INCLUSO"]);
																		$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																		$aux_traffic = str_replace(".", "", $aux_traffic);
																		$aux_traffic = str_replace(",", ".", $aux_traffic);
																		$subtotal_traffic = real_sum($subtotal_traffic, $aux_traffic);
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	$total_trafficI = real_sum($total_trafficI, $subtotal_traffic);

																	// Used
																	if ( isset($value["UTILIZADO"]) && $value["UTILIZADO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["UTILIZADO"] . "'>" . $value["UTILIZADO"] . "</td>";

																		// Total traffic
																		$aux_traffic = "";
																		$subtotal_traffic = 0;
																		$aux_traffic = str_replace(".", "", $value["UTILIZADO"]);
																		$aux_traffic = preg_replace("/MB+\s+/", ",", $value["UTILIZADO"]);
																		$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																		$aux_traffic = str_replace(".", "", $aux_traffic);
																		$aux_traffic = str_replace(",", ".", $aux_traffic);
																		$subtotal_traffic = real_sum($subtotal_traffic, $aux_traffic);
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	$total_trafficU = real_sum($total_trafficU, $subtotal_traffic);
																	
																	// Excess
																	if ( isset($value["EXCEDENTE"]) && $value["EXCEDENTE"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["EXCEDENTE"] . "'>" . $value["EXCEDENTE"] . "</td>";

																		// Total traffic
																		$aux_traffic = "";
																		$subtotal_traffic = 0;
																		$aux_traffic = str_replace(".", "", $value["EXCEDENTE"]);
																		$aux_traffic = preg_replace("/MB+\s+/", ",", $value["EXCEDENTE"]);
																		$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																		$aux_traffic = str_replace(".", "", $aux_traffic);
																		$aux_traffic = str_replace(",", ".", $aux_traffic);
																		$subtotal_traffic = real_sum($subtotal_traffic, $aux_traffic);
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	$total_trafficE = real_sum($total_trafficE, $subtotal_traffic);

																	break;

																// ---------------------------------------------------------------------------
																case 4: // SMS
																// ---------------------------------------------------------------------------

																	// Included
																	if ( isset($value["INCLUSO"]) && $value["INCLUSO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["INCLUSO"] . "'>" . $value["INCLUSO"] . "</td>";

																		// Total quantity
																		if ( strpos($value["INCLUSO"], ",") !== false )
																		{
																			// Format string value
																			$value["INCLUSO"] = preg_replace('/\./', '', $value["INCLUSO"], 1);
																			$value["INCLUSO"] = str_replace(",", ".", $value["INCLUSO"]);

																			// Total quantity																		
																			$total_qtdI = real_sum($total_qtdI, $value["INCLUSO"]);

																			// Check if it's the last loop
																			if( $count === ($total_elements - 1) )
																				$total_qtdI = formatMbKb($total_qtdI);
																		}
																		else if ( strpos($value["INCLUSO"], "m") === false )
																		{
																			$total_qtdI = real_sum($total_qtdI, str_replace(",", ".", $value["INCLUSO"]));
																		}
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";
																	
																	// Used
																	if ( isset($value["UTILIZADO"]) && $value["UTILIZADO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["UTILIZADO"] . "'>" . $value["UTILIZADO"] . "</td>";

																		// Total quantity
																		if ( strpos($value["UTILIZADO"], ",") !== false )
																		{
																			// Format string value
																			$value["UTILIZADO"] = preg_replace('/\./', '', $value["UTILIZADO"], 1);
																			$value["UTILIZADO"] = str_replace(",", ".", $value["UTILIZADO"]);

																			// Total quantity																		
																			$total_qtdU = real_sum($total_qtdU, $value["UTILIZADO"]);

																			// Check if it's the last loop
																			if( $count === ($total_elements - 1) )
																				$total_qtdU = formatMbKb($total_qtdU);
																		}
																		else if ( strpos($value["UTILIZADO"], "m") === false )
																		{
																			$total_qtdU = real_sum($total_qtdU, str_replace(",", ".", $value["UTILIZADO"]));
																		}
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";
																	
																	// Excess
																	if ( isset($value["EXCEDENTE"]) && $value["EXCEDENTE"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["EXCEDENTE"] . "'>" . $value["EXCEDENTE"] . "</td>";

																		// Total quantity
																		if ( strpos($value["EXCEDENTE"], ",") !== false )
																		{
																			// Format string value
																			$value["EXCEDENTE"] = preg_replace('/\./', '', $value["EXCEDENTE"], 1);
																			$value["EXCEDENTE"] = str_replace(",", ".", $value["EXCEDENTE"]);

																			// Total quantity																		
																			$total_qtdE = real_sum($total_qtdE, $value["EXCEDENTE"]);

																			// Check if it's the last loop
																			if( $count === ($total_elements - 1) )
																				$total_qtdE = formatMbKb($total_qtdE);
																		}
																		else if ( strpos($value["EXCEDENTE"], "m") === false )
																		{
																			$total_qtdE = real_sum($total_qtdE, str_replace(",", ".", $value["EXCEDENTE"]));
																		}
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	break;
															}

															// Total value
															if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
															{
																$value["VALOR"] = str_replace(":", ",", $value["VALOR"]);
																echo "<td style='text-align: center;' title='" . real_currency(str_replace(",", ".", $value["VALOR"])) . "'>" . real_currency(str_replace(",", ".", $value["VALOR"])) . "</td>";

																// Total sum
																$total_value = real_sum($total_value, str_replace(",", ".", $value["VALOR"]));
															}
															else
															{
																echo "<td style='text-align: center;'>-</td>";
															}

															// Charged value
															if ( $carrier == 1 ) // Just to Claro carrier
															{
																if ( isset($value["VALOR_COBRADO"]) && $value["VALOR_COBRADO"] != "" )
																{
																	echo "<td style='text-align: center;' title='" . real_currency(str_replace(",", ".", $value["VALOR_COBRADO"])) . "'>" . real_currency(str_replace(",", ".", $value["VALOR_COBRADO"])) . "</td>";

																	// Total sum
																	$total_value2 = real_sum($total_value2, str_replace(",", ".", $value["VALOR_COBRADO"]));
																}
																else
																{
																	echo "<td style='text-align: center;'>-</td>";
																}
															}

															// End content
															echo "</tr>";
															$count += 1;
															$subtotal_traffic = 0;
														}

														// Format the time (if necessary)
														if ( $total_time == "00:00" || $total_time == "0:00" )
															$total_time = "0:00";

														if ( $total_time2 == "00:00" || $total_time2 == "0:00" )
															$total_time2 = "0:00";
														
														if ( $total_time3 == "00:00" || $total_time3 == "0:00" )
															$total_time3 = "0:00";
													?>
												</tbody>
												<tfoot>
													<tr>
														<?php if ( $carrier == 10 ) { // Nextel ?>
															<td colspan="3" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } else { ?>
															<td colspan="2" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } ?>
														<td style="text-align: center; white-space: nowrap;"><h4>
														<?php
															// Check which information is necessary to print 
															if ( $total_qtdI != 0 && $total_time != "0:00" && $total_trafficI != 0 ) // Numeric total + time + traffic
																echo $total_qtdI . " / " . $total_time . " / " . formatMbKb($total_trafficI);
															else if ( $total_qtdI != 0 && $total_time != "0:00" ) // Numeric total + time 
																echo $total_qtdI . " / " . $total_time;
															else if ( $total_qtdI != 0 ) // Numeric total
																echo $total_qtdI;
															else if ( $total_trafficI != 0 ) // Traffic
																echo formatMbKb($total_trafficI);
															else if ( $total_time != "0:00" ) // MM:SS time
																echo format_mm_ss($total_time);
															else
																echo "-";
														?>
														</h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4>
														<?php
															// Check which information is necessary to print 
															if ( $total_qtdU != 0 && $total_time2 != "0:00" && $total_trafficU != 0 ) // Numeric total + time + traffic
																echo $total_qtdU . " / " . $total_time2 . " / " . formatMbKb($total_trafficU);
															else if ( $total_qtdU != 0 && $total_time2 != "0:00" ) // Numeric total + time 
																echo $total_qtdU . " / " . $total_time2;
															else if ( $total_qtdU != 0 ) // Numeric total
																echo $total_qtdU;
															else if ( $total_trafficU != 0 ) // Traffic
																echo formatMbKb($total_trafficU);
															else if ( $total_time2 != "0:00" ) // MM:SS time
																echo format_mm_ss($total_time2);
															else
																echo "-";
														?>
														</h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4>
														<?php
															// Check which information is necessary to print 
															if ( $total_qtdE != 0 && $total_time3 != "0:00" && $total_trafficE != 0 ) // Numeric total + time + traffic
																echo $total_qtdE . " / " . $total_time3 . " / " . formatMbKb($total_trafficE);
															else if ( $total_qtdE != 0 && $total_time3 != "0:00" ) // Numeric total + time 
																echo $total_qtdE . " / " . $total_time3;
															else if ( $total_qtdE != 0 ) // Numeric total
																echo $total_qtdE;
															else if ( $total_trafficE != 0 ) // Traffic
																echo formatMbKb($total_trafficE);
															else if ( $total_time3 != "0:00" ) // MM:SS time
																echo format_mm_ss($total_time3);
															else
																echo "-";
														?>
														</h4></td>
														<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value); ?></h4></td>
														<?php if ( $carrier == 1 ) { // Claro ?>
															<td style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value2); ?></h4></td>
														<?php } ?>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											<?php } ?>
										</table>
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