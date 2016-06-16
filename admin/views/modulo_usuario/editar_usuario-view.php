<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

	<?php

		// Check if service ID is valid
		if ( isset($_GET['id_User']) && $_GET['id_User'] != '' )
		{
			$user_id = decrypted_url($_GET['id_User'] , "**");

			// Load contract information
			$user_info = $modelo->get_user_info($user_id);

			// Edit function
			$modelo->edit_user($user_info["ID_ENDERECO"], $user_info["ID_USUARIO"]);
		}
		else
		{
			?><script>alert("Houve um problema com o identificador do usuário. Por favor, tente novamente.");
			window.location.href = "<?php echo HOME_URI . '/modulo_usuario'; ?>";</script> <?php
			return false;
		}

	?>

	<h1 class="grid_12 margin-top no-margin-top-phone" title="Editar Usuário">Editar Usuário</h1>

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
										if ( $user_info["ID_TIPO_USUARIO"] == $value[0] )
											echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
										else
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
							<input type="text" class="required" name="PRIMEIRO_NOME" id="PRIMEIRO_NOME" maxlength="30" value="<?php echo iif($user_info["PRIMEIRO_NOME"]); ?>" />
						</div>
					</div>

					<div class="row">
						<label for="SOBRENOME">
							<strong>Sobrenome:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="SOBRENOME" id="SOBRENOME" maxlength="30" value="<?php echo iif($user_info["SOBRENOME"]); ?>" />
						</div>
					</div>

					<div class="row">
						<label for="CPF">
							<strong>CPF:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="CPF" id="CPF" value="<?php echo iif($user_info["CPF"]); ?>"/>
						</div>
					</div>

					<div class="row">
						<label for="DATA_NASCIMENTO">
							<strong>Data de nascimento:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="date" class="required" name="DATA_NASCIMENTO" id="DATA_NASCIMENTO" value="<?php echo iif($user_info["DATA_NASCIMENTO"]); ?>" />
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
								<?php

									if ( strcmp($user_info["SEXO"], "M") == 0 )
									{
										echo "<option value='M' selected>Masculino</option>";
										echo "<option value='F'>Feminino</option>";
									}
									else
									{
										echo "<option value='M'>Masculino</option>";
										echo "<option value='F' selected>Feminino</option>";
									}

								?>
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
								<option value="A+" <?php if ( strcmp($user_info["TIPO_SANGUINEO"], "A+") == 0 ) { echo "selected"; } ?> >Sangue tipo A+</option> 
								<option value="A-" <?php if ( strcmp($user_info["TIPO_SANGUINEO"], "A-") == 0 ) { echo "selected"; } ?> >Sangue tipo A-</option> 
								<option value="B+" <?php if ( strcmp($user_info["TIPO_SANGUINEO"], "B+") == 0 ) { echo "selected"; } ?> >Sangue tipo B+</option> 
								<option value="B-" <?php if ( strcmp($user_info["TIPO_SANGUINEO"], "B-") == 0 ) { echo "selected"; } ?> >Sangue tipo B-</option> 
								<option value="AB+" <?php if ( strcmp($user_info["TIPO_SANGUINEO"], "AB+") == 0 ) { echo "selected"; } ?> >Sangue tipo AB+</option> 
								<option value="AB-" <?php if ( strcmp($user_info["TIPO_SANGUINEO"], "AB-") == 0 ) { echo "selected"; } ?> >Sangue tipo AB-</option> 
								<option value="O+" <?php if ( strcmp($user_info["TIPO_SANGUINEO"], "O+") == 0 ) { echo "selected"; } ?> >Sangue tipo O+</option> 
								<option value="O-" <?php if ( strcmp($user_info["TIPO_SANGUINEO"], "O-") == 0 ) { echo "selected"; } ?> >Sangue tipo O-</option>
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
										if ( $user_info["ID_FAIXA"] == $value[0] )
											echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
										else
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
							<input type="text" email="true" class="required" name="EMAIL" id="EMAIL" maxlength="100" value="<?php echo iif($user_info["EMAIL"]); ?>" />
						</div>
					</div>

					<div class="row">
						<label for="TELEFONE">
							<strong>Telefone fixo:</strong>
						</label>
						<div>
							<input type="text" name="TELEFONE" id="TELEFONE" value="<?php echo iif($user_info["TELEFONE"]); ?>"/>
						</div>
					</div>

					<div class="row">
						<label for="CELULAR">
							<strong>Celular:</strong>
						</label>
						<div>
							<input type="text" name="CELULAR" id="CELULAR" value="<?php echo iif($user_info["CELULAR"]); ?>" />
						</div>
					</div>

					<div class="row">
						<label for="CEP">
							<strong>CEP:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="CEP" id="CEP" value="<?php echo iif($user_info["CEP"]); ?>"/>
						</div>
					</div>

					<div class="row">
						<label for="LOGRADOURO">
							<strong>Logradouro:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="LOGRADOURO" id="LOGRADOURO" value="<?php echo iif($user_info["LOGRADOURO"]); ?>"/>
						</div>
					</div>

					<div class="row">
						<label for="NUMERO">
							<strong>Número:</strong>
						</label>
						<div>
							<input type="text" name="NUMERO" id="NUMERO" value="<?php echo iif($user_info["NUMERO"]); ?>"/>
						</div>
					</div>

					<div class="row">
						<label for="COMPLEMENTO">
							<strong>Complemento:</strong>
						</label>
						<div>
							<input type="text" name="COMPLEMENTO" id="COMPLEMENTO" value="<?php echo iif($user_info["COMPLEMENTO"]); ?>"/>
						</div>
					</div>

					<div class="row">
						<label for="BAIRRO">
							<strong>Bairro:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="BAIRRO" id="BAIRRO" value="<?php echo iif($user_info["BAIRRO"]); ?>"/>
						</div>
					</div>

					<div class="row">
						<label for="CIDADE">
							<strong>Cidade:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="text" class="required" name="CIDADE" id="CIDADE" value="<?php echo iif($user_info["CIDADE"]); ?>"/>
						</div>
					</div>

					<div class="row">
						<label for="UF">
							<strong>UF:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<select class="required" name="ID_UF" id="ID_UF" class="search">
								<?php

									// State's list
									$list = $modelo->get_state_list();

									foreach ($list as $value)
									{
										if ( $user_info["ID_UF"] == $value[0] )
											echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
										else
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
					<p>Clique no botão &quotFinalizar edição&quot; para encerrar a edição.</p>
				</fieldset>

			</div><!-- End of .content -->

			<div class="actions">
				<div class="left">
					<a href="#" class="button grey"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow-180.png" width=16 height=16></span>Passo anterior</a>
				</div>
				<div class="right">
					<a href="#" class="button grey"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow.png" width=16 height=16></span>Próximo passo</a>
					<a href="#" class="button finish"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow.png" width=16 height=16></span>Finalizar edição</a>
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