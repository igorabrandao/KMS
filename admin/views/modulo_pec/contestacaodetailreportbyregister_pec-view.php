							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Detalhamento por registro">Detalhamento por registro <small>relatório </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Check if PEC ID is valid
						$modelo->checkValidit_PEC();

						// Check if service ID is valid
						if (isset($_GET['idUtilizacao']) && $_GET['idUtilizacao'] != '')
						{
							$utilization_id = decrypted_url($_GET['idUtilizacao'] , "**");
						}
						else
						{
							?><script>alert("Houve um problema com o identificador da utilização. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/detailreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Check calling type ID is valid
						if (isset($_GET['idTipoLigacao']) && $_GET['idTipoLigacao'] != '')
						{
							$calling_id = decrypted_url($_GET['idTipoLigacao'] , "**");
							$calling_name = $modelo->get_calling_pec($calling_id);
							$calling_name = mb_strtoupper($calling_name, 'UTF-8');
						}
						else
						{
							?><script>alert("Houve um problema com o identificador do tipo de ligação. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/detailreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Check chamada type ID is valid
						if (isset($_GET['idTipoChamada']) && $_GET['idTipoChamada'] != '')
						{
							$chamada_id = decrypted_url($_GET['idTipoChamada'] , "**");
							$chamada_name = $modelo->get_chamada_pec($chamada_id);
						}
						else
						{
							?><script>alert("Houve um problema com o identificador do tipo de chamada. Por favor, tente novamente.");
							window.location.href = "<?php echo HOME_URI;?>/modulo_pec/detailreport_pec?idPEC=<?php echo $_GET['idPEC']; ?>";</script> <?php
							return false;
						}

						// Get carrier ID
						$carrier = $modelo->get_carrier_pec($modelo->getIdPEC());

						// Get the detail type
						$detail_type = $modelo->get_detail_type_pec($modelo->getIdPEC(), $calling_id, $chamada_id, $utilization_id);
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
											<div class="btn-group pull-left">
												<?php
													// Remove NOT DEFINED values
													if ( $chamada_name != "NÃO DEFINIDA" )
														echo "<h4 title='" . $calling_name . " ( " . $chamada_name . " )'>" . $calling_name . " ( " . $chamada_name . " )</h4>";
													else
														echo "<h4 title='" . $calling_name . "'>" . $calling_name . "</h4>";
												?>
											</div>
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

									<?php
										// Auxiliary variable
										$total_value = 0;
										$total_value2 = 0;
										$total_value3 = 0;
										$total_value4 = 0;
										$total_interconnection = 0;
										$total_tax = 0;
										$total_qtd = 0;
										$total_qtdI = 0;
										$total_qtdU = 0;
										$total_qtdE = 0;
										$total_time = 0;
										$total_time2 = 0;
										$total_time3 = 0;
										$total_traffic = 0;
										$total_trafficI = 0;
										$total_trafficU = 0;
										$total_trafficE = 0;
										$subtotal_traffic = 0;
										$show_minutes = 0;
										$count = 0;
										$charged_value_type = "";
										$is_contestacao = "";
										$platform_LD_qtd = 0;
										$tax_position = -1;
										$state_tax = "";
										$tax = "";
										$status_color = "";
										$status_color_text = "";
										$print = 1;
										$phone_list = array();
										$tax_type = array();
										$hidden_field_list = "";
										$plan_desc = "";
										$final_value = 0;
										$diff = 0;

										// Get the entire report
										$data_value = $modelo->detailedreportbyregister_PEC($modelo->getIdPEC(), $calling_id, $chamada_id, $utilization_id);
									?>

									<div class="row">
										<div class="col-md-12 space20">
											<button id="contestFilter" title="Validar/contestar todos os acessos filtrados" class="btn btn-blue add-row" type="button">
												<i class="fa fa-filter"></i> Validar/contestar com filtro
											</button>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="sample_1">
											<?php if ( $detail_type != 1 ) { // DETALHAMENTO ?>
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;" title="AÇÕES">AÇÕES</th>
														<th style="white-space: nowrap; text-align: center;" title="ACESSO">ACESSO</th>
														<th style="text-align: center;" title="JUSTIFICATIVA">JUSTIFICATIVA</th>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<th style="white-space: nowrap; text-align: center;" title="RÁDIO">RÁDIO</th>
														<?php } ?>
														<?php if ( $carrier == 1 ) { // CLARO ?>
															<th style="white-space: nowrap; text-align: center;" title="SERVIÇO">SERVIÇO</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center;" title="CSP">CSP</th>
														<th style="white-space: nowrap; text-align: center;" title="TIPO DE TARIFA">TIPO TARIFA</th>
														<th style="white-space: nowrap; text-align: center;" title="PLANO">PLANO</th>
														<th style="white-space: nowrap; text-align: center;" title="DATA">DATA</th>
														<th style="white-space: nowrap; text-align: center;" title="HORA">HORA</th>
														<th style="white-space: nowrap; text-align: center;" title="LOCALIDADE">LOCALIDADE</th>
														<th style="white-space: nowrap; text-align: center;" title="NÚMERO">NÚMERO</th>
														<th style="white-space: nowrap; text-align: center;" title="TARIFA">TARIFA</th>
														<th style="white-space: nowrap; text-align: center;" title="DURAÇÃO">DURAÇÃO</th>
														<!--<th style="white-space: nowrap; text-align: center;">TIPO</th>-->
														<th style="white-space: nowrap; text-align: center;" title="QUANTIDADE">QUANTIDADE</th>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<th style="white-space: nowrap; text-align: center;" title="INTERCONEXÃO">INTERCONEXÃO</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center;" title="VALOR (R$)">VALOR (R$)</th>
														<?php if ( $carrier == 1 ) { // CLARO ?>
															<th style="white-space: nowrap; text-align: center;" title="VALOR COBRADO (R$)">VALOR COBRADO (R$)</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center;" title="VL. CALC. (R$)">VL. CALC. (R$)</th>
														<th style="white-space: nowrap; text-align: center;" title="DIFERENÇA (R$)">DIFERENÇA (R$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
														// Run through service list
														$total_elements = count($data_value);
														foreach ( $data_value as $value )
														{
															// Define the initial value to the contestation variable
															$is_contestacao = 0;
															$print = 1;
															$platform_LD_qtd = 0;
															$tax_position = -1;
															$status_color = "";
															$status_color_text = "";
															$subtotal = 0;

															// Get the phone number contestation history
															$phone_contestation = $modelo2->get_phone_contestation_detailment($modelo->getIdPEC(), $modelo2->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false), $value["ID_PEC_DET"]);

															// If the item was already validated, than it's don't need to appear 
															if ( isset($phone_contestation[0]["IS_CONTESTACAO"]) && $phone_contestation[0]["IS_CONTESTACAO"] == 0 )
															{
																$print = 0;
															}

															/** GET LD PLATFORM
															 *
															 * VC1 => origin DDD number = destiny DDD number
															 * VC2 => origin DDD number != destiny DDD number, but the same state (Ex: 11 and 19)
															 * VC3 => origin DDD number != destiny DDD number and different states (Ex: 11 and 67)
															*/
															$ddd01 = substr(trim($value["LINHA"]), 0, 2);
															$ddd02 = substr(trim($value["N_CHAMADO"]), 0, 2);

															// Check the charged value type
															if ( strcmp($ddd01, $ddd02) == 0 )
																$charged_value_type = "VC1";
															else if ( strcmp(substr($ddd01, 0, 1), substr($ddd02, 0, 1)) == 0 )
																$charged_value_type = "VC2";
															else
																$charged_value_type = "VC3";

															//echo $ddd01 . " = " . $ddd02 . " --> " . $charged_value_type . " --------> " . $chamada_name . "</br>";

															/** RULE: use the LD platform tax accordling to the destiny number.
															 *
															*/
															$tax_ddd = $modelo2->get_UF_by_DDD($ddd02);

															// Get the plan list
															$plan_list = $modelo->get_phone_plan_list($value["LINHA"]);

															echo "</br>";
															var_dump($value);
															echo "</br>";

															// Run through the plan list to get the LD platform
															foreach ( $plan_list as $p_list )
															{
																//echo $p_list["N_CONTA"] . " - " . $p_list["LINHA"] . " - " . $p_list["ID_PLANO_CONTRATO"] . " - " . $p_list["DESCRITIVO_PLANO"] . "</br>";

																/** RULE: VC1 tax just have inside the package and excess
																 *
																*/
																if ( strcmp($charged_value_type, "VC1") == 0 )
																{
																	// Check if it's excess or inside the package
																	if ( strpos($value["TARIFA"], "excedente") !== false )
																	{
																		// Get the LD platform
																		$platformLD_list = $modelo2->get_platform_LD( $carrier, $p_list["DESCRITIVO_PLANO"], $charged_value_type, "Tarifa excedente" );
																	}
																	else
																	{
																		// Get the LD platform
																		$platformLD_list = $modelo2->get_platform_LD( $carrier, $p_list["DESCRITIVO_PLANO"], $charged_value_type, "Dentro do pacote" );
																	}
																}
																else
																{
																	// Get the LD platform
																	$platformLD_list = $modelo2->get_platform_LD( $carrier, $p_list["DESCRITIVO_PLANO"], $charged_value_type, $value["TARIFA"] );
																}

																// Run through all LD platforms
																foreach ( $platformLD_list as $LD_list )
																{
																	// Get the state's taxes
																	$state_tax = $LD_list["TARIFA_" . $tax_ddd[0]["UF"]];
																	$plan_desc = $LD_list["DESCRITIVO_PLANO"];
																	//echo "XXX: " . $LD_list["ID_PLATAFORMA_LD"] . " - " . $LD_list["ID_OPERADORA"] . " - " . $LD_list["DESCRITIVO_PLANO"] . " - " . $LD_list["DESC_TIPO_TARIFA"] . " - " . $LD_list["DESC_SUBTIPO_TARIFA"] . "</br></br>";
																	$platform_LD_qtd += 1;
																}
															}

															/** RULE: each register should have just one LD platform.
															 *  If the register has more than one or zero, it's contestation.
															*/
															if ( $platform_LD_qtd > 1 || $platform_LD_qtd == 0 )
															{
																$is_contestacao = 1;
																
																// Define the status color yellow
																$status_color = "#ffeb9c";
																$status_color_text = "#cf7e00";
															}

															// Calculates the tax accordling to the specific rules
															switch ( $value["ID_TIPO_DET"] )
															{
																// ---------------------------------------------------------------------------
																case 1: // NOT DEFINED
																// ---------------------------------------------------------------------------

																	break;

																// ---------------------------------------------------------------------------
																case 2: // VOICE
																// ---------------------------------------------------------------------------

																	/** CLASSIFICATION: it's necessary identify the item type to get the correct tax
																	 *  Types: Móvel / Fixo / Intra-rede / DSL1 / DSL2 / AD
																	*/
																	if ( strpos($calling_name, "ACESSO A CAIXA POSTAL") !== false )
																	{
																		$tax_position = 2; // Intra-rede
																	}
																	else if ( strpos($chamada_name, "Adicional") !== false || strpos($chamada_name, "Adicionais") !== false )
																	{
																		$tax_position = 5; // AD
																	}
																	else if ( strpos($chamada_name, "Ligações Recebidas em Roaming") !== false )
																	{
																		// Check the VC type
																		if ( strcmp($charged_value_type, "VC2") == 0 )
																			$tax_position = 3; // DSL1
																		else if ( strcmp($charged_value_type, "VC3") == 0 )
																			$tax_position = 4; // DSL2
																	}
																	else if ( strpos($chamada_name, "Celulares Vivo") !== false || strpos($chamada_name, "Celulares Vivo") !== false ) 
																	{
																		$tax_position = 2; // Intra-rede
																	}
																	else if ( strpos($chamada_name, "fixo") !== false || strpos($chamada_name, "Fixo") !== false ) 
																	{
																		$tax_position = 1; // Fixo
																	}
																	else if ( strpos($chamada_name, "celular") !== false || strpos($chamada_name, "Celular") !== false )
																	{
																		$tax_position = 0; // Móvel
																	}

																	// Get the tax accordling ot the position
																	$aux_tax = explode("***", $state_tax);

																	if ( isset($aux_tax[$tax_position]) )
																		$tax = str_replace("R$", "", $aux_tax[$tax_position]);
																	else
																		$tax = 0;

																	//echo $tax_ddd[0]["UF"] . " @@@ " . $tax . " --> " . $state_tax . "</br>" . $tax_position . "</br>";

																	//echo "</br></br>";

																	//echo $tax . " - " . $value["VALOR"] . " - " . compare_float($tax, $value["VALOR"]) . "</br>";

																	// Calculates the total amount accordling LD platform
																	$subtotal = $modelo2->calculate_charged_amount(format_min_sec($value["DURACAO"]), $tax);

																	// Total sum
																	//$total_value3 = real_sum($total_value3, str_replace(",", ".", $subtotal));

																	// Check if the calculated value is equivalent to the invoice
																	if ( compare_float($subtotal, $value["VALOR"]) == false )
																	{
																		$is_contestacao = 1;

																		// Define the status color red
																		$status_color = "#ffc7ce";
																		$status_color_text = "#cf2d06";
																	}
																	
																	break;

																// ---------------------------------------------------------------------------
																case 3: // DATA
																// ---------------------------------------------------------------------------

																	/** CLASSIFICATION: get the MB excedent tax
																	*/
																	$tax_position = 5; // AD (should be DATA)

																	// Get the tax accordling ot the position
																	$aux_tax = explode("***", $state_tax);

																	if ( isset($aux_tax[$tax_position]) )
																		$tax = str_replace("R$", "", $aux_tax[$tax_position]);
																	else
																		$tax = 0;

																	// Calculates the total amount accordling LD platform
																	$subtotal = $modelo2->calculate_charged_amount(format_min_sec($value["DURACAO"]), $tax);

																	// Check if the calculated value is equivalent to the invoice
																	if ( compare_float($subtotal, $value["VALOR"]) == false )
																	{
																		$is_contestacao = 1;

																		// Define the status color red
																		$status_color = "#ffc7ce";
																		$status_color_text = "#cf2d06";
																	}
																	
																	break;

																// ---------------------------------------------------------------------------
																case 4: // SMS
																// ---------------------------------------------------------------------------

																	break;
															}

															// Check if the register should be printed
															if ( $print == 1 && $is_contestacao == 1 )
															{
																// Init row
																echo "<tr style='background-color: " . $status_color . "; color: " . $status_color_text . ";text-align: center;'>";

																// Action buttons
																echo "<td style='white-space: nowrap;' class='center'>";

																if ( isset($value["ID_PEC_DET"]) && $value["ID_PEC_DET"] != 0 && $value["LINHA"] != "" )
																{
																	echo "<div class='visible-md visible-lg hidden-sm hidden-xs'>";

																	if ( isset($phone_contestation[0]["ID_PEC_DET"]) && $phone_contestation[0]["ID_PEC_DET"] != 0 )
																	{
																		echo "<a onClick='contestRegister(" . $modelo->getIdPEC() . ", " . $modelo2->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_PEC_DET"] . ", ". $phone_contestation[0]["ID_DETALHAMENTO_CONTESTACAO"] . ", 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																		echo "<a onClick='contestRegister(" . $modelo->getIdPEC() . ", " . $modelo2->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_PEC_DET"] . ", ". $phone_contestation[0]["ID_DETALHAMENTO_CONTESTACAO"] . ", 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																	}
																	else
																	{
																		echo "<a onClick='contestRegister(" . $modelo->getIdPEC() . ", " . $modelo2->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_PEC_DET"] . ", 0, 0);' class='btn btn-xs btn-green tooltips' data-placement='top' data-original-title='Validar linha'><i class='fa fa-check'></i></a>&nbsp;";
																		echo "<a onClick='contestRegister(" . $modelo->getIdPEC() . ", " . $modelo2->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . ", " . $value["ID_PEC_DET"] . ", 0, 1);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Contestar linha'><i class='fa fa-times fa fa-white'></i></a>";
																	}

																	echo "</div>";
																}

																echo "</td>";

																// Phone number
																if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																{
																	echo "<td style='text-align: center; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
																	$phone_list[$count] = trim($value["LINHA"]);
																}
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Justify
																if ( isset($phone_contestation[0]["JUSTIFICATIVA"]) && $phone_contestation[0]["JUSTIFICATIVA"] != "" )
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . $phone_contestation[0]["JUSTIFICATIVA"] . "'>" . $phone_contestation[0]["JUSTIFICATIVA"] . "</td>";
																else
																{
																	if ( $value["LINHA"] == "" )
																		echo "<td style='text-align: center;' title='NÃO POSSUI UM ACESSO'>NÃO POSSUI UM ACESSO</td>";
																	else
																		echo "<td style='text-align: center;'>-</td>";
																}

																// Radio ID
																if ( $carrier == 10 ) // Just to Nextel carrier
																{
																	if ( isset($value["ID_RADIO"]) && $value["ID_RADIO"] != "" && strpos($value["ID_RADIO"], "-") === false )
																		echo "<td style='text-align: center;' title='" . $value["ID_RADIO"] . "'>" . $value["ID_RADIO"] . "</td>";
																	else
																		echo "<td style='text-align: center;'>-</td>";
																}

																// Service
																if ( $carrier == 1 ) // Just to Claro carrier
																{
																	if ( isset($value["SERVICO"]) && $value["SERVICO"] != "" )
																		echo "<td style='text-align: left;' title='" . $value["SERVICO"] . "' >" . $value["SERVICO"] . "</td>";
																	else
																	{
																		echo "<td style='text-align: center;'> - </td>";
																	}
																}

																// CSP
																if ( isset($value["CSP"]) && $value["CSP"] != "" && $value["CSP"] != 0 )
																	echo "<td style='text-align: center;' title='" . $value["CSP"] . "' >" . $value["CSP"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Tax type
																if ( isset($charged_value_type) && $charged_value_type != "" )
																	echo "<td style='text-align: center;' title='" . $charged_value_type . "' >" . $charged_value_type . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Plan
																if ( isset($plan_desc) && $plan_desc != "" )
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . $plan_desc . "' >" . $plan_desc . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Date
																if ( isset($value["DATA"]) && $value["DATA"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["DATA"] . "' >" . $value["DATA"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Time
																if ( isset($value["HORA"]) && $value["HORA"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["HORA"] . "' >" . $value["HORA"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Location
																if ( isset($value["ORIGEM"]) && $value["ORIGEM"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["ORIGEM"] . "' >" . $value["ORIGEM"] . "</td>";
																else
																{
																	if ( isset($value["PAIS_OPERADORA"]) && $value["PAIS_OPERADORA"] != "" )
																		echo "<td style='text-align: center;' title='" . $value["PAIS_OPERADORA"] . "' >" . $value["PAIS_OPERADORA"] . "</td>";
																	else if ( isset($value["ORIGEM_DESTINO"]) && $value["ORIGEM_DESTINO"] != "" )
																		echo "<td style='text-align: center;' title='" . $value["ORIGEM_DESTINO"] . "' >" . $value["ORIGEM_DESTINO"] . "</td>";
																	else
																		echo "<td style='text-align: center;'> - </td>";
																}

																// Phone Number
																if ( isset($value["N_CHAMADO"]) && $value["N_CHAMADO"] != "" )
																	echo "<td style='white-space: nowrap; text-align: center;' title='" . $value["N_CHAMADO"] . "' >" . $value["N_CHAMADO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";

																// Taxes
																if ( isset($value["TARIFA"]) && $value["TARIFA"] != "" )
																{
																	echo "<td style='text-align: center;' title='" . str_replace(",", ".", $value["TARIFA"]) . "'>" . str_replace(",", ".", $value["TARIFA"]) . "</td>";

																	// Total sum
																	$total_tax = real_sum($total_tax, str_replace(",", ".", $value["TARIFA"]));

																	$tax_type[$count] = trim($value["TARIFA"]);
																}
																else
																{
																	echo "<td style='text-align: center;'>-</td>";
																}

																// Duration
																if ( isset($value["DURACAO"]) && $value["DURACAO"] != "" )
																{
																	// Check the time format (hh:mm:ss)
																	if ( strlen($value["DURACAO"]) == 8 )
																	{
																		echo "<td style='text-align: center;' title='" . format_mm_ss(format_hh_mm_ss($value["DURACAO"])) . "'>" . format_mm_ss(format_hh_mm_ss($value["DURACAO"])) . "</td>";
																		$value["DURACAO"] = format_mm_ss(format_hh_mm_ss($value["DURACAO"]));
																	}
																	else
																	{
																		echo "<td style='text-align: center;' title='" . $value["DURACAO"] . "'>" . $value["DURACAO"] . "</td>";
																	}

																	if ( strpos($value["DURACAO"], "m") === false )
																	{
																		// Total duration
																		if ( $count != 0 )
																			$total_time = min_sec_sum($total_time, $value["DURACAO"]);
																		else
																			$total_time = $value["DURACAO"];
																	}
																	else
																	{
																		// Total duration
																		if ( $count != 0 )
																			$total_time = min_sec_sum($total_time, format_min_sec($value["DURACAO"]));
																		else
																			$total_time = format_min_sec($value["DURACAO"]);
																		$total_time = str_replace(".", "", $total_time);
																		$show_minutes = 1;
																	}
																}
																else
																{
																	echo "<td style='text-align: center;'>-</td>";
																}

																// Type
																/*if ( isset($value["TIPO"]) && $value["TIPO"] != "" )
																	echo "<td style='text-align: center;' title='" . $value["TIPO"] . "' >" . $value["TIPO"] . "</td>";
																else
																	echo "<td style='text-align: center;'> - </td>";*/

																// Check the service type
																switch ( $value["ID_TIPO_DET"] )
																{
																	// ---------------------------------------------------------------------------
																	case 1: // NOT DEFINED
																	// ---------------------------------------------------------------------------

																		// Quantity
																		if ( isset($value["QUANTIDADE"]) && $value["QUANTIDADE"] != "" && $value["QUANTIDADE"] != 0 )
																		{
																			echo "<td style='text-align: center;' title='" . $value["QUANTIDADE"] . "'>" . $value["QUANTIDADE"] . "</td>";

																			// Total quantity
																			$total_qtd = real_sum($total_qtd, str_replace(",", ".", $value["QUANTIDADE"]));
																		}
																		else
																			echo "<td style='text-align: center;'>-</td>";

																		break;

																	// ---------------------------------------------------------------------------
																	case 2: // VOICE
																	// ---------------------------------------------------------------------------

																		// Quantity
																		if ( isset($value["QUANTIDADE"]) && $value["QUANTIDADE"] != "" && $value["QUANTIDADE"] != 0 )
																		{
																			//echo "<td style='text-align: center;' title='" . $value["QUANTIDADE"] . "'>" . $value["QUANTIDADE"] . "</td>";

																			// Total quantity
																			$total_qtd = real_sum($total_qtd, str_replace(",", ".", $value["QUANTIDADE"]));
																		}
																		else
																			echo "<td style='text-align: center;'>-</td>";

																		break;

																	// ---------------------------------------------------------------------------
																	case 3: // DATA
																	// ---------------------------------------------------------------------------

																		// Quantity
																		$traffic_list = $modelo->get_traffic_list2($modelo->getIdPEC(), iif($value["ID_PEC_DET"]));

																		// Run through service list
																		$aux_traffic = "";
																		foreach ( $traffic_list as $tf_list )
																		{
																			$aux_traffic = preg_replace("/MB+\s+/", ",", $tf_list["QUANTIDADE"]);
																			$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																			$aux_traffic = str_replace(",", ".", $aux_traffic);
																			$subtotal_traffic = real_sum($subtotal_traffic, ($aux_traffic));
																		}

																		echo "<td style='text-align: center;' title='" . formatMbKb($subtotal_traffic) . "'>" . formatMbKb($subtotal_traffic) . "</td>";
																		$total_traffic = real_sum($total_traffic, $subtotal_traffic);

																		break;

																	// ---------------------------------------------------------------------------
																	case 4: // SMS
																	// ---------------------------------------------------------------------------

																		// Quantity
																		if ( isset($value["QUANTIDADE"]) && $value["QUANTIDADE"] != "" )
																		{
																			echo "<td style='text-align: center;' title='" . $value["QUANTIDADE"] . "'>" . $value["QUANTIDADE"] . "</td>";

																			// Total quantity
																			if ( strpos($value["QUANTIDADE"], ",") !== false )
																			{
																				// Format string value
																				$value["QUANTIDADE"] = preg_replace('/\./', '', $value["QUANTIDADE"], 1);
																				$value["QUANTIDADE"] = str_replace(",", ".", $value["QUANTIDADE"]);

																				// Total quantity																		
																				$total_qtd = real_sum($total_qtd, $value["QUANTIDADE"]);

																				// Check if it's the last loop
																				if( $count === ($total_elements - 1) )
																					$total_qtd = formatMbKb($total_qtd);
																			}
																			else if ( strpos($value["QUANTIDADE"], "m") === false )
																			{
																				$total_qtd = real_sum($total_qtd, str_replace(",", ".", $value["QUANTIDADE"]));
																			}
																			else
																			{
																				// Total duration
																				if ( $count != 0 )
																					$total_time2 = min_sec_sum($total_time2, format_min_sec($value["QUANTIDADE"]));
																				else
																					$total_time2 = format_min_sec($value["QUANTIDADE"]);
																				$total_time2 = str_replace(".", "", $total_time2);
																			}
																		}
																		else
																			echo "<td style='text-align: center;'>-</td>";

																		break;
																}

																// Interconnection
																if ( $carrier == 10 ) // Just to Nextel carrier
																{
																	if ( isset($value["INTERCONEXAO"]) && $value["INTERCONEXAO"] != "" )
																		echo "<td style='text-align: center;' title='" . $value["INTERCONEXAO"] . "'>" . $value["INTERCONEXAO"] . "</td>";
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	// Total interconnection
																	$total_interconnection = real_sum($total_interconnection, str_replace(",", ".", $value["INTERCONEXAO"]));
																}

																// Total value
																if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
																{
																	$value["VALOR"] = str_replace(":", ",", $value["VALOR"]);
																	
																	if ( strpos($value["VALOR"], ".") === false )
																	{
																		echo "<td style='text-align: center;' title='" . real_currency(str_replace(",", ".", $value["VALOR"])) . "'>" . real_currency(str_replace(",", ".", $value["VALOR"])) . "</td>";
																		$final_value = real_currency(str_replace(",", ".", $value["VALOR"]));
																	}
																	else
																	{
																		echo "<td style='text-align: center;' title='" . $value["VALOR"] . "'>" . $value["VALOR"] . "</td>";
																		$final_value = $value["VALOR"];
																	}

																	//echo $final_value . " + " . $total_value . " = ";
																	
																	// Total sum
																	$total_value = real_sum($total_value, str_replace(",", ".", $value["VALOR"]));
																	
																	//echo $total_value . "</br></br>";
																}
																else
																{
																	echo "<td style='text-align: center;'>-</td>";
																}

																// Charged value
																if ( $carrier == 1 ) // Just to Claro carrier
																{
																	if ( isset($value["VALOR_COBRADO"]) && $value["VALOR_COBRADO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . real_currency(str_replace(",", ".", $value["VALOR_COBRADO"])) . "'>" . real_currency(str_replace(",", ".", $value["VALOR_COBRADO"])) . "</td>";

																		// Total sum
																		$total_value2 = real_sum($total_value2, str_replace(",", ".", $value["VALOR_COBRADO"]));
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>-</td>";
																	}
																}

																// Total value (calculated by the system)

																// VOICE
																if ( $value["ID_TIPO_DET"] == 2 )
																{
																	if ( isset($tax) && $value["DURACAO"] != "" )
																	{
																		if ( isset($subtotal) && $subtotal != "" )
																		{
																			echo "<td style='text-align: center;' title='" . $subtotal . "'>" . $subtotal . "</td>";

																			// Total sum
																			$total_value3 = real_sum($total_value3, str_replace(",", ".", $subtotal));
																		}
																		else
																			echo "<td style='text-align: center;' title='0,00'>0,00</td>";
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>0,00</td>";
																	}
																}
																else
																{
																	echo "<td style='text-align: center;'>0,00</td>";
																}

																// DIFF
																if ( $value["ID_TIPO_DET"] == 2 )
																{
																	if ( isset($final_value) && isset($subtotal) && $final_value != "" && $subtotal != "" )
																	{
																		$diff = real_currency(currency_operation($final_value, $subtotal, "-"));
																		echo "<td style='text-align: center;' title='" . $diff . "'>" . $diff . "</td>";

																		// Total sum
																		$total_value4 = real_sum($total_value4, str_replace(",", ".", $diff));
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>0,00</td>";
																	}
																}
																else
																{
																	echo "<td style='text-align: center;'>0,00</td>";
																}

																if ( isset($phone_contestation[0]["ID_PEC_DET"]) && $phone_contestation[0]["ID_PEC_DET"] != 0 )
																{
																	$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden'
																	data-tp-tax='" . $value["TARIFA"] . "' data-ddd-tax='" . substr(v_num($value["ORIGEM"]), 1) . "' data-vl-invoice='" . real_currency(str_replace(",", ".", $value["VALOR"])) . "' data-vl-calculated='" . $subtotal . "' data-diff='" . $diff . "' value='" . $modelo->getIdPEC() . "@@" . $modelo2->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . 
																	$value["ID_PEC_DET"] . "@@" . $phone_contestation[0]["ID_DETALHAMENTO_CONTESTACAO"] . "'/>";
																}
																else
																{
																	$hidden_field_list .= "<input id='elem_CONTEST" . $value["LINHA"] . "' name='elem_CONTEST' type='hidden'
																	data-tp-tax='" . $value["TARIFA"] . "' data-ddd-tax='" . substr(v_num($value["ORIGEM"]), 1) . "' data-vl-invoice='" . real_currency(str_replace(",", ".", $value["VALOR"])) . "' data-vl-calculated='" . $subtotal . "' data-diff='" . $diff . "' value='" . $modelo->getIdPEC(). "@@" . $modelo2->getPhoneID($modelo->getIdPEC(), $value["LINHA"], false) . "@@" . 
																	$value["ID_PEC_DET"] . "@@0'/>";
																}

																// End content
																echo "</tr>";
																$count += 1;
																$subtotal_traffic = 0;
																$subtotal = 0;
																$diff = 0;
															}

															// Format the time (if necessary)
															if ( $total_time == "00:00" || $total_time == "0:00" )
																$total_time = "0:00";

															if ( $total_time2 == "00:00" || $total_time2 == "0:00" )
																$total_time2 = "0:00";
															}
													?>
												</tbody>
												<tfoot>
													<tr>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<td colspan="10" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } else if ( $carrier == 1 ) { // CLARO ?>
															<td colspan="10" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } else { ?>
															<td colspan="10" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } ?>
														<td style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_tax); ?></h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4><?php formatMbKb($total_traffic); if ( $show_minutes == 0 ) echo str_replace(".", "", format_mm_ss($total_time)); else echo format_mm_ss($total_time); ?></h4></td>
														<td style="text-align: center; white-space: nowrap;">
														<?php
															// Check which information is necessary to print 
															if ( $total_qtd != 0 && $total_time2 != "0:00" && $total_traffic != 0 ) // Numeric total + time + traffic
																echo $total_qtd . " / " . $total_time2 . " / " . formatMbKb($total_traffic);
															else if ( $total_qtd != 0 && $total_time2 != "0:00" ) // Numeric total + time 
																echo $total_qtd . " / " . $total_time2;
															else if ( $total_qtd != 0 ) // Numeric total
																echo $total_qtd;
															else if ( $total_traffic != 0 ) // Traffic
																echo formatMbKb($total_traffic);
															else if ( $total_time2 != "0:00" ) // MM:SS time
																echo format_mm_ss($total_time2);
															else
																echo "-";
														?>
														</h4></td>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<td style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_interconnection); ?></h4></td>
														<?php } ?>
														<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value); ?></h4></td>
														<td id="foot_total2" style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value3); ?></h4></td>
														<td id="foot_total3" style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value4); ?></h4></td>
														<?php if ( $carrier == 1 ) { // CLARO ?>
															<td style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value2); ?></h4></td>
														<?php } ?>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
												<input type="hidden" id="total_value2" value="<?php echo real_currency($total_value3); ?>" />
												<input type="hidden" id="total_value3" value="<?php echo real_currency($total_value4); ?>" />
											<?php } else if ( $detail_type == 1 ) { // SUBTOTAL ?>
												<thead>
													<tr>
														<th style="white-space: nowrap; text-align: center;">ACESSO</th>
														<?php if ( $carrier == 10 ) { // NEXTEL ?>
															<th style="white-space: nowrap; text-align: center;">RÁDIO</th>
														<?php } ?>
														<th style="white-space: nowrap; text-align: center;">DESCRITIVO</th>
														<th style="white-space: nowrap; text-align: center;">INCLUSO</th>
														<th style="white-space: nowrap; text-align: center;">UTILIZADO</th>
														<th style="white-space: nowrap; text-align: center;">EXCEDENTE</th>
														<th style="white-space: nowrap; text-align: center;">VALOR (R$)</th>
														<?php if ( $carrier == 1 ) { // Claro ?>
															<th style="white-space: nowrap; text-align: center;">VALOR COBRADO (R$)</th>
														<?php } ?>
													</tr>
												</thead>
												<tbody>
													<?php
														// Run through service list
														$total_elements = count($data_value);
														foreach ( $data_value as $value )
														{
															// Init row
															echo "<tr>";

															// Acesso
															if ( isset($value["LINHA"]) && $value["LINHA"] != "" )
																echo "<td style='text-align: left; white-space: nowrap;' title='" . $value["LINHA"] . "' >" . $value["LINHA"] . "</td>";
															else
																echo "<td style='text-align: center; white-space: nowrap;'> - </td>";

															// Radio ID
															if ( $carrier == 10 ) // Just to Nextel carrier
															{
																if ( isset($value["ID_RADIO"]) && $value["ID_RADIO"] != "" && strpos($value["ID_RADIO"], "-") === false )
																	echo "<td style='text-align: center;' title='" . $value["ID_RADIO"] . "'>" . $value["ID_RADIO"] . "</td>";
																else
																	echo "<td style='text-align: center;'>-</td>";
															}

															// Description
															if ( isset($value["DESCRITIVO"]) && $value["DESCRITIVO"] != "" )
																echo "<td style='text-align: left;' title='" . $value["DESCRITIVO"] . "' >" . $value["DESCRITIVO"] . "</td>";
															else
																echo "<td style='text-align: center;'> - </td>";

															// Check the service type
															switch ( $value["ID_TIPO_DET"] )
															{
																// ---------------------------------------------------------------------------
																case 1: // NOT DEFINED
																// ---------------------------------------------------------------------------

																	// Quantity
																	if ( isset($value["QUANTIDADE"]) && $value["QUANTIDADE"] != "" && $value["QUANTIDADE"] != 0 )
																	{
																		echo "<td style='text-align: center;' title='" . $value["QUANTIDADE"] . "'>" . $value["QUANTIDADE"] . "</td>";

																		// Total quantity
																		$total_qtd = real_sum($total_qtd, str_replace(",", ".", $value["QUANTIDADE"]));
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	break;

																// ---------------------------------------------------------------------------
																case 2: // VOICE
																// ---------------------------------------------------------------------------

																	// Included
																	if ( isset($value["INCLUSO"]) && $value["INCLUSO"] != "" && $value["INCLUSO"] != "0:00" )
																	{
																		if ( $value["INCLUSO"] == "00:00" )
																		{
																			echo "<td style='text-align: center;'>-</td>";
																		}
																		else
																		{
																			$value["INCLUSO"] = format_mm_ss($value["INCLUSO"]);
																			echo "<td style='text-align: center;' title='" . $value["INCLUSO"] . "'>" . $value["INCLUSO"] . "</td>";
																		}

																		if ( strpos($value["INCLUSO"], "m") === false )
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time = min_sec_sum($total_time, $value["INCLUSO"]);
																			else
																				$total_time = $value["INCLUSO"];
																		}
																		else
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time = min_sec_sum($total_time, format_min_sec($value["INCLUSO"]));
																			else
																				$total_time = format_min_sec($value["INCLUSO"]);
																		}
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>-</td>";
																	}

																	// Used
																	if ( isset($value["UTILIZADO"]) && $value["UTILIZADO"] != "" && $value["UTILIZADO"] != "0:00" )
																	{
																		if ( $value["UTILIZADO"] == "00:00" )
																		{
																			echo "<td style='text-align: center;'>-</td>";
																		}
																		else
																		{
																			$value["UTILIZADO"] = format_mm_ss($value["UTILIZADO"]);
																			echo "<td style='text-align: center;' title='" . $value["UTILIZADO"] . "'>" . $value["UTILIZADO"] . "</td>";
																		}

																		if ( strpos($value["UTILIZADO"], "m") === false )
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time2 = min_sec_sum($total_time2, $value["UTILIZADO"]);
																			else
																				$total_time2 = $value["UTILIZADO"];
																		}
																		else
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time2 = min_sec_sum($total_time2, format_min_sec($value["UTILIZADO"]));
																			else
																				$total_time2 = format_min_sec($value["UTILIZADO"]);
																			$total_time2 = str_replace(".", "", $total_time2);
																		}
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>-</td>";
																	}

																	// Excess
																	if ( isset($value["EXCEDENTE"]) && $value["EXCEDENTE"] != "" && $value["EXCEDENTE"] != "0:00" )
																	{
																		if ( $value["EXCEDENTE"] == "00:00" )
																		{
																			echo "<td style='text-align: center;'>-</td>";
																		}
																		else
																		{
																			$value["EXCEDENTE"] = format_mm_ss($value["EXCEDENTE"]);
																			echo "<td style='text-align: center;' title='" . $value["EXCEDENTE"] . "'>" . $value["EXCEDENTE"] . "</td>";
																		}
																		
																		if ( strpos($value["EXCEDENTE"], "m") === false )
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time3 = min_sec_sum($total_time3, $value["EXCEDENTE"]);
																			else
																				$total_time3 = $value["EXCEDENTE"];
																		}
																		else
																		{
																			// Total duration
																			if ( $count != 0 )
																				$total_time3 = min_sec_sum($total_time3, format_min_sec($value["EXCEDENTE"]));
																			else
																				$total_time3 = format_min_sec($value["EXCEDENTE"]);
																			$total_time3 = str_replace(".", "", $total_time3);
																		}
																	}
																	else
																	{
																		echo "<td style='text-align: center;'>-</td>";
																	}

																	break;

																// ---------------------------------------------------------------------------
																case 3: // DATA
																// ---------------------------------------------------------------------------

																	// Included
																	if ( isset($value["INCLUSO"]) && $value["INCLUSO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["INCLUSO"] . "'>" . $value["INCLUSO"] . "</td>";

																		// Total traffic
																		$aux_traffic = "";
																		$subtotal_traffic = 0;
																		$aux_traffic = str_replace(".", "", $value["INCLUSO"]);
																		$aux_traffic = preg_replace("/MB+\s+/", ",", $value["INCLUSO"]);
																		$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																		$aux_traffic = str_replace(".", "", $aux_traffic);
																		$aux_traffic = str_replace(",", ".", $aux_traffic);
																		$subtotal_traffic = real_sum($subtotal_traffic, $aux_traffic);
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	$total_trafficI = real_sum($total_trafficI, $subtotal_traffic);

																	// Used
																	if ( isset($value["UTILIZADO"]) && $value["UTILIZADO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["UTILIZADO"] . "'>" . $value["UTILIZADO"] . "</td>";

																		// Total traffic
																		$aux_traffic = "";
																		$subtotal_traffic = 0;
																		$aux_traffic = str_replace(".", "", $value["UTILIZADO"]);
																		$aux_traffic = preg_replace("/MB+\s+/", ",", $value["UTILIZADO"]);
																		$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																		$aux_traffic = str_replace(".", "", $aux_traffic);
																		$aux_traffic = str_replace(",", ".", $aux_traffic);
																		$subtotal_traffic = real_sum($subtotal_traffic, $aux_traffic);
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	$total_trafficU = real_sum($total_trafficU, $subtotal_traffic);
																	
																	// Excess
																	if ( isset($value["EXCEDENTE"]) && $value["EXCEDENTE"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["EXCEDENTE"] . "'>" . $value["EXCEDENTE"] . "</td>";

																		// Total traffic
																		$aux_traffic = "";
																		$subtotal_traffic = 0;
																		$aux_traffic = str_replace(".", "", $value["EXCEDENTE"]);
																		$aux_traffic = preg_replace("/MB+\s+/", ",", $value["EXCEDENTE"]);
																		$aux_traffic = preg_replace("/KB/", "", $aux_traffic);
																		$aux_traffic = str_replace(".", "", $aux_traffic);
																		$aux_traffic = str_replace(",", ".", $aux_traffic);
																		$subtotal_traffic = real_sum($subtotal_traffic, $aux_traffic);
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	$total_trafficE = real_sum($total_trafficE, $subtotal_traffic);

																	break;

																// ---------------------------------------------------------------------------
																case 4: // SMS
																// ---------------------------------------------------------------------------

																	// Included
																	if ( isset($value["INCLUSO"]) && $value["INCLUSO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["INCLUSO"] . "'>" . $value["INCLUSO"] . "</td>";

																		// Total quantity
																		if ( strpos($value["INCLUSO"], ",") !== false )
																		{
																			// Format string value
																			$value["INCLUSO"] = preg_replace('/\./', '', $value["INCLUSO"], 1);
																			$value["INCLUSO"] = str_replace(",", ".", $value["INCLUSO"]);

																			// Total quantity																		
																			$total_qtdI = real_sum($total_qtdI, $value["INCLUSO"]);

																			// Check if it's the last loop
																			if( $count === ($total_elements - 1) )
																				$total_qtdI = formatMbKb($total_qtdI);
																		}
																		else if ( strpos($value["INCLUSO"], "m") === false )
																		{
																			$total_qtdI = real_sum($total_qtdI, str_replace(",", ".", $value["INCLUSO"]));
																		}
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";
																	
																	// Used
																	if ( isset($value["UTILIZADO"]) && $value["UTILIZADO"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["UTILIZADO"] . "'>" . $value["UTILIZADO"] . "</td>";

																		// Total quantity
																		if ( strpos($value["UTILIZADO"], ",") !== false )
																		{
																			// Format string value
																			$value["UTILIZADO"] = preg_replace('/\./', '', $value["UTILIZADO"], 1);
																			$value["UTILIZADO"] = str_replace(",", ".", $value["UTILIZADO"]);

																			// Total quantity																		
																			$total_qtdU = real_sum($total_qtdU, $value["UTILIZADO"]);

																			// Check if it's the last loop
																			if( $count === ($total_elements - 1) )
																				$total_qtdU = formatMbKb($total_qtdU);
																		}
																		else if ( strpos($value["UTILIZADO"], "m") === false )
																		{
																			$total_qtdU = real_sum($total_qtdU, str_replace(",", ".", $value["UTILIZADO"]));
																		}
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";
																	
																	// Excess
																	if ( isset($value["EXCEDENTE"]) && $value["EXCEDENTE"] != "" )
																	{
																		echo "<td style='text-align: center;' title='" . $value["EXCEDENTE"] . "'>" . $value["EXCEDENTE"] . "</td>";

																		// Total quantity
																		if ( strpos($value["EXCEDENTE"], ",") !== false )
																		{
																			// Format string value
																			$value["EXCEDENTE"] = preg_replace('/\./', '', $value["EXCEDENTE"], 1);
																			$value["EXCEDENTE"] = str_replace(",", ".", $value["EXCEDENTE"]);

																			// Total quantity																		
																			$total_qtdE = real_sum($total_qtdE, $value["EXCEDENTE"]);

																			// Check if it's the last loop
																			if( $count === ($total_elements - 1) )
																				$total_qtdE = formatMbKb($total_qtdE);
																		}
																		else if ( strpos($value["EXCEDENTE"], "m") === false )
																		{
																			$total_qtdE = real_sum($total_qtdE, str_replace(",", ".", $value["EXCEDENTE"]));
																		}
																	}
																	else
																		echo "<td style='text-align: center;'>-</td>";

																	break;
															}

															// Total value
															if ( isset($value["VALOR"]) && $value["VALOR"] != "" )
															{
																$value["VALOR"] = str_replace(":", ",", $value["VALOR"]);
																echo "<td style='text-align: center;' title='" . real_currency(str_replace(",", ".", $value["VALOR"])) . "'>" . real_currency(str_replace(",", ".", $value["VALOR"])) . "</td>";

																// Total sum
																$total_value = real_sum($total_value, str_replace(",", ".", $value["VALOR"]));
															}
															else
															{
																echo "<td style='text-align: center;'>-</td>";
															}

															// Charged value
															if ( $carrier == 1 ) // Just to Claro carrier
															{
																if ( isset($value["VALOR_COBRADO"]) && $value["VALOR_COBRADO"] != "" )
																{
																	echo "<td style='text-align: center;' title='" . real_currency(str_replace(",", ".", $value["VALOR_COBRADO"])) . "'>" . real_currency(str_replace(",", ".", $value["VALOR_COBRADO"])) . "</td>";

																	// Total sum
																	$total_value2 = real_sum($total_value2, str_replace(",", ".", $value["VALOR_COBRADO"]));
																}
																else
																{
																	echo "<td style='text-align: center;'>-</td>";
																}
															}

															// End content
															echo "</tr>";
															$count += 1;
															$subtotal_traffic = 0;
														}

														// Format the time (if necessary)
														if ( $total_time == "00:00" || $total_time == "0:00" )
															$total_time = "0:00";

														if ( $total_time2 == "00:00" || $total_time2 == "0:00" )
															$total_time2 = "0:00";
														
														if ( $total_time3 == "00:00" || $total_time3 == "0:00" )
															$total_time3 = "0:00";
													?>
												</tbody>
												<tfoot>
													<tr>
														<?php if ( $carrier == 10 ) { // Nextel ?>
															<td colspan="3" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } else { ?>
															<td colspan="2" style="text-align: center; white-space: nowrap;"><h4>Subtotal:</h4></td>
														<?php } ?>
														<td style="text-align: center; white-space: nowrap;"><h4>
														<?php
															// Check which information is necessary to print 
															if ( $total_qtdI != 0 && $total_time != "0:00" && $total_trafficI != 0 ) // Numeric total + time + traffic
																echo $total_qtdI . " / " . $total_time . " / " . formatMbKb($total_trafficI);
															else if ( $total_qtdI != 0 && $total_time != "0:00" ) // Numeric total + time 
																echo $total_qtdI . " / " . $total_time;
															else if ( $total_qtdI != 0 ) // Numeric total
																echo $total_qtdI;
															else if ( $total_trafficI != 0 ) // Traffic
																echo formatMbKb($total_trafficI);
															else if ( $total_time != "0:00" ) // MM:SS time
																echo format_mm_ss($total_time);
															else
																echo "-";
														?>
														</h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4>
														<?php
															// Check which information is necessary to print 
															if ( $total_qtdU != 0 && $total_time2 != "0:00" && $total_trafficU != 0 ) // Numeric total + time + traffic
																echo $total_qtdU . " / " . $total_time2 . " / " . formatMbKb($total_trafficU);
															else if ( $total_qtdU != 0 && $total_time2 != "0:00" ) // Numeric total + time 
																echo $total_qtdU . " / " . $total_time2;
															else if ( $total_qtdU != 0 ) // Numeric total
																echo $total_qtdU;
															else if ( $total_trafficU != 0 ) // Traffic
																echo formatMbKb($total_trafficU);
															else if ( $total_time2 != "0:00" ) // MM:SS time
																echo format_mm_ss($total_time2);
															else
																echo "-";
														?>
														</h4></td>
														<td style="text-align: center; white-space: nowrap;"><h4>
														<?php
															// Check which information is necessary to print 
															if ( $total_qtdE != 0 && $total_time3 != "0:00" && $total_trafficE != 0 ) // Numeric total + time + traffic
																echo $total_qtdE . " / " . $total_time3 . " / " . formatMbKb($total_trafficE);
															else if ( $total_qtdE != 0 && $total_time3 != "0:00" ) // Numeric total + time 
																echo $total_qtdE . " / " . $total_time3;
															else if ( $total_qtdE != 0 ) // Numeric total
																echo $total_qtdE;
															else if ( $total_trafficE != 0 ) // Traffic
																echo formatMbKb($total_trafficE);
															else if ( $total_time3 != "0:00" ) // MM:SS time
																echo format_mm_ss($total_time3);
															else
																echo "-";
														?>
														</h4></td>
														<td id="foot_total" style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value); ?></h4></td>
														<?php if ( $carrier == 1 ) { // Claro ?>
															<td style="text-align: center; white-space: nowrap;"><h4>R$ <?php echo real_currency($total_value2); ?></h4></td>
														<?php } ?>
													</tr>
												</tfoot>
												<input type="hidden" id="total_value" value="<?php echo real_currency($total_value); ?>" />
											<?php } ?>
										</table>

										<?php echo $hidden_field_list; ?>
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

			var results = [];

			/** Function to send the contestation
			 * @param pec_ID_ => pec ID
			 * @param phone_ID_ => phone ID
			 * @param det_contestation_ID_ => det ID
			 * @param id_phone_contest_ => phone contestation ID
			 * @param contest_type_ => contestation type: 0 => VALID / 1 => CONTESTATION
			*/
			function contestRegister( pec_ID_, phone_ID_, det_contestation_ID_, id_phone_contest_, contest_type_ )
			{
				var justify;

				if ( contest_type_ == 0 )
					justify = prompt("Informe uma justificativa para a validação", "");
				else
					justify = prompt("Informe uma justificativa para a contestação", "");

				if ( justify != "" && justify != null )
				{
					// Callback to delete the element
					sendRequest( '<?php echo HOME_URI;?>/modulo_pec/contestacaodetailreportbyregister_pec', 'action=contest&phone_ID=' + phone_ID_ + '&pec_ID=' + pec_ID_ + 
						'&id_pec_det=' + det_contestation_ID_ + '&contest_ID=' + id_phone_contest_ + '&contest_type=' + contest_type_ + 
						'&contest_justify=' + justify, 'POST', '///', document.getElementById('elem_DUMMY'), 'delete' );

					// Realod the page with parameters
					location.reload();
				}
				else
				{
					if ( contest_type == 0 )
						alert("Informe uma justificativa para realizar a contestação.");
					else
						alert("Informe uma justificativa para realizar a validação.");

					return false;
				}
			}

			/** Function to send the contestation
			 * @param contest_type => contestation type: 0 => VALID / 1 => CONTESTATION
			*/
			function contestAll( contest_type )
			{
				// Auxiliary variables
				var elem_CONTEST = document.getElementsByName("elem_CONTEST");
				var SELECT_ACESSOS = document.getElementById("SELECT_ACESSOS");
				var SELECT_TARIFA = document.getElementById("SELECT_TARIFA");
				var DDD_LOCALIDADE = document.getElementById("DDD_LOCALIDADE");
				var VALOR_FATURA = document.getElementById("VALOR_FATURA");
				var VALOR_CALCULADO = document.getElementById("VALOR_CALCULADO");
				var DIFF_VALUE = document.getElementById("DIFF_VALUE");
				var SELECT_OPERATOR = document.getElementById("SELECT_OPERATOR");
				var JUSTIFICATIVA = document.getElementById("JUSTIFICATIVA");
				var phone_id = "";
				var list_value = "";
				var contest_array;
				var aux_info;

				// Validate the filter
				if ( SELECT_ACESSOS.value == "" && SELECT_TARIFA.value == "" && DDD_LOCALIDADE.value == "" && VALOR_FATURA.value == "" && VALOR_CALCULADO.value == "" && DIFF_VALUE.value == "" && SELECT_OPERATOR.value == "" )
				{
					alert("Preencha ao menos um parâmetro e a justificativa para realizar o filtro!");
					SELECT_ACESSOS.focus();
					return false;
				}
				else if ( DIFF_VALUE.value != "" && SELECT_OPERATOR.value == "" || DIFF_VALUE.value == "" && SELECT_OPERATOR.value != "" )
				{
					alert("O parâmetro diferença necessita que a diferença e a condição sejam preenchidas.");
					DIFF_VALUE.focus();
					return false;
				}
				else
				{
					// Validate the justify
					if ( JUSTIFICATIVA.value == "" )
					{
						alert("Informe a justificativa.");
						JUSTIFICATIVA.focus();
						return false;
					}
					else
					{
						// Check if it's selectec
						if ( SELECT_ACESSOS.value != "" )
						{
							// Run through select options
							for ( x = 0; x < SELECT_ACESSOS.options.length; x++ )
							{
								// Check if the option is selected
								if ( SELECT_ACESSOS.options[x].selected == true )
								{
									// Run through all registers
									for ( z = 0; z < elem_CONTEST.length; z++ )
									{
										phone_id = elem_CONTEST[z].id.toString().replace("elem_CONTEST", "");

										// If the phone list was informed
										if ( SELECT_ACESSOS.options[x].value.localeCompare( phone_id ) == 0 )
										{
											// Get the specific attributes
											var data_tp_tax = elem_CONTEST[z].getAttribute("data-tp-tax");
											var data_ddd_tax = elem_CONTEST[z].getAttribute("data-ddd-tax");
											var data_vl_invoice = elem_CONTEST[z].getAttribute("data-vl-invoice");
											var data_vl_calculated = elem_CONTEST[z].getAttribute("data-vl-calculated");
											var data_diff = elem_CONTEST[z].getAttribute("data-diff");

											// Tax type
											if ( SELECT_TARIFA.value != "" && SELECT_TARIFA.value.localeCompare( data_tp_tax ) != 0 )
												continue;

											// DDD Location
											if ( DDD_LOCALIDADE.value != "" && DDD_LOCALIDADE.value != data_ddd_tax )
												continue;

											// Invoice value
											if ( VALOR_FATURA.value != "" && VALOR_FATURA.value != data_vl_invoice )
												continue;

											// Calculated value
											if ( VALOR_CALCULADO.value != "" && VALOR_CALCULADO.value != data_vl_calculated )
												continue;

											// Difference
											if ( DIFF_VALUE.value != "" && SELECT_OPERATOR.value != "" )
											{
												// Check the conditions
												if ( SELECT_OPERATOR.value == ">" )
												{
													if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) > parseFloat(data_diff.replace(",", ".")).toFixed(2) )
														continue;
												}
												else if ( SELECT_OPERATOR.value == "<" )
												{
													if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) < parseFloat(data_diff.replace(",", ".")).toFixed(2) )
														continue;
												}
												else if ( SELECT_OPERATOR.value == ">=" )
												{
													if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) > parseFloat(data_diff.replace(",", ".")).toFixed(2) )
														continue;
												}
												else if ( SELECT_OPERATOR.value == "<=" )
												{
													if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) < parseFloat(data_diff.replace(",", ".")).toFixed(2) )
														continue;
												}
												else if ( SELECT_OPERATOR.value == "=" )
												{
													if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) != parseFloat(data_diff.replace(",", ".")).toFixed(2) )
														continue;
												}
											}

											list_value += elem_CONTEST[z].value + "//";
										}
									}
								}
							}
						}
						// If the phone list wasn't informed
						else
						{
							for ( z = 0; z < elem_CONTEST.length; z++ )
							{
								// Get the specific attributes
								var data_tp_tax = elem_CONTEST[z].getAttribute("data-tp-tax");
								var data_ddd_tax = elem_CONTEST[z].getAttribute("data-ddd-tax");
								var data_vl_invoice = elem_CONTEST[z].getAttribute("data-vl-invoice");
								var data_vl_calculated = elem_CONTEST[z].getAttribute("data-vl-calculated");
								var data_diff = elem_CONTEST[z].getAttribute("data-diff");

								// Tax type
								if ( SELECT_TARIFA.value != "" && SELECT_TARIFA.value.localeCompare( data_tp_tax ) != 0 )
									continue;

								// DDD Location
								if ( DDD_LOCALIDADE.value != "" && DDD_LOCALIDADE.value != data_ddd_tax )
									continue;

								// Invoice value
								if ( VALOR_FATURA.value != "" && VALOR_FATURA.value != data_vl_invoice )
									continue;

								// Calculated value
								if ( VALOR_CALCULADO.value != "" && VALOR_CALCULADO.value != data_vl_calculated )
									continue;

								// Difference
								if ( DIFF_VALUE.value != "" && SELECT_OPERATOR.value != "" )
								{
									// Check the conditions
									if ( SELECT_OPERATOR.value == ">" )
									{
										if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) > parseFloat(data_diff.replace(",", ".")).toFixed(2) )
											continue;
									}
									else if ( SELECT_OPERATOR.value == "<" )
									{
										if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) < parseFloat(data_diff.replace(",", ".")).toFixed(2) )
											continue;
									}
									else if ( SELECT_OPERATOR.value == ">=" )
									{
										if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) > parseFloat(data_diff.replace(",", ".")).toFixed(2) )
											continue;
									}
									else if ( SELECT_OPERATOR.value == "<=" )
									{
										if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) < parseFloat(data_diff.replace(",", ".")).toFixed(2) )
											continue;
									}
									else if ( SELECT_OPERATOR.value == "=" )
									{
										if ( parseFloat(DIFF_VALUE.value.replace(",", ".")).toFixed(2) != parseFloat(data_diff.replace(",", ".")).toFixed(2) )
											continue;
									}
								}

								list_value += elem_CONTEST[z].value + "//";
							}
						}
					}
				}

				contest_array = list_value.split("//");

				if ( parseInt(contest_array.length) != 0 )
				{
					for ( var i = 0; i < contest_array.length; i++ )
					{
						if ( contest_array[i] != "" )
						{
							aux_info = contest_array[i].split("@@");

							// Callback to delete the element
							results.push( sendRequestAjax( '<?php echo HOME_URI;?>/modulo_pec/contestacaodetailreportbyregister_pec?action=contest&phone_ID=' + aux_info[1] + 
								'&pec_ID=' + aux_info[0] +  '&id_pec_det=' + aux_info[2] + '&contest_ID=' + aux_info[3] + '&contest_type=' + contest_type + 
								'&contest_justify=' + JUSTIFICATIVA.value, 'POST', 'text' ) );
						}
					}

					return true;
				}
				else
				{
					alert("Nenhum item foi localizado com os parâmetros informados.")
					return false;
				}
			}

		</script>