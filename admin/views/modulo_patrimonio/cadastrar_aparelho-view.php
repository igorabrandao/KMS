							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Aparelho">Aparelho <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_device();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVO APARELHO</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir um novo aparelho.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadAparelho" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
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
																Contrato da operadora <span class="symbol required"></span>
															</label>
															<select name="ID_CONTRATO_OPERADORA" id="ID_CONTRATO_OPERADORA" class="form-control search-select">
																<option value="">Selecione...</option>
																<?php 
																	// Lista os usuários
																	$lista = $modelo->get_contract_list();

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
																Marca do aparelho <span class="symbol required"></span>
															</label>
															<select name="ID_MARCA" id="ID_MARCA" class="form-control search-select">
																<option value="">Selecione...</option>
																<?php 
																	// Lista as marcas
																	$lista = $modelo->get_brand_list();

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
																Modelo <span class="symbol required"></span>
															</label>
															<input type="text" placeholder="Informe o modelo do aparelho" class="form-control" id="MODELO" name="MODELO" maxlength="50">											
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label class="control-label">
																Quantidade de aparelhos <span class="symbol required"></span>
															</label>
															<input type="number" id="N_APARELHOS" name="N_APARELHOS" min="1" max="10000000" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onChange="addIMEI('table_imei', this.value); deleteIMEI('table_imei', this.value);" />											
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-6">

												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label class="control-label">
																Tipo do ativo <span class="symbol required"></span>
															</label>
															<select name="ID_TIPO_ATIVO" id="ID_TIPO_ATIVO" class="form-control search-select">
																<option value="">Selecione...</option>
																<?php 
																	// Lista as marcas
																	$lista = $modelo->get_asset_type();

																	foreach ($lista as $value)
																	{
																		echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group">
															<label class="control-label">
																Forma de aquisição <span class="symbol required"></span>
															</label>
															<select name="ID_FORMA_AQUISICAO" id="ID_FORMA_AQUISICAO" class="form-control search-select">
																<option value="">Selecione...</option>
																<?php 
																	// Lista as marcas
																	$lista = $modelo->get_acquiring_mode();

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
													<div class="col-md-5">
														<div class="form-group">
															<label class="control-label">
																Status do aparelho <span class="symbol required"></span>
															</label>
															<select name="STATUS_APARELHO" id="STATUS_APARELHO" class="form-control search-select">
																<option value="">Selecione...</option>
																<option value="1">Uso</option>
																<option value="2">Estoque</option>
																<option value="3">Inativo</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="table-responsive">
													<table id="table_anexo" class="table table-striped table-bordered table-hover">
														<thead>
															<tr>
																<th style="width: 80%;">Arquivo</th>
																<th style="width: 20%;"></th>
															</tr>
														</thead>
														<tbody id="tableToModify">
															<tr id="rowToClone0" name="rowToClone">
																<td>
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
																					<input type="file" class="file-input" id="file_anexo[]" name="file_anexo[]">
																				</div>
																				<a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
																					<i class="fa fa-times"></i> Remover
																				</a>
																			</div>
																		</div>
																	</div>
																</td>
																<td class="center">
																	<div class="visible-md visible-lg hidden-sm hidden-xs">
																		<a name="btnAddAnexo" onclick="cloneRow(this);" class="btn btn-xs btn-teal" title="Adicionar anexo"><i class="fa fa-plus"></i></a>
																		<a name="btnRemoveAnexo" onclick="deleteRow(this);" class="btn btn-xs btn-bricky" title="Remover anexo"><i class="fa fa-times fa fa-white"></i></a>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="table-responsive">
													<table class="table table-striped table-bordered table-hover" id="table_imei">
														<thead>
															<tr>
																<th id="th_imei">IMEI</th>
																<th id="th_imei">IMEI</th>
																<th id="th_imei">IMEI</th>
																<th id="th_imei">IMEI</th>
																<th id="th_imei">IMEI</th>
															</tr>
														</thead>
														<tbody id="tableToImei">
															<tr>
																<td id="td_imei1" name="td_imei">
																	<div class="form-group">
																		<div class="input-group">
																			<input type="text" placeholder="Informe o IMEI" class="form-control" name="IMEI" maxlength="20" onBlur="updateIMEI('elem_IMEI');" />
																		</div>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
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
													Cadastrar aparelho(s) <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_aparelho" value="1" />
										<input type="hidden" id="elem_IMEI" name="elem_IMEI" value="" />
									</form>
								</div>
							</div>
							<!-- end: FORM VALIDATION 1 PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->

					<script type="text/javascript">

						var qtd_IMEI = 1;
						var status_add = 0;
						var linha_atual = 0;

						/** Function to clone a table TD
						 * @param table_ => table to add IMEI column
						 * @param qtd_ => number of IMEI's to be added
						*/
						function addIMEI( table_, qtd_ )
						{
							/* Check if the current number os IMEI's are lower than the new one */
							if ( qtd_IMEI < qtd_ )
							{
								status_add = 0;
								var aux = (qtd_ - qtd_IMEI);

								/* Check the number of IMEI's to be added */
								for ( var c = 0; c < aux; c++ )
								{
									/* Handle TD body */
									var tblBodyObj = document.getElementById(table_).tBodies[0];

									/* Check if it's necessary create a new line */
									if ( parseInt(qtd_IMEI % 5) == 0 )
									{
										// Get a reference to the table
										var tableRef = document.getElementById(table_);

										// Insert a row in the table at row index 0
										var newRow   = tableRef.insertRow(tblBodyObj.rows.length + 1);

										linha_atual += 1;
									}

									qtd_IMEI = parseInt(qtd_IMEI) + 1;

									var newCell = tblBodyObj.rows[linha_atual].insertCell(-1);
									newCell.setAttribute('id', 'td_imei' + qtd_IMEI);
									newCell.setAttribute('name', 'td_imei');
									newCell.innerHTML = "<div class='form-group'><div class='input-group'><input type='text' placeholder='Informe o IMEI " + qtd_IMEI + "' " + 
														"class='form-control' onBlur='updateIMEI(\"elem_IMEI\");' name='IMEI' maxlength='20' /></div></div>";
								}
							}
							else
							{
								status_add = 0;
							}
						}

						/** Function to delete table TD
						 * @param table_ => table to remove IMEI column
						 * @param qtd_ => number of IMEI's to be removed
						*/
						function deleteIMEI( table_, qtd_ )
						{
							var deleted = 0;

							/* Check if quantity is different from zero */
							if ( qtd_ == 0 )
							{
								alert("Quantidade inválida de IMEI's!");
								return false;
							}

							/* Check if an IMEI's was added before */
							if ( status_add == 0 )
							{
								/* Check if the current number os IMEI's are higher than the new one */
								if ( qtd_IMEI > qtd_ )
								{
									/* Check if it's only one IMEI */
									if ( (qtd_IMEI - qtd_) >= 1 )
									{
										var aux = parseInt(qtd_IMEI - qtd_);
										qtd_IMEI = parseInt(qtd_);

										/* Handle TD object */
										var allRows = document.getElementById(table_).rows;

										/* Delete the necessary quantity of IMEI's */
										for ( var i = allRows.length - 1; i >= 1; i-- )
										{
											if ( allRows[i].cells.length >= 1 )
											{
												for ( var j = allRows[i].cells.length - 1; j >= 0; j-- )
												{
													if ( deleted < aux )
													{
														allRows[i].deleteCell(-1);
														deleted++;
													}
												}
											}
										}

										linha_atual = Math.ceil(qtd_IMEI / 5) - 1;

										/* Update IMEI hidden field */
										updateIMEI("elem_IMEI");
									}
								}
							}
						}

						/** Function to update IMEI array in hidden field
						 * @param elem_ => determine the hidden field
						*/
						function updateIMEI( elem_ )
						{
							/* Get the HTML inputs */
							var field = document.getElementById( elem_.toString() );
							var IMEI = document.getElementsByName("IMEI");

							/* Clear the initial value */
							field.value = "";

							for ( var i = 0; i < IMEI.length; i++ )
							{
								if ( IMEI[i].value != "" )
								{
									if ( i == 0 )
										field.value = IMEI[i].value;
									else
										field.value += "//" + IMEI[i].value;
								}
							}
						}

						/** Function to clone a table row
						 * @param elem_ => element to validate row position
						*/
						function cloneRow( elem_ )
						{
							var listaAnexo = document.getElementsByName("btnAddAnexo");
							var file_anexo = document.getElementsByName("file_anexo");

							for ( var c = 0; c < listaAnexo.length; c++ )
							{
								// Check which element called the function
								if ( listaAnexo[c] == elem_ )
								{
									var row = document.getElementById("rowToClone" + (listaAnexo.length - 1)); // find row to copy
									var table = document.getElementById("tableToModify"); // find table to append to
									var clone = row.cloneNode(true); // copy children too
									clone.id = "rowToClone" + (listaAnexo.length); // change id or other attributes/contents
									table.appendChild(clone); // add new row to end of table
								}
							}
						}

						/** Function to remove a table row
						 * @param elem_ => element to validate row position
						*/
						function deleteRow( elem_ )
						{
							var listaAnexo = document.getElementsByName("btnRemoveAnexo");
							var rowClone = document.getElementsByName("rowToClone");

							// Make sure that at least one field stay
							if ( listaAnexo.length > 1 )
							{
								for ( var c = 0; c < listaAnexo.length; c++ )
								{
									// Check which element called the function
									if ( listaAnexo[c] == elem_ )
									{
										document.getElementById("table_anexo").deleteRow((c+1));
									}

									// Rename all rows
									for (var i = 0; i < rowClone.length; i++)
									{
										rowClone[i].id = "rowToClone" + i;
									}
								}
							}
						}

					</script>