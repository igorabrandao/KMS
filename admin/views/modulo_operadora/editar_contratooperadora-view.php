							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Cadastro Operadora">Contrato Operadora <small>cadastro </small></h1>
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

							// Load edit method
							$modelo->edit_contrato_operadora();
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
									<h2><i class="fa fa-pencil-square teal"></i> EDITAR CONTRATO</h2>
									<p>
										Preencha as informações do formulário abaixo para inserir um novo contrato.
									</p>
									<hr>
									<form action="#" role="form" id="frmCadContratoOperadora" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-12">
												<div class="errorHandler alert alert-danger no-display">
													<i class="fa fa-times-sign"></i> Alguns erros foram identificados. Por favor verifique o formulário.
												</div>
												<div class="successHandler alert alert-success no-display">
													<i class="fa fa-ok"></i> Preenchimento correto!
												</div>
											</div>
											<!-- FIRST STEP -->

											<input type="hidden" name="VALOR_TOTAL_CONTRATO" id="VALOR_TOTAL_CONTRATO" value="<?php if ( isset($contract_info["VALOR_TOTAL_CONTRATO"]) && $contract_info["VALOR_TOTAL_CONTRATO"] != "" ) echo $contract_info["VALOR_TOTAL_CONTRATO"]; else echo "0,00"; ?>"/>

											<div class="col-md-6">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="ID_TIPO_CONTRATO">
																Tipo de contrato <span class="symbol required"></span>
															</label>
															<select name="ID_TIPO_CONTRATO" id="ID_TIPO_CONTRATO" class="form-control search-select" >
																<option value="">Selecione...</option>
																<?php
																	// Contract type list
																	$lista = $modelo->get_contract_type();

																	foreach ( $lista as $value )
																	{
																		if ( $contract_info["ID_TIPO_CONTRATO"] == $value[0] )
																			echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
																		else
																			echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>														
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="N_CONTA">
																Número da conta
															</label>
															<input type="text" placeholder="Informe o número da conta" id="N_CONTA" name="N_CONTA" class="form-control" maxlength="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php echo iif($contract_info["N_CONTA"]); ?>">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label for="ID_EMPRESA">
																Empresa <span class="symbol required"></span>
															</label>
															<select name="ID_EMPRESA" id="ID_EMPRESA" class="form-control search-select" >
																<option value="">Selecione...</option>
																<?php 
																	// Company list
																	$lista = $modelo->get_company_list();

																	foreach ( $lista as $value )
																	{
																		if ( $contract_info["ID_EMPRESA"] == $value[0] )
																			echo "<option value='" . $value[0] . "' selected>(" . $value[1] . ") " . $value[2] . "</option>";
																		else
																			echo "<option value='" . $value[0] . "'>(" . $value[1] . ") " . $value[2] . "</option>";
																	}
																?>
															</select>															
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="ID_TIPO_SERVICO">
																Tipo de Serviço <span class="symbol required"></span>
															</label>
															<select name="ID_TIPO_SERVICO" id="ID_TIPO_SERVICO" class="form-control search-select" >
																<option value="">Selecione...</option>
																<?php 
																	// Lista os usuários
																	$lista = $modelo->get_service_type();

																	foreach ( $lista as $value )
																	{
																		if ( $contract_info["ID_TIPO_SERVICO"] == $value[0] )
																			echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
																		else
																			echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>													
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="ID_OPERADORA">
																Operadora <span class="symbol required"></span>
															</label>
															<select name="ID_OPERADORA" id="ID_OPERADORA" class="form-control search-select">
																<option value="">Selecione...</option>
																<?php 
																	// Carrier list
																	$lista = $modelo->get_operadora_list();

																	foreach ( $lista as $value )
																	{
																		if ( $contract_info["ID_OPERADORA"] == $value[0] )
																			echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
																		else
																			echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																	}
																?>
															</select>														
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="DATA_ASSINATURA">
																Data de assinatura do contrato <span class="symbol required"></span>
															</label>
															<input type="text" id="DATA_ASSINATURA" name="DATA_ASSINATURA" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" maxlength="10" value="<?php echo iif($contract_info["DATA_ASSINATURA"]);?>"/>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="DATA_ATIVACAO">
																Data de ativação do contrato
															</label>
															<input type="text" id="DATA_ATIVACAO" name="DATA_ATIVACAO" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" maxlength="10" value="<?php echo iif($contract_info["DATA_ATIVACAO"]);?>"/>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="CARENCIA">
																Vigência (em meses) <span class="symbol required"></span>
															</label>
															<input type="number" id="CARENCIA" name="CARENCIA" min="1" max="48" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php echo iif($contract_info["CARENCIA"]);?>"/>												
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
																		<th style="width: 14%; text-align: center;" title="QUANTIDADE DE APARELHOS">Qtd. Aparelhos</th>
																		<th style="width: 14%; text-align: center;" title="QUANTIDADE DE CHIPS">Qtd. Chips</th>
																		<th style="width: 14%; text-align: center;" title="Nº DE PARCELAS">Nº de parcelas</th>
																		<th style="width: 14%; text-align: center;" title="VALOR DA PARCELA">Valor da Parcela</th>
																		<th style="width: 14%; text-align: center;" title="VALOR TOTAL">Valor total</th>
																		<th style="width: 12%; text-align: center;"></th>
																	</tr>
																</thead>
																<tbody id="tableToModifyEquip">
																	<?php 
																		// Equipment list
																		$equip_lista = $modelo->load_contract_equipment($contract_id);
																		$equip_lista_ID = "";
																		$equip_counter = 0;
																		$equip_counter2 = 0;
																		
																		// Check if exist at least 1 register
																		if ( sizeof($equip_lista) > 0 )
																		{
																			foreach ( $equip_lista as $equip_value )
																			{
																				// Add the ID
																				$equip_lista_ID .= $equip_value["ID_CONTRATO_EQUIPAMENTO"] . "//";

																				if ( $equip_counter2 == 0 )
																					$equip_counter = "";

																				// Open the <TR> tag
																				echo '<tr id="rowToCloneEquip' . $equip_counter . '" name="rowToCloneEquip">';

																				// Negotiation type
																				echo '<td class="center"><div class="form-group">';
																				echo '<select id="ID_TIPO_NEGOCIACAO' . $equip_counter . '" name="ID_TIPO_NEGOCIACAO" class="form-control" onBlur="parseTableFields( \'elem_EQUIPAMENTOS\', \'table_Equip\' );">';
																				echo '<option value="">Selecione...</option>';

																					// Equipment negotiation type
																					$lista = $modelo->get_equip_negotiation_list();

																					foreach ( $lista as $value )
																					{
																						if ( $equip_value["ID_TIPO_NEGOCIACAO"] == $value[0] )
																							echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
																						else
																							echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																					}

																				echo '</select></div></td>';

																				// Device quantity
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="number" id="QTD_APARELHOS' . $equip_counter . '" name="QTD_APARELHOS" min="0" max="10000000" 
																					class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
																					onBlur="currencyOperation( document.getElementById(\'VALOR_PARCELA_EQUIP\'), document.getElementById(\'N_PARCELAS\'), \'\', \'\', \'*\', document.getElementsByName(\'VALOR_TOTAL_EQUIP\'), this ); 
																					parseTableFields( \'elem_EQUIPAMENTOS\', \'table_Equip\' );" 
																					onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddEquip\'), \'btnAddEquip\', \'rowToCloneEquip\', \'tableToModifyEquip\' );" value="' . iif($equip_value["QTD_APARELHOS"]) . '"/>';
																				echo '</div></td>';

																				// Chips quantity
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="number" id="QTD_CHIPS' . $equip_counter . '" name="QTD_CHIPS" min="0" max="10000000" class="form-control" 
																					onkeypress="return event.charCode >= 48 && event.charCode <= 57" onBlur="parseTableFields( \'elem_EQUIPAMENTOS\', \'table_Equip\' );" 
																					onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddEquip\'), \'btnAddEquip\', \'rowToCloneEquip\', \'tableToModifyEquip\' );" value="' . iif($equip_value["QTD_CHIPS"]) . '"/>';
																				echo '</div></td>';

																				// Installments number
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="number" id="N_PARCELAS' . $equip_counter . '" name="N_PARCELAS" min="0" max="48" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
																					onBlur="currencyOperation( this, document.getElementById(\'VALOR_PARCELA_EQUIP\'), \'\', \'\', \'*\', document.getElementsByName(\'VALOR_TOTAL_EQUIP\'), this ); 
																					parseTableFields( \'elem_EQUIPAMENTOS\', \'table_Equip\' );" 
																					onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddEquip\'), \'btnAddEquip\', \'rowToCloneEquip\', \'tableToModifyEquip\' );" value="' . iif($equip_value["N_PARCELAS"]) . '"/>';
																				echo '</div></td>';

																				// Installments value
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="text" id="VALOR_PARCELA_EQUIP' . $equip_counter . '" name="VALOR_PARCELA_EQUIP" class="form-control" maxlength="15" 
																					onBlur="currencyOperation( document.getElementById(\'N_PARCELAS\'), this, \'\', \'\', \'*\', document.getElementsByName(\'VALOR_TOTAL_EQUIP\'), this ); 
																					parseTableFields( \'elem_EQUIPAMENTOS\', \'table_Equip\' );" 
																					onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddEquip\'), \'btnAddEquip\', \'rowToCloneEquip\', \'tableToModifyEquip\' );" value="' . iif($equip_value["VALOR_PARCELA_EQUIP"]) . '"/>';
																				echo '</div></td>';

																				// Total value
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="text" id="VALOR_TOTAL_EQUIP' . $equip_counter . '" name="VALOR_TOTAL_EQUIP" class="form-control" maxlength="15" onBlur="parseTableFields( \'elem_EQUIPAMENTOS\', \'table_Equip\' );" 
																					onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddEquip\'), \'btnAddEquip\', \'rowToCloneEquip\', \'tableToModifyEquip\' );" value="' . real_currency( currency_operation( iif($equip_value["N_PARCELAS"]), iif($equip_value["VALOR_PARCELA_EQUIP"]), "*" ) ) . '" readonly="readonly"/>';
																				echo '</div></td>';

																				// Buttons
																				echo '<td class="center"><div class="visible-md visible-lg hidden-sm hidden-xs">';
																				echo '<a id="btnAddEquip" name="btnAddEquip" onclick="cloneRow( this, \'btnAddEquip\', \'rowToCloneEquip\', \'tableToModifyEquip\' ); addMaskMoney();" class="btn btn-xs btn-teal" title="Adicionar equipamento"><i class="fa fa-plus"></i></a>&nbsp;';
																				echo '<a id="btnRemoveEquip" name="btnRemoveEquip" onclick="deleteEquip( this );" class="btn btn-xs btn-bricky" title="Remover equipamento"><i class="fa fa-times fa fa-white"></i></a>';
																				echo '</div></td>';

																				// Close the <TR> tag
																				echo '</tr>';

																				// Increment the counter
																				$equip_counter2++;
																				$equip_counter = $equip_counter2;
																			}
																		}
																		else
																		{
																			?>
																				<tr id="rowToCloneEquip" name="rowToCloneEquip">
																					<td class="center">
																						<div class="form-group">
																							<select id="ID_TIPO_NEGOCIACAO" name="ID_TIPO_NEGOCIACAO" class="form-control" onBlur="parseTableFields( 'elem_EQUIPAMENTOS', 'table_Equip' );">
																								<option value="">Selecione...</option>
																								<?php 
																									// Equipment negotiation type
																									$lista = $modelo->get_equip_negotiation_list();

																									foreach ($lista as $value)
																									{
																										echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																									}
																								?>
																							</select>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<input type="number" id="QTD_APARELHOS" name="QTD_APARELHOS" min="0" max="10000000" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onBlur="currencyOperation( document.getElementById('VALOR_PARCELA_EQUIP'), document.getElementById('N_PARCELAS'), '', this, '*', document.getElementsByName('VALOR_TOTAL_EQUIP'), this ); parseTableFields( 'elem_EQUIPAMENTOS', 'table_Equip' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddEquip'), 'btnAddEquip', 'rowToCloneEquip', 'tableToModifyEquip' );"/>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<input type="number" id="QTD_CHIPS" name="QTD_CHIPS" min="0" max="10000000" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onBlur="parseTableFields( 'elem_EQUIPAMENTOS', 'table_Equip' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddEquip'), 'btnAddEquip', 'rowToCloneEquip', 'tableToModifyEquip' );"/>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<input type="number" id="N_PARCELAS" name="N_PARCELAS" min="0" max="48" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onBlur="currencyOperation( this, document.getElementById('VALOR_PARCELA_EQUIP'), '', document.getElementById('QTD_APARELHOS'), '*', document.getElementsByName('VALOR_TOTAL_EQUIP'), this ); parseTableFields( 'elem_EQUIPAMENTOS', 'table_Equip' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddEquip'), 'btnAddEquip', 'rowToCloneEquip', 'tableToModifyEquip' );"/>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<input type="text" id="VALOR_PARCELA_EQUIP" name="VALOR_PARCELA_EQUIP" class="form-control" maxlength="15" onBlur="currencyOperation( document.getElementById('N_PARCELAS'), this, '', document.getElementById('QTD_APARELHOS'), '*', document.getElementsByName('VALOR_TOTAL_EQUIP'), this ); parseTableFields( 'elem_EQUIPAMENTOS', 'table_Equip' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddEquip'), 'btnAddEquip', 'rowToCloneEquip', 'tableToModifyEquip' );"/>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<input type="text" id="VALOR_TOTAL_EQUIP" name="VALOR_TOTAL_EQUIP" class="form-control" maxlength="15" onBlur="parseTableFields( 'elem_EQUIPAMENTOS', 'table_Equip' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddEquip'), 'btnAddEquip', 'rowToCloneEquip', 'tableToModifyEquip' );" readonly="readonly"/>
																						</div>
																					</td>
																					<td class="center">
																						<div class="visible-md visible-lg hidden-sm hidden-xs">
																							<a id="btnAddEquip" name="btnAddEquip" onclick="cloneRow( this, 'btnAddEquip', 'rowToCloneEquip', 'tableToModifyEquip' ); addMaskMoney();" class="btn btn-xs btn-teal" title="Adicionar equipamento"><i class="fa fa-plus"></i></a>
																							<a id="btnRemoveEquip" name="btnRemoveEquip" onclick="deleteEquip( this );" class="btn btn-xs btn-bricky" title="Remover equipamento"><i class="fa fa-times fa fa-white"></i></a>
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
																	<th style="width: 10%; text-align: center;"></th>
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

																		// Check Plano Pronto disable elements
																		if ( $plan_value["ID_TIPO_PLANO"] == 3 ) //!< PLANO PRONTO
																			$readonly = "disabled='true'";
																		else
																			$readonly = "";

																		// Open the <TR> tag
																		echo '<tr id="rowToClonePlan' . $plan_counter . '" name="rowToClonePlan">';

																		// Plan type
																		echo '<td class="center"><div class="form-group">';
																		echo '<select name="ID_TIPO_PLANO" id="ID_TIPO_PLANO' . $plan_counter . '" class="form-control" onBlur="parseTableFields( \'elem_PLANOS\', \'table_Plan\' );" onChange="addPlanoPronto( this );">';
																		echo '<option value="">Selecione...</option>';

																			$lista = $modelo->get_plan_type_list();

																			foreach ( $lista as $value )
																			{
																				if ( $plan_value["ID_TIPO_PLANO"] == $value[0] )
																					echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
																				else
																					echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																			}

																		echo '</select></div></td>';

																		// Plan description
																		echo '<td class="center"><div class="form-group">';
																		echo '<input type="text" id="DESCRITIVO_PLANO' . $plan_counter . '" name="DESCRITIVO_PLANO" class="form-control" maxlength="100" 
																			onBlur="parseTableFields( \'elem_PLANOS\', \'table_Plan\' ); addPlan( this.name, \'ID_PLANO_CONTRATO\' ); addPlan( this.name, \'ID_PLANO_LINHA\' );" 
																			style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["DESCRITIVO_PLANO"]) . '"/>';
																		echo '</div></td>';

																		// Plan quantity
																		echo '<td class="center"><div class="form-group">';
																		echo '<input type="number" id="QUANTIDADE_PLANO' . $plan_counter . '" name="QUANTIDADE_PLANO" min="0" max="10000000" class="form-control" 
																			onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
																			onBlur="currencyOperation( this, document.getElementById(\'VALOR_ASSINATURA_PLANO\'), document.getElementById(\'VALOR_PAC_MIN\'), document.getElementById(\'DESCONTO_PLANO\'), \'*\', document.getElementsByName(\'VALOR_TOTAL_PLANO\'), this );
																			parseTableFields( \'elem_PLANOS\', \'table_Plan\' );" 
																			onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["QUANTIDADE_PLANO"]) . '"/>';
																		echo '</div></td>';

																		// Plan value
																		echo '<td class="center"><div class="form-group">';
																		echo '<input type="text" id="VALOR_ASSINATURA_PLANO' . $plan_counter . '" name="VALOR_ASSINATURA_PLANO" class="form-control" maxlength="15" 
																			onBlur="currencyOperation( document.getElementById(\'QUANTIDADE_PLANO\'), this, document.getElementById(\'VALOR_PAC_MIN\'), document.getElementById(\'DESCONTO_PLANO\'), \'*\', document.getElementsByName(\'VALOR_TOTAL_PLANO\'), this ); 
																			parseTableFields( \'elem_PLANOS\', \'table_Plan\' );" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["VALOR_ASSINATURA_PLANO"]) . '"/>';
																		echo '</div></td>';

																		// Voice package
																		echo '<td class="center" style="display: none;"><div class="form-group">';
																		echo '<input ' . $readonly . ' type="text" id="DESCRITIVO_PACOTE_VOZ' . $plan_counter . '" name="DESCRITIVO_PACOTE_VOZ" class="form-control" maxlength="100" 
																			onBlur="parseTableFields( \'elem_PLANOS\', \'table_Plan\' );" 
																			style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["DESCRITIVO_PACOTE_VOZ"]) . '"/>';
																		echo '</div></td>';

																		// Local tax
																		echo '<td class="center"><div class="form-group">';
																		echo '<input ' . $readonly . ' type="text" id="TARIFA_LOCAL' . $plan_counter . '" name="TARIFA_LOCAL" class="form-control" maxlength="15" 
																			onBlur="currencyOperation( this, document.getElementById(\'MINUTOS\'), \'\', \'\', \'*\', document.getElementsByName(\'VALOR_PAC_MIN\'), this );
																			currencyOperation( \'\', this, document.getElementById(\'MINUTOS\'), document.getElementById(\'VALOR_PAC_MIN\'), \'*\', document.getElementsByName(\'VALOR_TOTAL_PLANO\'), this );
																			parseTableFields( \'elem_PLANOS\', \'table_Plan\' );" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["TARIFA_LOCAL"]) . '"/>';
																		echo '</div></td>';

																		// Volume
																		echo '<td class="center"><div class="form-group">';
																		echo '<input type="text" id="VOLUME_PLANO" name="VOLUME_PLANO" class="form-control" maxlength="20" 
																			onBlur="parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );" style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["VOLUME_PLANO"]) . '"/>';
																		echo '</div></td>';
																		

																		// Minutes
																		echo '<td class="center"><div class="form-group">';
																		echo '<input ' . $readonly . ' type="text" id="MINUTOS' . $plan_counter . '" name="MINUTOS" class="form-control" maxlength="10" 
																			onBlur="currencyOperation( this, document.getElementById(\'TARIFA_LOCAL\'), \'\', \'\', \'*\', document.getElementsByName(\'VALOR_PAC_MIN\'), this );
																			currencyOperation( \'\', document.getElementById(\'TARIFA_LOCAL\'), this, document.getElementById(\'VALOR_PAC_MIN\'), \'*\', document.getElementsByName(\'VALOR_TOTAL_PLANO\'), this );
																			parseTableFields( \'elem_PLANOS\', \'table_Plan\' );" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["MINUTOS"]) . '"/>';
																		echo '</div></td>';

																		// Minutes package value
																		echo '<td class="center"><div class="form-group">';
																		echo '<input ' . $readonly . ' type="text" id="VALOR_PAC_MIN' . $plan_counter . '" name="VALOR_PAC_MIN" class="form-control" maxlength="15" 
																			onBlur="currencyOperation( this, document.getElementById(\'TARIFA_LOCAL\'), \'\', \'\', \'minutes\', document.getElementsByName(\'MINUTOS\'), this ); 
																			currencyOperation( \'\', document.getElementById(\'TARIFA_LOCAL\'), document.getElementById(\'MINUTOS\'), this, \'*\', document.getElementsByName(\'VALOR_TOTAL_PLANO\'), this );
																			currencyOperation( document.getElementById(\'QUANTIDADE_PLANO\'), document.getElementById(\'VALOR_ASSINATURA_PLANO\'), this, document.getElementById(\'DESCONTO_PLANO\'), \'*\', document.getElementsByName(\'VALOR_TOTAL_PLANO\'), this ); 
																			parseTableFields( \'elem_PLANOS\', \'table_Plan\' );" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["VALOR_PAC_MIN"]) . '"/>';
																		echo '</div></td>';

																		// Plan discount
																		echo '<td class="center"><div class="form-group">';
																		echo '<input type="text" id="DESCONTO_PLANO' . $plan_counter . '" name="DESCONTO_PLANO" class="form-control" maxlength="15" 
																			onBlur="currencyOperation( document.getElementById(\'QUANTIDADE_PLANO\'), document.getElementById(\'VALOR_ASSINATURA_PLANO\'), document.getElementById(\'VALOR_PAC_MIN\'), this, \'-\', document.getElementsByName(\'VALOR_TOTAL_PLANO\'), this ); 
																			parseTableFields( \'elem_PLANOS\', \'table_Plan\' );" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );"
																			value="' . iif($plan_value["DESCONTO_PLANO"]) . '"/>';
																		echo '</div></td>';

																		// Calculates the total value
																		$total_value = real_currency( currency_operation( iif($plan_value["QUANTIDADE_PLANO"]), iif($plan_value["VALOR_ASSINATURA_PLANO"]), "*" ) );
																		$total_value = real_currency( currency_operation( $total_value, iif($plan_value["VALOR_PAC_MIN"]), "+" ) );
																		$total_value = real_currency( currency_operation( $total_value, iif($plan_value["DESCONTO_PLANO"]), "-" ) );

																		// Plan total value
																		echo '<td class="center"><div class="form-group">';
																		echo '<input type="text" id="VALOR_TOTAL_PLANO' . $plan_counter . '" name="VALOR_TOTAL_PLANO" class="form-control" maxlength="15" 
																			onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddPlan\'), \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' );" readonly="readonly"
																			value="' . $total_value . '"/>';
																		echo '</div></td>';

																		// Buttons
																		echo '<td class="center"><div class="visible-md visible-lg hidden-sm hidden-xs">';
																		echo '<a id="btnAddPlan" name="btnAddPlan" onclick="cloneRow( this, \'btnAddPlan\', \'rowToClonePlan\', \'tableToModifyPlan\' ); addPlan( \'DESCRITIVO_PLANO\', \'ID_PLANO_CONTRATO\' ); addPlan( \'DESCRITIVO_PLANO\', \'ID_PLANO_LINHA\' ); addMaskMoney();" class="btn btn-xs btn-teal" title="Adicionar plano"><i class="fa fa-plus"></i></a>&nbsp;';
																		echo '<a id="btnRemovePlan" name="btnRemovePlan" onclick="deletePlan( this );" class="btn btn-xs btn-bricky" title="Remover plano"><i class="fa fa-times fa fa-white"></i></a>';
																		echo '</div></td>';

																		// Close the <TR> tag
																		echo '</tr>';
																		$print_plan++;

																		// Increment the counter
																		$plan_counter2++;
																		$plan_counter = $plan_counter2;
																	}

																	if ( $print_plan == 0 )
																	{
																		?>
																			<tr id="rowToClonePlan" name="rowToClonePlan">
																				<td>
																					<div class="form-group">
																						<select name="ID_TIPO_PLANO" id="ID_TIPO_PLANO" class="form-control" onBlur="parseTableFields( 'elem_PLANOS', 'table_Plan' );" onChange="addPlanoPronto( this );">
																							<option value="">Selecione...</option>
																							<?php
																								// Equipment plan type
																								$lista = $modelo->get_plan_type_list();

																								foreach ($lista as $value)
																								{
																									echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																								}
																							?>
																						</select>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="DESCRITIVO_PLANO" name="DESCRITIVO_PLANO" class="form-control" maxlength="100" onBlur="parseTableFields( 'elem_PLANOS', 'table_Plan' ); addPlan( this.name, 'ID_PLANO_CONTRATO' ); addPlan( this.name, 'ID_PLANO_LINHA' );" style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="number" id="QUANTIDADE_PLANO" name="QUANTIDADE_PLANO" min="0" max="10000000" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onBlur="currencyOperation( this, document.getElementById('VALOR_ASSINATURA_PLANO'), document.getElementById('VALOR_PAC_MIN'), document.getElementById('DESCONTO_PLANO'), '*', document.getElementsByName('VALOR_TOTAL_PLANO'), this ); parseTableFields( 'elem_PLANOS', 'table_Plan' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="VALOR_ASSINATURA_PLANO" name="VALOR_ASSINATURA_PLANO" class="form-control" maxlength="15" onBlur="currencyOperation( document.getElementById('QUANTIDADE_PLANO'), this, document.getElementById('VALOR_PAC_MIN'), document.getElementById('DESCONTO_PLANO'), '*', document.getElementsByName('VALOR_TOTAL_PLANO'), this ); parseTableFields( 'elem_PLANOS', 'table_Plan' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="DESCRITIVO_PACOTE_VOZ" name="DESCRITIVO_PACOTE_VOZ" class="form-control" maxlength="100" onBlur="parseTableFields( 'elem_PLANOS', 'table_Plan' );" style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="TARIFA_LOCAL" name="TARIFA_LOCAL" class="form-control" maxlength="15" onBlur="currencyOperation( this, document.getElementById('MINUTOS'), '', '', '*', document.getElementsByName('VALOR_PAC_MIN'), this ); currencyOperation( '', this, document.getElementById('MINUTOS'), document.getElementById('VALOR_PAC_MIN'), '*', document.getElementsByName('VALOR_TOTAL_PLANO'), this ); parseTableFields( 'elem_PLANOS', 'table_Plan' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="VOLUME_PLANO" name="VOLUME_PLANO" class="form-control" maxlength="20" onBlur="parseTableFields( 'elem_MODULOS', 'table_Modulo' );" style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById('btnAddModulo'), 'btnAddModulo', 'rowToCloneModulo', 'tableToModifyModulo' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="MINUTOS" name="MINUTOS" class="form-control" maxlength="10" onBlur="currencyOperation( this, document.getElementById('TARIFA_LOCAL'), '', '', '*', document.getElementsByName('VALOR_PAC_MIN'), this ); currencyOperation( '', document.getElementById('TARIFA_LOCAL'), this, document.getElementById('VALOR_PAC_MIN'), '*', document.getElementsByName('VALOR_TOTAL_PLANO'), this ); parseTableFields( 'elem_PLANOS', 'table_Plan' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="VALOR_PAC_MIN" name="VALOR_PAC_MIN" class="form-control" maxlength="15" onBlur="currencyOperation( this, document.getElementById('TARIFA_LOCAL'), '', '', 'minutes', document.getElementsByName('MINUTOS'), this ); currencyOperation( document.getElementById('QUANTIDADE_PLANO'), document.getElementById('VALOR_ASSINATURA_PLANO'), this, document.getElementById('DESCONTO_PLANO'), '*', document.getElementsByName('VALOR_TOTAL_PLANO'), this ); currencyOperation( '', document.getElementById('TARIFA_LOCAL'), document.getElementById('MINUTOS'), this, '*', document.getElementsByName('VALOR_TOTAL_PLANO'), this ); parseTableFields( 'elem_PLANOS', 'table_Plan' ); parseTableFields( 'elem_PLANOS', 'table_Plan' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="DESCONTO_PLANO" name="DESCONTO_PLANO" class="form-control" maxlength="15" onBlur="currencyOperation( document.getElementById('QUANTIDADE_PLANO'), document.getElementById('VALOR_ASSINATURA_PLANO'), document.getElementById('VALOR_PAC_MIN'), this, '-', document.getElementsByName('VALOR_TOTAL_PLANO'), this ); parseTableFields( 'elem_PLANOS', 'table_Plan' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="form-group">
																						<input type="text" id="VALOR_TOTAL_PLANO" name="VALOR_TOTAL_PLANO" class="form-control" maxlength="15" onkeydown="addRowEnterTab( event, document.getElementById('btnAddPlan'), 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' );" readonly="readonly"/>
																					</div>
																				</td>
																				<td class="center">
																					<div class="visible-md visible-lg hidden-sm hidden-xs">
																						<a id="btnAddPlan" name="btnAddPlan" onclick="cloneRow( this, 'btnAddPlan', 'rowToClonePlan', 'tableToModifyPlan' ); addPlan( 'DESCRITIVO_PLANO', 'ID_PLANO_CONTRATO' ); addPlan( 'DESCRITIVO_PLANO', 'ID_PLANO_LINHA' ); addMaskMoney();" class="btn btn-xs btn-teal" title="Adicionar plano"><i class="fa fa-plus"></i></a>
																						<a id="btnRemovePlan" name="btnRemovePlan" onclick="deletePlan( this );" class="btn btn-xs btn-bricky" title="Remover plano"><i class="fa fa-times fa fa-white"></i></a>
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
																		<th style="width: 16%; text-align: center;" title="TIPO DO MÓDULO">Tipo</th>
																		<th style="width: 5%; text-align: center;" title="MÓDULO COMPARTILHADO">Compartilhado</th>
																		<th style="width: 13%; text-align: center;" title="DESCRIÇÃO DO MÓDULO">Descrição</th>
																		<th style="width: 7%; text-align: center;" title="QUANTIDADE">Quantidade</th>
																		<th style="width: 8%; text-align: center;" title="VOLUME">Volume</th>
																		<th style="width: 9%; text-align: center;" title="VALOR DA ASSINATURA">Assinatura</th>
																		<th style="width: 9%; text-align: center;" title="DESCONTO">Desconto</th>
																		<th style="width: 10%; text-align: center;" title="VALOR TOTAL">Valor Total</th>
																		<th style="width: 10%; text-align: center;"></th>
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

																		// Check if exist at least 1 register
																		if ( sizeof($module_lista) > 0 )
																		{
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
																				echo '<td class="center"><div class="form-group">';
																				echo '<select name="ID_PLANO_CONTRATO" id="ID_PLANO_CONTRATO' . $module_counter . '" class="form-control" onBlur="parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );">';
																				echo '<option value="">Selecione...</option>';

																					// Plan reference list
																					$lista = $modelo->get_plan_list($contract_id);

																					foreach ( $lista as $value )
																					{
																						if ( $module_value["ID_PLANO_CONTRATO"] == $value[0] )
																							echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
																						else
																							echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																					}

																				echo '</select></div></td>';

																				// Module type
																				echo '<td class="center"><div class="form-group">';
																				echo '<select id="ID_TIPO_MODULO' . $module_counter . '" name="ID_TIPO_MODULO" class="form-control" onBlur="parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );">';
																				echo '<option value="">Selecione...</option>';

																					// Module type list
																					$lista = $modelo->get_module_type_list();

																					foreach ( $lista as $value )
																					{
																						if ( $module_value["ID_TIPO_MODULO"] == $value[0] )
																							echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
																						else
																							echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																					}

																				echo '</select></div></td>';

																				// Shared module check
																				echo '<td class="center">';

																				if ( $module_value["IS_COMPARTILHADO"] == 1 )
																					echo '<input checked type="checkbox" title="Módulo compartilhado?" style="height: 20px; width: 20px;" id="IS_COMPARTILHADO' . $module_counter . '" name="IS_COMPARTILHADO" onChange="parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );">';
																				else
																					echo '<input type="checkbox" title="Módulo compartilhado?" style="height: 20px; width: 20px;" id="IS_COMPARTILHADO' . $module_counter . '" name="IS_COMPARTILHADO" onChange="parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );">';
																				echo '</td>';

																				// Module description
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="text" id="DESCRITIVO_MODULO" name="DESCRITIVO_MODULO" class="form-control" maxlength="100" onBlur="parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );" 
																					style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddModulo\'), \'btnAddModulo\', \'rowToCloneModulo\', \'tableToModifyModulo\' );"
																					value="' . iif($module_value["DESCRITIVO_MODULO"]) . '"/>';
																				echo '</div></td>';

																				// Module quantity
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="number" id="QUANTIDADE_MODULO" name="QUANTIDADE_MODULO" min="0" max="10000000" class="form-control" 
																					onkeypress="return event.charCode >= 48 && event.charCode <= 57" onBlur="currencyOperation( this, document.getElementById(\'VALOR_ASSINATURA_MODULO\'), document.getElementById(\'DESCONTO_MODULO\'), \'\', \'-\', document.getElementsByName(\'VALOR_TOTAL_MODULO\'), this ); 
																					parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddModulo\'), \'btnAddModulo\', \'rowToCloneModulo\', \'tableToModifyModulo\' );"
																					value="' . iif($module_value["QUANTIDADE_MODULO"]) . '"/>';
																				echo '</div></td>';

																				// Module volume
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="text" id="VOLUME" name="VOLUME" class="form-control" maxlength="20" onBlur="parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );" 
																					style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddModulo\'), \'btnAddModulo\', \'rowToCloneModulo\', \'tableToModifyModulo\' );"
																					value="' . iif($module_value["VOLUME_MODULO"]) . '"/>';
																				echo '</div></td>';

																				// Module value
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="text" id="VALOR_ASSINATURA_MODULO" name="VALOR_ASSINATURA_MODULO" class="form-control" maxlength="15" 
																					onBlur="currencyOperation( document.getElementById(\'QUANTIDADE_MODULO\'), this, document.getElementById(\'DESCONTO_MODULO\'), \'\', \'-\', document.getElementsByName(\'VALOR_TOTAL_MODULO\'), this ); 
																					parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddModulo\'), \'btnAddModulo\', \'rowToCloneModulo\', \'tableToModifyModulo\' );"
																					value="' . iif($module_value["VALOR_ASSINATURA_MODULO"]) . '"/>';
																				echo '</div></td>';

																				// Module discount
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="text" id="DESCONTO_MODULO" name="DESCONTO_MODULO" class="form-control" maxlength="15" 
																					onBlur="currencyOperation( document.getElementById(\'QUANTIDADE_MODULO\'), document.getElementById(\'VALOR_ASSINATURA_MODULO\'), this, \'\', \'-\', document.getElementsByName(\'VALOR_TOTAL_MODULO\'), this ); 
																					parseTableFields( \'elem_MODULOS\', \'table_Modulo\' );" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddModulo\'), \'btnAddModulo\', \'rowToCloneModulo\', \'tableToModifyModulo\' );"
																					value="' . iif($module_value["DESCONTO_MODULO"]) . '"/>';
																				echo '</div></td>';

																				// Calculates the total value
																				$total_value = real_currency( currency_operation( iif($module_value["QUANTIDADE_MODULO"]), iif($module_value["VALOR_ASSINATURA_MODULO"]), "*" ) );
																				$total_value = real_currency( currency_operation( $total_value, iif($module_value["DESCONTO_MODULO"]), "-" ) );

																				// Module total value
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="text" id="VALOR_TOTAL_MODULO" name="VALOR_TOTAL_MODULO" class="form-control" maxlength="15" readonly="readonly" 
																					onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddModulo\'), \'btnAddModulo\', \'rowToCloneModulo\', \'tableToModifyModulo\' );"
																					value="' . $total_value . '"/>';
																				echo '</div></td>';

																				// Buttons
																				echo '<td class="center"><div class="visible-md visible-lg hidden-sm hidden-xs">';
																				echo '<a id="btnAddModulo" name="btnAddModulo" onclick="cloneRow( this, \'btnAddModulo\', \'rowToCloneModulo\', \'tableToModifyModulo\' ); addMaskMoney();" class="btn btn-xs btn-teal" title="Adicionar módulo"><i class="fa fa-plus"></i></a> &nbsp;';
																				echo '<a id="btnRemoveModulo" name="btnRemoveModulo" onclick="deleteModule( this );" class="btn btn-xs btn-bricky" title="Remover módulo"><i class="fa fa-times fa fa-white"></i></a>';
																				echo '</div></td>';

																				// Close the <TR> tag
																				echo '</tr>';

																				// Increment the counter
																				$module_counter2++;
																				$module_counter = $module_counter2;
																			}
																		}
																		else
																		{
																			?>
																				<tr id="rowToCloneModulo" name="rowToCloneModulo">
																					<td class="center">
																						<div class="form-group">
																							<select name="ID_PLANO_CONTRATO" id="ID_PLANO_CONTRATO" class="form-control" onBlur="parseTableFields( 'elem_MODULOS', 'table_Modulo' );">
																								<option value="">Selecione...</option>
																							</select>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<select id="ID_TIPO_MODULO" name="ID_TIPO_MODULO" class="form-control" onBlur="parseTableFields( 'elem_MODULOS', 'table_Modulo' );">
																								<option value="">Selecione...</option>
																								<?php
																									// Get module type list
																									$lista = $modelo->get_module_type_list();

																									foreach ($lista as $value)
																									{
																										echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																									}
																								?>
																							</select>
																						</div>
																					</td>
																					<td class="center">
																						<input type='checkbox' title="Módulo compartilhado?" style="height: 20px; width: 20px;" id='IS_COMPARTILHADO' name='IS_COMPARTILHADO' onChange="parseTableFields( 'elem_MODULOS', 'table_Modulo' );">
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<div class="form-group">
																								<input type="text" id="DESCRITIVO_MODULO" name="DESCRITIVO_MODULO" class="form-control" maxlength="100" onBlur="parseTableFields( 'elem_MODULOS', 'table_Modulo' );" style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById('btnAddModulo'), 'btnAddModulo', 'rowToCloneModulo', 'tableToModifyModulo' );"/>
																							</div>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<div class="form-group">
																								<input type="number" id="QUANTIDADE_MODULO" name="QUANTIDADE_MODULO" min="0" max="10000000" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onBlur="currencyOperation( this, document.getElementById('VALOR_ASSINATURA_MODULO'), document.getElementById('DESCONTO_MODULO'), '', '-', document.getElementsByName('VALOR_TOTAL_MODULO'), this ); parseTableFields( 'elem_MODULOS', 'table_Modulo' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddModulo'), 'btnAddModulo', 'rowToCloneModulo', 'tableToModifyModulo' );"/>
																							</div>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<div class="form-group">
																								<input type="text" id="VOLUME" name="VOLUME" class="form-control" maxlength="20" onBlur="parseTableFields( 'elem_MODULOS', 'table_Modulo' );" style="text-transform: uppercase" onkeydown="addRowEnterTab( event, document.getElementById('btnAddModulo'), 'btnAddModulo', 'rowToCloneModulo', 'tableToModifyModulo' );"/>
																							</div>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<div class="form-group">
																								<input type="text" id="VALOR_ASSINATURA_MODULO" name="VALOR_ASSINATURA_MODULO" class="form-control" maxlength="15" onBlur="currencyOperation( document.getElementById('QUANTIDADE_MODULO'), this, document.getElementById('DESCONTO_MODULO'), '', '-', document.getElementsByName('VALOR_TOTAL_MODULO'), this ); parseTableFields( 'elem_MODULOS', 'table_Modulo' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddModulo'), 'btnAddModulo', 'rowToCloneModulo', 'tableToModifyModulo' );"/>
																							</div>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<div class="form-group">
																								<input type="text" id="DESCONTO_MODULO" name="DESCONTO_MODULO" class="form-control" maxlength="15" onBlur="currencyOperation( document.getElementById('QUANTIDADE_MODULO'), document.getElementById('VALOR_ASSINATURA_MODULO'), this, '', '-', document.getElementsByName('VALOR_TOTAL_MODULO'), this ); parseTableFields( 'elem_MODULOS', 'table_Modulo' );" onkeydown="addRowEnterTab( event, document.getElementById('btnAddModulo'), 'btnAddModulo', 'rowToCloneModulo', 'tableToModifyModulo' );"/>
																							</div>
																						</div>
																					</td>
																					<td class="center">
																						<div class="form-group">
																							<div class="form-group">
																								<input type="text" id="VALOR_TOTAL_MODULO" name="VALOR_TOTAL_MODULO" class="form-control" maxlength="15" readonly="readonly" onkeydown="addRowEnterTab( event, document.getElementById('btnAddModulo'), 'btnAddModulo', 'rowToCloneModulo', 'tableToModifyModulo' );"/>
																							</div>
																						</div>
																					</td>
																					<td class="center">
																						<div class="visible-md visible-lg hidden-sm hidden-xs">
																							<a id="btnAddModulo" name="btnAddModulo" onclick="cloneRow( this, 'btnAddModulo', 'rowToCloneModulo', 'tableToModifyModulo' ); addMaskMoney();" class="btn btn-xs btn-teal" title="Adicionar módulo"><i class="fa fa-plus"></i></a>
																							<a id="btnRemoveModulo" name="btnRemoveModulo" onclick="deleteModule( this );" class="btn btn-xs btn-bricky" title="Remover módulo"><i class="fa fa-times fa fa-white"></i></a>
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
													<div class="col-md-6">
														<label for="form-field-mask-2">
															Quantidade de linhas
														</label>
														<div class="table-responsive">
															<table id="table_DDD" class="table table-striped table-bordered table-hover">
																<thead>
																	<tr>
																		<th style="width: 30%; text-align: center;" title="REFERÊNCIA DO PLANO">Plano</th>
																		<th style="width: 20%; text-align: center;" title="DDD">DDD</th>
																		<th style="width: 30%; text-align: center;" title="QUANTIDADE">Quantidade</th>
																		<th style="width: 20%; text-align: center;"></th>
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
																				echo '<td class="center"><div class="form-group">';
																				echo '<select name="ID_PLANO_CONTRATO" id="ID_PLANO_CONTRATO' . $DDD_counter . '" class="form-control" onBlur="parseTableFields( \'elem_QTDLINHAS\', \'table_DDD\' );">';
																				echo '<option value="">Selecione...</option>';

																					// Plan reference list
																					$lista = $modelo->get_plan_list($contract_id);

																					foreach ( $lista as $value )
																					{
																						if ( $DDD_value["ID_PLANO_LINHA"] == $value[0] )
																							echo "<option value='" . $value[0] . "' selected>" . $value[1] . "</option>";
																						else
																							echo "<option value='" . $value[0] . "'>" . $value[1] . "</option>";
																					}

																				echo '</select></div></td>';

																				// DDD
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="text" id="txt_DDD' . $DDD_counter . '" name="txt_DDD" class="form-control" onBlur="parseTableFields( \'elem_QTDLINHAS\', \'table_DDD\' );" 
																					onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="3" onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddDDD\'), \'btnAddDDD\', \'rowToCloneDDD\', \'tableToModifyDDD\' );"
																					value="' . iif($DDD_value["DDD"]) . '"/>';
																				echo '</div></td>';

																				// Quantity
																				echo '<td class="center"><div class="form-group">';
																				echo '<input type="number" id="txt_QTDLINHA' . $DDD_counter . '" name="txt_QTDLINHA" min="1" max="10000000" class="form-control" 
																					onBlur="parseTableFields( \'elem_QTDLINHAS\', \'table_DDD\' );" onkeypress="return event.charCode >= 48 && event.charCode <= 57;" 
																					onkeydown="addRowEnterTab( event, document.getElementById(\'btnAddDDD\'), \'btnAddDDD\', \'rowToCloneDDD\', \'tableToModifyDDD\' );"
																					value="' . iif($DDD_value["QTD_LINHA"]) . '"/>';
																				echo '</div></td>';

																				// Button
																				echo '<td class="center"><div class="form-group"><div class="visible-md visible-lg hidden-sm hidden-xs">';
																				echo '<a id="btnAddDDD" name="btnAddDDD" onclick="cloneRow( this, \'btnAddDDD\', \'rowToCloneDDD\', \'tableToModifyDDD\' );" class="btn btn-xs btn-teal" title="Adicionar DDD"><i class="fa fa-plus"></i></a> &nbsp;';
																				echo '<a id="btnRemoveDDD" name="btnRemoveDDD" onclick="deleteDDD( this );" class="btn btn-xs btn-bricky" title="Remover DDD"><i class="fa fa-times fa fa-white"></i></a>';
																				echo '</div></div></td>';

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
																	?>

																	<tr id="rowToCloneAnexo<?php echo $attach_counter; ?>" name="rowToCloneAnexo">
																		<td>
																			<div class="fileupload fileupload-new" data-provides="fileupload">
																				<div class="input-group">
																					<div class="form-control uneditable-input">
																						<i class="fa fa-file fileupload-exists"></i>
																						<span class="fileupload-preview"></span>
																					</div>
																					<div class="input-group-btn">
																						<div class="btn btn-light-grey btn-file">
																							<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Escolher arquivo</span>
																							<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Alterar</span>
																							<input type="file" class="file-input" id="file_anexo[]" name="file_anexo[]">
																						</div>
																						<a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
																							<i class="fa fa-times"></i> Remover
																						</a>
																					</div>
																				</div>
																			</div>
																		</td>
																		<td class="center">
																			<div class="visible-md visible-lg hidden-sm hidden-xs">
																				<a name="btnAddAnexo" onclick="cloneRow( this, 'btnAddAnexo', 'rowToCloneAnexo', 'tableToModifyAnexo' );" class="btn btn-xs btn-teal" title="Adicionar módulo"><i class="fa fa-plus"></i></a>
																				<a name="btnRemoveAnexo" onclick="deleteRow( this, 'btnRemoveAnexo', 'rowToCloneAnexo', 'tableToModifyAnexo' );" class="btn btn-xs btn-bricky" title="Remover módulo"><i class="fa fa-times fa fa-white"></i></a>
																			</div>
																		</td>
																	</tr>
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

										<hr>

										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-12">
														<div>
															<span class="symbol required"></span>Campo de preenchimento obrigatório
															<hr>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4">
														<button onclick="calculateTotalValue();" class="btn btn-blue btn-block" type="submit" title="Editar contrato Operadora">
															Atualizar contrato Operadora <i class="fa fa-arrow-circle-right"></i>
														</button>
													</div>
												</div>
												<input type="hidden" name="insere_contratoaires" value="1" />
											</div>
										</div>

										<input type="hidden" name="elem_QTDLINHAS" id="elem_QTDLINHAS" value=""/>
										<input type="hidden" name="elem_EQUIPAMENTOS" id="elem_EQUIPAMENTOS" value=""/>
										<input type="hidden" name="elem_PLANOS" id="elem_PLANOS" value=""/>
										<input type="hidden" name="elem_MODULOS" id="elem_MODULOS" value=""/>

										<input type="hidden" name="elem_QTDLINHASID" id="elem_QTDLINHASID" value="<?php echo iif($DDD_lista_ID);?>"/>
										<input type="hidden" name="elem_EQUIPAMENTOSID" id="elem_EQUIPAMENTOSID" value="<?php echo iif($equip_lista_ID);?>"/>
										<input type="hidden" name="elem_PLANOSID" id="elem_PLANOSID" value="<?php echo iif($plan_lista_ID);?>"/>
										<input type="hidden" name="elem_MODULOSID" id="elem_MODULOSID" value="<?php echo iif($module_lista_ID);?>"/>
										<input type="hidden" id="elem_ATTACHID" value="<?php echo iif($attach_lista_ID);?>"/>
										
										<input type="hidden" id="elem_DUMMY" value=""/>

										<input type="hidden" id="desc_plan" value="0"/>
										<input type="hidden" id="desc_module" value="1"/>
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

			var flag = 0;
			var flag_plano_pronto = 0;

			/** Function to clone a table row
			 * @param elem_ => element to validate row position
			 * @param btnAdd_ => element to determine position
			 * @param rowToClone_ => row to be cloned
			 * @param tableToModify_ => table do be modified
			*/
			function cloneRow( elem_, btnAdd_, rowToClone_, tableToModify_ )
			{
				var lista = document.getElementsByName(btnAdd_);
				var table;
				var new_row;
				var line_number;
				var input;

				for ( var i = 0; i < lista.length; i++ )
				{
					// Check which element called the function
					if ( lista[i] == elem_ )
					{
						// First row
						if ( lista.length == 1 )
							var row = document.getElementById(rowToClone_); // find row to copy
						else
							var row = document.getElementById(rowToClone_ + (lista.length - 1)); // find row to copy

						// Check if the line was found
						if ( row == null )
							row = document.getElementById(rowToClone_ + (lista.length - 2)); // fix row copy

						table = document.getElementById(tableToModify_); 	// find table to append to
						new_row = row.cloneNode(true); 						// copy children too
						new_row.id = szChar(new_row.id) + lista.length;		// change row ID
						line_number = table.rows.length; 					// number of lines

						/* Run through row columns */
						for ( var j = 0; j < (new_row.cells.length - 1); j++ )
						{
							//! Get the temporaly element
							input = new_row.cells[j].getElementsByTagName('input')[0];

							if ( input == null )
								input = new_row.cells[j].getElementsByTagName('select')[0];

							if ( input == null )
								input = new_row.cells[j].getElementsByTagName('checkbox')[0];

							if ( input != null && input.type == "checkbox" )
							{
								input.checked = false;
							}

							/*if ( input.type == "file" || input.type == "hidden" )
							{
								var btn_remove = document.getElementsByClassName("btn btn-light-grey fileupload-exists");
								alert(btn_remove[1]);
								btn_remove[0].click();
							}*/

							if ( input != null )
							{
								input.id = szChar(input.id) + line_number;		// change input ID
								input.value = "";
							}
						}

						table.appendChild(new_row); // add new row to end of table

						// Give the focus on next line
						if ( new_row.cells[0].getElementsByTagName('input')[0] != null )
							new_row.cells[0].getElementsByTagName('input')[0].focus();
						else if ( new_row.cells[0].getElementsByTagName('select')[0] != null )
							new_row.cells[0].getElementsByTagName('select')[0].focus();
						else if ( new_row.cells[0].getElementsByTagName('checkbox')[0] != null )
							new_row.cells[0].getElementsByTagName('checkbox')[0].focus();

						// Add the money mask
						addMaskMoney();
					}
				}
			}

			/** Function to remove a table row
			 * @param elem_ => element to validate row position
			 * @param btnRemove_ => element to determine position
			 * @param rowToClone_ => row to be cloned
			 * @param tableToModify_ => table do be modified
			*/
			function deleteRow( elem_, btnRemove_, rowToClone_, tableToModify_ )
			{
				var rowList = document.getElementsByName(btnRemove_);
				var rowClone = document.getElementsByName(rowToClone_);
				var min = 1;

				// Make sure that at least one field stay
				if ( rowList.length > min )
				{
					for ( var c = 0; c < rowList.length; c++ )
					{
						// Check which element called the function
						if ( rowList[c] == elem_ )
						{
							document.getElementById(tableToModify_).deleteRow(c);
						}

						// Rename all rows
						rowClone[0].id = rowToClone_;
						for ( var i = 1; i < rowClone.length; i++ )
						{
							rowClone[i].id = rowToClone_ + i;
						}
					}
				}
			}

			/** Function to remove a table row
			 * @param elem_ => element to receive the parse result
			 * @param tableToParse_ => ID table to be parsed
			*/
			function parseTableFields( elem_, tableToParse_ )
			{
				/* Get the HTML inputs */
				var tableToParse = document.getElementById( tableToParse_ );
				var field = document.getElementById( elem_ );

				/* Temporaly element */
				var t_elem;

				/* Clear the initial value */
				field.value = "";

				/* Run through table rows */
				for ( var i = 1; i < tableToParse.rows.length; i++ )
				{
					/* Run through table columns */
					for ( var j = 0; j < (tableToParse.rows[i].cells.length - 1); j++ )
					{
						//! Get the temporaly element
						t_elem = tableToParse.rows[i].cells[j].getElementsByTagName('input')[0];

						if ( t_elem == null )
							t_elem = tableToParse.rows[i].cells[j].getElementsByTagName('select')[0];

						if ( t_elem == null )
							t_elem = tableToParse.rows[i].cells[j].getElementsByTagName('checkbox')[0];

						//! Check if the element is a checkbox
						if ( t_elem.type == "checkbox" )
						{
							t_elem.value = t_elem.checked;
							t_elem.value = t_elem.value.replace("true", "1");
							t_elem.value = t_elem.value.replace("false", "0");
						}

						//! First line
						if ( i == 1 )
						{
							if ( j == (tableToParse.rows[i].cells.length - 2) )
								field.value += t_elem.value;
							else
								field.value += t_elem.value + "@@";
						}
						//! Other lines
						else
						{
							if ( j == 0)
								field.value += "//" + t_elem.value + "@@";
							else if ( j == (tableToParse.rows[i].cells.length - 2) )
								field.value += t_elem.value;
							else
								field.value += t_elem.value + "@@";
						}
					}
				}
			}

			/** Function to add dynamically a plan
			 * @param plan_elem_ => list of plans
			 * @param elem_ => select to receive the option
			*/
			function addPlan( plan_elem_, elem_ )
			{
				// Track the element itself
				var plans = document.getElementsByName(plan_elem_);
				var selects = document.getElementsByName(elem_);
				var option;
				var selected = new Array(selects.length);
				var status_delete = 0;

				// Run through all selects
				for ( var i = 0; i < selects.length; i++ )
				{
					selected[i] = selects[i].options[selects[i].selectedIndex].text;
					status_delete = 0;

					// Remove all options from current select element
					for ( k = 1; k < selects[i].options.length; k++ ) 
					{
						selects[i].innerHTML = "";
						status_delete = 1;
					}

					// Add the standard option
					if ( status_delete == 1 )
					{
						option = document.createElement("option");
						option.value = "";
						option.innerHTML = "Selecione...";
						selects[i].appendChild(option);
					}

					// Add new options to the select element
					for ( var j = 0; j < plans.length; j++ )
					{
						// Check if it's a valid plan
						if ( plans[j].value != "" )
						{
							// Create a dynamic option
							option = document.createElement("option");
							option.value = plans[j].value.toUpperCase();
							option.innerHTML = plans[j].value.toUpperCase();

							// Add the option to the element
							selects[i].appendChild(option);
						}
					}

					// Add the pre built plan
					if ( flag_plano_pronto == 1 )
					{
						option = document.createElement("option");
						option.value = "";
						option.innerHTML = "PLANO PRONTO";
						selects[i].appendChild(option);
					}

					// Check if it was the previous option selected (keep selection)
					for ( var k = 0; k < selects[i].options.length; k++ )
					{
						if ( selected[i].toLowerCase() == selects[i].options[k].text.toLowerCase() )
						{
							selects[i].selectedIndex = k;
						}
					}
				}
			}

			/** Function to simulate enter or tab click
			 * @param e_ => event handler
			 * @param elem_ => element to validate row position
			 * @param btnAdd_ => element to determine position
			 * @param rowToClone_ => row to be cloned
			 * @param tableToModify_ => table do be modified
			*/
			function addRowEnterTab( e_, elem_, btnAdd_, rowToClone_, tableToModify_ )
			{
				var e = event || e_; // for trans-browser compatibility
				var charCode = e.which || e.keyCode;

				/**
				 * KeyCode 13 -> Enter
				 * KeyCode 9 -> Tab
				*/
				if ( charCode == 13 )
				{
					cloneRow(elem_, btnAdd_, rowToClone_, tableToModify_);
				}
			}

			/** Function to execute an operation related to any row
			 * @param a_ => element that contains the first value
			 * @param b_ => element that contains the second value
			 * @param c_ => element that contains the third value
			 * @param d_ => element that contains the fourth value
			 * @param op_ => the operation itself
			 * @param elem_ => element to receive the result
			 * @param elem_row_ref_ => element to give the row reference
			*/
			function currencyOperation( a_, b_, c_, d_, op_, elem_, elem_row_ref_ )
			{
				var opA = document.getElementsByName(a_.name);
				var opB = document.getElementsByName(b_.name);
				var opC = document.getElementsByName(c_.name);
				var opD = document.getElementsByName(d_.name);
				var elem_ref = document.getElementsByName(elem_row_ref_.name);

				for ( var i = 0; i < elem_ref.length; i++ )
				{
					// Minutes package
					if ( opA[i] == null && opB[i].value != "" && opC[i] != null && opD[i] != null )
					{
						if ( opC[i].value != "" && opD[i].value != "" && elem_[i].value == "" )
						{
							elem_[i].value = opD[i].value;
						}
					}
					// Check which element called the function
					else if ( elem_ref[i] == elem_row_ref_ )
					{
						// Specific case for plan discount
						if ( opA[i].value != "" && opB[i].value != "" && opC[i] != null && opD[i] != null )
						{
							var desc_total;
							elem_[i].value = 0;
							elem_[i].value = format_real(getMoney( currency_operations(opA[i].value, opB[i].value, "*") ));

							if ( opC[i].value != "" )
								elem_[i].value =  format_real(getMoney( currency_operations(elem_[i].value, opC[i].value, "+") ));

							if ( opD[i].value != "" )
							{
								desc_total =  format_real(getMoney( currency_operations(opA[i].value, opD[i].value, "*") ));
								elem_[i].value =  format_real(getMoney( currency_operations(elem_[i].value, desc_total, "-") ));
							}
						}
						// Specific case for equipment multiplication
						else if ( opA[i].value != "" && opB[i].value != "" && opC[i] == null && opD[i] != null )
						{
							elem_[i].value = 0;
							elem_[i].value =  format_real(getMoney( currency_operations(opA[i].value, opB[i].value, "*") ));
							if ( opD[i].value != "" )
								elem_[i].value =  format_real(getMoney( currency_operations(elem_[i].value, opD[i].value, "*") ));
						}
						// Specific case for module discount
						else if ( opA[i].value != "" && opB[i].value != "" && opC[i] != null )
						{
							var desc_total;
							elem_[i].value = 0;
							elem_[i].value =  format_real(getMoney( currency_operations(opA[i].value, opB[i].value, "*") ));

							if ( opC[i].value != "" )
							{
								desc_total =  format_real(getMoney( currency_operations(opA[i].value, opC[i].value, "*") ));
								elem_[i].value =  format_real(getMoney( currency_operations(elem_[i].value, desc_total, "-") ));
							}
						}
						// Generic case
						else if ( opA[i].value != "" && opB[i].value != "" )
						{
							// Execute the operation
							if ( op_ != "minutes" )
								elem_[i].value =  format_real(getMoney( currency_operations(opA[i].value, opB[i].value, op_) ));
							else
								elem_[i].value = convertFloatMinutes(currency_operations(opA[i].value, opB[i].value, "/"));
						}
						// When the discount is empty
						else if ( opA[i].value != "" && opB[i].value == "" && opC[i].value != "" && opD[i].value != "" )
						{
							var desc_total;
							elem_[i].value = 0;

							if ( opC[i].value != "" )
								elem_[i].value =  format_real(getMoney( currency_operations(elem_[i].value, opC[i].value, "+") ));

							if ( opD[i].value != "" && opD[i].value != "R$0,00" )
							{
								desc_total =  format_real(getMoney( currency_operations(opA[i].value, opD[i].value, "*") ));
								elem_[i].value =  format_real(getMoney( currency_operations(elem_[i].value, desc_total, "-") ));
							}
						}
						// Invalid case
						else
						{
							// Clear the result field
							elem_[i].value = "";
						}

						// Update the total value
						calculateTotalValue();

						break;
					}
				}
			}

			/** Calculate the contract total value
			 *
			*/
			function calculateTotalValue()
			{
				var vl_equip_list = document.getElementsByName("VALOR_TOTAL_EQUIP");
				var vl_plan_list = document.getElementsByName("VALOR_TOTAL_PLANO");
				var vl_module_list = document.getElementsByName("VALOR_TOTAL_MODULO");
				var total_value = 0;

				// Equipments
				/*for ( var i = 0; i < vl_equip_list.length; i++ )
				{
					if ( vl_equip_list[i] != null && vl_equip_list[i].value != "" )
					{
						total_value = currency_operations(total_value, vl_equip_list[i].value, "+");
					}
				}*/

				// Plans
				for ( var i = 0; i < vl_plan_list.length; i++ )
				{
					if ( vl_plan_list[i] != null && vl_plan_list[i].value != "" )
					{
						total_value = currency_operations(total_value, vl_plan_list[i].value, "+");
					}
				}

				// Modules
				for ( var i = 0; i < vl_module_list.length; i++ )
				{
					if ( vl_module_list[i] != null && vl_module_list[i].value != "" )
					{
						total_value = currency_operations(total_value, vl_module_list[i].value, "+");
					}
				}

				// Update the reference field
				document.getElementById("spn_total_value").innerHTML = format_real(getMoney(total_value));
				document.getElementById("VALOR_TOTAL_CONTRATO").value = format_real(getMoney(total_value));
			}

			/** Function to update the ID list
			 * @param element_id_ => element to be updated
			 * @param position_ => position to remove
			 * @param divider_ => the string divider
			*/
			function parseIDList( element_id_, position_, divider_ )
			{
				var elem = document.getElementById(element_id_);
				var result = elem.value.split(divider_);
				var ID = 0;
				elem.value = "";

				for ( var i = 0; i < result.length; i++ )
				{
					if ( i != position_ )
						elem.value += result[i] + "//";
					else
						ID = parseInt(result[i]);
				}

				elem.value = elem.value.replace(divider_ + divider_, divider_);
				return ID;
			}

			/** Function to delete an equipment item
			 * @param element_ => element to be the position parameter in array of elements
			*/
			function deleteEquip( element_ )
			{
				var elem_ref = document.getElementsByName(element_.name);
				var ID = 0;

				for ( var i = 0; i < elem_ref.length; i++ )
				{
					// Check which element called the function
					if ( elem_ref[i] == element_ )
					{
						if ( confirm("Realmente deseja excluir o equipamento?") == true )
						{
							// Remove the table row
							deleteRow( elem_ref[i], "btnRemoveEquip", "rowToCloneEquip", "tableToModifyEquip" ); 

							// Update the parsed values
							parseTableFields( "elem_EQUIPAMENTOS", "table_Equip" );

							// Remove the ID in the list
							ID = parseIDList("elem_EQUIPAMENTOSID", i, "//");

							// Callback to delete the element
							sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/editar_contratooperadora', 'action=delete&item_type=equipment&item_ID=' + ID, 'POST', 
								'///', document.getElementById('elem_DUMMY'), 'delete' );
						}
						else
						{
							return false;
						}
					}
				}
			}

			/** Function to delete a plan item
			 * @param element_ => element to be the position parameter in array of elements
			*/
			function deletePlan( element_ )
			{
				var elem_ref = document.getElementsByName(element_.name);
				var ID = 0;

				for ( var i = 0; i < elem_ref.length; i++ )
				{
					// Check which element called the function
					if ( elem_ref[i] == element_ )
					{
						if ( confirm("Realmente deseja excluir este plano?") == true )
						{
							// Remove the table row
							deleteRow( elem_ref[i], "btnRemovePlan", "rowToClonePlan", "tableToModifyPlan" ); 

							// Update the reference plan select
							addPlan( "DESCRITIVO_PLANO", "ID_PLANO_CONTRATO" ); 
							addPlan( "DESCRITIVO_PLANO", "ID_PLANO_LINHA" ); 

							// Update the parsed values
							parseTableFields( "elem_PLANOS", "table_Plan" );

							// Remove the ID in the list
							ID = parseIDList("elem_PLANOSID", i, "//");

							// Callback to delete the element
							sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/editar_contratooperadora', 'action=delete&item_type=plan&item_ID=' + ID, 'POST', 
								'///', document.getElementById('elem_DUMMY'), 'delete' );
						}
						else
						{
							return false;
						}
					}
				}
			}

			/** Function to delete a module item
			 * @param element_ => element to be the position parameter in array of elements
			*/
			function deleteModule( element_ )
			{
				var elem_ref = document.getElementsByName(element_.name);
				var ID = 0;

				for ( var i = 0; i < elem_ref.length; i++ )
				{
					// Check which element called the function
					if ( elem_ref[i] == element_ )
					{
						if ( confirm("Realmente deseja excluir este módulo?") == true )
						{
							// Remove the table row
							deleteRow( elem_ref[i], "btnRemoveModulo", "rowToCloneModulo", "tableToModifyModulo" ); 

							// Update the parsed values
							parseTableFields( "elem_MODULOS", "table_Modulo" );

							// Remove the ID in the list
							ID = parseIDList("elem_MODULOSID", i, "//");

							// Callback to delete the element
							sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/editar_contratooperadora', 'action=delete&item_type=module&item_ID=' + ID, 'POST', 
								'///', document.getElementById('elem_DUMMY'), 'delete' );
						}
						else
						{
							return false;
						}
					}
				}
			}
			
			/** Function to delete a DDD item
			 * @param element_ => element to be the position parameter in array of elements
			*/
			function deleteDDD( element_ )
			{
				var elem_ref = document.getElementsByName(element_.name);
				var ID = 0;

				for ( var i = 0; i < elem_ref.length; i++ )
				{
					// Check which element called the function
					if ( elem_ref[i] == element_ )
					{
						if ( confirm("Realmente deseja excluir este DDD?") == true )
						{
							// Remove the table row
							deleteRow( elem_ref[i], "btnRemoveDDD", "rowToCloneDDD", "tableToModifyDDD" ); 

							// Update the parsed values
							parseTableFields( "elem_QTDLINHAS", "table_DDD" );

							// Remove the ID in the list
							ID = parseIDList("elem_QTDLINHASID", i, "//");

							// Callback to delete the element
							sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/editar_contratooperadora', 'action=delete&item_type=ddd&item_ID=' + ID, 'POST', 
								'///', document.getElementById('elem_DUMMY'), 'delete' );
						}
						else
						{
							return false;
						}
					}
				}
			}

			/** Function to delete a attachment item
			 * @param element_ => element to be the position parameter in array of elements
			*/
			function deleteAttach( element_ )
			{
				var elem_ref = document.getElementsByName(element_.name);
				var ID = 0;

				for ( var i = 0; i < elem_ref.length; i++ )
				{
					// Check which element called the function
					if ( elem_ref[i] == element_ )
					{
						if ( confirm("Realmente deseja excluir este anexo?") == true )
						{
							// Remove the table row
							deleteRow( elem_ref[i], "btnRemoveAnexo", "rowToCloneAnexo", "tableToModifyAnexo" ); 

							// Remove the ID in the list
							ID = parseIDList("elem_ATTACHID", i, "//");

							// Callback to delete the element
							sendRequest( '<?php echo HOME_URI;?>/modulo_operadora/editar_contratooperadora', 'action=delete&item_type=attach&item_ID=' + ID, 'POST', 
								'///', document.getElementById('elem_DUMMY'), 'delete' );
						}
						else
						{
							return false;
						}
					}
				}
			}

			/** Function to add dynamically a Pre Build Plan
			 * @param element_ => element to be the position parameter in array of elements
			*/
			function addPlanoPronto( element_ )
			{
				// Get the array of inputs
				var selects = document.getElementsByName(element_.name);
				var DESCRITIVO_PACOTE_VOZ = document.getElementsByName("DESCRITIVO_PACOTE_VOZ");
				var TARIFA_LOCAL = document.getElementsByName("TARIFA_LOCAL");
				var MINUTOS = document.getElementsByName("MINUTOS");
				var VALOR_PAC_MIN = document.getElementsByName("VALOR_PAC_MIN");

				for ( var i = 0; i < selects.length; i++ )
				{
					// Check which element called the function
					if ( selects[i] == element_ )
					{
						// Check if it's a Plano Pronto
						if ( selects[i].options[selects[i].selectedIndex].text == "PLANO PRONTO" )
						{
							// Disable the elements
							DESCRITIVO_PACOTE_VOZ[i].disabled = true;
							TARIFA_LOCAL[i].disabled = true;
							MINUTOS[i].disabled = true;
							VALOR_PAC_MIN[i].disabled = true;
						}
						else
						{
							// Enable the elements
							DESCRITIVO_PACOTE_VOZ[i].disabled = false;
							TARIFA_LOCAL[i].disabled = false;
							MINUTOS[i].disabled = false;
							VALOR_PAC_MIN[i].disabled = false;
						}
					}
				}
			}

		</script>