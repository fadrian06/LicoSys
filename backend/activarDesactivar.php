<?php

if (!$_POST) exit;

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/conexion.php';
require __DIR__ . '/funciones.php';

enum Action: string {
  case Activate = 'activar';
  case Disactivate = 'desactivar';

  function toInt(): int {
    return (int) ($this === self::Activate);
  }
}

enum Table: string {
  case Users = 'usuarios';
  case Businesses = 'negocios';
}

class JSONResponse {
  private string $ok = '';
  private string $error = '';
  private array $data = [];
  private int $code = 200;

  function setOkMessage(string $message): static {
    $this->ok = $message;

    return $this;
  }

  function getOkMessage(): string {
    return $this->ok;
  }

  function setErrorMessage(string $error, int $code): static {
    $this->error = $error;
    $this->code = $code;

    return $this;
  }

  function send(): never {
    Flight::response()
      ->status($this->code)
      ->write(json_encode([
        'ok' => $this->ok,
        'error' => $this->error,
        'datos' => $this->data
      ]))
      ->send();

    exit;
  }
}

$data = Flight::request()->data;
$response = new JSONResponse;
$db = new Sparrow;
$db->setDb($conexion);

try {
  /** @var Table La tabla a la que pertenece el registro. */
  $table = Table::from($data['tabla']);
} catch (ValueError) {
  $response
    ->setErrorMessage("Tabla no soportada ('usuarios' | 'negocios')", 400)
    ->send();
}

/** @var string Campo que identifica cada registro. */
$field = escapar($data['campo']);
/** @var int Valor único de cada registro. */
$value = (int) escapar($data['valor']);

try {
  $action = Action::from($data['accion']);
} catch (ValueError) {
  $response
    ->setErrorMessage("Por favor envie una opción válida ('activar' o 'desactivar')", 400)
    ->send();
}

try {
  $db->from($table->value)
    ->where($field, $value)
    ->update(['activo' => $action->toInt()])
    ->execute();

  $response->setOkMessage(sprintf(
    '%s %s exitósamente.',
    $table === Table::Users ? 'Usuario' : 'Negocio',
    $action === Action::Activate ? 'activado' : 'desactivado'
  ));
} catch (Exception) {
  $response->setErrorMessage('Ha ocurrido un error', 500);
}

$response->send();
