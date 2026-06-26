<?php

declare(strict_types=1);

namespace App;

use Leaf\BareUI as LeafBareUI;

final class BareUI extends LeafBareUI
{
  protected static $config = [];

  public function __construct(string $path, array $params = [])
  {
    $this->config('path', $path);
    $this->config('params', $params);
  }

  public static function setParam(string $name, mixed $value): void
  {
    self::$config['params'][$name] = $value;
  }

  protected static function getView(string $view): string
  {
    return $view;
  }
}
