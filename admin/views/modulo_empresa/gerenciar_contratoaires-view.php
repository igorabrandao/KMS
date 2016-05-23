							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Contrato Aires">Contrato Aires <small>gestão </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

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
											<button class="btn btn-blue add-row" onClick="javascript:window.location.href='<?php echo HOME_URI;?>/modulo_empresa/cadastrar_contratoaires';">
												Adicionar contrato Aires <i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="sample_1">
											<thead>
												<tr>
													<th>ID</th>
													<th>Início do contrato</th>
													<th>Operadoras</th>
													<th>Negociação (%)</th>
													<th>Gasto mensal estimado (R$)</th>
													<th>Redução mensal estimada (R$)</th>
													<th>Redução anual estimada (R$)</th>
													<th>Valor total linhas ativas (R$)</th>
													<th>Valor total linhas inativas (R$)</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													// List contracts
													$lista = $modelo->get_contract_list();
													$lista_operadora = $modelo->get_operadora_list();
													$i = 0;
													$coluna = 0;

													foreach ( $lista as $value )
													{
														// Construct table body
														echo "<tr>";

														/* INFO'S */
														echo "<td>" . $value[0] . "</td>";
														echo "<td>" . $value[1] . "</td>";

														/* Handle operadoras */
														echo "<td class='hidden-xs'>";
														foreach ( $lista_operadora as $value_operadora )
														{
															if ( substr( $value[2], $i, 1) == 1 )
															{
																echo "<span title='" . $value_operadora[1] . "' class='label label-sm label-success'>" . $value_operadora[1] . "</span>&nbsp;";
																$coluna++;

																if ( $coluna == 3 )
																{
																	echo "</br></br>";
																	$coluna = 0;
																}
															}
															$i++;
														}
														echo "</td>";

														echo "<td>" . $value[3] . "</td>";
														echo "<td>" . $value[4] . "</td>";
														echo "<td>" . $value[5] . "</td>";
														echo "<td>" . $value[6] . "</td>";
														echo "<td>" . $value[7] . "</td>";
														echo "<td>" . $value[8] . "</td>";

														// Line break
														echo "</tr>";
													}
												?>
											</tbody>
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