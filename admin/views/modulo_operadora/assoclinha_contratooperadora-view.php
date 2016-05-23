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
							if ( isset($_GET['action']) && $_GET['action'] == 'edit' )
							{
								// Load insert/edit method
								$assoc_info = $modelo->load_assocs($contract_id);
							}
							else
								$assoc_info = "";
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

														// Plans vertical checks
														echo "</tr><tr>";

														// Checkbox ALL
														/*echo '<th style="white-space: nowrap; text-align: center;" title="Selecionar tudo">
														<input type="checkbox" title="Selecionar tudo" style="height: 20px; width: 20px; display: none;"
														id="CHK_ALL" name="CHK_ALL" onChange="checkAll(this);" ></th>';*/

														echo '<th colspan="2" style="white-space: nowrap; text-align: center; title="Selecionar por grupo">Selecionar por grupo:</th>';
														$column_position = 0;

														// Plans vertical checks
														for ( $x = 0; $x < $total_plan; $x++ )
														{
															// Vertical checkboxes
															echo '<th style="white-space: nowrap; text-align: center;" title="Selecionar todas as linhas com este plano/serviço">
															<input type="checkbox" title="Selecionar todas as linhas com este plano/serviço" style="height: 20px; width: 20px;"
															id="CHK_PLAN' . $column_position  . '" name="CHK_PLAN' . $column_position . '" onChange="checkVertical(this.name);
															checkError( this, ' . $plan_list[$x]["QUANTIDADE_PLANO"] . ', \'' . $plan_list[$x]["DESCRITIVO_PLANO"] . '\', \'plan\', 1 );"></th>';
															$column_position++;
														}

														// Modules vertical checks
														for ( $x = 0; $x < $total_module; $x++ )
														{
															// Vertical checkboxes
															echo '<th style="white-space: nowrap; text-align: center;" title="Selecionar todas as linhas com este plano/serviço">
															<input type="checkbox" title="Selecionar todas as linhas com este plano/serviço" style="height: 20px; width: 20px;"
															id="CHK_MODULE' . $column_position  . '" name="CHK_MODULE' . $column_position . '" onChange="checkVertical(this.name);
															checkError( this, ' . $module_list[$x]["QUANTIDADE_MODULO"] . ', \'' . $module_list[$x]["DESCRITIVO_MODULO"] . '\', \'module\', 1 );"></th>';
															$column_position++;
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
																// Horizontal checkboxes
																echo '<td style="white-space: nowrap; text-align: center;" title="Selecionar todos os planos e serviços para o acesso ' . $value["LINHA"] . '">
																<input type="checkbox" title="Selecionar todos os planos e serviços para o acesso ' . $value["LINHA"] . '" style="height: 20px; width: 20px;"
																id="CHK_HORIZONTAL' . $value["ID_PEC_LINHA"] . '" name="CHK_HORIZONTAL" data-rowid="row' . $count . '" onChange="checkHorizontal(this);
																"></td>';

																echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
															}
															else
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

															// Plans horizontal checks
															$column_position = 0;
															for ( $x = 0; $x < $total_plan; $x++ )
															{
																echo '<td style="white-space: nowrap; text-align: center;" title="' . $value["LINHA"] . " x " . $plan_list[$x]["DESCRITIVO_PLANO"] . '">
																<input ' . $checked . ' type="checkbox" title="' . $value["LINHA"] . " x " . $plan_list[$x]["DESCRITIVO_PLANO"] . '" style="height: 20px; width: 20px;"
																id="CHK_PLAN' . $value["LINHA"] . '/' . $plan_list[$x]["ID_PLANO_CONTRATO"] . '" name="CHK_PLAN' . $column_position . '" data-desc="' . $plan_list[$x]["DESCRITIVO_PLANO"] . '" data-limit="elem_LIMITPLAN' . $x . '"  data-qtd="' . $plan_list[$x]["QUANTIDADE_PLANO"] .  '" data-type="plan"
																onChange="parseAssoc( this ); checkError( this, ' . $plan_list[$x]["QUANTIDADE_PLANO"] . ', \'' . $plan_list[$x]["DESCRITIVO_PLANO"] . '\', \'plan\', 0 );"></td>';

																$column_position++;
															}

															// Modules horizontal checks
															for ( $x = 0; $x < $total_module; $x++ )
															{
																echo '<td style="white-space: nowrap; text-align: center;" title="' . $value["LINHA"] . " x " . $module_list[$x]["DESCRITIVO_MODULO"] . '">
																<input ' . $checked . ' type="checkbox" title="' . $value["LINHA"] . " x " . $module_list[$x]["DESCRITIVO_MODULO"] . '" style="height: 20px; width: 20px;"
																id="CHK_MODULE' . $value["LINHA"] . '/' . $module_list[$x]["ID_MODULO_CONTRATO"] . '" name="CHK_MODULE' . $column_position . '" data-desc="' . $module_list[$x]["DESCRITIVO_MODULO"] . '" data-limit="elem_LIMITMODULE' . $x . '" data-qtd="' . $module_list[$x]["QUANTIDADE_MODULO"] .  '" data-type="module"
																onChange="parseAssoc( this ); checkError( this, ' . $module_list[$x]["QUANTIDADE_MODULO"] . ', \'' . $module_list[$x]["DESCRITIVO_MODULO"] . '\', \'module\', 0 );"></td>';

																$column_position++;
															}

															// End content
															echo "</tr>";
															$count += 1;
														}

														// Fill the list of plans that'll be ckecked
														if ( isset($_GET['action']) && $_GET['action'] == 'edit' )
														{
															foreach ( $assoc_info as $value_check )
															{
																if ( trim($value_check["ID_PLANO_CONTRATO"]) != "" )
																	$list_plan_selected .= "CHK_PLAN" . trim($value_check["LINHA"]) . "/" . $value_check["ID_PLANO_CONTRATO"] . "//";
															}
														}

														// Fill the list of modules that'll be ckecked
														if ( isset($_GET['action']) && $_GET['action'] == 'edit' )
														{
															foreach ( $assoc_info as $value_check )
															{
																if ( trim($value_check["ID_MODULO_CONTRATO"]) != "" )
																	$list_module_selected .= "CHK_MODULE" . trim($value_check["LINHA"]) . "/" . $value_check["ID_MODULO_CONTRATO"] . "//";
															}
														}
													?>
												</tbody>
												<tfoot>
													<?php

														// Filter checks
														echo "<tr>";

														// Auxiliary variables
														$column_position = 0;

														echo '<th colspan="2" style="color: #FFFFFF; white-space: nowrap; text-align: center;
														background: -webkit-linear-gradient(#002F49, #206C86); /* For Safari 5.1 to 6.0 */
														background: -o-linear-gradient(#002F49, #206C86); /* For Opera 11.1 to 12.0 */
														background: -moz-linear-gradient(#002F49, #206C86); /* For Firefox 3.6 to 15 */
														background: linear-gradient(#002F49, #206C86); /* Standard syntax */ " 
														title="Filtrar por coluna">Filtrar por coluna:</th>';

														// Plans vertical checks
														for ( $x = 0; $x < $total_plan; $x++ )
														{
															// Vertical checkboxes
															echo '<th style="white-space: nowrap; text-align: center;
															background: -webkit-linear-gradient(#002F49, #206C86); /* For Safari 5.1 to 6.0 */
															background: -o-linear-gradient(#002F49, #206C86); /* For Opera 11.1 to 12.0 */
															background: -moz-linear-gradient(#002F49, #206C86); /* For Firefox 3.6 to 15 */
															background: linear-gradient(#002F49, #206C86); /* Standard syntax */ "
															" title="Filtrar pela coluna: ' . $plan_list[$x]["DESCRITIVO_PLANO"] . '">
															<input type="checkbox" title="Filtrar pela coluna: ' . $plan_list[$x]["DESCRITIVO_PLANO"] . '" style="height: 20px; width: 20px;"
															id="CHK_FILTROPLAN' . $column_position . '" name="CHK_FILTRO"></th>';
															$column_position++;
														}

														// Modules vertical checks
														for ( $x = 0; $x < $total_module; $x++ )
														{
															// Vertical checkboxes
															echo '<th style="white-space: nowrap; text-align: center;
															background: -webkit-linear-gradient(#002F49, #206C86); /* For Safari 5.1 to 6.0 */
															background: -o-linear-gradient(#002F49, #206C86); /* For Opera 11.1 to 12.0 */
															background: -moz-linear-gradient(#002F49, #206C86); /* For Firefox 3.6 to 15 */
															background: linear-gradient(#002F49, #206C86); /* Standard syntax */ " 
															title="Filtrar pela coluna: ' . $module_list[$x]["DESCRITIVO_MODULO"] . '">
															<input type="checkbox" title="Filtrar pela coluna: ' . $module_list[$x]["DESCRITIVO_MODULO"] . '" style="height: 20px; width: 20px;"
															id="CHK_FILTROMODULE' . $column_position . '" name="CHK_FILTRO"></th>';
															$column_position++;
														}

														// Plans vertical checks
														echo "</tr>";

													?>
												</tfoot>
											</table>

											<?php

												// Plans hidden field
												for ( $x = 0; $x < $total_plan; $x++ )
												{
													echo '<input type="hidden" id="elem_LIMITPLAN' . $x . '" value="0"/>';
												}

												// Modules hidden field
												for ( $x = 0; $x < $total_module; $x++ )
												{
													echo '<input type="hidden" id="elem_LIMITMODULE' . $x . '" value="0"/>';
												}

											?>

											<input type="hidden" id="elem_DUMMY" value=""/>
											<input type="hidden" id="elem_ASSOC" value=""/>
											<input type="hidden" id="elem_CONTRACT" value="<?php echo $contract_id; ?>"/>
											<input type="hidden" id="elem_QTD" value="<?php echo $total_plan + $total_module; ?>"/>

											<div class="row">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-4">
															<button id="btnSubmit" data-style="expand-right" class="btn btn-blue btn-block ladda-button" type="button" title="Associar linhas">
																<span class="ladda-label"> Associar linhas </span>
																<i class="fa fa-arrow-circle-right"></i>
																<span class="ladda-spinner"></span>
																<span class="ladda-progress" style="width: 0px;"></span>
															</button>
														</div>
													</div>
												</div>
											</div>
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

			var flag_delete = 0;
			var results = [];

			/** Function to check if the associations contains error
			 * @param elem_ => element to receive the parse result
			 * @param limit_ => the limit of checkboxes
			 * @param description_ => the plan/module description
			 * @param plan_module_ => flag to define if the check refers to a plan/module
			 * @param batch_ => flag to define if the function was called individually or from a batch
			 *					0 = No batch / 1 = Vertical batch / 2 = Horizontal batch
			*/
			function checkError( elem_, limit_, description_, plan_module_, batch_ )
			{
				// Auxiliary variable
				var checked_counter = 0;
				var alerted = 0;

				// Get the specific attributes
				var qtd_limit = elem_.getAttribute("data-qtd");
				var elem_limit = document.getElementById(elem_.getAttribute("data-limit"));
				var flag_alert = 0;

				// Validate each limit
				if ( qtd_limit != null && elem_limit != null )
				{
					if ( elem_limit.value > qtd_limit )
						flag_alert = 1;
				}

				// Track the element itself
				var checks = document.getElementsByName( elem_.name );

				// Run through all checks
				for ( var i = 1; i < checks.length; i++ )
				{
					if ( checks[i].checked == true )
						checked_counter++;
				}

				// Check if the limit was crossed
				if ( parseInt(checked_counter) > parseInt(limit_) || flag_alert == 1 )
				{
					// Clean individually
					/*if ( batch_ == 0 || batch_ == 2 )
						elem_.checked = false;*/

					if ( batch_ == 0 || ( batch_ == 1 && alerted == 0 && elem_.checked == true ) || batch_ == 2 )
					{
						// Check if it's a plan or module
						if ( plan_module_ == "plan" )
						{
							if ( parseInt(limit_) == 1 )
								alert("Para este contrato, foi definido " + limit_ + " plano do tipo: " + description_ + ". O limite de associações foi atingido!");
							else
								alert("Para este contrato, foram definidos " + limit_ + " planos do tipo: " + description_ + ". O limite de associações foi atingido!");
						}
						else
						{
							if ( parseInt(limit_) == 1 )
								alert("Para este contrato, foi definido " + limit_ + " módulo do tipo: " + description_ + ". O limite de associações foi atingido!");
							else
								alert("Para este contrato, foram definidos " + limit_ + " módulos do tipo: " + description_ + ". O limite de associações foi atingido!");
						}
						alerted++;
					}

					// Clear all checks
					/*if ( batch_ == 1 )
					{
						// Run through all checks
						for ( var i = 0; i < checks.length; i++ )
						{
							checks[i].checked = false;
						}
					}*/

					return false;
				}

				return true;
			}

			/** Function check the vertical checkboxes
			 * @param elem_ => element to receive the parse result
			*/
			function checkVertical( elem_ )
			{
				// Track the element itself
				var checks = document.getElementsByName( elem_ );

				// Run through all checks
				for ( var i = 1; i < checks.length; i++ )
				{
					if ( checks[0].checked == true )
						checks[i].checked = true;
					else
						checks[i].checked = false;
					parseAssoc( checks[i] );
				}
			}

			/** Function the horizontal checkboxes
			 * @param elem_ => element to receive the parse result
			*/
			function checkHorizontal( elem_ )
			{
				// Track the element list in a row
				var cbs = document.getElementById(elem_.dataset.rowid).querySelectorAll('[type="checkbox"]');
				var desc;
				var qtd;
				var type;

				[].forEach.call(cbs, function(x)
				{
					x.checked = elem_.checked;

					// Get the specific attributes
					desc = x.getAttribute("data-desc");
					qtd = x.getAttribute("data-qtd");
					type = x.getAttribute("data-type");

					parseAssoc( x );

					// Validate each column
					if ( desc != null && qtd != null && type != null )
					{
						checkError( x, qtd, desc, type, 2 );
					}
				});
			}

			/** Function to check all checkboxes
			 * @param elem_ => element to receive the parse result
			*/
			function checkAll( elem_ )
			{
				// Track the element list in all table
				var cbs = document.getElementsByTagName('input');

				// Run through all elements
				for ( var i = 0; i < cbs.length; i++ )
				{
					// Check if the select all is true or false
					if ( cbs[i].type == 'checkbox' )
					{
						cbs[i].checked = elem_.checked;
						parseAssoc( cbs[i] );
					}
				}
			}

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
						document.getElementById(list[i].toString().trim()).checked = true;
						parseAssoc( document.getElementById(list[i].toString().trim()) );
					}
				}
			}

			/** Function to delete the previous association
			*/
			function deleteAssoc()
			{
				var contract_ID = document.getElementById("elem_CONTRACT").value;

				// Delete the elements first
				if ( flag_delete == 0 )
				{
					sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/assoclinha_contratooperadora', 'action2=delete&contract_ID=' + contract_ID, 'POST', 
						'///', document.getElementById('elem_DUMMY'), 'delete' );

					flag_delete = 1;
				}
			}

			String.prototype.replaceAll = function(search, replacement) {
				var target = this;
				return target.split(search).join(replacement);
			};

			/** Function to add the association value to the element
			 * @param chk_ => the element to be inserted
			*/
			function parseAssoc( chk_ )
			{
				// Association elements
				var elem_ASSOC = document.getElementById('elem_ASSOC');
				var aux_assoc, aux_value = "";
				var elem_limit = document.getElementById(chk_.getAttribute("data-limit"));

				// Plan
				if ( chk_.id.toString().indexOf("CHK_PLAN") > -1 )
				{
					aux_assoc = chk_.id.toString().replace("CHK_PLAN", "").split("/");
					aux_value += aux_assoc[0] + "@@P" + aux_assoc[1] + "//";
				}
				// Module
				else if ( chk_.id.toString().indexOf("CHK_MODULE") > -1 )
				{
					aux_assoc = chk_.id.toString().replace("CHK_MODULE", "").split("/");
					aux_value += aux_assoc[0] + "@@M" + aux_assoc[1] + "//";
				}

				// Add the value
				if ( chk_.id.toString().indexOf("/") > -1 && chk_.checked == true )
				{
					elem_ASSOC.value += aux_value;

					if ( elem_limit != null )
						elem_limit.value = parseInt(elem_limit.value) + 1;
				}
				// Remove the value
				else
				{
					elem_ASSOC.value = elem_ASSOC.value.replaceAll(aux_value, "");

					if ( elem_limit != null )
						elem_limit.value = parseInt(elem_limit.value) - 1;
				}
			}

			/** Function to save the association
			*/
			function saveAssoc()
			{
				// Track the element list in all table
				var elem_ASSOC = document.getElementById('elem_ASSOC');
				var contract_ID = document.getElementById("elem_CONTRACT").value;
				var qtd_plan_module = parseInt(document.getElementById("elem_QTD").value); // row length
				var assoc_array = elem_ASSOC.value.split("//");
				var aux_assoc = new Array(Math.ceil(assoc_array.length/qtd_plan_module));
				var j = 0;

				while ( assoc_array.length )
				{
					aux_assoc[j] = assoc_array.splice(0, qtd_plan_module);
					j++;
				}

				for ( var i = 0; i < aux_assoc.length; i++ )
				{
					if ( aux_assoc[i] != "" )
					{
						results.push( sendRequestAjax( '<?php echo HOME_URI;?>/modulo_operadora/assoclinha_contratooperadora?action2=insert&contract_ID=' + contract_ID + '&data=' + aux_assoc[i].toString().replaceAll(",", "//"), 'POST', 'text') );
					}
				}
			}

			/** Function to show a message to the user and redirect the page
			*/
			function showMessage()
			{
				alert("Associação registrada com sucesso!");
				window.location.href = "<?php echo HOME_URI;?>/modulo_operadora/gerenciar_assoclinha_contratooperadora";
			}

		</script>

		<?php

			// Call the function to check automaticaly the checkboxes
			if ( isset($_GET['action']) && $_GET['action'] == 'edit' )
			{
				?><script>checkAllAfterLoad( "<?php echo $list_plan_selected; ?>" );</script><?php
				?><script>checkAllAfterLoad( "<?php echo $list_module_selected; ?>" );</script><?php
			}

		?>