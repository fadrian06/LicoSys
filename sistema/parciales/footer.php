		<script src="../js/sistema.js"></script>
		<?=$notificacion ?? ''?>
		<?=$restringido ?? ''?>
	</body>
</html>
<?php if(isset($_SESSION["ciCliente"]) && !$nuevaVentaActivo) unset($_SESSION["ciCliente"]) ?>
<?php if(isset($_SESSION["idProveedor"]) && !$comprasActivo) unset($_SESSION["idProveedor"]) ?>