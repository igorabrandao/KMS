							<!-- start: PAGE TITLE -->
							<div class="page-header">
								<h1 title="Visualização da Contestação">Visualização da Contestação <small>PEC </small></h1>
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
						<div class="col-sm-4">
							<div class="core-box">
								<div class="heading">
									<i class="fa fa-dollar circle-icon circle-color1"></i>
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/contestacaocontratado_pec?idPEC=");?>" title="O que está sendo cobrado">O que está sendo cobrado</a></h2>
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
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/contestacaodetailreport_pec?idPEC=");?>" title="Detalhamento">Detalhamento</a></h2>
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
									<h2><a href="<?php echo encrypted_url($modelo->getIdPEC(), HOME_URI . "/modulo_pec/contestacaootherentries_pec?idPEC=");?>" title="Contrato">Outros lançamentos</a></h2>
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