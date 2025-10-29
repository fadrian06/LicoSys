<?php

declare(strict_types=1);

/**
 * @var string $tag
 * @var string $id
 * @var bool $hidden
 * @var bool $withCloseButton
 * @var string $title
 */

assert(is_string($tag));
assert(is_string($id));
assert(is_string($title));

$hidden ??= true;
$withCloseButton ??= true;
$slot ??= '';
$class = $hidden ? 'w3-hide' : 'w3-show';

?>

<<?= $tag ?>
  id="<?= $id ?>"
  class="modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster <?= $class ?>">
  <?php if ($withCloseButton) : ?>
    <div class="w3-right-align">
      <span class="icon-close w3-button w3-transparent w3-hover-red"></span>
    </div>
  <?php endif ?>
  <h2 class="w3-center w3-xxlarge oswald w3-margin-bottom"><?= $title ?></h2>
  <?= $slot ?>
</<?= $tag ?>>
