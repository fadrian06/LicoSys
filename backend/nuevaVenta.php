<?php
	session_start();
	
	require 'conexion.php';
	require 'funciones.php';
	
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	/*==========================================================
	=            RETORNAR INFORMACIÓN DE UN CLIENTE            =
	==========================================================*/
	if (!empty($_GET['clienteID'])):
		$id = (int) escapar($_GET['clienteID']);
		$respuesta['datos'] = getRegistro("SELECT * FROM clientes WHERE id=$id");
		$_SESSION['clienteID'] = $id;
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	/*===========================================================
	=            RETORNAR INFORMACIÓN DE UN PRODUCTO            =
	===========================================================*/
	if (!empty($_GET['productoID'])):
		$id = (int) escapar($_GET['productoID']);
		$respuesta['datos'] = getRegistro("SELECT * FROM inventario WHERE id=$id");
		$respuesta['datos']['iva'] = getIVA();
		$_SESSION['productoID'] = $id;
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	/*===================================================
	=            AÑADIR PRODUCTOS AL CARRITO            =
	===================================================*/
	if (!empty($_POST['addProduct'])):
		$productoID = (int) escapar($_POST['productoID']);
		$cantidad = (int) escapar($_POST['cantidad']);
		$clienteID = !empty($_SESSION['clienteID'])
			? $_SESSION['clienteID']
			: false;
		$iva = getIVA();
		$producto = getRegistro("SELECT * FROM inventario WHERE id=$productoID");
		
		/*----------  DATOS DEL PRODUCTO  ----------*/
		$codigo = strtoupper($producto['codigo']);
		$nombre = $producto['producto'];
		$stock = (int) $producto['stock'];
		$precio = (float) $producto['precio'];
		$excento = (int) $producto['excento'];
		$total = $precio * $cantidad;
		$totalIVA = 0;
		
		if ($excento) $totalIVA = $total + ($total * $iva);
		
		/*----------  VALIDACIONES  ----------*/
		if (!$clienteID) $respuesta['error'] = 'Por favor seleccione un cliente.';
		if (!$productoID) $respuesta['error'] = 'Por favor seleccione un producto.';
		if ($cantidad > $stock)
			$respuesta['error'] = 'La cantidad es mayor a la existencia del producto.';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = <<<SQL
			SELECT * FROM inventario WHERE producto_id=$productoID
		SQL;
		$productoEnCarrito = getRegistro($sql);
		
		// Si el producto existe en el carrito.
		if ($productoEnCarrito):
			
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		endif;
		
		// Si el producto no existe en el carrito.
		$sql = <<<SQL
			INSERT INTO carrito_venta(producto_id, nuevo_stock, precio_base, unidades,
				precio_total, total_iva)
				VALUES($productoID, $stock, $precio, $cantidad, $total, $totalIVA)
		SQL;
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		$respuesta['ok'] = 'Producto añadido al carrito.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
				/*if($temporal = getRegistro("SELECT * FROM carrito_venta WHERE cod='$codigo'")):
					$nuevaCantidad = $cantidad + $temporal["cantidad"];
					setRegistro("UPDATE carrito_venta SET cantidad=$nuevaCantidad WHERE cod='$codigo'");
					$temporal = getRegistro("SELECT * FROM carrito_venta WHERE cod='$codigo'");
					$total = round($temporal["cantidad"] * $temporal["precio_b"], 2);
					if($temporal["excento"] == "SI") $totalIva = (string) round($total + ($total * $iva), 2);
					setRegistro("UPDATE carrito_venta SET precio_total='$total', total_iva='$totalIva' WHERE cod='$codigo'");
					$nuevoStock = $temporal["stock"] - $temporal["cantidad"];
					setRegistro("UPDATE inventario SET stock=$nuevoStock WHERE cod='$codigo'");
					$notificacion = "
						<script>
							window.scrollTo(0, document.body.scrollHeight);
						</script>
					";
				else:
					if($excento == "SI") $totalIva = (string) round(($precioTotal + ($precioTotal * $iva)), 2);
					setRegistro("INSERT INTO carrito_venta VALUES('$codigo', '$nombre', $stock, $precioB, $cantidad, '$excento', '$precioTotal', '$totalIva')");
				endif;
				$temporal = getRegistro("SELECT * FROM carrito_venta WHERE cod='$codigo'");
				$nuevoStock = $temporal["stock"] - $temporal["cantidad"];
				if($nuevoStock <= 0) $nuevoStock = 0;
				setRegistro("UPDATE inventario SET stock=$nuevoStock WHERE cod='$codigo'");
				$notificacion = "
					<script>
						window.scrollTo(0, document.body.scrollHeight);
					</script>
				";
				$codigo      = "";
				$nombre      = "";
				$stock       = "";
				$precioB     = "";
				$cantidad    = "";
				$precioTotal = "";
				$excento     = "";
				$datosCarrito = getRegistros("SELECT * FROM carrito_venta ORDER BY nom_p");
				$productos    = getRegistros("SELECT * FROM inventario ORDER BY nom_p");
		*/
	endif;
?>