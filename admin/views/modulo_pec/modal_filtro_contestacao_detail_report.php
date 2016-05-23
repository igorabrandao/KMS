<!-- start: BOOTSTRAP EXTENDED MODALS -->
<div id="modal_filtro" class="modal fade" tabindex="-1" data-width="500" style="display: block;">
	<div class="modal-header">
		<button type="button" id="btn_close" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Filtro de Acessos</h4>
	</div>
	<div class="modal-body">

		<!-- start: PAGE CONTENT -->
		<div class="row">
			<div class="col-md-12">
				<!-- start: FORM VALIDATION 1 PANEL -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-external-link-square"></i>
					</div>
					<div class="panel-body">
						<h2><i class="fa fa-pencil-square teal"></i> FILTRAR ACESSOS</h2>
						<p>Utilize os campos abaixos para filtras as acessos a  serem contestadas ou validadas.</p>
						<hr>
						<form action="#" role="form" id="frmFiltroLinhas" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="SELECT_ACESSOS">
											Acesso(s):
										</label>
										<select id="SELECT_ACESSOS" multiple="multiple" class="form-control search-select" placeholder="Selecione o(s) acesso(s)">
											<option value="">Selecione...</option>
											<?php 
												$phone_list = array_values(array_unique($phone_list));

												for ( $i = 0; $i < sizeof($phone_list); $i++ )
												{
													if ( strcmp(trim($phone_list[$i]), "") != 0 )
														echo "<option value='" . $phone_list[$i] . "'>" . $phone_list[$i] . "</option>";
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="SELECT_TARIFA">
											Tipo de tarifa:
										</label>
										<select id="SELECT_TARIFA" class="form-control search-select" placeholder="Selecione o tipo de tarifa">
											<option value="">Selecione...</option>
											<?php 
												$tax_type = array_values(array_unique($tax_type));

												for ( $i = 0; $i < sizeof($tax_type); $i++ )
												{
													if ( strcmp(trim($tax_type[$i]), "") != 0 )
														echo "<option value='" . $tax_type[$i] . "'>" . $tax_type[$i] . "</option>";
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="DDD_LOCALIDADE">
											DDD Localidade
										</label>
										<input type="number" id="DDD_LOCALIDADE" name="DDD_LOCALIDADE" min="1" max="99" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>												
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="VALOR_FATURA">
											Valor da fatura (R$):
										</label>
										<input type="text" id="VALOR_FATURA" name="VALOR_FATURA" class="form-control" maxlength="15"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="VALOR_CALCULADO">
											Valor calculado (R$):
										</label>
										<input type="text" id="VALOR_CALCULADO" name="VALOR_CALCULADO" class="form-control" maxlength="15"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-7">
									<div class="form-group">
										<label for="DIFF_VALUE">
											Diferença valor fatura X valor calculado:
										</label>
										<input type="text" id="DIFF_VALUE" name="DIFF_VALUE" class="form-control" maxlength="15"/>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label for="SELECT_OPERATOR">
											Condição:
										</label>
										<select id="SELECT_OPERATOR" class="form-control search-select" placeholder="Selecione o operador">
											<option value="">Selecione...</option>
											<option value=">">(>) Maior</option>
											<option value="<">(<) Menor</option>
											<option value=">=">(>=) Maior ou igual</option>
											<option value="<=">(<=) Menor ou igual</option>
											<option value="=">(=) Igual</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="JUSTIFICATIVA">
											Justificativa:
										</label>
										<input type="text" id="JUSTIFICATIVA" name="JUSTIFICATIVA" class="form-control" maxlength="255" style="text-transform: uppercase"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<button id="validateButton" title="Validar todos os acessos filtrados" class="btn btn-green btn-block" type="button">
										<i class="fa fa-check"></i> Validar todos filtrados
									</button>
								</div>
								<div class="col-md-6">
									<button id="contestButton" title="Contestar todos os acessos filtrados" class="btn btn-bricky btn-block" type="button">
										<i class="fa fa-times fa fa-white"></i> Contestar todos filtrados
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>