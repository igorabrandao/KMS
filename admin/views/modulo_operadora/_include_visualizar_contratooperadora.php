<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/summernote/build/summernote.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/css/DT_bootstrap.css" />

<!-- Modal -->
<link href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<!-- Form Wizard -->
<script src="<?php echo HOME_URI;?>/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/form-wizard.js"></script>

<!-- Form Modal -->
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/ui-modals.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootbox/bootbox.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>

<!-- Form Validation -->
<script src="<?php echo HOME_URI;?>/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/form-validation.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/form_validation/form-validation-contratooperadora.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/form_validation/form-validation-modalplano.js"></script>

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo HOME_URI;?>/assets/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/autosize/jquery.autosize.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/select2/select2.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/jquery-maskmoney/jquery.maskMoney.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-colorpicker/js/commits.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/summernote/build/summernote.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/ckeditor/adapters/jquery.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/table_data_custom/table-data-contratooperadora.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/form-elements.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>

	// Apply the money mask
	var addMaskMoney = function()
	{
		$("input[name=VALOR_PARCELA_EQUIP]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=VALOR_TOTAL_EQUIP]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=TARIFA_LOCAL]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=TARIFA_EXCEDENTE]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=TARIFA_LD]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=VALOR_PAC_MIN]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=VALOR_ASSINATURA_PLANO]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=DESCONTO_PLANO]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=VALOR_ASSINATURA_MODULO]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
		$("input[name=DESCONTO_MODULO]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
	};

	jQuery(document).ready(function() {

		/* Elements initialization */
		Main.init();
		FormValidator.init();
		FormElements.init();

		/* Define field mask */
		$.mask.definitions['~'] = "[+-]";
			$("#DATA_ASSINATURA").mask("99-99-9999");
			$("#DATA_ATIVACAO").mask("99-99-9999");
			addMaskMoney();
			
		/* Update the hidden fields */
		parseTableFields( "elem_EQUIPAMENTOS", "table_Equip" );
		parseTableFields( "elem_PLANOS", "table_Plan" );
		parseTableFields( "elem_MODULOS", "table_Modulo" );
		parseTableFields( "elem_QTDLINHAS", "table_DDD" );
	});

	// Prevent enter key submit the form
	$(document).keypress(
		function(event){
		 if (event.which == '13') {
			event.preventDefault();
		  }
	});

</script>