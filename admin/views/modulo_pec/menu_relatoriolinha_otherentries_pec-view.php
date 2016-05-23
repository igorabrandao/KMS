							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Outros lançamentos por linha">Outros lançamentos por linha <small>relatório </small></h1>
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
												<h4 title="OUTROS LANÇAMENTOS">OUTROS LANÇAMENTOS</h4>
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
													<th style="white-space: nowrap; text-align: center;">LANÇAMENTO</th>
													<th style="white-space: nowrap; text-align: center;">VALOR TOTAL (R$)</th>
												</tr>
											</thead>
											<tbody>
												<?php
													// Auxiliary variable
													$total_value = 0;
													$subtotal_value = 0;
													$colspan = 1;

													// Get the entire report
													$data_value = $modelo->otherentriesreport_PEC($modelo->getIdPEC());

													// Run through service list
													foreach ( $data_value as $value )
													{
														// Init row
														echo "<tr>";

														// Service description
														echo "<td><a href='" . encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/relatoriolinha_otherentriesbyregister_pec?idPEC=") . encrypted_url($value["ID_PEC_OUTRO_LANCAMENTO"], "&idLancamento=") . "' title='" . $value["DESCRICAO"] . "'>" . $value["DESCRICAO"] . "</a></td>";

														// Check if the entry is a discount
														if ( strpos(strtolower($value["DESCRICAO"]), "desconto") !== false )
															// Total value
															$data_value = $modelo->get_otherentries_value_list($modelo->getIdPEC(), iif($value["ID_PEC_OUTRO_LANCAMENTO"]), false);
														else
															// Total value
															$data_value = $modelo->get_otherentries_value_list($modelo->getIdPEC(), iif($value["ID_PEC_OUTRO_LANCAMENTO"]), true);

														// Run through value list
														$aux_value = 0;
														foreach ( $data_value as $vl_list )
														{
															// Check if the value column exists and the carrier is different from CLARO
															if ( $vl_list["VALOR"] != "" ) 
															{
																$aux_value = str_replace(",", ".", $vl_list["VALOR"]);
																$aux_value = remove_double_dots($aux_value);
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
														$subtotal_value = 0;
													}
												?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
													<td id="foot_total" style="text-align: center;"><h4><?php echo real_currency($total_value); ?></h4></td>
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