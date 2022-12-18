"use strict";

/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLButtonElement} */
var btnVersion = document.querySelector('#version');
/** @type {HTMLDivElement} */
var modalAcercaDe = document.querySelector('#acercaDe');
/** @type {HTMLDivElement} */
var overlay = document.querySelector('.w3-overlay');
/** @type {HTMLButtonElement} */
var barras = document.querySelector('.icon-bars').parentElement;
/** @type {HTMLElement} [description] */
var menuLateral = document.querySelector('#menu');
/** @type {HTMLButtonElement} */
var btnModenas = document.querySelector('#btn-monedas');
/** @type {HTMLFormElement} */
var formMonedas = document.querySelector('#actualizarModenas');
var main = document.querySelector('main');
var dashboardHTML = main.innerHTML;
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
$('a').each(function (_i, enlace) {
  enlace.addEventListener('click', function (e) {
    /** @type {HTMLAnchorElement} */
    var enlace = e.currentTarget;
    e.preventDefault();
    main.classList.add('showLoader');
    if (enlace.href.includes('dashboard.php')) return setTimeout(function () {
      main.classList.remove('showLoader');
      main.innerHTML = dashboardHTML;
    }, 500);
    if (enlace.href.includes('salir.php')) return main.classList.remove('showLoader');
    $.get(enlace.href, function (res) {
      main.classList.remove('showLoader');
      main.innerHTML = res;
    });
  });
});
if (formMonedas) {
  modal(btnModenas, formMonedas, overlay);
  validar(formMonedas, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    formMonedas.classList.add('showLoader');
    ajax('backend/actualizarMonedas.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('afterClose', function () {
        return formMonedas.classList.remove('showLoader');
      }).show();
      formMonedas.classList.remove('showLoader');
      return notificacion('Valores actualizados correctamente.').on('onShow', function () {
        return formMonedas.querySelector('.icon-close').click();
      }).show();
    });
  });
}
modal(btnVersion, modalAcercaDe, overlay);
menu(barras, menuLateral, overlay);
$('summary').each(function (_i, summary) {
  summary.onclick = function () {
    summary.parentElement.classList.toggle('abierto');
    summary.parentElement.removeAttribute('open');
  };
});
$('[href="salir.php"]').on('click', function (e) {
  e.preventDefault();
  return confirmar(overlay, '¿Seguro que desea cerrar sesión?', 'center', function () {
    var url = location.href.split('/');
    url[url.length - 1] = 'salir.php';
    location.href = url.join('/');
  });
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/