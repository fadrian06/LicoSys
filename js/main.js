"use strict";

// @ts-nocheck
/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLDivElement} */
var overlay = document.querySelector('.w3-overlay');
/** @type {HTMLButtonElement} */
var barras = document.querySelector('.icon-bars').parentElement;
/** @type {HTMLElement} [description] */
var menuLateral = document.querySelector('#menu');
/** @type {HTMLButtonElement} */
var btnModenas = document.querySelector('#btn-monedas');
/** @type {HTMLFormElement} */
var formMonedas = document.querySelector('#actualizarMonedas');
var main = document.querySelector('main');
var dashboardHTML = main.innerHTML;
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reajustar();
menu();
navegacion();
if (formMonedas) {
  validar(formMonedas, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    formMonedas.classList.add('showLoader');
    ajax('backend/actualizarMonedas.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onClose', function () {
        return formMonedas.classList.remove('showLoader');
      }).show();
      $('#tablaMonedas').html("\n\t\t\t\t<tr>\n\t\t\t\t\t<td>IVA</td>\n\t\t\t\t\t<td colspan=\"2\"><b>".concat(formMonedas.iva.value, "%</b></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr>\n\t\t\t\t\t<td>D\xD3LAR</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<b><i>Bs. </i>").concat(formMonedas.dolar.value, "</b>\n\t\t\t\t\t</td>\n\t\t\t\t\t<td><b>").concat(formMonedas.pesos.value, "<i> Pesos</i></b></td>\n\t\t\t\t</tr>\t\n\t\t\t"));
      formMonedas.classList.remove('showLoader');
      return notificacion('Valores actualizados correctamente.').on('onShow', function () {
        formMonedas.querySelector('.icon-close').click();
      }).show();
    });
  });
}
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/