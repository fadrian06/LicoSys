<?php

declare(strict_types=1);

use Leaf\BareUI;
use LicoSys\Enums\NombreInput;

$inputPRE1 = generarInput(NombreInput::pre1, 'Pregunta 1:', 'Cree una pregunta');
$inputPRE2 = generarInput(NombreInput::pre2, 'Pregunta 2:', 'Cree una pregunta');
$inputPRE3 = generarInput(NombreInput::pre3, 'Pregunta 3:', 'Cree una pregunta');

$label = '<b>Respuesta 1:</b> <sup respuesta="res1" class="w3-text-blue"></sup>';
$inputRES1 = generarInput(NombreInput::res1, $label, 'La respuesta');

$label = '<b>Respuesta 2:</b> <sup respuesta="res2" class="w3-text-blue"></sup>';
$inputRES2 = generarInput(NombreInput::res2, $label, 'La respuesta');

$label = '<b>Respuesta 3:</b> <sup respuesta="res3" class="w3-text-blue"></sup>';
$inputRES3 = generarInput(NombreInput::res3, $label, 'La respuesta');

?>

<form
  id="registrarPreguntasRespuestas"
  autocomplete="off"
  class="modal w3-white w3-card w3-round-large w3-animate-zoom">
  <h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
    Cree sus Preguntas y Respuestas
  </h1>
  <?= BareUI::render('components/steps', ['stepsAmount' => 3, 'currentStep' => 3]) ?>
  <div class="w3-row w3-display-container w3-topbar">
    <i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
    <section class="w3-padding-top-24 w3-half w3-rightbar">
      <?= $inputPRE1 ?>
      <?= $inputPRE2 ?>
      <?= $inputPRE3 ?>
    </section>
    <section class="w3-padding-top-24 w3-half w3-leftbar">
      <?= $inputRES1 ?>
      <?= $inputRES2 ?>
      <?= $inputRES3 ?>
    </section>
  </div>
  <div class="w3-margin-top w3-center">
    <button
      class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block"
      style="width: 50%; margin: auto">
      Registrar
    </button>
    <br>
    <button type="button" id="masTarde" class="w3-button w3-round-xlarge w3-ripple w3-margin-bottom">
      Más tarde
    </button>
  </div>
</form>
