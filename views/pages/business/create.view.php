<?php

declare(strict_types=1);

use Leaf\BareUI;
use LicoSys\Enums\NombreInput;

$inputNombre = generarInput(NombreInput::NOMBRE_NEGOCIO, 'Nombre', 'Nombre del negocio');
$inputRIF = generarInput(NombreInput::RIF, 'RIF', 'RIF del negocio');
$inputTelefono = generarInput(NombreInput::TELEFONO, 'Teléfono', 'Teléfono de contacto');
$inputDireccion = generarInput(NombreInput::DIRECCION, 'Dirección', 'Dirección del negocio');

?>

<form
  id="registrarNegocio"
  class="w3-row modal w3-white w3-card w3-round-large w3-animate-zoom">
  <h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
    Registro de Negocio
  </h1>
  <?= BareUI::render('components/steps', ['stepsAmount' => 3, 'currentStep' => 1]) ?>
  <section class="w3-padding-top-24 w3-twothird w3-rightbar w3-topbar w3-bottombar w3-display-container">
    <i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
    <?= $inputNombre ?>
    <?= $inputRIF ?>
    <?= $inputTelefono ?>
    <?= $inputDireccion ?>
    <div class="w3-panel">
      <button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
        Registrar
      </button>
    </div>
  </section>
  <section class="w3-third w3-topbar w3-bottombar w3-center">
    <?= BareUI::render('components/input-image', [
      'name' => 'logo',
      'defaultImageSrc' => './assets/images/logoNegocio.jpg',
      'placeholder' => 'Subir logo',
      'label' => 'Logotipo del negocio',
    ]) ?>
  </section>
</form>
