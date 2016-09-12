<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->

<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html lang="pt-br" class="no-js"> <!--<![endif]-->
	<head>

		<?php
			//**********************************************************************************
			//**********  IGOR A. BRANDÃO 2016 ©
			//**********
			//**********  PGM: KMS - Karate Management System
			//**********
			//**********  CLIENTE:	AKC - Associação Karate Cidadão
			//**********
			//**********  IGOR AUGUSTO BRANDÃO
			//**********  VERSÃO:	1.0
			//**********
			//**********  MAI/2016 - Criação
			//**********
			//**********************************************************************************

			/* Verifica se a variável global existe e evita acesso direto a este arquivo */
			if ( ! defined('ABSPATH')) exit;
		?>

		<!-- Título -->
		<title><?php echo $this->title; ?></title>

		<!-- Meta tags -->
		<meta charset="utf-8">

		<link rel="dns-prefetch" href="http://fonts.googleapis.com" />
		<link rel="dns-prefetch" href="http://themes.googleusercontent.com" />
		<link rel="dns-prefetch" href="http://ajax.googleapis.com" />
		<link rel="dns-prefetch" href="http://cdnjs.cloudflare.com" />
		<link rel="dns-prefetch" href="http://agorbatchev.typepad.com" />

		<!-- Use the .htaccess and remove these lines to avoid edge case issues.
		More info: h5bp.com/b/378 -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- Mobile viewport optimized: h5bp.com/viewport -->
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<!-- iPhone: Don't render numbers as call links -->
		<meta name="format-detection" content="telephone=no">

		<!-- Palavras-chave -->
		<meta name="keywords" content="KMS, Karate, karate, sistema, gerenciamento, artes marciais, AKC">

		<!-- Descrição -->
		<meta name="description" content="KMS - Karate Management System">

		<!-- Autor -->
		<meta name="author" content="Igor A. Brandão">

		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo HOME_URI;?>/favicon.png" />

		<!-- CSS -->

		<!-- Layout Styles -->
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/style.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/grid.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/layout.css?<?php echo time(); ?>">

		<!-- Icon Styles -->
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/icons.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/fonts/font-awesome.css?<?php echo time(); ?>">
		<!--[if IE 8]><link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/fonts/font-awesome-ie7.css?<?php echo time(); ?>"><![endif]-->

		<!-- External Styles -->
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/jquery-ui-1.8.21.custom.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/jquery.chosen.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/jquery.cleditor.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/jquery.colorpicker.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/jquery.elfinder.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/jquery.fancybox.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/jquery.jgrowl.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/jquery.plupload.queue.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/syntaxhighlighter/shCore.css?<?php echo time(); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/external/syntaxhighlighter/shThemeDefault.css?<?php echo time(); ?>" />

		<!-- Elements -->
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/elements.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/forms.css?<?php echo time(); ?>">

		<!-- OPTIONAL: Print Stylesheet for Invoice -->
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/print-invoice.css?<?php echo time(); ?>">

		<!-- Typographics -->
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/typographics.css?<?php echo time(); ?>">

		<!-- Responsive Design -->
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/media-queries.css?<?php echo time(); ?>">

		<!-- Bad IE Styles -->
		<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/assets/css/ie-fixes.css?<?php echo time(); ?>">

		<!-- JS -->
		<script src="<?php echo HOME_URI;?>/functions/global-functions.js"></script>

		<!-- JavaScript at the top (will be cached by browser) -->
			
		<!-- Load Webfont loader -->
		<script type="text/javascript">
			window.WebFontConfig = {
				google: { families: [ 'PT Sans:400,700' ] },
				active: function(){ $(window).trigger('fontsloaded') }
			};
		</script>
		<script defer async src="https://ajax.googleapis.com/ajax/libs/webfont/1.0.28/webfont.js"></script>
		
		<!-- Essential polyfills -->
		<script src="<?php echo HOME_URI;?>/assets/js/mylibs/polyfills/modernizr-2.6.1.min.js"></script>
		<script src="<?php echo HOME_URI;?>/assets/js/mylibs/polyfills/respond.js"></script>
		<script src="<?php echo HOME_URI;?>/assets/js/mylibs/polyfills/matchmedia.js"></script>
		<!--[if lt IE 9]><script src="<?php echo HOME_URI;?>/assets/js/mylibs/polyfills/selectivizr.js"></script><![endif]-->
		<!--[if lt IE 10]><script src="<?php echo HOME_URI;?>/assets/js/mylibs/polyfills/excanvas.js"></script><![endif]-->
		<!--[if lt IE 10]><script src="<?php echo HOME_URI;?>/assets/js/mylibs/polyfills/classlist.js"></script><![endif]-->

		<!-- Grab frameworks from CDNs -->
			<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
		<script>window.jQuery || document.write('<script src="<?php echo HOME_URI;?>/assets/js/libs/jquery-1.7.2.js"><\/script>')</script>
		
			<!-- Do the same with jQuery UI -->
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.js"></script>
		<script>window.jQuery.ui || document.write('<script src="<?php echo HOME_URI;?>/assets/js/libs/jquery-ui-1.8.21.js"><\/script>')</script>
		
			<!-- Do the same with Lo-Dash.js -->
		<!--[if gt IE 8]><!-->
		<script src="<?php echo HOME_URI;?>/assets/js/libs/lo-dash.js"></script>
		<script>window._ || document.write('<script src="<?php echo HOME_URI;?>/assets/js/libs/lo-dash.js"><\/script>')</script>
		<!--<![endif]-->
		<!-- IE8 doesn't like lodash -->
		<!--[if lt IE 9]><script src="http://documentcloud.github.com/underscore/underscore.js"></script><![endif]-->

		<!-- start: MAIN JAVASCRIPTS -->
			<!-- General Scripts -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/jquery.hashchange.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/jquery.idle-timer.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/jquery.plusplus.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/jquery.jgrowl.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/jquery.scrollTo.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/jquery.ui.touch-punch.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/jquery.ui.multiaccordion.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/number-functions.js"></script>
			
			<!-- Forms -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.autosize.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.checkbox.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.chosen.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.cleditor.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.colorpicker.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.ellipsis.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.fileinput.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.fullcalendar.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.maskedinput.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.mousewheel.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.placeholder.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.pwdmeter.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.ui.datetimepicker.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.ui.spinner.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/jquery.validate.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/uploader/plupload.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/uploader/plupload.html5.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/uploader/plupload.html4.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/uploader/plupload.flash.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/uploader/jquery.plupload.queue/jquery.plupload.queue.js"></script>
				
			<!-- Charts -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/charts/jquery.flot.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/charts/jquery.flot.orderBars.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/charts/jquery.flot.pie.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/charts/jquery.flot.resize.js"></script>
			
			<!-- Explorer -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/explorer/jquery.elfinder.js"></script>
			
			<!-- Fullstats -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/fullstats/jquery.css-transform.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/fullstats/jquery.animate-css-rotate-scale.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/fullstats/jquery.sparkline.js"></script>
			
			<!-- Syntax Highlighter -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/syntaxhighlighter/shCore.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/syntaxhighlighter/shAutoloader.js"></script>
			
			<!-- Dynamic Tables -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/dynamic-tables/jquery.dataTables.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/dynamic-tables/jquery.dataTables.tableTools.zeroClipboard.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/dynamic-tables/jquery.dataTables.tableTools.js"></script>
			
			<!-- Gallery -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/gallery/jquery.fancybox.js"></script>
			
			<!-- Tooltips -->
			<script src="<?php echo HOME_URI;?>/assets/js/mylibs/tooltips/jquery.tipsy.js"></script>
			
			<!-- Do not touch! -->
			<script src="<?php echo HOME_URI;?>/assets/js/mango.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/plugins.js"></script>
			<script src="<?php echo HOME_URI;?>/assets/js/script.js"></script>

			<!-- Your custom JS goes here -->

		<!-- end: MAIN JAVASCRIPTS -->

	</head>