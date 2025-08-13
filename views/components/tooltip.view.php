<?php

declare(strict_types=1);

/**
 * @var string $slot
 * @var 'start'|'center'|'end' $textAlignment
 */

assert(is_string($slot));

$textAlignment ??= 'center';

$class = match ($textAlignment) {
  'start' => 'w3-left-align',
  'center' => 'w3-center',
  'end' => 'w3-right-align',
};

?>

<div class="w3-dropdown-content w3-padding-small w3-card-4 w3-white <?= $class ?>">
  <b><?= $slot ?></b>
</div>
