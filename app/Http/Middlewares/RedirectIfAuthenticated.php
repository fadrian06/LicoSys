<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use Illuminate\Container\Container;
use Psr\Http\Message\ResponseFactoryInterface;

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!empty($_SESSION['activa'])) {
  return Container::getInstance()->get(ResponseFactoryInterface::class)
    ->createResponse()
    ->withHeader('location', 'dashboard.php');
}

return null;
