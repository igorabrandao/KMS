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

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/js/table_data_custom/table-data-assoclinha-contratooperadora2.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>

	// Display modal
	$('#modal_loading').modal(
	{
		backdrop: 'static',
		keyboard: false  // to prevent closing with Esc button (if you want this too)
	});

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

	// When the page is totally load, these things happen
	jQuery(document).ready(function()
	{
		Main.init();
		TableData.init();
		UIButtons.init();

		// Hide modal
		$('#modal_loading').modal('hide');

		// Button submit trigger
		$("#btnSubmit").click(function(){

			// Display modal
			$('#modal_loading').modal(
			{
				backdrop: 'static',
				keyboard: false  // to prevent closing with Esc button (if you want this too)
			});

			// Call the function to delete the previous association
			deleteAssoc();

			// Call the function to insert/update the associations
			saveAssoc();

			// Wait until all ajax callbacks finish
			$.when.apply(this, results).done(function()
			{
				// Hide modal
				$('#modal_loading').modal('hide');

				setTimeout("", 2000);

				// Show the user message
				showMessage();
			});
		});
	});

</script>