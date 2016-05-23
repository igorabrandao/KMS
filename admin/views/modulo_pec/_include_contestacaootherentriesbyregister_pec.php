<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/css/DT_bootstrap.css" />

<!-- Modal -->
<link href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo HOME_URI;?>/assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<!-- Form Modal -->
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/ui-modals.js"></script>

<!-- Form Elements -->
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

<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/jquery.dataTables.rowGrouping.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/table_data_custom/table-data-contestatacao-other-register.js"></script>

<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/tableExport.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jquery.base64.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/html2canvas.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jquery.base64.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jspdf/libs/sprintf.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jspdf/jspdf.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jspdf/libs/base64.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/table-export.js"></script>

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>

	/** Function to generic send requests to the server
	 * @param url_ => the url to access the server-side function
	 * @param param_ => the params itself
	 * @param method_ => "POST" / "GET"
	 * @param datatype_ => "JSON" / "TEXT"
	*/
	function sendRequestAjax( url_, method_, datatype_ ) 
	{
		return $.ajax({
			url: url_,
			type: method_,
			dataType: datatype_,
			success: function(data) {
			   return data;
			},

			error: function(data) {
				return 0;
			}
		});
	};

	jQuery(document).ready(function() {
		Main.init();
		TableData.init();
		TableExport.init();
		FormElements.init();

		/* Define field mask */
		$.mask.definitions['~'] = "[+-]";
		$("#DATA_INICIAL").mask("99-99-99");
		$("#DATA_FINAL").mask("99-99-99");
		$("#VALOR_FATURA").maskMoney({allowZero:"true", allowNegative:"true", symbol:"R$",decimal:",",thousands:"."});
		$("#VALOR_CONTRATO").maskMoney({allowZero:"true", allowNegative:"true", symbol:"R$",decimal:",",thousands:"."});

		// Button to open the modal
		$("#contestFilter").click(function(){
			$('#modal_filtro').modal();
		});

		// Button contest all trigger
		$("#contestButton").click(function()
		{
			// Hide modal
			$('#modal_filtro').modal('hide');

			if ( contestAll(1) != false )
			{
				// Display modal
				$('#modal_loading').modal(
				{
					backdrop: 'static',
					keyboard: false  // to prevent closing with Esc button (if you want this too)
				});

				// Wait until all ajax callbacks finish
				$.when.apply(this, results).done(function()
				{
					// Hide modal
					$('#modal_loading').modal('hide');

					setTimeout("", 2000);

					// Realod the page with parameters
					location.reload();
				});
			}
		});

		// Button validate all trigger
		$("#validateButton").click(function()
		{
			// Hide modal
			$('#modal_filtro').modal('hide');

			if ( contestAll(0) != false )
			{
				// Display modal
				$('#modal_loading').modal(
				{
					backdrop: 'static',
					keyboard: false  // to prevent closing with Esc button (if you want this too)
				});

				// Wait until all ajax callbacks finish
				$.when.apply(this, results).done(function()
				{
					// Hide modal
					$('#modal_loading').modal('hide');

					setTimeout("", 2000);

					// Realod the page with parameters
					location.reload();
				});
			}
		});
	});

</script>