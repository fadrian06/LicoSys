<?php

declare(strict_types=1);

/**
 * @var string $legend
 * @var string $icon
 * @var string $name
 * @var string[] $props
 */

assert(is_string($legend));
assert(is_string($icon));
assert(is_string($name));

$value ??= '';
$type ??= 'text';
$required ??= false;
$slot ??= '';
$withEye ??= false;
$withLoader ??= false;
$isEdge = str_contains($_SERVER['HTTP_USER_AGENT'], 'Edg');

?>

<fieldset class="w3-border-0">
  <legend class="w3-large w3-padding w3-bold">
    <?php if ($required) : ?>
      <sup class="w3-text-red">(requerido) </sup>
    <?php else : ?>
      <sup class="w3-text-blue">(opcional) </sup>
    <?php endif ?>
    <?= $legend ?>
  </legend>
  <div class="w3-row w3-center w3-border-bottom">
    <div class="w3-col s2 w3-xxlarge <?= $icon ?>"></div>
    <div
      class="w3-col s10 w3-display-container"
      x-data="{
        type: '<?= $type ?>',
        isValid: undefined,
        value: '<?= $value ?>'
      }">
      <input
        class="w3-input w3-border-0 w3-large"
        :type="type"
        :value="value"
        name="<?= $name ?>"
        @input="isValid = $el.checkValidity()"
        <?php if ($required) : ?>
        required
        <?php endif ?>
        <?= join(' ', $props) ?> />
      <?php if ($withEye && !$isEdge) : ?>
        <div
          class="w3-display-right w3-xxlarge"
          :class="type === 'password' ? 'icon-eye' : 'icon-eye-slash'"
          @click="type = type === 'password' ? 'text' : 'password'">
        </div>
      <?php endif ?>
      <?php if ($withLoader) : ?>
        <div class="w3-display-right w3-xxlarge w3-hide">
          <i class="w3-block w3-spin icon-spinner"></i>
        </div>
      <?php endif ?>
      <?php if ($type !== 'password') : ?>
        <div
          x-show="value"
          x-transition
          class="w3-display-right w3-xxlarge"
          :class="isValid ? 'w3-text-green icon-check' : 'w3-text-red icon-close'">
        </div>
      <?php endif ?>
    </div>
  </div>
</fieldset>
