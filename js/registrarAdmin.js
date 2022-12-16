"use strict";

/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
var form = document.querySelector('#registrarAdmin');

/** @type {HTMLInputElement} */
var inputFile = form.foto;

/** @type {HTMLImageElement} */
var image = form.querySelector('.image-result');

/** @type {HTMLDivElement} */
var overlay = form.previousElementSibling;
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, function (error) {
  return alerta(error).show();
});
verClave(form.clave.nextElementSibling, form.clave);
verClave(form.confirmar.nextElementSibling, form.confirmar);

/**
 * @param  {string} res {error: string, datos: []}
 */
var recibirRespuesta = validar(form, function (error, fd, e) {
  if (error) return alerta(error).show();
  e.preventDefault();
  mostrarLoader(overlay, form);
  fd.append(inputFile.id, inputFile.files[0]);
  ajax('backend/registrarAdmin.php', fd, function (res) {
    /** @type {Respuesta} */
    var datos = JSON.parse(res);
    if (datos.error) return alerta(datos.error).on('afterClose', function () {
      return ocultarLoader(overlay, form);
    }).show();
    ocultarLoader(overlay, form);
    return notificacion('Administrador registrado exitósamente.').on('afterClose', function () {
      return location.reload();
    }).show();
  });
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/