<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->

<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
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
		//**********  JUN/2016 - Alteração
		//**********
		//**********************************************************************************

		/* Check if the global variable exists and avoid direct access to this file */
		if ( ! defined('ABSPATH')) exit;
	?>

	<meta charset="utf-8">

	<link rel="dns-prefetch" href="http://fonts.googleapis.com" />
	<link rel="dns-prefetch" href="http://themes.googleusercontent.com" />
	
	<link rel="dns-prefetch" href="http://ajax.googleapis.com" />
	<link rel="dns-prefetch" href="http://cdnjs.cloudflare.com" />
	<link rel="dns-prefetch" href="http://agorbatchev.typepad.com" />
	
	<!-- Use the .htaccess and remove these lines to avoid edge case issues.
	   More info: h5bp.com/b/378 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<!-- Title -->
	<title><?php echo $this->title; ?></title>

	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- iPhone: Don't render numbers as call links -->
	<meta name="format-detection" content="telephone=no">

	<!-- Keywords -->
	<meta name="keywords" content="KMS, Karate, karate, sistema, gerenciamento, artes marciais, AKC">

	<!-- Description -->
	<meta name="description" content="KMS - Karate Management System">

	<!-- Author -->
	<meta name="author" content="Igor A. Brandão">

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo HOME_URI;?>/favicon.png" />

	<!-- The Styles -->
	<!-- ---------- -->

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

	<!-- The Scripts -->
	<!-- ----------- -->

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
	<!--[if lt IE 9]><script src="<?php echo HOME_URI;?>/assets/js/mylibs/polyfills/selectivizr-min.js"></script><![endif]-->
	<!--[if lt IE 10]><script src="<?php echo HOME_URI;?>/assets/js/mylibs/charts/excanvas.js"></script><![endif]-->
	<!--[if lt IE 10]><script src="<?php echo HOME_URI;?>/assets/js/mylibs/polyfills/classlist.js"></script><![endif]-->

	<!-- Grab frameworks from CDNs -->
	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo HOME_URI;?>/assets/js/libs/jquery-1.7.2.min.js"><\/script>')</script>

	<!-- Do the same with jQuery UI -->
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
	<script>window.jQuery.ui || document.write('<script src="<?php echo HOME_URI;?>/assets/js/libs/jquery-ui-1.8.21.min.js"><\/script>')</script>
	
	<!-- Do the same with Lo-Dash.js -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/0.4.2/lodash.min.js"></script>
	<script>window._ || document.write('<script src="<?php echo HOME_URI;?>/assets/js/libs/lodash.min.js"><\/script>')</script>

	<!-- scripts concatenated and minified via build script -->
	
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
	<script src="<?php echo HOME_URI;?>/assets/js/mylibs/forms/uploader/jquery.plupload.queue/jquery.plupload.queue.js"></script>

	<!-- Syntax Highlighter -->
	<script src="<?php echo HOME_URI;?>/assets/js/mylibs/syntaxhighlighter/shCore.js"></script>
	<script src="<?php echo HOME_URI;?>/assets/js/mylibs/syntaxhighlighter/shAutoloader.js"></script>

	<!-- Dynamic Tables -->
	<script src="<?php echo HOME_URI;?>/assets/js/mylibs/dynamic-tables/jquery.dataTables.js"></script>
	<script src="<?php echo HOME_URI;?>/assets/js/mylibs/dynamic-tables/jquery.dataTables.tableTools.zeroClipboard.js"></script>
	<script src="<?php echo HOME_URI;?>/assets/js/mylibs/dynamic-tables/jquery.dataTables.tableTools.js"></script>

	<!-- Do not touch! -->
	<script src="<?php echo HOME_URI;?>/assets/js/mango.js"></script>
	<script src="<?php echo HOME_URI;?>/assets/js/plugins.js"></script>
	<script src="<?php echo HOME_URI;?>/assets/js/script.js"></script>

	<!-- Your custom JS goes here -->
	<script src="<?php echo HOME_URI;?>/assets/js/app.js"></script>

	<!-- end scripts -->

</head>

<body class=login>

	<!-- Some dialogs etc. -->

	<!-- The loading box -->
	<div id="loading-overlay"></div>
	<div id="loading">
		<span>Loading...</span>
	</div>
	<!-- End of loading box -->
	
	<!--------------------------------->
	<!-- Now, the page itself begins -->
	<!--------------------------------->
	
	<!-- The toolbar at the top -->
	<section id="toolbar">
		<div class="container_12">
		
			<!-- Left side -->
			<div class="left">
				<ul class="breadcrumb">
				
					<li><a href="javascript:void(0);">Site AKC</a></li>
					<li><a href="javascript:void(0);">Login</a></li>
					
				</ul>
			</div>
			<!-- End of .left -->
			
			<!-- Right side -->
			<div class="right">
			</div><!-- End of .right -->
			
			<!-- Phone only items -->
			<div class="phone">
				
				<!-- User Link -->
				<li><a href="#"><span class="icon icon-home"></span></a></li>
				<!-- Navigation -->
				<li><a href="#"><span class="icon icon-heart"></span></a></li>
			
			</div><!-- End of .phone -->
			
		</div><!-- End of .container_12 -->
	</section><!-- End of #toolbar -->
	
	<!-- The header containing the logo -->
	<header class="container_12">

		<div class="container">

			<!-- Your logos -->
			<a href="<?php echo HOME_URI;?>"><img src="<?php echo HOME_URI;?>/assets/img/logo.png" title="Logo AKC" alt="AKC" height="120"></a>

			<!-- Right link -->
			<div class="right">
			</div>
			
		</div><!-- End of .container -->
	
	</header><!-- End of header -->
	
	<!-- The container of the sidebar and content box -->
	<section id="login" class="container_12 clearfix">

		<form action="#" role="form" method="POST" class="box validate" enctype="multipart/form-data">
		
			<div class="header">
				<h2><span class="icon icon-lock"></span>Login</h2>
			</div>
			
			<div class="content">

				<div class="login-messages">
					<!-- Login messages -->
					<?php 

						if ( isset($this->login_error) && strcmp($this->login_error, "") != 0 )
						{
							echo'<div class="message welcome" style="color: #771717!important">' . $this->login_error . '</div>
								<div class="message failure">Informações incorretas.</div>';
						}
						else
						{
							echo'<div class="message welcome">Bem-vindo a AKC!</div>
								<div class="message failure">Informações incorretas.</div>';
						}

					?>
				</div>

				<!-- The form -->
				<div class="form-box">
				
					<div class="row">
						<label for="user">
							<strong>E-mail:</strong>
							<small>(Preenchimento obrigatório)</small>
						</label>
						<div>
							<input tabindex=1 type="text" class="required noerror" name="user" id="user" />
						</div>
					</div>
					
					<div class="row">
						<label for="user_password">
							<strong>Senha:</strong>
							<small><a href="javascript:void(0);" id="">Esqueceu sua senha?</a></small>
						</label>
						<div>
							<input tabindex=2 type="password" class="required noerror" name="user_password" id="user_password" />
						</div>
					</div>
					
				</div><!-- End of .form-box -->
				
			</div><!-- End of .content -->
			
			<div class="actions">
				<div class="left">
				</div>
				<div class="right">
					<input tabindex=3 type="submit" value="Entrar no sistema" />
				</div>
			</div><!-- End of .actions -->
			
		</form><!-- End of form -->

	</section>
	
	<!-- Spawn $$.loaded -->
	<script>
		$$.loaded();
	</script>
	
	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
	   chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script defer src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>