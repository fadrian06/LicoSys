<?php require_once "partial/head.php" ?>
<?php
	$negocios = CONSULTA("SELECT * FROM negocio");

	if(isset($_POST["actualizarFoto"])):
		$idNegocio = (int) $_POST["id"];
		$foto   = $_FILES["foto"];
		$tipo   = $foto["type"];
		switch($tipo){
			case "image/jpeg":
			case "image/jpg":
			case "image/png":
				$imagen = "$idNegocio.jpeg";
				break;
		}
		$peso = $foto["size"];
		$dirTemporal = $foto["tmp_name"];
		if($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png"):
			if($peso < 1*1000*2048 /*2MB*/):
				if(ACTUALIZAR("UPDATE negocio SET foto='$imagen' WHERE id_n=$idNegocio")):
					move_uploaded_file($dirTemporal, "../imagenes/negocios/$imagen");
					$notificacion = "
						<script>
							Swal.fire({
								title: 'Foto actualizada exitosamente',
								icon: 'success',
								timer: 2000,
								toast: true,
								timerProgressBar: true,
								position: 'bottom-end',
								showConfirmButton: false
							})
							document.querySelector('#foto$idNegocio').src = '../imagenes/negocios/$imagen';
						</script>
					";
				endif;
			else:
				$notificacion = "
					<script>
						Swal.fire({
							title: 'La imagen no puede ser mayor a <b class=\"w3-text-red\" title=\"2 Megabytes\">2MB</b>',
							icon: 'error',
							timer: 5000,
							timerProgressBar: true,
							position: 'bottom-end',
							showConfirmButton: false
						})
					</script>
				";
			endif;
		else:
			$notificacion = "
				<script>
					Swal.fire({
						title: 'Sólo se permiten imagenes (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)',
						icon: 'error',
						timer: 3000,
						timerProgressBar: true,
						position: 'bottom-end',
						showConfirmButton: false
					})
				</script>
			";
		endif;
	endif;

	if(isset($_POST["actualizar"])):
		$id = (int) $_POST["idNegocio"];
		$nombre    = !empty($_POST["nombre"])    ? ESCAPAR_STRING($_POST["nombre"])    : "";
		$rif       = !empty($_POST["rif"])       ? ESCAPAR_STRING($_POST["rif"])       : "";
		$telefono  = !empty($_POST["telefono"])  ? ESCAPAR_STRING($_POST["telefono"])  : "";
		$direccion = !empty($_POST["direccion"]) ? ESCAPAR_STRING($_POST["direccion"]) : "";
			if(ACTUALIZAR("UPDATE negocio SET nom_n='$nombre', rif='$rif', tlf_n='$telefono', direccion_n='$direccion' WHERE id_n=$id")):
				$_SESSION["negocio"] = $idNegocio;
				$notificacion = "
					<script>
						Swal.fire({
							title: 'Actualización exitosa',
							icon: 'success',
							timer: 2000,
							timerProgressBar: true,
							showConfirmButton: false
						})
						setTimeout(function(){
							window.location.href = '/licoreria/sistema/negocio.php';
							}, 2500)
					</script>
				";
			endif;
	endif;
?>

<!--=========================================
=            CONFIGURAR NEGOCIOS            =
==========================================-->
<main class="w3-container w3-main w3-row" id="negocios">
	<?php if($_SESSION["cargo"]=="a"):?>
			<!--===================================
			=            BARRA LATERAL            =
			====================================-->
			<div class="w3-col s3 m3 l3 w3-padding-24 w3-ul w3-center">
				<ul id="menuNegocios" class="w3-ul w3-card w3-white w3-tiny w3-center">
					<?php foreach($negocios as $negocio): ?>
						<li class="botonNegocio w3-button w3-block w3-rightbar" id="botonNegocio<?=$negocio["id_n"]?>">
							<i class="icon-building w3-large"></i>
							<div><?=$negocio["nom_n"]?></div>
						</li>
					<?php endforeach; ?>
				</ul>
				<button class="w3-button w3-card w3-blue w3-circle w3-margin-top w3-padding-16" id="botonAgregarNegocio">
					<i class="icon-plus w3-large"></i>
					<b class="w3-small w3-block">Nuevo</b>
				</button>
			</div>
			<!--====  End of BARRA LATERAL  ====-->

			<!--=====================================
			=            PANEL PRINCIPAL            =
			======================================-->
			<?php foreach($negocios as $negocio): ?>
				<div class="panelNegocio w3-rest w3-hide w3-animate-opacity" id="panelNegocio<?=$negocio["id_n"]?>">
					<!--==================================================
					=                   PANEL `NEGOCIO`                  =
					===================================================-->
					<div class="panelInfoNegocio w3-threequarter w3-margin-top w3-container w3-card w3-white w3-show w3-animate-opacity" id="panelInfoNegocio<?=$negocio["id_n"]?>">
						<h2 class="w3-large w3-padding w3-border-bottom"><span class="w3-text-blue">Información</span></h2>
						<div class="w3-clear"></div>

						<!--============================================
						=            Información `Negocio`             =
						=============================================-->
						<ul class="w3-ul w3-small w3-show w3-animate-opacity" id="infoNegocio<?=$negocio["id_n"]?>">
							<li>
								<span class="w3-tag w3-blue w3-left">Identificador:</span>
								<b class="w3-right"><?=$negocio["id_n"]?></b>
								<div class="w3-clear"></div>
							</li>
							<li>
								<span class="w3-tag w3-blue w3-left">Nombre:</span>
								<b class="w3-right"><?=$negocio["nom_n"]?></b>
								<div class="w3-clear"></div>
							</li>
							<li>
								<span class="w3-tag w3-blue w3-left">Rif:</span>
								<b class="w3-right"><?=$negocio["rif"]?></b>
								<div class="w3-clear"></div>
							</li>
							<li>
								<span class="w3-tag w3-blue w3-left">Teléfono:</span>
								<b class="w3-right"><?=isset($negocio["tlf_n"]) ? $negocio["tlf_n"] : "No especificado"?></b>
								<div class="w3-clear"></div>
							</li>
							<li>
								<span class="w3-tag w3-blue w3-left">Dirección:</span>
								<b class="w3-right"><?=isset($negocio["direccion_n"]) ? $negocio["direccion_n"] : "No especificado"?></b>
								<div class="w3-clear"></div>
							</li>
						</ul>

						<button class="botonActualizarNegocio w3-button w3-blue w3-section w3-round-large w3-show w3-animate-opacity" id="botonActualizarNegocio<?=$negocio["id_n"]?>">Actualizar datos</button>
				
						<!--==================================================
						=            Formulario `Actualizar info`            =
						===================================================-->
						<form action="" method="POST" class="formularioActualizarNegocio w3-center w3-hide w3-small w3-padding-16 w3-animate-opacity" id="formularioActualizar<?=$negocio["id_n"]?>">
							<div class="w3-row w3-section">
								<label for="nombre<?=$negocio["id_n"]?>" class="w3-third w3-padding">Nombre</label>
								<input type="text" name="nombre" class="w3-twothird w3-input" value="<?=$negocio["nom_n"]?>" id="nombre<?=$negocio["id_n"]?>" minlength="3" maxlength="20" required title="Sólo se permiten letras con inicial en Mayúscula">
							</div>
							<div class="w3-row w3-section">
								<label for="rif<?=$negocio["id_n"]?>" class="w3-third w3-padding">Rif</label>
								<input type="number" name="rif" class="w3-twothird w3-input" value="<?=$negocio["rif"]?>" id="rif<?=$negocio["id_n"]?>" minlength="8" maxlength="15" required pattern="^[0-9]{8,15}$" title="Sólo se permiten números entre 8 y 15 dígitos">
							</div>
							<div class="w3-row w3-section">
								<label for="telefono<?=$negocio["id_n"]?>" class="w3-third w3-padding">Teléfono</label>
								<input type="text" name="telefono" class="w3-twothird w3-input" value="<?=$negocio["tlf_n"]?>" id="telefono<?=$negocio["id_n"]?>">
							</div>
							<div class="w3-row w3-section">
								<label for="direccion<?=$negocio["id_n"]?>" class="w3-third w3-padding">Dirección</label>
								<input type="text" name="direccion" class="w3-twothird w3-input" value="<?=$negocio["direccion_n"]?>" id="direccion<?=$negocio["id_n"]?>">
							</div>
							<input type="text" name="idNegocio" class="w3-hide" value="<?=$negocio["id_n"]?>">
							<input type="submit" value="Actualizar" name="actualizar" class="w3-button w3-blue w3-round-large">
						</form>
					</div>
					<!--====  End of PANEL `NEGOCIO`  ====-->
		
					<!--============================================
					=            PANEL `FOTO DE PERFIL`            =
					=============================================-->
					<form class="formulario-foto w3-quarter w3-center w3-white w3-leftbar w3-show" id="formulario-foto<?=$negocio["id_n"]?>" enctype="multipart/form-data" action="" method="POST">
						<label for="foto<?=$negocio["id_n"]?>" class="w3-display-container w3-hover-opacity" style="background:url() top/contain no-repeat">
							<i class="icon-camera w3-xxxlarge w3-display-middle"></i>
							<input type="file" name="foto" class="w3-hide" id="foto<?=$negocio["id_n"]?>">
							<img class="image-result" src="<?=!empty($negocio["foto"]) ? "../imagenes/negocios/{$negocio['foto']}" : "../imagenes/logoNegocio.jpg"?>" id="foto<?=$negocio["id_n"]?>">
						</label>
						<input type="text" name="id" class="w3-hide" value="<?=$negocio["id_n"]?>">
						<input type="submit" name="actualizarFoto" value="Actualizar" class="w3-button w3-blue w3-round-large w3-section w3-animate-right w3-hide">
						<b class="w3-medium w3-white w3-block w3-margin-top"><?=$negocio["nom_n"]?></b>
						<span class="w3-small w3-white w3-block w3-text-blue">RIF-<?=$negocio["rif"]?></span>
					</form>
					<!--====  End of PANEL `FOTO DE PERFIL`  ====-->
				</div>
			<?php endforeach; ?>
		<!--====  End of PANEL PRINCIPAL  ====-->
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
<!--====  End of CONFIGURAR NEGOCIOS  ====-->


<?php require_once "partial/footer.php"; ?>