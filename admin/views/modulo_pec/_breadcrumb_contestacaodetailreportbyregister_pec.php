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
			<a href="<?php echo HOME_URI;?>/modulo_pec/menu_contestacao_pec?idPEC=<?php echo $_GET['idPEC']; ?>" title="Visualização Contestação">
				Visualização Contestação
			</a>
		<?php } else { ?>
			<a href="<?php echo HOME_URI;?>/modulo_pec/menu_contestacao_pec" title="Visualização Contestação">
				Visualização Contestação
			</a>
		<?php } ?>
	</li>
	<li>
		<?php
			if (isset($_GET['idPEC']) && $_GET['idPEC'] != '') {
		?>	
			<a href="<?php echo HOME_URI;?>/modulo_pec/contestacaodetailreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>" title="Contestação do detalhamento">
				Contestação do detalhamento
			</a>
		<?php } else { ?>
			<a href="<?php echo HOME_URI;?>/modulo_pec/contestacaodetailreport_pec" title="Detalhamento">
				Contestação do detalhamento
			</a>
		<?php } ?>
	</li>
	<li>
		<?php
			if (isset($_GET['idPEC']) && $_GET['idPEC'] != '' && isset($_GET['idUtilizacao']) && $_GET['idUtilizacao'] != '') {
		?>	
			<a href="<?php echo HOME_URI;?>/modulo_pec/contestacaodetailreportbyutilization_pec?idPEC=<?php echo $_GET['idPEC']; ?>&idUtilizacao=<?php echo $_GET['idUtilizacao']; ?>" title="Contestação do detalhamento por utilização">
				Contestação por utilização
			</a>
		<?php } else { ?>
			<a href="<?php echo HOME_URI;?>/modulo_pec/contestacaodetailreportbyutilization_pec" title="Detalhamento">
				Contestação por utilização
			</a>
		<?php } ?>
	</li>
	<li class="active" title="Contestação do detalhamento por registro">
		Contestação por registro
	</li>
</ol>
<!-- end: BREADCRUMB -->