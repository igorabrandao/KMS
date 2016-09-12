<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>

	<ul class="stats not-on-phone">
		<li title="Usuários cadastrados">
			<strong><?php echo $modelo->get_users_count(); ?></strong>
			<small>Usuários cadastrados</small>
		</li>
		<li title="Aulas ministradas">
			<strong><?php echo $modelo->get_class_count(); ?></strong>
			<small>Aulas ministradas</small>
		</li>
		<li title="Professores">
			<strong><?php echo $modelo->get_sensei_count(); ?></strong>
			<small>Professores</small>
		</li>
		<li title="Alunos">
			<strong><?php echo $modelo->get_student_count(); ?></strong>
			<small>Alunos</small>
		</li>
		<li title="Última aula">
			<strong><?php 

				$last_class = $modelo->get_last_class(); 

				if ( strcmp($last_class, "") != 0 )
				{
					echo $last_class;
				}
				else
				{
					echo " - ";
				}
			
			?></strong>
			<small>Última aula</small>
		</li>
	</ul><!-- End of ul.stats -->

	<h1 class="grid_12 margin-top no-margin-top-phone">Página Inicial</h1>

	<div class="grid_12">
		<div class="box">
		
			<div class="header">
				<h2><img class="icon" src="<?php echo HOME_URI;?>/assets/img/icons/packs/fugue/16x16/chart-up-color.png">Comparativo de registro de alunos nos últimos 3 anos (<?php echo date("Y") - 2; ?> - <?php echo date("Y"); ?>)</h2>
			</div>
			
			<div class="content" style="height: 250px;">
				<table class=chart >
					<thead>
						<tr>
							<th></th>
							<th>Janeiro</th>
							<th>Fevereiro</th>
							<th>Março</th>
							<th>Abril</th>
							<th>Maio</th>
							<th>Junho</th>
							<th>Julho</th>
							<th>Agosto</th>
							<th>Setembro</th>
							<th>Outubro</th>
							<th>Novembbro</th>
							<th>Dezembro</th>
						</tr>
					</thead>
					<tbody>
						<?php  

							// Auxiliary variables
							$current_year = (date("Y") + 1);
							$elapsed_period = 3; // in years
							$initial_month = 1; // january
							$final_month = 12; // december

							// Run the total of years
							for ( $i = $elapsed_period; $i > 0; $i-- )
							{
								// Open the chart line
								echo "<tr>";
								echo "<th>Ano de " . ($current_year - $i ) . "</th>";

								// Run each month of the year
								for ( $j = $initial_month; $j <= $final_month; $j++ )
								{
									// Print the information in the line
									$period = $j . "-" . ($current_year - $i );
									$count = $modelo->get_users_count_by_period($period);
									echo "<td alt='" . $count . "' title='" . $count . "'>" . $count . "</td>";
								}

								// Close the chart line
								echo "</tr>";
							}

						?>

					</tbody>	
				</table>
			</div><!-- End of .content -->
			
		</div><!-- End of .box -->
	</div><!-- End of .grid_12 -->

</section><!-- End of #content -->
<!-- end: CONTENT -->