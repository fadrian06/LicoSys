<?php require_once "partial/head.php" ?>
<!-- !CONTENIDO! -->
<main class="w3-main">
	<?php
		if($_SESSION["cargo"]=="a"):
			$usuarios=CONSULTA("SELECT * FROM usuario WHERE cargo<>'a'");
			$encabezados=["C.I", "Nombre", "Usuario", "Teléfono"];
			$campos=["ci_u", "nom_u", "usuario", "tlf"];
			echo "
				<header class='w3-container w3-center'>
					<h1 class='w3-bottombar w3-border-gray w3-round-large'>Usuarios</h1>
				</header>
			";
			TABLA($usuarios, $encabezados, $campos);
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
		endif; ?>
</main>
<?php require_once "partial/footer.php" ?>