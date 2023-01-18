<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: index.php');
	
	include 'templates/head.php';
	
	$versiones = getRegistros('SELECT * FROM versiones ORDER BY id DESC');

	$data = getAPI('https://s3.amazonaws.com/dolartoday/data.json', 'json/dolarToday.json');
	$dolarFecha = $data['_timestamp']['fecha'];
	$dolarT     = $data['USD']['transferencia'];
	$dolarE     = $data['USD']['efectivo'];

	$data = getAPI('https://api.exchangedyn.com/markets/quotes/usdves/bcv', 'json/bcv.json');
	$dolarBCV = round($data['sources']['BCV']['quote'], 2);
	
	$sql = <<<SQL
		SELECT fecha, foto, nombre, usuario FROM log
		INNER JOIN usuarios ON usuario_id=id
		WHERE negocio_id={$_SESSION['negocioID']}
		GROUP BY usuario_id ORDER BY fecha DESC
	SQL;
	$recientes = getRegistros($sql);
?>

<main class="w3-container w3-light-gray">
	<?=LOADER?>
	<h1 class="w3-xlarge w3-padding-16">
		<i class="icon-dashboard"></i> Administración
	</h1>
	<!--=============================
	=            WIDGETS            =
	==============================-->
	<section class="w3-row-padding w3-margin-bottom">
		<?php if($_SESSION['cargo'] === 'a'): ?>
			<a href="views/ventas.php" role="navegacion" class="w3-quarter w3-hover-opacity">
				<div class="w3-container w3-red w3-padding-16">
					<i class="icon-list-alt w3-xxxlarge w3-left"></i>
					<span class="w3-right w3-xlarge"><?=contarRegistros('ventas')?></span>
					<div class="w3-clear"></div>
					<span class="w3-large w3-block w3-margin-top">Ventas</span>
				</div>
			</a>
			<a href="views/compras.php" role="navegacion" class="w3-quarter w3-hover-opacity">
				<div class="w3-container w3-blue w3-padding-16">
					<i class="icon-handshake-o w3-xxxlarge w3-left"></i>
					<span class="w3-right w3-xlarge"><?=contarRegistros('compras')?></span>
					<div class="w3-clear"></div>
					<span class="w3-large w3-block w3-margin-top">Compras</span>
				</div>
			</a>
		<?php endif ?>
		<a href="views/inventario.php" role="navegacion" class="<?=$_SESSION['cargo'] === 'a' ? 'w3-quarter' : 'w3-half'?> w3-hover-opacity">
			<div class="w3-container w3-teal w3-padding-16">
				<i class="icon-product-hunt w3-xxxlarge w3-left"></i>
				<span class="w3-right w3-xlarge"><?=contarRegistros('inventario')?></span>
				<div class="w3-clear"></div>
				<span class="w3-large w3-block w3-margin-top">Productos</span>
			</div>
		</a>
		<a href="<?=$_SESSION['cargo'] === 'a' ? 'views/usuarios.php' : 'views/clientes.php'?>" role="navegacion" class="<?=$_SESSION['cargo'] === 'a' ? 'w3-quarter' : 'w3-half'?> w3-hover-opacity">
			<div class="w3-container w3-orange w3-text-white w3-padding-16">
				<i class="icon-users w3-xxxlarge w3-left"></i>
				<span class="w3-right w3-xlarge">
					<?=$_SESSION['cargo'] === 'a' ? contarRegistros('usuarios') - 1 : contarRegistros('clientes')?>
				</span>
				<div class="w3-clear"></div>
				<span class="w3-large w3-block w3-margin-top">
					<?=$_SESSION['cargo'] === 'a' ? 'Usuarios' : 'Clientes'?>
				</span>
			</div>
		</a>
	</section>
	<!--=============================
	=            MONEDAS            =
	==============================-->
	<div class="w3-row">
		<?php include 'templates/monedas.php' ?>
		<section class="w3-half w3-container w3-padding-24 w3-animate-opacity">
			<h2 class="w3-large w3-text-green">DOLAR TODAY</h2>
			<table class="w3-table w3-bordered w3-border w3-hoverable w3-pale-green">
				<tr>
					<td>Fecha</td>
					<td colspan="3">
						<b><i class="w3-small"><?=$dolarFecha?></i></b>
					</td>
				</tr>
				<tr>
					<td>DÓLAR (Bs.)</td>
					<td><b><i class="w3-small">BCV </i><?=$dolarBCV?></b></td>
					<td><b><i class="w3-small">Transferencia </i><?=$dolarT?></b></td>
					<td><b><i class="w3-small">Efectivo </i><?=$dolarE?></b></td>
				</tr>
			</table>
		</section>
	</div>
	<?php if($_SESSION['cargo'] === 'a' && $recientes): ?>
		<!--========================================
		=            USUARIOS RECIENTES            =
		=========================================-->
		<section class="w3-row w3-container w3-border-bottom w3-padding-24">
			<ul class="w3-half w3-ul w3-card-4 w3-white">
				<a href="views/log.php" role="navegacion" class="w3-button w3-block w3-border-bottom w3-light-gray w3-text-indigo w3-xlarge">
					Usuarios recientes
				</a>
				<?php foreach($recientes as $usuario): ?>
					<li class="w3-padding-16">
						<img src="<?=!empty($usuario['foto']) ? "images/perfil/{$usuario['foto']}" : "images/avatar2.png"?>" class="w3-circle w3-margin-right" style="width: 50px">
						<span class="w3-large"><?=$usuario['nombre']?></span>
					</li>
				<?php endforeach ?>
			</ul>
		</section>
	<?php endif ?>
	<!--===================================
	=            PIE DE PÁGINA            =
	====================================-->
	<footer class="w3-dark-grey w3-container" style="margin: 0 -16px">
		<div class="w3-row">
			<div class="w3-container w3-third">
				<h2 class="w3-xlarge oswald w3-bottombar w3-border-orange">Sistema</h2>
				<button onclick="modal(this)" data-target="#acercaDe" class="w3-block w3-left-align w3-button w3-transparent">Acerca De</button>
				<button onclick="modal(this)" data-target="#registroCambios" class="w3-block w3-left-align w3-button w3-transparent">Registro de cambios</button>
				<button onclick="modal(this)" data-target="#soporte" class="w3-block w3-left-align w3-button w3-transparent">Soporte Técnico</button>
				<button onclick="modal(this)" data-target="#manual" class="w3-block w3-left-align w3-button w3-transparent">Manual de Usuario</button>
			</div>
		</div>
		<p class="w3-center w3-large">
			Powered by
			&nbsp;<a href="https://www.w3schools.com/w3css/default.asp" target="_blank">
				w3.css
			</a>
			&nbsp;| <i class="icon-copyright"></i> UPTM <?=date('Y')?>
		</p>
	</footer>
	
	<?php
		/*===========================================
		=            REGISTRO DE CAMBIOS            =
		===========================================*/
		$listaVersiones = '';
		foreach($versiones as $version)
			$listaVersiones .= <<<HTML
				<dt class="w3-tag w3-blue">{$version['nombre']}</dt>
					<dd class="w3-small w3-margin-bottom">{$version['descripcion']}</dd>
			HTML;
		$contenido = <<<HTML
			<dl class="w3-container">$listaVersiones</dl>
		HTML;
		generarModal('div', 'registroCambios', 'Registro de Cambios', $contenido);
		
		/*=======================================
		=            SOPORTE TÉCNICO            =
		=======================================*/
		$contenido = <<<HTML
			<dl class="w3-left-align w3-container">
				<dt class="w3-tag w3-blue">
					<i class="icon-envelope-o"></i> Correo Electrónico
				</dt>
					<dd class="w3-section w3-hover-text-grey">
						<u>
							<a href="mailto:franyeradriansanchez@gmail.com">
								franyeradriansanchez@gmail.com
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<u>
							<a href="mailto:ftutorials610@gmail.com">
								ftutorials610@gmail.com
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<u>
							<a href="mailto:franyeradriansanchez@outlook.com">
								franyeradriansanchez@outlook.com
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<u>
							<a href="mailto:franyersanchez06@hotmail.com">
								franyersanchez06@hotmail.com
							</a>
						</u>
					</dd>
				<dt class="w3-tag w3-blue">
					<i class="icon-phone-square"></i> Teléfono
				</dt>
					<dd class="w3-section w3-hover-text-grey">
						<i class="icon-whatsapp w3-text-green"> </i>
						<u>
							<a target="_blank" href="https://api.whatsapp.com/send?phone=04165335826">
								+58 416-533-5826
							</a>
						</u>
					</dd>
					<dd class="w3-section w3-hover-text-grey">
						<i class="icon-whatsapp w3-text-green"> </i>
						<u>
							<a target="_blank" href="https://api.whatsapp.com/send?phone=04165462946">
								+58 416-546-2946
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<i class="icon-telegram w3-text-blue"> </i>
						<u>
							<a target="_blank" href="https://t.me/fsanchez61001">
								+58 416-533-5826
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<i class="icon-telegram w3-text-blue"> </i>
						<u>
							<a target="_blank" href="https://t.me/YenderSanchez">
								+58 424-715-7381
							</a>
						</u>
					</dd>
			</dl>
		HTML;
		generarModal('div', 'soporte', 'Soporte Técnico', $contenido);
		
		/*=========================================
		=            MANUAL DE USUARIO            =
		=========================================*/
		$titulo = <<<HTML
			<span class="w3-padding">Manual de Usuario</span>
		HTML;
		$contenido = '';
		generarModal('div', 'manual', $titulo, $contenido);
	?>
	<footer id="botones"><?=BOTONES['NUEVA_VENTA']?></footer>
</main>

<?php include 'templates/footer.php' ?>