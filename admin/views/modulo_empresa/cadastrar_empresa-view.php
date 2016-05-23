							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Cadastro de Empresa">Cadastro de Empresa <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_company();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVA EMPRESA</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir uma nova empresa.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadEmp" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-12">
												<div class="errorHandler alert alert-danger no-display">
													<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
												</div>
												<div class="successHandler alert alert-success no-display">
													<i class="fa fa-ok"></i> Empresa cadastrada com sucesso!
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														Modalidade da empresa <span class="symbol required"></span>
													</label>
													<select name="MODALIDADE_EMPRESA" id="MODALIDADE_EMPRESA" class="form-control search-select" >
														<option value="">Selecione...</option>
														<option value="1">Matriz</option>
														<option value="2">Filial</option>
													</select>
												</div>
												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label for="form-field-mask-2">
																CNPJ <small class="text-warning">99.999.999/9999-99</small> <span class="symbol required"></span>
															</label>
															<div class="input-group">
																<input type="text" id="CNPJ" name="CNPJ" class="form-control" onFocus="vApenasNum();" onKeyPress="vNum();" />
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label for="form-field-mask-2">
																Inscrição estadual <!--<small class="text-warning">999.999.999.999</small>--><span class="symbol required"></span>
															</label>
															<div class="input-group">
																<!--<span class="input-group-addon"> <i class="fa fa-phone"></i> </span>-->
																<input type="text" id="INSCRICAO_ESTADUAL" name="INSCRICAO_ESTADUAL" class="form-control" maxlength="15" />
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label">
														Razão social <span class="symbol required"></span>
													</label>
													<input type="text" placeholder="Informe a razão social" class="form-control" id="RAZAO_SOCIAL" name="RAZAO_SOCIAL" maxlength="50" />
												</div>
												<div class="form-group">
													<label class="control-label">
														Nome fantasia <span class="symbol required"></span>
													</label>
													<input type="text" placeholder="Informe o nome fantasia" class="form-control" id="NOME_FANTASIA" name="NOME_FANTASIA" maxlength="50" />
												</div>
												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label for="form-field-mask-2">
																Data de abertura <small class="text-warning">99-99-9999</small>
															</label>
															<div class="input-group">
																<!--date-picker-->
																<input type="text" id="DATA_ABERTURA" name="DATA_ABERTURA" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" />
																<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label for="form-field-mask-2">
																Número de funcionários
															</label>
															<input type="number" id="N_FUNCIONARIOS" name="N_FUNCIONARIOS" min="1" max="10000000" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label">
														Porte <span class="symbol required"></span>
													</label>
													<select name="PORTE" id="PORTE" class="form-control search-select" >
														<option value="">Selecione...</option>
														<option value="1">Microempresa</option>
														<option value="2">Pequena empresa</option>
														<option value="3">Média empresa</option>
														<option value="4">Média-grande empresa</option>
														<option value="5">Grande empresa</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-10">
														<div class="form-group">
															<label class="control-label">
																Endereço <span class="symbol required"></span>
															</label>
															<input class="form-control" type="text" id="ENDERECO" name="ENDERECO" maxlength="100">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label class="control-label">
																Número
															</label>
															<!--<input class="form-control tooltips" type="text" data-original-title="We'll display it when you write reviews" data-rel="tooltip"  title="" data-placement="top" name="city" id="city">-->
															<input type="number" class="form-control" id="NUMERO" name="NUMERO" min="1" max="100000">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																CEP <small class="text-warning">99999-999</small> <span class="symbol required"></span>
															</label>
															<input class="form-control" type="text" id="CEP" name="CEP">
														</div>
													</div>
													<div class="col-md-8">
														<div class="form-group">
															<label class="control-label">
																Bairro
															</label>
															<input class="form-control" type="text" id="BAIRRO" name="BAIRRO" maxlength="50">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-8">
														<div class="form-group">
															<label class="control-label">
																Cidade
															</label>
															<input class="form-control" type="text" id="CIDADE" name="CIDADE" maxlength="50">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																UF
															</label>
															<select name="UF" id="UF" class="form-control search-select" >
																<option value="">Selecione...</option>
																<?php
																	// Lista os usuários
																	$lista = $modelo->get_state_list();

																	foreach ($lista as $value)
																	{
																		echo "<option value='" . $value[1] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																Contato 1 <span class="symbol required"></span>
															</label>
															<input class="form-control" type="text" id="NOME_CONTATO" name="NOME_CONTATO" maxlength="50">
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																Telefone <span class="symbol required"></span>
															</label>
															<input class="form-control" type="text" id="TELEFONE" name="TELEFONE" maxlength="50">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label class="control-label">
																Ramal
															</label>
															<input class="form-control" type="text" id="RAMAL" name="RAMAL" maxlength="10">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">
																E-mail 1 <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o e-mail do contato 1" id="EMAIL" name="EMAIL" class="form-control" maxlength="100">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																Contato 2
															</label>
															<input class="form-control" type="text" id="NOME_CONTATO2" name="NOME_CONTATO2" maxlength="50">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																Telefone
															</label>
															<input class="form-control" type="text" id="TELEFONE2" name="TELEFONE2" maxlength="50">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label class="control-label">
																Ramal
															</label>
															<input class="form-control" type="text" id="RAMAL2" name="RAMAL2" maxlength="10">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">
																E-mail 2
															</label>
															<input type="text" placeholder="Informe o e-mail do contato 2" id="EMAIL2" name="EMAIL2" class="form-control" maxlength="100">
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
													Cadastrar empresa <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_empresa" value="1" />
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