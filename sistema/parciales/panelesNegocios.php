<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<?php if(isset($_SESSION["cargo"]) && $_SESSION["cargo"] == "a"): ?>
	<?php foreach($negocios as $negocio): ?>
		<div class="w3-mobile panelNegocio w3-rest w3-hide w3-animate-opacity" id="panelNegocio<?=$negocio["id_n"]?>">
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
						<b class="w3-right"><?=!empty($negocio["tlf_n"]) ? $negocio["tlf_n"] : "No especificado"?></b>
						<div class="w3-clear"></div>
					</li>
					<li>
						<span class="w3-tag w3-blue w3-left">Dirección:</span>
						<b class="w3-right w3-mobile"><?=!empty($negocio["direccion_n"]) ? $negocio["direccion_n"] : "No especificado"?></b>
						<div class="w3-clear"></div>
					</li>
				</ul>

					<div class="w3-section w3-show w3-animate-opacity">
						<button class="w3-small w3-button w3-blue w3-round-large <?=$negocio["id_n"] == $_SESSION["idNegocio"] ? "centrado \" style='display:block'" : "w3-left"?>" id="botonActualizarNegocio<?=$negocio["id_n"]?>">Actualizar datos</button>
						<?php if($negocio["id_n"] != $_SESSION["idNegocio"]): ?>
							<form method="POST" class="w3-right">
								<input type="hidden" name="idNegocio" value="<?=$negocio["id_n"]?>">
								<input type="submit" class="w3-button w3-small <?=$negocio["activo"] ? "w3-red" : "w3-green"?> w3-round-large" <?=$negocio["activo"] ? "name='desactivarNegocio' value='Desactivar'" : "name='activarNegocio' value='Activar'"?>>
							</form>
						<?php endif; ?>
						<div class="w3-clear"></div>
					</div>

				<!--==================================================
				=            Formulario `Actualizar info`            =
				===================================================-->
				<form method="POST" enctype="multipart/form-data" class="w3-margin-top formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="formularioActualizar<?=$negocio["id_n"]?>">
					<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
					<h3 class="swal2-title w3-margin-bottom">Actualizar Datos</h3>
					<section class="w3-padding-16 w3-container w3-margin-top w3-margin-left w3-margin-right">
						<div class="input">
							<div class="icono">
								<span class="icon-edit"></span>
							</div>
							<input type="text" name="nombreNegocio" placeholder="Nombre del negocio" autocomplete="off" autocapitalize="words" required minlength="4" maxlength="50" pattern="^[a-zA-ZáÁéÉíÍóÓúÚñÑ0-9\s]{4,50}$" title="Sólo se permiten entre 4 y 50 letras" value="<?=$negocio["nom_n"]?>">
						</div>
					</section>
					<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
						<div class="input">
							<div class="icono">
								<span class="icon-edit"></span>
							</div>
							<input type="text" name="rif" placeholder="RIF del negocio" autocomplete="off" autocapitalize required minlength="10" maxlength="15" pattern="^(v|e|V|E){1}\d{9,15}$" title="Debe empezar por V o E seguido de entre 9 y 15 dígitos" value="<?=$negocio["rif"]?>">
						</div>
					</section>
					<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
						<div class="input">
							<div class="icono">
								<span class="icon-edit"></span>
							</div>
							<input type="text" name="telefono" placeholder="Teléfono de contacto" maxlength="13" pattern="^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}" title="Ejemplo (+58 416-111-2222 o 0416-111-2222)" value="<?=$negocio["tlf_n"]?>">
						</div>
					</section>
					<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
						<div class="input">
							<div class="icono">
								<span class="icon-edit"></span>
							</div>
							<input type="text" name="direccion" placeholder="Dirección del negocio" maxlength="50" pattern="^([a-zA-Z\d\,\.\-\#\/]\s?){4,50}$" title="Sólo se permiten letras, números y símbolos (, . - / #)" value="<?=$negocio["direccion_n"]?>">
						</div>
					</section>
					<div class="w3-center w3-margin-top w3-container">
						<input class="w3-button w3-blue w3-round-xlarge" type="submit" value="Registrar" name="actualizarNegocio">
					</div>
					<input type="hidden" name="idNegocio" value="<?=$negocio["id_n"]?>">
				</form>
			</div>

			<!--============================================
			=            PANEL `LOGO DEL NEGOCIO`          =
			=============================================-->
			<form class="formulario-foto w3-quarter w3-center w3-white w3-leftbar w3-show" enctype="multipart/form-data" method="POST">
				<label for="foto<?=$negocio["id_n"]?>" class="w3-display-container w3-hover-opacity">
					<i class="icon-camera w3-xxxlarge w3-display-middle"></i>
					<input type="file" name="foto" class="w3-hide" id="foto<?=$negocio["id_n"]?>">
					<img class="image-result" src="<?=!empty($negocio["foto"]) ? "../imagenes/negocios/{$negocio['foto']}" : "../imagenes/logoNegocio.jpg"?>" id="foto<?=$negocio["id_n"]?>">
				</label>
				<input type="hidden" name="idNegocio" value="<?=$negocio["id_n"]?>">
				<input type="submit" name="actualizarFoto" value="Actualizar" class="w3-button w3-blue w3-round-large w3-section w3-animate-right w3-hide">
				<span><b class="w3-medium w3-white w3-block w3-margin-top"><?=$negocio["nom_n"]?></b></span>
				<span class="w3-small w3-white w3-block w3-text-blue">RIF-<?=$negocio["rif"]?></span>
			</form>
		</div>
	<?php endforeach; ?>
<?php endif ?>