<!-- start: TOOLBAR -->
	<!-- The container of the sidebar and content box -->
	<div role="main" id="main" class="container_12 clearfix" style="margin-top: -20px;">

		<!-- The blue toolbar stripe -->
		<section class="toolbar">
			<div class="user">
				<div class="avatar">
					<img src="<?php echo HOME_URI;?>/assets/img/layout/content/toolbar/user/avatar.png">
					<span>3</span>
				</div>
				<span>Administrator</span>
				<ul>
					<li><a href="javascript:$$.settings();">Settings</a></li>
					<li><a href="pages_profile.html">Profile</a></li>
					<li class="line"></li>
					<li><a href="login.html">Logout</a></li>
				</ul>
			</div>
			<ul class="shortcuts">
			
				<li>
					<a href="javascript:void(0);"><span class="icon i24_user-business"></span></a>
					<!-- Possible sizes: small/medium/large -->
					<div class="small">
						<h3>Create a User</h3>
						
						<!-- Button bar -->
						<button class="button flat left grey" onclick="$(this).parent().fadeToggle($$.config.fxSpeed).parent().removeClass('active')">Close</button>
						<button class="button flat right" onclick="$(this).parent().fadeToggle($$.config.fxSpeed).parent().removeClass('active')">Create</button>
						
						<div class="content">
							<form class="full grid">
								<div class="row no-bg">
									<p class="_100 small">
										<label for="p1_username">Username</label>
										<input type="text" name=p1_username id=p1_username />
									</p>
								</div>
								<div class="row no-bg">
									<p class="_50 small">
										<label for="p1_firstname">Firstname</label>
										<input type="text" name=p1_firstname id=p1_firstname />
									</p>
									<p class="_50 small">
										<label for="p1_lastname">Lastname</label>
										<input type="text" name=p1_lastname id=p1_lastname />
									</p>
								</div>
							</form>
						</div>
					</div><!-- End of popup -->
				</li>
				
				<li>
					<a href="javascript:void(0);"><span class="icon i24_inbox-document"></span></a>
					<!-- Possible sizes: small/medium/large -->
					<div class="small">
						<h3>Write a Message</h3>
						
						<!-- Button bar -->
						<button class="button flat left grey" onclick="$(this).parent().fadeToggle($$.config.fxSpeed).parent().removeClass('active')">Close</button>
						<button class="button flat right" onclick="$(this).parent().fadeToggle($$.config.fxSpeed).parent().removeClass('active')">Send</button>
						
						<div class="content">
							<form class="full grid">
								<div class="row no-bg">
									<p class="_100 small">
										<input type="text" name=p2_recipient id=p2_recipient placeholder="Recipient" />
									</p>
									<p class="_100 small">
										<input type="text" name=p2_subject id=p2_subject placeholder="Subject" />
									</p>
									<p class="_100 small">
										<textarea rows=5 style="overflow: hidden; height: 45px; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" name="p2_message" id="p2_message" placeholder="Message"></textarea>
									</p>
								</div>
							</form>
						</div>
					</div><!-- End of popup -->
				</li>
				
				<li>
					<a href="javascript:void(0);"><span class="icon i24_application-blue"></span></a>
					<!-- Possible sizes: small/medium/large -->
					<div class="small">
						<h3>Information</h3>
						
						<!-- Button bar -->
						<button class="button flat left grey" onclick="$(this).parent().fadeToggle($$.config.fxSpeed).parent().removeClass('active')">Close</button>
						
						<div class="content">
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
						</div>
					</div><!-- End of popup -->
				</li>
				
			</ul><!-- End of .shortcuts -->
			
			<input type="search" data-source="extras/search.php" placeholder="Search..." autocomplete="off" class="tooltip" title="e.g. Peach" data-gravity=s>
		</section><!-- End of .toolbar-->
<!-- end: TOOLBAR -->