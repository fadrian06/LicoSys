<?php
	include 'templates/head.php';
?>
	<main class="w3-main" id="index">
		<header class="w3-container w3-padding-16">
			<h1 class="w3-xlarge"><i class="icon-dashboard"> </i>Administración</h1>
		</header>
		<section class="w3-half w3-container w3-padding-24 <?=!isset($data) ? 'w3-hide' : ''?> w3-animate-opacity" id="dolarToday">
			<h5 class="w3-text-green">DOLAR TODAY</h5>
			<table class="w3-table w3-bordered w3-border w3-hoverable w3-pale-green">
				<tr>
					<td>Fecha</td>
					<td colspan="3"><b id="fD"><i class="w3-small"><?=$dolarFecha?></i></b></td>
				</tr>
				<tr>
					<td>DÓLAR (Bs.)</td>
					<td><b id="dBCV"><i class="w3-small">BCV </i><?=$dolarBCV?></b></td>
					<td><b id="dT"><i class="w3-small">Transferencia </i><?=$dolarT?></b></td>
					<td><b id="dE"><i class="w3-small">Efectivo </i><?=$dolarE?></b></td>
				</tr>
			</table>
		</section>
		<section class="w3-container w3-section">
			<h5>Recent Comments</h5>
			<div class="w3-row">
				<div class="w3-col m2 text-center">
					<img class="w3-circle" src="images/avatar3.png" style="width:96px;height:96px">
				</div>
				<div class="w3-col m10 w3-container">
					<h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
					<p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
				</div>
			</div>
			<div class="w3-row">
				<div class="w3-col m2 text-center">
					<img class="w3-circle" src="images/avatar1.png">
				</div>
				<div class="w3-col m10 w3-container">
					<h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
					<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
				</div>
			</div>
		</section>
	</main>
<?php include "templates/footer.php" ?>