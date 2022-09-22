<?php require "parciales/head.php" ?>

	<div class="w3-overlay w3-animate-opacity w3-hide"></div>

	<?php
		if(!$negocios):
			$registrarNegocio = true;
			require "parciales/formRegistroNegocio.php";
		elseif(!$admin):
			$registrarAdmin = true;
			require "parciales/formRegistroAdmin.php";
		else:
			require "parciales/login.php";
			require "parciales/formConsulta.php";

			if(isset($mostrarPreguntas)):
				require "parciales/formPreguntas.php";
			endif;

			if(isset($cambiarClave)):
				require "parciales/formCambiarClave.php";
			endif;
		endif;
	?>

<?php require "parciales/footer.php" ?>