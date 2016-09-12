<!-- start: MESSAGE DIALOG -->
	<div style="display: none;" id="dialog_message" title="Conversation: John Doe">
		<div class="spacer"></div>
		<div class="messages full chat">
			
			<div class="msg reply">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/iconsweets2/25x25/user-2.png"/>
				<div class="content">
					<h3><a href="pages_profile.html">John Doe</a> <span>says:</span><small>3 hours ago</small></h3>
					<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore
					et dolore magna aliquyam erat, sed diam voluptua.</p>
				</div>
			</div>
			
			<div class="msg">
				<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/iconsweets2/25x25/user-2.png"/>
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
<!-- end: MESSAGE DIALOG -->