<?php

declare(strict_types=1);

use Leaf\BareUI;
use Leaf\Http\Session;

require_once __DIR__ . '/../vendor/autoload.php';

if (!Session::has('activa')) {
  header('location: ../salir.php');
}

if (Session::get('cargo') === 'a') :
  require_once __DIR__ . '/../backend/componentes.php';
  require_once __DIR__ . '/../backend/conexion.php';
  require_once __DIR__ . '/../backend/funciones.php';

  echo LOADER;
  echo '<div id="moduloLog">';

  $negocioId = Session::get('negocioID');

  $sql = "
    SELECT fecha, nombre, usuario, telefono FROM log
    INNER JOIN usuarios ON usuario_id=id
    WHERE negocio_id={$negocioId}
    GROUP BY usuario_id ORDER BY fecha DESC
  ";

  $encabezados = [
    'escritorio' => ['Fecha', 'Nombre', 'Usuario', 'Teléfono'],
    'movil' => ['Fecha', 'Usuario']
  ];

  $datos = [
    'camposEscritorio' => ['fecha', 'nombre', 'usuario', 'telefono'],
    'camposMovil' => ['fecha', 'usuario'],
    'filas' => getRegistros($sql) ?? [],
  ];

  foreach ($datos['filas'] as &$log) {
    $log['fecha'] = formatearFecha($log['fecha']);
  }

  unset($log);

  tabla(
    'Registro de Sesiones',
    $encabezados,
    $datos,
    'No hay registros de sesiones.'
  );

  if ($datos['filas'] !== []) {
    echo '<footer id="botones">' . BareUI::render('components/quick-action-button', [
      'tag' => 'button',
      'props' => [
        'onclick="vaciarLog()"',
      ],
      'background' => 'blue',
      'icon' => 'icon-trash',
      'slot' => 'Vaciar Registro',
      'size' => 'normal',
    ]) . '</footer>';
  }

  echo '</div>';
else :
  include __DIR__ . '/../templates/head.php';
  $script .= sprintf("<script src='%sassets/js/restringido.js'></script>", $BASE_URL);
  include __DIR__ . '/../templates/footer.php';
endif;
