<?php

declare(strict_types=1);

use Leaf\Http\Session;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

if ($_POST !== []) :
  $cedula = (int) $_POST['cedula'];
  $nombrePersona = escapar($_POST['nombre']);
  $rif = escapar($_POST['rif']);
  $nombreEmpresa = escapar($_POST['nombreNegocio']);
  $telefono = escapar($_POST['telefono']);
  $direccion = escapar(capitalize($_POST['direccion']));

  /*====================================
  =            VALIDACIONES            =
  ====================================*/
  if ($cedula === 0 || ($nombrePersona === '' || $nombrePersona === '0')) {
    $respuesta['error'] = 'Los datos de persona de contacto son requeridos.';
  }

  if ($rif === '' || $rif === '0' || ($nombreEmpresa === '' || $nombreEmpresa === '0')) {
    $respuesta['error'] = 'El RIF y el nombre de empresa son requeridos.';
  }

  $proveedorEncontrado = consulta(sprintf("SELECT rif FROM proveedores WHERE rif='%s'", $rif));
  if ($proveedorEncontrado !== null && $proveedorEncontrado !== 0) {
    $respuesta['error'] = 'Ya existe un proveedor con ese RIF.';
  }

  /*=====  End of VALIDACIONES  ======*/

  if ($respuesta['error']) {
    exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
  }

  $userId = Session::get('userID');
  $negocioId = Session::get('negocioID');

  $sql = <<<SQL
      INSERT INTO proveedores(cedula, nombre, rif, nombreEmpresa,
        telefono, direccion, usuario_id, negocio_id
      ) VALUES({$cedula}, '{$nombrePersona}', '{$rif}', '{$nombreEmpresa}', '{$telefono}',
        '{$direccion}', {$userId}, {$negocioId}
      )
    SQL;

  $resultado = setRegistro($sql);

  if ($resultado === null || $resultado === 0) {
    $respuesta['error'] = $conexion->error;
  }

  $respuesta['ok'] = 'Proveedor registrado exitósamente.';

  exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
endif;
