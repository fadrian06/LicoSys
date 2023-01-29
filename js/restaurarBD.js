"use strict";

/** @typedef {import('./funciones')} */

var textoConfirmacion = "\n\t<h2 class=\"w3-medium\">Hay una copia de seguridad existente.</h2>\n\t<strong>\xBFDesea restaurarla?</strong>\n";
confirmar(textoConfirmacion, 'bottomRight', peticionRestaurarBD).show();
function peticionRestaurarBD(e) {
  e.target.innerHTML = '<i class="w3-spin icon-spinner"></i>';
  $('.w3-spin').removeClass('icon-question');
  $('.w3-spin').addClass('icon-spinner');
  $.post('backend/backupBD.php', {
    restaurar: true
  }, recibirRespuesta);
}
function recibirRespuesta(res) {
  /** @type {Respuesta} */
  var respuesta = JSON.parse(res);
  if (respuesta.error) return alerta(respuesta.error).show();
  var textoReiniciandoSistema = "\n\t\t<div class=\"w3-card w3-round-xlarge w3-white w3-padding-large w3-center\">\n\t\t\t<h1 class=\"w3-xlarge oswald\">".concat(respuesta.ok, "</h1>\n\t\t\t<h2 class=\"w3-large w3-padding-top-24 w3-topbar\">\n\t\t\t\tReiniciando el Sistema...\n\t\t\t</h2>\t\n\t\t</div>\n\t");
  var alertaReiniciando = new Noty({
    theme: null,
    id: 'intro',
    type: 'info',
    text: textoReiniciandoSistema,
    layout: 'center',
    modal: true,
    closeWith: [null],
    animation: {
      open: 'w3-animate-zoom'
    },
    timeout: 5000,
    callbacks: {
      onShow: function onShow() {
        return mostrarLoader($('form')[0]);
      },
      afterClose: function afterClose() {
        return redirigir('salir.php');
      }
    }
  });
  alertaReiniciando.show();
}