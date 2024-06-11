<?php

namespace Backend\Enums;

enum Action: string {
  case Enable = 'activar';
  case Disable = 'desactivar';
  const Error= "Por favor envie una opción ('activar' o 'desactivar')";
}
