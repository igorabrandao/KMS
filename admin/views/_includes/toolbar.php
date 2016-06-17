<!-- start: TOOLBAR -->
	<!-- The container of the sidebar and content box -->
	<div role="main" id="main" class="container_12 clearfix" style="margin-top: -20px;">

		<!-- The blue toolbar stripe -->
		<section class="toolbar">
			<div class="user">
				<div class="avatar">
					<img style="height: 32px; width: 32px; border: 0;" src="
					<?php 

						// Check if the user has a photo
						if ( isset($this->user_info["FOTO"]) && strcmp($this->user_info["FOTO"], "") != 0 )
						{
							echo HOME_URI . "/" . $this->user_info["FOTO"];
						}
						else
						{
							echo HOME_URI . "/assets/img/logo.png";
						}

					?>">
					<span>2</span>
				</div>
				<span><?php 

						// Check if the user has a name
						if ( isset($this->user_info["PRIMEIRO_NOME"]) && strcmp($this->user_info["PRIMEIRO_NOME"], "")  != 0 )
						{
							if ( isset($this->user_info["SOBRENOME"]) && strcmp($this->user_info["SOBRENOME"], "")  != 0 )
							{
								echo $this->user_info["PRIMEIRO_NOME"] . " " . $this->user_info["SOBRENOME"];
							}
							else
							{
								echo $this->user_info["PRIMEIRO_NOME"];
							}
						}

					?></span>
				<ul>
					<li><a href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario/perfil_usuario')); ?>">Perfil do usuário</a></li>
					<li class="line"></li>
					<li><a href="<?php echo HOME_URI . "?action=logout" ?>">Logout</a></li>
				</ul>
			</div>

			<!-- Google search -->
			<script>
			  (function() {
			    var cx = '008740153531644540099:8_9kpdvvsvw';
			    var gcse = document.createElement('script');
			    gcse.type = 'text/javascript';
			    gcse.async = true;
			    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
			    var s = document.getElementsByTagName('script')[0];
			    s.parentNode.insertBefore(gcse, s);
			  })();
			</script>

			<form name="search-form" class="search-form" action="">
				<input type="search" id="q" name="q" placeholder="Buscar no site..." autocomplete="off" class="tooltip" title="Digite uma palavra para buscar no site" data-gravity=s>
			</form>

		</section><!-- End of .toolbar-->
<!-- end: TOOLBAR -->