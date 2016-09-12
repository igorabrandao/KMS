		</div><!-- End of #main -->

		<!-- start: FOOTER -->
		<footer class="container_12">
			<ul class="grid_6">
				<li><a href="#">Sobre a AKC</a></li>
				<li><a href="#">Sobre o KMS</a></li>
				<li><a href="#">Fale conosco</a></li>
			</ul>

			<span class="grid_6">
				<?php echo date("Y"); ?> &copy; <strong>Associação Karate Cidadão</strong> desenvolvido por AKC.
			</span>
		</footer><!-- End of footer -->

		<!-- Spawn $$.loaded -->
		<script>
			$$.loaded();
		</script>

		<!-- end: FOOTER -->

	</body>
	<!-- end: BODY -->

	<?php

		if ( isset($_GET["q"]) && strcmp($_GET["q"], "") != 0 )
		{
			echo "<gcse:search></gcse:search>";
		}

	?>

</html>