<?php
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
				$notificacion = "
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
						document.querySelector('#registrarUsuario').click();
					</script>
				";
			else:
				$clave = ENCRIPTAR($clave);
				$insertar = "INSERT INTO usuario(ci_u, usuario, nom_u, clave, cargo, tlf) VALUES($cedula, '$usuario', '$nombre', '$clave', 'v', '$telefono')";
				$resultado = mysqli_query($conexion, $insertar);
				if (mysqli_affected_rows($conexion)>0):
					$notificacion = "
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
					$notificacion = "
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
							document.querySelector('#registrarUsuario').click();
						</script>
					";
				endif;
			endif;
		else:
			if ($clave != $confirmar && empty($clave) || empty($confirmar)):
				$notificacion = "
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
						document.querySelector('#registrarUsuario').click();
					</script>
				";
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
						document.querySelector('#registrarUsuario').click();
					</script>
				";
			endif;
		endif;
	endif;
?>