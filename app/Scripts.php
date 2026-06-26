<?php

declare(strict_types=1);

namespace App;

final class Scripts
{
  private static array $scripts = [];

  public static function push(string $script): void
  {
    self::$scripts[] = $script;
  }

  public static function pushSrc(string $src): void
  {
    self::push("<script src='$src'></script>");
  }

  public static function pushSrcOnce(string $src): void
  {
    static $sources = [];

    if (!in_array($src, $sources)) {
      $sources[] = $src;
      self::pushSrc($src);
    }
  }

  public static function toHtml(): string
  {
    return join('', self::$scripts);
  }

  public static function isEmpty(): bool
  {
    return empty(self::$scripts);
  }
}
