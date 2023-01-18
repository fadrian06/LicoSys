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
		$respuesta['datos']['dolar'] = getDolar();
		$respuesta['datos']['peso'] = getPeso();
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
		unset($_SESSION['productoID']);
		
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
			SELECT * FROM carrito_venta WHERE producto_id=$productoID
		SQL;
		$productoEnCarrito = getRegistro($sql);
		
		// Si el producto existe en el carrito.
		if ($productoEnCarrito):
			$cantidad += $productoEnCarrito['unidades'];
			$total = $productoEnCarrito['precio_base'] * $cantidad;
			if ($excento) $totalIVA = ($total * $iva) + $total;
			$sql = <<<SQL
				UPDATE carrito_venta SET unidades=$cantidad,
				precio_total=$total, total_iva=$totalIVA WHERE producto_id=$productoID
			SQL;
			$resultado = setRegistro($sql);
			if (!$resultado) $respuesta['error'] = $conexion->error;
			
			// Reducimos aún más el stock del producto.
			$stock = $productoEnCarrito['antiguo_stock'] - $cantidad;
			$sql = "UPDATE inventario SET stock=$stock WHERE id=$productoID";
			$resultado = setRegistro($sql);
			if (!$resultado) $respuesta['error'] = $conexion->error;
			
			$respuesta['ok'] = 'Producto añadido al carrito.';
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		endif;
		
		// Si el producto no existe en el carrito.
		$sql = <<<SQL
			INSERT INTO carrito_venta(producto_id, antiguo_stock, precio_base,
				unidades, precio_total, total_iva
			) VALUES($productoID, $stock, $precio, $cantidad, $total, $totalIVA)
		SQL;
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		// Reducimos el stock del producto seleccionado.
		$stock -= $cantidad;
		$sql = "UPDATE inventario SET stock=$stock WHERE id=$productoID";
		$resultado = setRegistro($sql);
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = 'Producto añadido al carrito.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	/*=====================================================
	=            ELIMINAR PRODUCTO DEL CARRITO            =
	=====================================================*/
	if (!empty($_POST['eliminar'])):
		$id = (int) escapar($_POST['productoID']);
		$sql = "SELECT antiguo_stock FROM carrito_venta WHERE producto_id=$id";
		$antiguoStock = (int) getRegistro($sql)['antiguo_stock'];
		$resultado = setRegistro("DELETE FROM carrito_venta WHERE producto_id=$id");
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$resultado = setRegistro("UPDATE inventario SET stock=$antiguoStock WHERE id=$id");
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = 'Producto eliminado del carrito.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	/*====================================
	=            ANULAR VENTA            =
	====================================*/
	if (!empty($_POST['anular'])):
		$productos = getRegistros('SELECT producto_id, antiguo_stock FROM carrito_venta');
		
		/*----------  RESTAURA EL STOCK DE CADA PRODUCTO  ----------*/
		foreach ($productos as $producto):
			$sql = <<<SQL
				UPDATE inventario SET stock={$producto['antiguo_stock']}
				WHERE id={$producto['producto_id']}
			SQL;
			$resultado = setRegistro($sql);
			if (!$resultado) $respuesta['error'] .= $conexion->error;
		endforeach;
		
		$resultado = setRegistro("TRUNCATE TABLE carrito_venta");
		if (!$resultado) $respuesta['error'] .= $conexion->error;
		unset($_SESSION['productoID']);
		$respuesta['ok'] = 'Venta anulada exitósamente.';
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	/*=====================================
	=            GENERAR VENTA            =
	=====================================*/
	if (!empty($_POST['generar'])):
		$productos = getRegistros('SELECT * FROM carrito_venta');
		$iva = getIVA();
		
		unset($_SESSION['productoID']);
		
		/*----------  INSERTAMOS LAS VENTAS  ----------*/
		foreach ($productos as $producto):
			$unidades = (int) $producto['unidades'];
			$total = $producto['total_iva'] > 0
				? $producto['total_iva']
				: $producto['precio_total'];
			$producto = getRegistro("SELECT * FROM inventario WHERE id={$producto['producto_id']}");
			
			$sql = <<<SQL
				INSERT INTO ventas(cliente_id, producto_id, unidades, total, iva, usuario_id, negocio_id)
				VALUES({$_SESSION['clienteID']}, {$producto['id']}, $unidades, $total, $iva, {$_SESSION['userID']}, {$_SESSION['negocioID']})
			SQL;
			
			$resultado = setRegistro($sql);
			if (!$resultado) $respuesta['error'] .= $conexion->error;
		endforeach;
		
		$resultado = setRegistro('TRUNCATE TABLE carrito_venta');
		if (!$resultado) $respuesta['error'] .= $conexion->error;
		
		$respuesta['ok'] = 'Venta generada exitósamente.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>