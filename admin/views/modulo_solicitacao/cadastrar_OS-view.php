							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Ordem de Serviço">Ordem de Serviço <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_OS();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVA ORDEM DE SERVIÇO</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir uma nova OS.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadOS" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
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
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																Operadora <span class="symbol required"></span>
															</label>
															<select name="ID_OPERADORA" id="ID_OPERADORA" class="form-control search-select">
																<option value="">Selecione...</option>
																<?php 
																	// Lista as operadoras
																	$lista = $modelo->get_operadora_list();

																	foreach ($lista as $value)
																	{
																		echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																Tipo de serviço <span class="symbol required"></span>
															</label>
															<select name="TIPO_SERVICO" id="TIPO_SERVICO" class="form-control search-select">
																<option value="">Selecione...</option>
																<?php 
																	// Lista os tipos de serviço
																	$lista = $modelo->get_service_type();

																	foreach ($lista as $value)
																	{
																		echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-10">
														<div class="form-group">
															<label class="control-label">
																Empresa <span class="symbol required"></span>
															</label>
															<select name="ID_EMPRESA" id="ID_EMPRESA" class="form-control search-select">
																<option value="">Selecione...</option>
																<?php 
																	// Lista os usuários
																	$lista = $modelo->get_company_list();

																	foreach ($lista as $value)
																	{
																		echo "<option value='" . $value[0] . "'>(" . $value[1] . ") " . $value[2] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label class="control-label">
																CPF <small class="text-warning">999.999.999-99</small> <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o cpf" id="CPF" name="CPF" class="form-control" onFocus="vApenasNum();" onKeyPress="vNum();" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-10">
														<div class="form-group">
															<label class="control-label">
																Nome completo <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o nome completo" class="form-control" id="NOME_COMPLETO" name="NOME_COMPLETO" maxlength="50">
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="row">
													<div class="form-group connected-group">
														<label class="control-label">
															Data de abertura da OS
														</label>
														<div class="row">
															<div class="col-md-5">
																<input type="text" id="DATA_ABERTURA_OS" name="DATA_ABERTURA_OS" class="form-control" readonly="readonly" value="<?php $dataHora = date("d/m/Y h:i:s"); echo $dataHora;?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<label for="form-field-mask-2">
															Descritivo da OS
														</label>
														<div class="input-group">
															<textarea rows="8" cols="55" maxlength="500" id="DESCRITIVO" name="DESCRITIVO" class="form-control limited"></textarea>
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
													Cadastrar ordem de serviço <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_OS" value="1" />
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