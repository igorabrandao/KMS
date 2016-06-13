<?php

	// Check if PEC ID is valid
	//$modelo->getUsers();

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
					<li><a class="current" href="#wiz_dados">Informacoes Gerais</a></li>
					<li><a href="#wiz_frequencia">Frequencia</a></li>
				</ul>

				<fieldset id="wiz_dados">

					<div class="row">
						<label for="DATA_AULA">
							<strong>Data de Realizacao</strong>
						</label>
						<div>
							<input type="date" class="required" name="DATA_AULA" id="DATA_AULA" maxlength="10" />
						</div>
					</div>

					<div class="row">
						<label for="CONTEUDO_MINISTRADO">
							<strong>Conteudo ministrado</strong>
						</label>
						<div>
							<textarea rows="5" cols="50" name="CONTEUDO_MINISTRADO" id="CONTEUDO_MINISTRADO" maxlength="500" />
						</div>
					</div>

					<div class="row">
						<label for="ID_PROFESSOR">
							<strong>Sensei:</strong>
						</label>
						<div>
							<p class="_25">
								<select name="ID_PROFESSOR" id="ID_PROFESSOR">
									<option value="">Selecione...</option> 
									<option value="1">Funakoshi</option> 
									<option value="2">Igor</option> 
									<option value="3">Inacio</option> 
								</select>
							</p>
						</div>
					</div>

				</fieldset>

				<fieldset id="wiz_frequencia">

					<table class="styled dynamic full" data-filter-Bar="always" data-table-tools='{"display":true}' data-max-items-per-page=20>
						<thead>
							<tr>
								<th>#</th>
								<th>Aluno</th>
								<th>Presente</th>
							</tr>
						</thead>
						<tbody>
							<tr class="gradeX">
								<td></td>
								<td>Joao</td>
								<td><input type="checkbox" name="ID_USUARIO" /></td>
							</tr>
						</tbody>
					</table><!-- End of table -->				

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