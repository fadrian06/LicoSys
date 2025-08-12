<?php

declare(strict_types=1);

use Leaf\Http\Session;
use LicoSys\Enums\BOTONES;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../backend/componentes.php';
require_once __DIR__ . '/../backend/conexion.php';
require_once __DIR__ . '/../backend/funciones.php';

if (!Session::has('activa')) {
  header('location: ../salir.php');
}

/*=========================================
=            CONSULTAR FACTURA            =
=========================================*/
if (!empty($_GET['ventaID'])) :
  $ventaID = (int) escapar($_GET['ventaID']);

  $sql = <<<SQL
      SELECT n.nombre as nombreNegocio, n.tlf, n.direccion,
      c.nombre as nombreCliente, c.cedula, v.unidades,
      i.producto, i.precio, v.total
      FROM ventas v INNER JOIN negocios n INNER JOIN clientes c
      INNER JOIN inventario i
      ON v.negocio_id=n.id AND v.cliente_id=c.id AND v.producto_id=i.id
      WHERE v.id={$ventaID}
    SQL;

  $datos = getRegistro($sql);

  if ($datos === null || $datos === []) {
    $respuesta['error'] = $conexion->error;
  }

  $respuesta['datos'] = [
    'nombreNegocio'    => $datos['nombreNegocio'] ?? throw new Error('No se ha encontrado el negocio'),
    'telefonoNegocio'  => $datos['tlf'] ?? throw new Error('No se ha encontrado el telefono del negocio'),
    'direccionNegocio' => $datos['direccion'] ?? throw new Error('No se ha encontrado la direccion del negocio'),
    'nombreCliente'    => $datos['nombreCliente'] ?? throw new Error('No se ha encontrado el cliente'),
    'cedulaCliente'    => $datos['cedula'] ?? throw new Error('No se ha encontrado la cedula del cliente'),
    'cantidad' => $datos['unidades'] ?? throw new Error('No se ha encontrado la cantidad'),
    'producto' => $datos['producto'] ?? throw new Error('No se ha encontrado el producto'),
    'precio'   => $datos['precio'] ?? throw new Error('No se ha encontrado el precio'),
    'total'    => $datos['total'] ?? throw new Error('No se ha encontrado el total'),
    'iva'      => getIVA()
  ];

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;

echo LOADER;
echo '<div id="moduloVentas">';

/*=============================
=            TABLA            =
=============================*/
$negocioId = Session::get('negocioID');

$sql = "
  SELECT v.id, fecha, c.nombre, i.producto, unidades, total, usuario
  FROM ventas v INNER JOIN clientes c INNER JOIN inventario i INNER JOIN usuarios u
  ON v.cliente_id=c.id AND v.producto_id=i.id AND v.usuario_id=u.id
  WHERE v.negocio_id={$negocioId} ORDER BY fecha DESC
";

$encabezados = [
  'escritorio' => ['Fecha', 'Vendido a', 'Producto', 'Unidades', 'Total', 'Vendedor'],
  'movil' => ['Producto', 'Total']
];

$datos = [
  'camposEscritorio' => ['fecha', 'nombre', 'producto', 'unidades', 'total', 'usuario'],
  'camposMovil' => ['producto', 'total'],
  'filas' => getRegistros($sql) ?? []
];

foreach ($encabezados['escritorio'] as &$encabezado) {
  $encabezado = sprintf('<small>%s</small>', $encabezado);
}

unset($encabezado);

foreach ($datos['filas'] as &$venta) :
  $venta['fecha'] = formatearFecha($venta['fecha']);

  foreach ($venta as $clave => $valor) {
    $venta[$clave] = $valor === 'No Especificado'
      ? ''
      : sprintf('<small>%s</small>', $valor);
  }
endforeach;

unset($venta);

tabla('Ventas', $encabezados, $datos, 'No hay ventas registradas', false, false, true);

/*===================================
  =            VER FACTURA            =
  ===================================*/
generarModal('div', 'modalFactura', '', '');

echo '<footer id="botones">' . BOTONES::NUEVA_VENTA->value . '</footer>';
echo '</div>';
