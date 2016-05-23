							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Cadastro de Atendimento">Cadastro de Atendimento <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_atendimento();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVO ATENDIMENTO</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir um novo atendimento.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadAtendimento" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
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
													<div class="col-md-5">
														<div class="form-group">
															<label class="control-label">
																CNPJ <small class="text-warning">99.999.999/9999-99</small> <span class="symbol required"></span>
															</label>
															<input type="text" id="CNPJ" name="CNPJ" class="form-control">
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group">
															<label class="control-label">
																Operadora<span class="symbol required"></span>
															</label>
															<select name="ID_OPERADORA" id="ID_OPERADORA" class="form-control search-select" >
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
												</div>
												
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																Tipo de atendimento <span class="symbol required"></span>
															</label>
															<select name="TIPO_ATENDIMENTO" id="TIPO_ATENDIMENTO" class="form-control search-select">
																<option value="">Selecione...</option>
																<option value="1">Anatel</option>
																<option value="2">Ouvidoria</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																Tipo de serviço<span class="symbol required"></span>
															</label>
															<select name="TIPO_SERVICO" id="TIPO_SERVICO" class="form-control search-select" >
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
																Nome atendente <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o nome do atendente" class="form-control" id="NOME_ATENDENTE" name="NOME_ATENDENTE" maxlength="50">
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																Modo de atendimento
															</label>
															<select name="MODO_ATENDIMENTO" id="MODO_ATENDIMENTO" class="form-control search-select" >
																<option value="">Selecione...</option>
																<option value="1">Telefone</option>
																<option value="2">E-mail</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																Protocolo de atendimento <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Protocolo do atendimento" class="form-control" id="PROTOCOLO_ATENDIMENTO" name="PROTOCOLO_ATENDIMENTO" maxlength="50" value="">
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label class="control-label">
																Data de abertura do protocolo
															</label>
															<input type="text" id="DATA_HORARIO_ATENDIMENTO" name="DATA_HORARIO_ATENDIMENTO" class="form-control" readonly="readonly" value="<?php $dataHora = date("d/m/Y h:i:s"); echo $dataHora;?>" />
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-6">

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																Tempo de resolução (em dias úteis)
															</label>
															<input type="number" id="N_DIAS" name="N_DIAS" min="1" max="365" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onChange="addWorkDay( document.getElementById('DATA_HORARIO_ATENDIMENTO').value.substring(0, 10), this.value );"/>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																Data de resolução prevista do protocolo
															</label>
															<input type="text" id="DATA_RESOLUCAO_PREVISTA" name="DATA_RESOLUCAO_PREVISTA" class="form-control" readonly="readonly">
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-md-10">
														<div class="form-group">
															<label class="control-label">
																Histórico do atendimento
															</label>
															<textarea rows="8" cols="55" maxlength="1000" id="HISTORICO" name="HISTORICO" class="form-control limited"></textarea>
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
													Cadastrar atendimento <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_atendimento" value="1" />
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

		<script type="text/javascript">

			/** Function to define add working days to a date
			 * @param date_ => date to receive the addition
			 * @param n_ => number of days to be added
			*/
			function addWorkDay( date_, n_ )
			{
				var parts = date_.split("/");
				var dt = parts[1] + "/" + parts[0] + "/" + parts[2];

				document.getElementById("DATA_RESOLUCAO_PREVISTA").value = addWorkingDay( dt.toString(), n_ );
			}

		</script>