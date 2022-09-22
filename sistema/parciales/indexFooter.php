<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<footer class="w3-dark-grey w3-container w3-padding-32">
	<div class="w3-row">
		<!-- <div class="w3-container w3-third">
			<h5 class="w3-bottombar w3-border-green">Demographic</h5>
			<p>Language</p>
			<p>Country</p>
			<p>City</p>
		</div> -->
		<!-- <div class="w3-container w3-third">
			<h5 class="w3-bottombar w3-border-red">System</h5>
			<p>Browser</p>
			<p>OS</p>
			<p>More</p>
		</div> -->
		<div class="w3-container w3-third">
			<h5 class="w3-bottombar w3-border-orange">Sistema</h5>
			<p id="acercaDeSistema" class="enlacesFooter">Acerca De</p>
			<p id="registroCambios" class="enlacesFooter">Registro de cambios</p>
			<p id="soporteTecnico" class="enlacesFooter">Soporte Técnico</p>
			<p id="manualUsuario" class="enlacesFooter">Manual de Usuario</p>
		</div>
	</div>
	<p class="w3-center w3-large">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a> | &copy; UPTM <?=date("Y")?></p>
</footer>