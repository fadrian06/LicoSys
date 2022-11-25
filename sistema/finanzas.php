<?php require 'parciales/head.php' ?>

<main id="finanzas" class="w3-container w3-main w3-center">
	<?php
		if($_SESSION['cargo'] === 'a'):
			echo "<h2 class='w3-center w3-bottombar w3-border-blue w3-round-medium'>Resumen Financiero</h2>";
			$negocios = getRegistros('SELECT * FROM negocio WHERE activo=1');
			echo '<ul class="w3-row w3-margin-top w3-ul w3-card w3-tiny w3-center w3-auto" style="width: max-content; max-width: 100%">';
			foreach($negocios as $negocio):
				$negocioActivo = $_SESSION['idNegocio'] == $negocio['id_n']
					? 'w3-blue'
					: '';
				echo <<<HTML
					<li class="w3-third w3-button w3-border-left w3-border-right $negocioActivo">
						<img src="../dist/images/negocios/{$negocio['foto']}" class="w3-image" style="max-height: 40px; margin-bottom: 5px">
						<div>{$negocio['nom_n']}</div>
					</li>
				HTML;
			endforeach;
			echo '</ul>';
			echo <<<HTML
				<div class="w3-panel w3-card w3-white w3-show-inline-block">
					<form class="w3-center">
						<i class="icon-search w3-xlarge"></i>
						<div class="w3-show-inline-block w3-margin">
							<input type="radio" name="periodo" id="diario" checked class="w3-radio">
							<label for="diario">Diario</label>
						</div>
						<div class="w3-show-inline-block w3-margin">
							<input type="radio" name="periodo" id="semanal" class="w3-radio">
							<label for="semanal">Semanal</label>
						</div>
						<div class="w3-show-inline-block w3-margin">
							<input type="radio" name="periodo" id="quincenal" class="w3-radio">
							<label for="quincenal">Quincenal</label>
						</div>
						<div class="w3-show-inline-block w3-margin">
							<input type="radio" name="periodo" id="mensual" class="w3-radio">
							<label for="mensual">Mensual</label>
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
		else:
			$alerta = REDIRECCIONAR();
		endif
	?>
</main>

<?php
	require 'parciales/indexModales.php';
	require 'parciales/footer.php'
?>