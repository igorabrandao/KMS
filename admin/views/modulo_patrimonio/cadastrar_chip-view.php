							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Chip">Chip <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_chip();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVO CHIP</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir um novo chip.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadChip" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-12">
												<div class="errorHandler alert alert-danger no-display">
													<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
												</div>
												<div class="successHandler alert alert-success no-display">
													<i class="fa fa-ok"></i> Preenchimento correto!
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">
														Contrato da operadora<span class="symbol required"></span>
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
												<div class="form-group">
													<label class="control-label">
														Status do chip<span class="symbol required"></span>
													</label>
													<select name="STATUS_CHIP" id="STATUS_CHIP" class="form-control search-select">
														<option value="">Selecione...</option>
														<option value="1">Branco</option>
														<option value="2">Vinculado</option>
														<option value="3">Subbstituído</option>
													</select>
												</div>
												<div class="form-group">
													<label class="control-label">
														Quantidade de chips <span class="symbol required"></span>
													</label>
													<input type="number" id="QTD_CHIP" name="QTD_CHIP" min="1" max="10000000" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onChange="addchip('table_chip', this.value); deletechip('table_chip', this.value);" />
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
													<table class="table table-striped table-bordered table-hover" id="table_chip">
														<thead>
															<tr>
																<th id="th_chip">CHIP</th>
																<th id="th_chip">CHIP</th>
																<th id="th_chip">CHIP</th>
																<th id="th_chip">CHIP</th>
																<th id="th_chip">CHIP</th>
															</tr>
														</thead>
														<tbody id="tableTochip">
															<tr>
																<td id="td_chip1" name="td_chip">
																	<div class="form-group">
																		<div class="input-group">
																			<input type="text" placeholder="Informe o nº do chip" class="form-control" name="chip" maxlength="30" onBlur="updatechip('elem_chip');" />
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
													Cadastrar chip(s) <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_chip" value="1" />
										<input type="hidden" id="elem_chip" name="elem_chip" value="" />
									</form>
								</div>
							</div>
							<!-- end: FORM VALIDATION 1 PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->

					<script type="text/javascript">

						var qtd_chip = 1;
						var status_add = 0;
						var linha_atual = 0;

						/** Function to clone a table TD
						 * @param table_ => table to add chip column
						 * @param qtd_ => number of chip's to be added
						*/
						function addchip( table_, qtd_ )
						{
							/* Check if the current number of chip's are lower than the new one */
							if ( qtd_chip < qtd_ )
							{
								status_add = 1;
								var aux = (qtd_ - qtd_chip);

								/* Check the number of chip's to be added */
								for ( var c = 0; c < aux; c++ )
								{
									/* Handle TD body */
									var tblBodyObj = document.getElementById(table_).tBodies[0];

									/* Check if it's necessary create a new line */
									if ( parseInt(qtd_chip % 5) == 0 )
									{
										// Get a reference to the table
										var tableRef = document.getElementById(table_);

										// Insert a row in the table at row index 0
										var newRow   = tableRef.insertRow(tblBodyObj.rows.length + 1);

										linha_atual += 1;
									}

									qtd_chip = parseInt(qtd_chip) + 1;

									var newCell = tblBodyObj.rows[linha_atual].insertCell(-1);
									newCell.setAttribute('id', 'td_chip' + qtd_chip);
									newCell.setAttribute('name', 'td_chip');
									newCell.innerHTML = "<div class='form-group'><div class='input-group'><input type='text' placeholder='Informe o nº do chip " + qtd_chip + "' " + 
														"class='form-control' onBlur='updatechip(\"elem_chip\");' name='chip' maxlength='30' /></div></div>";
								}
							}
							else
							{
								status_add = 0;
							}
						}

						/** Function to delete table TD
						 * @param table_ => table to remove chip column
						 * @param qtd_ => number of chip's to be removed
						*/
						function deletechip( table_, qtd_ )
						{
							var deleted = 0;

							/* Check if quantity is different from zero */
							if ( qtd_ == 0 )
							{
								alert("Quantidade inválida de chips");
								return false;
							}

							/* Check if an chip's was added before */
							if ( status_add == 0 )
							{
								/* Check if the current number os chip's are higher than the new one */
								if ( qtd_chip > qtd_ )
								{
									/* Check if it's only one chip */
									if ( (qtd_chip - qtd_) >= 1 )
									{
										var aux = parseInt(qtd_chip - qtd_);
										qtd_chip = parseInt(qtd_);

										/* Handle TD object */
										var allRows = document.getElementById(table_).rows;

										/* Delete the necessary quantity of chip's */
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

										linha_atual = Math.ceil(qtd_chip / 5) - 1;

										/* Update chip hidden field */
										updatechip("elem_chip");
									}
								}
							}
						}

						/** Function to update chip array in hidden field
						 * @param elem_ => determine the hidden field
						*/
						function updatechip( elem_ )
						{
							/* Get the HTML inputs */
							var field = document.getElementById( elem_.toString() );
							var chip = document.getElementsByName("chip");

							/* Clear the initial value */
							field.value = "";

							for ( var i = 0; i < chip.length; i++ )
							{
								if ( chip[i].value != "" )
								{
									if ( i == 0 )
										field.value = chip[i].value;
									else
										field.value += "//" + chip[i].value;
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