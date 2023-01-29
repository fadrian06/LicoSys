"use strict";

/** @typedef {import('./funciones')} */

var html = "\n\t<div class=\"w3-white w3-round-xlarge w3-padding w3-center w3-border\" style=\"z-index: 1000\">\n\t\t<div class=\"animate__animated animate__flip animate__infinite icon-close w3-xxxlarge w3-text-red\"></div>\n\t\t<h2 class=\"w3-large w3-margin-bottom\">\n\t\t\t<strong>ACCESO DENEGADO</strong>\n\t\t</h2>\n\t\t<p class=\"w3-topbar w3-center w3-padding w3-margin-top\">\n\t\t\tVolviendo a la p\xE1gina principal\n\t\t</p>\n\t</div>\n";
new Noty({
  text: html,
  theme: null,
  closeWith: [null],
  modal: true,
  timeout: 3000,
  layout: 'center',
  callbacks: {
    onClose: function onClose() {
      return location.reload();
    }
  }
}).show();