<?php

use Backend\Classes\Response;
use Backend\Enums\Action;
use Backend\Enums\Table;

if ($_POST) :
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/conexion.php';
  require_once __DIR__ . '/funciones.php';

  $table = Table::from($_POST['tabla']);

  /** Campo que identifica cada registro */
  $field = escapar($_POST['campo']);

  /** Valor único de cada registro */
  $value = (int) escapar($_POST['valor']);
  $response = (new Response)->appendOkMessage($table->getEntityName());
  $action = Action::tryFrom($_POST['accion']) ?? $response->sendWithError(Action::Error);

  switch ($action):
    case Action::Enable:
      $sql = "UPDATE $table->value SET activo=1 WHERE $field=$value";
      $response->appendOkMessage(' activado exitósamente.');

      break;
    case Action::Disable:
      $sql = "UPDATE $table->value SET activo=0 WHERE $field=$value";
      $response->appendOkMessage(' desactivado exitósamente.');

      break;
  endswitch;

  setRegistro($sql) or $response->sendWithError($conexion->error);
  $response->send();
endif;
