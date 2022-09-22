<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	$indexActivo
		= $nuevaVentaActivo
		= $inventarioActivo
		= $clientesActivo
		= $proveedoresActivo
		= $comprasActivo
		= $ventasActivo
		= $usuariosActivo
		= $negocioActivo
		= $finanzasActivo = "";
	$color = "w3-blue";
	switch ($_SERVER["PHP_SELF"]):
		case "/licoreria/sistema/nuevaVenta.php":
			$nuevaVentaActivo = $color;
			break;
		case "/licoreria/sistema/inventario.php":
		case "/licoreria/sistema/registrarArticulo.php":
			$inventarioActivo = $color;
			break;
		case "/licoreria/sistema/clientes.php":
		case "/licoreria/sistema/registrarCliente.php":
			$clientesActivo = $color;
			break;
		case "/licoreria/sistema/proveedores.php":
		case "/licoreria/sistema/registrarProveedor.php":
			$proveedoresActivo = $color;
			break;
		case "/licoreria/sistema/compras.php":
		case "/licoreria/sistema/nuevaCompra.php":
			$comprasActivo = $color;
			break;
		case "/licoreria/sistema/ventas.php":
			$ventasActivo = $color;
			break;
		case "/licoreria/sistema/usuarios.php":
		case "/licoreria/sistema/log.php":
		case "/licoreria/sistema/registrarUsuario.php":
			$usuariosActivo = $color;
			break;
		case "/licoreria/sistema/negocio.php":
			$negocioActivo = $color;
			break;
		case "/licoreria/sistema/finanzas.php":
			$finanzasActivo = $color;
			break;
		case "/licoreria/sistema/":
		case "/licoreria/sistema/index.php":
			$indexActivo = $color;
	endswitch;
?>