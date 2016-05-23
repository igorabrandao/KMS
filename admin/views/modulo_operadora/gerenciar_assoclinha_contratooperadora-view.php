							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Gerenciar Associações de Linhas">Gerenciar Associações de Linhas <small>gestão </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

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
										<table class="table table-striped table-bordered table-hover" id="sample_1">
											<thead>
												<tr>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="Nº DA CONTA">Nº DA CONTA</th>
													<th style="white-space: nowrap; text-align: center; width: 20%;" title=""></th>
													<th style="white-space: nowrap; text-align: center; width: 20%;" title="QUANTIDADE DE LINHAS">QUANTIDADE DE LINHAS</th>
													<th style="white-space: nowrap; text-align: center; width: 20%;" title="QUANTIDADE DE PLANOS">QUANTIDADE DE PLANOS</th>
													<th style="white-space: nowrap; text-align: center; width: 20%;" title="QUANTIDADE DE MÓDULOS">QUANTIDADE DE MÓDULOS</th>
												</tr>
											</thead>
											<tbody>
												<?php

													// Auxiliary variable
													$count = 0;
													$colspan = 5;
													$n_conta = 0;
													$reg_counter = 0;

													// Get the contract list
													$contract_list = $modelo->get_contract_list();

													// Run through service list
													foreach ( $contract_list as $c_list )
													{
														// Get the entire report
														$data_value = $modelo->get_contract_list_count( $c_list["N_CONTA"] );

														// Run through service list
														foreach ( $data_value as $value )
														{
															// Init row
															echo "<tr>";

															// Contract number
															if ( isset($value["N_CONTA"]) && $value["N_CONTA"] != "" )
															{
																echo "<td style='text-align: center;' title='" . $value["N_CONTA"] . "' >" . $value["N_CONTA"] . "</td>";
																$n_conta = $value["N_CONTA"];
															}
															else
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

															// Action buttons
															$assocs_count = $modelo->count_phone_assocs($value["N_CONTA"]);

															echo "<td class='center'>";
															echo "<div class='visible-md visible-lg hidden-sm hidden-xs'>";

															// Check if the contract number already have an association register
															if ( $assocs_count == 0 )
															{
																echo "<a href='" . HOME_URI . "/modulo_operadora/assoclinha_contratooperadora?n_contract=" . encrypt_decrypt('encrypt', $value["N_CONTA"]) . "' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Associar linhas nº conta: " . $value["N_CONTA"] . "'><i class='fa fa-exchange'></i></a>&nbsp;";
															}
															else
															{
																echo "<a href='" . HOME_URI . "/modulo_operadora/visualizar_assoclinha_contratooperadora?n_contract=" . encrypt_decrypt('encrypt', $value["N_CONTA"]) . "' class='btn btn-xs btn-warning tooltips' data-placement='top' data-original-title='Visualizar associações do nº conta: " . $value["N_CONTA"] . "'><i class='clip-search'></i></a>&nbsp;";
																echo "<a href='" . HOME_URI . "/modulo_operadora/assoclinha_contratooperadora?action=edit&n_contract=" . encrypt_decrypt('encrypt', $value["N_CONTA"]) . "' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Editar associações do nº conta: " . $value["N_CONTA"] . "'><i class='fa fa-edit'></i></a>&nbsp;";
																echo "<a onClick='deleteAssociation(" . $value["N_CONTA"] . ");' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remover associação'><i class='fa fa-times fa fa-white'></i></a>";
															}

															echo "</div></td>";

															// Phone count
															if ( isset($value["QTD_LINHAS"]) && $value["QTD_LINHAS"] != "" )
																echo "<td style='text-align: center;' title='" . $value["QTD_LINHAS"] . "' >" . $value["QTD_LINHAS"] . "</td>";
															else
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

															// Plan count
															if ( isset($value["QTD_PLANO_CONTRATO"]) && $value["QTD_PLANO_CONTRATO"] != "" )
																echo "<td style='text-align: center;' title='" . $value["QTD_PLANO_CONTRATO"] . "' >" . $value["QTD_PLANO_CONTRATO"] . "</td>";
															else
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

															// Module count
															if ( isset($value["QTD_MODULO_CONTRATO"]) && $value["QTD_MODULO_CONTRATO"] != "" )
																echo "<td style='text-align: center;' title='" . $value["QTD_MODULO_CONTRATO"] . "' >" . $value["QTD_MODULO_CONTRATO"] . "</td>";
															else
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

															// End content
															echo "</tr>";
															$reg_counter++;
														}
													}
												?>
											</tbody>
										</table>

										<input type="hidden" id="elem_DUMMY" value=""/>

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

			/** Function to delete the contract associantio
			 * @param contract_ID_ => contract identification
			*/
			function deleteAssociation( contract_ID_ )
			{
				if ( confirm("Realmente deseja excluir a associção?") == true )
				{
					// Callback to delete the element
					sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/gerenciar_assoclinha_contratooperadora', 'action=delete&contract_ID=' + contract_ID_, 'POST', 
						'///', document.getElementById('elem_DUMMY'), 'delete' );

					// Realod the page withou parameters
					window.location = window.location.href.split("?")[0];
				}
				else
				{
					return false;
				}
			}

		</script>