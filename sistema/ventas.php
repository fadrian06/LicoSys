<?php require 'parciales/head.php' ?>

	<main class="w3-main">
		<?php if($_SESSION['cargo'] == true):
			$consulta = "SELECT fecha_v, cliente, nom_p, unidades, precio_v, iva, usuario FROM venta INNER JOIN cliente INNER JOIN inventario INNER JOIN usuario ON venta.ci_c=cliente.ci_c AND venta.cod=inventario.cod AND venta.ci_u=usuario.ci_u AND venta.id_n={$_SESSION['idNegocio']}";
			$ventas = getRegistros($consulta);
			$encabezados = ['Fecha', 'Cliente', 'Producto', 'Unidades', 'Precio', 'IVA', 'Usuario'];
			echo '<h2 class="w3-center w3-bottombar w3-border-blue w3-round-medium">Ventas</h2>';
			TABLA($ventas, $encabezados, false, '', '', [], false, true);
		else:
			$restringido = REDIRECCIONAR();
		endif?>
		
		<!-- VER FACTURA -->
		<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalFactura">
			<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
			<h3 class="swal2-title w3-margin-bottom">
				<img src="../dist/images/logo.png" class="w3-margin-right w3-responsive" width="100px">
				Taberna Los 7 Hermanos
			</h3>
			<h4 class="w3-container w3-xlarge w3-right-align w3-blue">Comprobante</h4>
			<div class="w3-margin">
				<h5 class="w3-container w3-xlarge">Datos del cliente:</h5>
				<table class="w3-table-all">
					<tr></tr>
					<tr>
						<th class="w3-tag w3-blue">Nombre:</th>
						<td>Daniel Mancilla</td>
					</tr>
					<tr>
						<th class="w3-tag w3-blue">Cédula:</th>
						<td>28.001.002</td>
					</tr>
				</table>
			</div>
			<div class="w3-responsive w3-margin">
				<h5 class="w3-container w3-xlarge">Datos de la venta</h5>
				<table class="w3-table-all w3-centered">
					<tr class="w3-bottombar">
						<th>Cantidad</th>
						<th>Producto</th>
						<th>Precio unitario</th>
						<th>Monto total</th>
					</tr>
					<tr>
						<td>2</td>
						<td>5 Estrellas</td>
						<td>$8</td>
						<td>$17.5</td>
					</tr>
					<tr>
						<td>5</td>
						<td>Macondo</td>
						<td>$9</td>
						<td>$50.36</td>
					</tr>
				</table>
				<div class="w3-container w3-center w3-padding-top-24 w3-large">
					<div class="w3-left">Total IVA<span class="w3-xlarge">(16%)</span></div>
					<div class="w3-right">Monto total: <span class="icon-dollar w3-text-green w3-xlarge"></span><b class="w3-xlarge">67.86</b></div>
				</div>
				<div class="w3-row w3-padding-top-48">
					<table class="w3-col s8 w3-container w3-left-align">
						<tr>
							<th>Correo:</th>
							<td> correo@correo.com</td>
						</tr>
						<tr>
							<th>Teléfono:</th>
							<td> <span class="icon-whatsapp w3-text-green"> </span>0557-123-1234</td>
						</tr>
					</table>
					<button class="w3-rest w3-auto w3-button w3-blue w3-round-xlarge">
						<i class="icon-save"></i>
						Guardar
					</button>
				</div>
			</div>
		</div>
		
	</main>
<?php require 'parciales/indexModales.php' ?>
<?php require 'parciales/footer.php' ?>