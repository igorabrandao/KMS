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
		<link rel="shortcut icon" href="<?php echo HOME_URI;?>/favicon.ico" />

		<!-- CSS -->

		<!-- Layout Styles -->
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/style.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/grid.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/layout.css">

		<!-- Icon Styles -->
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/icons.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/fonts/font-awesome.css">
		<!--[if IE 8]><link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/fonts/font-awesome-ie7.css"><![endif]-->

		<!-- External Styles -->
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/jquery-ui-1.8.21.custom.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/jquery.chosen.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/jquery.cleditor.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/jquery.colorpicker.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/jquery.elfinder.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/jquery.fancybox.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/jquery.jgrowl.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/jquery.plupload.queue.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/syntaxhighlighter/shCore.css" />
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/external/syntaxhighlighter/shThemeDefault.css" />

		<!-- Elements -->
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/elements.css">
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/forms.css">

		<!-- OPTIONAL: Print Stylesheet for Invoice -->
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/print-invoice.css">

		<!-- Typographics -->
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/typographics.css">

		<!-- Responsive Design -->
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/media-queries.css">

		<!-- Bad IE Styles -->
		<link rel="stylesheet" href="<?php echo HOME_URI;?>/assets/css/ie-fixes.css">

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

	</head>