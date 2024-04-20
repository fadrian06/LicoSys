<?php if (isset($mostrarMenu)): ?>
	<!--====================================
	=            BARRA SUPERIOR            =
	=====================================-->
	<header id="encabezado" class="w3-top w3-black w3-large">
		<button class="w3-button w3-hide-large w3-hover-none w3-hover-text-grey">
			<i class="icon-bars"></i> Menú
		</button>
		<div class="w3-container w3-small w3-hide-medium w3-hide-small">
			<?=fecha()?>
		</div>
		<div class="w3-medium w3-hide-small w3-dropdown-hover">
			<button onclick="modal(this)" data-target="#acercaDe" class="w3-button">
				LicoSys <?=getUltimaVersion()?>
			</button>
			<?=generarTooltip('Acerca De')?>
		</div>
		<div class="w3-row">
			<div class="w3-half w3-medium w3-dropdown-hover w3-black">
				<a href="views/nuevaVenta.php" role="navegacion" title="Nueva Venta" class="w3-large w3-button">
					<i class="icon-cart-arrow-down"></i>
					<b id="productosEnCarrito"><?=$productosEnCarrito?></b>
				</a>
				<?=generarTooltip('Carrito de Ventas')?>
			</div>
			<?php
				$tooltipCarritoCompras = generarTooltip('Carrito de Compras');
				if ($_SESSION['cargo'] === 'a')
					echo <<<HTML
						<div class="w3-half w3-medium w3-dropdown-hover w3-black">
							<a href="views/nuevaCompra.php" role="navegacion" title="Nueva Compra" class="w3-large w3-button w3-hide-small">
								<i class="icon-handshake-o"></i>
								<b id="productosEnCarritoCompra">$productosEnCarritoCompra</b>
							</a>
							$tooltipCarritoCompras
						</div>
					HTML;
			?>
		</div>
		<div class="w3-medium w3-dropdown-hover w3-black">
			<a href="dashboard.php" role="navegacion" title="Panel de Administración" class="w3-medium w3-button" style="max-height: 40px">
				<img src="<?="$BASE_URL{$_SESSION['negocioLogo']}"?>" class="w3-image w3-circle" style="height: 25px; width:25px">
				&nbsp;<b id="menuNombreNegocio"><?=$_SESSION['negocio']?></b>
			</a>
			<?=generarTooltip('Panel de Administración')?>
		</div>
	</header>
	<!--==================================
	=            MENÚ LATERAL            =
	===================================-->
	<aside id="menu" class="w3-sidebar w3-collapse w3-white w3-animate-left w3-hide">
		<section class="w3-padding-top-24 w3-black w3-container w3-row w3-border-bottom w3-margin-bottom">
			<a href="views/miPerfil.php" role="navegacion" title="Mi Perfil" class="w3-block w3-col s3">
				<img id="fotoPerfil" src="<?="$BASE_URL{$_SESSION['userFoto']}"?>" class="w3-image w3-circle w3-margin-right w3-padding-small">
			</a>
			<div class="w3-col s9 w3-center">
				<div>
					Bienvenido,
					&nbsp;<b id="menuNombreUsuario"><?=$_SESSION['userName']?></b>
				</div>
				<hr style="margin: 5px">
				<?php
					if (is_float(getDolar()) and is_int(getPeso())):
						echo <<<HTML
							<button onclick="modal(this)" data-target="#conversionMonetaria" title="Calculadora Monetaria" class="w3-button icon-calculator"></button>
						HTML;
						
						$titulo = <<<HTML
							<i class="w3-hide-small icon-calculator w3-jumbo w3-display-topleft w3-margin"></i>
							<div class="w3-container">Calculadora Monetaria</div>
						HTML;
						
						$inputBS = generarINPUT('BS', 'Monto en Bs.');
						$inputDolar = generarINPUT('DOLAR', 'Monto en Dólares');
						$inputPesos = generarINPUT('PESO', 'Monto en Pesos');
						
						$valorDolar = getDolar();
						$valorPesos = getPeso();
						$contenido = <<<HTML
							<div class="w3-row" style="max-width: 600px">
								<section class="w3-half w3-display-container">
									$inputBS
									$inputDolar
									$inputPesos
								</section>
								<ul class="w3-half w3-ul w3-padding-large w3-small w3-margin-top w3-left-align">
									<li>Introduce un número en alguno de los campos para realizar la conversión.</li>
									<li>Adicionalmente, puedes introducir una operación básica (suma, resta, multiplicación o división)</li>
									<li>Pulsa fuera de un campo para que se realice la operación introducida.</li>
									<li>Si el resultado se evalúa como negativo, será convertido a un número positivo.</li>
								</ul>
							</div>
							<section class="w3-hide">
								<input type="hidden" id="valorDolar" value="$valorDolar">
								<input type="hidden" id="valorPesos" value="$valorPesos">
							</section>
						HTML;
						generarModal('form', 'conversionMonetaria', $titulo, $contenido);
					endif;
				?>
				<a href="views/miPerfil.php" role="navegacion" title="Mi Perfil" class="w3-button icon-cog"></a>
				<button onclick="cerrarSesion()" title="Cerrar Sesión" class="w3-button icon-sign-out"></button>
			</div>
		</section>
		<p class="w3-container">Panel de Administración</p>
		<nav class="w3-bar-block">
			<a href="dashboard.php" role="navegacion" title="Panel de Administración" class="w3-bar-item w3-button w3-padding w3-blue">
				<i class="icon-home"></i> Inicio
			</a>
			<a href="views/nuevaVenta.php" role="navegacion" title="Registrar Venta" class="w3-bar-item w3-button w3-padding">
				<i class="icon-shopping-cart"></i> Nueva Venta
			</a>
			<a href="views/inventario.php" role="navegacion" title="Ver Inventario" class="w3-bar-item w3-button w3-padding">
				<i class="icon-product-hunt"></i> Inventario
			</a>
			<a href="views/clientes.php" role="navegacion" title="Ver Clientes" class="w3-bar-item w3-button w3-padding">
				<i class="icon-id-card"></i> Clientes
			</a>
			<a href="views/proveedores.php" role="navegacion" title="Ver Proveedores" class="w3-bar-item w3-button w3-padding">
				<i class="icon-address-book"></i> Proveedores
			</a>
			<a href="views/ventas.php" role="navegacion" title="Gestionar Ventas" class="w3-bar-item w3-button w3-padding">
				<i class="icon-list-alt"></i> Ventas
			</a>
			<?php if ($_SESSION['cargo'] === 'a'): ?>
				<details class="w3-bar-block w3-light-gray">
					<summary class="w3-hover-grey w3-padding">
						<i class="icon-handshake-o"></i> Compras
						<i class="icon-chevron-right w3-right"></i>
					</summary>
					<div>
						<a href="views/compras.php" role="navegacion" title="Gestionar Compras" class="w3-bar-item w3-button w3-padding">
							<i class="icon-handshake-o"></i> Ver Compras
						</a>
						<a href="views/nuevaCompra.php" role="navegacion" title="Registrar Compra" class="w3-bar-item w3-button">
							<i class="icon-cart-plus"></i> Nueva Compra
						</a>
					</div>
				</details>
				<details class="w3-bar-block w3-light-gray">
					<summary class="w3-hover-grey w3-padding">
						<i class="icon-users"></i> Usuarios
						<i class="icon-chevron-right w3-right"></i>
					</summary>
					<div>
						<a href="views/usuarios.php" role="navegacion" title="Gestionar Usuarios" class="w3-bar-item w3-button">
							<i class="icon-users"></i> Ver Usuarios
						</a>
						<a href="views/log.php" role="navegacion" title="Registro de Sesiones" class="w3-bar-item w3-button">
							<i class="icon-list-alt"></i> Ver Log
						</a>
					</div>
				</details>
				<a href="views/negocios.php" role="navegacion" title="Gestionar Negocios" class="w3-bar-item w3-button w3-padding">
					<i class='icon-building'></i> Negocios
				</a>
				<a href="views/finanzas.php" role="navegacion" title="Gestionar Finanzas" class="w3-bar-item w3-button w3-padding">
					<i class="icon-bar-chart"></i> Finanzas
				</a>
			<?php endif ?>
		</nav>
		<br><br><br><br><br>
	</aside>
<?php endif ?>