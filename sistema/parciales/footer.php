		<script src="../librerias/axios/axios.min.js"></script>
		<script src="../librerias/w3/w3.min.js"></script>
		<script src="../librerias/sweetalert2/sweetalert2.all.min.js"></script>
		<script src="../librerias/aos/aos.min.js"></script>
		<script src="../librerias/moment/moment.min.js"></script>
		<script src="../librerias/moment/es.min.js"></script>
		<script src="../librerias/chart.min.js"></script>
		<script src="../js/funciones.js"></script>
		<script src="../js/sistema.js"></script>
		<script>AOS.init()</script>
		<?=$notificacion ?? ''?>
		<?=$restringido ?? ''?>
	</body>
</html>
<?php if(isset($_SESSION["ciCliente"]) && !$nuevaVentaActivo) unset($_SESSION["ciCliente"]) ?>
<?php if(isset($_SESSION["idProveedor"]) && !$comprasActivo) unset($_SESSION["idProveedor"]) ?>