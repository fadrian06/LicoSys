<?php

/*=================================
=            ACERCA DE            =
=================================*/
if (!empty($negocios) and !empty($admin)) :
  $titulo = 'Acerca de <small>LicoSys</small>';
  $contenido = <<<HTML
			<div class="w3-row">
				<div class="w3-third w3-padding-large w3-center">
					<img src="images/logo.png" class="w3-image">
				</div>
				<p class="w3-padding-large w3-rest w3-xlarge w3-justify">
					&nbsp;&nbsp;&nbsp;LicoSys es un sistema administrativo que 
					simplifica los procesos que se llevan a cabo para la correcta 
					gestión de cualquier negocio.
				</p>
			</div>
			<ul class="w3-container w3-ul w3-large w3-justify">
				<li class="w3-margin">
					<i class="icon-check"></i>
					Realiza procesos de <b>transacción de bienes</b>.
				</li>
				<li class="w3-margin">
					<i class="icon-check"></i>
					Consulta facturas ordenadas.
				</li>
				<li class="w3-margin">
					<i class="icon-check"></i>
					Registra a tus <b>clientes</b> y <b>proveedores</b> más frecuentes.
				</li>
				<li class="w3-margin">
					<i class="icon-check"></i>
					Gestiona a tus <b>vendedores</b>.
				</li>
				<li class="w3-margin">
					<i class="icon-check"></i>
					Convierte <b>monedas</b>.
				</li>
				<li class="w3-margin">
					<i class="icon-check"></i>
					Monitorea el <b>dólar</b> en todas sus variantes.
				</li>
				<li class="w3-margin">
					<i class="icon-check"></i>
					Analiza el desempaño de tu <b>negocio</b>.
				</li>
				<li class="w3-margin">
					<i class="icon-check"></i>
					Consulta tus <b>finanzas</b>.
				</li>
			</ul>
			<p class="w3-container w3-large w3-justify">
				Todo desde la comodidad de tu equipo preferido, LicoSys funciona tanto 
				en <b>computadoras</b> como en <b>smartphones y tablets</b>, su entorno 
				es web con lo cual sólo necesitarás un navegador y consume la 
				aplicación.
			</p>
			<img src="images/devices.jpg" class="w3-image">
			<p class="w3-container w3-large w3-justify">
				&nbsp;&nbsp;&nbsp;LicoSys está fuertemente centrado en la 
				<b>experiencia de usuario</b> y la <b>seguridad de la información</b>.
			</p>
			<p class="w3-container w3-large w3-justify">
				&nbsp;&nbsp;&nbsp;Utilizar el sistema es sumamente sencillo, 
				con unos pocos pasos y pocos clics, habrás registrado lo necesario 
				para que la aplicación funcione correctamente.
			</p>
		HTML;

  generarModal('div', 'acercaDe', $titulo, $contenido);
endif;
