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

  use Leaf\BareUI;
  use LicoSys\Enums\NombreInput;

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
      'clave' => '.{4,20}',
    ];

    $id = uniqid();
    $value = $value === 'No establecido' ? "" : $value;

    return match ($nombre->name) {
      'CLAVE' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-key',
        'type' => 'password',
        'name' => 'clave',
        'value' => $value,
        'required' => true,
        'props' => [
          'minlength="4"',
          'maxlength="20"',
          "pattern=\"{$expresiones['clave']}\"",
          'title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)"',
          "placeholder='$placeholder'",
        ],
        'withEye' => true,
      ]),
      'CONFIRMAR' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-key',
        'type' => 'password',
        'name' => 'confirmar',
        'value' => $value,
        'required' => true,
        'props' => [
          'minlength="4"',
          'maxlength="20"',
          "pattern=\"{$expresiones['clave']}\"",
          'title="Sólo se permiten entre 4 y 20 letras, números y símbolos (. - _ @ # / *)"',
          "placeholder='$placeholder'",
        ],
        'withEye' => true,
      ]),
      'USUARIO' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-user-circle-o',
        'type' => 'text',
        'name' => 'usuario',
        'value' => $value,
        'required' => true,
        'props' => [
          'minlength="4"',
          'maxlength="20"',
          "pattern=\"[\w\-]{4,20}\"",
          'title="Sólo se permiten entre 4 y 20 letras, números o guiones(-)"',
          "placeholder='$placeholder'",
        ],
        'withLoader' => true,
      ]),
      'CEDULA' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-id-card',
        'type' => 'number',
        'name' => 'cedula',
        'value' => $value,
        'required' => true,
        'props' => [
          'min="1"',
          'max="40000000"',
          'minlength="7"',
          'maxlength="8"',
          "pattern=\"[^e]?\\d{7,8}\"",
          'title="Un número entre 7 y 8 dígitos"',
          "placeholder='$placeholder'",
        ],
      ]),
      'IVA' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-percent',
        'type' => 'number',
        'name' => 'iva',
        'value' => $value,
        'required' => true,
        'props' => [
          'step="0.01"',
          'min="0"',
          'minlength="1"',
          'maxlength="4"',
          "pattern=\"((0\\.[0-9])|[0-9]){2,3}\"",
          'title="Un número decimal o un porcentaje"',
          "placeholder='$placeholder'",
        ],
      ]),
      'DOLAR' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-dollar',
        'type' => 'number',
        'name' => 'dolar',
        'value' => $value,
        'required' => true,
        'props' => [
          'step="0.01"',
          "placeholder='$placeholder'",
          "minlength='1'",
          "maxlength='4'",
          "pattern='\\d+\\.?\\d{0,2}'",
          'title="Un número con decimales opcionales"',
        ],
      ]),
      'BS' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-money',
        'type' => 'number',
        'name' => 'bs',
        'value' => $value,
        'required' => true,
        'props' => [
          'step="0.01"',
          "placeholder='$placeholder'",
          "minlength='1'",
          "pattern='\\d+\\.?\\d{1,2}'",
          'title="Un número con decimales opcionales"',
        ],
      ]),
      'PESO' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-peso',
        'type' => 'number',
        'name' => 'pesos',
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "minlength='1'",
          "pattern='[^e]?\\d{1,4}'",
          'title="Sólo se permiten números"',
        ],
      ]),
      'res1', 'res2', 'res3' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-question-circle',
        'type' => 'password',
        'name' => $nombre->name,
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "maxlength='50'",
          "pattern='[\\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\\s]+'",
          'title="Sólo se permiten hasta 50 letras y símbolos (¿ ?)"',
        ],
        'withEye' => true,
      ]),
      'NOMBRE' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-user',
        'name' => 'nombre',
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "minlength='4'",
          "maxlength='20'",
          "pattern='[a-zA-ZáÁéÉíÍóÓúÚñÑ\\s]{4,20}'",
          'title="Sólo se permiten entre 4 y 20 letras"',
        ],
      ]),
      'NOMBRE_NEGOCIO' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-building',
        'name' => 'nombreNegocio',
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "minlength='4'",
          "maxlength='20'",
          "pattern='[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ\\s]{4,20}'",
          'title="Sólo se permiten entre 4 y 20 letras, números y espacios"',
        ],
      ]),
      'TELEFONO' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-phone',
        'type' => 'tel',
        'name' => 'telefono',
        'value' => $value,
        'props' => [
          "placeholder='$placeholder'",
          "maxlength='13'",
          "pattern='(0|\\+57|\\+58)\\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}'",
          'title="Ejemplo (+58 416-111-2222 o 0416-111-2222)"',
        ],
      ]),
      'RIF' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-id-card',
        'name' => 'rif',
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "minlength='10'",
          "maxlength='15'",
          "pattern='(v|e|V|E){1}\\d{9,15}'",
          'title="Debe empezar por V o E seguido de entre 9 y 15 dígitos"',
        ],
      ]),
      'DIRECCION' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-map-marker',
        'name' => 'direccion',
        'value' => $value,
        'props' => [
          "placeholder='$placeholder'",
          "maxlength='50'",
          "pattern='.{4,50}'",
          'title="Sólo se permiten letras, números y símbolos (, . - / #)"',
        ],
      ]),
      'pre1', 'pre2', 'pre3' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-question-circle',
        'name' => $nombre->name,
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "maxlength='50'",
          "pattern='[\\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\\s]+'",
          'title="Sólo se permiten hasta 50 letras y símbolos (¿ ?)"',
        ],
      ]),
      'ID' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-id-card',
        'type' => 'hidden',
        'name' => 'id',
        'value' => $value,
      ]),
      'CODIGO' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-barcode',
        'name' => 'codigo',
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "minlength='3'",
          "maxlength='10'",
          "pattern='.{3,10}'",
          'title="Sólo se permiten letras, números y símbolos (- . #)"',
        ],
      ]),
      'STOCK' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-list-alt',
        'type' => 'number',
        'name' => 'stock',
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "min='0'",
          "pattern='[^e]?\\d+'",
          'title="Sólo se permiten números enteros"',
        ],
      ]),
      'PRECIO' => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-dollar',
        'type' => 'number',
        'name' => 'precio',
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "step='0.01'",
          "min='0'",
          "pattern='[\\d.]+'",
          'title="Sólo se permiten números decimales"',
        ],
      ]),
      default => BareUI::render('components/input', [
        'legend' => $label,
        'icon' => 'icon-question-circle',
        'name' => $nombre->name,
        'value' => $value,
        'required' => true,
        'props' => [
          "placeholder='$placeholder'",
          "maxlength='50'",
          "pattern='[\\?a-zA-ZÁáÉéÍíÓóÚúñÑ¿\\s]+'",
          'title="Sólo se permiten hasta 50 letras y símbolos (¿ ?)"',
        ],
      ]),
    };
  }
}
