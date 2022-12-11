<?php
	require_once "../backend/conexion.php";
	@session_start();
	session_destroy();
	mysqli_query($conexion, "TRUNCATE TABLE carrito_venta");
	mysqli_query($conexion, "TRUNCATE TABLE carrito_compra");
	header('location: ../');
?>