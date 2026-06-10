<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!empty($_SESSION['activa'])) {
  header('location: dashboard.php');
}
