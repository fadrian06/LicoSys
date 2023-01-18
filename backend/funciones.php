<?php
	
	/**
	 * Genera una tabla con los datos que le proporcionen.
	 * @param string $titulo El título de la tabla.
	 * @param array $encabezados Debe tener la siguiente estructura: <br><br>
	 * [<br>
	 * &nbsp;'escritorio' => [...Campos a mostrar en escritorio y tablet],<br>
	 * &nbsp;'movil' => [...Campos a mostrar en móvil]<br>
	 * ]
	 * @param array $datos Debe tener la siguiente estructura: <br><br>
	 * [<br>
	 * &nbsp;'camposEscritorio' => [...Campos de la tabla],<br>
	 * &nbsp;'camposMovil' => [...Campos de la tabla],<br>
	 * &nbsp;'filas' => [...Filas que debe mostrar la tabla]<br>
	 * ]
	 * @param string $sinRegistros Texto a mostrar cuando no existan filas.
	 * @param array|bool $desactivar FALSE si no quieres la funcionalidad de desactivar un registro,
	 * si es un array debe tener la siguiente estructura: <br><br>
	 * [<br>
	 * &nbsp;'tabla' => 'Tabla a la cual pertenecen los registros',<br>
	 * &nbsp;'campo' => 'El campo que identifica cada registro',<br>
	 * &nbsp;'enlace' => 'El HREF del enlace a clickear al activar o desactivar',<br>
	 * &nbsp;'filas' => [...Filas de registros desactivados]<br>
	 * ]
	 * @param array|bool $actualizar FALSE si no quieres la funcionalidad de editar un registro,
	 * si es un array debe tener la siguiente estructura: <br><br>
	 * [<br>
	 * &nbsp;'tabla' => 'Tabla a la cual pertenecen los registros',<br>
	 * &nbsp;'campo' => 'El campo que identifica cada registro',<br>
	 * &nbsp;'enlace' => 'El HREF del enlace a clickear tras actualizar.',<br>
	 * &nbsp;'IDform' => 'El ID del formulario para editar registros (incluido el #).',<br>
	 * ]
	 * @param array|bool $factura FALSE si no quieres la funcionalidad de VER FACTURA (Sólo para ventas y compras)
	 * @return true La tabla se ha impreso con éxito.
	 */
	function tabla(string $titulo, array $encabezados, array $datos, string $sinRegistros = '', $desactivar = false, $actualizar = false, $factura = false): bool {
		$filasEscritorio = '';
		$filasMovil = '';
		$filasDesactivadosEscritorio = '';
		$filasDesactivadosMovil = '';
		$encabezadosEscritorio = '';
		$encabezadosMovil = '';
		$encabezadosDesactivadosMovil = '';
				
		if (!$datos['filas'] and empty($desactivar['filas'])):
			print <<<HTML
				<h2 class="w3-display-middle w3-container w3-center w3-opacity">
					$sinRegistros
				</h2>
			HTML;
			return true;
		endif;
		
		// Rellenamos los encabezados en escritorio.
		foreach ($encabezados['escritorio'] as $encabezado)
			$encabezadosEscritorio .= <<<HTML
				<th>$encabezado</th>
			HTML;
		if ($desactivar) $encabezadosEscritorio .= '<th></th>';
		if ($actualizar) $encabezadosEscritorio .= '<th></th>';
		if ($factura) $encabezadosEscritorio .= '<th></th>';
		
		// Rellenamos lo encabezados en móvil.
		foreach ($encabezados['movil'] as $encabezado)
			$encabezadosMovil .= <<<HTML
				<div class="w3-padding w3-col s5 w3-indigo">
					<b>$encabezado</b>
				</div>
			HTML;
		
		// Rellenamos lo encabezados en móvil.
		foreach ($encabezados['movil'] as $encabezado)
			$encabezadosDesactivadosMovil .= <<<HTML
				<div class="w3-padding w3-col s5 w3-red">
					<b>$encabezado</b>
				</div>
			HTML;
		
		// Rellenamos las filas en escritorio.
		foreach ($datos['filas'] as $fila):
			$campos = '';
			foreach ($datos['camposEscritorio'] as $campo)
				$campos .= <<<HTML
					<td>
						<span class="w3-button w3-transparent w3-hover-none" style="padding-left: 0; padding-right: 0">
							$fila[$campo]
						</span>
					</td>
				HTML;
			
			if ($desactivar)
				$campos .= <<<HTML
					<td>
						<button onclick="desactivar('{$desactivar['tabla']}', '{$desactivar['campo']}', {$fila[$desactivar['campo']]}, '{$desactivar['enlace']}')" class="w3-button w3-round-xlarge w3-red w3-hover-black">
							Desactivar
						</button>
					</td>
				HTML;
			
			if ($actualizar && $_SESSION['cargo'] === 'a')
				$campos .= <<<HTML
					<td>
						<button onclick="editar(this, '{$actualizar['tabla']}', '{$actualizar['campo']}', {$fila[$actualizar['campo']]}, '{$actualizar['enlace']}')" data-target="{$actualizar['IDform']}" class="w3-button w3-round-xlarge w3-blue w3-hover-black">
							Editar
						</button>
					</td>
				HTML;
			
			if ($factura)
				$campos .= <<<HTML
					<td>
						<button onclick="verFacturaVenta(this, '{$fila['id']}')" data-target="#modalFactura" class="w3-button w3-round-xlarge w3-blue w3-hover-black">
							Ver factura
						</button>
					</td>
				HTML;
			
			$filasEscritorio .= <<<HTML
				<tr>$campos</tr>
			HTML;
		endforeach;
		
		// Rellenamos las filas en móvil.
		foreach ($datos['filas'] as $fila):
			$campos = '';
			$verMas = '';
			foreach ($datos['camposMovil'] as $campo)
				$campos .= <<<HTML
					<div class="w3-col s5">$fila[$campo]</div>
				HTML;
			
			$cantidadDatosVerMas = count($datos['camposEscritorio']);
			for ($i = 0; $i < $cantidadDatosVerMas; ++$i)
				$verMas .= <<<HTML
					<li class="w3-block w3-row-padding w3-border-bottom w3-border-black">
						<div class="w3-col s4">
							<b class="w3-tag">{$encabezados['escritorio'][$i]}:</b>
						</div>
						<div class="w3-rest">
							<span>{$fila[$datos['camposEscritorio'][$i]]}</span>
						</div>
					</li>
				HTML;
			
			if ($desactivar)
				$verMas .= <<<HTML
					<li class="w3-block">
						<div class=w3-container>
							<button onclick="desactivar('{$desactivar['tabla']}', '{$desactivar['campo']}', {$fila[$desactivar['campo']]}, '{$desactivar['enlace']}')" class="w3-block w3-button w3-round-xlarge w3-red w3-hover-black">
								Desactivar
							</button>
						</div>
					</li>
				HTML;
			
			if ($actualizar && $_SESSION['cargo'] === 'a')
				$verMas .= <<<HTML
					<li class="w3-block">
						<div class=w3-container>
							<button onclick="editar(this, '{$actualizar['tabla']}', '{$actualizar['campo']}', {$fila[$actualizar['campo']]}, '{$actualizar['enlace']}')" data-target="{$actualizar['IDform']}" class="w3-block w3-button w3-round-xlarge w3-blue w3-hover-black">
								Editar
							</button>
						</div>
					</li>
				HTML;
			
			if ($factura)
				$verMas .= <<<HTML
					<li class="w3-block">
						<div class=w3-container>
							<button onclick="verFacturaVenta(this, '{$fila['id']}')" data-target="#modalFactura" class="w3-block w3-button w3-round-xlarge w3-blue w3-hover-black">
								Ver factura
							</button>
						</div>
					</li>
				HTML;
			
			$filasMovil .= <<<HTML
				<div role="accordion">
					<button class="w3-block w3-button w3-row w3-center">
						$campos
						<div class="w3-rest">
							<i class="icon-chevron-right"></i>
						</div>
					</button>
					<div class="w3-hide w3-animate-opacity">
						<ul class="w3-ul w3-grey">
							$verMas
						</ul>
					</div>
				</div>
			HTML;
		endforeach;
		
		// Rellenamos las filas de desactivados en escritorio.
		if ($desactivar):
			foreach ($desactivar['filas'] as $fila):
				$campos = '';
				foreach ($datos['camposEscritorio'] as $campo)
					$campos .= <<<HTML
						<td>
							<span class="w3-button w3-transparent w3-hover-none" style="padding-left: 0; padding-right: 0">
								$fila[$campo]
							</span>
						</td>
					HTML;
				
				if ($desactivar)
					$campos .= <<<HTML
						<td>
							<button onclick="activar('{$desactivar['tabla']}', '{$desactivar['campo']}', '{$fila[$desactivar['campo']]}', '{$desactivar['enlace']}')" class="w3-button w3-round-xlarge w3-green w3-hover-black">
								Activar
							</button>
						</td>
					HTML;
				
				$filasDesactivadosEscritorio .= <<<HTML
					<tr class="w3-left-align">$campos</tr>
				HTML;
			endforeach;
			
			// Rellenamos las filas en móvil.
			foreach ($desactivar['filas'] as $fila):
				$campos = '';
				$verMas = '';
				foreach ($datos['camposMovil'] as $campo)
					$campos .= <<<HTML
						<div class="w3-col s5">$fila[$campo]</div>
					HTML;
				
				$cantidadDatosVerMas = count($datos['camposEscritorio']);
				for ($i = 0; $i < $cantidadDatosVerMas; ++$i)
					$verMas .= <<<HTML
						<li class="w3-block w3-row-padding w3-border-bottom w3-border-black">
							<div class="w3-col s4">
								<b class="w3-tag">{$encabezados['escritorio'][$i]}:</b>
							</div>
							<div class="w3-rest">
								<span>{$fila[$datos['camposEscritorio'][$i]]}</span>
							</div>
						</li>
					HTML;
				
				if ($desactivar)
					$verMas .= <<<HTML
						<li class="w3-block">
							<div class=w3-container>
								<button onclick="activar('{$desactivar['tabla']}', '{$desactivar['campo']}', '{$fila[$desactivar['campo']]}', '{$desactivar['enlace']}')" class="w3-block w3-button w3-round-xlarge w3-green w3-hover-black">
									Activar
								</button>
							</div>
						</li>
					HTML;
				
				$filasDesactivadosMovil .= <<<HTML
					<div role="accordion">
						<button class="w3-block w3-button w3-row w3-center">
							$campos
							<div class="w3-rest">
								<i class="icon-chevron-right"></i>
							</div>
						</button>
						<div class="w3-hide w3-animate-opacity">
							<ul class="w3-ul w3-grey">
								$verMas
							</ul>
						</div>
					</div>
				HTML;
			endforeach;
		endif;
		
		/*==================================================
		=            ESTRUCTURA TABLA ACTIVADOS            =
		==================================================*/
		if ($datos['filas'])
			echo <<<HTML
				<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>$titulo</h2>
				<div class="w3-animate-opacity w3-margin-top w3-margin-bottom w3-card-4 w3-responsive">
					<table class="w3-table-all w3-hoverable w3-hide-small">
						<tr class="w3-indigo">$encabezadosEscritorio</tr>
						$filasEscritorio
					</table>
					<div class="w3-hide-medium w3-hide-large">
						<div class="w3-row w3-center">
							$encabezadosMovil
							<div class="w3-padding w3-rest w3-indigo">
								<b style="opacity: 0">Ver</b>
							</div>
						</div>
						<div role="accordions">
							$filasMovil
						</div>
					</div>
				</div>
			HTML;
		
		/*=====================================================
		=            ESTRUCTURA TABLA DESACTIVADOS            =
		=====================================================*/
		if ($desactivar['filas']):
			$cantidadDesactivados = count($desactivar['filas']);
			echo <<<HTML
				<br>
				<details class="w3-margin-top">
					<summary class="w3-xlarge w3-padding">
						<i class="icon-lock"> Desactivados</i>
						<span class="w3-badge w3-margin-left">$cantidadDesactivados</span>
						<i class="icon-chevron-right w3-margin-left"></i>
					</summary>
					<div class="w3-margin w3-card-4 w3-responsive">
						<table class="w3-table w3-table-all w3-hoverable w3-hide-small">
							<tr class="w3-red">
								$encabezadosEscritorio
							</tr>
							$filasDesactivadosEscritorio
						</table>
					</div>
					<div class="w3-card-4 w3-hide-medium w3-hide-large">
						<div class="w3-row w3-center">
							$encabezadosDesactivadosMovil
							<div class="w3-padding w3-rest w3-red">
								<b style="opacity: 0">Ver</b>
							</div>
						</div>
						<div role="accordions">
							$filasDesactivadosMovil
						</div>
					</div>
				</details>
				<br><br><br><br><br><br><br><br><br><br>
			HTML;
		endif;
		return true;
	}

	/**
	 * Muestra arrays y objetos en formato más legible
	 * @param  iterable $dato
	 */
	function depurar(iterable $dato) {
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
	function setRegistro(string $sql): ?int {
		global $conexion;
		$conexion->query($sql);
		$afectadas = $conexion->affected_rows;
		return $afectadas != -1 ? $afectadas : NULL;
	}

	/**
	 * Contar filas.
	 * @param  string $sql Sentencia SELECT.
	 * @return int|null Retorna el número de filas encontrada, o NULL si encuentra un error.
	 *  <i>(ver error con `$conexion->error`)</i>
	 */
	function consulta(string $sql): ?int {
		global $conexion;
		$resultado = $conexion->query($sql);
		return $resultado ? $resultado->num_rows : NULL;
	}

	// Debe ser llamado dentro de una etiqueta <script></script>
	function getSQLError(): string{
		global $conexion;
		return "
			console.log(\"" . mysqli_error($conexion) . "\");
			alerta('Ha ocurrido un error, por favor intente nuevamente')
		";
	}

	/*======================================================
	=            OBTENER LA FECHA Y HORA ACTUAL            =
	======================================================*/
	function getHora() {
		date_default_timezone_set("America/Caracas");
		return date("d-m-Y, h:i a");
	}

	/**
	 * Obtener la última versión de la aplicación
	 * @return string Cadena que representa la última versión registrada.
	 */
	function getUltimaVersion(): string {
		$version = getRegistro('SELECT nombre FROM versiones ORDER BY id DESC LIMIT 1');
		return $version['nombre'];
	}

	/**
	 * Obtener el ID del último negocio registrado
	 * @return int|null Retorna el ID o NULL si no existen negocios.
	 */
	function getUltimoNegocio(): ?int {
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
	function capitalize(string $texto): string {
		return mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');
	}

	/**
	 * Escapar caracteres indeseados
	 * @param  string $texto
	 * @return string El `texto` con caracteres especiales escapados como `'' ""`
	 * y etiquetas.
	 */
	function escapar(string $texto): string {
		global $conexion;
		$texto = $conexion->real_escape_string($texto);
		$texto = quotemeta($texto);
		$texto = strip_tags($texto);
		return $texto;
	}

	/**
	 * Cuentas las filas en una tabla.
	 * @param  string $tabla La tabla a buscar (negocios | usuarios | versiones)
	 * @return ínt|null El número de registros. Retorna NULL si la tabla no existe.
	 */
	function contarRegistros(string $tabla): ?int {
		global $conexion;
		$resultado = $conexion->query("SELECT COUNT(*) FROM $tabla");
		return $resultado ? (int) $resultado->fetch_row()[0] : NULL;
	}

	/**
	 * Encripta cualquier texto
	 * @param  string $texto El texto a encriptar.
	 * @return string        El texto encriptado.
	 */
	function encriptar(string $texto): string {
		return password_hash($texto, PASSWORD_DEFAULT);
	}

	/**
	 * Retorna la fecha y hora actual
	 * @return string La fecha y hora formateada.
	 */
	function fecha(): string {
		date_default_timezone_set('America/Caracas');
		$dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
		$meses = [1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
			'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
		];
		$diaSemana = (int) date('w');
		$diaActual = (int) date('d');
		$mesActual = (int) date('m');
		$añoActual = (int) date('Y');
		return "$dias[$diaSemana], $diaActual de $meses[$mesActual] del $añoActual";
	}

	/*========================================================
	=            FORMATEAR UNA CANTIDAD MONETARIA            =
	========================================================*/
	function formatMoney($cantidad) {
		$cantidad = number_format($cantidad, 0, ",", ".");
		return $cantidad;
	}
	
	/**
	 * Obtiene, respalda y retorna la información de una API
	 * @param  string $url La URL de la API
	 * @param  string $urlJSON La ruta relativa al archivo JSON local.
	 * @return array Un array asociativo con la respuesta de la API.
	 */
	function getAPI(string $url, string $urlJSON): array {
		$data = @file_get_contents($url) ?: @file_get_contents($urlJSON);
		@file_put_contents($urlJSON, $data);
		$data = json_decode($data, true, 512, JSON_INVALID_UTF8_IGNORE);
		
		return $data;
	}
	
	/**
	 * Elimina los duplicados de una lista de datos.
	 * @param  array  $arrays El array de arrays a procesar.
	 * @param array $clave La clave del arreglo necesaria para detectar duplicados.
	 * @return array Un nuevo arreglo sin elementos duplicados.
	 */
	function eliminarDuplicados(array $arrays, string $clave): array {
		$sinDuplicados = [];
		if (!$arrays) return $sinDuplicados;
		
		foreach($arrays as $array)
			$sinDuplicados[$array[$clave]] = $array;
		
		return $sinDuplicados;
	}
	
	/**
	 * Calcula y retorna la diferencia entre una fecha especificada y la actual.
	 * @param  string $fecha La fecha con la cual calcular la diferencia.
	 * @return array        Un arreglo con la información sobre la diferencia de fechas.
	 */
	function obtenerDiferenciaFecha(string $fecha): array {
		date_default_timezone_set('America/Caracas');
		
		$objetoFecha = DateTime::createFromFormat('Y-m-d H:i:s', $fecha);
		$actual = time();
		$fecha  = $objetoFecha->getTimestamp();
		$diferencia  = $actual - $fecha;
		
		$datetime = [
			'año'      => 0,
			'mes'      => 0,
			'semana'   => 0,
			'dia'      => 0,
			'hora'     => 0,
			'minutos'  => 0,
			'segundos' => $diferencia
		];
		
		$datetime['minutos'] = (int) ($datetime['segundos'] / 60);
		$datetime['segundos'] %= 60;
		
		$datetime['hora'] = (int) ($datetime['minutos'] / 60);
		$datetime['minutos'] %= 60;
		
		$datetime['dia'] = (int) ($datetime['hora'] / 24);
		$datetime['hora'] %= 24;
		
		$datetime['semana'] = (int) ($datetime['dia'] / 7);
		$datetime['dia'] %= 7;
		
		$datetime['mes'] = (int) ($datetime['semana'] / 4);
		$datetime['semana'] %= 4;
		
		$datetime['año'] = (int) ($datetime['mes'] / 12);
		$datetime['mes'] %= 12;
		
		return $datetime;
	}
	
	/**
	 * Formatea la fecha y hora para mayor legibilidad.
	 * @param  string $fecha La fecha a formatear (en formato Y-m-d H:m:s),
	 * ejemplo (2023-01-01 16:43:32)
	 * @return string La fecha formateada.
	 */
	function formatearFecha(string $fecha): string {
		$formateada = 'Hace ';
		$diferencia = obtenerDiferenciaFecha($fecha);
		
		if ($diferencia['mes']):
			
			if ($diferencia['mes'] === 1)
				$formateada .= '1 mes ';
			else $formateada .= "{$diferencia['mes']} meses ";
			
		elseif ($diferencia['semana']):
			
			if ($diferencia['semana'] === 1)
				$formateada .= '1 semana ';
			else $formateada .= "{$diferencia['semana']} semanas ";
			
		elseif ($diferencia['dia']):
			
			if ($diferencia['dia'] === 1)
				$formateada .= '1 día ';
			else $formateada .= "{$diferencia['dia']} días ";
			
		elseif ($diferencia['hora']):
			
			if ($diferencia['hora'] === 1)
				$formateada .= '1 hora ';
			else $formateada .= "{$diferencia['hora']} horas ";
			
		elseif ($diferencia['minutos']):
			if ($diferencia['minutos'] === 1)
				$formateada .= '1 minuto ';
			else $formateada .= "{$diferencia['minutos']} minutos ";
			
		endif;
		
		if ($formateada === 'Hace ')
			$formateada .= 'unos instantes ';
		
		return $formateada;
	}
	
	/**
	 * Filtra elementos en un arreglo con el filtro especificado.
	 * @param  string $filtro 'diario', 'semanal', 'quincenal', 'mensual'
	 * @param  array  $datos  Un arreglo de arreglos que tiene una clave 'fecha'<br>
	 * con el formato 'Y-m-d H:i:s'
	 * @return array El arreglo filtrado.
	 */
	function filtrarFecha(string $filtro, array $datos): array {
		$filtrado = [];
		
		switch ($filtro):
			case 'diario':
				foreach ($datos as $dato):
					$diferencia = obtenerDiferenciaFecha($dato['fecha']);
					// Si no han transcurrido ni un año, ni un mes, ni una semana ni un día
					if (!$diferencia['año']
						and !$diferencia['mes']
						and !$diferencia['semana']
						and !$diferencia['dia']
					) $filtrado[] = $dato;
				endforeach;
				break;
			case 'semanal':
				foreach ($datos as $dato):
					$diferencia = obtenerDiferenciaFecha($dato['fecha']);
					// Si no han transcurrido ni un año, ni un mes, ni una semana
					if (!$diferencia['año']
						and !$diferencia['mes']
						and !$diferencia['semana']
					) $filtrado[] = $dato;
				endforeach;
				break;
			case 'quincenal':
				foreach ($datos as $dato):
					$diferencia = obtenerDiferenciaFecha($dato['fecha']);
					// Si no han transcurrido ni un año, ni un mes y han transcurrido menos
					// de dos semanas
					if (!$diferencia['año']
						and !$diferencia['mes']
						and ($diferencia['semana'] < 2)
					) $filtrado[] = $dato;
				endforeach;
				break;
			case 'mensual':
				foreach ($datos as $dato):
					$diferencia = obtenerDiferenciaFecha($dato['fecha']);
					
					// Si no han transcurrido ni un año ni un mes
					if (!$diferencia['año'] and !$diferencia['mes'])
						$filtrado[] = $dato;
				endforeach;
				break;
		endswitch;
		
		return $filtrado;
	}
?>