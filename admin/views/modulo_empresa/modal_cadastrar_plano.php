<!-- start: BOOTSTRAP EXTENDED MODALS -->
<div id="modal_plano" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			&times;
		</button>
		<h4 class="modal-title">Adicionar plano</h4>
	</div>

	<?php
		// Load insert method
		//$modelo->insert_plano();
	?>

	<form action="#" role="form" id="frmCadPlano" method="POST" enctype="multipart/form-data">
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<!-- start: FORM VALIDATION 1 PANEL -->
					<div class="panel panel-default">
						<div class="panel-body">
							<h2><i class="fa fa-pencil-square teal"></i> NOVO PLANO</h2>
							<p>
								Preencha as informações do formulário abaixo para inserir um novo plano.
							</p>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<div id="div_err" class="errorHandler alert alert-danger" style="display: none;">
										<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
									</div>
									<div id="div_success" class="successHandler alert alert-success" style="display: none;">
										<i class="fa fa-ok"></i> Preenchimento correto!
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">
											Book <span class="symbol required"></span>
										</label>
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
									<div class="form-group">
										<label class="control-label">
											Tipo de plano <span class="symbol required"></span>
										</label>
										<select name="TIPO_PLANO" id="TIPO_PLANO" class="form-control search-select" >
											<option value="">Selecione...</option>
											<option value="1">Plano flexível</option>
											<option value="2">Plano pronto</option>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label">
											Descritivo do plano <span class="symbol required"></span>
										</label>
										<input placeholder="Informe o descritivo" id="DESCRITIVO_PLANO" name="DESCRITIVO_PLANO" type="text" class="form-control" maxlength="100" />
									</div>
									<div class="form-group">
										<label class="control-label">
											Plataforma LD
										</label>
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
									<div class="form-group">
										<label class="control-label">
											Tarifas
										</label>
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
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">
													Valor da assinatura
												</label>
												<input type="text" name="VALOR_ASSINATURA" id="VALOR_ASSINATURA" class="form-control" maxlength="15" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">
													Valor da franquia
												</label>
												<input type="text" name="VALOR_FRANQUIA" id="VALOR_FRANQUIA" class="form-control currency" maxlength="15" onblur="calculateTotal( this.value, document.getElementById('QTD_LINHAS').value, document.getElementById('VALOR_ASSINATURA').value, 'VALOR_TOTAL' ); calculateFranquia( 'VALOR_FRANQUIA' );">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">
													Franquia em minutos
												</label>
												<input type="text" name="FRANQUIA_MINUTOS" id="FRANQUIA_MINUTOS" class="form-control" maxlength="15" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onblur="calculateFranquia( 'FRANQUIA_MINUTOS' );" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">
													Tipo de franquia
												</label>
												<select name="TIPO_FRANQUIA" id="TIPO_FRANQUIA" class="form-control search-select" >
													<option value="">Selecione...</option>
													<option value="1">Franquia compartilhada</option>
													<option value="2">Franquia individual</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">
													Quantidade de linhas
												</label>
												<input type="number" id="QTD_LINHAS" name="QTD_LINHAS" min="1" max="10000000" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onblur="calculateTotal( this.value, document.getElementById('VALOR_FRANQUIA').value, document.getElementById('VALOR_ASSINATURA').value, 'VALOR_TOTAL' );" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">
													Valor total
												</label>
												<input type="text" name="VALOR_TOTAL" id="VALOR_TOTAL" class="form-control" readonly />
											</div>
										</div>
									</div>
								</div>
							</div>
							<input type="hidden" id="TARIFA" name="TARIFA" value="" />
							<input type="hidden" id="TARIFA_EXCEDENTE" name="TARIFA_EXCEDENTE" value="" />
							<input type="hidden" id="VALOR_FRANQUIA_MEDIA" name="VALOR_FRANQUIA_MEDIA" value="0" />
						</div>
					</div>
					<!-- end: FORM VALIDATION 1 PANEL -->
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-light-grey">
				Fechar
			</button>
			<button type="button" class="btn btn-blue" onClick="bValida();">
				Adicionar plano <i class="fa fa-arrow-circle-right"></i>
			</button>
		</div>
	</form>
</div>
<!-- end: MODAL -->

<script type="text/javascript">

	/** Function to validate form
	*/
	function bValida()
	{
		var qtd_err = 0;
		var form = document.getElementById("frmCadPlano");
        var errorHandler1 = document.getElementById("div_err");
        var successHandler1 = document.getElementById("div_success");

		// Custom validation
		if ( document.getElementById("ID_BOOK").value == "" )
		{
			alert("Informe o ID do book");
			qtd_err += 1;
			document.getElementById("ID_BOOK").focus();
		}
		else if ( document.getElementById("TIPO_PLANO").value == "" )
		{
			alert("Informe o tipo de plano");
			qtd_err += 1;
			document.getElementById("TIPO_PLANO").focus();
		}
		else if ( document.getElementById("DESCRITIVO_PLANO").value == "" )
		{
			alert("Informe o descritivo do plano");
			qtd_err += 1;
			document.getElementById("DESCRITIVO_PLANO").focus();
		}

		// Check form status
		if ( qtd_err > 0 )
		{
			successHandler1.style.display = "none";
			errorHandler1.style.display = "block";
			return false;
		}
		else
		{
			successHandler1.style.display = "block";
			errorHandler1.style.display = "none";
			insertPlan( form );
		}
	}

	/** Function to multiply values onblur
	 * @param a_ => field a
	 * @param b_ => field b
	 * @param elem_ => field that'll receive result
	*/
	function multiplication( a_, b_, elem_ )
	{
		var elemento = document.getElementById(elem_);

		if ( !isNaN(a_) && a_ != "" && !isNaN(b_) && b_ != "" )
			elemento.value = ( a_ * b_ ).toFixed(2);
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

	/** Function to insert 
	 * @param form_ => form with information to be submited
	*/
	function insertPlan( form_ )
	{
		// URI to call process layer
		var HOME_URI = document.getElementById("HOME_URI").value;
		HOME_URI += '/modulo_empresa/cadastrar_contratooperadora';
		HOME_URI += "?action=insert_plan";
		var operadora = document.getElementById("ID_OPERADORA").value;

		// Data that will be sent
		var data = $("#frmCadPlano").serialize();
		data += "&elem_DDD=" + encodeURIComponent( document.getElementById("elem_DDD").value );

		// Insert contract data on database
		$.ajax({
			url: HOME_URI, // form action url
			type: 'POST', // form submit method get/post
			dataType: 'html', // request type html/json/xml
			data: data, // serialize form data 
			success: function( retorno ) {
				$('#modal_plano').modal('hide'); // Modal close
				updateCarrierPlanList( operadora ); // Update combo plans
			}
		});
	}

</script>