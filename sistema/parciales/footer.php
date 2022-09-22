		<script src="../librerias/axios/axios.min.js"></script>
		<script src="../librerias/w3/w3.min.js"></script>
		<!-- <link rel="stylesheet" href="../librerias/sweetalert2/borderless.min.css"> -->
		<!-- <link rel="stylesheet" href="../librerias/sweetalert2/dark.min.css"> -->
		<script src="../librerias/sweetalert2/sweetalert2.all.min.js"></script>
		<script src="../js/funciones.js"></script>
		<script src="../js/sistema.js"></script>
		<?=$notificacion ?? $notificacion?>
		<?=$restringido ?? $restringido?>
	</body>
</html>
<?php if(isset($_SESSION["ciCliente"]) && !$nuevaVentaActivo) unset($_SESSION["ciCliente"]) ?>
<?php if(isset($_SESSION["idProveedor"]) && !$comprasActivo) unset($_SESSION["idProveedor"]) ?>