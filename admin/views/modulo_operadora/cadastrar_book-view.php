							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Cadastro de Book">Cadastro de Book <small>cadastro </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->insert_book();
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
									<form action="#" role="form" class="smart-wizard form-horizontal" id="frmCadBook" method="POST" enctype="multipart/form-data">
										<div id="wizardBook" class="swMain">
											<ul>
												<li>
													<a href="#step-1">
														<div class="stepNumber">1</div>
														<span class="stepDesc"> Passo 1<br/>
														<small>Passo 1 - cadastrar book</small> </span>
													</a>
												</li>
												<li>
													<a href="#step-2">
														<div class="stepNumber">2</div>
														<span class="stepDesc"> Passo 2<br/>
														<small>Passo 2 - cadastrar plano</small> </span>
													</a>
												</li>
												<li>
													<a href="#step-3">
														<div class="stepNumber">3</div>
														<span class="stepDesc"> Passo 3<br/>
														<small>Passo 3 - cadastrar módulo</small> </span>
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
												<h2><i class="fa fa-pencil-square teal"></i> NOVO BOOK</h2>
												<p>
													Preencha as informações do formulário abaixo para inserir um novo book.
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
															<select name="ID_OPERADORA" id="ID_OPERADORA" class="form-control search-select" >
																<option value="">Selecione...</option>
																<?php 
																	// Lista os usuários
																	$lista = $modelo->get_operadora_list();

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
															Período de validade <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<input placeholder="Informe o período de validade" id="PERIODO_VALIDADE" name="PERIODO_VALIDADE" type="text" class="form-control date-range">
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
															Cadastrar book <i class="fa fa-arrow-circle-right"></i>
														</button>
													</div>
												</div>
												<input type="hidden" name="insere_book" value="1" />
											</div>
											<!-- FIM DO PASSO 1 -->

											<!-- PASSO 2 -->
											<div id="step-2">
												<h2><i class="fa fa-pencil-square teal"></i> Novo Plano</h2>
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
															Book <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<select name="ID_BOOK" id="ID_BOOK" class="form-control search-select" >
																<option value="">Selecione...</option>
																<?php
																	// Lista os usuários
																	$lista = $modelo->get_book_list();

																	foreach ($lista as $value)
																	{
																		echo "<option value='" . $value[0] . "'>" . $value[1] . " (" . $value[2] . ")</option>";
																	}
																?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Tipo de plano <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<select name="TIPO_PLANO" id="TIPO_PLANO" class="form-control search-select" >
																<option value="">Selecione...</option>
																<option value="1">Plano flexível</option>
																<option value="2">Plano pronto</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Descritivo do plano <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<input placeholder="Informe o descritivo" id="DESCRITIVO_PLANO" name="DESCRITIVO_PLANO" type="text" class="form-control" maxlength="100">
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Plataforma LD
														</label>
														<div class="col-sm-3">
															<select name="ID_PLATAFORMA_LD" id="ID_PLATAFORMA_LD" class="form-control search-select" >
																<option value="">Selecione...</option>
																<?php
																	// Lista os usuários
																	$lista = $modelo->get_plataformaLD_list();

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
														<div class="col-sm-4">
															<div class="table-responsive">
																<table class="table table-striped table-bordered table-hover" id="sample-table-2">
																	<thead>
																		<tr>
																			<th style="text-align: center;">Referência</th>
																			<th style="text-align: center;">Móvel</th>
																			<th style="text-align: center;">Fixo</th>
																			<th style="text-align: center;">Intra-rede</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td style="text-align: center;" nowrap>Tarifa</td>
																			<td style="text-align: center;"><input type="text" name="elem_TARIFA" class="form-control" style="height: 26px;" maxlength="10" onBlur="updateTax('elem_TARIFA', 'TARIFA'); calculateFranquia( 'VALOR_FRANQUIA_MEDIA' );"/></td>
																			<td style="text-align: center;"><input type="text" name="elem_TARIFA" class="form-control" style="height: 26px;" maxlength="10" onBlur="updateTax('elem_TARIFA', 'TARIFA'); calculateFranquia( 'VALOR_FRANQUIA_MEDIA' );"/></td>
																			<td style="text-align: center;"><input type="text" name="elem_TARIFA" class="form-control" style="height: 26px;" maxlength="10" onBlur="updateTax('elem_TARIFA', 'TARIFA'); calculateFranquia( 'VALOR_FRANQUIA_MEDIA' );"/></td>
																		</tr>
																		<tr>
																			<td style="text-align: center;" nowrap>Excedente</td>
																			<td style="text-align: center;"><input type="text" name="elem_TARIFA_EXCEDENTE" class="form-control" style="height: 26px;" maxlength="10" onBlur="updateTax('elem_TARIFA_EXCEDENTE', 'TARIFA_EXCEDENTE');"/></td>
																			<td style="text-align: center;"><input type="text" name="elem_TARIFA_EXCEDENTE" class="form-control" style="height: 26px;" maxlength="10" onBlur="updateTax('elem_TARIFA_EXCEDENTE', 'TARIFA_EXCEDENTE');"/></td>
																			<td style="text-align: center;"><input type="text" name="elem_TARIFA_EXCEDENTE" class="form-control" style="height: 26px;" maxlength="10" onBlur="updateTax('elem_TARIFA_EXCEDENTE', 'TARIFA_EXCEDENTE');"/></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Valor da assinatura
														</label>
														<div class="col-sm-2">
															<input type="text" name="VALOR_ASSINATURA" id="VALOR_ASSINATURA" class="form-control" maxlength="15" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Valor da franquia
														</label>
														<div class="col-sm-2">
															<input type="text" name="VALOR_FRANQUIA" id="VALOR_FRANQUIA" class="form-control currency" maxlength="15" onblur="calculateTotal( this.value, document.getElementById('QTD_LINHAS').value, document.getElementById('VALOR_ASSINATURA').value, 'VALOR_TOTAL' ); calculateFranquia( 'VALOR_FRANQUIA' );">
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Franquia em minutos
														</label>
														<div class="col-sm-2">
															<input type="text" name="FRANQUIA_MINUTOS" id="FRANQUIA_MINUTOS" class="form-control" maxlength="15" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onblur="calculateFranquia( 'FRANQUIA_MINUTOS' );" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Tipo de franquia
														</label>
														<div class="col-sm-2">
															<select name="TIPO_FRANQUIA" id="TIPO_FRANQUIA" class="form-control search-select" >
																<option value="">Selecione...</option>
																<option value="1">Franquia compartilhada</option>
																<option value="2">Franquia individual</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Quantidade de linhas
														</label>
														<div class="col-sm-2">
															<input type="number" id="QTD_LINHAS" name="QTD_LINHAS" min="1" max="10000000" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onblur="calculateTotal( this.value, document.getElementById('VALOR_FRANQUIA').value, document.getElementById('VALOR_ASSINATURA').value, 'VALOR_TOTAL' );" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Valor total
														</label>
														<div class="col-sm-2">
															<input type="text" name="VALOR_TOTAL" id="VALOR_TOTAL" class="form-control" readonly />
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
															Cadastrar plano <i class="fa fa-arrow-circle-right"></i>
														</button>
													</div>
												</div>
												<input type="hidden" name="insere_plano" value="1" />
												<input type="hidden" id="TARIFA" name="TARIFA" value="" />
												<input type="hidden" id="TARIFA_EXCEDENTE" name="TARIFA_EXCEDENTE" value="" />
												<input type="hidden" id="VALOR_FRANQUIA_MEDIA" name="VALOR_FRANQUIA_MEDIA" value="0" />
											</div>
											<!-- FIM DO PASSO 2 -->

											<?php
												// Load insert method
												$modelo->insert_plano();
											?>

											<!-- PASSO 3 -->
											<div id="step-3">
												<h2><i class="fa fa-pencil-square teal"></i> NOVO BOOK</h2>
												<p>Preencha as informações do formulário abaixo para inserir um novo book.</p><hr>
												<div class="row">
													<?php
														// Lista os campos
														$lista = $modelo->get_field_list();
														$fields = "";

														foreach ($lista as $value)
														{
															$fields .= $value[1] . "//"; 
														}
													?>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															Descritivo do módulo <span class="symbol required"></span>
														</label>
														<div class="col-sm-3">
															<select name="ID_MODULO" id="ID_MODULO" class="form-control search-select" onChange="customizeField( this.options[this.selectedIndex].getAttribute('choice') );" >
																<option value="">Selecione...</option>
																<?php
																	// Lista os usuários
																	$lista = $modelo->get_module_list();

																	foreach ($lista as $value)
																	{
																		echo "<option choice='" . $value[2] . "' value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>
														</div>
													</div>
													<!-- It changes dynamically -->
													<span id="dynamic_field" />
												</div>
												<div class="form-group">
													<div class="col-sm-3 col-sm-offset-0">
														<button class="btn btn-blue finish-step btn-block" onClick="updateValues( 'DYNAMIC_FIELDS', 'VALOR_CAMPOS' );">
															Cadastrar módulo <i class="fa fa-arrow-circle-right"></i>
														</button>
													</div>
												</div>
												<input type="hidden" id="elem_CAMPOS" name="elem_CAMPOS" value="<?php echo $fields; ?>" />
												<input type="hidden" id="VALOR_CAMPOS" name="VALOR_CAMPOS" value="" />
												<input type="hidden" name="insere_modulo" value="1" />
											</div>

											<?php
												// Load insert method
												$modelo->insert_module();
											?>

											<!-- FIM DO PASSO 3 -->
										</div>
										<input type="hidden" id="elem_step" name="elem_step" value="1"/>
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

			/** Function to customize field according to the choice
			 * @param choice_ => binary value that determines wich field will be displayed
			*/
			function customizeField( choice_ )
			{
				// Get fields value
				var campos = document.getElementById("elem_CAMPOS").value.split("//");
				var dynamic_field = document.getElementById("dynamic_field");
				dynamic_field.innerHTML = ""

				// List fields accordingly to the choice
				for ( var i = 0; i < campos.length; i++ )
				{
					// Check the choice
					if ( choice_.charAt(i) != null && parseInt( choice_.charAt(i) ) == 1 )
					{
						dynamic_field.innerHTML += "<div class='form-group'><label class='col-sm-3 control-label'>" +
							campos[i] + " <span class='symbol required'></span></label>" +
							"<div class='col-sm-3'><input placeholder='" + campos[i] + "' name='DYNAMIC_FIELDS'" +
							"type='text' class='form-control' maxlength='30'></div></div>";
					}
				}
			}

			/** Function to update value array in hidden field
			 * @param fieldname_ => determine the field array name
			 * @param elem_ => determine the hidden field
			*/
			function updateValues( fieldname_, elem_ )
			{
				/* Get the HTML inputs */
				var hid = document.getElementById( elem_.toString() );
				var field = document.getElementsByName(fieldname_);

				/* Clear the initial value */
				hid.value = "";

				for ( var i = 0; i < field.length; i++ )
				{
					if ( field[i].value != "" )
					{
						if ( i == 0 )
							hid.value = field[i].value;
						else
							hid.value += "//" + field[i].value;
					}
				}
			}

			/** Function to multiply values onblur
			 * @param a_ => field a
			 * @param b_ => field b
			 * @param c_ => field c
			 * @param elem_ => field that'll receive result
			*/
			function calculateTotal( a_, b_, c_, elem_ )
			{
				var elemento = document.getElementById(elem_);

				if ( !isNaN(a_) && a_ != "" && !isNaN(b_) && b_ != "" )
				{
					elemento.value = ( a_ * b_ ).toFixed(2);
					c_ = parseFloat( c_.replace(",", ".") );

					if ( !isNaN(elemento.value) && elemento.value != "" && !isNaN(c_) && c_ != "" )
					{
						elemento.value = ( parseFloat(elemento.value) + parseFloat(c_) ).toFixed(2);
					}
				}
				else
					elemento.value = "";
			}

			/** Function to update tax array in hidden field
			 * @param fieldname_ => determine the field array name
			 * @param elem_ => determine the hidden field
			*/
			function updateTax( fieldname_, elem_ )
			{
				/* Get the HTML inputs */
				var hid = document.getElementById( elem_.toString() );
				var field = document.getElementsByName(fieldname_);
				var avgTax = 0.00;

				/* Clear the initial value */
				hid.value = "";

				for ( var i = 0; i < field.length; i++ )
				{
					if ( field[i].value != "" )
					{
						if ( i == 0 )
							hid.value = field[i].value;
						else
							hid.value += "//" + field[i].value;

						var values = field[i].value.split(",");
						var v1 = parseFloat(values[0].replace(/\D/g,''));
						var v2 = parseFloat(values[1].replace(/\D/g,''));

						avgTax += parseFloat( v1 + "." + v2 );
					}
				}

				// Check if it's necessary to calculate the average tax
				if ( elem_ == "TARIFA" )
				{
					document.getElementById("VALOR_FRANQUIA_MEDIA").value = ( avgTax / field.length ).toFixed( 2 );
				}
			}

			/** Function to calculate franquia value's
			* @param elem_ => element that calls the action
			*/
			function calculateFranquia( elem_ )
			{
				var avgTax = document.getElementById("VALOR_FRANQUIA_MEDIA");
				var valorFranquia = document.getElementById("VALOR_FRANQUIA");
				var franquiaMinutos = document.getElementById("FRANQUIA_MINUTOS");

				// Verify wich field is filled
				if ( avgTax.value != "" && valorFranquia.value != "" && elem_ != "FRANQUIA_MINUTOS" )
				{
					franquiaMinutos.value = ( valorFranquia.value / avgTax.value ).toFixed( 2 );
				}
				else if ( avgTax.value != "" && franquiaMinutos.value != "" && elem_ != "VALOR_FRANQUIA" )
				{
					valorFranquia.value = ( avgTax.value * franquiaMinutos.value ).toFixed( 2 );
				}
			}

		</script>