<?php

declare(strict_types=1);

$stdout = file_get_contents('php://stdin') ?: '';
echo $stdout;

preg_match_all(
  '/^\s*(Classes|Methods|Paths|Branches|Lines):\s*([0-9.]+)%/m',
  $stdout,
  $matches,
  PREG_SET_ORDER
);

$failed = false;

foreach ($matches as $match) {
  $metric = $match[1];
  $percentage = (float) $match[2];

  if ($percentage < 100.0) {
    $failed = true;
  }
}

if (count($matches) < 5 || $failed) {
  exit(1);
}

exit(0);
