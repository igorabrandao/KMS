							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Visualização da PEC">Visualização da PEC <small>PEC </small></h1>
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

										// Attachment
										if ( $value["ANEXO"] != "" )
											echo "<table style='width: 140px;'><tr><td style='white-space: nowrap;'><h5>Anexo da fatura:</td><td><a target='_blank' href='" . encrypted_url($value["ID_PEC"], HOME_URI . "/modulo_geral/visualizarfatura?idPEC=") . "' title='Abrir fatura em anexo'>
												 <div class='icons'><div class='file-icon' data-type='pdf'></div></div></a></h5></td></tr></table>";
									}
								?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="fa fa-dollar circle-icon circle-color1"></i>
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/chargedreport_pec?idPEC=");?>" title="O que está sendo cobrado">O que está sendo cobrado</a></h2>
								</div>
								<div class="content">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
								</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="fa fa-search-plus circle-icon circle-color1"></i>
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/detailreport_pec?idPEC=");?>" title="Detalhamento">Detalhamento</a></h2>
								</div>
								<div class="content">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
								</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="fa fa-file-text-o circle-icon circle-color1"></i>
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/otherentriesreport_pec?idPEC=");?>" title="Contrato">Outros lançamentos</a></h2>
								</div>
								<div class="content">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
								</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="clip-user-4 circle-icon circle-color4"></i>
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/menu_contestacao_pec?idPEC=");?>" title="Contestação">Contestação</a></h2>
								</div>
								<div class="content">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
								</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="clip-user-4 circle-icon circle-color4"></i>
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/adequacyreport_pec?idPEC=");?>" title="Adequação">Adequação</a></h2>
								</div>
								<div class="content">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
								</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="clip-user-4 circle-icon circle-color4"></i>
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/incomesummaryreport_pec?idPEC=");?>" title="Consolidação da fatura">Consolidação da fatura</a></h2>
								</div>
								<div class="content">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
								</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="fa fa-bar-chart-o circle-icon circle-color1"></i>
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/menu_relatorio_pec?idPEC=");?>" title="Relatórios">Relatórios</a></h2>
								</div>
								<div class="content">
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
								</div>
								<a class="view-more" href="#">
									View More <i class="clip-arrow-right-2"></i>
								</a>
							</div>
						</div>
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->