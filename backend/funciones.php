<?php
	/**
	 * Genera una tabla a partir de ciertos parámetros.
	 * @param  array|bool  $datos Lista de registros.
	 * @param  array   $encabezados Encabezados de la tabla.
	 * @param  boolean $desactivar Si desea agregar un botón de desactivar
	 * @param  string  $tabla La tabla a la cual pertenecen los registros.
	 * @param  string  $llavePrimaria El campo PRIMARIO de la tabla.
	 * @param  array   $desactivados Si no desea añadir una tabla con los elementos desactivados, deja este parámetro en FALSE.
	 * @param  boolean $editable Si desea añadir un botón de editar
	 * @param  boolean $factura Si desea añadir un botón de factura
	 */
	function tabla($datos = [], array $encabezados, $desactivar = false, $tabla = '', $llavePrimaria = '', $desactivados = [], $editable = false, $factura = false) {
		echo '
			<div class="w3-padding-large w3-responsive">
				<table class="w3-table w3-centered">
					<tr>
		';
		foreach ($encabezados as $encabezado)
			echo "<th class='w3-border w3-border-black w3-blue'>$encabezado</th>";
		if($desactivar):
			echo '<th></th>';
			$_SESSION['llavePrimaria'] = $llavePrimaria;
			$_SESSION['tabla'] = $tabla;
		endif;
		echo $factura ? '<th></th>' : '';
		echo '</tr>';
		foreach ($datos as $dato):
			echo "
				<tr>
					<form method='POST'>
						<td class='w3-border w3-border-black w3-white'>
							<input style='width: max-content' class='w3-input w3-center w3-border-0 w3-transparent' type='text' readonly name='llavePrimaria' value='$dato[0]'>
						</td>
			";
			$i = 0;
			foreach($encabezados as $encabezado)
				echo "
					<td class='w3-border w3-border-black w3-white'>
						<input style='width: max-content; width: -moz-max-content' class='w3-input w3-center w3-border-0 w3-transparent' readonly value='{$dato[++$i]}'>
					</td>
				";
			if($desactivar or $editable or $factura):
				echo '<td>';
				if ($desactivar) echo '<input class="w3-button w3-red w3-round-xlarge" type="submit" name="desactivar" value="Desactivar">';
				if ($editable && $_SESSION['cargo'] === 'a') echo '<input class="w3-button w3-indigo w3-round-large" type="submit" name="editar" value="Editar"';
				if($factura) echo "<a class='w3-button w3-indigo w3-round-large' name='factura'>Ver Factura</a>";
				echo '</td>';
			endif;
			echo "
					</form>
				</tr>
			";
		endforeach;
		echo "
				</table>
			</div>
		";
		if($desactivados) mostrarDesactivados($desactivados, $encabezados, $tabla, $llavePrimaria);
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

	function mostrarDesactivados(array $datos, array $encabezados/*, string $tabla, string $llavePrimaria*/){
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

	/*======================================================
	=            RESTRINGE ACCESO A UN VENDEDOR            =
	======================================================*/
	function REDIRECCIONAR(){
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

	/*================================================================
	=            MUESTRA VARIABLES EN FORMATO MÁS LEGIBLE            =
	================================================================*/
	/**
	 * Muestra arrays y objetos en formato más legible
	 * @param  iterable $dato
	 */
	function depurar(Iterable $dato){
		$formato = print_r('<pre class="w3-orange w3-padding-large">');
		$formato += print_r($dato);
		$formato += print_r('</pre>');
	}

	/**
	 * Obtener múltiples filas
	 * @param  string $sql La sentencia SELECT
	 * @return array|null Devuelve un array multimensional o NULL dependiendo si encuentra coincidencias.
	 */
	function getRegistros(string $sql): ?array {
		global $conexion;
		$resultado = $conexion->query($sql);
		return $resultado ? $resultado->fetch_all(MYSQLI_BOTH) : NULL;
	}

	/**
	 * Obtener una fila
	 * @param  string $sql Sentencia SELECT
	 * @return array Un array asociativo con los datos o [].
	 */
	function getRegistro(string $sql): ?array {
		global $conexion;
		$resultado = $conexion->query($sql);
		return $resultado ? $resultado->fetch_assoc() : NULL;
	}

	/**
	 * Crear, actualizar o eliminar una fila
	 * @param string $sql Sentencia `INSERT, UPDATE o DELETE`.
	 * @return int|null Retorna el número de filas afectadas o `NULL` en caso
	 * de error, para ver el error utilice `$conexion->error`. 
	 */
	function setRegistro(string $sql):?int {
		global $conexion;
		$conexion->query($sql);
		$afectadas = $conexion->affected_rows;
		return $afectadas != -1 ? $afectadas : NULL;
	}

	/*====================================
	=            CONTAR FILAS            =
	====================================*/
	// Requiere una sentencia SQL
	// Devuelve un entero si encuentra filas
	// Devuelve NULL en caso de error
	/**
	 * Contar filas.
	 * @param  string $sql Sentencia SELECT.
	 * @return int|null Retorna el número de filas encontrada, o NULL si encuentra un error.
	 *  <i>(ver error con `$conexion->error`)</i>
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

	/*======================================================
	=            OBTENER LA FECHA Y HORA ACTUAL            =
	======================================================*/
	function getHora() {
		date_default_timezone_set("America/Caracas");
		return date("d-m-Y, h:i a");
	}

	/*==================================================================
	=            OBTENER LA ÚLTIMA VERSIÓN DE LA APLICACIÓN            =
	==================================================================*/
	/**
	 * Obtener la última versión de la aplicación
	 * @return string Cadena que representa la última versión registrada.
	 */
	function getUltimaVersion():string {
		$version = getRegistro('SELECT nombre FROM versiones ORDER BY id DESC LIMIT 1');
		return $version['nombre'];
	}

	/*===================================================================
	=            OBTENER EL ID DEL ÚLTIMO NEGOCIO REGISTRADO            =
	===================================================================*/
	// Se utiliza por ejemplo para insertar un logo a un nuevo negocio
	/**
	 * Obtener el ID del último negocio registrado
	 * @return int|null Retorna el ID o NULL si no existen negocios.
	 */
	function getUltimoNegocio():?int {
		$id = getRegistro('SELECT * FROM negocios ORDER BY id DESC LIMIT 1');
		return (int) $id['id'] ?? null;
	}

	/**
	 * Obtener el más reciente IVA registrado.
	 * @return float|string El valor del IVA en formato `0.nn`.
	 */
	function getIVA() {
		$iva = getRegistro('SELECT * FROM iva ORDER BY fecha DESC LIMIT 1');
		return $iva && $iva['valor'] ? (float) $iva['valor'] : 'No establecido';
	}

	/**
	 * Obtener la más reciente tasa del dólar registrada.
	 * @return float|string La tasa del dolar.
	 */
	function getDolar() {
		$dolar = getRegistro('SELECT * FROM dolar ORDER BY fecha DESC LIMIT 1');
		return $dolar && $dolar['valor'] ? (float) $dolar['valor'] : 'No establecido';
	}
	
	/**
	 * Obtener la más reciente tasa de cambio Dolar/Peso registrada.
	 * @return int|string La tasa de cambio Dolar/Peso
	 */
	function getPeso() {
		$peso = getRegistro('SELECT * FROM peso ORDER BY fecha DESC LIMIT 1');
		return $peso && $peso['valor'] ? (int) $peso['valor'] : 'No establecido';
	}

	/**
	 * Cambia cada inicial a mayúscula
	 * @param string $texto
	 */
	function capitalize(string $texto):string {
		return mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');
	}

	/**
	 * Escapar caracteres indeseados
	 * @param  string $texto
	 * @return string El `texto` con caracteres especiales escapados como `'' ""`
	 * y etiquetas.
	 */
	function escapar(string $texto):string {
		global $conexion;
		$texto = $conexion->real_escape_string($texto);
		$texto = quotemeta($texto);
		$texto = strip_tags($texto);
		return $texto;
	}

	/*=================================================
	=            CUENTA FILAS DE UNA TABLA            =
	=================================================*/
	/**
	 * Cuentas las filas en una tabla.
	 * @param  string $tabla La tabla a buscar (negocios | usuarios | versiones)
	 * @return ínt|null El número de registros. Retorna NULL si la tabla no existe.
	 */
	function contarRegistros(string $tabla):?int {
		global $conexion;
		$resultado = $conexion->query("SELECT COUNT(*) FROM $tabla");
		return $resultado ? (int) $resultado->fetch_row()[0] : NULL;
	}

	/*================================================
	=            ENCRIPTA CUALQUIER TEXTO            =
	================================================*/
	function encriptar(string $texto):string {
		return password_hash($texto, PASSWORD_DEFAULT);
	}

	/*============================================================
	=            OBTENER UN TEXTO CON LA FECHA ACTUAL            =
	============================================================*/
	/**
	 * Retorna la fecha y hora actual
	 * @return string La fecha y hora formateada.
	 */
	function fecha():string {
		date_default_timezone_set('America/Caracas');
		$dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
		$meses = [1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
			'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
		];
		return $dias[date('w')] . ', ' . date('d') . ' de ' . $meses[date('m')]
			. ' del ' . date('Y');
	}

	/*========================================================
	=            FORMATEAR UNA CANTIDAD MONETARIA            =
	========================================================*/
	function formatMoney($cantidad){
		$cantidad = number_format($cantidad, 0, ",", ".");
		return $cantidad;
	}
	
	/**
	 * Obtiene, respalda y retorna la información de una API
	 * @param  string $url La URL de la API
	 * @param  string $urlJSON La ruta relativa al archivo JSON local.
	 * @return array Un array asociativo con la respuesta de la API.
	 */
	function getAPI(string $url, string $urlJSON):array {
		$data = @file_get_contents($url) ?: @file_get_contents($urlJSON);
		@file_put_contents($urlJSON, $data);
		$data = json_decode($data, true, 512, JSON_INVALID_UTF8_IGNORE);
		
		return $data;
	}
?>