"use strict";

/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
var form = document.querySelector('#registrarNegocio');
/** @type {HTMLInputElement} */
var inputFile = form.logo;
/** @type {HTMLImageElement} */
var image = form.querySelector('.image-result');
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, function (error) {
  if (error) return alerta(error).show();
});
validar(form, function (error, fd, e) {
  if (error) return alerta(error).show();
  e.preventDefault();
  mostrarLoader(form);
  fd.append(inputFile.id, inputFile.files[0]);
  ajax('backend/registrarNegocio.php', fd, function (res) {
    /** @type {Respuesta} */
    var respuesta = JSON.parse(res);
    if (respuesta.error) return alerta(respuesta.error).on('afterClose', function () {
      return ocultarLoader(form);
    }).show();
    ocultarLoader(form);
    return notificacion(respuesta.ok).on('onClose', function () {
      return location.reload();
    }).show();
  });
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/