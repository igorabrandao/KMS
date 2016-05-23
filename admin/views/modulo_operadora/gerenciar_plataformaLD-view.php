							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Plataforma LD">Plataforma LD <small>gestão </small></h1>
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
											<button class="btn btn-blue add-row" onClick="javascript:window.location.href='<?php echo HOME_URI;?>/modulo_operadora/cadastrar_plataformaLD';">
												Adicionar plataforma LD <i class="fa fa-plus"></i>
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
													<th style="white-space: nowrap; text-align: center; width: 10%;" title="OPERADORA">OPERADORA</th>
													<th style="white-space: nowrap; text-align: center; width: 10%;" title=""></th>
													<th style="white-space: nowrap; text-align: center; width: 30%;" title="PLANO">PLANO</th>
													<th style="white-space: nowrap; text-align: center; width: 20%;" title="TIPO DE TARIFA">TIPO DE TARIFA</th>
													<th style="white-space: nowrap; text-align: center; width: 20%;" title="TIPO DE SUBTARIFA">TIPO DE SUBTARIFA</th>
												</tr>
											</thead>
											<tbody>
												<?php

													// Auxiliary variable
													$count = 0;
													$colspan = 8;

													// Get the entire report
													$data_value = $modelo->get_plataforma_LD();

													// Run through service list
													foreach ( $data_value as $value )
													{
														// Init row
														echo "<tr>";

														// Carrier name
														if ( isset($value["NOME_OPERADORA"]) && $value["NOME_OPERADORA"] != "" )
															echo "<td style='text-align: center;' title='" . mb_strtoupper($value["NOME_OPERADORA"], 'UTF-8') . "' >" . mb_strtoupper($value["NOME_OPERADORA"], 'UTF-8') . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Action buttons
														echo "<td class='center'>";
														echo "<div class='visible-md visible-lg hidden-sm hidden-xs'>";
														echo "<a href='" . encrypted_url($value["ID_PLATAFORMA_LD"], HOME_URI . "/modulo_operadora/visualizar_plataformaLD?ID_platformLD=") . "' class='btn btn-xs btn-warning tooltips' data-placement='top' data-original-title='Visualizar'><i class='clip-search'></i></a>&nbsp;";
														echo "<a href='" . encrypted_url($value["ID_PLATAFORMA_LD"], HOME_URI . "/modulo_operadora/editar_plataformaLD?ID_platformLD=") . "' class='btn btn-xs btn-teal tooltips' data-placement='top' data-original-title='Editar'><i class='fa fa-edit'></i></a>&nbsp;";
														echo "<a onClick='deletePlataformaLD(" . $value["ID_PLATAFORMA_LD"] . ");' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remover'><i class='fa fa-times fa fa-white'></i></a>";
														echo "</div></td>";

														// Plan name
														if ( isset($value["DESCRITIVO_PLANO"]) && $value["DESCRITIVO_PLANO"] != "" )
															echo "<td style='text-align: center;' title='" . $value["DESCRITIVO_PLANO"] . "' >" . $value["DESCRITIVO_PLANO"] . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Tax description
														if ( isset($value["DESC_TIPO_TARIFA"]) && $value["DESC_TIPO_TARIFA"] != "" )
															echo "<td style='text-align: center;' title='" . $value["DESC_TIPO_TARIFA"] . "' >" . $value["DESC_TIPO_TARIFA"] . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// Subtax description
														if ( isset($value["DESC_SUBTIPO_TARIFA"]) && $value["DESC_SUBTIPO_TARIFA"] != "" )
															echo "<td style='text-align: center;' title='" . $value["DESC_SUBTIPO_TARIFA"] . "' >" . $value["DESC_SUBTIPO_TARIFA"] . "</td>";
														else
															echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

														// End content
														echo "</tr>";
														$subtotal_value = 0;
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

			/** Function to delete a LD platform
			 * @param id_ => contract identification
			*/
			function deletePlataformaLD( id_ )
			{
				if ( confirm("Realmente deseja excluir a plataforma LD?") == true )
				{
					// Callback to delete the element
					sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/gerenciar_plataformaLD', 'action=delete&ID_platformLD=' + id_, 'POST', 
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