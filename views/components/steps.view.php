<?php

declare(strict_types=1);

/**
 * @var int $stepsAmount
 * @var int $currentStep
 */

assert(is_int($stepsAmount));
assert(is_int($currentStep));
assert($currentStep > 0 && $currentStep <= $stepsAmount);

?>

<div class="step-container">
  <?php for ($step = 1; $step <= $stepsAmount; ++$step) : ?>
    <div class="step">
      <?php if ($step === $currentStep) : ?>
        <span class="w3-blue"><?= $step ?></span>
      <?php else : ?>
        <span><?= $step ?></span>
      <?php endif ?>
    </div>
  <?php endfor ?>
</div>
