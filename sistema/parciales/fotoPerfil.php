<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<form class="formulario-foto w3-quarter w3-center w3-white w3-leftbar" enctype="multipart/form-data" method="POST">
	<label for="foto" class="w3-display-container w3-hover-opacity">
		<i class="icon-camera w3-xxxlarge w3-display-middle"></i>
		<input type="file" name="foto" id="foto" class="w3-hide">
		<img class="image-result" src="<?=!empty($_SESSION['foto']) ? "../dist/images/perfil/{$_SESSION['foto']}" : "../dist/images/avatar2.png"?>">
	</label>
	<input type="submit" name="actualizarFoto" value="Actualizar" class="w3-button w3-blue w3-round-large w3-section w3-animate-right w3-hide">
	<span class="w3-medium w3-white w3-block"><?=$_SESSION["nombreUsuario"]?></span>
	<span class="w3-small w3-white w3-block w3-text-blue">@<?=$_SESSION["usuario"]?></span>
</form>