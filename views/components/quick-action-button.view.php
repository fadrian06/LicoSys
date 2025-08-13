<?php

declare(strict_types=1);

/**
 * @var string $tag
 * @var 'blue'|'black' $background
 * @var string $icon
 * @var string[] $props
 * @var 'small'|'normal'|'large' $size
 */

assert(is_string($tag));
assert(is_string($background));
assert(is_string($icon));
assert(is_string($size));

$class ??= '';
$props ??= [];
$slot = str_replace(' ', '<br />', $slot ?? '');

if ($background === 'blue') {
  $class = "w3-blue w3-text-black $class";
} elseif ($background === 'black') {
  $class = "w3-black $class";
}

// $icon .= match ($size) {
//   'small' => ' w3-xlarge',
//   'normal' => ' w3-xxlarge',
//   'large' => ' w3-xxxlarge',
// };

if ($size === 'small') {
  $icon .= ' w3-xlarge';
  $slot = "<small>$slot</small>";
} elseif ($size === 'normal') {
  $icon .= ' w3-xxlarge';
} elseif ($size === 'large') {
  $icon .= ' w3-xxxlarge';
}

?>

<<?= $tag ?>
  class="w3-button w3-circle w3-border w3-border-black <?= $class ?>"
  style="aspect-ratio: 1/1; text-transform: capitalize"
  <?= join(' ', $props) ?>>
  <span class="w3-block w3-center <?= $icon ?>"></span>
  <?= $slot ?>
</<?= $tag ?>>
