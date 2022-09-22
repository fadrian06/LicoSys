<?php if(isset($mostrarPreguntas)): ?>
	<form method="POST" class="w3-margin-top formularioModal w3-padding-16 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show" id="formPreguntas">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h1 class="w3-xlarge">Recuperar Contraseña</h1>
		<b class="w3-text-teal w3-margin-bottom">Paso 2/3</b>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<label for="r1" class="w3-block w3-left-align w3-margin-bottom w3-margin-left">Pregunta 1: <b><?="{$registro["pre1"]}?"?></b></label>
			<div class="input">
				<div class="icono">
					<span class="icon-key"></span>
				</div>
				<input type="text" id="r1" name="respuesta1" placeholder="Respuesta" autofocus autocomplete="off" minlength="1" maxlength="20" required pattern="^[a-zA-Z0-9]{1,20}$" title="Sólo se permiten letras y números" value="<?=$respuesta1 ?? ""?>">
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<label for="r2" class="w3-block w3-left-align w3-margin-bottom w3-margin-left">Pregunta 2: <b><?="{$registro["pre2"]}?"?></b></label>
			<div class="input">
				<div class="icono">
					<span class="icon-key"></span>
				</div>
				<input type="text" id="r2" name="respuesta2" placeholder="Respuesta" autocomplete="off" minlength="1" maxlength="20" required pattern="^[a-zA-Z0-9]{1,20}$" title="Sólo se permiten letras y números" value="<?=$respuesta2 ?? ""?>">
			</div>
		</section>
		<section class="w3-padding-16 w3-container w3-margin-left w3-margin-right">
			<label for="r3" class="w3-block w3-left-align w3-margin-bottom w3-margin-left">Pregunta 3: <b><?="{$registro["pre3"]}?"?></b></label>
			<div class="input">
				<div class="icono">
					<span class="icon-key"></span>
				</div>
				<input type="text" id="r3" name="respuesta3" placeholder="Respuesta" autocomplete="off" minlength="1" maxlength="20" required pattern="^[a-zA-Z0-9]{1,20}$" title="Sólo se permiten letras y números" value="<?=$respuesta3 ?? ""?>">
			</div>
		</section>
		<div class="w3-margin-top w3-container">
			<input class="w3-margin-left w3-margin-right" type="submit" value="Consultar" name="enviarRespuestas">
		</div>
	</form>
<?php else: header("location: ../"); endif ?>