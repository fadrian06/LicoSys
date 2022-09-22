<?php require "partial/head.php" ?>
<main class="w3-main w3-row-padding">
	<?php if($_SESSION["cargo"]=="a"): ?>
		<br>
		<form action="" method="post" class="w3-container w3-card w3-content w3-padding w3-white w3-round" style="max-width: 450px">
			<header class="w3-border-bottom w3-border-black w3-round-large w3-margin-bottom">
				<a href="usuarios.php" class="w3-xxlarge w3-hover-text-gray w3-left" style="text-decoration: none"><span class="icon-chevron-circle-left"></span></a>
				<h2 class="w3-center">Registro de Usuario</h2>
			</header>
			<section class="w3-panel w3-row w3-border-bottom">
				<div class="w3-half w3-border-right">
					<label class="w3-input w3-border-0 w3-small" for="cedula">C.I<strong class="w3-text-red">*</strong>:</label></div>
				<div class="w3-half">
					<input class="w3-input w3-border-0" type="number" name="cedula" id="cedula" placeholder="ej. xxXXXxxx" min="2000000" max="35000000" required>
				</div>
			</section>
			<section class="w3-panel w3-row w3-border-bottom">
				<div class="w3-half w3-border-right">
					<label class="w3-input w3-border-0 w3-small" for="nombre">Nombre<strong class="w3-text-red">*</strong>:</label>
				</div>
				<div class="w3-half">
					<input class="w3-input w3-border-0" type="text" name="nombre" id="nombre" placeholder="ej. Bob Arturo" required>
				</div>
			</section>
			<section class="w3-panel w3-row w3-border-bottom">
				<div class="w3-half w3-border-right">
					<label class="w3-input w3-border-0 w3-small" for="usuario">Usuario<strong class="w3-text-red">*</strong>:</label>
				</div>
				<div class="w3-half">
					<input class="w3-input w3-border-0" type="text" name="usuario" id="usuario" placeholder="ej. bob123" required>
				</div>
			</section>
			<section class="w3-panel w3-row w3-border-bottom">
				<div class="w3-half w3-border-right">
					<label class="w3-input w3-border-0 w3-small" for="clave">Nueva Contraseña<strong class="w3-text-red">*</strong>:</label>
				</div>
				<div class="w3-half">
					<input class="w3-input w3-border-0" type="password" name="clave" id="clave" placeholder="ej. bob_98*" required>
				</div>
			</section>
			<section class="w3-panel w3-row w3-border-bottom">
				<div class="w3-half w3-border-right">
					<label class="w3-input w3-border-0 w3-small" for="clave2">Confirmar Contraseña<strong class="w3-text-red">*</strong>:</label>
				</div>
				<div class="w3-half">
					<input class="w3-input w3-border-0" type="password" name="clave2" id="clave2" placeholder="ej. bob_98*" required>
				</div>
			</section>
			<section class="w3-panel w3-row w3-border-bottom">
				<div class="w3-half w3-border-right">
					<label class="w3-input w3-border-0 w3-small" for="telefono">Teléfono <sup class="w3-text-grey">opcional</sup>:</label>
				</div>
				<div class="w3-half">
					<input class="w3-input w3-border-0" type="text" name="telefono" id="telefono" placeholder="ej. xxxxXXXxxxx">
				</div>
			</section>
			<?php require "php/registrarUsuario.php"; ?>
			<input class="w3-section w3-button w3-block w3-blue w3-round-medium" type="submit" name="registrar" value="Registrar" id="registrar">
		</form>
	<?php else:
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