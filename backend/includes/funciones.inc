<?php
	/**
	 * GENERA UNA TABLA
	 * @param array   $datos         Los datos que desea mostrar
	 * @param array   $encabezados   Los encabezados de la tabla
	 * @param boolean $desactivar    Si quiere agregar el botón correspondiente
	 * @param string  $tabla         Nombre de la tabla en la Base de Datos
	 * @param string  $llavePrimaria Llave primaria de cada fila
	 * @param array   $desactivados  Si quiere agregar el botón correspondiente
	 * @param boolean $editable      Si quiere agregar el botón correspondiente
	 */
	function TABLA(array $datos, array $encabezados, $desactivar = false, $tabla = "", $llavePrimaria = "", array $desactivados = [], $editable = false) {
		echo "
			<div class='w3-padding-large w3-responsive'>
				<table class='w3-table w3-centered'>
					<tr>
		";
		for ($i = 0, $intEncabezados = count($encabezados); $i < $intEncabezados; $i++):
			echo "<th class='w3-border w3-border-black w3-blue'>$encabezados[$i]</th>";
		endfor;
		if($desactivar):
			echo "<th></th>";
			$_SESSION["llavePrimaria"] = $llavePrimaria;
			$_SESSION["tabla"] = $tabla;
		endif;
		echo $desactivar ? "<th></th>" : "";
		echo "</tr>";
		foreach ($datos as $dato):
			echo "
				<tr>
					<form method='POST'>
						<td class='w3-border w3-border-black w3-white'>
							<input style='width: max-content' class='w3-input w3-center w3-border-0 w3-transparent' type='text' readonly name='llavePrimaria' value='$dato[0]'>
						</td>
			";
			for ($i = 1; $i < $intEncabezados; $i++):
				echo "
				 	<td class='w3-border w3-border-black w3-white'>
				 		<input style='width: max-content' class='w3-input w3-center w3-border-0 w3-transparent' type='text' readonly value='$dato[$i]'>
				 	</td>
				";
			endfor;
			if($desactivar || $editable):
				echo "<td>";
				if($desactivar) echo "<input class='w3-button w3-red w3-round-xlarge' type='submit' name='desactivar' value='Desactivar'>";
				if($editable && $_SESSION["cargo"] == "a") echo "<input class='w3-button w3-indigo w3-round-large' type='submit' name='editar' value='Editar'";
				echo "</td>";
			endif;
			echo "
					</form>
				</tr>";
		endforeach;
		echo "
				</table>
			</div>
		";
		if($desactivados) mostrarDesactivados($desactivados, $encabezados);
		if($editable) editar($tabla, $llavePrimaria);
	}

	function editar(string $tabla, $llavePrimaria){
		if(isset($_POST['llavePrimaria'])):
			$llave = $_POST['llavePrimaria'];
			$sql = ($tabla == 'proveedor')
				? "SELECT * FROM $tabla WHERE $llavePrimaria=$llave"
				: "SELECT * FROM $tabla WHERE $llavePrimaria='$llave'";
			$registro = getRegistro($sql);
			if(!empty($registro["ci_u"])) unset($registro["ci_u"]);
			if(!empty($registro["id_p"])) unset($registro["id_p"]);
			if(!empty($registro["id_n"])) unset($registro["id_n"]);
		endif;
	}

	function mostrarDesactivados(array $datos, array $encabezados){
		echo "
			<details class='w3-section w3-padding-large w3-responsive'>
				<summary class='w3-large w3-bottombar w3-border-red w3-round-large'>Desactivados</summary>
				<table class='w3-section w3-table w3-centered' id='activar'>
					<tr>
		";
		for($i = 0, $intEncabezados = count($encabezados); $i < $intEncabezados; $i++):
			echo "<th class='w3-border w3-border-black w3-red'>$encabezados[$i]</th>";
		endfor;
		echo "
				<th></th>
			</tr>
		";
		foreach($datos as $dato):
			echo "
				<tr>
					<form method='POST'>
						<td class='w3-border w3-border-black w3-white'>
							<input class='w3-input w3-center w3-border-0 w3-transparent' type='text' readonly name='llavePrimaria' value='$dato[0]'>
						</td>
			";
			for ($i = 1; $i < $intEncabezados; $i++):
				echo "
				 	<td class='w3-border w3-border-black w3-white'>
				 		<input class='w3-input w3-center w3-border-0 w3-transparent' type='text' readonly value='$dato[$i]'>
				 	</td>
				";
			endfor;
			echo "
						<td>
							<input class='w3-button w3-green w3-round-xlarge' type='submit' name='activar' value='Activar'>
						</td>
					</form>
				</tr>
			";
		endforeach;
		echo "
				</table>
			</details>
		";
	}

	/**
	 * Valida un string con un patrón
	 * @param string $patron El patrón a utilizar
	 * @param string $dato   El string a validar
	 * @return bool          Retorna 1 si coincide, 0 si no y FALSE si falla
	 */
	function validar(string $patron, string $dato):bool {
		return preg_match($patron, $dato);
	}
	
	/**
	 * RETORNA UN SCRIPT CON UNA ALERTA DE ACCESO DENEGADO
	 * @return string Una etiqueta \<script>\</script>
	 */
	function REDIRECCIONAR():string{
		return "
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
				setTimeout(function(){
					window.location.href = 'http://localhost/licoreria/sistema/';
				}, 3000);
			</script>
		";
	}

	/**
	 * FORMATEA SALIDA
	 * @param  iterable $dato Un objeto o array
	 */
	function depurar(iterable $dato){
		$formato = print_r("<pre>");
		$formato += print_r($dato);
		$formato += print_r("</pre>");
	}

	/**
	 * Obtiene la Base de Datos en uso
	 * @return string Nombre de la base de datos
	 */
	function getBD(): string {
		global $conexion;
		$resultado = $conexion->query('SELECT DATABASE()');
		$data = $resultado->fetch_assoc();
		return $data['DATABASE()'];
	}

	/**
	 * OBTIENE REGISTROS DE LA BASE DE DATOS
	 * @param  string $sql Una consulta SELECT
	 * @return null|array      Retorna un array con los datos o NULL en caso de fallo
	 */
	function getRegistros(string $sql):?array {
		global $conexion;
		$resultado = $conexion->query($sql);
		return $resultado ? $resultado->fetch_all(MYSQLI_BOTH) : NULL;
	}

	/**
	 * OBTIENE UN REGISTRO DE LA BASE DE DATOS
	 * @param  string $sql Una sentencia SELECT
	 * @return null|array      Retorna un array con el registro. NULL si algo falla, use `$conexion->error` para ver el error
	 */
	function getRegistro(string $sql):?array {
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		return $resultado ? mysqli_fetch_array($resultado, MYSQLI_ASSOC) : NULL;
	}

	/**
	 * Consultas de modificacion de datos
	 * @param string $sql Una consulta INSERT, DELETE, TRUNCATE o UPDATE
	 * @return int   Retorna las filas afectadas o NULL si algo falla, use `$conexion->error` para ver el error
	 */
	function setRegistro(string $sql):?int{
		global $conexion;
		$conexion->query($sql);
		$afectadas = $conexion->affected_rows;
		return $afectadas !== -1 ? $afectadas : NULL;
	}

	/**
	 * Busca la existencia de un registro
	 * @param string $sql Una sentencia SELECT
	 * @return null|int Retorna el número de filas encontradas. Retorna NULL si algo falla
	 */
	function consulta(string $sql):?int {
		global $conexion;
		$resultado = $conexion->query($sql);
		return $resultado ? $resultado->num_rows : NULL;
	}

	/*=================================================================
	=            MUESTRA UN ERROR POR ALERTA Y POR CONSOLA            =
	=================================================================*/
	// Debe ser llamado dentro de una etiqueta <script></script>
	function getSQLError():string{
		global $conexion;
		return "
			console.log(\"" . mysqli_error($conexion) . "\");
			alerta('Ha ocurrido un error, por favor intente nuevamente')
		";
	}

	/*================================================
	=            MUESTRA REGISTRO EXITOSO            =
	================================================*/
	function registroExitoso(){
		return "
			<script>
				notificacion('Registro Exitoso', false);
			</script>
		";
	}

	/**
	 * RETORNA LA HORA Y FECHA FORMATEADA
	 * @return string La hora y fecha actual en formato `DD-MM-YYYY, hh:mm:ss`
	 */
	function getHora():string {
		date_default_timezone_set('America/Caracas');
		return date('d-m-Y, h:i a');
	}

	/**
	 * RETORNA LA ULTIMA VERSIÓN DE LA APLICACIÓN
	 * @return string La version más reciente
	 */
	function getUltimaVersion():string {
		$version = getRegistro('SELECT * FROM versiones ORDER BY id_v DESC LIMIT 1');
		return $version['nombre_v'];
	}

	/**
	 * RETORNA EL ID DEL ÚLTIMO NEGOCIO REGISTRADO
	 * @return int El ID del último negocio en la BD
	 */
	function getUltimoNegocio():int {
		$id = getRegistro('SELECT * FROM negocio ORDER BY id_n DESC LIMIT 1');
		return (int) $id['id_n'];
	}

	/**
	 * OBTIENE EL MÁS RECIENTE IVA REGISTRADO
	 * @return float El valor del más reciente IVA registrado
	 */
	function getIVA():float{
		$iva = getRegistro("SELECT * FROM iva ORDER BY fecha_iva DESC LIMIT 1");
		return (float) $iva["iva"];
	}

	/**
	 * OBTIENE EL MÁS RECIENTE VALOR DEL DÓLAR REGISTRADO
	 * @return float El más reciente valor del dolar en la BD
	 */
	function getDolar():float {
		$dolar = getRegistro('SELECT * FROM dolar ORDER BY fecha_dolar DESC LIMIT 1');
		return (float) $dolar['dolar'];
	}

	/**
	 * OBTIENE EL MÁS RECIENTE VALOR DEL PESO REGISTRADO
	 * @return float El más reciente valor del peso en la BD
	 */
	function getPeso():float{
		$peso = getRegistro('SELECT * FROM peso ORDER BY fecha_peso DESC LIMIT 1');
		return (int) $peso['peso'];
	}

	/**
	 * Cambia cada inicial a mayúscula
	 * @param string $string El string a capitalizar
	 */
	function capitalize(string $string):string {
		return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
	}

	/**
	 * LIMPIA UN STRING DE CARACTERES INDESEADOS
	 * @param string $string El string a limpiar
	 */
	function ESCAPAR(string $string):string {
		global $conexion;
		$string = $conexion->real_escape_string($string);
		$string = quotemeta($string);
		$string = strip_tags($string);
		return $string;
	}

	/**
	 * RETORNA EL NÚMERO DE REGISTROS DE UNA TABLA
	 * @param  string $tabla La tabla a consultar
	 * @return int        El número de filas de la tabla
	 */
	function contarRegistros(string $tabla):int {
		global $conexion;
		$resultado = $conexion->query("SELECT COUNT(*) FROM $tabla");
		$resultado = $resultado->fetch_row();
		return (int) $resultado[0];
	}

	/**
	 * Encripta cualquier texto
	 * @param string $texto El texto a encriptar
	 * @return string El string encriptado
	 */
	function encriptar(string $texto):string {
		return password_hash($texto, PASSWORD_DEFAULT);
	}

	/**
	 * RETORNA LA HORA Y FECHA ACTUAL PARA PRESENTACION
	 * @return string La fecha y hora actual
	 */
	function FECHA():string {
		date_default_timezone_set("America/Caracas");
		$semana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
		$meses = ["Diciembre", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre"];
		return $semana[date("w")] . " " . date("d") . " de " . $meses[date("n")] . " del " . date("Y");
	}

	/**
	 * FORMATEA UNA CANTIDAD MONETARIA PARA MEJOR PRESENTACIÓN
	 * @param  int|float $cantidad La cantidad a formatear
	 * @return int|float           La cantidad formateada
	 */
	function formatMoney($cantidad){
		$cantidad = number_format($cantidad, 0, ',', '.');
		return $cantidad;
	}
?>