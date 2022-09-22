<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<div class="w3-threequarter w3-margin-top w3-container w3-card w3-white w3-hide" id="panelSeguridad">
	<h2 class="w3-large w3-padding w3-border-bottom w3-text-blue">Seguridad</h2>
	<div class="w3-clear"></div>
	<div class="w3-row">
		<!--==========================================
		=            SECCIÓN `CONTRASEÑA`            =
		===========================================-->
		<ul class="w3-half w3-ul w3-small w3-hide w3-bottombar" id="infoClave">
			<li>
				<span class="w3-tag w3-indigo w3-left">Contraseña:</span>
				<b class="w3-right">**********</b>
				<div class="w3-clear"></div>
			</li>
			<button class="centrado w3-hide w3-button w3-indigo w3-section w3-round-large" id="botonActualizarClave">Cambiar contraseña</button>
		</ul>

		<!--======================================================
		=            SECCIÓN `PREGUNTAS Y RESPUESTAS`            =
		=======================================================-->
		<ul class="w3-half w3-ul w3-small w3-border-left w3-hide w3-bottombar" id="preguntas">
			<li>
				<span class="w3-tag w3-pale-blue w3-left">Pregunta #1:</span>
				<b class="w3-right"><?="{$_SESSION["pregunta1"]}?" ?? "<span class='w3-text-red'>No definida</span>"?></b>
				<div class="w3-clear"></div>
			</li>
			<li>
				<span class="w3-tag w3-blue w3-left">Respuesta #1:</span>
				<b class="w3-right"><?=!empty($_SESSION["respuesta1"]) ? "**********" : "<span class='w3-text-red'>No definida</span>"?></b>
				<div class="w3-clear"></div>
			</li>
			<br>
			<li>
				<span class="w3-tag w3-pale-blue w3-left">Pregunta #2:</span>
				<b class="w3-right"><?="{$_SESSION["pregunta2"]}?" ?? "<span class='w3-text-red'>No definida</span>"?></b>
				<div class="w3-clear"></div>
			</li>
			<li>
				<span class="w3-tag w3-blue w3-left">Respuesta #2:</span>
				<b class="w3-right"><?=!empty($_SESSION["respuesta2"]) ? "**********" : "<span class='w3-text-red'>No definida</span>"?></b>
				<div class="w3-clear"></div>
			</li>
			<br>
			<li>
				<span class="w3-tag w3-pale-blue w3-left">Pregunta #3:</span>
				<b class="w3-right"><?="{$_SESSION["pregunta3"]}?" ?? "<span class='w3-text-red'>No definida</span>"?></b>
				<div class="w3-clear"></div>
			</li>
			<li>
				<span class="w3-tag w3-blue w3-left">Respuesta #3:</span>
				<b class="w3-right"><?=!empty($_SESSION["respuesta3"]) ? "**********" : "<span class='w3-text-red'>No definida</span>"?></b>
				<div class="w3-clear"></div>
			</li>
			<button class="centrado w3-button w3-blue w3-section w3-round-large w3-hide" id="botonActualizarPreguntas">Actualizar datos</button>
		</ul>
	</div>
</div>