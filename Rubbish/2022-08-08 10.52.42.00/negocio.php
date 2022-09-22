<?php require_once "partial/head.php" ?>
<?php
	$negocios = CONSULTA("SELECT * FROM negocio");

	if(isset($_POST["actualizarFoto"])):
		$idNegocio = (int) $_POST["id"];
		$foto   = $_FILES["foto"];
		$tipo   = $foto["type"];
		switch($tipo){
			case "image/jpeg":
			case "image/jpg":
			case "image/png":
				$imagen = "$idNegocio.jpeg";
				break;
		}
		$peso = $foto["size"];
		$dirTemporal = $foto["tmp_name"];
		if($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png"):
			if($peso < 1*1000*2048 /*2MB*/):
				if(ACTUALIZAR("UPDATE negocio SET foto='$imagen' WHERE id_n=$idNegocio")):
					move_uploaded_file($dirTemporal, "../imagenes/negocios/$imagen");
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
							document.querySelector(#foto$idNegocio).src = '../imagenes/negocios/$imagen';
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

<!--=========================================
=            CONFIGURAR NEGOCIOS            =
==========================================-->
<main class="w3-container w3-main w3-row" id="negocios">
	<?php if($_SESSION["cargo"]=="a"):?>
			<!--===================================
			=            BARRA LATERAL            =
			====================================-->
			<div class="w3-col s3 m3 l3 w3-padding-24 w3-ul w3-center">
				<ul id="menuNegocios" class="w3-ul w3-card w3-white w3-tiny w3-center">
					<?php foreach($negocios as $negocio): ?>
						<li class="w3-button w3-block w3-rightbar" id="botonNegocio<?=$negocio["id_n"]?>">
							<i class="icon-building w3-large"></i>
							<div><?=$negocio["nom_n"]?></div>
						</li>
					<?php endforeach; ?>
				</ul>
				<button class="w3-button w3-card w3-blue w3-circle w3-margin-top w3-padding-16" id="botonAgregarNegocio">
					<i class="icon-plus w3-large"></i>
					<b class="w3-small w3-block">Nuevo</b>
				</button>
			</div>
			<!--====  End of BARRA LATERAL  ====-->

			<!--=====================================
			=            PANEL PRINCIPAL            =
			======================================-->
			<div class="w3-rest">

				<?php foreach($negocios as $negocio): ?>
					<!--==================================================
					=                   PANEL `NEGOCIO`                  =
					===================================================-->
					<div class="w3-threequarter w3-margin-top w3-container w3-card w3-white w3-show" id="panelInfoNegocio<?=$negocio["id_n"]?>">
						<h2 class="w3-large w3-padding w3-border-bottom"><span class="w3-text-blue">Información</span></h2>
						<div class="w3-clear"></div>

						<!--============================================
						=            Información `Negocio`             =
						=============================================-->
						<ul class="w3-ul w3-small w3-show" id="infoNegocio<?=$negocio["id_n"]?>">
							<li>
								<span class="w3-tag w3-blue w3-left">Identificador:</span>
								<b class="w3-right"><?=$negocio["id_n"]?></b>
								<div class="w3-clear"></div>
							</li>
							<li>
								<span class="w3-tag w3-blue w3-left">Nombre:</span>
								<b class="w3-right"><?=$negocio["nom_n"]?></b>
								<div class="w3-clear"></div>
							</li>
							<li>
								<span class="w3-tag w3-blue w3-left">Rif:</span>
								<b class="w3-right"><?=$negocio["rif"]?></b>
								<div class="w3-clear"></div>
							</li>
							<li>
								<span class="w3-tag w3-blue w3-left">Teléfono:</span>
								<b class="w3-right"><?=isset($negocio["tlf_n"]) ? $negocio["tlf_n"] : "No especificado"?></b>
								<div class="w3-clear"></div>
							</li>
							<li>
								<span class="w3-tag w3-blue w3-left">Dirección:</span>
								<b class="w3-right"><?=isset($negocio["direccion_n"]) ? $negocio["direccion_n"] : "No especificado"?></b>
								<div class="w3-clear"></div>
							</li>
						</ul>

						<button class="w3-button w3-blue w3-section w3-round-large w3-show" id="botonActualizarNegocio<?=$negocio["id_n"]?>">Actualizar datos</button>
				
						<!--==================================================
						=            Formulario `Actualizar info`            =
						===================================================-->
						<form action="" method="POST" class="w3-center w3-hide w3-small w3-padding-16" id="formulario-actualizar-negocio-<?=$negocio["id_n"]?>">
							<div class="w3-row w3-section">
								<label for="nombre<?=$negocio["id_n"]?>" class="w3-third w3-padding">Nombre</label>
								<input type="text" name="nombre" class="w3-twothird w3-input" value="<?=$negocio["nom_n"]?>" id="nombre<?=$negocio["id_n"]?>">
							</div>
							<div class="w3-row w3-section">
								<label for="rif<?=$negocio["id_n"]?>" class="w3-third w3-padding">Rif</label>
								<input type="number" name="rif" class="w3-twothird w3-input" value="<?=$negocio["rif"]?>" id="rif<?=$negocio["id_n"]?>">
							</div>
							<div class="w3-row w3-section">
								<label for="telefono<?=$negocio["id_n"]?>" class="w3-third w3-padding">Teléfono</label>
								<input type="text" name="telefono" class="w3-twothird w3-input" value="<?=$negocio["tlf_n"]?>" id="telefono<?=$negocio["id_n"]?>">
							</div>
							<div class="w3-row w3-section">
								<label for="direccion<?=$negocio["id_n"]?>" class="w3-third w3-padding">Dirección</label>
								<input type="text" name="direccion" class="w3-twothird w3-input" value="<?=$negocio["direccion_n"]?>" id="direccion<?=$negocio["id_n"]?>">
							</div>
							<input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-blue w3-round-large">
						</form>
					</div>
					<!--====  End of PANEL `NEGOCIO`  ====-->
		
					<!--============================================
					=            PANEL `FOTO DE PERFIL`            =
					=============================================-->
					<form class="formulario-foto w3-quarter w3-center w3-white w3-leftbar" id="formulario-foto<?=$negocio["id_n"]?>" enctype="multipart/form-data" action="" method="POST">
						<label for="foto<?=$negocio["id_n"]?>" class="w3-display-container w3-hover-opacity" style="background:url() top/contain no-repeat">
							<i class="icon-camera w3-xxxlarge w3-display-middle"></i>
							<input type="file" name="foto" class="w3-hide" id="foto<?=$negocio["id_n"]?>">
							<img class="image-result" src="<?=!empty($negocio["foto"]) ? "../imagenes/negocios/{$negocio['foto']}" : "../imagenes/logoNegocio.jpg"?>" id="foto<?=$negocio["id_n"]?>">
						</label>
						<input type="text" name="id" class="w3-hide" value="<?=$negocio["id_n"]?>">
						<input type="submit" name="actualizarFoto" value="Actualizar" class="w3-button w3-blue w3-round-large w3-section w3-animate-right w3-hide">
						<b class="w3-medium w3-white w3-block w3-margin-top"><?=$negocio["nom_n"]?></b>
						<span class="w3-small w3-white w3-block w3-text-blue">RIF-<?=$negocio["rif"]?></span>
					</form>
					<!--====  End of PANEL `FOTO DE PERFIL`  ====-->
				<?php endforeach; ?>
			</div>
		<!--====  End of PANEL PRINCIPAL  ====-->
	<?php else:
		$restringido = "
			<script>
				Swal.fire({
					title: 'ACCESO DENEGADO',
					icon: 'error',
					footer: 'Volviendo a la página principal',
					timer: 3000,
					timerProgressBar: true,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false,
					showConfirmButton: false,
				})
				setInterval(function(){
					window.location.href = '/licoreria/sistema/'
				}, 3000);
			</script>
		";
	endif; ?>
</main>
<!--====  End of CONFIGURAR NEGOCIOS  ====-->


<?php require_once "partial/footer.php"; ?>