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
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/plugins/DataTables/media/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URI;?>/assets/js/table_data_custom/table-data-relatoriolinha-contratado.js"></script>

<!-- Jquery plugin -->
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/tableExport.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jquery.base64.js"></script>
<script src="<?php echo HOME_URI;?>/assets/js/table-export.js"></script>

<!-- PNG export -->
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/html2canvas.js"></script>

<!-- PDF export -->
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jspdf/libs/sprintf.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jspdf/jspdf.js"></script>
<script src="<?php echo HOME_URI;?>/assets/plugins/tableExport/jspdf/libs/base64.js"></script>

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<script>

	// When the page is totally load, these things happen
	jQuery(document).ready(function()
	{
		Main.init();
		TableData.init();
		UIButtons.init();
		TableExport.init();
	});

</script>