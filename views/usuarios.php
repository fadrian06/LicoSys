<?php

declare(strict_types=1);

use Leaf\BareUI;
use Leaf\Http\Session;
use LicoSys\Enums\NombreInput;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../backend/componentes.php';
require_once __DIR__ . '/../backend/conexion.php';
require_once __DIR__ . '/../backend/funciones.php';

if (!Session::has('activa')) {
  header('location: ../salir.php');
}

if (Session::get('cargo') === 'a') :
  echo BareUI::render('components/loader');
  echo '<div id="moduloUsuarios">';

  $sql = "SELECT cedula, nombre, usuario, telefono FROM usuarios WHERE cargo='v' AND activo=1 ORDER BY cedula";
  $usuarios = getRegistros($sql);

  $sql = "SELECT cedula, nombre, usuario, telefono FROM usuarios WHERE cargo='v' AND activo=0 ORDER BY cedula";

  $desactivados = [
    'tabla' => 'usuarios',
    'campo' => 'cedula',
    'enlace' => 'views/usuarios.php',
    'filas' => getRegistros($sql) ?? [],
  ];

  $encabezados = [
    'escritorio' => ['C.I', 'Nombre', 'Usuario', 'Teléfono'],
    'movil' => ['C.I', 'Usuario'],
  ];

  $datos = [
    'camposEscritorio' => ['cedula', 'nombre', 'usuario', 'telefono'],
    'camposMovil' => ['cedula', 'usuario'],
    'filas' => $usuarios ?? [],
  ];

  tabla(
    'Usuarios',
    $encabezados,
    $datos,
    'No hay usuarios registrados.',
    $desactivados
  );

  $label = '<b>Cédula: </b><sup class="w3-text-red">(requerido)</sup>';
  $inputCedula = generarInput(NombreInput::CEDULA, $label, 'Cédula del empleado');

  $label = '<b>Nombre: </b><sup class="w3-text-red">(requerido)</sup>';
  $inputNombre = generarInput(NombreInput::NOMBRE, $label, 'Nombre del empleado');

  $label = '<b>Usuario: </b><sup class="w3-text-red">(requerido)</sup>';
  $inputUsuario = generarInput(NombreInput::USUARIO, $label, 'Cree un usuario');

  $label = '<b>Contraseña: </b><sup class="w3-text-red">(requerido)</sup>';
  $inputClave = generarInput(NombreInput::CLAVE, $label, 'Crea una contraseña');

  $label = '<b>Confirmar contraseña: </b><sup class="w3-text-red">(requerido)</sup>';
  $inputConfirmar = generarInput(NombreInput::CONFIRMAR, $label, 'Repite la contraseña');

  $label = '<b>Teléfono: </b><sup class="w3-text-blue">(opcional)</sup>';
  $inputTelefono = generarInput(NombreInput::TELEFONO, $label, 'Introduce un teléfono');
  echo <<<HTML
      <form
        id="registrarUsuario"
        autocomplete="off"
        class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster w3-hide">
        <div class="w3-right-align">
          <span class="icon-close w3-button w3-transparent w3-hover-red"></span>
        </div>
        <h1 class="w3-center w3-xlarge oswald w3-margin-bottom">
          Registrar Usuario
        </h1>
        <section class="w3-display-container">
          <i class="w3-spin icon-spinner w3-display-middle w3-jumbo loader"></i>
          {$inputCedula}
          {$inputNombre}
          {$inputUsuario}
          {$inputClave}
          {$inputConfirmar}
          {$inputTelefono}
        </section>
        <section class="w3-panel">
          <button class="w3-button w3-round-xlarge w3-blue w3-ripple w3-block">
            Registrar
          </button>
        </section>
      </form>
    HTML;

  echo '<footer id="botones">' . BareUI::render('components/quick-action-button', [
    'tag' => 'button',
    'background' => 'blue',
    'icon' => 'icon-user-plus',
    'props' => [
      'onclick="modal(this)"',
      'data-target="#registrarUsuario"',
    ],
    'size' => 'normal',
    'slot' => 'Registrar Usuario',
  ]) . '</footer>';
  echo '</div>';
else :
  include __DIR__ . '/../templates/head.php';
  $script = sprintf("<script src='%sassets/js/restringido.js'></script>", $BASE_URL);
  include __DIR__ . '/../templates/footer.php';
endif;
