<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

	<h1 class="grid_12 margin-top no-margin-top-phone" title="Gestão de Usuários">Gestão de Usuários</h1>

	<div class="tabletools">
		<div class="left">
			<a class="open-add-client-dialog" href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/cadastrar_usuario')); ?>" title="Adicionar novo usuário">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/user--plus.png" alt="" height=16 width=16/>
				Novo usuário
			</a>
		</div>
		<div class="right">
			<!--<a class="open-add-client-dialog" href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/editar_usuario')); ?>" title="Editar usuário já existente">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/user--pencil.png" alt="" height=16 width=16/>
				Editar usuário
			</a>
			<a class="open-add-client-dialog" href="javascript:void(0);" title="Excluir usuário">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/user--minus.png" alt="" height=16 width=16/>
				Excluir usuário
			</a>-->
		</div>
	</div>

	<table class="styled dynamic full" data-filter-Bar="always" data-table-tools='{"display":true}' data-max-items-per-page=20>
		<thead>
			<tr>
				<th>#</th>
				<th>Foto</th>
				<th>CPF</th>
				<th>Nome</th>
				<th>Tipo de usuário</th>
				<th>Faixa</th>
				<th>Data de cadastro</th>
			</tr>
		</thead>
		<tbody>
			<?php

				// Auxiliary variable
				$count = 0;

				// Get the user list
				$data_value = $modelo->get_user_list();

				// Run through service list
				foreach ( $data_value as $value )
				{
					// Init row
					echo "<tr>";

					// Botões de ação
					echo '<td class="center">
						<a href="' . join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/editar_usuario')) . '"; class="button small orange tooltip" data-gravity=s title="Editar usuário"><i class="icon-pencil"></i></a>

						<a onClick="deleteUser(' . $value["ID_USUARIO"] . ')" class="button small red tooltip" data-gravity=s title="Excluir usuário"><i class="icon-remove"></i></a></td>';

					// Foto
					echo "<td></td>";

					// CPF
					if ( isset($value["CPF"]) && strcmp($value["CPF"], "")  != 0 )
					{
						echo "<td style='text-align: center;' title='" . $value["CPF"] . "'>" . $value["CPF"] . "</td>";
					}
					else
					{
						echo "<td style='text-align: center;'>-</td>";
					}

					// Nome do usuário
					if ( isset($value["PRIMEIRO_NOME"]) && strcmp($value["PRIMEIRO_NOME"], "")  != 0 )
					{
						if ( isset($value["SOBRENOME"]) && strcmp($value["SOBRENOME"], "")  != 0 )
						{
							echo "<td style='text-align: center;' title='" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "'>" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "</td>";
						}
						else
						{
							echo "<td style='text-align: center;' title='" . $value["PRIMEIRO_NOME"] . "'>" . $value["PRIMEIRO_NOME"] . "</td>";
						}
					}

					// Tipo de usuário
					if ( isset($value["TP_USUARIO"]) && strcmp($value["TP_USUARIO"], "")  != 0 )
					{
						echo "<td style='text-align: center;' title='" . $value["TP_USUARIO"] . "'>" . $value["TP_USUARIO"] . "</td>";
					}
					else
					{
						echo "<td style='text-align: center;'>-</td>";
					}

					// Faixa
					if ( isset($value["FAIXA"]) && strcmp($value["FAIXA"], "")  != 0 )
					{
						echo "<td style='text-align: center;' title='" . $value["FAIXA"] . "'>" . $value["FAIXA"] . "</td>";
					}
					else
					{
						echo "<td style='text-align: center;'>-</td>";
					}

					// Data de cadastro
					if ( isset($value["DATA_CADASTRO"]) && strcmp($value["DATA_CADASTRO"], "")  != 0 )
					{
						echo "<td style='text-align: center;' title='" . $value["DATA_CADASTRO"] . "'>" . $value["DATA_CADASTRO"] . "</td>";
					}
					else
					{
						echo "<td style='text-align: center;'>-</td>";
					}

					echo "</tr>";
				}
			?>
		</tbody>
	</table><!-- End of table -->
</section><!-- End of #content -->
<!-- end: CONTENT -->

<script>

	/* Function to delete an user by ID
	 *
	 * @param id_user_ => user ID
	*/
	function deleteUser( id_user_ )
	{
		alert(id_user_)
	}

</script>