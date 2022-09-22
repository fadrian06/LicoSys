<?php require_once "partial/head.php" ?>
<?php
	if(isset($_POST["actualizarFoto"])):
		$cedula = (int) $_SESSION["idUsuario"];
		$foto        = $_FILES["foto"];
		$tipo        = $foto["type"];
		switch($tipo){
			case "image/jpeg":
			case "image/jpg":
			case "image/png":
				$cedula .= ".jpeg";
				break;
		}
		$peso        = $foto["size"];
		$dirTemporal = $foto["tmp_name"];
		if($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png"):
			if($peso < 1*1000*2048 /*2MB*/):
				if(ACTUALIZAR("UPDATE usuario SET foto='$cedula' WHERE usuario='$usuario'")):
					$_SESSION["foto"] = $cedula;
					move_uploaded_file($dirTemporal, "../imagenes/perfil/$cedula");
					$notificacion = "
						<script>
							Swal.fire({
								title: 'Foto actualizada exitosamente',
								icon: 'success',
								timer: 2000,
								toast: true,
								timerProgressBar: true,
								position: 'bottom-end',
								showConfirmButton: false
							})
							document.querySelector('#fotoPerfil').src = '../imagenes/perfil/" . $_SESSION["foto"] . "';
						</script>
					";
				endif;
			else:
				$notificacion = "
					<script>
						Swal.fire({
							title: 'La imagen no puede ser mayor a <b class=\"w3-text-red\" title=\"2 Megabytes\">2MB</b>',
							icon: 'error',
							timer: 5000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					Swal.fire({
						title: 'Sólo se permiten imagenes (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)',
						icon: 'error',
						timer: 3000,
						timerProgressBar: true,
						position: 'bottom-end',
						showConfirmButton: false
					})
				</script>
			";
		endif;
	endif;

	if(isset($_POST["actualizar"])):
		$cedula = (int) $_SESSION["idUsuario"];
		$nombre   = ESCAPAR_STRING($_POST["nombre"]);
		$usuario  = ESCAPAR_STRING($_POST["usuario"]);
		$telefono = !empty($_POST["telefono"]) ? ESCAPAR_STRING($_POST["telefono"]) : "";
		if(ACTUALIZAR("UPDATE usuario SET nom_u='$nombre', usuario='$usuario', tlf='$telefono' WHERE ci_u=$cedula")):
			$_SESSION["nombreUsuario"] = $nombre;
			$_SESSION["usuario"] = $usuario;
			$_SESSION["telefono"] = $telefono;
			$notificacion = "
				<script>
					Swal.fire({
						title: 'Actualización exitosa',
						icon: 'success',
						timer: 2000,
						timerProgressBar: true,
						showConfirmButton: false
					})
				</script>
			";
		endif;
	endif;

	if(isset($_POST["cambiarClave"])):
		$cedula      = (int) $_SESSION["idUsuario"];
		$claveActual = $_POST["clave"];
		$nuevaClave  = ESCAPAR_STRING($_POST["nuevaClave"]);
		$confirmar   = ESCAPAR_STRING($_POST["confirmar"]);
		if($claveActual != $_POST["nuevaClave"]):
			if($nuevaClave == $confirmar):
				$nuevaClave = ENCRIPTAR($nuevaClave);
				if(ACTUALIZAR("UPDATE usuario SET clave='$nuevaClave' WHERE ci_u=$cedula")):
					$_SESSION["clave"] = $nuevaClave;
					$notificacion = "
						<script>
							Swal.fire({
								title: 'Contraseña actualizada exitosamente',
								icon: 'success',
								timer: 2000,
								timerProgressBar: true,
								showConfirmButton: false
							})
						</script>
					";
				else:
					$notificacion = "
						<script>
							Swal.fire({
								title: 'Error al actualizar, intente nuevamente',
								icon: 'error',
								timer: 2000,
								timerProgressBar: true,
								showConfirmButton: false
							})
						</script>
					";
				endif;
			else:
				$notificacion = "
					<script>
						Swal.fire({
							title: 'Las contraseñas no coinciden',
							icon: 'error',
							toast: true,
							timer: 5000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					Swal.fire({
						title: 'La nueva contraseña no puede ser igual a la anterior',
						icon: 'error',
						toast: true,
						timer: 3000,
						timerProgressBar: true,
						position: 'bottom-end',
						showConfirmButton: false
					})
				</script>
			";
		endif;
	endif;

	if(isset($_POST["actualizarPreguntas"])):
		$cedula     = (int) $_SESSION["idUsuario"];
		$pregunta1  = ESCAPAR_STRING($_POST["pregunta1"]);
		$pregunta2  = ESCAPAR_STRING($_POST["pregunta2"]);
		$pregunta3  = ESCAPAR_STRING($_POST["pregunta3"]);
		$respuesta1 = ENCRIPTAR(ESCAPAR_STRING($_POST["respuesta1"]));
		$respuesta2 = ENCRIPTAR(ESCAPAR_STRING($_POST["respuesta2"]));
		$respuesta3 = ENCRIPTAR(ESCAPAR_STRING($_POST["respuesta3"]));
		if(ACTUALIZAR("UPDATE usuario SET pre1='$pregunta1', r1='$respuesta1', pre2='$pregunta2', r2='$respuesta2', pre3='$pregunta3', r3='$respuesta3' WHERE ci_u=$cedula")):
			$_SESSION["pregunta1"]  = $pregunta1;
			$_SESSION["pregunta2"]  = $pregunta2;
			$_SESSION["pregunta3"]  = $pregunta3;
			$_SESSION["respuesta1"] = $respuesta1;
			$_SESSION["respuesta2"] = $respuesta2;
			$_SESSION["respuesta3"] = $respuesta3;
			$notificacion = "
				<script>
					Swal.fire({
						title: 'Preguntas y respuestas actualizadas exitosamente',
						icon: 'success',
						timer: 2000,
						timerProgressBar: true,
						showConfirmButton: false
					})
				</script>
			";
		endif;
	endif;
?>
<!--===============================
=            MI PERFIL            =
================================-->
<main class="w3-container w3-main w3-row" id="miPerfil">

	<!--===================================
	=            BARRA LATERAL            =
	====================================-->
	<div class="w3-col s3 m1 l1 w3-padding-24 w3-ul w3-center">
		<ul id="menuMiPerfil" class="w3-ul w3-card w3-white w3-tiny w3-center">
			<li class="w3-button w3-block w3-rightbar" id="botonSobre">
				<i class="icon-user w3-large"></i>
				<div>SOBRE</div>
			</li>
			<li class="w3-button w3-block w3-rightbar" id="botonSeguridad">
				<i class="icon-key w3-large"></i>
				<div id="textoSeguridad">SEGURIDAD</div>
			</li>
		</ul>
	</div>
	<!--====  End of BARRA LATERAL  ====-->

	<!--=====================================
	=            PANEL PRINCIPAL            =
	======================================-->
	<div class="w3-rest">

		<!--======================================
		=            PANEL `SOBRE MI`            =
		=======================================-->
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

			<button class="w3-button w3-blue w3-section w3-round-large w3-show" id="botonActualizar">Actualizar datos</button>
			
			<!--==================================================
			=            Formulario `Actualizar info`            =
			===================================================-->
			<form action="" method="POST" class="w3-center w3-hide w3-small w3-padding-16" id="formulario-actualizar">
				<div class="w3-row w3-section">
					<label class="w3-third w3-padding">Cédula</label>
					<div class="w3-twothird w3-input"><span class="w3-left"><?=$_SESSION["idUsuario"]?></span></div>
				</div>
				<div class="w3-row w3-section">
					<label for="nombre" class="w3-third w3-padding">Nombre</label>
					<input type="text" name="nombre" class="w3-twothird w3-input" value="<?=$_SESSION["nombreUsuario"]?>" id="nombre">
				</div>
				<div class="w3-row w3-section">
					<label for="usuario" class="w3-third w3-padding">Usuario</label>
					<input type="text" name="usuario" class="w3-twothird w3-input" value="<?=$_SESSION["usuario"]?>" id="usuario">
				</div>
				<div class="w3-row w3-section">
					<label for="telefono" class="w3-third w3-padding">Teléfono</label>
					<input type="text" name="telefono" class="w3-twothird w3-input" value="<?=$_SESSION["telefono"]?>" id="telefono">
				</div>
				<input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-blue w3-round-large">
			</form>
		</div>
		<!--====  End of PANEL `SOBRE MI`  ====-->
		
		<!--=======================================
		=            PANEL `SEGURIDAD`            =
		========================================-->
		<div class="w3-threequarter w3-margin-top w3-container w3-card w3-white w3-hide" id="panelSeguridad">
			<h2 class="w3-large w3-padding w3-border-bottom w3-text-blue">Seguridad</h2>
			<div class="w3-clear"></div>
			<div class="w3-row">
				<!--==========================================
				=            SECCIÓN `CONTRASEÑA`            =
				===========================================-->
				<ul class="w3-half w3-ul w3-small w3-hide" id="infoClave">
					<li>
						<span class="w3-tag w3-indigo w3-left">Contraseña:</span>
						<b class="w3-right">**********</b>
						<div class="w3-clear"></div>
					</li>
					<button class="w3-hide w3-button w3-indigo w3-section w3-round-large" id="botonActualizarClave">Cambiar contraseña</button>
				</ul>

				<!--======================================================
				=            SECCIÓN `PREGUNTAS Y RESPUESTAS`            =
				=======================================================-->
				<ul class="w3-half w3-ul w3-small w3-border-left w3-hide" id="preguntas">
					<li>
						<span class="w3-tag w3-pale-blue w3-left">Pregunta #1:</span>
						<b class="w3-right"><?=!empty($_SESSION["pregunta1"]) ? $_SESSION["pregunta1"] . "?" : "<span class='w3-text-red'>No definida</span>"?></b>
						<div class="w3-clear"></div>
					</li>
					<li>
						<span class="w3-tag w3-blue w3-left">Respuesta #1:</span>
						<b class="w3-right"><?=!empty($_SESSION["respuesta1"]) ? "**********" : "<span class='w3-text-red'>No definida</span>"?></b>
						<div class="w3-clear"></div>
					</li>
					<br>
					<li>
						<span class="w3-tag w3-pale-blue w3-left">Pregunta #2:</span>
						<b class="w3-right"><?=!empty($_SESSION["pregunta2"]) ? $_SESSION["pregunta2"] . "?" : "<span class='w3-text-red'>No definida</span>"?></b>
						<div class="w3-clear"></div>
					</li>
					<li>
						<span class="w3-tag w3-blue w3-left">Respuesta #2:</span>
						<b class="w3-right"><?=!empty($_SESSION["respuesta2"]) ? "**********" : "<span class='w3-text-red'>No definida</span>"?></b>
						<div class="w3-clear"></div>
					</li>
					<br>
					<li>
						<span class="w3-tag w3-pale-blue w3-left">Pregunta #3:</span>
						<b class="w3-right"><?=!empty($_SESSION["pregunta3"]) ? $_SESSION["pregunta3"] . "?" : "<span class='w3-text-red'>No definida</span>"?></b>
						<div class="w3-clear"></div>
					</li>
					<li>
						<span class="w3-tag w3-blue w3-left">Respuesta #3:</span>
						<b class="w3-right"><?=!empty($_SESSION["respuesta3"]) ? "**********" : "<span class='w3-text-red'>No definida</span>"?></b>
						<div class="w3-clear"></div>
					</li>
					<button class="w3-button w3-blue w3-section w3-round-large w3-hide" id="botonActualizarPreguntas">Actualizar datos</button>
				</ul>
			</div>

			<!--=====================================================
			=            FORMULARIO `CAMBIAR CONTRASEÑA`            =
			======================================================-->
			<form action="" method="POST" class="w3-center w3-hide w3-small w3-padding-16" id="formulario-actualizar-clave">
				<div class="w3-row w3-section input">
					<label for="clave" class="w3-third w3-padding">Contraseña actual</label>
					<input type="password" name="clave" class="w3-twothird w3-input" id="clave">
					<div class="icono ver">
						<span class="icon-eye" id="ojo1" onclick="verClave(this.id, 'clave')"></span>
					</div>
				</div>
				<div class="w3-row w3-section input">
					<label for="nuevaClave" class="w3-third w3-padding">Nueva Contraseña</label>
					<input type="password" name="nuevaClave" class="w3-twothird w3-input" id="nuevaClave">
					<div class="icono ver">
						<span class="icon-eye" id="ojo2" onclick="verClave(this.id, 'nuevaClave')"></span>
					</div>
				</div>
				<div class="w3-row w3-section input">
					<label for="confirmar" class="w3-third w3-padding">Repetir Contraseña</label>
					<input type="password" name="confirmar" class="w3-twothird w3-input" id="confirmar">
					<div class="icono ver">
						<span class="icon-eye" id="ojo3" onclick="verClave(this.id, 'confirmar')"></span>
					</div>
				</div>
				<input type="submit" value="Actualizar" name="cambiarClave" class="w3-button w3-blue w3-round-large">
			</form>

			<!--=========================================================
			=            FORMULARIO `PREGUNTAS Y RESPUESTAS`            =
			==========================================================-->
			<form action="" method="POST" class="w3-center w3-hide w3-small w3-padding-16" id="formulario-actualizar-preguntas">
				<div class="w3-row w3-section">
					<label for="pregunta1" class="w3-third w3-padding">Pregunta #1</label>
					<input type="text" minlength="5" maxlength="30" name="pregunta1" class="w3-twothird w3-input" id="pregunta1" value="<?=!empty($_SESSION["pregunta1"]) ? $_SESSION["pregunta1"] : ""?>">
				</div>
				<div class="w3-row w3-section">
					<label for="respuesta1" class="w3-third w3-padding">Respuesta #1</label>
					<input type="text" minlength="5" maxlength="20" name="respuesta1" class="w3-twothird w3-input" id="respuesta1">
				</div>
				<div class="w3-row w3-section">
					<label for="pregunta2" class="w3-third w3-padding">Pregunta #2</label>
					<input type="text" minlength="5" maxlength="30" name="pregunta2" class="w3-twothird w3-input" id="pregunta2" value="<?=!empty($_SESSION["pregunta2"]) ? $_SESSION["pregunta2"] : ""?>">
				</div>
				<div class="w3-row w3-section">
					<label for="respuesta2" class="w3-third w3-padding">Respuesta #2</label>
					<input type="text" minlength="5" maxlength="20" name="respuesta2" class="w3-twothird w3-input" id="respuesta2">
				</div>
				<div class="w3-row w3-section">
					<label for="pregunta3" class="w3-third w3-padding">Pregunta #3</label>
					<input type="text" minlength="5" maxlength="30" name="pregunta3" class="w3-twothird w3-input" id="pregunta3" value="<?=!empty($_SESSION["pregunta3"]) ? $_SESSION["pregunta3"] : ""?>">
				</div>
				<div class="w3-row w3-section">
					<label for="respuesta3" class="w3-third w3-padding">Respuesta #3</label>
					<input type="text" minlength="5" maxlength="20" name="respuesta3" class="w3-twothird w3-input" id="respuesta3">
				</div>
				<input type="submit" value="Actualizar" name="actualizarPreguntas" class="w3-button w3-blue w3-round-large">
			</form>
		</div>
		<!--====  End of PANEL `SEGURIDAD`  ====-->
		
		<!--============================================
		=            PANEL `FOTO DE PERFIL`            =
		=============================================-->
		<form class="w3-quarter w3-center w3-white w3-leftbar" id="formulario-foto" enctype="multipart/form-data" action="" method="POST">
			<label for="foto" class="w3-display-container w3-hover-opacity" style="background:url() top/contain no-repeat" id="result-image">
				<i class="icon-camera w3-xxxlarge w3-display-middle"></i>
				<input type="file" name="foto" id="foto" class="w3-hide">
				<img src="<?=!empty($_SESSION["foto"]) ? "../imagenes/perfil/" . $_SESSION["foto"] : "../imagenes/avatar2.png"?>" id="img-result">
			</label>
			<input type="submit" name="actualizarFoto" value="Actualizar" class="w3-button w3-blue w3-round-large w3-section w3-animate-right w3-hide" id="submit">
			<span class="w3-xlarge w3-white w3-block"><?=$_SESSION["nombreUsuario"]?></span>
			<span class="w3-medium w3-white w3-block w3-text-blue">@<?=$_SESSION["usuario"]?></span>
		</form>
		<!--====  End of PANEL `FOTO DE PERFIL`  ====-->
	</div>
	<!--====  End of PANEL PRINCIPAL  ====-->
</main>
<!--====  End of MI PERFIL  ====-->
<?php require_once "partial/footer.php" ?>