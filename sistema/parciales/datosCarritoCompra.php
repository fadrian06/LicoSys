<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<?php if($_SESSION["cargo"] == "a"): ?>
	<section class="w3-responsive">
		<form method="POST" class="w3-center" id="formCarrito">
			<span class="w3-left icon-cart-arrow-down w3-padding w3-dark-gray w3-xxlarge" style="border-radius:20px 20px 0 0"></span>
			<div class="w3-clear"></div>
			<table class="w3-table w3-centered w3-hoverable">
				<tr class="w3-dark-gray w3-small">
					<th>Producto</th>
					<th>Código</th>
					<th class="w3-hide">Existencia</th>
					<th>Precio ($)</th>
					<th>Cantidad</th>
					<th>Total ($)</th>
				</tr>
				<?php $total = 0; $i = 1; foreach($datosCarrito as $dato): ?>
					<tr>
						<td><input style="width: max-content" class="w3-input w3-center w3-transparent" type="text" name="nombreProducto<?=$i?>" value="<?=$dato['nom_p']?>"></td>
						<td><input style="width: max-content" class="w3-input w3-center w3-transparent" type="text" name="codigo<?=$i?>" value="<?=$dato['cod']?>"></td>
						<td class="w3-hide"><input style="width: max-content" class="w3-input w3-center w3-transparent" type="text" name="stock<?=$i?>" value="<?=$dato['stock']?>"></td>
						<td>
							<div class="tooltip-container">
								<input style="width: max-content" class="w3-input w3-center w3-transparent" type="text" name="precioB<?=$i?>" value="<?=$dato['precio_b']?>">
								<span class="tooltip">
									<b class="w3-block">Bs. <?=round($dato["precio_b"] * getDolar(), 2)?></b>
									<b class="w3-block">Pesos <?=formatMoney($dato["precio_b"] * getPeso())?></b>
								</span>
							</div>
						</td>
						<td><input style="width: max-content" class="w3-input w3-center w3-transparent" type="text" name="cantidad<?=$i?>" value="<?=$dato['cantidad']?>"></td>
						<td class="w3-display-container">
							<div class="tooltip-container">
								<input style="width: max-content" class="w3-input w3-transparent w3-center" type="text" name="precioT<?=$i?>" value="<?=$dato["precio_total"]?>">
								<span class="tooltip">
									<b class="w3-block">Bs. <?=round($dato["precio_total"] * getDolar(), 2)?></b>
									<b class="w3-block">Pesos <?=formatMoney($dato["precio_total"] * getPeso())?></b>
								</span>
							</div>
						</td>
					</tr>
				<?php $total += $dato["precio_total"]; $i++; endforeach; ?>
				<?php if($total): ?>
					<tr class="w3-hover-none">
						<td></td>
						<td></td>
						<td class="w3-hide"></td>
						<td></td>
						<td></td>
						<td class="w3-topbar w3-border-black">
							<div class="tooltip-container">
								<input style="width: max-content" type="text" readonly class="w3-input w3-transparent w3-border-0 w3-center" value="<?=$total?>">
								<span class="tooltip">
									<b class="w3-block">Bs. <?=round($total * getDolar(), 2)?></b>
									<b class="w3-block">Pesos <?=formatMoney($total * getPeso())?></b>
								</span>
							</div>
						</td>
					</tr>
				<?php endif; ?>
			</table>
			<?php if($datosCarrito): ?>
				<input type="submit" name="anular" class="w3-margin w3-button w3-red w3-round-large" value="Anular Compra">
				<input type="submit" name="procesar" class="w3-margin w3-button w3-blue w3-round-large" value="Generar Compra">
			<?php endif; ?>
		</form>
	</section>
	<br>
	<br>
<?php endif ?>