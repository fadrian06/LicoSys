<?php require "partial/head.php" ?>

<!-- !CONTENIDO! -->
<main class="w3-main">
	<?php
		if($_SESSION["cargo"]=="a"):
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
<?php require_once "partial/footer.php"; ?>