"use strict";

var html = "\n\t<h1 class=\"w3-text-white w3-center w3-xlarge oswald\">\n\t\tBienvenido a Licosys\n\t</h1>\n\t<div class=\"newtons-cradle\">\n\t\t<div class=\"newtons-cradle__dot\"></div>\n\t\t<div class=\"newtons-cradle__dot\"></div>\n\t\t<div class=\"newtons-cradle__dot\"></div>\n\t\t<div class=\"newtons-cradle__dot\"></div>\n\t</div>\n\t<p class=\"w3-text-white w3-center\">\n\t\tEstamos configurando algunas cosas, por favor espere...\n\t</p>\n";
var showIntro = function showIntro() {
  $('#loader').remove();
  html = "\n\t\t<div class=\"w3-card w3-round-xlarge w3-white w3-padding-large w3-center\">\n\t\t\t<h1 class=\"w3-xlarge oswald\">Licosys instalado correctamente</h1>\n\t\t\t<h2 class=\"w3-large w3-padding-top-24 w3-topbar\">\n\t\t\t\tS\xF3lo faltan unos pocos pasos...\n\t\t\t</h2>\t\n\t\t</div>\n\t";
  new Noty({
    theme: null,
    id: 'intro',
    type: 'info',
    text: html,
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
  }).show();
};
var capturarRespuesta = function capturarRespuesta(data) {
  if (data !== 'true') return console.log(data);
  setTimeout(showIntro, 3000);
};
var showLoader = function showLoader() {
  $.post('backend/conexion.php', {
    instalarBD: true
  }, capturarRespuesta);
};
new Noty({
  theme: null,
  id: 'loader',
  type: 'info',
  layout: 'center',
  text: html,
  closeWith: [null],
  animation: {
    open: 'w3-animate-opacity'
  },
  callbacks: {
    onShow: showLoader
  }
}).show();