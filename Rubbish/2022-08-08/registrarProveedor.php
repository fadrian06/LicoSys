<?php require_once "partial/head.php" ?>
<main class="w3-main w3-row-padding">
	<?php if($_SESSION["cargo"]=="a"): ?>
		<form action="" method="post" class="w3-container w3-card w3-content w3-padding w3-white w3-round">
			<header class="w3-border-bottom w3-border-black w3-round-large w3-margin-bottom">
				<a href="proveedores.php" class="w3-xxlarge w3-hover-text-gray w3-left" style="text-decoration: none"><span class="icon-chevron-circle-left"></span></a>
				<h2 class="w3-center">Registro de Proveedor</h2>
			</header>
			<section class="w3-panel w3-row w3-border-bottom">
				<div class="w3-third w3-border-right">
					<label class="w3-input w3-border-0" for="nombre">Nombre<strong class="w3-text-red">*</strong>:</label>
				</div>
				<div class="w3-twothird">
					<input class="w3-input w3-border-0" type="text" name="nombre" id="nombre" placeholder="Nombre del Proveedor" required>
				</div>
			</section>
			<?php require "php/registrarProveedor.php"; ?>
			<input class="w3-section w3-button w3-block w3-blue w3-round-medium" type="submit" name="registrar" value="Registrar" id="registrar">
		</form>
	<?php else:
		$restringido = "
			<script>
				Swal.fire({
					title: 'ACCESO DENEGADO',
					icon: 'error',
					footer: 'Volviendo a la vista de proveedores',
					timer: 3000,
					timerProgressBar: true,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false,
					showConfirmButton: false,
				})
				setInterval(function(){
					window.location.href = '/licoreria/sistema/proveedores.php'
				}, 3000);
			</script>
		";
	endif; ?>
</main>
<?php require_once "partial/footer.php" ?>