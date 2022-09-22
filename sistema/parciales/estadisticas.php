<?php @session_start(); if(!isset($_SESSION["activa"])) require_once "../salir.php" ?>
<?php if($_SESSION["cargo"] == "a"): ?>
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
<?php endif ?>