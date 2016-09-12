<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

	<?php

		// Insertion function
		$modelo->insert_class();

	?>

	<h1 class="grid_12 margin-top no-margin-top-phone" title="Cadastrar Aula">Cadastrar Aula</h1>

	<div class="grid_12">

		<form action="#" role="form" id="wiz" action="" method="POST" class="box wizard manual validate" enctype="multipart/form-data">

			<!--<div class="header">
				<h2><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/ui-tab--arrow.png" class="icon">Wizard</h2>
			</div>-->

			<div class="content">

				<ul class="steps">
					<li><a class="current" href="#wiz_geral">Informações gerais</a></li>
					<li><a href="#wiz_frequencia">Frequência</a></li>
				</ul>

				<fieldset id="wiz_geral">

					<div class="row">
						<label for="DATA_AULA">
							<strong>Data da aula:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input type="date" class="required" name="DATA_AULA" id="DATA_AULA" />
						</div>
					</div>

					<div class="row">
						<label for="CONTEUDO_MINISTRADO">
							<strong>Conteúdo ministrado:</strong>
						</label>
						<div>
							<textarea class="editor" name="CONTEUDO_MINISTRADO" id="CONTEUDO_MINISTRADO" ></textarea>
						</div>
					</div>

					<div class="row">
						<label for="ID_PROFESSOR">
							<strong>Sensei: </strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<select name="ID_PROFESSOR" id="ID_PROFESSOR" class="required search">
								<option value="">Selecione...</option>
								<?php

									// Sensei's list
									$list = $modelo->getSensei();

									foreach ($list as $value)
									{
										echo "<option value='" . $value[0] . "'>" . $value[1] . " " . $value[2] . "</option>";
									}

								?>
							</select>
						</div>
					</div>

				</fieldset>

				<fieldset id="wiz_frequencia">

					</br>
					<div class="grid_12">
						<div class="box">
						
							<div class="header">
								<h2>Lançar frequência</h2>
							</div>
							
							<div class="content">

								<table id="table_frequency" class="dynamic styled" data-filter-Bar="always" data-table-tools='{"display":false}' data-max-items-per-page=30> 
									<thead>
										<tr>
											<th style="width: 50%;">Nome do aluno</th>
											<th style="width: 50%;">Está presente?</th
										</tr>
									</thead>
									<tbody>

										<?php

											// Auxiliary variable
											$count = 0;

											// Get the user list
											$data_value = $modelo->getStudents();

											// Run through service list
											foreach ( $data_value as $value )
											{
												// Init row
												echo "<tr>";

												// Nome do usuário
												if ( isset($value["PRIMEIRO_NOME"]) && strcmp($value["PRIMEIRO_NOME"], "")  != 0 )
												{
													if ( isset($value["SOBRENOME"]) && strcmp($value["SOBRENOME"], "")  != 0 )
													{
														echo "<td class='center middle' title='" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "'><strong>" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "</strong></td>";

														echo "<input type='hidden' name='ID_ALUNO' id='ID_ALUNO" . $count . "' value='" . $value["ID_USUARIO"] . "' />";
													}
													else
													{
														echo "<td class='center middle' title='" . $value["PRIMEIRO_NOME"] . "'><strong>" . $value["PRIMEIRO_NOME"] . "</strong></td>";

														echo "<input type='hidden' name='ID_ALUNO' id='ID_ALUNO" . $count . "' value='" . $value["ID_USUARIO"] . "' />";
													}
												}

												// Checkbox
												echo "<td class='center middle' title='" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . " está presente?'>
													<input type='checkbox' name='PRESENTE' id='PRESENTE" . $count . "' />
												</td>";

												$count++;
											}
										?>

									</tbody>
								</table>
								
							</div><!-- End of .content -->
							
						</div><!-- End of .box -->
					</div><!-- End of .grid_12 -->

				</fieldset>

			</div><!-- End of .content -->

			<div class="actions">
				<div class="left">
					<a href="#" class="button grey"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow-180.png" width=16 height=16></span>Passo anterior</a>
				</div>
				<div class="right">
					<a href="#" class="button grey"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow.png" width=16 height=16></span>Próximo passo</a>
					<a onClick="parseFrequency();" href="#" class="button finish"><span><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/arrow.png" width=16 height=16></span>Finalizar cadastro da aula</a>
				</div>
			</div><!-- End of .actions -->

			<input type="hidden" name="elem_USERS" id="elem_USERS" value=""/>
			<input type="hidden" name="elem_FREQUENCY" id="elem_FREQUENCY" value=""/>

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

<script type="text/javascript">

	/** Function to parse the frequency information
	*/
	function parseFrequency()
	{
		/* Get the HTML inputs */
		var id_aluno_group = document.getElementsByName("ID_ALUNO");
		var id_aluno_hidden = document.getElementById("elem_USERS");

		var id_frequency_group = document.getElementsByName("PRESENTE");
		var id_frequency_hidden = document.getElementById("elem_FREQUENCY");

		/* Clear the initial value */
		id_aluno_hidden.value = "";
		id_frequency_hidden.value = "";

		// Run through aluno group
		for ( var i = 0; i < id_aluno_group.length; i++ )
		{
			id_aluno_hidden.value += id_aluno_group[i].value + "@@";
		}

		// Run through frequency group
		for ( var i = 0; i < id_frequency_group.length; i++ )
		{
			if ( id_frequency_group[i].checked == true )
				id_frequency_hidden.value += "1@@";
			else
				id_frequency_hidden.value += "0@@";
		}
	}

</script>