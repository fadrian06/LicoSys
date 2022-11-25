<div class="contenedor">
	<!--=============================
	=            SIDEBAR            =
	==============================-->
	<aside class="bienvenida w3-display-container">
		<div class="widget w3-display-bottomright w3-margin-right"></div>
		<p class=" w3-xlarge widget fecha w3-margin-right w3-display-topright"><b>LicoSys <?=getUltimaVersion()?></b></p>
	</aside>

	<!--===============================================
	=            FORMULARIO INICIAR SESIÓN            =
	================================================-->
	<form method="POST" id="formLogin" class="w3-center w3-padding-large">
		<header class="w3-container w3-bottombar w3-border-black">
			<h1 class="w3-xlarge w3-margin-left">Iniciar Sesión</h1>
		</header>
		<section class="negocios w3-section">
			<b class="w3-block w3-margin-bottom w3-text-grey">Por favor seleccione un negocio:</b>
			<div class="input-radio">
				<?php foreach($negocios as $negocio): ?>
					<div class="radio-group tooltip-container">
						<input type="radio" name="negocio" id="negocio#<?=$negocio["id_n"]?>" value="<?=$negocio["id_n"]?>">
						<label for="negocio#<?=$negocio["id_n"]?>" style="background:url(<?=!empty($negocio["foto"]) ? "dist/images/negocios/{$negocio["foto"]}" : "dist/images/logoNegocio.jpg"?>) center/contain no-repeat"></label>
						<?=!isset($cambiarClave) ? "<span class='tooltip'>{$negocio['nom_n']}</span>" : ""?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<section class="w3-padding-16">
			<div class="input">
				<div class="icono">
					<span class="icon-user-circle-o"></span>
				</div>
				<input type="text" name="usuario" placeholder="Ingrese su usuario" value="<?=$usuario ?? ""?>" autofocus required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w-]{4,20}$" title="Sólo se permiten entre 4 y 20 letras, números o guiones(-)">
			</div>
		</section>
		<section class="w3-padding-16">
			<div class="input">
				<div class="icono">
					<span class="icon-lock"></span>
				</div>
				<input type="password" id="clave" name="clave" placeholder="Ingrese su contraseña" value="<?=$confirmar ?? ""?>" required minlength="4" maxlength="20" autocomplete="off" pattern="^[\w.-@#/*]{4,20}$" title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)">
				<div class="icono ver">
					<span class="icon-eye"></span>
				</div>
			</div>
		</section>
		<div class="submit w3-section">
			<input type="submit" name="login" value="Iniciar">
		</div>
		<a class="recuperarClave">¿Olvidó su contraseña?</a>
	</form>
</div>