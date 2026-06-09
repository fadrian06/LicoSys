<?php

declare(strict_types=1);

namespace Tests\Unit;

use Override;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\ExpectationFailedException;

final class IndexTest extends UnitTestCase
{
  #[Override]
  public function setUp(): void
  {
    parent::setUp();

    error_reporting(E_ALL);
    ob_start(static fn(): string => '');
  }

  #[Override]
  public function tearDown(): void
  {
    parent::tearDown();
    ob_end_clean();
  }

  #[Test]
  public function session_is_started(): void
  {
    require_once __DIR__ . '/../../index.php';

    try {
      self::assertSame(PHP_SESSION_ACTIVE, session_status());
    } catch (ExpectationFailedException) {
      exit('Session is not started.');
    }
  }
}
