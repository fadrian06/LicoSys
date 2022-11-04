<?php
	if(!isset($_SESSION["contador"])) $_SESSION["contador"] = 0;
	if (isset($_SESSION["activa"])):
		header("location: sistema/");
	elseif (isset($_POST["login"])):
		$usuario = ESCAPAR($_POST["usuario"]);
		$clave   = $_POST["clave"];
		$negocio = $_POST['negocio'] ?? false;
		if($usuario && $clave):
			if($negocio):
				$sql = "SELECT * FROM usuario WHERE BINARY(usuario)=BINARY('$usuario')";
				if (CONSULTA($sql)):
					$registro = getRegistro($sql);
					if (password_verify($clave, $registro["clave"])):
						if($registro["activo"]):
							$negocio = getRegistro("SELECT * FROM negocio WHERE id_n=$negocio");
							$_SESSION["activa"]        = true;
							$_SESSION["idUsuario"]     = (int) $registro["ci_u"];
							$_SESSION["usuario"]       = $registro["usuario"];
							$_SESSION["nombreUsuario"] = $registro["nom_u"];
							$_SESSION["clave"]         = $_POST["clave"];
							$_SESSION["cargo"]         = $registro["cargo"];
							$_SESSION["pregunta1"]     = $registro["pre1"];
							$_SESSION["respuesta1"]    = $registro["r1"];
							$_SESSION["pregunta2"]     = $registro["pre2"];
							$_SESSION["respuesta2"]    = $registro["r2"];
							$_SESSION["pregunta3"]     = $registro["pre3"];
							$_SESSION["respuesta3"]    = $registro["r3"];
							$_SESSION["foto"]          = $registro["foto"];
							$_SESSION["telefono"]      = $registro["tlf"];
							$_SESSION["idNegocio"]     = (int) $negocio["id_n"];
							$_SESSION["nombreNegocio"] = $negocio["nom_n"];
							$_SESSION["logo"]          = $negocio["foto"];
							$fecha = getHora();
							if ($registro["cargo"] != "a") setRegistro("INSERT INTO log VALUES ('$fecha', {$_SESSION["idUsuario"]}, {$_SESSION["idNegocio"]})");
							header("location: sistema/");
						else:
							$alerta = "
								<script>
									alerta('Este usuario se encuentra desactivado');
								</script>
							";
						endif;
					elseif(++$_SESSION["contador"] < 3):
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
						unset($_SESSION["contador"]);
						$alerta = "
							<script>
								Swal.fire({
									title: 'Contraseña incorrecta',
									html: '<span class=\"w3-text-red\">Verifique mayúsculas y minúsculas</span>',
									footer: '<a class=\"recuperarClave\" onclick=\"ventanaEmergente(formRecuperar, overlay);\">¿Olvidó su contraseña?</a>',
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
							alerta('Usuario no existe<br><small class=\"w3-text-red\">Verifique mayúsculas y minúsculas</small>');
						</script>
					";
				endif;
			else:
				$alerta = "
					<script>
						alerta('Por favor seleccione un negocio');
					</script>
				";
			endif;
		else:
			$alerta = "
				<script>
					alerta('Por favor rellene los campos');
				</script>
			";
		endif;
	endif;
?>