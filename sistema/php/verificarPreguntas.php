<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	if(!empty($indexActivo)):
		switch($_SESSION):
			case empty($_SESSION["pregunta1"]):
			case empty($_SESSION["pregunta2"]):
			case empty($_SESSION["pregunta3"]):
			case empty($_SESSION["respuesta1"]):
			case empty($_SESSION["respuesta2"]):
			case empty($_SESSION["respuesta3"]):
				$notificacion = "
					<script>
						Swal.fire({
							title: 'No tienes <br>\"preguntas y respuestas secretas\" registradas.',
							footer: '<a href=\"miPerfil.php\" class=\"w3-text-indigo\">CLICK AQUÍ</a>&nbsp;para registrarlas',
							icon: 'warning',
							toast: true,
							timer: 5000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
					</script>
				";
				break;
		endswitch;
	endif;
?>