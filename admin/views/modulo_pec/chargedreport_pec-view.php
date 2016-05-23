							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="O que está sendo cobrado">O que está sendo cobrado <small>relatório </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Check if PEC ID is valid
						$modelo->checkValidit_PEC();

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
												<h4 title="SERVIÇOS CONTRATADOS">SERVIÇOS CONTRATADOS</h4>
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
									//! All carriers, except TIM
									if ( $carrier != 6 ) { ?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;">DESCRITIVO DO SERVIÇO</th>
														<th style="white-space: nowrap; text-align: center;">QUANTIDADE DE LINHAS</th>
														<th style="white-space: nowrap; text-align: center;">PERÍODO DE REFERÊNCIA</th>
														<?php if ( $carrier == 1 ) { // CLARO ?>
															<th style="white-space: nowrap; text-align: center;">DESCONTO</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center;">VALOR TOTAL (R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
														// Auxiliary variable
														$total_value = 0;
														$total_discount = 0;
														$colspan = 3;

														// Get the entire report
														if ( $carrier != 1 )
															$data_value = $modelo->chargedreport_PEC($modelo->getIdPEC()); //!< Carrier different than CLARO
														else
															$data_value = $modelo->chargedreport_discount_PEC($modelo->getIdPEC(), false); //!< Get registers different than discount

														// Run through service list
														foreach ( $data_value as $value )
														{
															// Init row
															echo "<tr>";
															
															// Service description
															if ( isset($value["DESCRICAO"]) && $value["DESCRICAO"] )
																echo "<td style='white-space: nowrap;'><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/chargedbyservicereport_pec?idPEC=") . encrypted_url($value["ID_SERVICO"], "&idService=") . "' title='" . $value["DESCRICAO"] . "'>" . $value["DESCRICAO"] . "</a></td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Phone number count
															if ( isset($value["QTD_LINHA"]) && $value["QTD_LINHA"] )
																echo "<td style='text-align: center;' title='" . $value["QTD_LINHA"] . "'>" . $value["QTD_LINHA"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Income period
															if ( isset($value["PERIODO"]) && $value["PERIODO"] )
																echo "<td style='text-align: center;' title='" . $value["PERIODO"] . "'>" . $value["PERIODO"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// CLARO carrier specific case 
                                                            if ( $carrier == 1 )
                                                            {
                                                                $discount_value = $modelo->chargedreport_discount_PEC($modelo->getIdPEC(), true);
                                                                $is_printed = 0;

                                                                // Run through discount list
                                                                foreach ( $discount_value as $disc_value )
                                                                {
                                                                    $description = str_replace("DESCONTO", "", rtrim(ltrim( $disc_value["DESCRICAO"] )));

                                                                    if ( strcmp(trim($description), trim($value["DESCRICAO"])) == 0 )
                                                                    {
                                                                        $total_discount = real_sum($total_discount, $disc_value["VALOR_TOTAL"]);
                                                                        echo "<td style='text-align: center;' title='" . real_currency($disc_value["VALOR_TOTAL"]) . "'>" . real_currency($disc_value["VALOR_TOTAL"]) . "</td>";
                                                                        $is_printed = 1;
                                                                        break;
                                                                    }
                                                                }

                                                                if ( $is_printed == 0 )
                                                                    echo "<td style='text-align: center;' title='-'>-</td>";
                                                            }

															// Total value
															if ( isset($value["FRANQUIA_REAIS"]) && $value["FRANQUIA_REAIS"] != "" )
															{
																echo "<td style='text-align: center;' title='" . $value["FRANQUIA_REAIS"] . "'>" . $value["FRANQUIA_REAIS"] . "</td>";

																// Total sum
																$total_value = real_sum($total_value, $value["FRANQUIA_REAIS"]);

																// Insert dynamically the complementary values
																$modelo->insert_chargedreport_PEC( $modelo->getIdPEC(), $value["ID_PEC_SERVICO"], $value["QTD_LINHA"], $value["FRANQUIA_REAIS"] );
															}
															else
															{
																if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																{
																	echo "<td style='text-align: center;' title='" . $value["VALOR_TOTAL"] . "'>" . $value["VALOR_TOTAL"] . "</td>";

																	echo usd_currency($total_value) . " + " .  $value["VALOR_TOTAL"] . " = ";

																	// Total sum
																	$total_value = (currency_operation( $total_value, str_replace(",", "", $value["VALOR_TOTAL"]), "+" ))/100;

																	echo $total_value . "</br>";

																	// Insert dynamically the complementary values
																	$modelo->insert_chargedreport_PEC( $modelo->getIdPEC(), $value["ID_PEC_SERVICO"], $value["QTD_LINHA"], $value["VALOR_TOTAL"] );
																}
																else
																{
																	echo "<td style='text-align: center;' title='" . real_currency($value["VALOR_TOTAL"]) . "'>" . real_currency($value["VALOR_TOTAL"]) . "</td>";

																	// Total sum
																	$total_value = real_sum($total_value, $value["VALOR_TOTAL"]);

																	// Insert dynamically the complementary values
																	$modelo->insert_chargedreport_PEC( $modelo->getIdPEC(), $value["ID_PEC_SERVICO"], $value["QTD_LINHA"], real_currency($value["VALOR_TOTAL"]) );
																}
															}

															// End content
															echo "</tr>";
														}

														echo $total_value;
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
														<?php if ( $carrier == 1 ) { // CLARO subtotal desconto ?>
															<td style="text-align: center;"><h4><?php echo real_currency($total_discount); ?></h4></td>
														<?php } ?>
														<td id="foot_total" style="text-align: right;"><h4><?php echo real_currency($total_value); ?></h4></td>
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
														<th style="white-space: nowrap; text-align: center;" title="DESCRIÇÃO DO SERVIÇO">DESCRITIVO</th>
														<th style="white-space: nowrap; text-align: center;" title="QUANTIDADE DE LINHAS">QTD. LINHAS</th>
														<th style="white-space: nowrap; text-align: center;" title="NÚMERO DE DIAS">Nº DIAS</th>
														<th style="white-space: nowrap; text-align: center;" title="DURAÇÃO">DURAÇÃO</th>
														<th style="white-space: nowrap; text-align: center;" title="VOLUME DE DADOS">VOLUME</th>
														<th style="white-space: nowrap; text-align: center;" title="PERÍODO DE REFERÊNCIA">PERÍODO</th>
														<th style="white-space: nowrap; text-align: center;" title="ICMS">ICMS</th>
														<th style="white-space: nowrap; text-align: center;" title="PIS/COFINS">PIS/COFINS</th>
														<th style="white-space: nowrap; text-align: center;" title="VALOR TOTAL (R$)">VALOR TOTAL (R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
														// Auxiliary variable,
														$subtotal_value = 0;
														$total_value = 0;
														$total_discount = 0;
														$colspan = 8;

														// Get the entire report
														$data_value = $modelo->chargedreport_tim_PEC($modelo->getIdPEC()); 

														// Run through service list
														foreach ( $data_value as $value )
														{
															// Init row
															echo "<tr>";

															// Service description
															if ( isset($value["DESCRICAO"]) && $value["DESCRICAO"] )
																echo "<td style='white-space: nowrap;'><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/chargedbyservicereport_pec?idPEC=") . encrypted_url($value["ID_SERVICO"], "&idService=") . "' title='" . $value["DESCRICAO"] . "'>" . $value["DESCRICAO"] . "</a></td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Phone number count
															if ( isset($value["QTD_LINHA"]) && $value["QTD_LINHA"] )
																echo "<td style='text-align: center;' title='" . $value["QTD_LINHA"] . "'>" . $value["QTD_LINHA"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Days number
															if ( isset($value["N_DIAS"]) && $value["N_DIAS"] )
																echo "<td style='text-align: center;' title='" . $value["N_DIAS"] . "'>" . $value["N_DIAS"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Duration
															if ( isset($value["DURACAO"]) && $value["DURACAO"] )
																echo "<td style='text-align: center;' title='" . $value["DURACAO"] . "'>" . $value["DURACAO"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Volume
															if ( isset($value["VOLUME"]) && $value["VOLUME"] )
																echo "<td style='text-align: center;' title='" . $value["VOLUME"] . "'>" . $value["VOLUME"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Income period
															if ( isset($value["PERIODO2"]) && $value["PERIODO2"] )
																echo "<td style='white-space: nowrap; text-align: center;' title='" . str_replace("_a_", " a ", $value["PERIODO2"]) . "'>" . str_replace("_a_", " a ", $value["PERIODO2"]) . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// ICMS
															if ( isset($value["ICMS"]) && $value["ICMS"] )
																echo "<td style='text-align: center;' title='" . $value["ICMS"] . "'>" . $value["ICMS"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// PIS/COFINS
															if ( isset($value["PIS_COFINS"]) && $value["PIS_COFINS"] )
																echo "<td style='text-align: center;' title='" . $value["PIS_COFINS"] . "'>" . $value["PIS_COFINS"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Total value
															$value_list = $modelo->chargedreport_tim_value_PEC($modelo->getIdPEC(), iif($value["ID_SERVICO"]));

															// Run through service list
															$aux_value = "";
															foreach ( $value_list as $vl_list )
															{
																// Value
																if ( isset($vl_list["VALOR"]) && $vl_list["VALOR"] != "" )
																{
																	$aux_value = str_replace(",", ".", $vl_list["VALOR"]);
																	$aux_value = remove_double_dots($aux_value);
																	$subtotal_value = real_sum($subtotal_value, $aux_value);
																}
																else
																	echo "<td style='text-align: center;'>0,00</td>";
															}

															if ( isset($subtotal_value) )
															{
																echo "<td style='text-align: center;' title='" . real_currency($subtotal_value) . "'>" . real_currency($subtotal_value) . "</td>";

																// Total sum
																$total_value = real_sum($total_value, $subtotal_value);

																// Insert dynamically the complementary values
																$modelo->insert_chargedreport_PEC( $modelo->getIdPEC(), $value["ID_PEC_SERVICO"], $value["QTD_LINHA"], real_currency($subtotal_value) );
																$subtotal_value = 0;
															}

															// End content
															echo "</tr>";
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
														<td id="foot_total" style="text-align: right;"><h4><?php echo real_currency($total_value); ?></h4></td>
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