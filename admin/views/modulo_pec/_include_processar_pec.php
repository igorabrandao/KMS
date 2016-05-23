<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
	jQuery(document).ready(function() {
		/* Report redirect */
		<?php if ( $modelo->getStatusProcessing() == true ) { ?>
			<?php $modelo->insertLog_PEC( $modelo->getIdPEC(), "Cadastro PEC da operadora " . $modelo->getCarrier(), (microtime(true) - $modelo->getProcessedTime()), date("d-m-Y H:i:s"), "SUCCESS"); ?>
			//window.location.href = "<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/menu_pec?idPEC=");?>";
		<?php } else { ?>
			<?php $modelo->insertLog_PEC( $modelo->getIdPEC(), "Cadastro PEC da operadora " . $modelo->getCarrier(), (microtime(true) - $modelo->getProcessedTime()), date("d-m-Y H:i:s"), "ERROR"); ?>
			alert("Houve um problema no processamento da fatura. Por favor, tente novamente.");
			window.location.href = "<?php echo HOME_URI;?>/modulo_pec/upload_pec";</script>
		<?php } ?>
	});
</script>