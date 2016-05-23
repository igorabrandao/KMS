<!-- start: BREADCRUMB -->
<ol class="breadcrumb">
	<li>
		<i class="clip-home-3"></i>
		<a href="<?php echo HOME_URI;?>" title="Painel de Controle">
			Painel de Controle
		</a>
	</li>
	<li>
		<a href="<?php echo HOME_URI;?>/modulo_pec/gerenciar_pec" title="PEC">
			PEC
		</a>
	</li>	
	<li>
		<?php
			if (isset($_GET['idPEC']) && $_GET['idPEC'] != '') {
		?>	
			<a href="<?php echo HOME_URI;?>/modulo_pec/menu_pec?idPEC=<?php echo $_GET['idPEC']; ?>" title="Visualização PEC">
				Visualização PEC
			</a>
		<?php } else { ?>
			<a href="<?php echo HOME_URI;?>/modulo_pec/menu_pec" title="Visualização PEC">
				Visualização PEC
			</a>
		<?php } ?>
	</li>
	<li>
		<?php
			if (isset($_GET['idPEC']) && $_GET['idPEC'] != '') {
		?>	
			<a href="<?php echo HOME_URI;?>/modulo_pec/menu_relatorio_pec?idPEC=<?php echo $_GET['idPEC']; ?>" title="Relatórios">
				Relatórios
			</a>
		<?php } else { ?>
			<a href="<?php echo HOME_URI;?>/modulo_pec/menu_relatorio_pec" title="Relatórios">
				Relatórios
			</a>
		<?php } ?>
	</li>
	<li>
		<?php
			if (isset($_GET['idPEC']) && $_GET['idPEC'] != '') {
		?>	
			<a href="<?php echo HOME_URI;?>/modulo_pec/menu_relatoriolinha_pec?idPEC=<?php echo $_GET['idPEC']; ?>" title="Relatórios por linha">
				Relatórios por linha
			</a>
		<?php } else { ?>
			<a href="<?php echo HOME_URI;?>/modulo_pec/menu_relatoriolinha_pec" title="Relatórios por linha">
				Relatórios por linha
			</a>
		<?php } ?>
	</li>
	<li class="active" title="Relatório de contratação por linha">
		Relatório de contratação por linha
	</li>
</ol>
<!-- end: BREADCRUMB -->