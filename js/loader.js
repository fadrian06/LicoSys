"use strict";

/** @typedef {import('./funciones')} */

var textoCargando = "\n\t<h1 class=\"w3-text-white w3-center w3-xlarge oswald\">\n\t\tBienvenido a Licosys\n\t</h1>\n\t<div class=\"newtons-cradle\">\n\t\t<div class=\"newtons-cradle__dot\"></div>\n\t\t<div class=\"newtons-cradle__dot\"></div>\n\t\t<div class=\"newtons-cradle__dot\"></div>\n\t\t<div class=\"newtons-cradle__dot\"></div>\n\t</div>\n\t<p class=\"w3-text-white w3-center\">\n\t\tEstamos configurando algunas cosas, por favor espere...\n\t</p>\n";
var textoBienvenida = "\n\t<div class=\"w3-card w3-round-xlarge w3-white w3-padding-large w3-center\">\n\t\t<h1 class=\"w3-xlarge oswald\">Licosys instalado correctamente</h1>\n\t\t<h2 class=\"w3-large w3-padding-top-24 w3-topbar\">\n\t\t\tS\xF3lo faltan unos pocos pasos...\n\t\t</h2>\t\n\t</div>\n";
var alertaCargando = new Noty({
  theme: null,
  id: 'loader',
  type: 'info',
  layout: 'center',
  text: textoCargando,
  closeWith: [null],
  animation: {
    open: 'w3-animate-opacity'
  },
  callbacks: {
    onShow: instalarBD
  }
});
var alertaBienvenido = new Noty({
  theme: null,
  id: 'intro',
  type: 'info',
  text: textoBienvenida,
  layout: 'center',
  closeWith: [null],
  animation: {
    open: 'w3-animate-zoom'
  },
  timeout: 3000,
  callbacks: {
    afterClose: function afterClose() {
      return location.reload();
    }
  }
});
alertaCargando.show();

/** Hace la petición para instalar la Base de Datos, recibida la respuesta
 * muestra la bienvenida. */
function instalarBD() {
  $.post('backend/conexion.php', {
    instalarBD: true
  }, function (data) {
    if (data !== 'true') return console.error(data);
    return setTimeout(function () {
      $('#loader').remove();
      alertaBienvenido.show();
    }, 3000);
  });
}