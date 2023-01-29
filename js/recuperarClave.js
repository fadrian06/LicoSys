"use strict";

// @ts-nocheck
/** @typedef {import('./funciones')} */
/** @typedef {import('./login')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLButtonElement} */
var botonRecuperar = document.querySelector('#recuperar');
/** @type {HTMLFormElement} */
var formConsulta = document.querySelector('#consultar');
/** @type {HTMLFormElement} */
var formPreguntasRespuestas = document.querySelector('#preguntasRespuestas');
/** @type {HTMLFormElement} */
var formClave = document.querySelector('#cambiarClave');
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
botonRecuperar.onclick = function (e) {
  e.preventDefault();
  modal(botonRecuperar);
};
validar(formConsulta, function (error, fd, e) {
  if (error) return alerta(error).show();
  e.preventDefault();
  formConsulta.classList.add('showLoader');
  fd.append('consultar', true);
  ajax('backend/recuperarClave.php', fd, function (res) {
    /** @type {Respuesta} */
    var datos = JSON.parse(res);
    if (datos.error) return alerta(datos.error).on('onShow', function () {
      return formConsulta.classList.remove('showLoader');
    }).show();
    formConsulta.classList.remove('showLoader');
    location.reload();
  });
});
if (formPreguntasRespuestas) {
  mostrarModal(formPreguntasRespuestas, function () {
    return $.post('backend/recuperarClave.php', {
      cerrar: true
    }, function (res) {
      console.log(res);
    });
  });
  verClave(formPreguntasRespuestas.res1.nextElementSibling, formPreguntasRespuestas.res1);
  verClave(formPreguntasRespuestas.res2.nextElementSibling, formPreguntasRespuestas.res2);
  verClave(formPreguntasRespuestas.res3.nextElementSibling, formPreguntasRespuestas.res3);
  validar(formPreguntasRespuestas, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    formPreguntasRespuestas.classList.add('showLoader');
    fd.append('verificarRespuestas', true);
    return ajax('backend/recuperarClave.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onShow', function () {
        formPreguntasRespuestas.classList.remove('showLoader');
      }).show();
      formPreguntasRespuestas.classList.remove('showLoader');
      location.reload();
    });
  });
}
if (formClave) {
  mostrarModal(formClave, function () {
    return $.post('backend/recuperarClave.php', {
      cerrar: true
    }, function (res) {
      console.log(res);
    });
  });
  verClave(formClave.clave.nextElementSibling, formClave.clave);
  verClave(formClave.confirmar.nextElementSibling, formClave.confirmar);
  validar(formClave, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    formClave.classList.add('showLoader');
    fd.append('cambiarClave', true);
    return ajax('backend/recuperarClave.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onShow', function () {
        return formClave.classList.remove('showLoader');
      }).show();
      formClave.classList.remove('showLoader');
      notificacion('Contraseña actualizada exitósamente.').show();
      return formClave.querySelector('.icon-close').click();
    });
  });
}
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/