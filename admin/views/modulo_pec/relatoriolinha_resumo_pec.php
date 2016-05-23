							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Relatório de resumo por linha">Relatório de resumo por linha <small>relatório </small></h1>
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

														// Auxiliary variable
														$colspan = 0;

														// Open the superior column
														echo "<tr>";

														// Print the columns
														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														//!< **************** FIRST TABLE'S HEAD ROW ****************

														// Print the table title
														echo "<th colspan='13' style='text-align: center; white-space: nowrap;' title='RESUMO GERAL POR ACESSO'>RESUMO GERAL POR ACESSO</th>";

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Close the superior columns
														echo "</tr><tr>";

														//!< ********************************************************

														//!< **************** SECOND TABLE'S HEAD ROW ***************

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Print the sub-columns
														echo "<th style='text-align: center; white-space: nowrap;' title='VALOR PLANOS/MÓDULOS (R$)' >VALOR PLANOS/MÓDULOS (R$)</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='DESCONTO (R$)' >DESCONTO (R$)</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='PARCELA' >PARCELA</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='VALOR PARCELA (R$)' >VALOR PARCELA (R$)</th>";

														echo "<th colspan='3' style='text-align: center; white-space: nowrap;' title='UTILIZAÇÃO ACIMA DO CONTRATADO' >UTILIZAÇÃO ACIMA DO CONTRATADO</th>";
														echo "<th colspan='3' style='text-align: center; white-space: nowrap;' title='SERVIÇOS UTILIZADOS EM PERÍODOS ANTERIORES' >SERVIÇOS UTILIZADOS EM PERÍODOS ANTERIORES</th>";
														echo "<th colspan='3' style='text-align: center; white-space: nowrap;' title='SERVIÇOS DE TERCEIROS TELEFÔNICA DATA' >SERVIÇOS DE TERCEIROS TELEFÔNICA DATA</th>";

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Close the middle columns
														echo "</tr><tr>";

														//!< ********************************************************

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap' title='ACESSOS'>ACESSOS</th>";

														// Print the sub-columns
														echo "<th colspan='4' white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														echo "<th style='text-align: center; white-space: nowrap;' title='VOZ' >VOZ</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='DADOS' >DADOS</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='SMS' >SMS</th>";

														echo "<th style='text-align: center; white-space: nowrap;' title='VOZ' >VOZ</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='DADOS' >DADOS</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='SMS' >SMS</th>";

														echo "<th style='text-align: center; white-space: nowrap;' title='VOZ' >VOZ</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='DADOS' >DADOS</th>";
														echo "<th style='text-align: center; white-space: nowrap;' title='SMS' >SMS</th>";

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

														// Totalization variables
														$subtotal_value = 0;	//!< subtotal per row
														$total_value = 0;		//!< report's total value
														$total_module = 0;
														$total_discount = 0;
														$total_installment = 0;
														$total_acima_voice = 0;
														$total_acima_data = 0;
														$total_acima_sms = 0;
														$total_periodo_anterior_voice = 0;
														$total_periodo_anterior_data = 0;
														$total_periodo_anterior_sms = 0;
														$total_telefonica_data_voice = 0;
														$total_telefonica_data_data = 0;
														$total_telefonica_data_sms = 0;

														// Get the contracted services relates to a phone number
														$phone_list = $modelo->get_summary_report_byphone($modelo->getIdPEC());

														// Run through phone number list
														foreach ( $phone_list as $value )
														{
															// Check if it's the same phone number
															if ( isset($value["LINHA"]) )
															{
																// Clear the total variables
																$subtotal_value = 0;

																// New phone number (Init row)
																echo "</tr><tr id='row" . $count . "'>";

																// Phone numer
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Contracted value
																if ( isset($value["VALOR_CONTRATADO"]) && $value["VALOR_CONTRATADO"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_CONTRATADO"]) . "' >" . real_currency($value["VALOR_CONTRATADO"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_CONTRATADO"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Discount value
																if ( isset($value["VALOR_DESCONTO"]) && $value["VALOR_DESCONTO"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_DESCONTO"]) . "' >" . real_currency($value["VALOR_DESCONTO"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_DESCONTO"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Installments
																if ( isset($value["PARCELA"]) && $value["PARCELA"] != "" )
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["PARCELA"] . "' >" . $value["PARCELA"] . "</td>";
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Installments value
																if ( isset($value["VALOR_PARCELA"]) && $value["VALOR_PARCELA"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_PARCELA"]) . "' >" . real_currency($value["VALOR_PARCELA"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_PARCELA"]));

																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values above the contracted (voice)
																if ( isset($value["VALOR_ACIMA_VOZ"]) && $value["VALOR_ACIMA_VOZ"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_ACIMA_VOZ"]) . "' >" . real_currency($value["VALOR_ACIMA_VOZ"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_ACIMA_VOZ"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values above the contracted (data)
																if ( isset($value["VALOR_ACIMA_DADOS"]) && $value["VALOR_ACIMA_DADOS"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_ACIMA_DADOS"]) . "' >" . real_currency($value["VALOR_ACIMA_DADOS"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_ACIMA_DADOS"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values above the contracted (sms)
																if ( isset($value["VALOR_ACIMA_SMS"]) && $value["VALOR_ACIMA_SMS"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_ACIMA_SMS"]) . "' >" . real_currency($value["VALOR_ACIMA_SMS"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_ACIMA_SMS"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values related to other periods (voice)
																if ( isset($value["VALOR_PERIODO_ANTERIOR_VOZ"]) && $value["VALOR_PERIODO_ANTERIOR_VOZ"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_PERIODO_ANTERIOR_VOZ"]) . "' >" . real_currency($value["VALOR_PERIODO_ANTERIOR_VOZ"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_PERIODO_ANTERIOR_VOZ"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values related to other periods (data)
																if ( isset($value["VALOR_PERIODO_ANTERIOR_DADOS"]) && $value["VALOR_PERIODO_ANTERIOR_DADOS"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_PERIODO_ANTERIOR_DADOS"]) . "' >" . real_currency($value["VALOR_PERIODO_ANTERIOR_DADOS"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_PERIODO_ANTERIOR_DADOS"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values related to other periods (sms)
																if ( isset($value["VALOR_PERIODO_ANTERIOR_SMS"]) && $value["VALOR_PERIODO_ANTERIOR_SMS"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_PERIODO_ANTERIOR_SMS"]) . "' >" . real_currency($value["VALOR_PERIODO_ANTERIOR_SMS"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_PERIODO_ANTERIOR_SMS"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values related to telefonic data (voice)
																if ( isset($value["VALOR_TELEFONICA_DATA_VOZ"]) && $value["VALOR_TELEFONICA_DATA_VOZ"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_TELEFONICA_DATA_VOZ"]) . "' >" . real_currency($value["VALOR_TELEFONICA_DATA_VOZ"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_TELEFONICA_DATA_VOZ"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values related to telefonic data (data)
																if ( isset($value["VALOR_TELEFONICA_DATA_DADOS"]) && $value["VALOR_TELEFONICA_DATA_DADOS"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_TELEFONICA_DATA_DADOS"]) . "' >" . real_currency($value["VALOR_TELEFONICA_DATA_DADOS"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_TELEFONICA_DATA_DADOS"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Values related to telefonic data (sms)
																if ( isset($value["VALOR_TELEFONICA_DATA_SMS"]) && $value["VALOR_TELEFONICA_DATA_SMS"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR_TELEFONICA_DATA_SMS"]) . "' >" . real_currency($value["VALOR_TELEFONICA_DATA_SMS"]) . "</td>";

																	// Total register sum
																	$subtotal_value = real_sum($subtotal_value, str_replace(",", ".", $value["VALOR_TELEFONICA_DATA_SMS"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Subtotal value
																if ( isset($subtotal_value) && $subtotal_value != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($subtotal_value) . "' ><strong>" . real_currency($subtotal_value) . "</strong></td>";

																	// Total value
																	$total_value = real_sum($total_value, str_replace(",", ".", $subtotal_value));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Close the row
																echo "</tr>";

																// Sum up the totals
																if ( isset( $value["VALOR_CONTRATADO"] ) )
																	$total_module = real_sum($total_module, str_replace(",", ".", $value["VALOR_CONTRATADO"]));

																if ( isset( $value["VALOR_DESCONTO"] ) )
																	$total_discount = real_sum($total_discount, str_replace(",", ".", $value["VALOR_DESCONTO"]));

																if ( isset( $value["VALOR_PARCELA"] ) )
																	$total_installment = real_sum($total_installment, str_replace(",", ".", $value["VALOR_PARCELA"]));

																if ( isset( $value["VALOR_ACIMA_VOZ"] ) )
																	$total_acima_voice = real_sum($total_acima_voice, str_replace(",", ".", $value["VALOR_ACIMA_VOZ"]));

																if ( isset( $value["VALOR_ACIMA_DADOS"] ) )
																	$total_acima_data = real_sum($total_acima_data, str_replace(",", ".", $value["VALOR_ACIMA_DADOS"]));

																if ( isset( $value["VALOR_ACIMA_SMS"] ) )
																	$total_acima_sms = real_sum($total_acima_sms, str_replace(",", ".", $value["VALOR_ACIMA_SMS"]));

																if ( isset( $value["VALOR_PERIODO_ANTERIOR_VOZ"] ) )
																	$total_periodo_anterior_voice = real_sum($total_periodo_anterior_voice, str_replace(",", ".", $value["VALOR_PERIODO_ANTERIOR_VOZ"]));

																if ( isset( $value["VALOR_PERIODO_ANTERIOR_DADOS"] ) )
																	$total_periodo_anterior_data = real_sum($total_periodo_anterior_data, str_replace(",", ".", $value["VALOR_PERIODO_ANTERIOR_DADOS"]));

																if ( isset( $value["VALOR_PERIODO_ANTERIOR_SMS"] ) )
																	$total_periodo_anterior_data = real_sum($total_periodo_anterior_data, str_replace(",", ".", $value["VALOR_PERIODO_ANTERIOR_SMS"]));

																if ( isset( $value["VALOR_TELEFONICA_DATA_VOZ"] ) )
																	$total_telefonica_data_voice = real_sum($total_telefonica_data_voice, str_replace(",", ".", $value["VALOR_TELEFONICA_DATA_VOZ"]));

																if ( isset( $value["VALOR_TELEFONICA_DATA_DADOS"] ) )
																	$total_telefonica_data_data = real_sum($total_telefonica_data_data, str_replace(",", ".", $value["VALOR_TELEFONICA_DATA_DADOS"]));

																if ( isset( $value["VALOR_TELEFONICA_DATA_SMS"] ) )
																	$total_telefonica_data_sms = real_sum($total_telefonica_data_sms, str_replace(",", ".", $value["VALOR_TELEFONICA_DATA_SMS"]));
															}
														}

														// Get the empty phone entries
														$empty_phone_list = $modelo->get_summary_report_emptyentries($modelo->getIdPEC(), 6); //!< discount

														// Run through phone number list
														foreach ( $empty_phone_list as $value )
														{
															// Check if it's the same phone number
															if ( isset($value["VALOR"]) )
															{
																$subtotal_value2 = 0;
																echo "<tr>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																if ( isset($value["PERIODO"]) && $value["PERIODO"] != "" )
																	echo "<td style='text-align: center; white-space: nowrap;'>" . $value["PERIODO"] . "</td>";
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																{
																	echo "<td style='text-align: center; white-space: nowrap;'>" . $value["VALOR"] . "</td>";

																	// Total register sum
																	$subtotal_value2 = real_sum($subtotal_value2, str_replace(",", ".", $value["VALOR"]));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Subtotal value
																if ( isset($subtotal_value2) && $subtotal_value2 != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($subtotal_value2) . "' ><strong>" . real_currency($subtotal_value2) . "</strong></td>";

																	// Total value
																	$total_installment = real_sum($total_installment, str_replace(",", ".", $subtotal_value2));
																	$total_value = real_sum($total_value, str_replace(",", ".", $subtotal_value2));
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																echo "</tr>";
															}
														}

													?>
												</tbody>
												<tfoot>
													<tr>
														<!-- Footer title -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>

														<!-- Total modules/services value -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_module); ?></h4></td>

														<!-- Total discount value -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_discount); ?></h4></td>

														<!-- Blank <td> -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"></td>

														<!-- Installment value -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_installment); ?></h4></td>

														<!-- Above the contracted (voice) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_acima_voice); ?></h4></td>

														<!-- Above the contracted (data) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_acima_data); ?></h4></td>

														<!-- Above the contracted (sms) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_acima_sms); ?></h4></td>

														<!-- Other periods (voice) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_periodo_anterior_voice); ?></h4></td>

														<!-- Other periods (data) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_periodo_anterior_data); ?></h4></td>

														<!-- Other periods (sms) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_periodo_anterior_sms); ?></h4></td>

														<!-- Telefonic data (voice) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_telefonica_data_voice); ?></h4></td>

														<!-- Telefonic data (data) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_telefonica_data_data); ?></h4></td>

														<!-- Telefonic data (sms) -->
														<td colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_telefonica_data_sms); ?></h4></td>

														<!-- Total value -->
														<td id="foot_total" colspan="1" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_value); ?></h4></td>
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