<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Exception;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\ExpectationFailedException;
use Psr\Http\Message\ResponseInterface;

final class RedirectIfAuthenticatedTest extends UnitTestCase
{
  #[Test]
  public function redirect_to_dashboard_if_session_is_active(): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $_SESSION['activa'] = true;

    /** @var ?ResponseInterface */
    $response = require __DIR__ . '/../../app/Http/Middlewares/RedirectIfAuthenticated.php';

    try {
      self::assertInstanceOf(ResponseInterface::class, $response);
      self::assertTrue($response->hasHeader('location'));
      self::assertStringContainsString('dashboard.php', $response->getHeaderLine('location'));
    } catch (Exception) {
      exit('Session is not active. Please ensure that the session is properly started before running this test.');
    }
  }

  #[Test]
  public function does_not_redirect_if_session_is_inactive(): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $_SESSION['activa'] = false;

    /** @var ?ResponseInterface */
    $response = require __DIR__ . '/../../app/Http/Middlewares/RedirectIfAuthenticated.php';

    try {
      self::assertNull($response);
    } catch (ExpectationFailedException) {
      exit('Session is active. Please ensure that the session is properly set to inactive before running this test.');
    }
  }
}
