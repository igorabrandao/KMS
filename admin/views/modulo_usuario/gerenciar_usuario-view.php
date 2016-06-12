<?php

	// Check if PEC ID is valid
	$modelo->getUsers();

?>

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
			<a class="open-add-client-dialog" href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/editar_usuario')); ?>" title="Editar usuário já existente">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/user--pencil.png" alt="" height=16 width=16/>
				Editar usuário
			</a>
			<a class="open-add-client-dialog" href="javascript:void(0);" title="Excluir usuário">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/user--minus.png" alt="" height=16 width=16/>
				Excluir usuário
			</a>
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
			<tr class="gradeX">
				<td></td>
				<td>XXX</td>
				<td>Trident</td>
				<td>Internet
					 Explorer 4.0</td>
				<td>Win 95+</td>
				<td class="center">4</td>
				<td class="center">X</td>
			</tr>
			<tr class="gradeC">
				<td></td>
				<td>XXX</td>
				<td>Trident</td>
				<td>Internet
					 Explorer 5.0</td>
				<td>Win 95+</td>
				<td class="center">5</td>
				<td class="center">C</td>
			</tr>
			<tr class="gradeA">
				<td></td>
				<td>XXX</td>
				<td>Trident</td>
				<td>Internet
					 Explorer 5.5</td>
				<td>Win 95+</td>
				<td class="center">5.5</td>
				<td class="center">A</td>
			</tr>
		</tbody>
	</table><!-- End of table -->
</section><!-- End of #content -->
<!-- end: CONTENT -->