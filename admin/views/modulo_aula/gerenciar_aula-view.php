<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

	<?php

		// Auxiliary array
		$message_array = array();
		$message_array["success"]["insert"] = "A aula foi cadastrada com sucesso";
		$message_array["success"]["edit"] = "A aula foi editada com sucesso";
		$message_array["success"]["delete"] = "A aula foi excluída com sucesso";
		$message_array["error"]["insert"] = "Algo inesperado ocorreu no cadastro";
		$message_array["error"]["edit"] = "Algo inesperado ocorreu na edição";
		$message_array["error"]["delete"] = "Algo inesperado ocorreu na exclusão";

		// Check if exists a status variable
		if ( isset($_GET["status"]) && strcmp($_GET["status"], "success") == 0 )
		{
			if ( isset($_GET["action"]) && strcmp($_GET["action"], "") != 0 )
			{
				?>
					<div class="alert success">
						<span class="icon"></span>
						<strong>Sucesso!</strong> <?php echo $message_array["success"][$_GET["action"]] . "."; ?>
					</div>
				<?php
			}
		}
		else if ( isset($_GET["status"]) && strcmp($_GET["status"], "error") == 0 )
		{
			if ( isset($_GET["action"]) && strcmp($_GET["action"], "") != 0 )
			{
				?>
					<div class="alert error no-margin-top">
						<span class="icon"></span>
						<strong>Erro!</strong> <?php echo $message_array["error"][$_GET["action"]] . "."; ?>
					</div>
				<?php
			}
		}

	?>

	<h1 class="grid_12 margin-top no-margin-top-phone" title="Gestão de Aulas">Gestão de Aulas</h1>

	<div class="tabletools">
		<div class="left">
			<a class="open-add-client-dialog" href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_aula/cadastrar_aula')); ?>" title="Adicionar novo usuário">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/document-task.png" alt="" height=16 width=16/>
				Registrar aula
			</a>
		</div>
	</div>

	<table class="styled dynamic full" data-filter-Bar="always" data-table-tools='{"display":true}' data-max-items-per-page=20>
		<thead>
			<tr>
				<th style="width: 10%; white-space: nowrap;">#</th>
				<th style="width: 15%; white-space: nowrap;">Data de realizacao</th>
				<th style="width: 55%;">Conteudo ministrado</th>
				<th style="width: 20%; white-space: nowrap;">Professor</th>
			</tr>
		</thead>
		<tbody>
			<?php

				// Auxiliary variable
				$count = 0;

				// Get the classes list
				$data_value = $modelo->getClasses();

				// Run through classes list
				foreach ( $data_value as $value )
				{
					// Init row
					echo "<tr>";

					// Botões de ação
					echo '<td style="width: 10%; white-space: nowrap;" class="center middle">
						<a href="' . encrypted_url($value["ID_AULA"], HOME_URI . "/modulo_aula/editar_aula?id_Aula=") . '"; class="button small orange tooltip" data-gravity=s title="Editar aula"><i class="icon-pencil"></i></a>

						<a onClick="deleteClass(' . $value["ID_AULA"] . ', \'' . $value["DATA_AULA"] . '\')" class="button small red tooltip" data-gravity=s title="Excluir aula"><i class="icon-remove"></i></a></td>';

					// Class's date
					if ( isset($value["DATA_AULA"]) && strcmp($value["DATA_AULA"], "")  != 0 )
					{
						echo "<td style='width: 15%; white-space: nowrap;' class='center middle' title='" . $value["DATA_AULA"] . "'>" . $value["DATA_AULA"] . "</td>";
					}
					else
					{
						echo "<td class='center middle'>-</td>";
					}

					// Content
					if ( isset($value["CONTEUDO_MINISTRADO"]) && strcmp($value["CONTEUDO_MINISTRADO"], "")  != 0 )
					{
						echo "<td class='center middle' title='" . $value["CONTEUDO_MINISTRADO"] . "'><strong>" . $value["CONTEUDO_MINISTRADO"] . "</strong></td>";
					}
					else
					{
						echo "<td class='center middle'>-</td>";
					}

					// Sensei
					if ( isset($value["PRIMEIRO_NOME"]) && strcmp($value["PRIMEIRO_NOME"], "")  != 0 )
					{
						if ( isset($value["SOBRENOME"]) && strcmp($value["SOBRENOME"], "")  != 0 )
						{
							echo "<td style='width: 20%; white-space: nowrap;' class='center middle' title='" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "'>" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "</td>";
						}
						else
						{
							echo "<td style='width: 20%; white-space: nowrap;' class='center middle' title='" . $value["PRIMEIRO_NOME"] . "'>" . $value["PRIMEIRO_NOME"] . "</td>";
						}
					}

					echo "</tr>";
				}
			?>
		</tbody>
	</table><!-- End of table -->
</section><!-- End of #content -->
<!-- end: CONTENT -->

<input type="hidden" id="elem_DUMMY" value=""/>

<script>

	/* Function to delete a class by ID
	 *
	 * @param id_class_ => class ID
	*/
	function deleteClass( id_class_, class_date_ )
	{
		if ( confirm("Realmente deseja excluir a aula do dia '" + class_date_ + "'?") == true )
		{
			// Callback to delete the element
			sendRequest( '<?php echo HOME_URI;?>/modulo_aula', 'action=delete&class_ID=' + id_class_, 'POST', 
				'///', document.getElementById('elem_DUMMY'), 'delete' );

			// Realod the page withou parameters
			window.location = window.location.href.split("?")[0];
		}
		else
		{
			return false;
		}
	}

</script>