<?php

declare(strict_types=1);

/**
 * @var string $name
 * @var string $defaultImageSrc
 * @var string $placeholder
 * @var string $label
 */

assert(is_string($name));
assert(is_string($defaultImageSrc));
assert(is_string($placeholder));
assert(is_string($label));

$required ??= false;
$id = uniqid();

?>

<label
  class="w3-block w3-display-container w3-hover-opacity"
  style="cursor: pointer"
  for="<?= $id ?>"
  x-data="{
    imageSrc: '<?= $defaultImageSrc ?>',
  }">
  <span
    class="icon-camera w3-xxxlarge w3-display-middle w3-display-hover"
    style="pointer-events: none; text-shadow: 0 0 .25rem white">
  </span>
  <input
    id="<?= $id ?>"
    type="file"
    accept="image/jpeg,image/png"
    name="<?= $name ?>"
    class="w3-hide"
    @input="
      const { files } = $el;

      if (!files) {
        return alerta('No se ha seleccionado ningún archivo').show();
      }

      const [image] = files;

      if (
        image.type !== 'image/jpeg'
        && image.type !== 'image/jpg'
        && image.type !== 'image/png'
      ) {
        return alerta('El archivo debe ser una imagen JPEG o PNG').show();
      }

      if (image.size > 1 * 1000 * 1024 * 2) {
        return alerta('El archivo no debe superar los 2MB').show();
      }

      const fileReader = new FileReader();
      fileReader.readAsDataURL(image);

      fileReader.onload = () => {
        const { result } = fileReader;

        if (!result) {
          return alerta('No se pudo leer el archivo').show();
        }

        imageSrc = result.toString();
      }
    " />
  <img
    class="w3-image"
    :src="imageSrc"
    width="150"
    style="pointer-events: none" />
</label>
<div class="w3-container w3-margin-top w3-center">
  <label for="<?= $id ?>" class="w3-button w3-round-xlarge w3-blue w3-ripple">
    <span class="icon-upload"></span>
    <?= $placeholder ?>
  </label>
</div>

<b class="w3-white w3-block w3-margin-top w3-margin-bottom">
  <?= $label ?>
</b>
<?php if ($required) : ?>
  <b class="w3-margin-bottom w3-white w3-block w3-text-red">Requerido</b>
<?php else : ?>
  <b class="w3-margin-bottom w3-white w3-block w3-text-blue">Opcional</b>
<?php endif ?>
