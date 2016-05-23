<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/table-data.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>
	jQuery(document).ready(function() {
		Main.init();
		TableData.init();

		/* Change chk_div click */
		var div = document.getElementsByClassName('icheckbox_minimal-grey')[0];

		div.addEventListener('click', function (event) {
			setAllCheckBoxes('frmColetaAparelho', 'chk_coleta');
		});
	});
</script>