<div class="contenedor w3-padding">
	<!--=============================
	=            SIDEBAR            =
	==============================-->
	<aside class="bienvenida w3-display-container w3-topbar w3-rightbar w3-bottombar w3-leftbar w3-border-black w3-round-xxlarge">
		<div class="widget w3-display-bottomright w3-margin-right"></div>
		<p class=" w3-xlarge widget fecha w3-margin-right w3-display-topright"><b>LicoSys <?=getUltimaVersion()?></b></p>
	</aside>

	<!--===============================================
	=            FORMULARIO INICIAR SESIÓN            =
	================================================-->
	<form method="POST" id="formLogin" class="w3-center w3-padding-large w3-topbar w3-rightbar w3-bottombar w3-leftbar w3-border-black">
		<header class="w3-left-align w3-container w3-bottombar w3-border-black">
			<h1 class="w3-xlarge w3-margin-left">Iniciar Sesión</h1>
		</header>
		<section class="negocios w3-section">
			<b class="w3-block w3-margin-bottom w3-text-grey">Por favor seleccione un negocio:</b>
			<div class="input-radio w3-row-padding">
				<?php foreach($negocios as $negocio):
					$logo = !empty($negocio['foto']) ? "negocios/{$negocio['foto']}" : 'logoNegocio.jpg';
					$span = isset($cambiarClave) ? '' : "<span class='tooltip'>{$negocio['nom_n']}</span>";
					echo <<<HTML
						<div class="w3-col s4 w3-margin-bottom w3-round-xxlarge radio-group tooltip-container">
							<input type="radio" name="negocio" id="negocio#{$negocio['id_n']}" value="{$negocio['id_n']}">
							<label class="w3-block w3-round-large" for="negocio#{$negocio['id_n']}" style="background: url('imagenes/$logo') center/contain no-repeat; height: 100%"></label>
							$span
						</div>
					HTML;
				endforeach ?>
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