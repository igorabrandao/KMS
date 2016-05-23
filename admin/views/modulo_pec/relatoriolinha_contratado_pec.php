							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Relatório de contratação por linhas">Relatório de contratação por linhas <small>relatório </small></h1>
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
														$total_plan = 0;
														$total_module = 0;
														$plan_list_id = array();

														// Get the plan list
														$plan_list = $modelo->get_service_list($modelo->getIdPEC());

														// Run through plan list
														foreach ( $plan_list as $plan_value )
														{
															if ( isset($plan_value["DESCRICAO"]) )
															{
																$plan_list_id[$total_plan] = $plan_value["ID_PEC_SERVICO"];
																$total_plan += 1;
															}
														}

														// Calculate the column size
														$column_size = 100/($total_plan + 2);

														// Open the superior column
														echo "<tr>";

														// Print the columns
														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Check if at least one plan will be printed
														if ( sizeof($plan_list) > 0 )
															echo "<th colspan='" . ($total_plan * 2) . "' style='width: " . $column_size . "%; text-align: center' title='PLANOS'>PLANOS</th>";

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Close the superior columns
														echo "</tr><tr>";

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Print the sub-columns (plans)
														foreach ( $plan_list as $plan_value )
														{
															echo "<th colspan='2' style='width: " . $column_size . "%; text-align: center' title='" . $plan_value["DESCRICAO"] . "' >" . $plan_value["DESCRICAO"] . "</th>";
														}

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap'></th>";

														// Close the middle columns
														echo "</tr><tr>";
														$colspan = ($total_plan * 2) + 1;

														echo "<th style='width: 15%; white-space: nowrap; text-align: center; white-space: nowrap' title='ACESSOS'>ACESSOS</th>";

														// Print the sub-columns (plans)
														foreach ( $plan_list as $plan_value )
														{
															echo "<th style='width: " . $column_size/2 . "%; text-align: center' title='Volume' >Volume</th>";
															echo "<th style='width: " . $column_size/2 . "%; text-align: center' title='Valor (R$)' >Valor (R$)</th>";
														}

														echo "<th style='width: 10%; white-space: nowrap; text-align: center; white-space: nowrap' title='VALOR TOTAL POR ACESSO (R$)'>VALOR TOTAL (R$)</th>";

														echo "</tr>";

													?>
												</thead>
												<tbody>
													<?php

														// Auxiliary variable
														$count = 0;
														$colspan = 1;
														$checked = "";
														$id_assoc = "";
														$list_plan_selected = "";
														$aux_phone = "";

														// store the value by line
														$value_by_line = 0;
														$total_value = 0;

														// controls the service's value distribution
														$service_value_counter = 0;

														//! flag to check if the row is ending (end of line)
														$flag_eol = 0;

														// Get the phone number list
														//$phone_list = $modelo->get_phone_list($modelo->getIdPEC());

														// Get the contracted services relates to a phone number
														$phone_service_list = $modelo->get_phoneservice_list($modelo->getIdPEC());

														// Run through phone number list
														foreach ( $phone_service_list as $value )
														{
															// Check if it's the same phone number
															if ( isset($value["LINHA"]) && $value["ID_LINHA"] != $aux_phone )
															{
																// Check if it's an end of line to complete the columns
																if ( $flag_eol == 1 )
																{
																	for ( $c = $service_value_counter; $c < sizeof($plan_list_id); $c++ )
																	{
																		// Volume
																		echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																		// Value
																		echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																	}

																	// Print the total value by line
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value_by_line) . "' >" . real_currency($value_by_line) . "</td>";

																	// Reset the total line value counter
																	$value_by_line = 0;
																}

																// New phone number (Init row)
																$service_value_counter = 0;
																$columns_filled = 0;
																echo "</tr><tr id='row" . $count . "'>";

																// Phone numer
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																{
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
																}
																else
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
															}

															// Get the phone number
															$aux_phone = $value["ID_LINHA"];

															// Run through the service
															for ( $i = $service_value_counter; $i < sizeof($plan_list_id); $i++ )
															{
																// Check if it's the correspondent service
																if ( isset($value["ID_SERVICO"]) && isset($plan_list_id[$i]) && $value["ID_SERVICO"] == $plan_list_id[$i] )
																{
																	// Volume
																	if ( isset($value["MINUTOS"]) && $value["MINUTOS"] != "" )
																	{
																		echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["MINUTOS"] . "' >" . $value["MINUTOS"] . "</td>";
																	}
																	else
																		echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																	// Value
																	if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																	{
																		// Sum the total value by line
																		$value_by_line = real_sum($value_by_line, $value["VALOR"]);
																		$total_value = real_sum($total_value, $value["VALOR"]);

																		echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value["VALOR"]) . "' >" . real_currency($value["VALOR"]) . "</td>";
																	}
																	else
																		echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																	$service_value_counter += 1;
																	$flag_eol = 1;
																	break;
																}
																else
																{
																	// Volume
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																	// Value
																	echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																}

																$flag_eol = 1;
																$service_value_counter += 1;
															}

															$count += 1;
														}

														// Check if it's an end of line to complete the columns (last line)
														if ( $flag_eol == 1 )
														{
															for ( $c = $service_value_counter; $c < sizeof($plan_list_id); $c++ )
															{
																// Volume
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																// Value
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
															}

															// Print the total value by line
															echo "<td style='white-space: nowrap; text-align: center;' title='" . real_currency($value_by_line) . "' >" . real_currency($value_by_line) . "</td>";

															echo "</tr>";
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"></td>
														<td id="foot_total" style="text-align: right;"><h4>Subtotal: R$ <?php echo real_currency($total_value); ?></h4></td>
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