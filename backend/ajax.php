<?php
	if (!empty($_POST = json_decode(file_get_contents('php://input'), true))):
		
		if (isset($_POST['ajax']))
			exit(200);
		
	endif;
?>