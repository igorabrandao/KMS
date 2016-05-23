							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Pré-cadastro de módulo do book">Pré-cadastro de módulo do book <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_modulobook();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVO MÓDULO BOOK</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir um novo atendimento.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadModulo" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-12">
												<div class="errorHandler alert alert-danger no-display">
													<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
												</div>
												<div class="successHandler alert alert-success no-display">
													<i class="fa fa-ok"></i> Preenchimento correto!
												</div>
											</div>
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
												<div class="form-group">
													<label class="control-label">
														Descritivo <span class="symbol required"></span>
													</label>
													<input placeholder="Informe o descritivo" id="DESCRITIVO_MODULO" name="DESCRITIVO_MODULO" type="text" class="form-control" maxlength="100">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label class="control-label">
														Campos <span class="symbol required"></span>
													</label>
													<div class="table-responsive">
														<!-- Gerar caixas de check de acordo com as operadoras do banco de dados -->
														<table class="table table-striped table-bordered table-hover" id="sample-table-2">
															<tbody>
																<?php 
																	// List operadoras
																	$campo_coluna = 5;
																	$i = 0;
																	$lista = $modelo->get_field_list();

																	echo "<tr>";
																	foreach ($lista as $value)
																	{
																		// Check if it's necessary break line
																		if ( $i == $campo_coluna )
																		{
																			echo "</tr><tr>";
																			$i = 0;
																		}

																		echo "<td title='" . $value[1] . "' style='text-align: left;' nowrap> <label class='checkbox-inline'>";
																		echo "<input type='checkbox' class='square-grey' id='chk_" . $value[0] . "' name='chk_field'/>";
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
											<div class="col-md-12">
												<div>
													<span class="symbol required"></span>Campo de preenchimento obrigatório
													<hr>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<button class="btn btn-blue btn-block" type="submit" onclick="document.getElementById('CAMPOS').value = checkToField('chk_field');">
													Pré-cadastrar módulo <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" id="CAMPOS" name="CAMPOS" value="" />
										<input type="hidden" name="insere_modulobook" value="1" />
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
			function checkToField( chk_ )
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