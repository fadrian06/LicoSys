<?php
	session_start();
	
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/componentes.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		echo LOADER;
		echo '<div id="moduloNuevaVenta">';
		/*===========================================
		=            SELECCIONAR CLIENTE            =
		===========================================*/
		$clientes = getRegistros('SELECT id, cedula, nombre FROM clientes ORDER BY cedula');
		
		$cliente = [
			'id' => '',
			'cedula' => '',
			'nombre' => 'No especificado'
		];
		if (!empty($_SESSION['clienteID']))
			$cliente = getRegistro("SELECT * FROM clientes WHERE id={$_SESSION['clienteID']}");
		
		$botonesClientes = '';
		foreach ($clientes as $cliente)
			$botonesClientes .= <<<HTML
				<button cliente-id="{$cliente['id']}" title="{$cliente['nombre']}" class="w3-bar-item w3-button">
					<span>v-{$cliente['cedula']}</span>
				</button>
			HTML;
		
		$mostrarLista = isset($_SESSION['clienteID'])
			? ''
			: 'w3-hide';
		echo <<<HTML
			<section class="w3-row w3-padding-large w3-bottombar w3-round-large">
				<h2 class="w3-xlarge">Datos del <b>Cliente</b></h2>
				<div class="w3-third w3-center w3-margin-top">
					<button onclick="modal(this)" data-target="#registrarCliente" title="Registrar Cliente" class="w3-green w3-button w3-circle">
						<b class="w3-large">+</b>
					</button>
					<div class="w3-dropdown-hover">
						<button class="w3-button w3-blue w3-hover-blue w3-hover-text-black">
							Seleccionar Cliente
						</button>
						<div id="listaClientes" class="w3-dropdown-content w3-bar-block w3-card w3-light-grey">
							<input type="number" onkeyup="filter(this, 'listaClientes')" class="w3-input w3-padding" placeholder="Buscar...">
							$botonesClientes
						</div>
					</div>
				</div>
				<div class="w3-twothird">
					<ul id="datosCliente" class="w3-ul w3-small w3-card w3-white w3-padding-large w3-margin-top $mostrarLista w3-animate-opacity">
						<li>
							<span class="w3-tag w3-blue w3-left">Cédula:</span>
							<b class="w3-right">v-{$cliente['cedula']}</b>
							<div class="w3-clear"></div>
						</li>
						<li>
							<span class="w3-tag w3-blue w3-left">Nombre:</span>
							<b class="w3-right">{$cliente['nombre']}</b>
							<div class="w3-clear"></div>
						</li>
					</ul>
				</div>
			</section>
		HTML;
		
		/*===================================
		=            DATOS VENTA            =
		===================================*/
		echo <<<HTML
			<section class="w3-row w3-padding-large w3-bottombar w3-round-large">
				<div class="w3-half">
					<h2 class="w3-xlarge">Datos de la <b>Venta</b></h2>
					<p class="w3-text-gray"><i class="icon-user w3-text-black"> </i>Vendedor</p>
					<span class="w3-text-blue">{$_SESSION['userName']}</span>
				</div>
		HTML;
		include '../templates/monedas.php';
		echo <<<HTML
			</section>
		HTML;
		
		/*============================================
		=            SELECCIONAR PRODUCTO            =
		============================================*/
		$productos = getRegistros("SELECT * FROM inventario ORDER BY producto");
		$producto = [
			'id' => '',
			'codigo' => '',
			'producto' => '',
			'stock' => 100,
			'precio' => '',
			'excento' => ''
		];
		if (!empty($_SESSION['productoID']))
			$producto = getRegistro("SELECT * FROM inventario WHERE id={$_SESSION['productoID']}");
		
		$botonesProductos = '';
		foreach ($productos as $producto)
			$botonesProductos .= <<<HTML
				<button producto-id="{$producto['id']}" class="w3-bar-item w3-button">
					{$producto['producto']}
				</button>
			HTML;
			
		$mostrarLista = isset($_SESSION['productoID'])
			? ''
			: 'w3-hide';
		$iva = getIVA();
		echo <<<HTML
			<section class="w3-row w3-padding-large">
				<div class="w3-col s12 m5 w3-margin-top">
					<button onclick="modal(this)" data-target="#registrarProducto" title="Registrar Producto" class="w3-green w3-button w3-circle">
						<b class="w3-large">+</b>
					</button>
					<div class="w3-dropdown-hover">
						<button class="w3-button w3-blue w3-hover-blue w3-hover-text-black">
							Seleccionar Producto
						</button>
						<div id="listaProductos" class="w3-dropdown-content w3-bar-block w3-card w3-light-grey">
							<input onkeyup="filter(this, 'listaProductos')" class="w3-input w3-padding" placeholder="Buscar...">
							$botonesProductos
						</div>
					</div>
				</div>
				<div class="w3-col s12 m7">
					<form id="datosProducto" class="w3-small w3-card w3-white w3-padding-large w3-margin-top $mostrarLista w3-animate-opacity">
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Producto:</div>
							<div class="w3-col s8">
								<input class="w3-input w3-padding w3-text-black" disabled value="{$producto['producto']}">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Código:</div>
							<div class="w3-col s8">
								<input class="w3-input w3-padding w3-text-black" disabled value="{$producto['codigo']}">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Existencia:</div>
							<div class="w3-col s8">
								<input class="w3-input w3-padding w3-text-black" disabled value="{$producto['stock']}">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Precio (<i class="icon-dollar"></i>):</div>
							<div class="w3-col s8">
								<input  name="precio" class="w3-input w3-padding w3-text-black" disabled value="{$producto['precio']}">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Cantidad:</div>
							<div class="w3-col s8">
								<input type="number" id="cantidad" name="cantidad" onchange="actualizarTotal(this, {$producto['excento']}, '#total')" placeholder="Introduce la cantidad" required min="0" max="{$producto['stock']}" class="w3-input w3-padding">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Total (<i class="icon-dollar"></i>):</div>
							<div class="w3-col s8">
								<input id="total" class="w3-input w3-padding w3-text-black" disabled>
							</div>
						</section>
						<div class="w3-center">
							<input type="hidden" id="productoID" name="productoID" value="{$producto['id']}">
							<input type="hidden" name="iva" value="$iva">
							<button class="w3-margin-top w3-medium w3-button w3-blue w3-round-xlarge w3-hide w3-animate-bottom">
								<span class="icon-plus"></span>
								Añadir Producto
							</button>
						</div>
					</form>
				</div>
			</section>
		HTML;
		
		echo '<br><br><br><br><br><br><br><br><br><br>';
		
		/*=========================================
		=            REGISTRAR CLIENTE            =
		=========================================*/
		$label = '<b>Cédula: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputCedula = generarINPUT('CEDULA', $label, 'Cédula del cliente');
		
		$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputNombre = generarINPUT('NOMBRE', $label, 'Nombre del cliente');
		
		echo <<<HTML
			<form id="registrarCliente" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
				<div class="w3-right-align">
					<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
				</div>
				<h2 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Registrar Cliente
				</h2>
				<section class="w3-display-container">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					$inputCedula
					$inputNombre
				</section>
				<section class="w3-panel">
					<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
						Registrar
					</button>
				</section>
			</form>
		HTML;
		
		/*==========================================
		=            REGISTRAR PRODUCTO            =
		==========================================*/
		$label = '<b>Código: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputCodigo = generarINPUT('CODIGO', $label, 'Código del producto');
		$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputNombre = generarINPUT('NOMBRE', $label, 'Nombre del producto');
		$label = '<b>Precio: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputPrecio = generarINPUT('PRECIO', $label, 'Precio base del producto');
		$label = '<b>Excento: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputExcento = generarINPUT('EXCENTO', $label, '¿Excento de IVA?');
		$label = '<b>Existencia: </b><sup class="w3-text-blue">(opcional)</sup>';
		$inputStock = generarINPUT('STOCK', $label, 'Cantidad disponible');
		echo <<<HTML
			<form id="registrarProducto" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
				<div class="w3-right-align">
					<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
				</div>
				<h2 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Registrar Producto
				</h2>
				<section class="w3-display-container">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					$inputCodigo
					$inputNombre
					$inputPrecio
					$inputExcento
					$inputStock
				</section>
				<section class="w3-panel">
					<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
						Registrar
					</button>
				</section>
			</form>
		HTML;
		
		/*=======================================
		=            ENLACES OCULTOS            =
		=======================================*/
		echo <<<HTML
			<footer id="botones">
				<a href="#carrito" class="w3-hide">Ir a carrito</a>
			</footer>
		HTML;
		echo '</div>';
	else:
		include '../templates/head.php';
		$script .= "<script src='{$BASE_URL}js/restringido.js'></script>";
		include '../templates/footer.php';
	endif;
?>