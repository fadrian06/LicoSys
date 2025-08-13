<?php

declare(strict_types=1);

use Leaf\BareUI;
use LicoSys\Enums\NombreInput;

$inputCedula = generarInput(NombreInput::CEDULA, 'Cédula', 'Introduce tu cédula');
$inputNombre = generarInput(NombreInput::NOMBRE, 'Nombre', 'Introduce tu nombre');
$inputUsuario = generarInput(NombreInput::USUARIO, 'Usuario', '@usuario');
$inputClave = generarInput(NombreInput::CLAVE, 'Contraseña', 'Cree una contraseña');
$inputConfirmar = generarInput(NombreInput::CONFIRMAR, 'Repetir contraseña', 'Repite la contraseña');
$inputTelefono = generarInput(NombreInput::TELEFONO, 'Teléfono', 'Introduce un número de teléfono');

?>

<form
  id="registrarAdmin"
  autocomplete="off"
  class="w3-row modal w3-white w3-card w3-round-large w3-animate-zoom">
  <h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
    Cree su cuenta de Administrador
  </h1>
  <?= BareUI::render('components/steps', ['stepsAmount' => 3, 'currentStep' => 2]) ?>
  <section class="w3-padding-top-24 w3-twothird w3-rightbar w3-topbar w3-bottombar w3-display-container">
    <i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
    <?= $inputCedula ?>
    <?= $inputNombre ?>
    <?= $inputUsuario ?>
    <?= $inputClave ?>
    <?= $inputConfirmar ?>
    <?= $inputTelefono ?>
    <div class="w3-panel">
      <button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
        Registrar
      </button>
    </div>
  </section>
  <section class="w3-third w3-topbar w3-bottombar w3-center">
    <label for="foto" class="w3-display-container w3-hover-opacity w3-circle">
      <i class="icon-camera w3-xxxlarge w3-display-middle w3-display-hover"></i>
      <input type="file" id="foto" accept="image/jpeg,image/png" name="foto" class="w3-hide">
      <img class="image-result w3-image" src="./assets/images/avatar1.png" width="150" />
    </label>
    <div class="w3-container w3-margin-top w3-center">
      <label for="foto" class="w3-button w3-round-xlarge w3-blue w3-ripple">
        <i class="icon-upload"></i> Subir foto
      </label>
    </div>
    <b class="w3-white w3-block w3-margin-top w3-margin-bottom">
      Foto de perfil
    </b>
    <b class="w3-margin-bottom w3-white w3-block w3-text-blue">Opcional</b>
  </section>
</form>
