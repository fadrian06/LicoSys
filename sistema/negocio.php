<?php require_once "parciales/head.php" ?>
<?php
	$negocios = getRegistros("SELECT * FROM negocio");

	require_once "php/registrarNegocio.php";
	require_once "php/actualizarLogo.php";
	require_once "php/actualizarNegocio.php";
	require_once "php/activarDesactivar.php";
?>

	<main class="w3-container w3-main w3-row" id="negocios">
		<?php if($_SESSION["cargo"] === "a"): ?>
				<?php require_once "parciales/botonesNegocios.php" ?>
				<?php require_once "parciales/panelesNegocios.php" ?>
				<?php require_once "parciales/formRegistrarNegocio.php" ?>
				<div class="w3-bottom" style="width: max-content; height: max-content">
					<button id="boton-restaurar" class="w3-button w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black w3-round-xlarge">
						<i class="icon-upload w3-xlarge"></i><br>Restaurar Datos
					</button>
					<button id="boton-respaldar" class="w3-button w3-right w3-margin w3-blue w3-hover-blue w3-hover-text-black w3-round-xlarge">
						<i class="icon-download w3-xlarge"></i><br>Respaldar Datos
					</button>
				</div>
		<?php else: $restringido = REDIRECCIONAR(); endif ?>
	</main>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php"; ?>