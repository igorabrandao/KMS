							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Chips">Chips <small>gestão </small></h1>
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
											<button class="btn btn-blue add-row" onClick="javascript:window.location.href='<?php echo HOME_URI;?>/modulo_patrimonio/cadastrar_chip';">
												Adicionar chip <i class="fa fa-plus"></i>
											</button>
											<div class="btn-group pull-right">
												<ul class="dropdown-menu dropdown-light pull-right">
													<li>
														<a href="#" class="export-pdf" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Save as PDF </a>
													</li>
													<li>
														<a href="#" class="export-png" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Save as PNG </a>
													</li>
													<li>
														<a href="#" class="export-csv" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Save as CSV </a>
													</li>
													<li>
														<a href="#" class="export-txt" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Save as TXT </a>
													</li>
													<li>
														<a href="#" class="export-xml" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Save as XML </a>
													</li>
													<li>
														<a href="#" class="export-sql" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Save as SQL </a>
													</li>
													<li>
														<a href="#" class="export-json" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Save as JSON </a>
													</li>
													<li>
														<a href="#" class="export-excel" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Export to Excel </a>
													</li>
													<li>
														<a href="#" class="export-doc" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Export to Word </a>
													</li>
													<li>
														<a href="#" class="export-powerpoint" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Export to PowerPoint </a>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="sample_1">
											<thead>
												<tr>
													<th class="center">
														<div class="checkbox-table">
															<label>
																<input type="checkbox" class="flat-grey">
															</label>
														</div>
													</th>
													<th>Empresa</th>
													<th>CNPJ</th>
													<th>Representante</th>
													<th>Modelo</th>
													<th>Status coleta</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="center">
													<div class="checkbox-table">
														<label>
															<input type="checkbox" class="flat-grey">
														</label>
													</div></td>
													<td>XXXXXXXXXXXXXXX</td>
													<td>Vivo</td>
													<td>Marca 01</td>
													<td class="hidden-xs">
													<a href="#" rel="nofollow" target="_blank">
														Modelo 01
													</a></td>
													<td>Não coletado</td>
													<td class="center">
														<div class="visible-md visible-lg hidden-sm hidden-xs">
															<a href="#" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
															<a href="#" class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
															<a href="#" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
														</div>
														<div class="visible-xs visible-sm hidden-md hidden-lg">
															<div class="btn-group">
																<a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
																	<i class="fa fa-cog"></i> <span class="caret"></span>
																</a>
																<ul role="menu" class="dropdown-menu pull-right">
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-edit"></i> Edit
																		</a>
																	</li>
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-share"></i> Share
																		</a>
																	</li>
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-times"></i> Remove
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td class="center">
													<div class="checkbox-table">
														<label>
															<input type="checkbox" class="flat-grey">
														</label>
													</div></td>
													<td>YYYYYYYYYYYYYYYY</td>
													<td>Tim</td>
													<td>Marca 02</td>
													<td class="hidden-xs">
													<a href="#" rel="nofollow" target="_blank">
														Modelo 02
													</a></td>
													<td>Coletado</td>
													<td class="center">
														<div class="visible-md visible-lg hidden-sm hidden-xs">
															<a href="#" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
															<a href="#" class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
															<a href="#" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
														</div>
														<div class="visible-xs visible-sm hidden-md hidden-lg">
															<div class="btn-group">
																<a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
																	<i class="fa fa-cog"></i> <span class="caret"></span>
																</a>
																<ul role="menu" class="dropdown-menu pull-right">
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-edit"></i> Edit
																		</a>
																	</li>
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-share"></i> Share
																		</a>
																	</li>
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-times"></i> Remove
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td class="center">
													<div class="checkbox-table">
														<label>
															<input type="checkbox" class="flat-grey">
														</label>
													</div></td>
													<td>ZZZZZZZZZZZZZZZZ</td>
													<td>Vivo</td>
													<td>Marca 03</td>
													<td class="hidden-xs">
													<a href="#" rel="nofollow" target="_blank">
														Modelo 03
													</a></td>
													<td>Não coletado</td>
													<td class="center">
														<div class="visible-md visible-lg hidden-sm hidden-xs">
															<a href="#" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
															<a href="#" class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
															<a href="#" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
														</div>
														<div class="visible-xs visible-sm hidden-md hidden-lg">
															<div class="btn-group">
																<a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
																	<i class="fa fa-cog"></i> <span class="caret"></span>
																</a>
																<ul role="menu" class="dropdown-menu pull-right">
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-edit"></i> Edit
																		</a>
																	</li>
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-share"></i> Share
																		</a>
																	</li>
																	<li role="presentation">
																		<a role="menuitem" tabindex="-1" href="#">
																			<i class="fa fa-times"></i> Remove
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
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