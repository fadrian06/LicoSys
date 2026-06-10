<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use GuzzleHttp\Psr7\HttpFactory;

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!empty($_SESSION['activa'])) {
  return (new HttpFactory)
    ->createResponse()
    ->withHeader('location', 'dashboard.php');
}

return null;
