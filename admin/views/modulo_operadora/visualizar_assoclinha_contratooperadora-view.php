							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Associar Linhas">Associar Linhas <small>gestão </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php

						// Check if the contract ID is valid
						if ( isset($_GET['n_contract']) && $_GET['n_contract'] != '' )
						{
							$contract_id = encrypt_decrypt('decrypt', $_GET['n_contract']);

							// Load insert/edit method
							//$modelo->insert_assoc_linha();

							// Check the action type
							$assoc_info = $modelo->load_assocs($contract_id);
						}

						// Check if the contract ID is valid
						if ( !isset($contract_id) || $contract_id == "" )
						{
							// Return a message
							?><script>alert("Houve um problema com o identificador do contrato. Por favor, acesse novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_operadora/gerenciar_assoclinha_contratooperadora";</script> <?php
							return false;
						}

					?>

					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> </a>
										<a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="fa fa-refresh"></i> </a>
										<a class="btn btn-xs btn-link panel-expand" href="#"> <i class="fa fa-resize-full"></i> </a>
										<a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
									</div>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12 space20">
											<div class="btn-group pull-right">
												<button data-toggle="dropdown" class="btn btn-light-grey dropdown-toggle">
													Exportar para... <i class="fa fa-angle-down"></i>
												</button>
												<ul class="dropdown-menu dropdown-light pull-right">
													<li><a href="#" class="export-pdf" data-table="#sample_1"> Exportar para PDF </a></li>
													<li><a href="#" class="export-excel" data-table="#sample_1"> Exportar para Excel </a></li>
													<li><a href="#" class="export-powerpoint" data-table="#sample_1"> Exportar para PowerPoint </a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<form action="#" role="form" id="frmAssocLinha" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<thead>
													<?php
													
														// Auxiliary variable
														$total_plan = 0;
														$total_module = 0;

														// Get the plan list
														$plan_list = $modelo->load_plans_assoc($contract_id);

														// Get the module list
														$module_list = $modelo->load_modules_assoc($contract_id);

														// Run through plan list
														foreach ( $plan_list as $plan_value )
														{
															if ( isset($plan_value["DESCRITIVO_PLANO"]) )
																$total_plan += 1;
														}

														// Run through module list
														foreach ( $module_list as $module_value )
														{
															if ( isset($module_value["DESCRITIVO_MODULO"]) )
																$total_module += 1;
														}

														// Calculate the column size
														$column_size = 100/($total_plan + $total_module + 2);

														// Open the superior column
														echo "<tr>";

														// Print the columns
														echo "<th rowspan='2' style='width: 5%; text-align: center; white-space: nowrap'></th>";
														echo "<th rowspan='2' style='width: 10%; white-space: nowrap; text-align: center; white-space: nowrap' title='ACESSOS'>ACESSOS</th>";

														// Check if at least one plan will be printed
														if ( sizeof($plan_list) > 0 )
															echo "<th colspan='" . $total_plan . "' style='width: " . $column_size . "%; text-align: center' title='PLANOS'>PLANOS</th>";

														// Check if at least one module will be printed
														if ( sizeof($module_list) > 0 )
															echo "<th colspan='" . $total_module . "' style='width: " . $column_size . "%; text-align: center' title='MÓDULOS'>MÓDULOS</th>";

														// Close the superior columns
														echo "</tr><tr>";

														// Print the sub-columns (plans)
														foreach ( $plan_list as $plan_value )
														{
															echo "<th style='width: " . $column_size . "%; text-align: center' title='" . $plan_value["DESCRITIVO_PLANO"] . "' >" . $plan_value["DESCRITIVO_PLANO"] . "</th>";
														}

														// Print the sub-columns (module)
														foreach ( $module_list as $module_value )
														{
															echo "<th style='width: " . $column_size . "%; text-align: center' title='" . $module_value["DESCRITIVO_MODULO"] . "' >" . $module_value["DESCRITIVO_MODULO"] . "</th>";
														}

														echo "</tr>";

													?>
												</thead>
												<tbody>
													<?php

														// Auxiliary variable
														$count = 0;
														$colspan = 1;
														$checked = "";
														$id_assoc = "";
														$list_plan_selected = "";
														$list_module_selected = "";

														// Get the phone number list
														$phone_list = $modelo->load_phone_numbers_assoc($contract_id);

														// Run through phone number list
														foreach ( $phone_list as $value )
														{
															// Init row
															echo "<tr id='row" . $count . "'>";

															// Phone numer
															if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
															{
																echo "<td style='white-space: nowrap; text-align: center;' ></td>";
																echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
															}
															else
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

															// Plans horizontal checks
															for ( $x = 0; $x < $total_plan; $x++ )
															{
																echo '<td id="CHK_PLAN' . $value["LINHA"] . '/' . $plan_list[$x]["ID_PLANO_CONTRATO"] . '" name="CHK_PLAN' . $x . '" style="white-space: nowrap; text-align: center;" title="' . $value["LINHA"] . " x " . $plan_list[$x]["DESCRITIVO_PLANO"] . '"></td>';
															}

															// Modules horizontal checks
															for ( $x = 0; $x < $total_module; $x++ )
															{
																echo '<td id="CHK_MODULE' . $value["LINHA"] . '/' . $module_list[$x]["ID_MODULO_CONTRATO"] . '" name="CHK_MODULE' . $x . '" style="white-space: nowrap; text-align: center;" title="' . $value["LINHA"] . " x " . $module_list[$x]["DESCRITIVO_MODULO"] . '"></td>';
															}

															// End content
															echo "</tr>";
															$count += 1;
														}

														// Fill the list of plans that'll be ckecked
														foreach ( $assoc_info as $value_check )
														{
															if ( trim($value_check["ID_PLANO_CONTRATO"]) != "" )
																$list_plan_selected .= "CHK_PLAN" . trim($value_check["LINHA"]) . "/" . $value_check["ID_PLANO_CONTRATO"] . "//";
														}

														// Fill the list of modules that'll be ckecked
														foreach ( $assoc_info as $value_check )
														{
															if ( trim($value_check["ID_MODULO_CONTRATO"]) != "" )
																$list_module_selected .= "CHK_MODULE" . trim($value_check["LINHA"]) . "/" . $value_check["ID_MODULO_CONTRATO"] . "//";
														}
													?>
												</tbody>
											</table>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->

		<script type="text/javascript">

			/** Function to check all checkboxes after load
			 * @param list_ => the list of checkboxes to be selected
			*/
			function checkAllAfterLoad( list_ )
			{
				// Track each checkbox to be selected
				var list = list_.toString().split("//");

				// Run through all checkboxes
				for ( var i = 0; i < list.length; i++ )
				{
					// Check all of checkboxes inside the list
					if ( document.getElementById(list[i]) != null )
					{
						document.getElementById(list[i].toString().trim()).innerHTML = "X";
					}
				}
			}

		</script>

		<?php

			// Call the function to check automaticaly the checkboxes
			?><script>checkAllAfterLoad( "<?php echo $list_plan_selected; ?>" );</script><?php
			?><script>checkAllAfterLoad( "<?php echo $list_module_selected; ?>" );</script><?php

		?>