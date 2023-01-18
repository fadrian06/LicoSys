<?php if (isset($_SESSION['activa'])): ?>
	<section class="w3-half w3-container w3-padding-24">
		<h2 class="w3-large">Datos Financieros</h2>
		<table id="tablaMonedas" class="w3-table w3-bordered w3-border w3-hoverable w3-white">
			<tr>
				<td>IVA</td>
				<td colspan="2"><b><?=getIVA() === 'No establecido' ? getIVA() : getIVA() * 100 . '%'?></b></td>
			</tr>
			<tr>
				<td>DÓLAR</td>
				<td>
					<b><?=getDolar() !== 'No establecido' ? '<i>Bs. </i>' . getDolar() : getDolar()?></b>
				</td>
				<?php if (getDolar() !== 'No establecido'): ?>
					<td><b><?=getPeso()?><i> Pesos</i></b></td>
				<?php endif ?>
			</tr>
		</table>
		<?php if($_SESSION['cargo'] === 'a'):
			$textoBoton =
				(is_string(getDolar()) or is_string(getPeso()) or is_string(getIVA()))
					? 'Establecer'
					: 'Actualizar';
			echo <<<HTML
				<div class="w3-padding-large">
					<button onclick="modal(this)" data-target="#actualizarMonedas" class="w3-block w3-button w3-dark-grey">
						$textoBoton
					</button>
				</div>
			HTML;
		endif ?>
	</section>
	<!-- ACTUALIZAR MONEDAS -->
	<?php if($_SESSION['cargo'] === 'a'): ?>
		<form id="actualizarMonedas" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
			<div class="w3-right-align">
				<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
			</div>
			<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
				<?php
					switch ('No establecido'):
						case getIVA():
						case getDolar():
						case getPeso():
							echo 'Establecer Valores';
							break;
						default:
							echo 'Actualizar Valores';
					endswitch
				?>
			</h1>
			<section class="w3-display-container">
				<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
				<?php
					$label = getIVA() !== 'No establecido'
						? 'IVA (Actual): <b>' . getIVA() * 100 . '%</b>'
						: '<b class="w3-block w3-margin-left">Establecer IVA:</b>';
					$value = getIVA() !== 'No establecido'
						? getIVA() * 100
						: '';
					echo generarINPUT('IVA', $label, '', $value);
					
					$label = getDolar() !== 'No establecido'
						? 'DÓLAR: (actual) <b class="w3-block w3-margin-left">Bs. ' . getDolar() . '</b>'
						: '<b class="w3-block w3-margin-left">Establecer DÓLAR (en Bs.)</b>';
					echo generarINPUT('DOLAR', $label, '', getDolar());
					
					$label = getPeso() !== 'No establecido'
						? '<b class="w3-block w3-margin-left">' . getPeso() . ' Pesos</b>'
						: '<b class="w3-block w3-margin-left">Establecer PESO (a pesos)</b>';
					echo generarINPUT('PESO', $label, '', getPeso());
				?>
			</section>
			<section class="w3-panel">
				<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
					<?php
						switch ('No establecido'):
							case getIVA():
							case getDolar():
							case getPeso():
								echo 'Establecer';
								break;
							default:
								echo 'Actualizar';
						endswitch
					?>
			</button>
			</section>
		</form>
	<?php endif ?>
<?php endif ?>