<?php
	session_start();
	
	require 'conexion.php';
	require 'funciones.php';
	
	if (!isset($_SESSION['activa'])) header('location: ../salir.php');
	
	/*============================================================
	=            RETORNAR INFORMACIÓN DE UN PROVEEDOR            =
	============================================================*/
	if (!empty($_GET['proveedorID'])):
		$id = (int) escapar($_GET['proveedorID']);
		$respuesta['datos'] = getRegistro("SELECT * FROM proveedores WHERE id=$id");
		$_SESSION['proveedorID'] = $id;
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
		$precio = (float) $_POST['precio'];
		$proveedorID = !empty($_SESSION['proveedorID'])
			? $_SESSION['proveedorID']
			: false;
		$producto = getRegistro("SELECT * FROM inventario WHERE id=$productoID");
		unset($_SESSION['productoID']);
		
		/*----------  DATOS DEL PRODUCTO  ----------*/
		$total = $precio * $cantidad;
		$respuesta['datos'] = [
			'precio' => $precio,
			'cantidad' => $cantidad,
			'total' => $total
		];
		
		/*----------  VALIDACIONES  ----------*/
		if (!$proveedorID) $respuesta['error'] = 'Por favor seleccione un proveedor.';
		if (!$productoID) $respuesta['error'] = 'Por favor seleccione un producto.';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		$sql = <<<SQL
			SELECT * FROM carrito_compra WHERE producto_id=$productoID
		SQL;
		$productoEnCarrito = getRegistro($sql);
		
		// Si el producto existe en el carrito.
		if ($productoEnCarrito):
			// Aumentamos las unidades en el carrito y
			// recalculamos el total sin IVA.
			$productoEnCarrito['unidades'] += $cantidad;
			$productoEnCarrito['precio_total'] = $productoEnCarrito['unidades'] * $precio;
			
			$sql = <<<SQL
				UPDATE carrito_compra SET unidades={$productoEnCarrito['unidades']},
				precio_total={$productoEnCarrito['precio_total']} WHERE producto_id=$productoID
			SQL;
			$resultado = setRegistro($sql);
			if (!$resultado) $respuesta['error'] = $conexion->error;
			
			// Aumentamos aún más el stock del producto.
			// y comprobamos si el precio aumenta o se conserva.
			$producto['stock'] += $cantidad;
			$producto['precio'] = $producto['precio'] > $precio
				? (float) $producto['precio']
				: $precio;
			
			$sql = <<<SQL
				UPDATE inventario SET stock={$producto['stock']},
				precio={$producto['precio']} WHERE id=$productoID
			SQL;
			$resultado = setRegistro($sql);
			if (!$resultado) $respuesta['error'] = $conexion->error;
			
			$respuesta['ok'] = 'Producto añadido al carrito.';
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		endif;
		
		// Si el producto no existe en el carrito.
		// Se registra en el carrito el antiguo stock, el nuevo precio,
		// cantidad a comprar y el total sin IVA.
		$sql = <<<SQL
			INSERT INTO carrito_compra(producto_id, antiguo_stock, precio_base, unidades, precio_total)
			VALUES($productoID, {$producto['stock']}, {$producto['precio']}, $cantidad, $total)
		SQL;
		$resultado = setRegistro($sql);
		
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		// Aumentamos el stock del producto seleccionado
		// y comprobamos si el precio aumenta o se conserva.
		$producto['stock'] += $cantidad;
		$producto['precio'] = $producto['precio'] > $precio
			? (float) $producto['precio']
			: $precio;
		
		$sql = <<<SQL
			UPDATE inventario SET stock={$producto['stock']},
			precio={$producto['precio']} WHERE id=$productoID
		SQL;
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
		
		$sql = <<<SQL
			SELECT antiguo_stock, precio_base FROM carrito_compra
			WHERE producto_id=$id
		SQL;
		$productoEnCarrito = getRegistro($sql);
		
		/*----------  RESTAURAMOS EL STOCK Y PRECIO DEL PRODUCTO  ----------*/
		$sql = <<<SQL
			UPDATE inventario SET stock={$productoEnCarrito['antiguo_stock']},
			precio={$productoEnCarrito['precio_base']} WHERE id=$id
		SQL;
		$resultado = setRegistro($sql);
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		/*----------  ELIMINAMOS EL PRODUCTO DEL CARRITO  ----------*/
		$resultado = setRegistro("DELETE FROM carrito_compra WHERE producto_id=$id");
		if (!$resultado) $respuesta['error'] = $conexion->error;
		
		$respuesta['ok'] = 'Producto eliminado del carrito.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	/*=====================================
	=            ANULAR COMPRA            =
	=====================================*/
	if (!empty($_POST['anular'])):
		$sql = 'SELECT producto_id, antiguo_stock, precio_base FROM carrito_compra';
		$productos = getRegistros($sql);
		
		/*----------  RESTAURA EL STOCK Y EL PRECIO DE CADA PRODUCTO  ----------*/
		foreach ($productos as $producto):
			$sql = <<<SQL
				UPDATE inventario SET stock={$producto['antiguo_stock']},
				precio={$producto['precio_base']} WHERE id={$producto['producto_id']}
			SQL;
			$resultado = setRegistro($sql);
			if (!$resultado) $respuesta['error'] .= $conexion->error;
		endforeach;
		
		$resultado = setRegistro('TRUNCATE TABLE carrito_compra');
		if (!$resultado) $respuesta['error'] .= $conexion->error;
		unset($_SESSION['productoID']);
		$respuesta['ok'] = 'Compra anulada exitósamente.';
		
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
	
	/*======================================
	=            GENERAR COMPRA            =
	======================================*/
	if (!empty($_POST['generar'])):
		$sql = <<<SQL
			SELECT c.producto_id, c.unidades, i.precio, c.precio_total
			FROM carrito_compra c INNER JOIN inventario i ON c.producto_id=i.id
		SQL;
		$productos = getRegistros($sql);
		
		/*----------  INSERTAMOS LAS COMPRAS  ----------*/
		foreach ($productos as $producto):
			$sql = <<<SQL
				INSERT INTO compras(producto_id, unidades, precio, total,
					proveedor_id, usuario_id, negocio_id
				) VALUES({$producto['producto_id']}, {$producto['unidades']},
					{$producto['precio']}, {$producto['precio_total']},
					{$_SESSION['proveedorID']}, {$_SESSION['userID']}, {$_SESSION['negocioID']}
				)
			SQL;
			
			$resultado = setRegistro($sql);
			if (!$resultado) $respuesta['error'] .= $conexion->error;
		endforeach;
		
		$resultado = setRegistro('TRUNCATE TABLE carrito_compra');
		if (!$resultado) $respuesta['error'] .= $conexion->error;
		
		$respuesta['ok'] = 'Compra generada exitósamente.';
		unset($_SESSION['proveedorID']);
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>