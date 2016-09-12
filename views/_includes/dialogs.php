<!-- Add Client Example Dialog -->
	<div style="display: none;" id="dialog_add_client" title="Add Client Example Dialog">
		<form action="" class="full validate">
			<div class="row">
				<label for="d2_username">
					<strong>Username</strong>
				</label>
				<div>
					<input class="required" type=text name=d2_username id=d2_username />
				</div>
			</div>
			<div class="row">
				<label for="d2_email">
					<strong>Email Address</strong>
				</label>
				<div>
					<input class="required" type=text name=d2_email id=d2_email />
				</div>
			</div>
			<div class="row">
				<label for="d2_role">
					<strong>Role</strong>
				</label>
				<div>
					<select style="padding-bottom: 10px" name=d2_role id=d2_role class="search required" data-placeholder="Choose a Role">
						<option value=""></option>
						<option value="Applicant">Applicant</option> 
						<option value="Member">Member</option> 
						<option value="Moderator">Moderator</option> 
						<option value="Administrator">Administrator</option> 
					</select>
				</div>
			</div>
		</form>
		<div class="actions">
			<div class="left">
				<button class="grey cancel">Cancel</button>
			</div>
			<div class="right">
				<button class="submit">Add User</button>
			</div>
		</div>
	</div><!-- End if #dialog_add_client -->
	
	<script>
	$$.ready(function() {
		$( "#dialog_add_client" ).dialog({
			autoOpen: false,
			modal: true,
			width: 400,
			open: function(){ $(this).parent().css('overflow', 'visible'); $$.utils.forms.resize() }
		}).find('button.submit').click(function(){
			var $el = $(this).parents('.ui-dialog-content');
			if ($el.validate().form()) {
				$el.find('form')[0].reset();
				$el.dialog('close');
			}
		}).end().find('button.cancel').click(function(){
			var $el = $(this).parents('.ui-dialog-content');
			$el.find('form')[0].reset();
			$el.dialog('close');;
		});
		
		$( ".open-add-client-dialog" ).click(function() {
			$( "#dialog_add_client" ).dialog( "open" );
			return false;
		});
	});
	</script>
	<!--  End of Add Client Example Dialog -->
	
	<!-- Message Dialog -->
	<div style="display: none;" id="dialog_message" title="Conversation: John Doe">
		<div class="spacer"></div>
		<div class="messages full chat">
			
			<div class="msg reply">
				<img src="img/icons/packs/iconsweets2/25x25/user-2.png"/>
				<div class="content">
					<h3><a href="pages_profile.html">John Doe</a> <span>says:</span><small>3 hours ago</small></h3>
					<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore
					et dolore magna aliquyam erat, sed diam voluptua.</p>
				</div>
			</div>
			
			<div class="msg">
				<img src="img/icons/packs/iconsweets2/25x25/user-2.png"/>
				<div class="content">
					<h3><a href="pages_profile.html">Peter Doe</a> <span>says:</span><small>5 hours ago</small></h3>
					<p>At vero eos et accusam et justo duo dolores et ea rebum.
					Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
				</div>
			</div>
		
		</div><!-- End of .messages -->
		
		<div class="actions">
			<div class="left">
				<input style="width: 330px;" type="text" name=d3_message id=d3_message placeholder="Type your message..."/>
			</div>
			<div class="right">
				<button>Send</button>
				<button class="grey">Cancel</button>
			</div>
		</div><!-- End of .actions -->
		
	</div><!-- End of #dialog_message -->
	
	<script>
	$$.ready(function() {
		$( "#dialog_message" ).dialog({
			autoOpen: false,
			width: 500,
			modal: true
		}).find('button').click(function(){
			$(this).parents('.ui-dialog-content').dialog('close');
		});
		
		$( ".open-message-dialog" ).click(function() {
			$( "#dialog_message" ).dialog( "open" );
			return false;
		});
	});
	</script>
<!-- End of Message Dialog -->