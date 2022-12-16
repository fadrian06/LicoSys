<?php
	session_start();
	if (!isset($_SESSION['activa'])) header('location: index.php');
	
	include 'templates/head.php';
?>

<a href="salir.php" class="w3-button w3-white">Salir</a>

<?php include 'templates/footer.php' ?>