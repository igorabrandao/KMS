							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Visualizar Contrato">Visualizar Contrato <small>visualização </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php

						// Check if the contract ID is valid
						if ( isset($_GET['n_contract']) && $_GET['n_contract'] != '' )
						{
							$contract_id = decrypted_url($_GET['n_contract'] , "**");

							// Load contract information
							$contract_info = $modelo->load_contract_info($contract_id);
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
									<h2><i class="fa fa-pencil-square teal"></i> VISUALIZAR CONTRATO</h2>
									<p>
										Informações referentes ao contrato.
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
																		<th style="width: 12%; text-align: center;" title="TIPO CONTRATO">TIPO CONTRATO</th>
																		<th style="width: 10%; text-align: center;" title="Nº CONTA">Nº CONTA</th>
																		<th style="width: 22%; text-align: center;" title="EMPRESA">EMPRESA</th>
																		<th style="width: 12%; text-align: center;" title="TIPO SERVIÇO">TIPO SERVIÇO</th>
																		<th style="width: 10%; text-align: center;" title="OPERADORA">OPERADORA</th>
																		<th style="width: 15%; text-align: center;" title="DATA ASSINATURA">DATA ASSINATURA</th>
																		<th style="width: 12%; text-align: center;" title="DATA ATIVAÇÃO">DATA ATIVAÇÃO</th>
																		<th style="width: 12%; text-align: center;" title="VIGÊNCIA">VIGÊNCIA</th>
																	</tr>
																</thead>
																<tbody>
																	<?php

																		// Init row
																		echo "<tr>";

																		// Contract type
																		if ( isset($contract_info["ID_TIPO_CONTRATO"]) && $contract_info["ID_TIPO_CONTRATO"] )
																		{
																			// Contract type list
																			$lista = $modelo->get_contract_type();

																			foreach ( $lista as $value )
																			{
																				if ( $contract_info["ID_TIPO_CONTRATO"] == $value[0] )
																				{
																					echo "<td style='text-align: center;' title='" .$value[1] . "'>" . $value[1] . "</td>";
																					break;
																				}
																			}
																		}
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Invoice number
																		if ( isset($contract_info["N_CONTA"]) && $contract_info["N_CONTA"] )
																			echo "<td style='text-align: center;' title='" . $contract_info["N_CONTA"] . "'>" . $contract_info["N_CONTA"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Company
																		if ( isset($contract_info["ID_EMPRESA"]) && $contract_info["ID_EMPRESA"] )
																		{
																			// Company list
																			$lista = $modelo->get_company_list();

																			foreach ( $lista as $value )
																			{
																				if ( $contract_info["ID_EMPRESA"] == $value[0] )
																				{
																					echo "<td style='text-align: center;' title='" . $value[1] . "'>" . $value[1] . $value[2] . "</td>";
																					break;
																				}
																			}
																		}
																		else
																			echo "<td style='text-align: center;'> - </td>";
																		
																		// Service type
																		if ( isset($contract_info["ID_TIPO_SERVICO"]) && $contract_info["ID_TIPO_SERVICO"] )
																		{
																			// Service type
																			$lista = $modelo->get_service_type();

																			foreach ( $lista as $value )
																			{
																				if ( $contract_info["ID_TIPO_SERVICO"] == $value[0] )
																				{
																					echo "<td style='text-align: center;' title='" . $value[1] . "'>" . $value[1] . "</td>";
																					break;
																				}
																			}
																		}
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Carrier
																		if ( isset($contract_info["ID_OPERADORA"]) && $contract_info["ID_OPERADORA"] )
																		{
																			// Carrier list
																			$lista = $modelo->get_operadora_list();

																			foreach ( $lista as $value )
																			{
																				if ( $contract_info["ID_OPERADORA"] == $value[0] )
																				{
																					echo "<td style='text-align: center;' title='" . $value[1] . "'>" . $value[1] . "</td>";
																					break;
																				}
																			}
																		}
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Sign date
																		if ( isset($contract_info["DATA_ASSINATURA"]) && $contract_info["DATA_ASSINATURA"] )
																			echo "<td style='text-align: center;' title='" . $contract_info["DATA_ASSINATURA"] . "'>" . $contract_info["DATA_ASSINATURA"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Actvation date
																		if ( isset($contract_info["DATA_ATIVACAO"]) && $contract_info["DATA_ATIVACAO"] )
																			echo "<td style='text-align: center;' title='" . $contract_info["DATA_ATIVACAO"] . "'>" . $contract_info["DATA_ATIVACAO"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Vigence
																		if ( isset($contract_info["CARENCIA"]) && $contract_info["CARENCIA"] )
																			echo "<td style='text-align: center;' title='" . $contract_info["CARENCIA"] . "'>" . $contract_info["CARENCIA"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

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

										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-12">
														<label for="form-field-mask-2">
															Equipamentos
														</label>
														<div class="table-responsive">
															<table id="table_Equip" class="table table-striped table-bordered table-hover">
																<thead>
																	<tr>
																		<th style="width: 18%; text-align: center;" title="TIPO DE NEGOCIAÇÃO">Tipo de negociação</th>
																		<th style="width: 15%; text-align: center;" title="QUANTIDADE DE APARELHOS">Qtd. Aparelhos</th>
																		<th style="width: 15%; text-align: center;" title="QUANTIDADE DE CHIPS">Qtd. Chips</th>
																		<th style="width: 15%; text-align: center;" title="Nº DE PARCELAS">Nº de parcelas</th>
																		<th style="width: 15%; text-align: center;" title="VALOR DA PARCELA">Valor da Parcela</th>
																		<th style="width: 15%; text-align: center;" title="VALOR TOTAL">Valor total</th>
																	</tr>
																</thead>
																<tbody id="tableToModifyEquip">
																	<?php 
																		// Equipment list
																		$equip_lista = $modelo->load_contract_equipment($contract_id);
																		$equip_lista_ID = "";
																		$equip_counter = 0;
																		$equip_counter2 = 0;

																		foreach ( $equip_lista as $equip_value )
																		{
																			// Add the ID
																			$equip_lista_ID .= $equip_value["ID_CONTRATO_EQUIPAMENTO"] . "//";

																			if ( $equip_counter2 == 0 )
																				$equip_counter = "";

																			// Open the <TR> tag
																			echo '<tr id="rowToCloneEquip' . $equip_counter . '" name="rowToCloneEquip">';

																			// Negotiation type
																			if ( isset($equip_value["ID_TIPO_NEGOCIACAO"]) && $equip_value["ID_TIPO_NEGOCIACAO"] )
																			{
																				// Service type
																				$lista = $modelo->get_equip_negotiation_list();

																				foreach ( $lista as $value )
																				{
																					if ( $equip_value["ID_TIPO_NEGOCIACAO"] == $value[0] )
																					{
																						echo "<td style='text-align: center;' title='" . $value[1] . "'>" . $value[1] . "</td>";
																						break;
																					}
																				}
																			}
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Device quantity
																			if ( isset($equip_value["QTD_APARELHOS"]) && $equip_value["QTD_APARELHOS"] != "" )
																				echo "<td style='text-align: center;' title='" . $equip_value["QTD_APARELHOS"] . "'>" . $equip_value["QTD_APARELHOS"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Chips quantity
																			if ( isset($equip_value["QTD_CHIPS"]) && $equip_value["QTD_CHIPS"] != "" )
																				echo "<td style='text-align: center;' title='" . $equip_value["QTD_CHIPS"] . "'>" . $equip_value["QTD_CHIPS"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Installments number
																			if ( isset($equip_value["N_PARCELAS"]) && $equip_value["N_PARCELAS"] != "" )
																				echo "<td style='text-align: center;' title='" . $equip_value["N_PARCELAS"] . "'>" . $equip_value["N_PARCELAS"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Installments value
																			if ( isset($equip_value["VALOR_PARCELA_EQUIP"]) && $equip_value["VALOR_PARCELA_EQUIP"] != "" )
																				echo "<td style='text-align: center;' title='" . $equip_value["VALOR_PARCELA_EQUIP"] . "'>R$ " . $equip_value["VALOR_PARCELA_EQUIP"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Total value
																			if ( isset($equip_value["VALOR_PARCELA_EQUIP"]) && $equip_value["VALOR_PARCELA_EQUIP"] != "" )
																				echo "<td style='text-align: center;' title='" . real_currency( currency_operation( iif($equip_value["N_PARCELAS"]), iif($equip_value["VALOR_PARCELA_EQUIP"]), "*" ) ) . "'>R$ " . real_currency( currency_operation( iif($equip_value["N_PARCELAS"]), iif($equip_value["VALOR_PARCELA_EQUIP"]), "*" ) ) . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Close the <TR> tag
																			echo '</tr>';

																			// Increment the counter
																			$equip_counter2++;
																			$equip_counter = $equip_counter2;
																		}
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>

										<hr>

										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-12">
														<label for="form-field-mask-2">
															Planos
														</label>
														<table id="table_Plan" class="table table-striped table-bordered table-hover">
															<thead>
																<tr>
																	<th style="width: 16%; text-align: center;" title="TIPO DO PLANO">Tipo</th>
																	<th style="width: 12%; text-align: center;" title="DESCRIÇÃO DO PLANO">Descrição</th>
																	<th style="width: 4%; text-align: center;" title="QUANTIDADE">Quantidade</th>
																	<th style="width: 7%; text-align: center;" title="VALOR DA ASSINATURA">Assinatura</th>
																	<th style="width: 9%; text-align: center; display: none;" title="PACOTE DE VOZ">Pacote de voz</th>
																	<th style="width: 8%; text-align: center;" title="TARIFA LOCAL">Tarifa local</th>
																	<th style="width: 8%; text-align: center;" title="VOLUME DO PLANO">Volume</th>
																	<th style="width: 5%; text-align: center;" title="MINUTOS">Minutos</th>
																	<th style="width: 8%; text-align: center;" title="VALOR DO PACOTE DE MINUTOS">Valor pacote min.</th>
																	<th style="width: 7%; text-align: center;" title="DESCONTO">Desconto</th>
																	<th style="width: 9%; text-align: center;" title="VALOR TOTAL">Valor total</th>
																</tr>
															</thead>
															<tbody id="tableToModifyPlan">
																<?php
																	// Plan list
																	$plan_lista = $modelo->load_contract_plan($contract_id);
																	$plan_counter = 0;
																	$plan_counter2 = 0;
																	$total_value = 0;
																	$plan_lista_ID = "";
																	$print_plan = 0;

																	foreach ( $plan_lista as $plan_value )
																	{
																		// Add the ID
																		$plan_lista_ID .= $plan_value["ID_PLANO_CONTRATO"] . "//";
																		$readonly = "disabled='false'";
																		$total_value = 0;

																		if ( $plan_counter2 == 0 )
																			$plan_counter = "";

																		// Open the <TR> tag
																		echo '<tr id="rowToClonePlan' . $plan_counter . '" name="rowToClonePlan">';

																		// Plan type
																		if ( isset($plan_value["ID_TIPO_PLANO"]) && $plan_value["ID_TIPO_PLANO"] )
																		{
																			// Plan type
																			$lista = $modelo->get_plan_type_list();

																			foreach ( $lista as $value )
																			{
																				if ( $plan_value["ID_TIPO_PLANO"] == $value[0] )
																				{
																					echo "<td style='text-align: center;' title='" . $value[1] . "'>" . $value[1] . "</td>";
																					break;
																				}
																			}
																		}
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Plan description
																		if ( isset($plan_value["DESCRITIVO_PLANO"]) && $plan_value["DESCRITIVO_PLANO"] != "" )
																			echo "<td style='text-align: center;' title='" . $plan_value["DESCRITIVO_PLANO"] . "'>" . $plan_value["DESCRITIVO_PLANO"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Plan quantity
																		if ( isset($plan_value["QUANTIDADE_PLANO"]) && $plan_value["QUANTIDADE_PLANO"] != "" )
																			echo "<td style='text-align: center;' title='" . $plan_value["QUANTIDADE_PLANO"] . "'>" . $plan_value["QUANTIDADE_PLANO"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Plan value
																		if ( isset($plan_value["VALOR_ASSINATURA_PLANO"]) && $plan_value["VALOR_ASSINATURA_PLANO"] != "" )
																			echo "<td style='text-align: center;' title='" . $plan_value["VALOR_ASSINATURA_PLANO"] . "'>R$ " . $plan_value["VALOR_ASSINATURA_PLANO"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Voice package
																		if ( isset($plan_value["DESCRITIVO_PACOTE_VOZ"]) && $plan_value["DESCRITIVO_PACOTE_VOZ"] != "" )
																			echo "<td style='display: none; text-align: center;' title='" . $plan_value["DESCRITIVO_PACOTE_VOZ"] . "'>" . $plan_value["DESCRITIVO_PACOTE_VOZ"] . "</td>";
																		else
																			echo "<td style='display: none; text-align: center;'> - </td>";

																		// Local tax
																		if ( isset($plan_value["TARIFA_LOCAL"]) && $plan_value["TARIFA_LOCAL"] != "" )
																			echo "<td style='text-align: center;' title='" . $plan_value["TARIFA_LOCAL"] . "'>R$ " . $plan_value["TARIFA_LOCAL"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Volume
																		if ( isset($plan_value["VOLUME_PLANO"]) && $plan_value["VOLUME_PLANO"] != "" )
																			echo "<td style='text-align: center;' title='" . $plan_value["VOLUME_PLANO"] . "'>" . $plan_value["VOLUME_PLANO"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Minutes
																		if ( isset($plan_value["MINUTOS"]) && $plan_value["MINUTOS"] != "" )
																			echo "<td style='text-align: center;' title='" . $plan_value["MINUTOS"] . "'>" . $plan_value["MINUTOS"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Minutes package value
																		if ( isset($plan_value["VALOR_PAC_MIN"]) && $plan_value["VALOR_PAC_MIN"] != "" )
																			echo "<td style='text-align: center;' title='" . $plan_value["VALOR_PAC_MIN"] . "'>R$ " . $plan_value["VALOR_PAC_MIN"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Plan discount
																		if ( isset($plan_value["DESCONTO_PLANO"]) && $plan_value["DESCONTO_PLANO"] != "" )
																			echo "<td style='text-align: center;' title='" . $plan_value["DESCONTO_PLANO"] . "'>R$ " . $plan_value["DESCONTO_PLANO"] . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Calculates the total value
																		$total_value = real_currency( currency_operation( iif($plan_value["QUANTIDADE_PLANO"]), iif($plan_value["VALOR_ASSINATURA_PLANO"]), "*" ) );
																		$total_value = real_currency( currency_operation( $total_value, iif($plan_value["VALOR_PAC_MIN"]), "+" ) );
																		$total_value = real_currency( currency_operation( $total_value, iif($plan_value["DESCONTO_PLANO"]), "-" ) );

																		// Plan total value
																		if ( isset($total_value) && $total_value != "" )
																			echo "<td style='text-align: center;' title='" . $total_value . "'>" . $total_value . "</td>";
																		else
																			echo "<td style='text-align: center;'> - </td>";

																		// Close the <TR> tag
																		echo '</tr>';
																		$print_plan++;

																		// Increment the counter
																		$plan_counter2++;
																		$plan_counter = $plan_counter2;
																	}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>

										<hr>

										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-12">
														<label for="form-field-mask-2">
															Módulos
														</label>
														<div class="table-responsive">
															<table id="table_Modulo" class="table table-striped table-bordered table-hover">
																<thead>
																	<tr>
																		<th style="width: 16%; text-align: center;" title="REFERÊNCIA DO PLANO">Plano</th>
																		<th style="width: 5%; text-align: center;" title="TIPO DO MÓDULO">Tipo</th>
																		<th style="width: 5%; text-align: center;" title="MÓDULO COMPARTILHADO">Compartilhado</th>
																		<th style="width: 25%; text-align: center;" title="DESCRIÇÃO DO MÓDULO">Descrição</th>
																		<th style="width: 7%; text-align: center;" title="QUANTIDADE">Quantidade</th>
																		<th style="width: 8%; text-align: center;" title="VOLUME">Volume</th>
																		<th style="width: 9%; text-align: center;" title="VALOR DA ASSINATURA">Assinatura</th>
																		<th style="width: 9%; text-align: center;" title="DESCONTO">Desconto</th>
																		<th style="width: 10%; text-align: center;" title="VALOR TOTAL">Valor Total</th>
																	</tr>
																</thead>
																<tbody id="tableToModifyModulo">
																	<?php
																		// Module list
																		$module_lista = $modelo->load_contract_module($contract_id);
																		$module_counter = 0;
																		$module_counter2 = 0;
																		$total_value = 0;
																		$module_lista_ID = "";

																		foreach ( $module_lista as $module_value )
																		{
																			// Add the ID
																			$module_lista_ID .= $module_value["ID_MODULO_CONTRATO"] . "//";

																			$total_value = 0;

																			if ( $module_counter2 == 0 )
																				$module_counter = "";

																			// Open the <TR> tag
																			echo '<tr id="rowToCloneModulo' . $module_counter . '" name="rowToCloneModulo">';

																			// Plan reference
																			if ( isset($plan_value["ID_PLANO_CONTRATO"]) && $plan_value["ID_PLANO_CONTRATO"] )
																			{
																				// Plan reference list
																				$lista = $modelo->get_plan_list($contract_id);

																				foreach ( $lista as $value )
																				{
																					if ( $module_value["ID_PLANO_CONTRATO"] == $value[0] )
																					{
																						echo "<td style='text-align: center;' title='" . $value[1] . "'>" . $value[1] . "</td>";
																						break;
																					}
																				}
																			}
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Module type
																			if ( isset($module_value["ID_TIPO_MODULO"]) && $module_value["ID_TIPO_MODULO"] )
																			{
																				// Module type list
																				$lista = $modelo->get_module_type_list();

																				foreach ( $lista as $value )
																				{
																					if ( $module_value["ID_TIPO_MODULO"] == $value[0] )
																					{
																						echo "<td style='text-align: center;' title='" . $value[1] . "'>" . $value[1] . "</td>";
																						break;
																					}
																				}
																			}
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Shared module check
																			if ( $module_value["IS_COMPARTILHADO"] == 1 )
																				echo "<td style='text-align: center;' title='SIM'>SIM</td>";
																			else
																				echo "<td style='text-align: center;' title='NÃO'>NÃO</td>";

																			// Module description
																			if ( isset($module_value["DESCRITIVO_MODULO"]) && $module_value["DESCRITIVO_MODULO"] != "" )
																				echo "<td style='text-align: center;' title='" . $module_value["DESCRITIVO_MODULO"] . "'>" . $module_value["DESCRITIVO_MODULO"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Module quantity
																			if ( isset($module_value["QUANTIDADE_MODULO"]) && $module_value["QUANTIDADE_MODULO"] != "" )
																				echo "<td style='text-align: center;' title='" . $module_value["QUANTIDADE_MODULO"] . "'>" . $module_value["QUANTIDADE_MODULO"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Module volume
																			if ( isset($module_value["VOLUME_MODULO"]) && $module_value["VOLUME_MODULO"] != "" )
																				echo "<td style='text-align: center;' title='" . $module_value["VOLUME_MODULO"] . "'>" . $module_value["VOLUME_MODULO"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Module value
																			if ( isset($module_value["VALOR_ASSINATURA_MODULO"]) && $module_value["VALOR_ASSINATURA_MODULO"] != "" )
																				echo "<td style='text-align: center;' title='" . $module_value["VALOR_ASSINATURA_MODULO"] . "'>R$ " . $module_value["VALOR_ASSINATURA_MODULO"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Module discount
																			if ( isset($module_value["DESCONTO_MODULO"]) && $module_value["DESCONTO_MODULO"] != "" )
																				echo "<td style='text-align: center;' title='" . $module_value["DESCONTO_MODULO"] . "'>R$ " . $module_value["DESCONTO_MODULO"] . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Calculates the total value
																			$total_value = real_currency( currency_operation( iif($module_value["QUANTIDADE_MODULO"]), iif($module_value["VALOR_ASSINATURA_MODULO"]), "*" ) );
																			$total_value = real_currency( currency_operation( $total_value, iif($module_value["DESCONTO_MODULO"]), "-" ) );

																			// Module total value
																			if ( isset($total_value) && $total_value != "" )
																				echo "<td style='text-align: center;' title='" . $total_value . "'>R$ " . $total_value . "</td>";
																			else
																				echo "<td style='text-align: center;'> - </td>";

																			// Close the <TR> tag
																			echo '</tr>';

																			// Increment the counter
																			$module_counter2++;
																			$module_counter = $module_counter2;
																		}
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>

										<hr>

										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-6">
														<label for="form-field-mask-2">
															Quantidade de linhas
														</label>
														<div class="table-responsive">
															<table id="table_DDD" class="table table-striped table-bordered table-hover">
																<thead>
																	<tr>
																		<th style="width: 50%; text-align: center;" title="REFERÊNCIA DO PLANO">Plano</th>
																		<th style="width: 25%; text-align: center;" title="DDD">DDD</th>
																		<th style="width: 25%; text-align: center;" title="QUANTIDADE">Quantidade</th>
																	</tr>
																</thead>
																<tbody id="tableToModifyDDD">
																	<?php
																		// Module list
																		$DDD_lista = $modelo->load_contract_DDD($contract_id);
																		$DDD_counter = 0;
																		$DDD_counter2 = 0;
																		$DDD_lista_ID = "";

																		// Check if exist at least 1 register
																		if ( sizeof($DDD_lista) > 0 )
																		{
																			foreach ( $DDD_lista as $DDD_value )
																			{
																				// Add the ID
																				$DDD_lista_ID .= $DDD_value["ID_CONTRATO_QTD_LINHA"] . "//";

																				if ( $DDD_counter2 == 0 )
																					$DDD_counter = "";

																				// Open the <TR> tag
																				echo '<tr id="rowToCloneDDD' . $DDD_counter . '" name="rowToCloneDDD">';

																				// Plan reference
																				if ( isset($DDD_value["ID_PLANO_LINHA"]) && $DDD_value["ID_PLANO_LINHA"] )
																				{
																					// Plan reference list
																					$lista = $modelo->get_plan_list($contract_id);

																					foreach ( $lista as $value )
																					{
																						if ( $DDD_value["ID_PLANO_LINHA"] == $value[0] )
																						{
																							echo "<td style='text-align: center;' title='" . $value[1] . "'>" . $value[1] . "</td>";
																							break;
																						}
																					}
																				}
																				else
																					echo "<td style='text-align: center;'> - </td>";

																				// DDD
																				if ( isset($DDD_value["DDD"]) && $DDD_value["DDD"] != "" )
																					echo "<td style='text-align: center;' title='" . $DDD_value["DDD"] . "'>" . $DDD_value["DDD"] . "</td>";
																				else
																					echo "<td style='text-align: center;'> - </td>";

																				// Quantity
																				if ( isset($DDD_value["QTD_LINHA"]) && $DDD_value["QTD_LINHA"] != "" )
																					echo "<td style='text-align: center;' title='" . $DDD_value["QTD_LINHA"] . "'>" . $DDD_value["QTD_LINHA"] . "</td>";
																				else
																					echo "<td style='text-align: center;'> - </td>";

																				// Close the <TR> tag
																				echo '</tr>';

																				// Increment the counter
																				$DDD_counter2++;
																				$DDD_counter = $DDD_counter2;
																			}
																		}
																		else
																		{
																			?>
																				<tr id="rowToCloneDDD" name="rowToCloneDDD">
																					<td class="center">
																						<div class="form-group">
																							<select name="ID_PLANO_LINHA" id="ID_PLANO_LINHA" class="form-control" onBlur="parseTableFields( 'elem_QTDLINHAS', 'table_DDD' );">
																								<option value="">Selecione...</option>
																							</select>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<input type="text" id="txt_DDD" name="txt_DDD" class="form-control" onBlur="parseTableFields( 'elem_QTDLINHAS', 'table_DDD' );" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="3" onkeydown="addRowEnterTab( event, document.getElementById('btnAddDDD'), 'btnAddDDD', 'rowToCloneDDD', 'tableToModifyDDD' );"/>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<input type="number" id="txt_QTDLINHA" name="txt_QTDLINHA" min="1" max="10000000" class="form-control" onBlur="parseTableFields( 'elem_QTDLINHAS', 'table_DDD' );" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" onkeydown="addRowEnterTab( event, document.getElementById('btnAddDDD'), 'btnAddDDD', 'rowToCloneDDD', 'tableToModifyDDD' );"/>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<div class="visible-md visible-lg hidden-sm hidden-xs">
																								<a id="btnAddDDD" name="btnAddDDD" onclick="cloneRow( this, 'btnAddDDD', 'rowToCloneDDD', 'tableToModifyDDD' );" class="btn btn-xs btn-teal" title="Adicionar DDD"><i class="fa fa-plus"></i></a>
																								<a id="btnRemoveDDD" name="btnRemoveDDD" onclick="deleteDDD( this );" class="btn btn-xs btn-bricky" title="Remover DDD"><i class="fa fa-times fa fa-white"></i></a>
																							</div>
																						</div>
																					</td>
																				</tr>
																			<?php
																		}
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>

										<hr>

										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-12">
														<label for="form-field-mask-2">
															Anexos
														</label>
														<div class="table-responsive">
															<table id="table_anexo" class="table table-striped table-bordered table-hover">
																<thead>
																	<tr>
																		<th style="width: 80%;">Arquivo</th>
																		<th style="width: 20%;"></th>
																	</tr>
																</thead>
																<tbody id="tableToModifyAnexo">
																	<?php
																		// Attachment list
																		$anexo_lista = $modelo->load_contract_attachment($contract_id);
																		$attach_lista_ID = "";
																		$attach_counter = 0;
																		$attach_counter2 = 0;

																		if ( sizeof($anexo_lista) > 0 )
																		{
																			foreach ( $anexo_lista as $anexo_value )
																			{
																				// Add the ID
																				$attach_lista_ID .= $anexo_value["ID_ANEXO_CONTRATO"] . "//";

																				if ( $attach_counter2 == 0 )
																						$attach_counter = "";

																				// Open the <TR> tag
																				echo '<tr id="rowToCloneAnexo' . $attach_counter . '" name="rowToCloneAnexo">';

																				// Attachment field
																				if ( isset($anexo_value["ANEXO"]) && $anexo_value["ANEXO"] )
																				{
																					echo "<td style='text-align: left;' title='" . file_basename($anexo_value["ANEXO"]) . "'>";
																					echo "<table><tr><td>";
																					echo "<div class='icons' style='width: 50%; margin: auto;'><div class='file-icon' data-type='" . file_ext($anexo_value["ANEXO"]) . "'></div></div>";
																					echo "</td><td style='padding-left: 15px;'>" . file_basename($anexo_value["ANEXO"]) . "</td>";
																					echo "</tr></table></td>";
																				}
																				else
																					echo "<td style='text-align: center;'> - </td>";

																				// Buttons
																				echo '<td class="center"><div class="visible-md visible-lg hidden-sm hidden-xs">';
																				echo '<a name="btnAddAnexo" style="display: none;" class="btn btn-xs btn-teal" title="Adicionar módulo"><i class="fa fa-plus"></i></a>';
																				echo '<a name="btnRemoveAnexo" onclick="deleteAttach( this );" class="btn btn-xs btn-bricky" title="Remover arquivo"><i class="fa fa-times fa fa-white"></i></a>';
																				echo '</div></td>';

																				// Close the <TR> tag
																				echo '</tr>';

																				// Increment the counter
																				$attach_counter2++;
																				$attach_counter = $attach_counter2;
																			}

																			if ( $attach_counter2 == 0 )
																				$attach_counter = "";
																		}
																		else
																		{
																			// Open the <TR> tag
																			echo '<tr id="rowToCloneAnexo' . $attach_counter . '" name="rowToCloneAnexo">';

																			echo "<td style='text-align: center;'> - </td>";
																			echo "<td style='text-align: center;'> - </td>";

																			// Close the <TR> tag
																			echo '</tr>';
																		}

																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>

										<hr>
										
										<div class="row">
											<div class="col-sm-12">
												<div class="well">
													<h4>VALOR TOTAL DO CONTRATO: <strong>R$ <span id="spn_total_value"><?php if ( isset($contract_info["VALOR_TOTAL_CONTRATO"]) && $contract_info["VALOR_TOTAL_CONTRATO"] != "" ) echo $contract_info["VALOR_TOTAL_CONTRATO"]; else echo "0,00"; ?></span></strong></h4>
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