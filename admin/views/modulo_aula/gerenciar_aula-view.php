<?php

	// Check if PEC ID is valid
	//$modelo->getAulas();
	// Os métodos da model ainda não existem. Precisam ser implementados.
?>

<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

	<h1 class="grid_12 margin-top no-margin-top-phone" title="Gestão de Aulas">Gestão de Aulas</h1>

	<div class="tabletools">
		<div class="left">
			<a class="open-add-client-dialog" href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/cadastrar_usuario')); ?>" title="Adicionar novo usuário">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/user--plus.png" alt="" height=16 width=16/>
				Registrar aula
			</a>
		</div>
		<div class="right">
			<a class="open-add-client-dialog" href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/editar_usuario')); ?>" title="Editar usuário já existente">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/user--pencil.png" alt="" height=16 width=16/>
				Editar aula
			</a>
			<a class="open-add-client-dialog" href="javascript:void(0);" title="Excluir usuário">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/user--minus.png" alt="" height=16 width=16/>
				Excluir aula
			</a>
		</div>
	</div>

	<table class="styled dynamic full" data-filter-Bar="always" data-table-tools='{"display":true}' data-max-items-per-page=20>
		<thead>
			<tr>
				<th>#</th>
				<th>Data de realizacao</th>
				<th>Conteudo ministrado</th>
				<th>Professor</th>
				<th>Frequencia</th>
			</tr>
		</thead>
		<tbody>
			<tr class="gradeX">
				<td></td>
				<td>-01/01/2001</td>
				<td>Defesa</td>
				<td>Sensei Igor</td>
				<td>Ver/Registrar</td>
			</tr>
		</tbody>
	</table><!-- End of table -->
</section><!-- End of #content -->
<!-- end: CONTENT -->