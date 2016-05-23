<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/select2/select2.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/plugins/summernote/build/summernote.css">

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

<!-- Form Validation -->
<script src="<?php echo HOME_URI;?>/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/form-validation.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/form_validation/form-validation-book.js"></script>

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
<script src="<?php echo HOME_URI;?>/assets/js/form-elements.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
	jQuery(document).ready(function() {
		/* Elements initialization */
		Main.init();
		FormValidator.init();
		FormElements.init();
		FormWizard.init();
		UIModals.init();

		/* Define field mask */
		$.mask.definitions['~'] = "[+-]";
			$("input[name=elem_TARIFA]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
			$("input[name=elem_TARIFA_EXCEDENTE]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
			$("#VALOR_ASSINATURA").maskMoney({symbol:"R$",decimal:",",thousands:"."});

			$("input").blur(function() {
				$("#info").html("Unmasked value: " + $(this).mask());
			}).dblclick(function() {
				$(this).unmask();
			});
	});
</script>