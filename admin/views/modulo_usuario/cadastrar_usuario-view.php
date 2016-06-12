<?php

	// Check if PEC ID is valid
	$modelo->getUsers();

?>

<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

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
						<label for="PRIMEIRO_NOME">
							<strong>Primeiro nome:</strong>
						</label>
						<div>
							<input type="text" class="required" name="PRIMEIRO_NOME" id="PRIMEIRO_NOME" maxlength="30" />
						</div>
					</div>

					<div class="row">
						<label for="SOBRENOME">
							<strong>Sobrenome:</strong>
						</label>
						<div>
							<input type="text" class="required" name="SOBRENOME" id="SOBRENOME" maxlength="30" />
						</div>
					</div>

					<div class="row">
						<label for="CPF">
							<strong>CPF:</strong>
							<small>ex: 123.456.789-11</small>
						</label>
						<div>
							<input type="text" class="required" name="CPF" id="CPF" />
						</div>
					</div>
					
					<div class="row">
						<label for="w1_password">
							<strong>User Password</strong>
						</label>
						<div>
							<input type="password" class="required" value="ThisSecretPassIsCool!" name=w1_password id=w1_password />
						</div>
					</div>
				</fieldset>

				<fieldset id="wiz_contato">
					<div class="row">
						<label for="w1_email">
							<strong>E-Mail</strong>
						</label>
						<div>
							<input type="text" class="required" email=true name=w1_email id=w1_email />
						</div>
					</div>
					<div class="row">
						<label for="w1_userpassword">
							<strong>Password</strong>
						</label>
						<div>
							<input type="password" class="required" name=w1_userpassword id=w1_userpassword />
						</div>
					</div>
				</fieldset>
				<fieldset id="wiz_finalizacao">
					<div class="alert note top">
						<span class="icon"></span>
						<strong>Congratulations!</strong> You just finished the main steps.
					</div>
					<p>Press &quotFinish&quot; to end this cool Wizard and submit the data.</p>
				</fieldset>
			</div><!-- End of .content -->
			
			<div class="actions">
				<div class="left">
					<a href="#" class="button grey"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow-180.png" width=16 height=16></span>Back</a>
				</div>
				<div class="right">
					<a href="#" class="button grey"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow.png" width=16 height=16></span>Next</a>
					<a href="#" class="button finish"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow.png" width=16 height=16></span>Finish</a>
				</div>
			</div><!-- End of .actions -->
			
		</form><!-- End of .box -->
	</div><!-- End of .grid_4 -->
	
	<script>
		$$.ready(function(){
			$('#wiz').wizard({
				onSubmit: function(){
					alert('Your Data:\n' + $('form#wiz').serialize());
					return false;
				}
			});

			// Call the function to mask the input fields
			applyCustomMasks();
		});
	</script>
</section><!-- End of #content -->
<!-- end: CONTENT -->