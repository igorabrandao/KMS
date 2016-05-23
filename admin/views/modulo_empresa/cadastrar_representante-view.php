							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Cadastro de Representante">Cadastro de Representante <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_representante();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVO REPRESENTANTE</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir um novo representante.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadRep" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-12">
												<div class="errorHandler alert alert-danger no-display">
													<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
												</div>
												<div class="successHandler alert alert-success no-display">
													<i class="fa fa-ok"></i> Preenchimento correto!
												</div>
											</div>
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-6">
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
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">
																Nome completo <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o nome completo" class="form-control" id="NOME_COMPLETO" name="NOME_COMPLETO" maxlength="50" />
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">
																Data de nascimento <small class="text-warning">99-99-9999</small>
															</label>
															<input type="text" placeholder="Informe o nascimento" id="DATA_NASCIMENTO" name="DATA_NASCIMENTO" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-2">
														<div class="form-group">
															<label class="control-label">
																CPF <small class="text-warning">99.999.999-99</small> <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o cpf" id="CPF" name="CPF" class="form-control" onFocus="vApenasNum();" onKeyPress="vNum();" />
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label class="control-label">
																RG <small class="text-warning">99.999.999-9</small> <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o rg" id="RG" name="RG" class="form-control" />
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label class="control-label">
																Cargo
															</label>
															<input type="text" placeholder="Informe o cargo" id="CARGO" name="CARGO" class="form-control" maxlength="30">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">
																Tipo de representação
															</label>
															<div class="table-responsive">
																<!-- Gerar caixas de check de acordo com as operadoras do banco de dados -->
																<table class="table table-striped table-bordered table-hover" id="sample-table-2">
																	<tbody>
																		<?php 
																			// List operadoras
																			$operadora_coluna = 5;
																			$i = 0;
																			$lista = $modelo->get_type_representante();

																			echo "<tr>";
																			foreach ($lista as $value)
																			{
																				// Check if it's necessary break line
																				if ( $i == $operadora_coluna )
																				{
																					echo "</tr><tr>";
																					$i = 0;
																				}

																				echo "<td title='" . $value[1] . "' style='text-align: center;' nowrap> <label class='checkbox-inline'>";
																				echo "<input type='checkbox' class='square-grey' id='chk_" . $value[0] . "' name='chk_tipo_representante'>";
																				echo $value[1];
																				echo "</label>";
																				$i++;
																			}
																			echo "</tr>";
																		?>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													
												</div>

												<div class="row">
													<div class="col-md-2">
														<div class="form-group">
															<label class="control-label">
																Telefone <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o telefone" id="TELEFONE" name="TELEFONE" class="form-control">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																E-mail
															</label>
															<input type="text" placeholder="Informe o e-mail" id="EMAIL" name="EMAIL" class="form-control" maxlength="100">
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
												<button class="btn btn-blue btn-block" type="submit" onclick="document.getElementById('TIPO_REPRESENTANTE').value = checkToBinary('chk_tipo_representante');">
													Cadastrar representante <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_representante" value="1" />
										<input type="hidden" id="TIPO_REPRESENTANTE" name="TIPO_REPRESENTANTE" value="" />
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

			/** Function to generate binary value according to checkbox
			 * @param chk_ => group of checkboxes to be evaluated
			*/
			function checkToBinary( chk_ )
			{
				var checks = document.getElementsByName(chk_);
				var result = "";

				for ( var i = 0; i < checks.length; i++ )
				{
					if ( checks[i].checked == true )
						result += 1;
					else
						result += 0;
				}
				return result;
			}

		</script>