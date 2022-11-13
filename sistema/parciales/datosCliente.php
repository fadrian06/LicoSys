<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<section class="w3-container w3-padding-24 w3-bottombar w3-border-gray w3-round-large">
	<h2>Datos del Cliente</h2>
	<button id="registrarCliente" class="w3-button w3-green w3-circle w3-large">+</button>
	<div class="w3-dropdown-click w3-dropdown-hover">
		<button class="w3-button w3-blue w3-hover-blue w3-hover-text-black w3-medium">Seleccionar Cliente</button>
		<div class="w3-dropdown-content w3-bar-block w3-card w3-light-grey" id="cliente">
			<input class="w3-input w3-padding" type="text" placeholder="Buscar.." id="buscarCliente" onkeyup="filterFunction(this.id, 'cliente')">
			<?php
				foreach($clientes as $cliente):
					echo "
						<button class='w3-bar-item w3-button botonCliente'>
							<span title='{$cliente['cliente']}'>v-{$cliente['ci_c']}</span>
							<span class='w3-hide'>{$cliente['cliente']}</span>
						</button>
					";
				endforeach;
			?>
		</div>
	</div>
	<input class="w3-button w3-disabled w3-border w3-border-black inputCliente" type="text" disabled value="No especificado">
	<b class="w3-button w3-disabled w3-border w3-border-black">v-<?=isset($_SESSION["ciCliente"]) ? $_SESSION["ciCliente"] : ""?></b>
</section>