<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

	<?php

		// Auxiliary array
		$message_array = array();
		$message_array["success"]["insert"] = "O usuário foi cadastrado com sucesso";
		$message_array["success"]["edit"] = "O usuário foi editado com sucesso";
		$message_array["success"]["delete"] = "O usuário foi excluído com sucesso";
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
				<?php if ( isset($this->user_info["ID_TIPO_USUARIO"]) && ( $this->user_info["ID_TIPO_USUARIO"] == 1 || $this->user_info["ID_TIPO_USUARIO"] == 2 ) ) { ?>
					<th>CPF</th>
				<?php } ?>
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
					$nome = $value["PRIMEIRO_NOME"] . ' ' . $value["SOBRENOME"];

					// Check if the user has permission to change the register
					if ( isset($this->user_info["ID_TIPO_USUARIO"]) && ( $this->user_info["ID_TIPO_USUARIO"] == 1 || $this->user_info["ID_TIPO_USUARIO"] == 2 ) )
					{
						echo '<td class="center middle">
							<a href="' . encrypted_url($value["ID_USUARIO"], HOME_URI . "/modulo_usuario/editar_usuario?id_User=") . '"; class="button small orange tooltip" data-gravity=s title="Editar usuário"><i class="icon-pencil"></i></a>

							<a onClick="deleteUser(' . $value["ID_USUARIO"] . ', \'' . $nome . '\')" class="button small red tooltip" data-gravity=s title="Excluir usuário"><i class="icon-remove"></i></a>

							<a href="' . encrypted_url($value["ID_USUARIO"], HOME_URI . "/modulo_usuario/perfil_usuario?id_User=") . '"; class="button small grey tooltip" data-gravity=s title="Visualizar perfil do usuário"><i class="icon-eye-open"></i></a></td>';
					}
					else
					{
						echo "<td class='center middle'>-</td>";
					}

					// Foto
					if ( isset($value["FOTO"]) && strcmp($value["FOTO"], "")  != 0 )
					{
						echo "<td class='center middle'><div class='image'><img height='50px;' alt='" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "' src='" . join(DIRECTORY_SEPARATOR, array(HOME_URI, $value["FOTO"])) . "' /></div></td>";
					}
					else
					{
						echo "<td class='center middle'><div class='image'><img height='50px;' alt='" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "' src='" . join(DIRECTORY_SEPARATOR, array(HOME_URI, "assets/img/logo.png")) . "' /></div></td>";
					}

					// CPF
					if ( isset($this->user_info["ID_TIPO_USUARIO"]) && ( $this->user_info["ID_TIPO_USUARIO"] == 1 || $this->user_info["ID_TIPO_USUARIO"] == 2 ) )
					{
						if ( isset($value["CPF"]) && strcmp($value["CPF"], "")  != 0 )
						{
							echo "<td class='center middle' title='" . $value["CPF"] . "'>" . $value["CPF"] . "</td>";
						}
						else
						{
							echo "<td class='center middle'>-</td>";
						}
					}

					// Nome do usuário
					if ( isset($value["PRIMEIRO_NOME"]) && strcmp($value["PRIMEIRO_NOME"], "")  != 0 )
					{
						if ( isset($value["SOBRENOME"]) && strcmp($value["SOBRENOME"], "")  != 0 )
						{
							echo "<td class='center middle' title='" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "'>" . $value["PRIMEIRO_NOME"] . " " . $value["SOBRENOME"] . "</td>";
						}
						else
						{
							echo "<td class='center middle' title='" . $value["PRIMEIRO_NOME"] . "'>" . $value["PRIMEIRO_NOME"] . "</td>";
						}
					}

					// Tipo de usuário
					if ( isset($value["TP_USUARIO"]) && strcmp($value["TP_USUARIO"], "")  != 0 )
					{
						echo "<td class='center middle' title='" . $value["TP_USUARIO"] . "'>" . $value["TP_USUARIO"] . "</td>";
					}
					else
					{
						echo "<td class='center middle'>-</td>";
					}

					// Faixa
					if ( isset($value["FAIXA"]) && strcmp($value["FAIXA"], "")  != 0 )
					{
						echo "<td class='center middle' title='" . $value["FAIXA"] . "'>" . $value["FAIXA"] . "</td>";
					}
					else
					{
						echo "<td class='center middle'>-</td>";
					}

					// Data de cadastro
					if ( isset($value["DATA_CADASTRO"]) && strcmp($value["DATA_CADASTRO"], "")  != 0 )
					{
						echo "<td class='center middle' title='" . $value["DATA_CADASTRO"] . "'>" . $value["DATA_CADASTRO"] . "</td>";
					}
					else
					{
						echo "<td class='center middle'>-</td>";
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

	/* Function to delete an user by ID
	 *
	 * @param id_user_ => user ID
	*/
	function deleteUser( id_user_, user_name_ )
	{
		if ( confirm("Realmente deseja excluir o usuário '" + user_name_ + "'?") == true )
		{
			// Callback to delete the element
			sendRequest( '<?php echo HOME_URI;?>/modulo_usuario', 'action=delete&user_ID=' + id_user_, 'POST', 
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