<!-- start: SIDEBAR -->
	<aside>
		<div class="top">

			<!-- Navigation -->
			<nav><ul class="collapsible accordion">

				<li <?php if ( $GLOBALS['ACTIVE_TAB'] == 'Dashboard' ) echo "class='current'"; ?> >
					<a href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI)); ?>">
						<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/dashboard.png" alt="" height=16 width=16>
						Página Inicial
					</a>
				</li>

				<li <?php if ( $GLOBALS['ACTIVE_TAB'] == 'Usuario' ) echo "class='current'"; ?> >
					<a href="<?php echo join(DIRECTORY_SEPARATOR, array(HOME_URI, 'modulo_usuario')); ?>">
						<img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/users.png" alt="" height=16 width=16>
						Usuários
					</a>
				</li>

				<li>
					<a href="javascript:void(0);"><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>Frequência<span class="badge">4</span></a>
				</li>

				<li>
					<a href="javascript:void(0);"><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>Exames de faixa<span class="badge">4</span></a>
				</li>

				<li>
					<a href="javascript:void(0);"><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>Relatórios<span class="badge">4</span></a>
				</li>

				<li>
					<a href="javascript:void(0);"><img src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>Pagamentos<span class="badge">4</span></a>
				</li>
				
			</ul></nav><!-- End of nav -->				
		</div><!-- End of .top -->
		
		<div class="bottom sticky">
			<div class="divider"></div>
			<div class="progress">
				<div class="bar" data-title="Space" data-value="1285" data-max="5120" data-format="0,0 MB"></div>
				<div class="bar" data-title="Traffic" data-value="8.61" data-max="14" data-format="0.00 GB"></div>
				<div class="bar" data-title="Budget" data-value="20000" data-max="20000" data-format="$0,0"></div>
			</div>
			<div class="divider"></div>
			<div class="buttons">
				<a href="javascript:void(0);" class="button grey open-add-client-dialog">Add New Client</a>
				<a href="javascript:void(0);" class="button grey open-add-client-dialog">Open a Ticket</a>
			</div>
		</div><!-- End of .bottom -->
	</aside>
<!-- end: SIDEBAR -->