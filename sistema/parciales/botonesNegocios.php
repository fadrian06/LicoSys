<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php if(isset($_SESSION["cargo"]) && $_SESSION["cargo"] == "a"): ?>
	<div class="w3-col s12 m3 l3 w3-padding-24 w3-ul w3-center">
		<ul class="menuNegocios w3-ul w3-card w3-white w3-tiny w3-center">
			<?php foreach($negocios as $negocio): if($negocio["activo"]): ?>
				<li class="botonNegocio w3-button w3-block w3-rightbar" id="botonNegocio<?=$negocio["id_n"]?>">
					<i class="icon-building w3-large"></i>
					<div><?=$negocio["nom_n"]?></div>
				</li>
			<?php endif; endforeach; ?>
		</ul>
		<details class="w3-margin-top">
			<summary><b class="w3-margin-left w3-small">Desactivados</b></summary>
			<ul class="menuNegocios w3-ul w3-card w3-white w3-tiny w3-center">
				<?php foreach($negocios as $negocio): if(!$negocio["activo"]): ?>
					<li class="botonNegocio w3-button w3-block w3-red" id="botonNegocio<?=$negocio["id_n"]?>">
						<i class="icon-building w3-large"></i>
						<div><?=$negocio["nom_n"]?></div>
					</li>
				<?php endif; endforeach; ?>
			</ul>
		</details>
		<button class="w3-button w3-card w3-blue w3-circle w3-margin-top w3-padding-16" id="botonAgregarNegocio">
			<i class="icon-plus w3-large"></i>
			<b class="w3-small w3-block">Nuevo</b>
		</button>
	</div>
<?php endif ?>