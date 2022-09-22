<?php require_once "partial/head.php";?>
<main class="w3-main">
	<?php
		if ($_SESSION["cargo"] == "a"):
			$negocio = $_SESSION["negocio"];
			$logs          = CONSULTA("SELECT fecha, nom_u, usuario FROM log l INNER JOIN usuario u ON l.ci_u=u.ci_u WHERE l.id_n=$negocio ORDER BY fecha DESC");
			$encabezados   = ["Fecha", "Nombre", "Usuario"];
			$campos        = ["fecha", "nom_u", "usuario"];
			echo "
				<header class='w3-container w3-center'>
					<h1 class='w3-bottombar w3-border-gray w3-round-large'>Registro de Sesiones</h1>
				</header>
			";
			TABLA($logs, $encabezados, $campos);
		else:
			$restringido = "
				<script>
					Swal.fire({
						title: 'ACCESO DENEGADO',
						icon: 'error',
						footer: 'Volviendo a la página principal',
						timer: 3000,
						timerProgressBar: true,
						allowOutsideClick: false,
						allowEscapeKey: false,
						allowEnterKey: false,
						showConfirmButton: false,
					})
					setInterval(function(){
						window.location.href = '/licoreria/sistema/'
					}, 3000);
				</script>
			";
		endif;?>
</main>
<?php require_once "partial/footer.php";?>