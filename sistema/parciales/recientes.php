<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<?php if($_SESSION["cargo"]=="a"): ?>
	<section class="w3-container w3-border-bottom w3-padding-24">
		<a href="log.php" class="w3-button w3-text-indigo w3-xlarge">Usuarios recientes</a>
		<ul class="w3-ul w3-card-4 w3-white">
			<?php foreach($recientes as $usuario):?>
				<li class="w3-padding-16">
					<img src="<?=!empty($usuario['foto']) ? "../dist/images/perfil/{$usuario['foto']}" : "../dist/images/avatar2.png"?>" class="w3-circle w3-margin-right" style="width:50px">
					<span class="w3-large"><?=$usuario["nom_u"]?></span><br>
				</li>
			<?php endforeach ?>
		</ul>
	</section>
<?php endif ?>