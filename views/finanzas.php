<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/componentes.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		$negocios = getRegistros('SELECT * FROM negocios WHERE activo=1');
		
		echo LOADER;
		echo '<div id="moduloFinanzas" class="w3-center">';
		
		$botones = '';
		$paneles = '';
		foreach ($negocios as $negocio):
			$negocioActivo = $negocio['id'] === $_SESSION['negocioID']
				? 'w3-blue'
				: 'w3-white';
			$negocio['logo'] = $negocio['logo']
				? "images/negocios/{$negocio['logo']}"
				: 'images/logoNegocio.jpg';
			$panelActivo = $negocio['id'] === $_SESSION['negocioID']
				? 'w3-show-inline-block'
				: 'w3-hide';
			$botones .= <<<HTML
				<li role="botonPanel" data-target="#panelNegocio{$negocio['id']}" class="w3-card w3-col s4 w3-button w3-border-left w3-border-right $negocioActivo">
					<i class="icon-building w3-xlarge"></i>
					<div>{$negocio['nombre']}</div>
				</li>
			HTML;
			$paneles .= <<<HTML
				<div id="panelNegocio{$negocio['id']}" role="panel" class="w3-panel w3-card w3-white $panelActivo">
					<form class="w3-center">
						<div class="w3-padding">
							<div class="w3-show-inline-block">
								<input type="radio" name="periodo" id="diario" checked class="w3-radio">
								<label for="diario">Diario</label>
							</div>
							<div class="w3-show-inline-block w3-border-left">
								<input type="radio" name="periodo" id="semanal" class="w3-radio">
								<label for="semanal">Semanal</label>
							</div>
							<div class="w3-show-inline-block w3-border-left">
								<input type="radio" name="periodo" id="quincenal" class="w3-radio">
								<label for="quincenal">Quincenal</label>
							</div>
							<div class="w3-show-inline-block w3-border-left">
								<input type="radio" name="periodo" id="mensual" class="w3-radio">
								<label for="mensual">Mensual</label>
							</div>
						</div>
					</form>
					<div class="w3-responsive w3-padding-top-24 w3-topbar w3-margin-bottom">
						<table class="w3-table-all w3-centered w3-hoverable">
							<tr class="w3-blue">
								<th>Unidades</th>
								<th>Productos</th>
								<th class="w3-red">Gastos</th>
								<th class="w3-green">Ingresos</th>
							</tr>
							<tr>
								<td>2</td>
								<td>5 Estrellas</td>
								<td>$ 8</td>
								<td>$ 9</td>
							</tr>
							<tr>
								<td>5</td>
								<td>Sangría</td>
								<td>$ 5</td>
								<td>$ 8</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Macondo</td>
								<td>$ 7</td>
								<td>$ 10</td>
							</tr>
							<tr>
								<td>1</td>
								<td>Vino</td>
								<td>$ 7</td>
								<td>$ 10</td>
							</tr>
							<tr class="w3-blue">
								<td colspan="2">TOTAL:</td>
								<td class="w3-red">$ 26</td>
								<td class="w3-green">$ 38</td>
							</tr>
						</table>
						<div class="w3-panel w3-xxlarge w3-right-align" style="font-family: Oswald">
							<b class="w3-margin-right">Ganancias: </b>
							<i class="icon-dollar w3-text-green"></i>
							10
						</div>
					</div>
				</div>
			HTML;
		endforeach;
		
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