<?php

namespace Backend\Enums;

enum Table: string {
  case Users = 'usuarios';
  case Businesses = 'negocios';

  function getEntityName(): string {
    return match ($this) {
      self::Users => 'Usuario',
      self::Businesses => 'Negocio'
    };
  }
}
