							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Contrato Operadoras">Contrato Operadoras <small>gestão </small></h1>
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
											<button class="btn btn-blue add-row" onClick="javascript:window.location.href='<?php echo HOME_URI;?>/modulo_operadora/cadastrar_contratooperadora';">
												Adicionar contrato <i class="fa fa-plus"></i>
											</button>
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
													<th style="white-space: nowrap; text-align: center; width: 5%;" title="Nº DA CONTA">Nº DA CONTA</th>
													<th style="white-space: nowrap; text-align: center; width: 20%;" title=""></th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="TIPO DE CONTRATO">TIPO CONTRATO</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="TIPO DE SERVIÇO">TIPO SERVIÇO</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="OPERADORA">OPERADORA</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="DATA DE ASSINATURA">DATA ASSINATURA</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="DATA DE ATIVAÇÃO">DATA ATIVAÇÃO</th>
													<th style="white-space: nowrap; text-align: center; width: 8%;" title="CARÊNCIA">CARÊNCIA</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="OPERADORA">QTD LINHAS</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="VALOR TOTAL(R$)">VALOR TOTAL(R$)</th>
												</tr>
											</thead>
											<tbody>
												<?php

													// Auxiliary variable
													$total_value = 0;
													$total_phone_numbers = 0;
													$subtotal_value = 0;
													$count = 0;
													$colspan = 8;
													$n_conta = 0;
													$reg_counter = 0;

													// Get the entire report
													$data_value = $modelo->get_carrier_contract_list();

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
														echo "<td class='center'>";
														echo "<div class='visible-md visible-lg hidden-sm hidden-xs'>";
														echo "<a href='" . encrypted_url($value["ID_CONTRATO_OPERADORA"], HOME_URI . "/modulo_operadora/visualizar_contratooperadora?n_contract=") . "' class='btn btn-xs btn-warning tooltips' data-placement='top' data-original-title='Visualizar'><i class='clip-search'></i></a>&nbsp;";
														echo "<a href='" . encrypted_url($value["ID_CONTRATO_OPERADORA"], HOME_URI . "/modulo_operadora/editar_contratooperadora?n_contract=") . "' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Editar'><i class='fa fa-edit'></i></a>&nbsp;";
														echo "<a href='" . encrypted_url($value["ID_CONTRATO_OPERADORA"], HOME_URI . "/modulo_operadora/cadastrar_contratooperadora?n_contract=") . "' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Adicionar contrato associado'><i class='fa fa-plus'></i></a>&nbsp;";
														echo "<a onClick='deleteContract(" . $value["ID_CONTRATO_OPERADORA"] . ");' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remover'><i class='fa fa-times fa fa-white'></i></a>";
														echo "</div></td>";

														// Contract type
														if ( isset($value["TIPO_CONTRATO"]) && $value["TIPO_CONTRATO"] != "" )
															echo "<td style='text-align: center;' title='" . $value["TIPO_CONTRATO"] . "' >" . $value["TIPO_CONTRATO"] . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Service type
														if ( isset($value["TIPO_SERVICO"]) && $value["TIPO_SERVICO"] != "" )
															echo "<td style='text-align: center;' title='" . $value["TIPO_SERVICO"] . "' >" . $value["TIPO_SERVICO"] . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Carrier name
														if ( isset($value["NOME_OPERADORA"]) && $value["NOME_OPERADORA"] != "" )
															echo "<td style='text-align: center;' title='" . $value["NOME_OPERADORA"] . "' >" . $value["NOME_OPERADORA"] . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Sign date
														if ( isset($value["DATA_ASSINATURA"]) && $value["DATA_ASSINATURA"] != "" )
															echo "<td style='text-align: center;' title='" . $value["DATA_ASSINATURA"] . "' >" . $value["DATA_ASSINATURA"] . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Activation date
														if ( isset($value["DATA_ATIVACAO"]) && $value["DATA_ATIVACAO"] != "" )
															echo "<td style='text-align: center;' title='" . $value["DATA_ATIVACAO"] . "' >" . $value["DATA_ATIVACAO"] . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Carência
														if ( isset($value["CARENCIA"]) && $value["CARENCIA"] != "" )
															echo "<td style='text-align: center;' title='" . $value["CARENCIA"] . " meses' >" . $value["CARENCIA"] . " meses</td>";
														else
															echo "<td style='text-align: center;'> - </td>";

														// Phone number quantity
														if ( isset($value["QTD_LINHAS"]) && $value["QTD_LINHAS"] != "" )
														{
															echo "<td style='text-align: center;' title='" . $value["QTD_LINHAS"] . "' >" . $value["QTD_LINHAS"] . "</td>";
															$total_phone_numbers += (int)$value["QTD_LINHAS"];
														}
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Value
														if ( isset($value["VALOR_TOTAL_CONTRATO"]) && $value["VALOR_TOTAL_CONTRATO"] != "" )
														{
															$aux_value = str_replace(",", ".", $value["VALOR_TOTAL_CONTRATO"]);
															$aux_value = remove_double_dots($aux_value);
															$subtotal_value = real_sum($subtotal_value, $aux_value);

															if ( isset($subtotal_value) )
															{
																echo "<td style='text-align: center;' title='" . real_currency($subtotal_value) . "'>" . real_currency($subtotal_value) . "</td>";

																// Total sum
																$total_value = real_sum($total_value, $subtotal_value);
															}
														}
														else
															echo "<td style='text-align: center;'> - </td>";

														// End content
														echo "</tr>";
														$subtotal_value = 0;
														$reg_counter++;
													}
												?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="<?php echo $colspan; ?>" style="text-align: center; white-space: nowrap;"><h4>Subtotal: R$</h4></td>
													<td style="text-align: center; white-space: nowrap;"><h4><?php echo $total_phone_numbers; ?> linhas</h4></td>
													<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4><?php echo real_currency($total_value); ?></h4></td>
												</tr>
											</tfoot>
											<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
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
		
			/** Function to delete an equipment item
			 * @param id_ => contract identification
			*/
			function deleteContract( id_ )
			{
				if ( confirm("Realmente deseja excluir o contrato?") == true )
				{
					// Callback to delete the element
					sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/gerenciar_contratooperadora', 'action=delete&contract_ID=' + id_, 'POST', 
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