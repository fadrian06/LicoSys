<?php require_once "parciales/head.php" ?>
<?php
	$negocios = getRegistros("SELECT * FROM negocio");

	require_once "php/registrarNegocio.php";
	require_once "php/actualizarLogo.php";
	require_once "php/actualizarNegocio.php";
	require_once "php/activarDesactivar.php";
?>

	<main class="w3-container w3-main w3-row" id="negocios">
		<?php if($_SESSION["cargo"]=="a"):?>
				<?php require_once "parciales/botonesNegocios.php" ?>
				<?php require_once "parciales/panelesNegocios.php" ?>
				<?php require_once "parciales/formRegistrarNegocio.php" ?>
		<?php else: $restringido = REDIRECCIONAR(); endif ?>
	</main>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php"; ?>