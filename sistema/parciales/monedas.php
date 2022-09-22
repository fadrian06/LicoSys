<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<section class="w3-half w3-container w3-border-bottom w3-padding-24">
	<h5>Datos Financieros</h5>
	<table class="w3-table w3-bordered w3-border w3-hoverable w3-white">
		<tr>
			<td>IVA</td>
			<td><b><?=getIva() * 100?>%</b></td>
			<td></td>
		</tr>
		<tr>
			<td>DÓLAR</td>
			<td><b id="dolar"><i>Bs. </i><?=getDolar()?></b></td>
			<td><b id="peso"><?=getPeso()?><i> Pesos</i></b></td>
		</tr>
	</table>
	<?php if($_SESSION["cargo"] == "a"):?>
		<button class="w3-margin w3-button w3-dark-grey" id="actualizarMonedas">Actualizar &blacktriangleright;</button>
	<?php endif; ?>
</section>