							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Coleta de Aparelhos">Coleta de Aparelhos <small>gestão </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Load insert method
						$modelo->garbage_device();
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
									<form action="#" role="form" id="frmColetaAparelho" action="" method="POST" class="form-box register-form contact-form" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-12 space20">
												<button class="btn btn-blue add-row" onClick="getAllCheckBoxes('frmColetaAparelho', 'chk_coleta');">
													Coletar aparelho(s) selecionado(s)
												</button>
												<input type="hidden" name="coleta_aparelho" value="1" />
												<input type="hidden" id="IMEI" name="IMEI" value="1" />
											</div>
										</div>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<thead>
													<tr>
														<th class="center">
															<input id="chk_select" type="checkbox" class="" onClick="setAllCheckBoxes('frmColetaAparelho', 'chk_coleta');" />
														</th>
														<th>IMEI</th>
														<th>Lote</th>
														<th>Contrato</th>
														<th>Marca</th>
														<th>Modelo</th>
														<th>Tipo de dispositivo</th>
														<th>Status</th>
														<th>Data de coleta</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														// List devices
														$lista = $modelo->get_device_list();

														foreach ($lista as $value)
														{
															// Construct table body
															echo "<tr><td class='center'><div class='checkbox-table'><label><input type='checkbox' class='grey' 
																  name='chk_coleta'></label></div></td>";

															/* INFO'S */
															// echo "<td>" . $value[0] . "</td>"; // ID
															echo "<td>" . $value[1] . " <input type='hidden' name='elem_IMEI' value='" . $value[1] . "' /></td>"; // IMEI
															echo "<td>" . $value[2] . "</td>"; // LOTE
															echo "<td>" . $value[3] . "</td>"; // CONTRACT NUMBER
															echo "<td>" . $value[4] . "</td>"; // DEVICE BRAND
															echo "<td>" . $value[5] . "</td>"; // MODEL
															echo "<td>" . $value[6] . "</td>"; // DEVICE TYPE

															// STATUS
															if ( $value[7] == "Inativo" )
																echo "<td class='hidden-xs'><span class='label label-sm label-danger'>" . $value[7] . "</span></td>";
															else if ( $value[7] == "Uso" )
																echo "<td class='hidden-xs'><span class='label label-sm label-success'>" . $value[7] . "</span></td>";
															else
																echo "<td class='hidden-xs'><span class='label label-sm label-warning'>" . $value[7] . "</span></td>";

															echo "<td>" . $value[8] . "</td>"; // GARBAGE DATA

															// Line break
															echo "</tr>";
														}
													?>
												</tbody>
											</table>
										</div>
									</form>
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

			//addEvent();
		
			var flag_selected = true;

			/** Function to clone a table TD
			 * @param formName => indicates the form name
			 * @param fieldName => indicates the field to be changed
			*/
			function setAllCheckBoxes( formName, fieldName )
			{
				/* Get the array of checkboxes */
				var objCheckBoxes = document.forms[formName].elements[fieldName];
				var countCheckBoxes = objCheckBoxes.length;

				/* Check if exist at least one element */
				if( !objCheckBoxes )
				{
					return;
				}
				else
				{
					// set the check value for all check boxes
					for ( var i = 0; i < countCheckBoxes; i++ )
					{
						/* Get the div element above from checkbox[i] */
						var div_check = objCheckBoxes[i].parentNode
						objCheckBoxes[i].checked = flag_selected;

						/* Change CSS dynamically */
						if ( flag_selected == true )
							div_check.className = div_check.className + " checked";
						else
							div_check.className = div_check.className.replace("checked", "");
					}
				}

				/* Invert flag value */
				if ( flag_selected == true )
					flag_selected = false;
				else
					flag_selected = true;
			}
			
			/** Function to get all IMEI that'll be colected
			 * @param formName => indicates the form name				
			 * @param fieldName => indicates the field to be changed
			*/
			function getAllCheckBoxes( formName, fieldName )
			{
				/* Get the array of checkboxes */
				var objCheckBoxes = document.forms[formName].elements[fieldName];
				var countCheckBoxes = objCheckBoxes.length;
				var objIMEI = document.getElementsByName("elem_IMEI");
				var hid_IMEI = document.getElementById("IMEI");
				var selecionados = 0;
				hid_IMEI.value = "";

				/* Check if exist at least one element */
				if( !objCheckBoxes )
				{
					return;
				}
				else
				{
					// get all IMEI checked
					for ( var i = 0; i < countCheckBoxes; i++ )
					{
						/* Check if it's checked */
						if ( objCheckBoxes[i].checked == true )
						{
							if ( hid_IMEI.value == "" )
								hid_IMEI.value = objIMEI[i].value;
							else
								hid_IMEI.value += "//" + objIMEI[i].value;
							selecionados += 1;
						}
					}

					// Submit form
					if ( selecionados > 0 )
						$('#' + formName).unbind().submit();
					else
						alert("Selecione ao menos um aparelho para coleta");
				}
			}

		</script>