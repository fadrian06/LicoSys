<?php require 'parciales/head.php' ?>

<div class="w3-overlay w3-animate-opacity w3-hide"></div>

<?php

	if (!$negocios):
		if (file_exists('backup/licosys.sql'))
			$alerta = '<script src="js/restaurarBD.js"></script>';
		else
			$alerta = <<<HTML
				<link rel="stylesheet" href="librerias/sweetalert2/borderless.min.css">
				<script src="js/loader.js"></script>
			HTML;
		$registrarNegocio = true;
		require 'parciales/formRegistroNegocio.php';
	elseif (!$admin):
		$registrarAdmin = true;
		require 'parciales/formRegistroAdmin.php';
	else:
		require 'parciales/login.php';
		require 'parciales/formConsulta.php';

		if (isset($mostrarPreguntas))
			require 'parciales/formPreguntas.php';

		if (isset($cambiarClave))
			require 'parciales/formCambiarClave.php';

	endif;

	require 'parciales/footer.php'
	
?>