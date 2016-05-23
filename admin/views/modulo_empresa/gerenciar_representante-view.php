							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Representante">Representante <small>gestão </small></h1>
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
											<button class="btn btn-blue add-row" onClick="javascript:window.location.href='<?php echo HOME_URI;?>/modulo_empresa/cadastrar_representante';">
												Adicionar representante <i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="sample_1">
											<thead>
												<tr>
													<th>CPF</th>
													<th>Nome completo</th>
													<th>Descricao</th>
													<th>Cargo</th>
													<th>E-mail</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													// List companies
													$lista = $modelo->get_representante_list();

													foreach ($lista as $value)
													{
														// Construct table body
														echo "<tr>";

														/* INFO'S */
														echo "<td>" . $value[0] . "</td>";
														echo "<td>" . $value[1] . "</td>";
														echo "<td>" . $value[2] . "</td>";
														echo "<td>" . $value[3] . "</td>";
														echo "<td>" . $value[4] . "</td>";

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