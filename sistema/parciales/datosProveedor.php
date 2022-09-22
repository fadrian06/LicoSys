<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php if($_SESSION["cargo"] == "a"): ?>
	<section class="w3-container w3-padding-24 w3-bottombar w3-border-gray w3-round-large">
		<h2>Datos del Proveedor</h2>
		<button id="registrarProveedor" class="w3-button w3-green w3-circle w3-large">+</button>
		<div class="w3-dropdown-hover">
			<button class="w3-button w3-blue w3-hover-blue w3-hover-text-black w3-medium">Seleccionar Proveedor</button>
			<div class="w3-dropdown-content w3-bar-block w3-card w3-light-grey" id="proveedor">
				<input class="w3-input w3-padding" type="text" placeholder="Buscar.." id="buscarProveedor" onkeyup="filterFunction(this.id, 'proveedor');">
				<?php
					foreach($proveedores as $proveedor):
						echo "
							<button class='w3-bar-item w3-button botonProveedor'>
								<span>{$proveedor['proveedor']}</span>
								<span class='w3-hide'>{$proveedor['id_p']}</span>
							</button>
						";
					endforeach;
				?>
			</div>
		</div>
		<input class="w3-button w3-disabled w3-border w3-border-black inputProveedor" type="text" disabled>
		<b class="w3-button w3-disabled w3-border w3-border-black">ID-<?=$_SESSION["idProveedor"] ?? ""?></b>
	</section>
<?php endif ?>