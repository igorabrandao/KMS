							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Visualizar Plataforma LD">Visualizar Plataforma LD <small>visualização </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php

						// Check if the contract ID is valid
						if ( isset($_GET['ID_platformLD']) && $_GET['ID_platformLD'] != '' )
						{
							$platformLD_id = decrypted_url($_GET['ID_platformLD'] , "**");

							// Load general information
							$platformLD_info = $modelo2->get_plataforma_LD_byID($platformLD_id);

							// Load contract tax information
							$platformLD_tax_info = $modelo->load_platformLD_tax_info($platformLD_id);

							// Auxiliary status
							$tipo_tarifa = "";
						}

					?>

					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-md-12">
							<!-- start: FORM VALIDATION 1 PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Formulário de registro
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="fa fa-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="fa fa-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="fa fa-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
									<h2><i class="fa fa-pencil-square teal"></i> VISUALIZAR PLATAFORMA LD</h2>
									<p>
										Informações referentes a plataforma LD.
									</p>
									<hr>
										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
															<label for="form-field-mask-2">
																Informações gerais
															</label>
															<table class="table table-striped table-bordered table-hover">
																<thead>
																	<tr>
																		<th style="width: 12%; text-align: center;" title="OPERADORA">OPERADORA</th>
																		<th style="width: 12%; text-align: center;" title="PLANO">PLANO</th>
																		<th style="width: 10%; text-align: center;" title="TIPO DE TARIFA">TIPO DE TARIFA</th>
																		<th style="width: 22%; text-align: center;" title="TIPO DE SUBTARIFA">TIPO DE SUBTARIFA</th>
																	</tr>
																</thead>
																<tbody>
																	<?php

																		// Init row
																		echo "<tr>";

																		// Carrier name
																		if ( isset($platformLD_info[0]["NOME_OPERADORA"]) && $platformLD_info[0]["NOME_OPERADORA"] != "" )
																			echo "<td style='text-align: center;' title='" . mb_strtoupper($platformLD_info[0]["NOME_OPERADORA"], 'UTF-8') . "' >" . mb_strtoupper($platformLD_info[0]["NOME_OPERADORA"], 'UTF-8') . "</td>";
																		else
																			echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																		// Plan name
																		if ( isset($platformLD_info[0]["DESCRITIVO_PLANO"]) && $platformLD_info[0]["DESCRITIVO_PLANO"] != "" )
																			echo "<td style='text-align: center;' title='" . $platformLD_info[0]["DESCRITIVO_PLANO"] . "' >" . $platformLD_info[0]["DESCRITIVO_PLANO"] . "</td>";
																		else
																			echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																		// Tax description
																		if ( isset($platformLD_info[0]["DESC_TIPO_TARIFA"]) && $platformLD_info[0]["DESC_TIPO_TARIFA"] != "" )
																		{
																			echo "<td style='text-align: center;' title='" . $platformLD_info[0]["DESC_TIPO_TARIFA"] . "' >" . $platformLD_info[0]["DESC_TIPO_TARIFA"] . "</td>";
																			$tipo_tarifa = $platformLD_info[0]["DESC_TIPO_TARIFA"];
																		}
																		else
																			echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																		// Subtax description
																		if ( isset($platformLD_info[0]["DESC_SUBTIPO_TARIFA"]) && $platformLD_info[0]["DESC_SUBTIPO_TARIFA"] != "" )
																			echo "<td style='text-align: center;' title='" . $platformLD_info[0]["DESC_SUBTIPO_TARIFA"] . "' >" . $platformLD_info[0]["DESC_SUBTIPO_TARIFA"] . "</td>";
																		else
																			echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

																		// End content
																		echo "</tr>";

																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>

										<hr>

										<p>
											Tarifas referentes a plataforma LD.
										</p>
										<div class="row">
											<div class="col-md-12">
												<div class="table-responsive">
													<table class="table table-striped table-bordered table-hover" id="table_state_taxes" style="display: none;">
														<thead>
															<tr>
																<th style="text-align: center;">UF</th>
																<th style="text-align: center;">Móvel</th>
																<th style="text-align: center;">Fixo</th>
																<th style="text-align: center;">Intra-rede</th>
																<th style="text-align: center;">DSL1</th>
																<th style="text-align: center;">DSL2</th>
																<th style="text-align: center;">AD</th>
															</tr>
														</thead>
														<tbody>
															<?php

																// Auxiliary variables
																$columns_number = 6;
																$tax_list = "";

																// Get the state list to print the taxes fields
																$state_list = $modelo->get_state_list();

																// Print the state list
																foreach ( $state_list as $s_list )
																{
																	// Get the tax list
																	if ( isset($platformLD_tax_info[0]["TARIFA_" . $s_list["UF"]]) )
																	{
																		$tax_list = $platformLD_tax_info[0]["TARIFA_" . $s_list["UF"]];
																		$tax_list_array = explode("***", $tax_list);
																	}

																	echo "<tr>";

																	// Print the line header
																	echo '<td style="text-align: center;" title="' . $s_list["UF"] . '" nowrap>' . $s_list["UF"] . '</td>';

																	// Print each column
																	for ( $i = 0; $i < $columns_number; $i++ )
																	{
																		if ( isset($tax_list_array[$i]) && $tax_list_array[$i] != "" )
																			echo "<td style='text-align: center;' title='" . $tax_list_array[$i] . "' >" . str_replace("R$", "",$tax_list_array[$i]) . "</td>";
																		else
																			echo "<td style='text-align: center; white-space: nowrap;'> - </td>";
																	}

																	echo "</tr>";
																}

															?>
														</tbody>
														<tfoot>
															<tr>
																<th style="text-align: center;">UF</th>
																<th style="text-align: center;">Móvel</th>
																<th style="text-align: center;">Fixo</th>
																<th style="text-align: center;">Intra-rede</th>
																<th style="text-align: center;">DSL1</th>
																<th style="text-align: center;">DSL2</th>
																<th style="text-align: center;">AD</th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- end: FORM VALIDATION 1 PANEL -->
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->
		
		<script type="text/javascript">
		
			/** Function hide/show the table columns accordling to the tax type
			 *
			 * @param tax_type_ => tax type VC1/VC2/VC3
			*/
			function setTableColumns( tax_type_ )
			{
				// Get the table itself
				var tbl = document.getElementById('table_state_taxes');
				var rows = tbl.getElementsByTagName('tr');
				var cels;

				// Check if the parameter is valid
				if ( tax_type_.localeCompare("Selecione...") != 0 )
				{
					tbl.style.display = "";

					// Check the tax type
					if ( tax_type_.localeCompare("VC1") == 0 ) // VC1 tax
					{
						// Define array to show and hide
						var array_show = [];
						var array_hide = [4, 5, 6];
						fields_number = 3;
					}
					else // VC2 and VC3
					{
						// Define array to show and hide
						var array_show = [4, 5, 6];
						var array_hide = [];
						fields_number = 6;
					}

					// Run through all the columns to hide
					for ( var i = 0; i < array_hide.length; i++ )
					{
						for ( var row = 0; row < rows.length; row++ )
						{
							cels = rows[row].getElementsByTagName('td')

							if ( cels[array_hide[i]] )
							{
								cels[array_hide[i]].style.display = "none";
							}
							else
							{
								cels = rows[row].getElementsByTagName('th')

								if ( cels[array_hide[i]] )
								{
									cels[array_hide[i]].style.display = "none";
								}
							}
						}
					}

					// Run through all the columns to show
					for ( var i = 0; i < array_show.length; i++ )
					{
						for ( var row = 0; row < rows.length; row++ )
						{
							cels = rows[row].getElementsByTagName('td')

							if ( cels[array_show[i]] )
							{
								cels[array_show[i]].style.display = "";
							}
							else
							{
								cels = rows[row].getElementsByTagName('th')

								if ( cels[array_show[i]] )
								{
									cels[array_show[i]].style.display = "";
								}
							}
						}
					}
				}
				else
				{
					tbl.style.display = "none";
				}
			}

		</script>

		<?php
			// Check if the tax type was filled to show the related table
			if ( strcmp($tipo_tarifa, "VC1") == 0 ) {
				?><script>setTableColumns("VC1");</script><?php
			} else {
				?><script>setTableColumns("VC2");</script><?php
			}
		?>