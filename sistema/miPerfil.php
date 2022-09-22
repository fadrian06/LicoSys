<?php require_once "parciales/head.php" ?>
<?php
	/*=======================================
	=            ACTUALIZACIONES            =
	=======================================*/
	require_once "php/actualizarFoto.php";
	require_once "php/actualizarPerfil.php";
	require_once "php/actualizarClave.php";
	require_once "php/actualizarPreguntas.php";

	/*===============================
	=            MODALES            =
	===============================*/
	require_once "parciales/perfilModales.php";
?>
<main class="w3-container w3-main w3-row" id="miPerfil">

	<!--===================================
	=            BARRA LATERAL            =
	====================================-->
	<div class="w3-col s3 m1 l1 w3-padding-24 w3-ul w3-center">
		<ul id="menuMiPerfil" class="w3-ul w3-card w3-white w3-tiny w3-center">
			<li class="w3-button w3-block w3-rightbar" id="botonSobre">
				<i class="icon-user w3-large"></i>
				<div>SOBRE MI</div>
			</li>
			<li class="w3-button w3-block w3-rightbar" id="botonSeguridad">
				<i class="icon-key w3-large"></i>
				<div id="textoSeguridad">SEGURIDAD</div>
			</li>
		</ul>
	</div>

	<!--=====================================
	=            PANEL PRINCIPAL            =
	======================================-->
	<div class="w3-rest">
		<?php require_once "parciales/sobreMi.php" ?>
		<?php require_once "parciales/seguridad.php" ?>
		<?php require_once "parciales/fotoPerfil.php" ?>
	</div>
</main>
<?php require_once "parciales/indexModales.php"?>
<?php require_once "parciales/footer.php" ?>