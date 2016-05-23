							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Cadastro de Plataforma LD">Cadastro de Plataforma LD <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_tax();
					?>

					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-md-12">
							<div class="col-sm-12">
							<!-- start: FORM WIZARD PANEL -->
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
									<form action="#" role="form" class="smart-wizard form-horizontal" id="frmCadPlataformaLD" method="POST" enctype="multipart/form-data">
										<div id="wizardPlataformaLD" class="swMain">
											<ul>
												<li>
													<a href="#step-1">
														<div class="stepNumber">1</div>
														<span class="stepDesc"> Passo 1<br/>
														<small>Passo 1 - cadastrar plataforma LD</small> </span>
													</a>
												</li>
												<li>
													<a href="#step-2">
														<div class="stepNumber">2</div>
														<span class="stepDesc"> Passo 2<br/>
														<small>Passo 2 - associar tarifa</small> </span>
													</a>
												</li>
											</ul>
											<div class="progress progress-striped active progress-sm">
												<div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-success step-bar">
													<span class="sr-only"> 0% Complete (success)</span>
												</div>
											</div>
											<!-- PASSO 1 -->
											<div id="step-1">
												<h2><i class="fa fa-pencil-square teal"></i> NOVA PLATAFORMA LD</h2>
												<p>
													Preencha as informações do formulário abaixo para inserir uma nova plataforma LD.
												</p>
												<hr>
												<div class="row">
													<div class="col-md-12">
														<div class="errorHandler alert alert-danger no-display">
															<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
														</div>
														<div class="successHandler alert alert-success no-display">
															<i class="fa fa-ok"></i> Preenchimento correto!
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">	
															Operadora <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<select name="ID_OPERADORA" id="ID_OPERADORA" class="form-control search-select" onChange="changeOperadora(this.options[this.selectedIndex].innerHTML); 
															sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/cadastrar_plataformaLD', 'action=update_plataforma_LD&carrier=' + this.value, 'POST', '///', document.getElementById('ID_DEGRAU_LD'), 'fill select' );">
																<option value="">Selecione...</option>
																<?php 
																	// Print the carrier list
																	$lista = $modelo->get_operadora_list();

																	foreach ( $lista as $value )
																	{
																		echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Degrau LD <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<select name="ID_DEGRAU_LD" id="ID_DEGRAU_LD" class="form-control search-select" onChange="changeDegrau(this.options[this.selectedIndex].innerHTML);">
																<option value="">Selecione...</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
														</label>
														<div class="col-sm-7">
															<div class="input-group">
																<span class="symbol required"></span>Campo de preenchimento obrigatório
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 col-sm-offset-0">
														<button class="btn btn-blue next-step btn-block">
															Cadastrar plataforma <i class="fa fa-arrow-circle-right"></i>
														</button>
													</div>
												</div>
												<input type="hidden" name="insere_plataformaLD" value="1" />
											</div>
											<!-- FIM DO PASSO 1 -->

											<!-- PASSO 2 -->
											<div id="step-2">
												<h2><i class="fa fa-pencil-square teal"></i> NOVA TARIFA</h2>
												<p>
													Preencha as informações do formulário abaixo para inserir um novo plano.
												</p>
												<hr>
												<div class="row">
													<div class="col-md-12">
														<div class="errorHandler alert alert-danger no-display">
															<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
														</div>
														<div class="successHandler alert alert-success no-display">
															<i class="fa fa-ok"></i> Preenchimento correto!
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Operadora <span class="symbol required"></span>
														</label>
														<div class="col-sm-7">
															<label id="lblOperadora" class="control-label">
																Identificador da operadora cadastrado no passo anterior
															</label>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Degrau associado <span class="symbol required"></span>
														</label>
														<div class="col-sm-7">
															<label id="lblDegrau" class="control-label">
																Identificador do degrau cadastrado no passo anterior
															</label>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Tipo de tarifa <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<select name="ID_TIPO_TARIFA" id="ID_TIPO_TARIFA" class="form-control search-select" onChange="setTableColumns( this.options[this.selectedIndex].text );" >
																<option value="">Selecione...</option>
																<?php 
																	// List the tax list
																	$lista = $modelo->get_tax_list();

																	foreach ($lista as $value)
																	{
																		echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Subtipo de tarifa <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<select name="ID_SUBTIPO_TARIFA" id="ID_SUBTIPO_TARIFA" class="form-control search-select" >
																<option value="">Selecione...</option>
																<?php 
																	// Lista os usuários
																	$lista = $modelo->get_tax_subtype_list();

																	foreach ($lista as $value)
																	{
																		echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Tarifas
														</label>
														<div class="col-sm-8">
															<div class="table-responsive">
																<table class="table table-striped table-bordered table-hover" id="table_state_taxes" style="display: none;">
																	<thead>
																		<tr>
																			<th style="text-align: center;">
																				<a onClick="deleteAll();" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Limpar tudo"><i class="fa fa-times fa fa-white"></i></a>
																			</th>
																			<th style="text-align: center;">UF</th>
																			<th style="text-align: center;">Móvel</th>
																			<th style="text-align: center;">Fixo</th>
																			<th style="text-align: center;">Intra-rede</th>
																			<th style="text-align: center;">DSL1</th>
																			<th style="text-align: center;">DSL2</th>
																			<th style="text-align: center;">AD</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php

																			// Auxiliary variables
																			$columns_number = 6;

																			// Get the state list to print the taxes fields
																			$state_list = $modelo->get_state_list();

																			// Print the state list
																			foreach ( $state_list as $s_list )
																			{
																				echo "<tr>";

																				// Print the line header
																				echo '<td style="text-align: center;"><a onClick="copyLine(this);" id="btn_reply' . $s_list["UF"] . '" name="btn_reply" class="btn btn-xs btn-dark-grey tooltips" data-placement="top" data-original-title="Replicar ' . $s_list["UF"] . '"><i class="clip-copy-2"></i></a></td>';
																				echo '<td style="text-align: center;" title="' . $s_list["UF"] . '" nowrap>' . $s_list["UF"] . '</td>';

																				// Print each column
																				for ( $i = 0; $i < $columns_number; $i++ )
																				{
																					echo '<td style="text-align: center;"><input type="text" name="TARIFA_ESTADO" class="form-control" style="height: 26px;" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" onBlur="getProvinceTaxes( );"/></td>';
																				}

																				echo "</tr>";
																			}

																		?>
																	</tbody>
																	<tfoot>
																		<tr>
																			<th style="text-align: center;">
																				<a onClick="deleteAll();" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Limpar tudo"><i class="fa fa-times fa fa-white"></i></a>
																			</th>
																			<th style="text-align: center;">UF</th>
																			<th style="text-align: center;">Móvel</th>
																			<th style="text-align: center;">Fixo</th>
																			<th style="text-align: center;">Intra-rede</th>
																			<th style="text-align: center;">DSL1</th>
																			<th style="text-align: center;">DSL2</th>
																			<th style="text-align: center;">AD</th>
																		</tr>
																	</tfoot>
																</table>

																<!-- Hidden fields --> 
																<input type="hidden" id="TARIFA_AC" name="TARIFA_AC" value="" />
																<input type="hidden" id="TARIFA_AL" name="TARIFA_AL" value="" />
																<input type="hidden" id="TARIFA_AP" name="TARIFA_AP" value="" />
																<input type="hidden" id="TARIFA_AM" name="TARIFA_AM" value="" />
																<input type="hidden" id="TARIFA_BA" name="TARIFA_BA" value="" />
																<input type="hidden" id="TARIFA_CE" name="TARIFA_CE" value="" />
																<input type="hidden" id="TARIFA_DF" name="TARIFA_DF" value="" />
																<input type="hidden" id="TARIFA_ES" name="TARIFA_ES" value="" />
																<input type="hidden" id="TARIFA_GO" name="TARIFA_GO" value="" />
																<input type="hidden" id="TARIFA_MA" name="TARIFA_MA" value="" />
																<input type="hidden" id="TARIFA_MT" name="TARIFA_MT" value="" />
																<input type="hidden" id="TARIFA_MS" name="TARIFA_MS" value="" />
																<input type="hidden" id="TARIFA_MG" name="TARIFA_MG" value="" />
																<input type="hidden" id="TARIFA_PA" name="TARIFA_PA" value="" />
																<input type="hidden" id="TARIFA_PB" name="TARIFA_PB" value="" />
																<input type="hidden" id="TARIFA_PR" name="TARIFA_PR" value="" />
																<input type="hidden" id="TARIFA_PE" name="TARIFA_PE" value="" />
																<input type="hidden" id="TARIFA_PI" name="TARIFA_PI" value="" />
																<input type="hidden" id="TARIFA_RJ" name="TARIFA_RJ" value="" />
																<input type="hidden" id="TARIFA_RN" name="TARIFA_RN" value="" />
																<input type="hidden" id="TARIFA_RS" name="TARIFA_RS" value="" />
																<input type="hidden" id="TARIFA_RO" name="TARIFA_RO" value="" />
																<input type="hidden" id="TARIFA_RR" name="TARIFA_RR" value="" />
																<input type="hidden" id="TARIFA_SC" name="TARIFA_SC" value="" />
																<input type="hidden" id="TARIFA_SP" name="TARIFA_SP" value="" />
																<input type="hidden" id="TARIFA_SE" name="TARIFA_SE" value="" />
																<input type="hidden" id="TARIFA_TO" name="TARIFA_TO" value="" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
														</label>
														<div class="col-sm-7">
															<div class="input-group">
																<span class="symbol required"></span>Campo de preenchimento obrigatório
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 col-sm-offset-0">
														<button class="btn btn-blue finish-step btn-block">
															Associar tarifa <i class="fa fa-arrow-circle-right"></i>
														</button>
													</div>
												</div>
												<input type="hidden" name="insere_taxes" value="1" />
											</div>
											<!-- FIM DO PASSO 2 -->

											<?php
												// Load insert method
												$modelo->insert_state_tax();
											?>

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

			var fields_number = 0;

			/** Function to define associated carrier
			 * @param value_ => value to change element view
			*/
			function changeOperadora( value_ )
			{
				var lblOperadora = document.getElementById("lblOperadora");
				lblOperadora.innerHTML = value_;
			}
			
			/** Function to define associated degrau
			 * @param value_ => value to change element view
			*/
			function changeDegrau( value_ )
			{
				var lblDegrau = document.getElementById("lblDegrau");
				lblDegrau.innerHTML = value_;
			}

			/** Function to group province taxes in differents hiddens fields
			 *
			*/
			function getProvinceTaxes( )
			{
				/* Auxiliar variables */
				var ufs = ["AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS",
						   "RO", "RR", "SC", "SP", "SE", "TO"];

				/* Get the HTML inputs */
				var listaTarifas = document.getElementsByName("TARIFA_ESTADO");
				var tbl = document.getElementById('table_state_taxes');

				/* Temporaly element */
				var t_elem;

				// Run all UFS elements
				for ( var i = 1; i < tbl.rows.length - 1; i++ )
				{
					var uf_hidden = document.getElementById("TARIFA_" + tbl.rows[i].cells[1].innerHTML.trim());
					uf_hidden.value = "";

					/* Run through table columns */
					for ( var j = 2; j < (fields_number + 2); j++ )
					{
						//! Get the temporaly element
						t_elem = tbl.rows[i].cells[j].getElementsByTagName('input')[0];

						if ( uf_hidden.value.localeCompare("") == 0 )
							uf_hidden.value += t_elem.value;
						else
							uf_hidden.value += "***" + t_elem.value;
					}
				}
			}

			/** Function hide/show the table columns accordling to the tax type
			 *
			 * @param tax_type_ => tax type VC1/VC2/VC3
			*/
			function setTableColumns( tax_type_ )
			{
				// Get the table itself
				var tbl = document.getElementById('table_state_taxes');
				var rows = tbl.getElementsByTagName('tr');
				var cels;

				// Check if the parameter is valid
				if ( tax_type_.localeCompare("Selecione...") != 0 )
				{
					tbl.style.display = "";

					// Check the tax type
					if ( tax_type_.localeCompare("VC1") == 0 ) // VC1 tax
					{
						// Define array to show and hide
						var array_show = [];
						var array_hide = [5, 6, 7];
						fields_number = 3;
					}
					else // VC2 and VC3
					{
						// Define array to show and hide
						var array_show = [5, 6, 7];
						var array_hide = [];
						fields_number = 6;
					}

					// Run through all the columns to hide
					for ( var i = 0; i < array_hide.length; i++ )
					{
						for ( var row = 0; row < rows.length; row++ )
						{
							cels = rows[row].getElementsByTagName('td')

							if ( cels[array_hide[i]] )
							{
								cels[array_hide[i]].style.display = "none";
							}
							else
							{
								cels = rows[row].getElementsByTagName('th')

								if ( cels[array_hide[i]] )
								{
									cels[array_hide[i]].style.display = "none";
								}
							}
						}
					}

					// Run through all the columns to show
					for ( var i = 0; i < array_show.length; i++ )
					{
						for ( var row = 0; row < rows.length; row++ )
						{
							cels = rows[row].getElementsByTagName('td')

							if ( cels[array_show[i]] )
							{
								cels[array_show[i]].style.display = "";
							}
							else
							{
								cels = rows[row].getElementsByTagName('th')

								if ( cels[array_show[i]] )
								{
									cels[array_show[i]].style.display = "";
								}
							}
						}
					}
				}
				else
				{
					tbl.style.display = "none";
				}
			}

			/** Function to replicate the values from a row to the others
			 *
			 * @param elem_ => element to identify the row position
			*/
			function copyLine( elem_ )
			{
				// Auxiliary variables
				var values = "";

				// Array of elements
				var elem_array = document.getElementsByName(elem_.name);

				// Get the table itself
				var tbl = document.getElementById('table_state_taxes');
				var rows = tbl.getElementsByTagName('tr');
				var cels;

				/* Temporaly element */
				var t_elem;
				var array_values;

				// Run through all elements
				for ( var i = 0; i < elem_array.length; i++ )
				{
					// Check if the calling row
					if ( elem_array[i] == elem_ )
					{
						// Skips the header column
						i += 1;

						/* Run through table columns */
						for ( var j = 2; j < (fields_number + 2); j++ )
						{
							//! Get the temporaly element
							t_elem = tbl.rows[i].cells[j].getElementsByTagName('input')[0];

							// Check if the element exist
							if ( t_elem )
							{
								if ( j == 2 )
									values += t_elem.value;
								else
									values += "***" + t_elem.value;
							}
						}
						break;
					}
				}

				// Check if value is valid
				if ( values.localeCompare("") != 0 )
				{
					// Run through all rows
					for ( var row = 0; row < rows.length; row++ )
					{
						/* Run through table columns */
						for ( var j = 2; j < (fields_number + 2); j++ )
						{
							// Split the values into an arra
							array_values = values.split("***");

							// Get the element to be filles
							t_elem = tbl.rows[row].cells[j].getElementsByTagName('input')[0];

							if ( t_elem )
							{
								// Check if the field has already been filled
								if ( t_elem.value.localeCompare("") == 0 )
									t_elem.value = array_values[(j - 2)];
							}
						}
					}
				}

				// Update the hidden fields
				getProvinceTaxes();
			}

			/** Function to clear all fields
			 *
			*/
			function deleteAll( )
			{
				/* Get the HTML inputs */
				var tbl = document.getElementById('table_state_taxes');

				/* Temporaly element */
				var t_elem;

				// Run all UFS elements
				for ( var i = 1; i < tbl.rows.length - 1; i++ )
				{
					var uf_hidden = document.getElementById("TARIFA_" + tbl.rows[i].cells[1].innerHTML.trim());
					uf_hidden.value = "";

					/* Run through table columns */
					for ( var j = 2; j < (fields_number + 2); j++ )
					{
						//! Get the temporaly element
						t_elem = tbl.rows[i].cells[j].getElementsByTagName('input')[0];

						// Clear all the fields
						t_elem.value = "";
					}
				}

				// Update the hidden fields
				getProvinceTaxes();
			}

		</script>