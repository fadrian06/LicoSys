		<script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
		<script src="../dist/bundle.js"></script>
		<?=$notificacion ?? ''?>
		<?=$restringido ?? ''?>
	</body>
</html>
<?php if(isset($_SESSION["ciCliente"]) && !$nuevaVentaActivo) unset($_SESSION["ciCliente"]) ?>
<?php if(isset($_SESSION["idProveedor"]) && !$comprasActivo) unset($_SESSION["idProveedor"]) ?>