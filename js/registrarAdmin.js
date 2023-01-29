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
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, function (error) {
  return alerta(error).show();
});
verClave(form.clave.nextElementSibling, form.clave);
verClave(form.confirmar.nextElementSibling, form.confirmar);
validar(form, function (error, fd, e) {
  if (error) return alerta(error).show();
  e.preventDefault();
  mostrarLoader(form);
  fd.append(inputFile.id, inputFile.files[0]);
  fd.append('cargo', 'a');
  ajax('backend/registrarUsuario.php', fd, function (res) {
    /** @type {Respuesta} */
    var respuesta = JSON.parse(res);
    if (respuesta.error) return alerta(respuesta.error).on('afterClose', function () {
      return ocultarLoader(form);
    }).show();
    ocultarLoader(form);
    return notificacion(respuesta.ok).on('afterClose', function () {
      return location.reload();
    }).show();
  });
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/