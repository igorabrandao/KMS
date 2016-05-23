<!-- start: LOCK SCREEN -->
	<div id="lock-screen" title="Screen Locked">

		<a href="login.html" class="header right button grey flat">Logout</a>

		<p>Due to the inactivity of this session, your account was temporarily locked.</p>
		<p>To unlock your account, simply slide the button and enter your password.</p>
		
		<div class="actions">
			<div id="slide_to_unlock">
				<img src="<?php echo HOME_URI;?>/assets/img/elements/slide-unlock/lock-slider.png" alt="slide me">
				<span>slide to unlock</span>
			</div>
			<form action="#" method="GET">
				<input type="password" name="pwd" id="pwd" placeholder="Enter your password here..." autocorrect="off" autocapitalize="off"> <input type="submit" name=send value="Unlock" disabled> <input type="reset" value="X">
			</form>
		</div><!-- End of .actions -->
		
	</div>
<!-- end: LOCK SCREEN -->