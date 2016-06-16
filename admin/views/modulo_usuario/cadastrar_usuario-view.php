<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

	<?php

		// Insertion function
		$modelo->insert_user();

	?>

	<h1 class="grid_12 margin-top no-margin-top-phone" title="Cadastrar novo Usuário">Cadastrar novo Usuário</h1>

	<div class="grid_12">

		<form action="#" role="form" id="wiz" action="" method="POST" class="box wizard manual validate" enctype="multipart/form-data">

			<!--<div class="header">
				<h2><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/ui-tab--arrow.png" class="icon">Wizard</h2>
			</div>-->

			<div class="content">

				<ul class="steps">
					<li><a class="current" href="#wiz_pessoal">Informações pessoais</a></li>
					<li><a href="#wiz_contato">Endereço e contato</a></li>
					<li><a href="#wiz_finalizacao">Finalização</a></li>
				</ul>

				<fieldset id="wiz_pessoal">

					<div class="row">
						<label for="FOTO">
							<strong>Foto: </strong>
						</label>
						<div>
							<input type="file" id="FOTO" name="FOTO" />
						</div>
					</div>

					<div class="row">
						<label for="ID_TIPO_USUARIO">
							<strong>Tipo de usuário: </strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<select name="ID_TIPO_USUARIO" id="ID_TIPO_USUARIO" class="search">
								<option value="">Selecione...</option>
								<?php

									// Belt's list
									$list = $modelo->get_user_type_list();

									foreach ($list as $value)
									{
										echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
									}

								?>
							</select>
						</div>
					</div>

					<div class="row">
						<label for="PRIMEIRO_NOME">
							<strong>Primeiro nome:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="PRIMEIRO_NOME" id="PRIMEIRO_NOME" maxlength="30" />
						</div>
					</div>

					<div class="row">
						<label for="SOBRENOME">
							<strong>Sobrenome:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="SOBRENOME" id="SOBRENOME" maxlength="30" />
						</div>
					</div>

					<div class="row">
						<label for="CPF">
							<strong>CPF:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="CPF" id="CPF" />
						</div>
					</div>

					<div class="row">
						<label for="DATA_NASCIMENTO">
							<strong>Data de nascimento:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="date" class="required" name="DATA_NASCIMENTO" id="DATA_NASCIMENTO" />
						</div>
					</div>

					<div class="row">
						<label for="SEXO">
							<strong>Sexo: </strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<select class="required" name="SEXO" id="SEXO">
								<option value="">Selecione...</option> 
								<option value="M">Masculino</option> 
								<option value="F">Feminino</option> 
							</select>
						</div>
					</div>

					<div class="row">
						<label for="TIPO_SANGUINEO">
							<strong>Tipo sanguíneo: </strong>
						</label>
						<div>
							<select name="TIPO_SANGUINEO" id="TIPO_SANGUINEO" class="search">
								<option value="">Selecione...</option> 
								<option value="A+">Sangue tipo A+</option> 
								<option value="A-">Sangue tipo A-</option> 
								<option value="B+">Sangue tipo B+</option> 
								<option value="B-">Sangue tipo B-</option> 
								<option value="AB+">Sangue tipo AB+</option> 
								<option value="AB-">Sangue tipo AB-</option> 
								<option value="O+">Sangue tipo O+</option> 
								<option value="O-">Sangue tipo O-</option>
							</select>
						</div>
					</div>

					<div class="row">
						<label for="FAIXA">
							<strong>Faixa: </strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<select name="ID_FAIXA" class="required" id="ID_FAIXA" class="search">
								<option value="">Selecione...</option>
								<?php

									// Belt's list
									$list = $modelo->get_belt_list();

									foreach ($list as $value)
									{
										echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
									}

								?>
							</select>
						</div>
					</div>

				</fieldset>

				<fieldset id="wiz_contato">

					<div class="row">
						<label for="EMAIL">
							<strong>E-mail:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" email="true" class="required" name="EMAIL" id="EMAIL" maxlength="100" />
						</div>
					</div>

					<div class="row">
						<label for="TELEFONE">
							<strong>Telefone fixo:</strong>
						</label>
						<div>
							<input type="text" name="TELEFONE" id="TELEFONE"/>
						</div>
					</div>

					<div class="row">
						<label for="CELULAR">
							<strong>Celular:</strong>
						</label>
						<div>
							<input type="text" name="CELULAR" id="CELULAR"/>
						</div>
					</div>

					<div class="row">
						<label for="CEP">
							<strong>CEP:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="CEP" id="CEP"/>
						</div>
					</div>

					<div class="row">
						<label for="LOGRADOURO">
							<strong>Logradouro:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="LOGRADOURO" id="LOGRADOURO"/>
						</div>
					</div>

					<div class="row">
						<label for="NUMERO">
							<strong>Número:</strong>
						</label>
						<div>
							<input type="text" name="NUMERO" id="NUMERO"/>
						</div>
					</div>

					<div class="row">
						<label for="COMPLEMENTO">
							<strong>Complemento:</strong>
						</label>
						<div>
							<input type="text" name="COMPLEMENTO" id="COMPLEMENTO"/>
						</div>
					</div>

					<div class="row">
						<label for="BAIRRO">
							<strong>Bairro:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="BAIRRO" id="BAIRRO"/>
						</div>
					</div>

					<div class="row">
						<label for="CIDADE">
							<strong>Cidade:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="CIDADE" id="CIDADE"/>
						</div>
					</div>

					<div class="row">
						<label for="UF">
							<strong>UF:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<select class="required" name="ID_UF" id="ID_UF" class="search">
								<option value="">Selecione...</option>
								<?php

									// Stete's list
									$list = $modelo->get_state_list();

									foreach ($list as $value)
									{
										echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
									}

								?>
							</select>
						</div>
					</div>

				</fieldset>

				<fieldset id="wiz_finalizacao">
					<div class="alert note top">
						<span class="icon"></span>
						<strong>Sucesso!</strong> Todas as informações foram corretamente preenchidas.
					</div>
					<p>Clique no botão &quotFinalizar cadastro&quot; para encerrar o cadastro. Uma mensagem de confirmação será enviado para o 
					e-mail cadastrado.</p>
				</fieldset>

			</div><!-- End of .content -->

			<div class="actions">
				<div class="left">
					<a href="#" class="button grey"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow-180.png" width=16 height=16></span>Passo anterior</a>
				</div>
				<div class="right">
					<a href="#" class="button grey"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow.png" width=16 height=16></span>Próximo passo</a>
					<a href="#" class="button finish"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow.png" width=16 height=16></span>Finalizar cadastro</a>
				</div>
			</div><!-- End of .actions -->

		</form><!-- End of .box -->
	</div><!-- End of .grid_4 -->

	<script>
		$$.ready(function(){
			$('#wiz').wizard({
				onSubmit: function(){
					//alert('Your Data:\n' + $('form#wiz').serialize());
					return false;
				}
			});

			// Call the function to mask the input fields
			applyCustomMasks();
		});
	</script>
</section><!-- End of #content -->
<!-- end: CONTENT -->