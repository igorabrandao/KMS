<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/plugins/summernote/build/summernote.css">

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo HOME_URI;?>/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/summernote/build/summernote.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/form_validation/form-validation-empresa.js"></script>

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
<script src="<?php echo HOME_URI;?>/assets/js/form-elements.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
	jQuery(document).ready(function() {
		/* Elements initialization */
		Main.init();
		FormValidator.init();
		FormElements.init();

		/* Define field mask */
		$.mask.definitions['~'] = "[+-]";
			$("#CNPJ").mask("99.999.999/9999-99");
			//$("#INSCRICAO_ESTADUAL").mask("999.999.999.999");
			$("#DATA_ABERTURA").mask("99-99-9999");
			$("#CEP").mask("99999-999");
			$("#TELEFONE").mask("(99)99999-9999");
			$("#TELEFONE2").mask("(99)99999-9999");

			$("input").blur(function() {
				$("#info").html("Unmasked value: " + $(this).mask());
			}).dblclick(function() {
				$(this).unmask();
			});
	});
</script>