							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Contrato com a Operadora">Cadastro de Operadora <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_operadora();
					?>

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
									<h2><i class="fa fa-pencil-square teal"></i> NOVA OPERADORA</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir uma nova operadora.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadOperadora" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
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
												<div class="form-group">
													<label class="control-label">
														Nome da operadora <span class="symbol required"></span>
													</label>
													<input type="text" placeholder="Informe o nome da operadora" class="form-control" id="NOME_OPERADORA" name="NOME_OPERADORA" maxlength="50" />
												</div>
												<div class="form-group">
													<label for="form-field-mask-2">
														CSP <span class="symbol required"></span>
													</label>
													<div class="input-group">
														<!--<span class="input-group-addon"><i class="fa fa-phone"></i> </span>-->
														<input type="text" placeholder="Informe o CSP" id="CSP" name="CSP" class="form-control" maxlength="3"/>
													</div>
												</div>
												</br>
												<label for="form-field-mask-2">
													Telefones para atendimento:
												</label>
												</br></br>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															Fixo
														</label>
														<span class="input-icon">
															<input type="text" placeholder="Telefonia fixa" id="CONTATO_FIXO" name="CONTATO_FIXO" class="form-control" />
														<i class="fa fa-phone"></i> </span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															Móvel
														</label>
														<span class="input-icon">
															<input type="text" placeholder="Telefonia móvel" id="CONTATO_MOVEL" name="CONTATO_MOVEL" class="form-control" />
														<i class="fa fa-phone"></i> </span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															Link dedicado/Fibra ótica
														</label>
														<span class="input-icon">
															<input type="text" placeholder="Link dedicado" id="CONTATO_LINK_DEDICADO" name="CONTATO_LINK_DEDICADO" class="form-control" />
														<i class="fa fa-phone"></i> </span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															Dados
														</label>
														<span class="input-icon">
															<input type="text" placeholder="Dados" id="CONTATO_DADOS" name="CONTATO_DADOS" class="form-control" />
														<i class="fa fa-phone"></i> </span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															DDR
														</label>
														<span class="input-icon">
															<input type="text" placeholder="DDR" id="CONTATO_DDR" name="CONTATO_DDR" class="form-control" />
														<i class="fa fa-phone"></i> </span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															Contato ouvidoria
														</label>
														<span class="input-icon">
															<input type="text" placeholder="Contato ouvidoria" id="CONTATO_OUVIDORIA" name="CONTATO_OUVIDORIA" class="form-control" />
														<i class="fa fa-phone"></i> </span>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row"></div>
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
												<button class="btn btn-yellow btn-block" type="submit">
													Cadastrar operadora <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_operadora" value="1" />
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