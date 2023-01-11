<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');

	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/componentes.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		echo LOADER;
		echo '<div id="moduloUsuarios">';
		
		$sql = "SELECT cedula, nombre, usuario, telefono FROM usuarios WHERE cargo='v' AND activo=1 ORDER BY cedula";
		$usuarios = getRegistros($sql);
				
		$sql = "SELECT cedula, nombre, usuario, telefono FROM usuarios WHERE cargo='v' AND activo=0 ORDER BY cedula";
		$desactivados = [
			'tabla' => 'usuarios',
			'campo' => 'cedula',
			'enlace' => 'views/usuarios.php',
			'filas' => getRegistros($sql)
		];
		$encabezados = [
			'escritorio' => ['C.I', 'Nombre', 'Usuario', 'Teléfono'],
			'movil' => ['C.I', 'Usuario']
		];
		$datos = [
			'camposEscritorio' => ['cedula', 'nombre', 'usuario', 'telefono'],
			'camposMovil' => ['cedula', 'usuario'],
			'filas' => $usuarios
		];
		tabla('Usuarios', $encabezados, $datos, 'No hay usuarios registrados.', $desactivados);
		
		$label = '<b>Cédula: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputCedula = generarINPUT('CEDULA', $label, 'Cédula del empleado');
		
		$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputNombre = generarINPUT('NOMBRE', $label, 'Nombre del empleado');
		
		$label = '<b>Usuario: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputUsuario = generarINPUT('USUARIO', $label, 'Cree un usuario');
		
		$label = '<b>Contraseña: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputClave = generarINPUT('CLAVE', $label, 'Crea una contraseña');
		
		$label = '<b>Confirmar contraseña: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputConfirmar = generarINPUT('CONFIRMAR', $label, 'Repite la contraseña');
		
		$label = '<b>Teléfono: </b><sup class="w3-text-blue">(opcional)</sup>';
		$inputTelefono = generarINPUT('TELEFONO', $label, 'Introduce un teléfono');
		echo <<<HTML
			<form id="registrarUsuario" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
				<div class="w3-right-align">
					<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
				</div>
				<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Registrar Usuario
				</h1>
				<section class="w3-display-container">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					$inputCedula
					$inputNombre
					$inputUsuario
					$inputClave
					$inputConfirmar
					$inputTelefono
				</section>
				<section class="w3-panel">
					<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
						Registrar
					</button>
				</section>
			</form>
		HTML;
		
		echo '<footer id="botones">' . BOTONES['REGISTRAR_USUARIO'] . '</footer>';
		echo '</div>';
	else:
		include '../templates/head.php';
		$script = "<script src='{$BASE_URL}js/restringido.js'></script>";
		include '../templates/footer.php';
	endif;
?>