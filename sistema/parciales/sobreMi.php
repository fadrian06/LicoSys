<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<div class="w3-threequarter w3-margin-top w3-container w3-card w3-white w3-show" id="panelSobreMi">
	<h2 class="w3-large w3-padding w3-border-bottom"><span class="w3-text-blue">Sobre</span> mí</h2>
	<div class="w3-clear"></div>

	<!--============================================
	=            Información `Sobre Mi`            =
	=============================================-->
	<ul class="w3-ul w3-small w3-show" id="sobreMi">
		<li>
			<span class="w3-tag w3-blue w3-left">Cédula:</span>
			<b class="w3-right"><?=$_SESSION["idUsuario"]?></b>
			<div class="w3-clear"></div>
		</li>
		<li>
			<span class="w3-tag w3-blue w3-left">Nombre:</span>
			<b class="w3-right"><?=$_SESSION["nombreUsuario"]?></b>
			<div class="w3-clear"></div>
		</li>
		<li>
			<span class="w3-tag w3-blue w3-left">Usuario:</span>
			<b class="w3-right">@<?=$_SESSION["usuario"]?></b>
			<div class="w3-clear"></div>
		</li>
		<li>
			<span class="w3-tag w3-blue w3-left">Cargo:</span>
			<b class="w3-right"><?=$_SESSION["cargo"] == "a" ? "Administrador" : "Vendedor"?></b>
			<div class="w3-clear"></div>
		</li>
		<li>
			<span class="w3-tag w3-blue w3-left">Teléfono:</span>
			<b class="w3-right"><?=!empty($_SESSION["telefono"]) ? $_SESSION["telefono"] : "No establecido"?></b>
			<div class="w3-clear"></div>
		</li>
	</ul>

	<button class="w3-button w3-blue w3-section w3-round-large w3-show centrado" id="botonActualizar">Actualizar datos</button>
</div>