							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Detalhamento por utilização">Detalhamento por utilização <small>relatório </small></h1>
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
							$utilization_name = $modelo->get_utiilization_pec($utilization_id);
						}
						else
						{
							?><script>alert("Houve um problema com o identificador da utilização. Por favor, tente novamente.");
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
												<?php echo "<h4 title='" . $utilization_name . "'>" . $utilization_name . "</h4>"; ?>
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

									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="sample_1">
											<thead>
												<tr>
													<th style="white-space: nowrap; text-align: center;">TIPO DE CHAMADA</th>
													<th style="white-space: nowrap; text-align: center;">DURAÇÃO TOTAL</th>
													<th style="white-space: nowrap; text-align: center;">QUANTIDADE (SMS)</th>
													<th style="white-space: nowrap; text-align: center;">TRÁFEGO</th>
													<th style="white-space: nowrap; text-align: center;">VALOR TOTAL (R$)</th>
												</tr>
											</thead>
											<tbody>
												<?php
													// Auxiliary variable
													$total_value = 0;
													$subtotal_value = 0;
													$total_qtd = 0;
													$total_time = 0;
													$total_traffic = 0;
													$subtotal_traffic = 0;
													$count = 0;

													// Get the entire report
													$data_value = $modelo->detailedutilizationreport_PEC($modelo->getIdPEC(), $utilization_id);

													// Run through service list
													foreach ( $data_value as $value )
													{
														// Init row
														echo "<tr>";

														// Upper-case
														$value["DESC_LIGACAO"] = mb_strtoupper($value["DESC_LIGACAO"], 'UTF-8');

														// Remove part from service description
														/*if ( strpos($value["DESC_LIGACAO"], "LONGA") !== false )
														{
															$aux_desc = explode("LONGA", $value["DESC_LIGACAO"]); 
															$value["DESC_LIGACAO"] = $aux_desc[0] . " LONGA DISTÂNCIA";
														}*/

														// Service description
														echo "<td><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/detailreportbyregister_pec?idPEC=") . 
															encrypted_url($utilization_id, "&idUtilizacao=") . encrypted_url($value["ID_PEC_TIPO_LIGACAO"], "&idTipoLigacao=") . 
															encrypted_url($value["ID_PEC_TIPO_CHAMADA"], "&idTipoChamada=") . "' title='" . $value["DESC_LIGACAO"] . "'>" . 
															$value["DESC_LIGACAO"];

														// Calling description
														if ( $value["DESC_CHAMADA"] != "NÃO DEFINIDA" )
															echo " ( " . $value["DESC_CHAMADA"] . " )";

														echo "</td>";
														
														// Check the service type
														switch ( $value["ID_TIPO_DET"] )
														{
															// ---------------------------------------------------------------------------
															case 1: // NOT DEFINED
															// ---------------------------------------------------------------------------

																// Duration
																echo "<td style='text-align: center;'>-</td>";

																// Quantity
																echo "<td style='text-align: center;'>-</td>";

																// Traffic
																echo "<td style='text-align: center;'>-</td>";

																break;
																
															// ---------------------------------------------------------------------------
															case 2: // VOICE
															// ---------------------------------------------------------------------------

																// Duration
																$aux_duration_value = "";
																$duration_list = $modelo->get_duration_list($modelo->getIdPEC(), iif($value["ID_PEC_TIPO_LIGACAO"]), iif($value["ID_PEC_TIPO_CHAMADA"]), iif($value["ID_TIPO_UTILIZACAO"]));

																// Run through service list
																$aux_duration = 0;
																foreach ( $duration_list as $df_list )
																{
																	//! Set the duration auxiliar variable
																	if ( isset($df_list["UTILIZADO"]) && $df_list["UTILIZADO"] != "" )
																		$aux_duration_value = $df_list["UTILIZADO"];
																	else
																		$aux_duration_value = $df_list["DURACAO"];

																	// Check the time type
																	if ( strpos($aux_duration_value, "m") === false )
																	{
																		// Subtotal duration
																		$aux_duration = min_sec_sum($aux_duration, $aux_duration_value);
																	}
																	else
																	{
																		// Subtotal duration
																		$aux_duration = min_sec_sum($aux_duration, format_min_sec($aux_duration_value));
																	}
																}
																echo "<td style='text-align: center;' title='" . format_mm_ss($aux_duration) . "'>" . format_mm_ss($aux_duration) . "</td>";
																$total_time = min_sec_sum($total_time, $aux_duration);

																// Quantity
																echo "<td style='text-align: center;'>-</td>";

																// Traffic
																echo "<td style='text-align: center;'>-</td>";

																break;

															// ---------------------------------------------------------------------------
															case 3: // DATA
															// ---------------------------------------------------------------------------

																// Duration
																echo "<td style='text-align: center;'>-</td>";

																// Quantity
																echo "<td style='text-align: center;'>-</td>";

																// Traffic
																$traffic_list = $modelo->get_traffic_list($modelo->getIdPEC(), iif($value["ID_PEC_TIPO_CHAMADA"]), iif($value["ID_TIPO_DET"]), iif($value["ID_TIPO_UTILIZACAO"]));

																// Run through service list
																$aux_traffic = "";
																$aux_traffic_value = "";
																foreach ( $traffic_list as $tf_list )
																{
																	if ( isset($tf_list["QUANTIDADE"]) && $tf_list["QUANTIDADE"] != "" )
																		$aux_traffic_value = $tf_list["QUANTIDADE"];
																	else
																		$aux_traffic_value = $tf_list["UTILIZADO"];

																	$aux_traffic = str_replace(".", "", $aux_traffic_value);
																	$aux_traffic = preg_replace("/MB+\s+/", ",", $aux_traffic_value);
																	$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																	$aux_traffic = str_replace(".", "", $aux_traffic);
																	$aux_traffic = str_replace(",", ".", $aux_traffic);
																	$subtotal_traffic = real_sum($subtotal_traffic, $aux_traffic);
																}
																echo "<td style='text-align: center;' title='" . formatMbKb($subtotal_traffic) . "'>" . formatMbKb($subtotal_traffic) . "</td>";
																$total_traffic = real_sum($total_traffic, $subtotal_traffic);

																break;
																
															// ---------------------------------------------------------------------------
															case 4: // SMS
															// ---------------------------------------------------------------------------

																// Duration
																echo "<td style='text-align: center;'>-</td>";

																// Quantity
																$sms_count = $modelo->get_sms_count($modelo->getIdPEC(), iif($value["ID_PEC_TIPO_LIGACAO"]), iif($value["ID_PEC_TIPO_CHAMADA"]), iif($value["ID_TIPO_UTILIZACAO"]));

																echo "<td style='text-align: center;' title='" . $sms_count . "'>" . $sms_count . "</td>";

																// Total quantity
																$total_qtd = real_sum($total_qtd, $sms_count);

																// Traffic
																echo "<td style='text-align: center;'>-</td>";

																break;
														}

														// Value list
														$value_list = $modelo->get_value_list($modelo->getIdPEC(), iif($value["ID_PEC_TIPO_LIGACAO"]), iif($value["ID_PEC_TIPO_CHAMADA"]), iif($value["ID_TIPO_UTILIZACAO"]));

														// Run through value list
														$aux_value = 0;
														foreach ( $value_list as $vl_list )
														{
															// Check if the value column exists and the carrier is different from CLARO
															if ( $vl_list["VALOR"] != "" && ($carrier != 1 || $vl_list["VALOR_COBRADO"] == "") ) 
															{
																$aux_value = str_replace(",", ".", $vl_list["VALOR"]);
																$subtotal_value = real_sum($subtotal_value, $aux_value);

																// If the carrier is NEXTEL, check if the column INTERCONEXAO exists
																if ( $carrier == 10 && $vl_list["INTERCONEXAO"] != "" )
																{
																	$aux_value = str_replace(",", ".", $vl_list["INTERCONEXAO"]);
																	$subtotal_value = real_sum($subtotal_value, $aux_value);
																}
															}
															else if ( $vl_list["VALOR_COBRADO"] != "" )
															{
																$aux_value = str_replace(",", ".", $vl_list["VALOR_COBRADO"]);
																$subtotal_value = real_sum($subtotal_value, $aux_value);
															}
														}

														if ( isset($subtotal_value) )
														{
															echo "<td style='text-align: center;' title='" . real_currency($subtotal_value) . "'>" . real_currency($subtotal_value) . "</td>";

															// Total sum
															$total_value = real_sum($total_value, $subtotal_value);
														}

														// End content
														echo "</tr>";
														$count += 1;
														$subtotal_traffic = 0;
														$subtotal_value = 0;
													}

													// Format the time (if necessary)
													if ( $total_time == 0 )
														$total_time = "0:00";
												?>
											</tbody>
											<tfoot>
												<tr>
													<td style="text-align: center; white-space: nowrap;"><h4>Subtotal</h4></td>
													<td style="text-align: center; white-space: nowrap;"><h4><?php echo format_mm_ss($total_time); ?></h4></td>
													<td style="text-align: center; white-space: nowrap;"><h4><?php echo $total_qtd; ?></h4></td>
													<td style="text-align: center; white-space: nowrap;"><h4><?php echo formatMbKb($total_traffic); ?></h4></td>
													<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4>(R$ <?php echo real_currency($total_value); ?>)</h4></td>
												</tr>
											</tfoot>
											<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
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