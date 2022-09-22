<?php require "parciales/head.php" ?>
<?php
	$consultaClientes="SELECT * FROM cliente ORDER BY cliente";
	$resultado=mysqli_query($conexion, $consultaClientes);
	$clientes=mysqli_fetch_all($resultado, MYSQLI_ASSOC);
	mysqli_free_result($resultado);

	$consultaProductos="SELECT * FROM inventario ORDER BY nom_p";
	$resultado=mysqli_query($conexion, $consultaProductos);
	$productos=mysqli_fetch_all($resultado, MYSQLI_ASSOC);
	mysqli_free_result($resultado);

	(isset($_GET["cliente"]))?$_SESSION["cliente"]=$_GET["cliente"]:"";

	if(isset($_GET["producto"])):
		$_SESSION["codigo"]=$_GET["cod"];
		$_SESSION["producto"]=$_GET["producto"];
		$_SESSION["stock"]=$_GET["stock"];
		$_SESSION["precioB"]=(float) $_GET["precioB"];
	endif;
	if(isset($_GET["cantidad"])):
		$_SESSION["cantidad"]=(int) $_GET["cantidad"];
		$_SESSION["precioT"]=(float) ($_SESSION["cantidad"] * $_SESSION["precioB"]);

		$codigo=$_SESSION["codigo"];
		$producto=$_SESSION["producto"];
		$stock=$_SESSION["stock"];
		$precioB=$_SESSION["precioB"];
		$cantidad=$_SESSION["cantidad"];
		$precioT=$_SESSION["precioT"];

		$consulta="SELECT * FROM datos_temporales WHERE cod='$codigo'";
		$consulta=mysqli_query($conexion, $consulta);
		if(mysqli_num_rows($consulta)==0):
			$insertar="INSERT INTO datos_temporales VALUES('$codigo', '$producto', $stock, $precioB, $cantidad, $precioT)";
			$ejecucion=mysqli_query($conexion, $insertar);
		endif;
	endif;

	$consultaCarrito="SELECT * FROM datos_temporales";
	$consultaCarrito=mysqli_query($conexion, $consultaCarrito);
	$datosCarrito=mysqli_fetch_all($consultaCarrito, MYSQLI_ASSOC);
	mysqli_free_result($consultaCarrito);
?>
<main class="w3-main w3-container">
	<header class="w3-container">
		<h2>Datos del Cliente</h2>
	</header>
	<div class="w3-dropdown-click w3-dropdown-hover">
		<button class="w3-button w3-blue w3-hover-blue w3-hover-text-black" onclick="dropFunction('cliente')">Seleccionar Cliente</button>
		<div class="w3-dropdown-content w3-bar-block w3-card w3-light-grey" id="cliente">
			<input class="w3-input w3-padding" type="text" placeholder="Buscar.." id="buscarCliente" onkeyup="w3.filterHTML()">
			<?php
				foreach($clientes as $cliente):
					echo "<a class='w3-bar-item w3-button' href='?cliente={$cliente['cliente']}'>{$cliente['cliente']}</a>";
				endforeach;
			?>
		</div>
	</div>
	<input class="w3-button w3-border w3-border-black" type="text" disabled value="<?=(isset($_SESSION["cliente"]))?$_SESSION["cliente"]:"" ?>"><br>
	<header class="w3-container">
		<h2>Datos de la Venta</h2>
	</header>
	<section class="w3-row-padding">
		<div class="w3-col w3-half">
			<p class="w3-text-gray"><i class="icon-user w3-text-black"></i>Vendedor</p>
			<span class="w3-text-blue">
				<?=$_SESSION["nombreUsuario"] ?></span>
		</div>
		<div class="w3-col w3-half">
			<p class="w3-text-grey">Acciones</p>
			<a href="nuevaVenta.php" class="w3-button w3-red w3-round-large">Anular Venta</a>
			<a href="#" class="w3-button w3-blue w3-round-large">Generar Venta</a>
		</div>
	</section><br>
	<section class="w3-responsive">
		<table class="w3-table w3-centered">
			<tr class="w3-dark-gray">
				<th>Nombre del Producto</th>
				<th>Código</th>
				<th>Existencia</th>
				<th>Precio</th>
				<th>Cantidad</th>
				<th>Precio Total</th>
				<th>Acciones</th>
			</tr>
			<tr>
				<td style="height: 125px">
					<div class="w3-dropdown-click w3-dropdown-hover">
						<button class="w3-button w3-grey" onclick="dropFunction('producto')">Seleccionar Producto</button>
						<div class="w3-dropdown-content w3-bar-block w3-card w3-light-grey" id="producto">
							<input class="w3-input w3-padding" type="text" placeholder="Buscar.." id="buscarProducto" onkeyup="filterFunction('buscarCliente', 'producto')">
							<?php
								foreach($productos as $producto):
									echo "<a class='w3-bar-item w3-button' href='?producto=${producto['nom_p']}&cod=${producto['cod']}&stock=${producto['stock']}&precioB=${producto['precio_b']}'>${producto['nom_p']}</a>";
								endforeach;
							?>
						</div>
					</div>
				</td>
				<form>
					<td><input disabled class="w3-input w3-center" type="text" name="codigo" value="<?=(isset($_GET['cod']))?$_GET['cod']:'' ?>"></td>
					<td><input disabled class="w3-input w3-center" type="text" name="stock" value="<?=(isset($_GET["stock"]))?$_GET['stock']:'' ?>"></td>
					<td><input disabled class="w3-input w3-center" type="text" name="precioB" id="precio" value="<?=(isset($_GET["precioB"]))?$_GET["precioB"]:"" ?>"></td>
					<td><input class="w3-input" type="number" name="cantidad" id="cantidad" onkeyup="precioTotal()" onchange="precioTotal()" min="0" max="20"></td>
					<td><input disabled class="w3-input w3-center" type="number" name="precioT" id="precioT"></td>
					<td><?=(isset($_GET["producto"]))?"<button class='w3-button w3-blue w3-round-large' type='submit' formaction='' formmethod='GET' name='agregarProducto'>Agregar</button>":""?></td>
				</form>
			</tr>
		</table>
	</section>
	<section class="w3-responsive">
		<table class="w3-table w3-centered">
			<tr class="w3-dark-gray">
				<th>Nombre del Producto</th>
				<th>Código</th>
				<th>Existencia</th>
				<th>Precio</th>
				<th>Cantidad</th>
				<th>Precio Total</th>
				<th>Acciones</th>
			</tr>
			<?php foreach($datosCarrito as $datoCarrito): ?>
				<tr>
					<td><input class="w3-input w3-center" type="text" name="nombreProducto" value="<?=$datoCarrito['nom_p'] ?>"></td>
					<td><input class="w3-input w3-center" type="text" name="codigoProducto" value="<?=$datoCarrito['cod'] ?>"></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</section>
</main>
<?php include "parciales/footer.php" ?>