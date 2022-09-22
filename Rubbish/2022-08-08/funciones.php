<?php
	function TABLA(array $datos, array $encabezados, array $campos, bool $editable = false) {
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

	function CONSULTA($sql): array {
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		$array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
		return $array;
	}

	function REGISTRAR($sql): bool {
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		return $resultado;
	}

	function ACTUALIZAR($sql): bool {
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		return $resultado;
	}

	function ESCAPAR_STRING($string): string {
		global $conexion;
		$string = strip_tags(quotemeta(mysqli_real_escape_string($conexion, $string)));
		return $string;
	}

	function CONTAR_REGISTROS(string $tabla): int {
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