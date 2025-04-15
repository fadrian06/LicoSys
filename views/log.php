<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['activa'])) {
  header('location: ../salir.php');
}

if ($_SESSION['cargo'] === 'a') :
  require __DIR__ . '/../backend/componentes.php';
  require __DIR__ . '/../backend/conexion.php';
  require __DIR__ . '/../backend/funciones.php';

  echo LOADER;
  echo '<div id="moduloLog">';
  $sql = <<<SQL
      SELECT fecha, nombre, usuario, telefono FROM log
      INNER JOIN usuarios ON usuario_id=id
      WHERE negocio_id={$_SESSION['negocioID']}
      GROUP BY usuario_id ORDER BY fecha DESC
    SQL;

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
    echo '<footer id="botones">' . BOTONES['VACIAR_LOG'] . '</footer>';
  }

  echo '</div>';
else :
  include __DIR__ . '/../templates/head.php';
  $script .= sprintf("<script src='%sassets/js/restringido.js'></script>", $BASE_URL);
  include __DIR__ . '/../templates/footer.php';
endif;
