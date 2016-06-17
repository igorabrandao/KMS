<!-- start: LOCK SCREEN -->
	<div id="lock-screen" title="Tela de Bloqueio">

		<a href="<?php echo HOME_URI . "?action=logout"; ?>" class="header right button grey flat">Logout</a>

		<p>Você atingiu o período máximo de inatividade no sistema. Para a sua segurança a tela foi bloqueada.</p>
		<p>Para desbloquear a tela, arraste o botão abaixo e informe a sua senha.</p>
		
		<div class="actions">
			<div id="slide_to_unlock">
				<img src="<?php echo HOME_URI;?>/assets/img/elements/slide-unlock/lock-slider.png" alt="slide me">
				<span>arraste para liberar</span>
			</div>
			<form action="#" method="GET">
				<input type="password" name="pwd" id="pwd" placeholder="Digite sua senha..." autocorrect="off" autocapitalize="off"> <input type="submit" name=send value="Liberar" disabled> <input type="reset" value="X">
			</form>
		</div><!-- End of .actions -->
		
	</div>
<!-- end: LOCK SCREEN -->