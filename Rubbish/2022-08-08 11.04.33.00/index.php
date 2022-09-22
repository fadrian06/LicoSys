<?php
	session_start();
	require_once "php/conexion.php";
	require_once "sistema/php/funciones.php";
	if(!isset($_SESSION["contador"])) $_SESSION["contador"] = 0;
	$negocios = CONSULTA("SELECT * FROM negocio WHERE activo=1");
	$version = CONSULTA("SELECT MAX(id_v) FROM versiones");
	$ultimaVersion = $version[0]["MAX(id_v)"];
	$version = CONSULTA("SELECT * FROM versiones WHERE id_v=$ultimaVersion");
	$ultimaVersion = $version[0]["nombre_v"];
	$registros = CONSULTA("SELECT * FROM usuario");
	foreach($registros as $registro):
		if($registro["cargo"] == "a") $existeAdmin = true;
	endforeach;
	if (isset($_SESSION["activa"])):
		header("location: sistema/");
	else:
		if (isset($_POST["login"])):
			$usuario = ESCAPAR_STRING($_POST["usuario"]);
			$clave   = $_POST["clave"];
			$negocio = isset($_POST["negocio"]) ? $_POST['negocio'] : false;
			if($negocio):
				$consulta  = "SELECT * FROM usuario WHERE BINARY(usuario)=BINARY('$usuario')";
				$resultado = mysqli_query($conexion, $consulta);
				if ($resultado):
					$filas = mysqli_num_rows($resultado);
					if ($filas > 0):
						$registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
						if (password_verify($clave, $registro["clave"])):
							if($registro["activo"]):
								@mysqli_free_result($resultado);
								$_SESSION["activa"]        = true;
								$_SESSION["idUsuario"]     = $registro["ci_u"];
								$_SESSION["usuario"]       = $registro["usuario"];
								$_SESSION["nombreUsuario"] = $registro["nom_u"];
								$_SESSION["clave"]         = $registro["clave"];
								$_SESSION["cargo"]         = $registro["cargo"];
								$_SESSION["pregunta1"]     = $registro["pre1"];
								$_SESSION["respuesta1"]    = $registro["r1"];
								$_SESSION["pregunta2"]     = $registro["pre2"];
								$_SESSION["respuesta2"]    = $registro["r2"];
								$_SESSION["pregunta3"]     = $registro["pre3"];
								$_SESSION["respuesta3"]    = $registro["r3"];
								$_SESSION["foto"]          = $registro["foto"];
								$_SESSION["telefono"]      = $registro["tlf"];
								$_SESSION["negocio"]       = $negocio;
								$ci_u  = (int) $registro["ci_u"];
								$fecha = date("d-m-Y, h:i a");
								if ($registro["cargo"] != "a"):
									$insertar = "INSERT INTO log VALUES ('$fecha', $ci_u, $negocio)";
									$resultado = mysqli_query($conexion, $insertar);
									@mysqli_free_result($resultado);
								endif;
								header("location:sistema/");
							else:
								@mysqli_free_result($resultado);
								$alerta = "
									<script>
										Swal.fire({
											title: 'Este usuario se encuentra desactivado',
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
							@mysqli_free_result($resultado);
							$_SESSION["contador"]++;
							if($_SESSION["contador"] < 3):
								$alerta = "
									<script>
										Swal.fire({
											title: 'Contraseña incorrecta',
											html: '<span class=\"w3-text-red\">Verifique mayúsculas y minúsculas</span>',
											icon: 'error',
											footer: 'Intento<b>&nbsp;{$_SESSION["contador"]}/3</b>',
											toast: true,
											timer: 5000,
											timerProgressBar: true,
											position: 'bottom-end',
											showConfirmButton: false
										})
									</script>
								";
							else:
								$alerta = "
									<script>
										Swal.fire({
											title: 'Contraseña incorrecta',
											html: '<span class=\"w3-text-red\">Verifique mayúsculas y minúsculas</span>',
											footer: '<a class=\"recuperarClave\" id=\"recuperarClave\">¿Olvidó su contraseña?</a>',
											icon: 'error',
											toast: true,
											timer: 5000,
											timerProgressBar: true,
											position: 'bottom-end',
											showConfirmButton: false
										})
									</script>
								";
								session_destroy();
							endif;
						endif;
					else:
						@mysqli_free_result($resultado);
						$alerta = "
							<script>
								Swal.fire({
									title: 'Usuario no existe',
									html: '<span class=\"w3-text-red\">Verifique mayúsculas y minúsculas</span>',
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
					@mysqli_free_result($resultado);
					$alerta = "
						<script>
							Swal.fire({
								title: 'Ha ocurrido un error, por favor intente nuevamente',
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
				$alerta = "
					<script>
						Swal.fire({
							title: 'Por favor seleccione un negocio',
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
	endif;

	if(isset($_POST["consultar"])):
		$cedula  = (int) $_POST["cedula"];
		$usuario = ESCAPAR_STRING($_POST["usuario"]);
		if(!empty($cedula) || !empty($usuario)):
			$consulta = "SELECT * FROM usuario WHERE BINARY(usuario)=BINARY('$usuario')";
			if($resultado = mysqli_query($conexion, $consulta)):
				if(mysqli_num_rows($resultado) > 0):
					$registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
					@mysqli_free_result($resultado);
					if((int) $registro["ci_u"] == $cedula):
						$mostrarPreguntas = true;
					else:
						@mysqli_free_result($resultado);
						$alerta = "
							<script>
								document.querySelector('a.recuperarClave').click();
								Swal.fire({
									title: 'Cédula incorrecta',
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
				@mysqli_free_result($resultado);
					$alerta = "
						<script>
							document.querySelector('a.recuperarClave').click();
							Swal.fire({
								title: 'Usuario no existe',
								html: '<span class=\"w3-text-red\">Verifique mayúsculas y minúsculas</span>',
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
			@mysqli_free_result($resultado);
				$alerta = "
					<script>
						document.querySelector('a.recuperarClave').click();
						Swal.fire({
							title: 'Ha ocurrido un error, por favor intente nuevamente',
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
			$alerta = "
				<script>
					document.querySelector('a.recuperarClave').click();
					Swal.fire({
						title: 'Por favor rellene los campos',
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

	if(isset($_POST["enviarRespuestas"])):
		$respuesta1 = ESCAPAR_STRING($_POST["respuesta1"]);
		$respuesta2 = ESCAPAR_STRING($_POST["respuesta2"]);
		$respuesta3 = ESCAPAR_STRING($_POST["respuesta3"]);
		$usuario = $_POST["usuario"];
		if(!empty($respuesta1) || !empty($respuesta2) || !empty($respuesta3)):
			$consulta  = "SELECT * FROM usuario WHERE usuario='$usuario'";
			$resultado = mysqli_query($conexion, $consulta);
			$registro  = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
			if(password_verify($respuesta1, $registro["r1"]) && password_verify($respuesta2, $registro["r2"]) && password_verify($respuesta3, $registro["r3"])):
				$cambiarClave = true;
			else:
				$mostrarPreguntas = true;
				$alerta = "
					<script>
						Swal.fire({
							title: 'Respuestas incorrectas',
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
			$consulta  = "SELECT * FROM usuario WHERE usuario='$usuario'";
			$resultado = mysqli_query($conexion, $consulta);
			$registro  = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
			$mostrarPreguntas = true;
			$alerta = "
				<script>
					Swal.fire({
						title: 'Por favor rellene los campos',
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

	if(isset($_POST["actualizarClave"])):
		$nuevaClave = $_POST["nuevaClave"];
		$confirmar  = $_POST["confirmar"];
		$usuario    = $_POST["usuario"];
		$consulta   = "SELECT * FROM usuario WHERE usuario='$usuario'";
		$resultado  = mysqli_query($conexion, $consulta);
		$registro   = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		if(!empty($nuevaClave) || !empty($confirmar)):
			if($nuevaClave === $confirmar):
				$nuevaClave = ENCRIPTAR($nuevaClave);
				if(ACTUALIZAR("UPDATE usuario SET clave='$nuevaClave' WHERE usuario='$usuario'")):
				@mysqli_free_result($resultado);
					$claveActualizada = $confirmar;
					$alerta = "
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
					$cambiarClave = true;
					$alerta = "
						<script>
							Swal.fire({
								title: 'Ha ocurrido un error, por favor intente nuevamente',
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
				$cambiarClave = true;
				$alerta = "
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
			$cambiarClave = true;
			$alerta = "
				<script>
					Swal.fire({
						title: 'Por favor rellene los campos',
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

	if(isset($_POST["registrar"])):
		$nombre    = ESCAPAR_STRING($_POST["nombreNegocio"]);
		$rif       = ESCAPAR_STRING($_POST["rif"]);
		$telefono  = !empty($_POST["telefono"])  ? ESCAPAR_STRING($_POST["telefono"])  : "";
		$direccion = !empty($_POST["direccion"]) ? ESCAPAR_STRING($_POST["direccion"]) : "";
		$foto      = !empty($_FILES["foto"]) ? $_FILES["foto"] : "";
		$imagen = "";
		if(!empty($nombre) && !empty($rif)):
			if(!empty($foto)):
				$id = CONSULTA("SELECT MAX(id_n) FROM negocio");
				$id = (int) $id[0]["MAX(id_n)"] + 1;
				$tipo = $foto["type"];
				$peso = $foto["size"];
				$dirTemporal = $foto["tmp_name"];
				switch($tipo){
					case "image/jpeg":
					case "image/jpg":
					case "image/png":
						$imagen = "$id.jpeg";
						break;
				}
				if($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png"):
					if($peso < 1*1000*2048 /*2MB*/):
						move_uploaded_file($dirTemporal, "imagenes/negocios/$imagen");
					else:
						$alerta = "
							<script>
								Swal.fire({
									title: 'La imagen no puede ser mayor a <b class=\"w3-text-red\" title=\"2 Megabytes\">2MB</b>',
									icon: 'error',
									timer: 5000,
									timerProgressBar: true,
									position: 'bottom-end',
									showConfirmButton: false
								})
								mostrarFormulario('#formularioRegistrarNegocio', 'div.overlayModal');
							</script>
						";
					endif;
				else:
					$alerta = "
						<script>
							Swal.fire({
								title: 'Sólo se permiten imagenes (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)',
								icon: 'error',
								timer: 3000,
								timerProgressBar: true,
								position: 'bottom-end',
								showConfirmButton: false
							})
							mostrarFormulario('#formularioRegistrarNegocio', 'div.overlayModal');
						</script>
					";
				endif;
			endif;
			$consulta  = "SELECT * FROM negocio WHERE nom_n='$nombre' OR rif='$rif'";
			$resultado = mysqli_query($conexion, $consulta);
			$fila = mysqli_num_rows($resultado);
			if(!$fila > 0):
				if(REGISTRAR("INSERT INTO negocio(nom_n, rif, tlf_n, direccion_n, foto, activo) VALUES('$nombre', '$rif', '$telefono', '$direccion', '$imagen', 1)")):
					$alerta = "
						<script>
							Swal.fire({
								title: 'Registro existoso',
								icon: 'success',
								timer: 2000,
								timerProgressBar: true,
								showConfirmButton: false
							})
						</script>
					";
					$negocios = CONSULTA("SELECT * FROM negocio WHERE activo=1");
				else:
					$alerta = "
						<script>
							Swal.fire({
								title: 'Ha ocurrido un error, por favor intente nuevamente',
								icon: 'error',
								toast: true,
								timer: 5000,
								timerProgressBar: true,
								position: 'bottom-end',
								showConfirmButton: false
							})
							mostrarFormulario('#formularioRegistrarNegocio', 'div.overlayModal');
						</script>
					";
				endif;
			else:
				$alerta = "
					<script>
						Swal.fire({
							title: 'Negocio ya existe',
							icon: 'error',
							toast: true,
							timer: 5000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
						mostrarFormulario('#formularioRegistrarNegocio', 'div.overlayModal');
					</script>
				";
			endif;
		else:
			$alerta = "
				<script>
					Swal.fire({
						title: 'Por favor rellene los campos',
						icon: 'error',
						toast: true,
						timer: 3000,
						timerProgressBar: true,
						position: 'bottom-end',
						showConfirmButton: false
					})
					mostrarFormulario('#formularioRegistrarNegocio', 'div.overlayModal');
				</script>
			";
		endif;
	endif;

	if (isset($_POST["registrarUsuario"])):
		$cedula   = (int) $_POST["cedula"];
		$nombre   = ESCAPAR_STRING($_POST["nombre"]);
		$usuario  = ESCAPAR_STRING($_POST["usuario"]);
		$clave    = ESCAPAR_STRING($_POST["nuevaClave"]);
		$confirmar   = ESCAPAR_STRING($_POST["confirmar"]);
		$telefono = ESCAPAR_STRING($_POST["telefono"]);
		if ($clave == $confirmar && !empty($clave) && !empty($confirmar)):
			$consulta = "SELECT * FROM usuario WHERE usuario='$usuario' || ci_u=$cedula";
			$resultado = mysqli_query($conexion, $consulta);
			$filas = mysqli_num_rows($resultado);
			if ($filas > 0):
				$alerta = "
					<script>
						Swal.fire({
							title: 'Usuario ya existe',
							icon: 'error',
							toast: true,
							timer: 5000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
						mostrarFormulario('#formularioRegistrarUsuario', 'div.w3-overlay');
					</script>
				";
			else:
				$clave = ENCRIPTAR($clave);
				$insertar = "INSERT INTO usuario(ci_u, usuario, nom_u, clave, cargo, tlf) VALUES($cedula, '$usuario', '$nombre', '$clave', 'a', '$telefono')";
				$resultado = mysqli_query($conexion, $insertar);
				if (mysqli_affected_rows($conexion)>0):
					$alerta = "
						<script>
							Swal.fire({
								title: 'Registro exitoso',
								icon: 'success',
								timer: 2000,
								timerProgressBar: true,
								showConfirmButton: false
							})
						</script>
					";
				else:
					$alerta = "
						<script>
							Swal.fire({
								title: 'Ha ocurrido un error, por favor intente nuevamente',
								icon: 'error',
								toast: true,
								timer: 5000,
								timerProgressBar: true,
								position: 'bottom-end',
								showConfirmButton: false
							})
							mostrarFormulario('#formularioRegistrarUsuario', 'div.w3-overlay');
						</script>
					";
				endif;
			endif;
		else:
			if ($clave != $confirmar && empty($clave) || empty($confirmar)):
				$alerta = "
					<script>
						Swal.fire({
							title: 'Por favor rellene los campos',
							icon: 'error',
							toast: true,
							timer: 3000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
						mostrarFormulario('#formularioRegistrarUsuario', 'div.w3-overlay');
					</script>
				";
			else:
				$alerta = "
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
						mostrarFormulario('#formularioRegistrarUsuario', 'div.w3-overlay');
					</script>
				";
			endif;
		endif;
	endif;
?>
<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="author" content="Franyer Sánchez">
		<meta name="author" content="Daniel Mancilla">
		<meta name="description" content="Sistema Automatizado para Registrar Compras y Ventas">
		<meta name="theme-color" content="black">
		<link rel="icon" href="imagenes/favicon.png">
		<link rel="stylesheet" href="iconos/style.min.css">
		<link rel="stylesheet" href="librerias/w3/w3.min.css">
		<link rel="stylesheet" href="librerias/sweetalert2/sweetalert2.min.css">
		<link rel="stylesheet" href="librerias/animate.min.css">
		<link rel="stylesheet" href="fuentes/fuentes.css">
		<link rel="stylesheet" href="css/login.css">
		<title>LicoSys</title>
	</head>

	<body>
		<!--====================================================
		=            FORMULARIO REGISTRAR NEGOCIO              =
		=====================================================-->
		<?php if(!$negocios): ?>
			<form action="" method="POST" enctype="multipart/form-data" class="w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show" id="formularioRegistrarNegocio">
				<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
				<h3 class="swal2-title w3-margin-bottom">Registro de Negocio</h3>
				<div class="w3-twothird w3-rightbar">
					<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
						<div class="input">
							<div class="icono">
								<span class="icon-edit"></span>
							</div>
							<input type="text" name="nombreNegocio" placeholder="Nombre del negocio" autocomplete="off">
						</div>
					</section>
					<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
						<div class="input">
							<div class="icono">
								<span class="icon-edit"></span>
							</div>
							<input type="text" name="rif" placeholder="RIF del negocio" autocomplete="off" minlength="8" maxlength="15" required pattern="^[0-9]{8,15}$" title="Sólo se permiten números entre 8 y 15 dígitos">
						</div>
					</section>
					<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
						<div class="input">
							<div class="icono">
								<span class="icon-edit"></span>
							</div>
							<input type="text" name="telefono" placeholder="Teléfono de contacto" autocomplete="off">
						</div>
					</section>
					<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
						<div class="input">
							<div class="icono">
								<span class="icon-edit"></span>
							</div>
							<input type="text" name="direccion" placeholder="Dirección del negocio" autocomplete="off">
						</div>
					</section>
					<div class="submit w3-margin-top w3-container">
						<input class="w3-margin-left w3-margin-right" type="submit" value="Registrar" name="registrar">
					</div>
				</div>
				<div class="formulario-foto w3-third w3-center w3-white" id="formulario-foto<?=$negocio["id_n"]?>" enctype="multipart/form-data" action="" method="POST">
					<label for="registroLogo" class="w3-display-container w3-hover-opacity" style="background:url() top/contain no-repeat">
						<i class="icon-camera w3-xxxlarge w3-display-middle"></i>
						<input type="file" name="foto" class="w3-hide" id="registroLogo">
						<img class="image-result w3-image" src="imagenes/logoNegocio.jpg" style="max-width: 150px;">
					</label>
					<b class="w3-medium w3-white w3-block w3-margin-top">Logotipo del negocio</b>
					<span class="w3-small w3-white w3-block w3-text-blue">Opcional</span>
				</div>
			</form>
		<?php endif; ?>
		<!--====  End of FORMULARIO REGISTRAR NEGOCIO  ====-->

		<!--==========================================================
		=            FORMULARIO REGISTRAR ADMINISTRADOR              =
		===========================================================-->
		<?php if(!isset($existeAdmin)): ?>
			<form action="" method="POST" class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show" id="formularioRegistrarUsuario">
				<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
				<h3 class="swal2-title w3-margin-bottom">Registro de Administrador</h3>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="number" name="cedula" placeholder="Cédula" minlength="7" maxlength="8" required>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="text" name="nombre" placeholder="Nombre" required>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="text" name="usuario" placeholder="@usuario" required>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="password" name="nuevaClave" id="nuevaClave" placeholder="Crear Contraseña" required>
						<div class="icono ver">
							<span class="icon-eye" id="ojo2" onclick="verClave(this.id, 'nuevaClave')"></span>
						</div>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="password" name="confirmar" id="confirmar" placeholder="Repetir contraseña" required>
						<div class="icono ver">
							<span class="icon-eye" id="ojo1" onclick="verClave(this.id, 'confirmar')"></span>
						</div>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-edit"></span>
						</div>
						<input type="text" name="telefono" placeholder="Teléfono (opcional)">
					</div>
				</section>
				<div class="submit w3-margin-top w3-container">
					<input class="w3-padding-large w3-margin-left w3-margin-right" type="submit" value="Registrar" name="registrarUsuario">
				</div>
			</form>
		<?php endif; ?>
		<!--====  End of FORMULARIO REGISTRAR ADMINISTRADOR  ====-->

		<?php if($negocios && isset($existeAdmin)): ?>
			<div class="contenedor">
				<!--=============================
				=            SIDEBAR            =
				==============================-->
				<aside class="bienvenida w3-display-container">
					<div class="widget w3-display-bottomright w3-margin-right">
						<div class="fecha">
							<b id="diaSemana"></b>
							<b id="dia"></b>
							<b>de </b>
							<b id="mes"></b>
							<b>del </b>
							<b id="year"></b>
						</div>
						<div class="reloj">
							<b id="horas"></b>
							<b>:</b>
							<b id="minutos"></b>
							<b id="ampm"></b>
						</div>
					</div>
					<p class=" w3-xlarge widget fecha w3-margin-right w3-display-topright"><b>LicoSys <?=$ultimaVersion?></b></p>
				</aside>
				<!--====  End of SIDEBAR  ====-->
		
				<!--===========================
				=            LOGIN            =
				============================-->
				<form action="" method="POST" id="formulario-login" class="w3-center w3-padding-large">
					<header class="w3-container w3-bottombar w3-border-black">
						<h1 class="w3-xlarge w3-margin-left">Iniciar Sesión</h1>
					</header>
					<section class="negocios w3-section">
						<b class="w3-block w3-margin-bottom w3-text-grey">Por favor seleccione un negocio:</b>
						<div class="input-radio">
							<?php foreach($negocios as $negocio): ?>
								<div class="radio-group" id="negocio<?=$negocio["id_n"]?>">
									<input type="radio" name="negocio" id="negocio#<?=$negocio["id_n"]?>" value="<?=$negocio["id_n"]?>">
									<label for="negocio#<?=$negocio["id_n"]?>" title="<?=$negocio['nom_n']?>" style="background:url(<?=!empty($negocio["foto"]) ? "imagenes/negocios/{$negocio["foto"]}" : "imagenes/logoNegocio.jpg"?>) center/contain no-repeat"></label>
								</div>
							<?php endforeach; ?>
						</div>
					</section>
					<section class="w3-padding-16">
						<div class="input">
							<div class="icono">
								<span class="icon-user-circle-o"></span>
							</div>
							<input type="text" name="usuario" placeholder="Ingrese su usuario" autocomplete="off" value="<?=isset($usuario) ? $usuario : "" ?>" minlength="4" maxlength="20" required pattern="^[a-zA-Z]*[\w-]{4,20}$" title="Sólo se permiten letras, guiones(-) y espacios">
						</div>
					</section>
					<section class="w3-padding-16">
						<div class="input">
							<div class="icono">
								<span class="icon-lock"></span>
							</div>
							<input type="password" id="clave" name="clave" placeholder="Ingrese su contraseña" autocomplete value="<?=isset($claveActualizada) ? $claveActualizada : ""?>" minlength="4" maxlength="20" required pattern="^[\w.-@#/*]{4,20}$" title="Sólo se permiten letras, espacios y símbolos(.-@#/*)">
							<div class="icono ver">
								<span class="icon-eye" id="ojo" onclick="verClave(this.id, 'clave')"></span>
							</div>
						</div>
					</section>
					<div class="submit w3-section">
						<input type="submit" name="login" value="Iniciar">
					</div>
					<a class="recuperarClave">¿Olvidó su contraseña?</a>
				</form>
				<!--====  End of LOGIN  ====-->
			</div>
		<?php endif; ?>

		<!--==================================
		=            FONDO OSCURO            =
		===================================-->
		<div class="w3-overlay w3-animate-opacity w3-hide"></div>

		<!--====================================================
		=            FORMULARIO CONSULTAR PREGUNTAS            =
		=====================================================-->
		<form action="" method="POST" class="formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formulario-recuperar">
			<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
			<h3 class="swal2-title">Recuperar Contraseña</h3>
			<b class="w3-text-teal">Paso 1/3</b>
			<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
				<div class="input">
					<div class="icono">
						<span class="icon-id-card"></span>
					</div>
					<input type="number" name="cedula" placeholder="Ingrese su cédula" autocomplete="off" value="<?=isset($cedula) ? $cedula : "" ?>" minlength="7" maxlength="8" required pattern="^[^e]?[0-9]{7,8}$" title="Debe tener entre 7 y 8 dígitos">
				</div>
			</section>
			<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
				<div class="input">
					<div class="icono">
						<span class="icon-user-circle-o"></span>
					</div>
					<input type="text" name="usuario" placeholder="Ingrese su usuario" autocomplete="off" value="<?=isset($usuario) ? $usuario : "" ?>" minlength="4" maxlength="20" required pattern="^[a-zA-Z]*[\w-]{4,20}$" title="Sólo se permiten letras, guiones(-) y espacios">
				</div>
			</section>
			<div class="submit w3-margin-top w3-container">
				<input class="w3-margin-left w3-margin-right" type="submit" value="Consultar" name="consultar">
			</div>
		</form>
		<!--====  End of FORMULARIO CONSULTAR PREGUNTAS  ====-->

		<!--=======================================================
		=            FORMULARIO PREGUNTAS Y RESPUESTAS            =
		========================================================-->
		<?php if(isset($mostrarPreguntas)): ?>
			<form action="" method="POST" class="formularioModal w3-padding-16 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show" id="formulario-preguntas">
				<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
				<h3 class="swal2-title">Recuperar Contraseña</h3>
				<b class="w3-text-teal">Paso 2/3</b>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<label for="r1" class="w3-block w3-left-align w3-margin-bottom w3-margin-left">Pregunta 1: <b><?=$registro["pre1"] . "?"?></b></label>
					<div class="input">
						<div class="icono">
							<span class="icon-key"></span>
						</div>
						<input type="text" id="r1" name="respuesta1" placeholder="Respuesta" autocomplete="off" maxlength="20" required pattern="^[a-zA-Z]+$" title="Sólo letras y espacios" value="<?=isset($respuesta1) ? $respuesta1 : "" ?>">
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
					<label for="r2" class="w3-block w3-left-align w3-margin-bottom w3-margin-left">Pregunta 2: <b><?=$registro["pre2"] . "?"?></b></label>
					<div class="input">
						<div class="icono">
							<span class="icon-key"></span>
						</div>
						<input type="text" id="r2" name="respuesta2" placeholder="Respuesta" autocomplete="off" maxlength="20" required pattern="^[a-zA-Z]+$" title="Sólo letras y espacios" value="<?=isset($respuesta2) ? $respuesta2 : "" ?>">
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
					<label for="r3" class="w3-block w3-left-align w3-margin-bottom w3-margin-left">Pregunta 3: <b><?=$registro["pre3"] . "?"?></b></label>
					<div class="input">
						<div class="icono">
							<span class="icon-key"></span>
						</div>
						<input type="text" id="r3" name="respuesta3" placeholder="Respuesta" autocomplete="off" maxlength="20" required pattern="^[a-zA-Z]+$" title="Sólo letras y espacios" value="<?=isset($respuesta3) ? $respuesta3 : "" ?>">
					</div>
				</section>
				<input type="text" name="usuario" class="w3-hide" value="<?=$registro["usuario"]?>">
				<div class="submit w3-margin-top w3-container">
					<input class="w3-margin-left w3-margin-right" type="submit" value="Consultar" name="enviarRespuestas">
				</div>
			</form>
		<?php endif; ?>
		<!--====  End of FORMULARIO PREGUNTAS Y RESPUESTAS  ====-->

		<!--==============================================
		=            FORMULARIO CAMBIAR CLAVE            =
		===============================================-->
		<?php if(isset($cambiarClave)): ?>
			<form action="" method="POST" class="formularioModal w3-padding-16 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show" id="formulario-clave">
				<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
				<h3 class="swal2-title">Recuperar Contraseña</h3>
				<b class="w3-text-teal">Paso 3/3</b>
				<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-lock"></span>
						</div>
						<input type="password" id="nuevaClave" name="nuevaClave" placeholder="Nueva contraseña" autocomplete="off" minlength="4" maxlength="20" required pattern="^[\w.-@#/*]{4,20}$" title="Sólo se permiten letras, espacios y símbolos(.-@#/*)">
						<div class="icono ver">
							<span class="icon-eye" id="ojoNuevaClave" onclick="verClave(this.id, 'nuevaClave')"></span>
						</div>
					</div>
				</section>
				<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
					<div class="input">
						<div class="icono">
							<span class="icon-key"></span>
						</div>
						<input type="password" id="confirmar" name="confirmar" placeholder="Repetir contraseña" autocomplete="off" minlength="4" maxlength="20" required pattern="^[\w.-@#/*]{4,20}$" title="Sólo se permiten letras, espacios y símbolos(.-@#/*)">
						<div class="icono ver">
							<span class="icon-eye" id="ojoConfirmar" onclick="verClave(this.id, 'confirmar')"></span>
						</div>
					</div>
				</section>
				<input type="text" name="usuario" class="w3-hide" value="<?=$registro["usuario"]?>">
				<div class="submit w3-margin-top w3-container">
					<input class="w3-margin-left w3-margin-right" type="submit" value="Actualizar" name="actualizarClave">
				</div>
			</form>
		<?php endif; ?>
		<!--====  End of FORMULARIO CAMBIAR CLAVE  ====-->
		
		<script src="librerias/w3/w3.min.js"></script>
		<script src="librerias/sweetalert2/sweetalert2.all.min.js"></script>
		<script src="sistema/js/actualizarFoto.js"></script>
		<script src="sistema/js/funciones.js"></script>
		<script src="js/verClave.js"></script>
		<script src="js/alertas.js"></script>
		<script src="js/validacion.js"></script>
		<script src="js/login.js"></script>
		<?=isset($alerta) ? $alerta : ""?>
		<script src="js/reloj.js"></script>
	</body>
</html>