<?php

declare(strict_types=1);

use Leaf\BareUI;

require_once __DIR__ . '/../vendor/autoload.php';

if (isset($mostrarChangelog)) :
  /*===========================================
    =            REGISTRO DE CAMBIOS            =
    ===========================================*/
  $listaVersiones = '';
  foreach ($versiones as $versione) {
    $listaVersiones .= <<<HTML
        <dt class="w3-tag w3-blue">{$versione['nombre']}</dt>
          <dd class="w3-small w3-margin-bottom">{$versione['descripcion']}</dd>
      HTML;
  }

  $contenido = <<<HTML
      <dl class="w3-container">{$listaVersiones}</dl>
    HTML;

  echo BareUI::render('components/modal', [
    'tag' => 'div',
    'id' => 'registroCambios',
    'title' => 'Registro de Cambios',
    'slot' => $contenido,
  ]);
endif;
