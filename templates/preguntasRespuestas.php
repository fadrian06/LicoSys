<?php
	if (isset($_SESSION['showQuestions'])):
		$inputRES1 = generarINPUT('res1', "{$_SESSION['pre1']}?", '', '');
		$inputRES2 = generarINPUT('res2', "{$_SESSION['pre2']}?", '', '');
		$inputRES3 = generarINPUT('res3', "{$_SESSION['pre3']}?", '', '');
		$sql = <<<SQL
			SELECT id FROM usuarios WHERE pre1='{$_SESSION['pre1']}'
			AND pre2='{$_SESSION['pre2']}' AND pre3='{$_SESSION['pre3']}'
		SQL;
		$id = getRegistro($sql)['id'];
		$inputID = generarINPUT('ID', '', '', "$id");
		echo <<<HTML
			<form id="preguntasRespuestas" autocomplete="off" class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-show">
				<div class="w3-right-align">
					<span class="icon-close w3-button w3-transparent w3-hover-red"></span>
				</div>
				<h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
					Recuperar Contraseña
				</h1>
				<div class="step-container">
					<div class="step"><span>1</span></div>
					<div class="step"><span class="w3-blue">2</span></div>
					<div class="step"><span>3</span></div>
				</div>
				<section class="w3-display-container">
					<i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
					$inputID
					$inputRES1
					$inputRES2
					$inputRES3
				</section>
				<section class="w3-panel">
					<button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
						Enviar Respuestas
				</button>
				</section>
			</form>
		HTML;
	endif;
?>