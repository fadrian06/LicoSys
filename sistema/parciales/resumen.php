<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<?php if($_SESSION["cargo"] == "a"): ?>
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
<?php endif ?>