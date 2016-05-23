							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<!--<h1 title="Estamos processando o seu pedido...">Estamos processando o seu pedido...</h1>
								<div class="col-md-6">
									<div class="row">
										<div class="progress progress-striped active progress-sm">
											<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
												<span class="sr-only"> 40% Complete (success)</span>
											</div>
										</div>
									</div>
								</div>-->
							</div>
							<hr>
							<!-- end: PAGE TITLE -->

							<?php
								ini_set('MAX_EXECUTION_TIME', -1);

								// Call extract function
								$modelo->extract_PEC();

								// Define the carrier
								$modelo->getCarrier_PEC($modelo->getContent());

								// Get basic information about PEC
								$modelo->getInfo_PEC($modelo->getContent());

								// Get the list of services from PEC
								$modelo->getServices_PEC($modelo->getContent());

								// Get the list of phone numbers from PEC
								$modelo->getPhones_PEC($modelo->getContent());

								// Get the other entries
								$modelo->getOtherEntries_PEC($modelo->getContent());

								// Associate de services with phone numbers
								$modelo->associatePhoneService_PEC($modelo->getContent());

								// Set status processing false
								$modelo->setStatusProcessing(true);
							?>

						</div>
					</div>
					<!-- end: PAGE HEADER -->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->

		<script>

			/** Function to open loading modal
			*/
			function openModal()
			{
				// Auxiliar variables
				var modal_load = document.getElementById("modal_loading");

				// Update data from database
				$('#modal_loading').modal('show');
			}

			/** Function to close loading modal
			*/
			function closeModal()
			{
				// Auxiliar variables
				var modal_load = document.getElementById("modal_loading");
				var btn_close = document.getElementById("btn_close");

				// Timeout to close modal
				setTimeout(function ()
				{
					btn_close.click();
				}, 2000);
			}

		</script>