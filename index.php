<?php require 'parciales/head.php' ?>

<div class="w3-overlay w3-animate-opacity w3-hide"></div>

<?php

	if ($negocios):
		if (isset($_SESSION['bienvenido'])):
			unset($_SESSION['bienvenido']);
			$alerta = <<<HTML
				<link rel="stylesheet" href="librerias/sweetalert2/borderless.min.css">
				<script src="js/loader.js"></script>
			HTML;
		elseif (file_exists('backup/licosys.sql')):
			$alerta = '<script src="js/restaurarBD.js"></script>';
		endif;
		
		$registrarNegocio = true;
		require 'parciales/registrarNegocio.html';
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