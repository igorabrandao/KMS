<!-- start: BOOTSTRAP EXTENDED MODALS -->
<div id="modal_modulo" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			&times;
		</button>
		<h4 class="modal-title">Adicionar módulo</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<!-- start: FORM VALIDATION 1 PANEL -->
				<div class="panel panel-default">
					<div class="panel-body">
						<h2><i class="fa fa-pencil-square teal"></i> NOVO MÓDULO</h2>
						<p>
							Preencha as informações do formulário abaixo para inserir um novo módulo.
						</p>
						<hr>
						<form action="#" role="form" id="form">
						<!--<form id="frmCadEmp" name="frmCadEmp" class="form-box register-form contact-form" action="empresa_bd.php" method="POST">-->
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
									<div class="form-group">
										<label for="form-field-mask-2">
											Descritivo do módulo <span class="symbol required"></span>
										</label>
										<div class="input-group">
											<input type="text" class="form-control" id="card_name" name="card_name" placeholder="Informe o descritivo">
										</div>
									</div>
									<div class="form-group">
										<label for="form-field-mask-2">
											Franquia minutos individual
										</label>
										<div class="input-group">
											<input type="text" class="form-control">
											<span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
										</div>
									</div>
									<div class="form-group">
										<label for="form-field-mask-2">
											Franquia sms individual <span class="symbol required"></span>
										</label>
										<div class="input-group">
											<input type="text" class="form-control" id="card_name" name="card_name" placeholder="">
										</div>
									</div>
									<div class="form-group">
										<label for="form-field-mask-2">
											Franquia sms compartilhado
										</label>
										<div class="input-group">
											<input type="text" class="form-control" id="card_name" name="card_name" placeholder="">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label">
											Velocidade da internet
										</label>
										<input type="text" class="form-control" id="card_name" name="card_name" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label">
											Quantidade de linhas
										</label>
										<input type="text" name="txtVlTotPlano" id="txtVlTotPlano" class="form-control currency">
									</div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="form-field-mask-2">
													Tarifa módulo
												</label>
												<div class="input-group">
													<input type="text" id="form-field-mask-5" class="form-control currency">
												</div>
											</div>
											<div class="form-group">
												<label for="form-field-mask-2">
													Tarifa excedente
												</label>
												<div class="input-group">
													<input type="text" id="form-field-mask-5" class="form-control currency">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="form-field-mask-2">
													Valor unitário
												</label>
												<div class="input-group">
													<input type="text" id="form-field-mask-5" class="form-control currency">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="form-field-mask-2">
													Desconto
												</label>
												<div class="input-group">
													<input type="text" id="form-field-mask-5" class="form-control currency">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="form-field-mask-2">
													Valor total
												</label>
												<div class="input-group">
													<input type="text" id="form-field-mask-5" class="form-control currency">
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
						</form>
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
		<button type="button" class="btn btn-blue">
			Salvar módulo
		</button>
	</div>
</div>