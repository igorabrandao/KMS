							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Visualizador de Faturas">Visualizador de Faturas <small>arquivo </small></h1>
							</div>
							<!-- end: PAGE TITLE -->
						</div>
					</div>
					<!-- end: PAGE HEADER -->

					<?php
						// Check if PEC ID is valid
						$modelo->checkValidit_PEC();
					?>

					<!-- start: PAGE CONTENT -->
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-info">
								<?php
									// Get the info's
									$data_value = $modelo->getInfo_PEC( $modelo->getIdPEC() );
								
									// Run through the info's
									foreach ( $data_value as $value )
									{
										// Account number
										if ( $value["N_CONTA"] != "" )
											echo "<h5>Número da conta: " . $value["N_CONTA"] . "</h5>";

										// Consume center
										if ( $value["CENTRO_CUSTO"] != "" )
											echo "<h5>Centro de custo: " . $value["CENTRO_CUSTO"] . "</h5>";

										// Company name
										if ( $value["RAZAO_SOCIAL"] != "" )
											echo "<h5>Razão social: " . $value["RAZAO_SOCIAL"] . "</h5>";

										// Carrier
										if ( $value["NOME_OPERADORA"] != "" )
											echo "<h5>Operadora: " . $value["NOME_OPERADORA"] . "</h5>";

										// Reference month
										if ( $value["MES_REFERENCIA"] != "" )
											echo "<h5>Mês de referência: " . $value["MES_REFERENCIA"] . "</h5>";

										// Expire date
										if ( $value["DATA_VENCIMENTO"] != "" )
											echo "<h5>Data de vencimento: " . $value["DATA_VENCIMENTO"] . "</h5>";

										// PERIOD
										if ( $value["PERIODO"] != "" )
											echo "<h5>Período de referência: " . $value["PERIODO"] . "</h5>";
									}
								?>
							</div>
						</div>
					</div>

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
											<object name="invoice_view" type="text/html" data="<?php echo HOME_URI; ?>/assets/PDFjs/web/viewer.php?file=<?php echo HOME_URI . "/" . $value["ANEXO"]; ?>" style="width: 100%; height: 600px;"></object>
										</div>
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