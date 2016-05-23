							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Cotação">Cotação <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_cotation();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVA COTAÇÃO</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir uma nova cotação.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadCotacao" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
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
													<div class="col-md-10">
														<div class="form-group">
															<label for="form-field-mask-2">
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
																Data de abertura
															</label>
															<input type="text" id="DATA_ABERTURA_COTACAO" name="DATA_ABERTURA_COTACAO" class="form-control" readonly="readonly" value="<?php $dataHora = date("d/m/Y h:i:s"); echo $dataHora;?>" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label for="form-field-mask-2">
																Descritivo da cotação<span class="symbol required"></span>
															</label>
															<div class="input-group">
																<textarea rows="8" cols="55" maxlength="2000" id="DESCRITIVO" name="DESCRITIVO" class="form-control limited"></textarea>
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
												<button class="btn btn-blue btn-block" type="submit" onclick="document.getElementById('OPERADORA').value = checkToBinary('chk_operadora');">
													Cadastrar cotação <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
											<input type="hidden" name="insere_cotacao" value="1" />
											<input type="hidden" name="STATUS_COTACAO" value="1" />
										</div>
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

			var flag = 0;

			/** Function to clone a table row
			 * @param elem_ => element to validate row position
			 * @param btnAdd_ => element to determine position
			 * @param rowToClone_ => row to be cloned
			 * @param tableToModify_ => table do be modified
			*/
			function cloneRow( elem_, btnAdd_, rowToClone_, tableToModify_ )
			{
				var lista = document.getElementsByName(btnAdd_);

				for ( var c = 0; c < lista.length; c++ )
				{
					// Check which element called the function
					if ( lista[c] == elem_ )
					{
						var row = document.getElementById(rowToClone_ + (lista.length - 1)); // find row to copy

						if ( row == null )
							row = document.getElementById(rowToClone_ + (lista.length - 2)); // fix row copy

						var table = document.getElementById(tableToModify_); // find table to append to
						var clone = row.cloneNode(true); // copy children too
						clone.id = rowToClone_ + (lista.length); // change id or other attributes/contents
						table.appendChild(clone); // add new row to end of table
					}
				}
			}

			/** Function to remove a table row
			 * @param elem_ => element to validate row position
			 * @param btnRemove_ => element to determine position
			 * @param rowToClone_ => row to be cloned
			 * @param tableToModify_ => table do be modified
			*/
			function deleteRow( elem_, btnRemove_, rowToClone_, tableToModify_ )
			{
				var listaAnexo = document.getElementsByName(btnRemove_);
				var rowClone = document.getElementsByName(rowToClone_);
				var min = 1;

				// Make sure that at least one field stay
				if ( listaAnexo.length > min )
				{
					for ( var c = 0; c < listaAnexo.length; c++ )
					{
						// Check which element called the function
						if ( listaAnexo[c] == elem_ )
						{
							document.getElementById(tableToModify_).deleteRow(c);
						}

						// Rename all rows
						for (var i = 0; i < rowClone.length; i++)
						{
							rowClone[i].id = rowToClone_ + i;
						}
					}
				}
			}

			/** Function to update chip array in hidden field
			 * @param elem_ => determine the hidden field
			*/
			function updateDDD( elem_ )
			{
				/* Get the HTML inputs */
				var field = document.getElementById( elem_.toString() );
				var ddd = document.getElementsByName("txt_DDD");
				var qtd_ddd = document.getElementsByName("txt_QTDLINHA");
				var qtd_lines = document.getElementById("qtd_lines");

				/* Clear the initial value */
				field.value = "";
				qtd_lines.value = 0;

				/* Check all fields */
				for ( var i = 0; i < ddd.length; i++ )
				{
					if ( ddd[i].value != "" && qtd_ddd[i].value != "" )
					{
						if ( i == 0 )
							field.value = ddd[i].value + "@@" + qtd_ddd[i].value;
						else
							field.value += "//" + ddd[i].value + "@@" + qtd_ddd[i].value;

						qtd_lines.value = ( parseInt(qtd_lines.value) + parseInt(qtd_ddd[i].value) );
					}
				}
			}

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