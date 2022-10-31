<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php"; ?>
<?php
	$productos = getRegistros("SELECT * FROM inventario WHERE stock<=5");
	if($productos):
		$casiAgotados = false;
		$notificacion = "<script>advertencia('";
		foreach($productos as $producto):
			if(!$producto["stock"]):
				$notificacion .= "{$producto['nom_p']}<br><b>AGOTADO</b>";
				break;
			else:
				$notificacion .= "{$producto['nom_p']}<br>";
				$casiAgotados = true;
			endif;
		endforeach;
		if($casiAgotados) $notificacion .= "<b>CASI AGOTADO(S)</b>";
		$notificacion .= "')</script>";
	endif;
?>