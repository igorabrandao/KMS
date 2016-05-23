							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Planilha de Estrutura de Custo (PEC)">Planilha de Estrutura de Custo (PEC) <small>gestão </small></h1>
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
											<button class="btn btn-blue add-row" onClick="javascript:window.location.href='<?php echo HOME_URI;?>/modulo_pec/upload_pec';">
												Cadastrar nova PEC <i class="fa fa-plus"></i>
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
													<th style="white-space: nowrap; text-align: center;">Nº DA CONTA</th>
													<th style="white-space: nowrap; text-align: center;">RAZÃO SOCIAL</th>
													<th style="white-space: nowrap; text-align: center;">OPERADORA</th>
													<th style="white-space: nowrap; text-align: center;">MÊS DE REFERÊNCIA</th>
													<th style="white-space: nowrap; text-align: center;">DATA DE VENCIMENTO</th>
													<th style="white-space: nowrap; text-align: center;">PERÍODO DE REFERÊNCIA</th>
													<th style="white-space: nowrap; text-align: center;">ANEXO</th>
												</tr>
											</thead>
											<tbody>
												<?php
													// Get the entire report
													$data_value = $modelo->get_pec_list();

													// Run through service list
													foreach ( $data_value as $value )
													{
														// Init row
														echo "<tr>";

														// PEC number
														echo "<td><a href='" . encrypted_url($value["ID_PEC"], HOME_URI . "/modulo_pec/menu_pec?idPEC=") . "' title='" . $value["N_CONTA"] . "'>" . $value["N_CONTA"] . "</a></td>";

														// Company
														echo "<td style='text-align: center;' title='" . $value["RAZAO_SOCIAL"] . "'>" . $value["RAZAO_SOCIAL"] . "</td>";

														// Carrier
														echo "<td style='text-align: center;' title='" . $value["NOME_OPERADORA"] . "'>" . $value["NOME_OPERADORA"] . "</td>";

														// Reference month
														echo "<td style='text-align: center;' title='" . $value["MES_REFERENCIA"] . "'>" . $value["MES_REFERENCIA"] . "</td>";

														// Expire date
														echo "<td style='text-align: center;' title='" . $value["DATA_VENCIMENTO"] . "'>" . $value["DATA_VENCIMENTO"] . "</td>";

														// Period
														echo "<td style='text-align: center;' title='" . $value["PERIODO"] . "'>" . $value["PERIODO"] . "</td>";

														// Attachment
														echo "<td align='center' style='text-align: center;' title='Abrir fatura em anexo'>
															  <a target='_blank' href='" . encrypted_url($value["ID_PEC"], HOME_URI . "/modulo_geral/visualizarfatura?idPEC=") . "'>
															  <div class='icons' style='width: 50%; margin: auto;'><div class='file-icon' data-type='pdf'></div></div></a></td>";

														// End content
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