<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<!--======================================
=            ACTUALIZAR INFO             =
=======================================-->
<form method="POST" class="w3-margin-top formularioModal w3-padding-16 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formPerfil">
	<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
	<h3 class="swal2-title">Actualizar Datos</h3>
	<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-id-card-o"></span>
			</div>
			<input readonly type="number" name="cedula" placeholder="Cédula" minlength="7" maxlength="8" autocomplete="off" required pattern="^[^e]?[\d]{7,8}$" title="Un número entre 7 y 8 dígitos" value="<?=$_SESSION["idUsuario"]?>">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="text" name="nombre" placeholder="Nombre" required minlength="4" maxlength="20" autocomplete="off" autocapitalize pattern="^[a-zA-Z]{4,20}$" title="Sólo se permiten entre 4 y 20 letras sin espacios" value="<?=$_SESSION["nombreUsuario"]?>">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-user-circle-o"></span>
			</div>
			<input type="text" name="usuario" placeholder="@usuario" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w-]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números o guiones(-)" value="<?=$_SESSION["usuario"]?>">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="text" name="telefono" placeholder="Teléfono (opcional)" maxlength="13" pattern="^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}" title="Ejemplo (+58 416-111-2222 o 0416-111-2222)" value="<?=$_SESSION["telefono"]?>">
		</div>
	</section>
	<input class="centrado w3-button w3-round-xlarge w3-blue" type="submit" value="Actualizar" name="actualizarPerfil">
</form>

<!--===================================
=            CAMBIAR CLAVE            =
====================================-->
<form method="POST" class="w3-margin-top formularioModal w3-padding-16 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formClave">
	<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
	<h3 class="swal2-title">Cambiar contraseña</h3>
	<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-lock"></span>
			</div>
			<input type="password" name="nuevaClave" placeholder="Nueva contraseña" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)">
			<div class="icono ver">
				<span class="icon-eye"></span>
			</div>
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-key"></span>
			</div>
			<input type="password" name="confirmar" placeholder="Repetir contraseña" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w.-@#/*]{4,20}" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)">
			<div class="icono ver">
				<span class="icon-eye"></span>
			</div>
		</div>
	</section>
	<div class="submit w3-margin-top w3-container">
		<input class="centrado w3-button w3-round-xlarge w3-blue" type="submit" value="Cambiar" name="actualizarClave">
	</div>
</form>

<!--============================================
=            PREGUNTAS Y RESPUESTAS            =
=============================================-->
<form method="POST" class="w3-margin-top formularioModal w3-padding-16 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formPreguntas">
	<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
	<h3 class="swal2-title">Registro de <small class="w3-block">Preguntas y Respuestas</small></h3>
	<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="text" name="pregunta1" placeholder="Pregunta" required maxlength="30" autocomplete="off" pattern="^[\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\s]+$" title="Sólo se permiten hasta 30 letras y símbolos (¿ ?)" value="<?=$_SESSION["pregunta1"]?>">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-key"></span>
			</div>
			<input type="text" name="respuesta1" placeholder="Respuesta" autocomplete="off" minlength="1" maxlength="20" required pattern="^[a-zA-ZÁéÉíÍóÓúÚñÑ0-9]{1,20}$" title="Sólo se permiten letras y números" value="<?=$_POST["respuesta1"] ?? ""?>">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="text" name="pregunta2" placeholder="Pregunta" required maxlength="30" autocomplete="off" pattern="^[\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\s]+$" title="Sólo se permiten hasta 30 letras y símbolos (¿ ?)" value="<?=$_SESSION["pregunta2"]?>">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-key"></span>
			</div>
			<input type="text" name="respuesta2" placeholder="Respuesta" autocomplete="off" minlength="1" maxlength="20" required pattern="^[a-zA-ZÁéÉíÍóÓúÚñÑ0-9]{1,20}$" title="Sólo se permiten letras y números" value="<?=$_POST["respuesta2"] ?? ""?>">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-edit"></span>
			</div>
			<input type="text" name="pregunta3" placeholder="Pregunta" required maxlength="30" autocomplete="off" pattern="^[\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\s]+$" title="Sólo se permiten hasta 30 letras y símbolos (¿ ?)" value="<?=$_SESSION["pregunta3"]?>">
		</div>
	</section>
	<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
		<div class="input">
			<div class="icono">
				<span class="icon-key"></span>
			</div>
			<input type="text" name="respuesta3" placeholder="Respuesta" autocomplete="off" minlength="1" maxlength="20" required pattern="^[a-zA-ZÁéÉíÍóÓúÚñÑ0-9]{1,20}$" title="Sólo se permiten letras y números" value="<?=$_POST["respuesta3"] ?? ""?>">
		</div>
	</section>
	<div class="submit w3-margin-top w3-container">
		<input class="centrado w3-button w3-round-xlarge w3-blue" type="submit" value="Cambiar" name="actualizarPreguntas">
	</div>
</form>