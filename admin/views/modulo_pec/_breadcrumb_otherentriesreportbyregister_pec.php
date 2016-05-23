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
			<a href="<?php echo HOME_URI;?>/modulo_pec/otherentriesreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>" title="Outros Lançamentos">
				Outros Lançamentos
			</a>
		<?php } else { ?>
			<a href="<?php echo HOME_URI;?>/modulo_pec/otherentriesreport_pec" title="Outros Lançamentos">
				Outros Lançamentos
			</a>
		<?php } ?>
	</li>
	<li class="active" title="Detalhamento por lançamento">
		Detalhamento por lançamento
	</li>
</ol>
<!-- end: BREADCRUMB -->