							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Contrato com a Aires">Contrato com a Aires <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_contrato();
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
									<h2><i class="fa fa-pencil-square teal"></i> NOVO CONTRATO</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir um novo contrato.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadContratoAires" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
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
													<div class="col-md-12">
														<div class="form-group">
															<label for="form-field-mask-2">
																Empresa <span class="symbol required"></span>
															</label>
															<select name="ID_EMPRESA" id="ID_EMPRESA" class="form-control search-select" >
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
													<div class="col-md-6">
														<div class="form-group">
															<label for="form-field-mask-2">
																Data de início do contrato <small class="text-warning">99-99-9999</small>&nbsp;<span class="symbol required"></span>
															</label>
															<div class="input-group">
																<input type="text" id="DATA_INICIO_CONTRATO" name="DATA_INICIO_CONTRATO" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" maxlength="10" />
															</div>
														</div>
													</div>
												</div>

												<!-- Proposta -->
												<div class="row">
													<div class="col-md-12">
														<label for="form-field-mask-2">
															Proposta <span class="symbol required"></span>
														</label>
														<table id="table_negociacao_estimada" class="table table-striped table-bordered table-hover">
															<thead>
																<tr>
																	<th style="width: 20%; text-align: center;">Gasto mensal (R$)</th>
																	<th style="width: 20%; text-align: center;">Redução mensal (R$)</th>
																	<th style="width: 20%; text-align: center;">Redução mensal (%)</th>
																	<th style="width: 20%; text-align: center;">Redução anual (R$)</th>
																	<th style="width: 20%; text-align: center;">Redução anual (%)</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>
																		<div class="form-group">
																			<input type="text" id="GASTO_MENSAL_ESTIMADO" name="GASTO_MENSAL_ESTIMADO" class="form-control" maxlength="15" onblur="document.getElementById('GASTO_MENSAL_FINAL').value = this.value; propose_estimate( 'proposta' );"/>
																		</div>
																	</td>
																	<td>
																		<div class="form-group">
																			<input type="text" id="REDUCAO_MENSAL_ESTIMADA" name="REDUCAO_MENSAL_ESTIMADA" class="form-control" maxlength="15" onblur="propose_estimate( 'proposta' );"/>
																		</div>
																	</td>
																	<td>
																		<div class="form-group">
																			<input type="text" id="REDUCAO_MENSAL_ESTIMADA_PERCENTUAL" name="REDUCAO_MENSAL_ESTIMADA_PERCENTUAL" class="form-control" maxlength="6" readonly="readonly"/>
																		</div>
																	</td>
																	<td>
																		<div class="form-group">
																			<input type="text" id="REDUCAO_ANUAL_ESTIMADA" name="REDUCAO_ANUAL_ESTIMADA" class="form-control" maxlength="15" readonly="readonly"/>
																		</div>
																	</td>
																	<td>
																		<div class="form-group">
																			<input type="text" id="REDUCAO_ANUAL_ESTIMADA_PERCENTUAL" name="REDUCAO_ANUAL_ESTIMADA_PERCENTUAL" class="form-control" maxlength="6" readonly="readonly"/>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>

												<!-- Negociação final -->
												<div class="row">
													<div class="col-md-12">
														<label for="form-field-mask-2">
															Negociação final
														</label>
														<table id="table_negociacao_final" class="table table-striped table-bordered table-hover">
															<thead>
																<tr>
																	<th style="width: 20%; text-align: center;">Gasto mensal (R$)</th>
																	<th style="width: 20%; text-align: center;">Redução mensal (R$)</th>
																	<th style="width: 20%; text-align: center;">Redução mensal (%)</th>
																	<th style="width: 20%; text-align: center;">Redução anual (R$)</th>
																	<th style="width: 20%; text-align: center;">Redução anual (%)</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>
																		<div class="form-group">
																			<input type="text" id="GASTO_MENSAL_FINAL" name="GASTO_MENSAL_FINAL" class="form-control" maxlength="15" onblur="real_multiplication( document.getElementById('QTD_LINHA_ATIVA').value, this.value, 'VALOR_TOTAL_LINHA_ATIVA' ); propose_estimate( 'final' );"/>
																		</div>
																	</td>
																	<td>
																		<div class="form-group">
																			<input type="text" id="REDUCAO_MENSAL_FINAL" name="REDUCAO_MENSAL_FINAL" class="form-control" maxlength="15" onblur="real_multiplication( document.getElementById('QTD_LINHA_ATIVA').value, this.value, 'VALOR_TOTAL_LINHA_ATIVA' ); propose_estimate( 'final' );"/>
																		</div>
																	</td>
																	<td>
																		<div class="form-group">
																			<input type="text" id="REDUCAO_MENSAL_PERCENTUAL_FINAL" name="REDUCAO_MENSAL_PERCENTUAL_FINAL" class="form-control" maxlength="6" readonly="readonly"/>
																		</div>
																	</td>
																	<td>
																		<div class="form-group">
																			<input type="text" id="REDUCAO_ANUAL_FINAL" name="REDUCAO_ANUAL_FINAL" class="form-control" maxlength="15" readonly="readonly"/>
																		</div>
																	</td>
																	<td>
																		<div class="form-group">
																			<input type="text" id="REDUCAO_ANUAL_PERCENTUAL_FINAL" name="REDUCAO_ANUAL_PERCENTUAL_FINAL" class="form-control" maxlength="6" readonly="readonly"/>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>

												<div class="row">
													<div class="col-md-5">
														<div class="form-group">
															<label for="form-field-mask-2">
																Percentual negociado  <small class="text-warning">(%)</small>&nbsp;<span class="symbol required"></span>
															</label>
															<div class="input-group">
																<input type="text" id="PERCENTUAL_NEGOCIACAO" name="PERCENTUAL_NEGOCIACAO" class="form-control currency" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="6" />
															</div>
														</div>
													</div>
												</div>

												<div class="form-group connected-group">
													<label class="control-label">
														Linhas ativas <span class="symbol required"></span>
													</label>
													<div class="row">
														<div class="col-md-2">
															<input type="text" placeholder="Qtd" id="QTD_LINHA_ATIVA" name="QTD_LINHA_ATIVA" class="form-control" maxlength="5" onblur="real_multiplication( this.value, document.getElementById('VALOR_LINHA_ATIVA').value, 'VALOR_TOTAL_LINHA_ATIVA' );"/>
														</div>
														<div class="col-md-2">
															<input type="text" placeholder="Vl. Unit" id="VALOR_LINHA_ATIVA" name="VALOR_LINHA_ATIVA" class="form-control currency" maxlength="10" onblur="real_multiplication( document.getElementById('QTD_LINHA_ATIVA').value, this.value, 'VALOR_TOTAL_LINHA_ATIVA' );"/>
														</div>
														<div class="col-md-2">
															<input type="text" placeholder="Vl. Total" id="VALOR_TOTAL_LINHA_ATIVA" name="VALOR_TOTAL_LINHA_ATIVA" class="form-control" readonly />
														</div>
													</div>
												</div>
												<div class="form-group connected-group">
													<label class="control-label">
														Linhas inativas
													</label>
													<div class="row">
														<div class="col-md-2">
															<input type="text" placeholder="Qtd" id="QTD_LINHA_INATIVA" name="QTD_LINHA_INATIVA" class="form-control" maxlength="5" onblur="real_multiplication( this.value, document.getElementById('VALOR_LINHA_INATIVA').value, 'VALOR_TOTAL_LINHA_INATIVA' );"/>
														</div>
														<div class="col-md-2">
															<input type="text" placeholder="Vl. Unit" id="VALOR_LINHA_INATIVA" name="VALOR_LINHA_INATIVA" class="form-control currency" maxlength="10" onblur="real_multiplication( document.getElementById('QTD_LINHA_INATIVA').value, this.value, 'VALOR_TOTAL_LINHA_INATIVA' );"/>
														</div>
														<div class="col-md-2">
															<input type="text" placeholder="Vl. Total" id="VALOR_TOTAL_LINHA_INATIVA" name="VALOR_TOTAL_LINHA_INATIVA" class="form-control" readonly />
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label">
														Operadoras <span class="symbol required"></span>
													</label>
													<div class="row">
														<div class="col-md-2">
															<div class="table-responsive">
																<!-- Gerar caixas de check de acordo com as operadoras do banco de dados -->
																<table class="table table-striped table-bordered table-hover" id="sample-table-2">
																	<tbody>
																		<?php 
																			// List operadoras
																			$operadora_coluna = 5;
																			$i = 0;
																			$lista = $modelo->get_operadora_list();

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
																				echo "<input type='checkbox' class='square-grey' id='chk_" . $value[0] . "' name='chk_operadora'>";
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
													<input type="hidden" id="OPERADORA" name="OPERADORA" value="" />
												</div>
												<div class="form-group connected-group">
													<label class="control-label">
														Anexos
													</label>
													<div class="row">
														<div class="col-md-12">
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
													Cadastrar contrato Aires <i class="fa fa-arrow-circle-right"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="insere_contratoaires" value="1" />
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

			/** Function to fill the proposal
			 * @param type_ => indicates if it's the proposal or the final negotiation
			*/
			function propose_estimate( type_ )
			{
				var gasto_mensal = document.getElementById("GASTO_MENSAL_ESTIMADO").value.replace('R$','');
				var reducao_mensal = document.getElementById("REDUCAO_MENSAL_ESTIMADA").value.replace('R$','');
				gasto_mensal = converteMoedaFloat(gasto_mensal);
				reducao_mensal = converteMoedaFloat(reducao_mensal);
				
				var gasto_mensal_final = document.getElementById("GASTO_MENSAL_FINAL").value.replace('R$','');
				var reducao_mensal_final = document.getElementById("REDUCAO_MENSAL_FINAL").value.replace('R$','');
				gasto_mensal_final = converteMoedaFloat(gasto_mensal_final);
				reducao_mensal_final = converteMoedaFloat(reducao_mensal_final);

				// Check if values are consistent
				if ( gasto_mensal < reducao_mensal )
				{
					alert("A redução mensal não pode exceder o gasto.");
					if ( type_ == "proposta" )
					{
						document.getElementById("GASTO_MENSAL_ESTIMADO").value = "";
						document.getElementById("REDUCAO_MENSAL_ESTIMADA").value = "";
						document.getElementById("REDUCAO_MENSAL_ESTIMADA_PERCENTUAL").value = "";
						document.getElementById("REDUCAO_ANUAL_ESTIMADA").value = "";
						document.getElementById("REDUCAO_ANUAL_ESTIMADA_PERCENTUAL").value = "";
						document.getElementById("GASTO_MENSAL_ESTIMADO").focus();
					}
					else
					{
						document.getElementById("GASTO_MENSAL_FINAL").value = "";
						document.getElementById("REDUCAO_MENSAL_FINAL").value = "";
						document.getElementById("REDUCAO_MENSAL_PERCENTUAL_FINAL").value = "";
						document.getElementById("REDUCAO_ANUAL_FINAL").value = "";
						document.getElementById("REDUCAO_ANUAL_PERCENTUAL_FINAL").value = "";
						document.getElementById("GASTO_MENSAL_FINAL").focus();
					}
				}
				// Check if both values was filled
				else if ( !isNaN(gasto_mensal) && !isNaN(reducao_mensal) && gasto_mensal != "" && reducao_mensal != "" )
				{
					if ( type_ == "proposta" )
					{
						document.getElementById("REDUCAO_MENSAL_ESTIMADA_PERCENTUAL").value = (( reducao_mensal/gasto_mensal ) * 100).toFixed(2);
						document.getElementById("REDUCAO_ANUAL_ESTIMADA").value = ( reducao_mensal * 12 ).toFixed(2);
						document.getElementById("REDUCAO_ANUAL_ESTIMADA_PERCENTUAL").value = (( (reducao_mensal * 12)/(gasto_mensal * 12) ) * 100).toFixed(2);
					}
					else
					{
						document.getElementById("REDUCAO_MENSAL_PERCENTUAL_FINAL").value = (( reducao_mensal_final/gasto_mensal_final ) * 100).toFixed(2);
						document.getElementById("REDUCAO_ANUAL_FINAL").value = ( reducao_mensal_final * 12 ).toFixed(2);
						document.getElementById("REDUCAO_ANUAL_PERCENTUAL_FINAL").value = (( (reducao_mensal_final * 12)/(gasto_mensal_final * 12) ) * 100).toFixed(2);
					}
				}
			}

		</script>