							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Planilha de Estrutura de Custo (PEC)">Planilha de Estrutura de Custo (PEC) <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-md-12">
							<!-- start: FORM VALIDATION 1 PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Formulário de registro
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="fa fa-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="fa fa-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
									<h2><i class="fa fa-pencil-square teal"></i> NOVA PEC</h2>
									<p>
										Insira a fatura para cadastrar uma nova PEC.
									</p>
									<hr>
									<form action="<?php echo HOME_URI;?>/modulo_pec/processar_pec" role="form" id="frmCadPEC" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-12">
												<div class="errorHandler alert alert-danger no-display">
													<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
												</div>
												<div class="successHandler alert alert-success no-display">
													<i class="fa fa-ok"></i> Preenchimento correto!
												</div>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-8">
														<div class="form-group">
															<label class="control-label">
																Arquivo da fatura <span class="symbol required"></span>
															</label>
															<div class="fileupload fileupload-new" data-provides="fileupload">
																<div class="input-group">
																	<div class="form-control uneditable-input">
																		<i class="fa fa-file fileupload-exists"></i>
																		<span class="fileupload-preview"></span>
																	</div>
																	<div class="input-group-btn">
																		<div class="btn btn-light-grey btn-file">
																			<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Escolher arquivo</span>
																			<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Alterar</span>
																			<input type="file" class="file-input" id="FILE_ANEXO" name="FILE_ANEXO" accept=".pdf" />
																		</div>
																		<a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
																			<i class="fa fa-times"></i> Remover
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div>
													<span class="symbol required"></span>Campo de preenchimento obrigatório
													<hr>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<button class="btn btn-blue btn-block" type="submit">
													Cadastrar PEC <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_PEC" value="1" />
									</form>
								</div>
							</div>
							<!-- end: FORM VALIDATION 1 PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->