<?php

declare(strict_types=1);

namespace LicoSys\Enums {
  enum NombreInput {
    case CLAVE;
    case CONFIRMAR;
    case USUARIO;
    case CEDULA;
    case IVA;
    case DOLAR;
    case PESO;
    case res1;
    case res2;
    case res3;
    case NOMBRE;
    case TELEFONO;
    case NOMBRE_NEGOCIO;
    case RIF;
    case DIRECCION;
    case pre1;
    case pre2;
    case pre3;
    case ID;
    case CODIGO;
    case STOCK;
    case PRECIO;
    case EXCENTO;
    case BS;
  }
}

namespace {

  use LicoSys\Enums\NombreInput;

  /**
   * Genera una pequeña ventana emergente con el texto que desees.
   * <u>Requisitos</u>
   *
   * - Debe incluirse en un contenedor con la `class="w3-dropdown-hover"`
   * @param  string $texto El texto del tooltip.
   * @param  bool   $center Si quieres el tooltip centrado (Por defecto)
   * @return string        Texto HTML para incluir.
   */
  function generarTooltip(string $texto, bool $center = true): string {
    $centrado = $center ? 'w3-center' : 'w3-left-align';

    return <<<html
      <div class="w3-dropdown-content w3-padding-small w3-card-4 w3-white {$centrado}">
        <b>{$texto}</b>
      </div>
    html;
  }

  /**
   * Genera un `<input />` HTML
   * @param  string $label El título del `<input />`
   * @param  string $placeholder El placeholder del input.
   * @param string $value El valor por defecto del `<input />`
   * @return string El elemento `<input />`
   */
  function generarInput(
    NombreInput $nombre,
    string $label,
    string $placeholder = '',
    string $value = '',
  ): string {
    $expresiones = [
      'clave' => '[!#$%&/=?¿¡@+.\-\w]{4,20}',
    ];

    $id = uniqid();
    $value = $value === 'No establecido' ? "" : $value;

    return match ($nombre->name) {
      'CLAVE' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-key w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="password"
                    id="clave"
                    name="clave"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="4"
                    maxlength="20"
                    pattern="{$expresiones['clave']}"
                    title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)"
                    class="w3-input w3-border-0 w3-large">
                  <div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'CONFIRMAR' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-key w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="password"
                    id="confirmar"
                    name="confirmar"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="4"
                    maxlength="20"
                    pattern="{$expresiones['clave']}"
                    title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)"
                    class="w3-input w3-border-0 w3-large">
                  <div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'USUARIO' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-user-circle-o w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    id="usuario-{$id}"
                    name="usuario"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="4"
                    maxlength="20"
                    pattern="[\w\-]{4,20}"
                    title="Sólo se permiten entre 4 y 20 letras, números o guiones(-)"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-hide" id="usuarioLoader">
                    <i class="w3-block w3-spin icon-spinner"></i>
                  </div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'CEDULA' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-id-card w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="number"
                    id="cedula"
                    name="cedula"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    min="1"
                    max="40000000"
                    minlength="7"
                    maxlength="8"
                    pattern="[^e]?\d{7,8}"
                    title="Un número entre 7 y 8 dígitos"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'IVA' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-percent w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="number"
                    step="0.01"
                    id="iva"
                    name="iva"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="1"
                    maxlength="4"
                    pattern="((0\.[0-9])|[0-9]){2,3}"
                    title="Un número decimal o un porcentaje"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'DOLAR' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding">
                <b>{$label}</b>
              </legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-dollar w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="number"
                    step="0.01"
                    id="dolar"
                    name="dolar"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="1"
                    maxlength="4"
                    pattern="\d+\.?(\d{1,2})?"
                    title="Un número con decimales opcionales"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'BS' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="w3-col s2 w3-xxlarge">Bs</div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="number"
                    step="0.01"
                    id="bs"
                    name="bs"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    min="0"
                    minlength="1"
                    pattern="\d+\.?(\d{1,2})?"
                    title="Un número con decimales opcionales"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'PESO' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="w3-col s2 w3-xxlarge">P</div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="number"
                    id="pesos"
                    name="pesos"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    min="0"
                    pattern="[^e]?\d{1,4}"
                    title="Sólo se permiten números"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'res1', 'res2', 'res3' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-key w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="password"
                    id="{$nombre->name}"
                    name="{$nombre->name}"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="1"
                    maxlength="20"
                    pattern="[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ\s]{1,20}"
                    title="Sólo se permiten letras y números"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge icon-eye w3-show"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'NOMBRE' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-edit w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    id="nombre"
                    name="nombre"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="4"
                    maxlength="20"
                    pattern="[a-zA-ZáÁéÉíÍóÓúÚñÑ\s]{4,20}"
                    title="Sólo se permiten entre 4 y 20 letras"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'NOMBRE_NEGOCIO' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-building w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    id="nombreNegocio"
                    name="nombreNegocio"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="4"
                    maxlength="20"
                    pattern="[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ\s]{4,20}"
                    title="Sólo se permiten entre 4 y 20 letras, números y espacios"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'TELEFONO' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-phone w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="tel"
                    id="telefono"
                    name="telefono"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    maxlength="13"
                    pattern="(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}"
                    title="Ejemplo (+58 416-111-2222 o 0416-111-2222)"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'RIF' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-id-card w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    id="rif"
                    name="rif"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="10"
                    maxlength="15"
                    pattern="(v|e|V|E){1}\d{9,15}"
                    title="Debe empezar por V o E seguido de entre 9 y 15 dígitos"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'DIRECCION' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-map-marker w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    id="direccion"
                    name="direccion"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    maxlength="50"
                    pattern=".{4,50}"
                    title="Sólo se permiten letras, números y símbolos (, . - / #)"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'pre1', 'pre2', 'pre3' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-question-circle w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    id="{$nombre->name}"
                    name="{$nombre->name}"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    maxlength="50"
                    pattern="[\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\s]+"
                    title="Sólo se permiten hasta 30 letras y símbolos (¿ ?)"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'ID' => <<<HTML
            <input type="hidden" name="id" value="{$value}" class="w3-hide">
          HTML,
      'CODIGO' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-barcode w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    id="codigo"
                    name="codigo"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    minlength="3"
                    maxlength="10"
                    pattern=".{3,10}"
                    title="Sólo se permiten letras, números y símbolos (- . #)"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'STOCK' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-list-alt w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="number"
                    id="stock"
                    name="stock"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    min="0"
                    pattern="[^e]?[\d]+"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      'PRECIO' => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-dollar w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <input
                    type="number"
                    step="0.01"
                    id="precio"
                    name="precio"
                    placeholder="{$placeholder}"
                    value="{$value}"
                    required
                    min="0"
                    pattern="[\d.]+"
                    class="w3-input w3-border-0 w3-large" />
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
      default => <<<HTML
            <fieldset class="w3-border-0">
              <legend class="w3-large w3-padding"><b>{$label}</b></legend>
              <div class="w3-row w3-center w3-border-bottom">
                <div class="icon-question-circle w3-col s2 w3-xxlarge"></div>
                <div class="w3-col s10 w3-display-container">
                  <select
                    name="excento"
                    id="excento"
                    required
                    class="w3-input w3-border-0 w3-large">
                    <option disabled selected>{$placeholder}</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                  </select>
                  <div class="w3-display-right w3-xxlarge w3-text-green icon-check w3-hide"></div>
                  <div class="w3-display-right w3-xxlarge w3-text-red icon-close w3-hide"></div>
                </div>
              </div>
            </fieldset>
          HTML,
    };
  }

  /**
   * @param  string       $tipo      `div` o `form`
   * @param  string       $id        El ID del modal.
   * @param  string       $titulo    Contenido HTML para el título del modal.
   * @param  string       $contenido Contenido HTML para el contenido del modal.
   * @param  bool|boolean $cerrar    Si quieres agregar el botón de cerrar el modal, por defecto es `true`.
   * @param  bool|boolean $mostrar   Si quieres mostrar el modal cuando cargue la vista, por defecto es `false`.
   * @return void                    No retorna, imprime el modal.
   */
  function generarModal(
    string $tipo,
    string $id,
    string $titulo,
    string $contenido,
    bool $cerrar = true,
    bool $mostrar = false
  ): void {
    $mostrar = $mostrar ? 'w3-show' : 'w3-hide';

    echo sprintf(
      "<%s id='%s' class='modal w3-white w3-card w3-round-large animate__animated animate__fadeInUp animate__faster %s'>",
      $tipo,
      $id,
      $mostrar
    );
    if ($cerrar) {
      echo <<<HTML
            <div class="w3-right-align">
              <span class="icon-close w3-button w3-transparent w3-hover-red"></span>
            </div>
          HTML;
    }

    echo <<<HTML
          <h2 class="w3-center w3-xxlarge oswald w3-margin-bottom">{$titulo}</h2>
          {$contenido}
        HTML;
    echo sprintf('</%s>', $tipo);
  }
}
