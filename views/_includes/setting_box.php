<!-- start: SETTING DIALOG -->
	<div id="settings" class="settings-content" data-width=450>
	
		<ul class="tabs center-elements">
			<li><a href="#settings-1"><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/24x24/user-business.png" alt="" /><span>Account Settings</span></a></li>
			<li><a href="#settings-2"><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/24x24/balloon.png" alt="" /><span>Notifications</span></a></li>
			<li><a href="#settings-3"><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/24x24/credit-card.png" alt="" /><span>Invoicing</span></a></li>
		</ul>

		<div class="change_password">
			<form action="#" method="GET" class="validate" id="settings_password">
				<p>
					<label for="settings-password">New Password:</label> <input type="password" id="settings-password" class="required strongpw small password meter" />
				</p>
			</form>
			<div class="actions">
				<div class="right">
					<input form="settings_password" type="reset" value="Cancel" class="grey" />
					<input form="settings_password" type="submit" value="OK" />
				</div>
			</div>
		</div><!-- End of .change_password -->
		
		<div class="content">
		
			<div id="settings-1">
				<form action="#" method="GET">
					<p>
						<label for="settings-name">Name:</label> <input type="text" id="settings-name" class="medium" />
					</p>
					<p>
						<label for="settings-descr">Descripton:</label> <input type="text" id="settings-descr" class="medium" />
					</p>
					<p class="divider"></p>
					<p>
						<label for="settings-pw">Password: </label> <input class="grey change_password_button" type="button" id="settings-pw" value="Change Password..." data-lang-changed="Password changed" />
					</p>
				</form>
			</div><!-- End of #settings-1 -->
			
			<div id="settings-2">
				Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
				<form action="#" method="GET">
					<div class="spacer"></div>
					<p class="divider"></p>
					<div class="spacer"></div>
					<p>
						<label for="settings-email">Email Address:</label> <input type="text" id="settings-email" class="medium" />
					</p>
					<p>
						<label for="settings-interval">Interval: </label>
						<select name="settings-interval" id="settings-interval" data-placeholder="Choose an Interval">
							<option value=""></option>
							<option value="Never">Never</option>
							<option value="Daily">Daily</option>
							<option value="Weekly">Weekly</option>
							<option value="Monthly">Monthly</option>
							<option value="Yearly">Yearly</option>
						</select>
					</p>
				</form>
			</div><!-- End of #settings-2 -->
			
			<div id="settings-3">
				<form action="#" method="GET">
					<p>
						<label for="settings-card-number">Card number:</label> <input type="text" id="settings-card-number" class="medium" />
					</p>
					<p>
						<label for="settings-cvv">CVV:</label> <input type="text" id="settings-cvv" class="medium" />
					</p>
					<p>
						<label for="settings-expiration">Expiration: </label>
						<select sname="settings-expiration" id="settings-expiration" data-placeholder="Choose an Expiration">
							<option value=""></option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
						</select>
					</p>
				</form>
			</div><!-- End of #settings-3 -->
			
		</div><!-- End of .content -->
		
		<div class="actions">
			<div class="left">
				<button class="grey cancel">Cancel</button>
			</div>
			<div class="right">
				<button class="save">Save</button>
				<button class="hide saving" disabled >Saving...</button>
			</div>
		</div><!-- End of .actions -->
		
	</div>
<!-- end: SETTING DIALOG -->