<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

final class IndexTest extends FeatureTestCase
{
  #[Test]
  public function index_is_working(): void
  {
    $response = self::$client->get('./');

    self::assertSame(200, $response->getStatusCode());
    self::assertStringContainsString('text/html', strtolower($response->getHeaderLine('content-type')));
  }
}
