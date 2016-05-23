<!-- start: NAVBAR -->
			<!-- Right side -->
			<div class="right">
				<ul>
				
					<li><a href="pages_profile.html"><span class="icon i14_admin-user"></span>Profile</a></li>
					
					<li>
						<a href="#"><span>3</span>Messages</a>
						
						<!-- Mail popup -->
						<div class="popup">
							<h3>New Messages</h3>
							
							<!-- Button bar -->
							<a class="button flat left grey" onclick="$(this).parent().fadeToggle($$.config.fxSpeed)">Close</a>
							<a class="button flat right" href="tables_dynamic.html">Inbox</a>
							
							<!-- The mail content -->
							<div class="content mail">
								<ul>
								
									<li>
										<div class="avatar">
											<img src="<?php echo HOME_URI;?>/assets/img/elements/mail/avatar.png" height=40 width=40/>
										</div>
										<div class="info">
											<strong>John Doe</strong>
											<span>Thanks for your theme!</span>
											<small>09:32 am</small>
										</div>
										<div class="text">
											<p>Hey Admin!</p>
											<p>I've purchased your admin template and it's great :)</p>
											<p>A happy customer</p>
											<div class="actions">
												<a href="javascript:void(0);" class="left open-message-dialog">Reply</a>
												<a onclick="$(this).parent().parent().parent().slideToggle($$.config.fxSpeed)" class="red right" href="javascript:void(0);">Delete</a>
											</div>
										</div>
									</li>
									
									<li>
										<div class="avatar">
											<img src="<?php echo HOME_URI;?>/assets/img/elements/mail/mail.png" height=40 width=40/>
										</div>
										<div class="info">
											<strong>System</strong>
											<span>New comment</span>
											<small>08:47 am</small>
										</div>
										<div class="text">
											<p>Hello,</p>
											<p>There is one new comment on your theme.</p>
											<p>Go to Comments page to see it.</p>
											<div class="actions">
												<a href="javascript:void(0);" class="left open-message-dialog">Reply</a>
												<a onclick="$(this).parent().parent().parent().slideToggle($$.config.fxSpeed)" class="red right" href="javascript:void(0);">Delete</a>
											</div>
										</div>
									</li>
									
									<li>
										<div class="avatar">
											<img src="<?php echo HOME_URI;?>/assets/img/elements/mail/mail.png" height=40 width=40/>
										</div>
										<div class="info">
											<strong>Stranger</strong>
											<span>[SPAM] ---</span>
											<small>Yesterday</small>
										</div>
										<div class="text">
											<p>[...]</p>
											<div class="actions">
												<a href="javascript:void(0);" class="left open-message-dialog">Read</a>
												<a onclick="$(this).parent().parent().parent().slideToggle($$.config.fxSpeed)" class="red right" href="javascript:void(0);">Delete</a>
											</div>                            
										</div>
									</li>
									
								</ul>
							</div><!-- End of .contents -->
							
						</div><!-- End of .popup -->
					</li><!-- End of li -->
					
					<li class="space"></li>
					
					<li><a href="javascript:void(0);" id="btn-lock"><span>--:--</span>Lock screen</a></li>
					
					<li class="red"><a href="login.html">Logout</a></li>
					
				</ul>
			</div><!-- End of .right -->

			<!-- Phone only items -->
			<div class="phone">

				<!-- User Link -->
				<li><a href="pages_profile.html"><span class="icon icon-user"></span></a></li>
				<!-- Navigation -->
				<li><a class="navigation" href="#"><span class="icon icon-list"></span></a></li>

			</div><!-- End of phone items -->

		</div><!-- End of .container_12 -->
	</section><!-- End of #toolbar -->
<!-- end: NAVBAR -->