<?php
	/*=====================================
	=            GENERAR TABLA            =
	=====================================*/
	// PARÁMETROS
	# $datos       ==> un array multimensional con los datos a imprimir
	# $encabezados ==> un array con los encabezados de la tabla
	# $desactivar  ==> indica si debe incluir un botón de desactivar
	# $tabla       ==> indica la tabla de la cual quieres desactivar
	# $llavePrimaria ==> indica la llave primaria INT o STRING en la cual quieres operar
	# $desactivados ==> un array multimensional que contiene los datos de registros desactivados
	# $editable ==> indica si los registros se pueden EDITAR
	function TABLA(array $datos, array $encabezados, $desactivar = false, $tabla = '', $llavePrimaria = '', array $desactivados = [], $editable = false, $factura = false) {
		echo "
			<div class='w3-padding-large w3-responsive'>
				<table class='w3-table w3-centered'>
					<tr>
		";
		for ($i = 0, $intEncabezados = count($encabezados); $i < $intEncabezados; $i++)
			echo "<th class='w3-border w3-border-black w3-blue'>$encabezados[$i]</th>";
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
			for ($i = 1; $i < $intEncabezados; $i++):
				echo "
				 	<td class='w3-border w3-border-black w3-white'>
				 		<input style='width: max-content' class='w3-input w3-center w3-border-0 w3-transparent' type='text' readonly value='$dato[$i]'>
				 	</td>
				";
			endfor;
			if($desactivar || $editable || $factura):
				echo '<td>';
				if($desactivar) echo "<input class='w3-button w3-red w3-round-xlarge' type='submit' name='desactivar' value='Desactivar'>";
				if($editable && $_SESSION["cargo"] == "a") echo "<input class='w3-button w3-indigo w3-round-large' type='submit' name='editar' value='Editar'";
				if($factura) echo "<a class='w3-button w3-indigo w3-round-large' name='factura'>Ver Factura</a>";
				echo '</td>';
			endif;
			echo "
					</form>
				</tr>";
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

	/*========================================
	=            OBTENER UNA FILA            =
	========================================*/
	// Requiere una sentencia SQL
	// Devuelve un array o NULL dependiendo si encuentra una coincidencia
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

	/*================================================
	=            CREAR/MODIFICAR UNA FILA            =
	================================================*/
	// Requiere una sentencia SQL
	// Devuelve un entero que representa si hay filas afectadas
	// Devuelve NULL en caso de error
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
	function CONSULTA(string $sql):?int {
		global $conexion;
		$resultado = mysqli_query($conexion, $sql);
		return $resultado ? mysqli_num_rows($resultado) : NULL;
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
	function getUltimaVersion(){
		$version = getRegistro("SELECT * FROM versiones ORDER BY id_v DESC LIMIT 1");
		return $version["nombre_v"];
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

	/*==============================================================
	=            OBTENER EL MÁS RECIENTE IVA REGISTRADO            =
	==============================================================*/
	function getIVA():float{
		$iva = getRegistro("SELECT * FROM iva ORDER BY fecha_iva DESC LIMIT 1");
		return (float) $iva["iva"];
	}

	/*==========================================================================
	=            OBTENER EL MÁS RECIENTE VALOR DEL DÓLAR REGISTRADO            =
	==========================================================================*/
	function getDolar():float{
		$dolar = getRegistro("SELECT * FROM dolar ORDER BY fecha_dolar DESC LIMIT 1");
		return (float) $dolar["dolar"];
	}

	/*=========================================================================
	=            OBTENER EL MÁS RECIENTE VALOR DEL PESO REGISTRADO            =
	=========================================================================*/
	function getPeso():float{
		$peso = getRegistro("SELECT * FROM peso ORDER BY fecha_peso DESC LIMIT 1");
		return (int) $peso["peso"];
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
	function contarRegistros(string $tabla):int {
		global $conexion;
		$resultado = mysqli_query($conexion, "SELECT COUNT(*) FROM $tabla");
		$resultado = mysqli_fetch_row($resultado);
		return (int) $resultado[0];
	}

	/*================================================
	=            ENCRIPTA CUALQUIER TEXTO            =
	================================================*/
	function ENCRIPTAR(string $texto):string {
		return password_hash($texto, PASSWORD_DEFAULT);
	}

	/*============================================================
	=            OBTENER UN TEXTO CON LA FECHA ACTUAL            =
	============================================================*/
	function FECHA(){
		date_default_timezone_set("America/Caracas");
		$semana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
		$meses = ["Diciembre", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre"];
		return $semana[date("w")] . " " . date("d") . " de " . $meses[date("n")] . " del " . date("Y");
	}

	/*========================================================
	=            FORMATEAR UNA CANTIDAD MONETARIA            =
	========================================================*/
	function formatMoney($cantidad){
		$cantidad = number_format($cantidad, 0, ",", ".");
		return $cantidad;
	}
?>