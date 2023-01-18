<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/componentes.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		/**
		 * Genera un resúmen de gastos/ingresos filtrado.
		 * @param  string $rol       El filtro a aplicar: 'diario', 'semanal', 'quincenal', 'mensual'
		 * @param  int    $negocioID El ID del negocio que posee los registros.
		 * @return void            Devuelve al cliente la respuesta a su petición.
		 */
		function generarResumen(string $rol, int $negocioID) {
			global $respuesta;
			$sql = <<<SQL
				SELECT v.producto_id, v.fecha, i.producto, v.unidades, v.total
				FROM ventas v INNER JOIN inventario i ON v.producto_id=i.id
				WHERE v.negocio_id=$negocioID ORDER BY i.producto DESC
			SQL;
			$ventas = getRegistros($sql);
			$ventas = filtrarFecha($rol, $ventas);
			
			$ventasCombinadas = [];
			foreach ($ventas as $venta):
				$id = $venta['producto_id'];
				if (!array_key_exists($id, $ventasCombinadas)):
					$ventasCombinadas[$id] = $venta;
				else:
					$ventasCombinadas[$id]['unidades'] += $venta['unidades'];
					$ventasCombinadas[$id]['total'] += $venta['total'];
				endif;
			endforeach;
			
			$totalGastos = 0;
			$totalIngresos = 0;
			$ganancia = 0;
			$filasProductos = '';
			foreach ($ventasCombinadas as $venta):
				$sql = <<<SQL
					SELECT producto_id, unidades, total, fecha FROM compras
					WHERE producto_id={$venta['producto_id']} AND negocio_id=$negocioID
				SQL;
				$compras = getRegistros($sql);
				$compras = filtrarFecha($rol, $compras);
				$comprasCombinadas = [];
				foreach ($compras as $compra):
					$id = $compra['producto_id'];
					if (!array_key_exists($id, $comprasCombinadas)):
						$comprasCombinadas[$id] = $compra;
					else:
						$comprasCombinadas[$id]['unidades'] += $compra['unidades'];
						$comprasCombinadas[$id]['total'] += $compra['total'];
					endif;
				endforeach;
				$compra = !empty($comprasCombinadas[$id])
					? $comprasCombinadas[$id]
					: ['total' => 0, 'unidades' => 0];
				$compra['total'] = (float) $compra['total'];
				$venta['total'] = (float) $venta['total'];
				
				$totalGastos += $compra['total'];
				$totalIngresos += $venta['total'];
				
				$filasProductos .= <<<HTML
					<tr>
						<td>{$compra['unidades']}</td>
						<td>{$venta['unidades']}</td>
						<td>{$venta['producto']}</td>
						<td>{$compra['total']}</td>
						<td>{$venta['total']}</td>
					</tr>
				HTML;
			endforeach;
			
			$ganancia = $totalIngresos - $totalGastos;
			$textoGanancia = $ganancia >= 0
				? <<<HTML
					<b class="w3-margin-right">Ganancias: </b>
					<i class="icon-dollar w3-text-green"></i>
					$ganancia
				HTML
				: <<<HTML
					<b class="w3-margin-right">Pérdidas: </b>
					<i class="icon-dollar w3-text-red"></i>
					$ganancia
				HTML;
			
			$respuesta['ok'] = $filasProductos;
			$respuesta['datos'] = [
				'gastos' => $totalGastos,
				'ingresos' => $totalIngresos,
				'ganancia' => $textoGanancia
			];
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		}
		
		/*=======================================
		=            RESUMEN VARIABLE           =
		=======================================*/
		if (!empty($_GET['rol'])):
			$negocioID = (int) escapar($_GET['negocioID']);
			switch ($_GET['rol']):
				case 'diario':
					generarResumen('diario', $negocioID);
					break;
				case 'semanal':
					generarResumen('semanal', $negocioID);
					break;
				case 'quincenal':
					generarResumen('quincenal', $negocioID);
					break;
				case 'mensual':
					generarResumen('mensual', $negocioID);
					break;
			endswitch;
		endif;
		
		/*=========================================
		=            VISTA POR DEFECTO            =
		=========================================*/
		$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
		
		echo LOADER;
		echo '<div id="moduloFinanzas" class="w3-center">';
		
		$botones = '';
		$paneles = '';
		foreach ($negocios as $negocio):
			/*----------  BOTONES NEGOCIOS  ----------*/
			$negocioActivo = $negocio['id'] === $_SESSION['negocioID']
				? 'w3-blue'
				: 'w3-white';
			$botones .= <<<HTML
				<li role="botonPanel" data-target="#panelNegocio{$negocio['id']}" class="w3-card w3-col s6 m4 w3-button w3-border-left w3-border-right $negocioActivo">
					<i class="icon-building w3-xlarge"></i>
					<div>{$negocio['nombre']}</div>
				</li>
			HTML;
			
			/*----------  TABLA  ----------*/
			// Obtenemos las ventas y aplicamos filtro diario por defecto.
			$sql = <<<SQL
				SELECT v.producto_id, v.fecha, i.producto, v.unidades, v.total
				FROM ventas v INNER JOIN inventario i ON v.producto_id=i.id
				WHERE v.negocio_id={$negocio['id']} ORDER BY i.producto DESC
			SQL;
			$ventas = getRegistros($sql);
			$ventas = filtrarFecha('diario', $ventas);
			
			$ventasCombinadas = [];
			foreach ($ventas as $venta):
				$id = $venta['producto_id'];
				if (!array_key_exists($id, $ventasCombinadas)):
					$ventasCombinadas[$id] = $venta;
				else:
					$ventasCombinadas[$id]['unidades'] += $venta['unidades'];
					$ventasCombinadas[$id]['total'] += $venta['total'];
				endif;
			endforeach;
			
			$totalGastos = 0;
			$totalIngresos = 0;
			$ganancia = 0;
			$filasProductos = '';
			foreach ($ventasCombinadas as $venta):
				$sql = <<<SQL
					SELECT producto_id, unidades, total, fecha FROM compras
					WHERE producto_id={$venta['producto_id']} AND negocio_id={$negocio['id']}
				SQL;
				$compras = getRegistros($sql);
				$compras = filtrarFecha('diario', $compras);
				$comprasCombinadas = [];
				foreach ($compras as $compra):
					$id = $compra['producto_id'];
					if (!array_key_exists($id, $comprasCombinadas)):
						$comprasCombinadas[$id] = $compra;
					else:
						$comprasCombinadas[$id]['unidades'] += $compra['unidades'];
						$comprasCombinadas[$id]['total'] += $compra['total'];
					endif;
				endforeach;
				$compra = !empty($comprasCombinadas[$id])
					? $comprasCombinadas[$id]
					: ['total' => 0, 'unidades' => 0];
				$compra['total'] = (float) $compra['total'];
				$venta['total'] = (float) $venta['total'];
				
				$totalGastos += $compra['total'];
				$totalIngresos += $venta['total'];
				
				$filasProductos .= <<<HTML
					<tr class="w3-animate-opacity">
						<td>{$compra['unidades']}</td>
						<td>{$venta['unidades']}</td>
						<td>{$venta['producto']}</td>
						<td>{$compra['total']}</td>
						<td>{$venta['total']}</td>
					</tr>
				HTML;
			endforeach;
			
			$ganancia = $totalIngresos - $totalGastos;
			$textoGanancia = $ganancia >= 0
				? <<<HTML
					<b class="w3-margin-right">Ganancias: </b>
					<i class="icon-dollar w3-text-green"></i>
					$ganancia
				HTML
				: <<<HTML
					<b class="w3-margin-right">Pérdidas: </b>
					<i class="icon-dollar w3-text-red"></i>
					$ganancia
				HTML;
			
			$tooltipCompradas = generarTooltip('Unidades compradas');
			$tooltipVendidas = generarTooltip('Unidades vendidas');
			
			$panelActivo = $negocio['id'] === $_SESSION['negocioID']
				? 'w3-show-inline-block'
				: 'w3-hide';
			$paneles .= <<<HTML
				<div id="panelNegocio{$negocio['id']}" role="panel" class="w3-panel w3-card w3-white $panelActivo" style="width: 100%">
					<form class="w3-center">
						<div class="w3-padding w3-row w3-left-align">
							<div class="w3-col s6 m3">
								<input type="radio" name="periodo" id="diario{$negocio['id']}" negocio-id="{$negocio['id']}" checked class="w3-radio">
								<label for="diario{$negocio['id']}">Diario</label>
							</div>
							<div class="w3-col s6 m3">
								<input type="radio" name="periodo" id="semanal{$negocio['id']}" negocio-id="{$negocio['id']}" class="w3-radio">
								<label for="semanal{$negocio['id']}">Semanal</label>
							</div>
							<div class="w3-col s6 m3">
								<input type="radio" name="periodo" id="quincenal{$negocio['id']}" negocio-id="{$negocio['id']}" class="w3-radio">
								<label for="quincenal{$negocio['id']}">Quincenal</label>
							</div>
							<div class="w3-col s6 m3">
								<input type="radio" name="periodo" id="mensual{$negocio['id']}" negocio-id="{$negocio['id']}" class="w3-radio">
								<label for="mensual{$negocio['id']}">Mensual</label>
							</div>
						</div>
					</form>
					<div class="w3-responsive w3-padding-top-24 w3-topbar w3-margin-bottom">
						<table class="w3-table-all w3-centered w3-hoverable">
							<tr class="w3-blue">
								<th class="tooltip-container">
									UC
									$tooltipCompradas
								</th>
								<th class="tooltip-container">
									UV
									$tooltipVendidas
								</th>
								<th>Producto</th>
								<th class="w3-red">Gastos</th>
								<th class="w3-green">Ingresos</th>
							</tr>
							$filasProductos
							<tr class="w3-blue w3-animate-opacity">
								<td colspan="3">TOTAL:</td>
								<td class="w3-red">$totalGastos</td>
								<td class="w3-green">$totalIngresos</td>
							</tr>
						</table>
						<div class="w3-panel w3-xxlarge w3-right-align oswald">
							$textoGanancia
						</div>
					</div>
				</div>
			HTML;
		endforeach;
		
		/*==================================
		=            ESTRUCTURA            =
		==================================*/
		echo <<<HTML
			<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>
				Resumen Financiero
			</h2>
			<ul class="w3-row w3-margin-top w3-ul w3-small">
				$botones
			</ul>
			$paneles
		HTML;
		
		echo '</div>';
	else:
		include '../templates/head.php';
		$script .= "<script src='{$BASE_URL}js/restringido.js'></script>";
		include '../templates/footer.php';
	endif;
?>