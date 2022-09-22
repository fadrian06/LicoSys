<?php require_once "parciales/head.php" ?>
	<main class="w3-container w3-main w3-row" id="finanzas">
		<?php if($_SESSION["cargo"]=="a"):?>
		<?php else:
			$restringido = REDIRECCIONAR();
		endif?>
	</main>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php"; ?>