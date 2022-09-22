<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php if($_SESSION["cargo"] == "a"): ?>	
	<section class="w3-section w3-container w3-row">
		<div class="w3-half">
			<h2>Datos de la <b>Compra</b></h2>
			<p class="w3-text-gray"><i class="icon-user w3-text-black"> </i>Comprador</p>
			<span class="w3-text-blue"><?=$_SESSION["nombreUsuario"]?></span>
		</div>
		<?php include_once "parciales/monedas.php" ?>
	</section>
	<section class="w3-responsive">
		<table class="w3-table w3-centered">
			<tr class="w3-dark-gray w3-small">
				<th></th>
				<th>Nombre del Producto</th>
				<th>Código</th>
				<th>Existencia</th>
				<th>Precio ($)</th>
				<th>Cantidad</th>
				<th>Total ($)</th>
				<th></th>
			</tr>
			<tr>
				<td>
					<button id="registrarProducto" class="w3-button w3-green w3-circle w3-large">+</button>
				</td>
				<td style="height: 150px;">
					<div class="w3-dropdown-hover">
						<button class="w3-button w3-grey w3-medium">Seleccionar Producto</button>
						<div style="overflow-y: scroll" class="w3-dropdown-content w3-bar-block w3-card w3-light-grey" id="producto">
							<input class="w3-input w3-padding" type="text" placeholder="Buscar.." id="buscarProducto" onkeyup="filterFunction(this.id, 'producto')">
							<?php foreach($productos as $producto):
								echo "
									<button class='nombreProducto w3-bar-item w3-button'>
										<span>{$producto["nom_p"]}</span>
										<span class='w3-hide'>{$producto["cod"]}</span>
										<span class='w3-hide'>{$producto["stock"]}</span>
										<span class='w3-hide'>$ {$producto["precio_b"]}</span>
										<span class='w3-hide'>{$producto["excento"]}</span>
									</button>
								";
							endforeach;?>
						</div>
					</div>
					<input type="text" name="producto" class="inputProducto w3-margin-top w3-disabled w3-input w3-border w3-border-black" value="<?=isset($nombre) ? $nombre : ""?>">
				</td>
				<form method="POST">
					<td><input class="w3-input w3-center w3-disabled" readonly type="text" name="codigo" value="<?=$codigo ?? ""?>"></td>
					<td><input class="w3-input w3-center w3-disabled" readonly type="text" name="stock" value="<?=$stock ?? ""?>"></td>
					<td>
						<div class="tooltip-container">
							<input class="w3-input w3-center" type="text" name="precioB" value="$ " required pattern="^\$ [\d.]+$" title="Sólo números, un punto y 2 decimales">
							<span class="tooltip">
								<b class="w3-block">Bs. </b>
								<b class="w3-block">Pesos </b>
							</span>
						</div>
					</td>
					<td>
						<input class="w3-input" type="number" name="cantidad" min="1">
					</td>
					<td>
						<input class="w3-input w3-center w3-disabled" readonly type="text" name="precioT" id="precioT">
					</td>
					<td>
						<input type="hidden" name="nombreProducto" class="inputProducto" value="<?=$nombre ?? ""?>">
						<input type="hidden" name="excento" value="<?=$excento ?? ""?>">
						<input class="inputProveedor" name="idProveedor" type="hidden" value="<?=$_SESSION["idProveedor"] ?? ""?>">
						<input class='w3-button w3-blue w3-round-large w3-large w3-hide' type='submit' name='agregarProducto' value="+">
					</td>
				</form>
			</tr>
		</table>
	</section>
<?php endif ?>