<?php

declare(strict_types=1);

if (isset($mostrarChangelog)):
  /*===========================================
    =            REGISTRO DE CAMBIOS            =
    ===========================================*/
  $listaVersiones = '';
  foreach ($versiones as $versione)
    $listaVersiones .= <<<HTML
        <dt class="w3-tag w3-blue">{$versione['nombre']}</dt>
          <dd class="w3-small w3-margin-bottom">{$versione['descripcion']}</dd>
      HTML;

  $contenido = <<<HTML
      <dl class="w3-container">{$listaVersiones}</dl>
    HTML;
  generarModal('div', 'registroCambios', 'Registro de Cambios', $contenido);
endif;
