"use strict";

/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
var form = document.querySelector('#registrarPreguntasRespuestas');

/** @param  {RespuestaCruda} res */
function recibirRespuesta(res) {
  /** @type {Respuesta} */
  var respuesta = JSON.parse(res);
  if (respuesta.error) return alerta(respuesta.error).on('afterClose', function () {
    return ocultarLoader(form);
  }).show();
  ocultarLoader(form);
  Noty.closeAll();
  return notificacion('Registro exitoso.').on('onClose', function () {
    return location.reload();
  }).show();
}
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
verClave(form.res1.nextElementSibling, form.res1);
verClave(form.res2.nextElementSibling, form.res2);
verClave(form.res3.nextElementSibling, form.res3);
labelPreguntas(form);
$('#masTarde').on('click', function (e) {
  e.preventDefault();
  var textoConfirmacion = "\n\t\t<h2 class=\"w3-large w3-margin-bottom\">\n\t\t\t<strong>\xBFEst\xE1s seguro que desea realizar este proceso m\xE1s tarde?</strong>\n\t\t</h2>\n\t\t<p class=\"w3-padding-top-16 w3-justify w3-medium w3-text-red\">\n\t\t\t&nbsp;&nbsp;Es recomendable que cree sus preguntas y respuestas secretas, pues \n\t\t\tle permitir\xE1n recuperar su contrase\xF1a en caso de extraviarla.\n\t\t</p>\n\t\t<p class=\"w3-padding-top-16\">\n\t\t\t\xBFRegistrar preguntas y respuestas m\xE1s tarde?\n\t\t</p>\n\t";
  return confirmar(textoConfirmacion, 'center', function () {
    form.pre1.value = 'No especificada';
    form.pre2.value = 'No especificada';
    form.pre3.value = 'No especificada';
    var fd = new FormData(form);
    ajax('backend/registrarPreguntasRespuestas.php', fd, recibirRespuesta);
  }).show();
});
validar(form, function (error, fd, e) {
  if (error) return alerta(error).show();
  e.preventDefault();
  mostrarLoader(form);
  ajax('backend/registrarPreguntasRespuestas.php', fd, recibirRespuesta);
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/