<?php
	session_start();
	
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	if ($_SESSION['cargo'] === 'a'):
		require '../backend/config.php';
		require '../backend/componentes.php';
		require '../backend/conexion.php';
		require '../backend/funciones.php';
		
		echo LOADER;
		echo '<div id="moduloNuevaCompra">';
		
		/*=============================================
		=            SELECCIONAR PROVEEDOR            =
		=============================================*/
		$proveedores = getRegistros('SELECT * FROM proveedores ORDER BY rif');
		$proveedor = [
			'id' => '',
			'rif' => '',
			'nombre' => 'No especificado',
		];
		
		if (!empty($_SESSION['proveedorID']))
			$proveedor = getRegistro("SELECT * FROM proveedores WHERE id={$_SESSION['proveedorID']}");
		
		$botonesProveedores = '';
		foreach ($proveedores as $proveedor)
			$botonesProveedores .= <<<HTML
				<button proveedor-id="{$proveedor['id']}" title="{$proveedor['nombre']}" class="w3-bar-item w3-button">
					<span>{$proveedor['rif']}</span>
				</button>
			HTML;
		
		$mostrarLista = isset($_SESSION['proveedorID'])
			? ''
			: 'w3-hide';
			
		echo <<<HTML
			<section class="w3-row w3-padding-large w3-bottombar w3-round-large">
				<h2 class="w3-xlarge">Datos del <b>Proveedor</b></h2>
				<div class="w3-col m5 w3-margin-top">
					<button onclick="modal(this)" data-target="#registrarProveedor" title="Registrar Proveedor" class="w3-green w3-button w3-circle">
						<b class="w3-large">+</b>
					</button>
					<div class="w3-dropdown-hover">
						<button class="w3-button w3-blue w3-hover-blue w3-hover-text-black">
							Seleccionar Proveedor
						</button>
						<div id="listaProveedores" class="w3-dropdown-content w3-bar-block w3-card w3-light-grey">
							<input type="number" onkeyup="filter(this, 'listaProveedores')" class="w3-input w3-padding" placeholder="Buscar...">
							$botonesProveedores
						</div>
					</div>
				</div>
				<div class="w3-col m7">
					<ul id="datosProveedor" class="w3-ul w3-small w3-card w3-white w3-padding-large w3-margin-top $mostrarLista w3-animate-opacity">
						<li>
							<span class="w3-tag w3-blue w3-left">RIF:</span>
							<b class="w3-right">{$proveedor['rif']}</b>
							<div class="w3-clear"></div>
						</li>
						<li>
							<span class="w3-tag w3-blue w3-left">Nombre:</span>
							<b class="w3-right">{$proveedor['nombre']}</b>
							<div class="w3-clear"></div>
						</li>
					</ul>
				</div>
			</section>
		HTML;
		
		/*==========================================
		=            DATOS DE LA COMPRA            =
		==========================================*/
		echo <<<HTML
			<section class="w3-row w3-padding-large w3-bottombar w3-round-large">
				<div class="w3-half">
					<h2 class="w3-xlarge">Datos de la <b>Compra</b></h2>
					<p class="w3-text-gray"><i class="icon-user w3-text-black"> </i>Comprador</p>
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
			'precio' => 0,
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
		$iva = is_float(getIVA())
			? getIVA()
			: 0;
		$dolar = is_float(getDolar())
			? getDolar()
			: 0;
		$peso = is_int(getPeso())
			? getPeso()
			: 0;
		$stock = $producto['stock'] > 0
			? "<span class='w3-input w3-left-align w3-padding w3-light-grey'>{$producto['stock']}</span>"
			: "<span class='w3-input w3-padding w3-red'>Agotado</span>";
		$precioBS = is_float(getDolar())
			? round($producto['precio'] * getDolar(), 2)
			: 0;
		$precioPesos = is_int(getPeso())
			? (int) ($producto['precio'] * getPeso())
			: 0;
		$tooltipPrecio = generarTooltip("Bs. $precioBS<br>$precioPesos pesos", false);
		$tooltipRegistrarProducto = generarTooltip('Registrar Producto');
		echo <<<HTML
			<section class="w3-row w3-padding-large w3-bottombar w3-round-large">
				<div class="w3-col s12 m5 w3-margin-top">
					<div class="w3-dropdown-hover w3-transparent">
						<button onclick="modal(this)" data-target="#registrarProducto" title="Registrar Producto" class="w3-green w3-button w3-circle">
							<b class="w3-large">+</b>
						</button>
						$tooltipRegistrarProducto
					</div>
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
								<input class="w3-input w3-padding w3-light-grey w3-text-black" disabled value="{$producto['producto']}">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Código:</div>
							<div class="w3-col s8">
								<input class="w3-input w3-padding w3-light-grey w3-text-black" disabled value="{$producto['codigo']}">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Existencia:</div>
							<div class="w3-col s8">
								$stock
								<input type="hidden" disabled value="{$producto['stock']}">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Precio (<i class="icon-dollar"></i>):</div>
							<div class="w3-col s8 w3-dropdown-hover">
								<input name="precio" onchange="actualizarPrecio(this)" onkeyup="actualizarPrecio(this)" class="w3-input w3-padding" value="{$producto['precio']}">
								$tooltipPrecio
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Cantidad:</div>
							<div class="w3-col s8">
								<input type="number" id="cantidad" name="cantidad" onchange="actualizarTotal(this, 0, '#total')" onkeyup="actualizarTotal(this, 0, '#total')" placeholder="Introduce la cantidad" required min="0" class="w3-input w3-padding">
							</div>
						</section>
						<section class="w3-row">
							<div class="w3-input w3-col s4 w3-blue">Total (<i class="icon-dollar"></i>):</div>
							<div class="w3-col s8 w3-dropdown-hover">
								<span id="total" class="w3-left-align w3-input w3-padding w3-light-grey w3-text-black" disabled>
									<i class="w3-opacity-min">&nbsp;</i>
								</span>
							</div>
						</section>
						<div class="w3-center">
							<input type="hidden" id="productoID" name="productoID" value="{$producto['id']}">
							<input type="hidden" name="iva" value="$iva">
							<input type="hidden" name="dolar" value="$dolar">
							<input type="hidden" name="peso" value="$peso">
							<button class="w3-margin-top w3-medium w3-button w3-blue w3-round-xlarge w3-hide w3-animate-zoom">
								<span class="icon-plus"></span>
								Añadir Producto
							</button>
						</div>
					</form>
				</div>
			</section>
		HTML;	
		
		
		/*=========================================
		=            CARRITO DE COMPRA            =
		=========================================*/
		$sql = <<<SQL
			SELECT c.producto_id, i.producto, i.precio, c.unidades, c.precio_total
			FROM carrito_compra c INNER JOIN inventario i ON c.producto_id=i.id
		SQL;
		$carrito = getRegistros($sql);
		
		$filasProductos = '';
		$totalCarrito = 0;
		foreach ($carrito as $producto):
			$precioBS = round($producto['precio'] * getDolar(), 2);
			$precioPesos = (int) ($producto['precio'] * getPeso());
			$tooltipPrecio = generarTooltip("Bs. $precioBS<br>$precioPesos pesos", false);
			
			$precioBS = round((float) $producto['precio_total'] * getDolar(), 2);
			$precioPesos = (int) ((float) $producto['precio_total'] * getPeso());
			$tooltipTotal = generarTooltip("Bs. $precioBS<br>$precioPesos pesos", false);
			$totalCarrito += (float) $producto['precio_total'];
			$filasProductos .= <<<HTML
				<tr class="w3-white">
					<td>
						<button class="w3-button w3-transparent w3-hover-none">
							{$producto['producto']}
						</button>
					</td>
					<td class="w3-dropdown-hover">
						<button class="w3-button w3-transparent w3-hover-none">
							{$producto['precio']}
						</button>
						$tooltipPrecio
					</td>
					<td>
						<button class="w3-button w3-transparent w3-hover-none">
							{$producto['unidades']}
						</button>
					</td>
					<td class="w3-dropdown-hover">
						<button class="w3-button w3-transparent w3-hover-none">
							{$producto['precio_total']}
						</button>
						$tooltipTotal
					</td>
					<td>
						<a role="eliminarProducto" productoid="{$producto['producto_id']}" class="w3-button w3-red w3-round-large">
							<i class="icon-trash"></i>
						</a>
					</td>
				</tr>
			HTML;
		endforeach;
		
		if ($carrito):
			$precioBS = round($totalCarrito * getDolar(), 2);
			$precioPesos = (int) ($totalCarrito * getPeso());
			$tooltipTotalCarrito = generarTooltip("Bs. $precioBS<br>$precioPesos pesos", false);
			echo <<<HTML
				<section class="w3-section w3-responsive">
					<form id="carritoCompra">
						<span class="w3-left icon-cart-arrow-down w3-padding w3-dark-grey w3-xxlarge" style="border-top-left-radius: 16px; border-top-right-radius: 16px; margin-bottom: -1px; margin-left: 1px"></span>
						<div class="w3-clear"></div>
						<table class="w3-table-all w3-centered w3-hoverable">
							<tr class="w3-dark-grey w3-small">
								<th>Producto</th>
								<th>Precio (<i class="icon-dollar"></i>)</th>
								<th>Cantidad</th>
								<th>Total (<i class="icon-dollar"></i>)</th>
								<th></th>
							</tr>
							$filasProductos
							<tr class="w3-dark-grey">
								<td></td>
								<td></td>
								<td>TOTAL:</td>
								<td class="w3-dropdown-hover">$totalCarrito $tooltipTotalCarrito</td>
								<td></td>
							</tr>
						</table>
						<div class="w3-center w3-padding-large w3-margin-top">
							<button role="generarCompra" class="w3-margin-top w3-button w3-blue w3-round-large w3-margin-right">
								<i class="icon-handshake-o"></i> Generar Compra
							</button>
							<button role="anularCompra" class="w3-margin-top w3-button w3-red w3-round-large w3-margin-right">
								<i class="icon-trash"></i> Anular Compra
							</button>
						</div>
					</form>
				</section>
			HTML;
		endif;	
		
		/*===========================================
		=            REGISTRAR PROVEEDOR            =
		===========================================*/
		$label = '<b>RIF: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputRIF = generarINPUT('RIF', $label, 'RIF del proveedor');
		
		$label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
		$inputNombre = generarINPUT('NOMBRE_NEGOCIO', $label, 'Nombre del proveedor');
		
		echo <<<HTML
			<form id="registrarProveedor" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
				<div class="w3-right-align">
					<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
				</div>
				<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Registrar Proveedor
				</h1>
				<section class="w3-display-container">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					$inputRIF
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
		
		echo '<br><br><br><br><br><br><br><br><br><br>';
		
		$productosEnCarrito = count($carrito);
		echo "<span class='w3-hide' id='cantidadProductosEnCarrito'>$productosEnCarrito</span>";
		echo '</div>';
	else:
		include '../templates/head.php';
		$script = "<script src='{$BASE_URL}js/restringido.js'></script>";
		include '../templates/footer.php';
	endif;
?>