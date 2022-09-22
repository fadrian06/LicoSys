<?php require_once "partial/head.php"; ?>
<?php
	$numeroVentas    = CONTAR_REGISTROS("venta");
	$numeroCompras   = CONTAR_REGISTROS("compra");
	$numeroProductos = CONTAR_REGISTROS("inventario");
	$numeroUsuarios  = CONTAR_REGISTROS("usuario");
	$numeroClientes  = CONTAR_REGISTROS("cliente");

	$negocio = (int) $_SESSION["negocio"];
	$usuariosRecientes = CONSULTA("SELECT DISTINCT nom_u FROM log INNER JOIN usuario ON log.ci_u=usuario.ci_u WHERE id_n=$negocio ORDER BY fecha DESC LIMIT 3");
?>
<!--======================================
=            PÁGINA PRINCIPAL            =
=======================================-->
<main class="w3-main">
	<!--================================
	=            ENCABEZADO            =
	=================================-->
	<header class="w3-container w3-padding-16">
		<h1 class="w3-xlarge"><i class="icon-dashboard"> </i>Administración</h1>
	</header>

	<!--=============================
	=            WIDGETS            =
	==============================-->
	<section class="w3-row-padding w3-margin-bottom">
		<a href="ventas.php" class="w3-quarter w3-hover-opacity">
			<div class="w3-container w3-red w3-padding-16">
				<i class="icon-list-alt w3-xxxlarge w3-left"></i>
				<span class="w3-right w3-xlarge"><?=$numeroVentas?></span>
				<div class="w3-clear"></div>
				<span class="w3-large w3-block w3-margin-top">Ventas</span>
			</div>
		</a>
		<a href="compras.php" class="w3-quarter w3-hover-opacity">
			<div class="w3-container w3-blue w3-padding-16">
				<i class="icon-handshake-o w3-xxxlarge w3-left"></i>
				<span class="w3-right w3-xlarge"><?=$numeroCompras?></span>
				<div class="w3-clear"></div>
				<span class="w3-large w3-block w3-margin-top">Compras</span>
			</div>
		</a>
		<a href="inventario.php" class="w3-quarter w3-hover-opacity">
			<div class="w3-container w3-teal w3-padding-16">
				<i class="icon-product-hunt w3-xxxlarge w3-left"></i>
				<span class="w3-right w3-xlarge"><?=$numeroProductos?></span>
				<div class="w3-clear"></div>
				<span class="w3-large w3-block w3-margin-top">Productos</span>
			</div>
		</a>
		<a href="<?=($_SESSION['cargo']=='a') ? 'usuarios.php' : 'clientes.php'?>" class="w3-quarter w3-hover-opacity">
			<div class="w3-container w3-orange w3-text-white w3-padding-16">
				<i class="icon-users w3-xxxlarge w3-left"></i>
				<span class="w3-right w3-xlarge"><?=($_SESSION["cargo"]=="a") ? $numeroUsuarios : $numeroClientes; ?></span class="w3-right w3-xlarge">
				<div class="w3-clear"></div>
				<span class="w3-large w3-block w3-margin-top"><?=($_SESSION["cargo"]=="a") ? "Usuarios" : "Clientes"?></span>
			</div>
		</a>
	</section>

	<!--=============================
	=            RESÚMEN            =
	==============================-->
	<section class="w3-border-bottom">
		<div class="w3-row-padding w3-padding-24">
			<div class="w3-col m5 l5 w3-mobile">
				<h2 class="w3-large">Resúmen de Ventas</h2>
				<img src="../imagenes/region.jpg" alt="Google Regional Map" class="w3-image">
			</div>
			<div class="w3-col m7 l7 w3-mobile">
				<h2 class="w3-large">&nbsp;</h2>
				<table class="w3-table w3-striped w3-white">
					<tr>
						<td><i class="icon-user w3-text-blue w3-large"></i></td>
						<td>New record, over 90 views.</td>
						<td><i>10 mins</i></td>
					</tr>
					<tr>
						<td><i class="icon-bell w3-text-red w3-large"></i></td>
						<td>Database error.</td>
						<td><i>15 mins</i></td>
					</tr>
					<tr>
						<td><i class="icon-users w3-text-yellow w3-large"></i></td>
						<td>New record, over 40 users.</td>
						<td><i>17 mins</i></td>
					</tr>
					<tr>
						<td><i class="icon-comment w3-text-red w3-large"></i></td>
						<td>New comments.</td>
						<td><i>25 mins</i></td>
					</tr>
					<tr>
						<td><i class="icon-bookmark w3-text-blue w3-large"></i></td>
						<td>Check transactions.</td>
						<td><i>28 mins</i></td>
					</tr>
					<tr>
						<td><i class="icon-laptop w3-text-red w3-large"></i></td>
						<td>CPU overload.</td>
						<td><i>35 mins</i></td>
					</tr>
					<tr>
						<td><i class="icon-share-alt w3-text-green w3-large"></i></td>
						<td>New shares.</td>
						<td><i>39 mins</i></td>
					</tr>
				</table>
			</div>
		</div>
	</section>

	<!--==================================
	=            ESTADÍSTICAS            =
	===================================-->
	<section class="w3-container w3-border-bottom w3-padding-24">
		<h5>General Stats</h5>
		<p>New Visitors</p>
		<div class="w3-grey w3-row">
			<div class="w3-col s3 m3 l3 w3-container w3-center w3-padding w3-green">+25%</div>
		</div>
		<p>New Users</p>
		<div class="w3-grey w3-row">
			<div class="w3-col s6 m6 l6 w3-container w3-center w3-padding w3-orange">50%</div>
		</div>
		<p>Bounce Rate</p>
		<div class="w3-grey w3-row">
			<div class="w3-col s9 m9 l9 w3-container w3-center w3-padding w3-red">75%</div>
		</div>
	</section>

	<!--=====================================
	=            Section comment            =
	======================================-->
	<section class="w3-container w3-border-bottom w3-padding-24">
		<h5>Countries</h5>
		<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
			<tr>
				<td>United States</td>
				<td>65%</td>
			</tr>
			<tr>
				<td>UK</td>
				<td>15.7%</td>
			</tr>
			<tr>
				<td>Russia</td>
				<td>5.6%</td>
			</tr>
			<tr>
				<td>Spain</td>
				<td>2.1%</td>
			</tr>
			<tr>
				<td>India</td>
				<td>1.9%</td>
			</tr>
			<tr>
				<td>France</td>
				<td>1.5%</td>
			</tr>
		</table><br>
		<button class="w3-button w3-dark-grey">More Countries &blacktriangleright;</button>
	</section>

	<!--========================================
	=            USUARIOS RECIENTES            =
	=========================================-->
	<?php if($_SESSION["cargo"]=="a"): ?>
		<section class="w3-container w3-border-bottom w3-padding-24">
			<a href="log.php" class="w3-button w3-text-indigo w3-xlarge">Usuarios recientes</a>
			<ul class="w3-ul w3-card-4 w3-white">
				<?php foreach($usuariosRecientes as $usuarioReciente): ?>
					<li class="w3-padding-16">
						<img src="../imagenes/avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
						<span class="w3-medium"><?=$usuarioReciente["nom_u"]?></span><br>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>

	<!--=====================================
	=            Section comment            =
	======================================-->
	<section class="w3-container w3-section">
		<h5>Recent Comments</h5>
		<div class="w3-row">
			<div class="w3-col m2 text-center">
				<img class="w3-circle" src="../imagenes/avatar3.png" style="width:96px;height:96px">
			</div>
			<div class="w3-col m10 w3-container">
				<h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
				<p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
			</div>
		</div>
		<div class="w3-row">
			<div class="w3-col m2 text-center">
				<img class="w3-circle" src="../imagenes/avatar1.png">
			</div>
			<div class="w3-col m10 w3-container">
				<h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
				<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
			</div>
		</div>
	</section>

	<!--===================================
	=            PIE DE PÁGINA            =
	====================================-->
	<footer class="w3-container w3-dark-grey w3-padding-32">
		<div class="w3-row">
			<div class="w3-container w3-third">
				<h5 class="w3-bottombar w3-border-green">Demographic</h5>
				<p>Language</p>
				<p>Country</p>
				<p>City</p>
			</div>
			<div class="w3-container w3-third">
				<h5 class="w3-bottombar w3-border-red">System</h5>
				<p>Browser</p>
				<p>OS</p>
				<p>More</p>
			</div>
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
	<!--==================================
	=            FONDO OSCURO            =
	===================================-->
	<div class="overlayModal w3-overlay w3-animate-opacity w3-hide"></div>
	<!--========================================
	=            REGISTRO CAMBIOS              =
	=========================================-->
	<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalRegistroCambios">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h3 class="swal2-title w3-margin-bottom">Registro de Cambios</h3>
		<dl class="w3-left-align w3-container">
			<?php foreach($versiones as $version): ?>
				<dt class="w3-tag w3-blue"><?=$version["nombre_v"]?></dt>
					<dd class="w3-small w3-margin-bottom"><?=$version["descripcion"]?></dd>
			<?php endforeach; ?>
		</dl>
	</div>
	<!--====  End of REGISTRO CAMBIOS  ====-->

	<!--========================================
	=            SOPORTE TÉCNICO               =
	=========================================-->
	<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalSoporteTecnico">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h3 class="swal2-title w3-margin-bottom">Soporte técnico</h3>
		<dl class="w3-left-align w3-container">
			<dt class="w3-tag w3-blue">Correo Electrónico</dt>
			<dd class="w3-margin-bottom w3-hover-text-grey"><a href="mailto:franyeradriansanchez@gmail.com">franyeradriansanchez@gmail.com</a></dd>
			<dt class="w3-tag w3-blue">Teléfono</dt>
			<dd class="w3-margin-bottom w3-hover-text-grey"><u>+58 416-533-5826</u></dd>
		</dl>
	</div>
	<!--====  End of SOPORTE TÉCNICO  ====-->

	<!--========================================
	=            ACERCA DE                     =
	=========================================-->
	<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalAcercaDe">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h3 class="swal2-title w3-margin-bottom">Acerca de <small>LicoSys</small></h3>
	</div>
	<!--====  End of ACERCA DE  ====-->

	<!--==========================================
	=            MANUAL DE USUARIO               =
	===========================================-->
	<div class="w3-margin-top w3-row formularioModal w3-padding-24 w3-display-container w3-center w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide" id="modalManual">
		<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
		<h3 class="swal2-title w3-margin-bottom">Manual de Usuario</h3>
	</div>
	<!--====  End of MANUAL DE USUARIO  ====-->
</main>
<!--====  End of PÁGINA PRINCIPAL  ====-->
<?php require_once "partial/footer.php" ?>