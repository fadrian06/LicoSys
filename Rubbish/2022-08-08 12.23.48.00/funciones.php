<?php
	function TABLA(array $datos, array $encabezados, array $campos, bool $desactivar = false) {
		$url = $_SERVER["PHP_SELF"];
		echo "
			<form method='get' class='tabla w3-container w3-responsive w3-padding-32'>
				<table class='w3-table w3-centered w3-hoverable w3-white'>
					<tr class='w3-blue'>
		";
		$cantidadEncabezados = count($encabezados);
		$cantidadCampos      = count($campos);
		for ($i = 0; $i < $cantidadEncabezados; $i++): ?>
			<th class='w3-border w3-border-black'><?=$encabezados[$i]?></th>
		<?php endfor; ?>
		</tr>
		<?php foreach ($datos as $dato) :?>
			<tr>
				<td class="w3-border w3-border-black">
					<input class='w3-center w3-transparent w3-border-0' type="text" readonly name="llavePrimaria" title="<?=$dato[$campos[0]]?>" value="<?=$dato[$campos[0]]?>">
				</td>
				<?php for ($i = 1; $i < $cantidadCampos; $i++): ?>
					<td class='w3-border w3-border-black'><input class='w3-center w3-transparent w3-border-0' type='text' readonly title='<?=$dato[$campos[$i]];?>' value='<?=$dato[$campos[$i]]?>'></td>
				<?php endfor;?>
			</tr>
		<?php endforeach;?>
			</table>
		</form>
		<?php }

	function getRegistros($sql): array {
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		$array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
		return $array;
	}

	function getRegistro($sql): array {
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		$array = mysqli_fetch_assoc($resultado);
		return $array;
	}
	
	function verificarPreguntas(int $ciUsuario){
		$usuario = getRegistro("SELECT * FROM usuario WHERE ci_u=$ciUsuario");
		$tienePreguntas = true;
		foreach($usuario as $dato):
			if(!$dato) $tienePreguntas = false;
		endforeach;
		if (!$tienePreguntas):
			return "
				<script>
					Swal.fire({
						title: 'No tienes <br>\"preguntas y respuestas secretas\" registradas.',
						footer: '<a href=\"miPerfil.php\" class=\"w3-text-indigo\">CLICK AQUÍ</a>&nbsp;para registrarlas',
						icon: 'warning',
						toast: true,
						timer: 5000,
						timerProgressBar: true,
						position: 'bottom-end',
						showConfirmButton: false
					})
				</script>
			";
		endif;
		return false;
	}

	function CONSULTA($sql): int {
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		return mysqli_num_rows($resultado);
	}

	function getUltimaVersion(){
		$version = getRegistro("SELECT * FROM versiones ORDER BY id_v DESC LIMIT 1");
		return $version["nombre_v"];
	}

	function getUltimoNegocio(): int{
		$id = getRegistro("SELECT * FROM negocio ORDER BY id_n DESC LIMIT 1");
		return (int) $id["id_n"];
	}

	function setRegistro($sql): int{
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		return mysqli_affected_rows($conexion);
	}

	function ESCAPAR($string): string {
		global $conexion;
		$string = strip_tags(quotemeta(mysqli_real_escape_string($conexion, $string)));
		return $string;
	}

	function contarRegistros(string $tabla): int {
		global $conexion;
		$resultado = mysqli_query($conexion, "SELECT COUNT(*) FROM $tabla");
		$resultado = mysqli_fetch_row($resultado);
		return (int) $resultado[0];
	}

	function ENCRIPTAR(string $texto): string {
		global $conexion;
		$encriptado = password_hash($texto, PASSWORD_DEFAULT);
		return $encriptado;
	}

	function FECHA(): string{
		$semana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
		$meses = ["Diciembre", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre"];
		return $semana[date("w")] . " " . date("d") . " de " . $meses[date("n")] . " del " . date("Y");
	}
?>