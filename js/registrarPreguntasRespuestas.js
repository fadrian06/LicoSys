"use strict";

/**
 * @type {HTMLFormElement}
 */
var form = document.querySelector('#registrarPreguntasRespuestas');
/**
 * @type {HTMLDivElement}
 */
var overlay = form.previousElementSibling;
verClave(form.res1.nextElementSibling, form.res1);
verClave(form.res2.nextElementSibling, form.res2);
verClave(form.res3.nextElementSibling, form.res3);
form.pre1.addEventListener('keyup', function () {
  var legendRespuesta = form.querySelector("sup[respuesta=".concat(form.res1.id, "]"));
  legendRespuesta.innerText = "(".concat(form.pre1.value, ")");
});
form.pre3.addEventListener('keyup', function () {
  var legendRespuesta = form.querySelector("sup[respuesta=".concat(form.res2.id, "]"));
  legendRespuesta.innerText = "(".concat(form.pre2.value, ")");
});
form.pre3.addEventListener('keyup', function () {
  var legendRespuesta = form.querySelector("sup[respuesta=".concat(form.res3.id, "]"));
  legendRespuesta.innerText = "(".concat(form.pre3.value, ")");
});

/**
 * @param  {string} res {error: string, datos: []}
 */
var recibirRespuesta = function recibirRespuesta(res) {
  /**
   * @type {{error: string, datos: []}}
   */
  var datos = JSON.parse(res);
  if (datos.error) return new Noty({
    text: "<i class=\"icon-close w3-margin-right\"></i> ".concat(datos.error),
    type: 'error',
    timeout: 5000,
    callbacks: {
      afterClose: function afterClose() {
        overlay.classList.remove('w3-show');
        overlay.classList.add('w3-hide');
        form.classList.remove('showLoader');
      }
    }
  }).show();
  overlay.classList.remove('w3-show');
  overlay.classList.add('w3-hide');
  form.classList.remove('showLoader');
  Noty.closeAll();
  new Noty({
    text: "<i class=\"icon-check w3-margin-right\"></i> Registro exitoso.",
    type: 'success',
    timeout: 5000,
    callbacks: {
      afterClose: function afterClose() {
        return location.reload();
      }
    }
  }).show();
};
var enviarDatos = function enviarDatos() {
  form.pre1.value = 'No especificada';
  form.pre2.value = 'No especificada';
  form.pre3.value = 'No especificada';
  var fd = new FormData(form);
  $.ajax({
    url: 'backend/registrarPreguntasRespuestas.php',
    type: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: recibirRespuesta
  });
};
var esperarRespuesta = function esperarRespuesta() {
  $('.noty_close_button').click(function () {
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
  });
  $('#confirmar').click(enviarDatos);
  $('#cancelar').click(function () {
    $('#confirmacion .noty_close_button')[0].click();
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
  });
};
form.querySelector('#masTarde').onclick = function (e) {
  e.preventDefault();
  overlay.style.zIndex = '999';
  overlay.classList.remove('w3-hide');
  overlay.classList.add('w3-show');
  var html = "\n\t\t<div class=\"w3-white w3-round-xlarge w3-padding w3-center w3-border\" style=\"z-index: 1000\">\n\t\t\t<div class=\"animate__animated animate__flip animate__infinite icon-question w3-xxxlarge\"></div>\n\t\t\t<h2 class=\"w3-large w3-margin-bottom\">\n\t\t\t\t<strong>\xBFEst\xE1s seguro que desea realizar este proceso m\xE1s tarde?</strong>\n\t\t\t</h2>\n\t\t\t<p class=\"w3-padding-top-16 w3-justify\">\n\t\t\t\t&nbsp;&nbsp;Es recomendable que cree sus preguntas y respuestas secretas, pues \n\t\t\t\tle permitir\xE1n recuperar su contrase\xF1a. <strong>Tenga en cuenta que \n\t\t\t\tsi no agrega respuestas secretas, estas por defecto \n\t\t\t\testar\xE1n vac\xEDas y con su c\xE9dula y usuario podr\xE1n cambiar su contrase\xF1a e \n\t\t\t\tingresar a su perfil.</strong>\n\t\t\t</p>\n\t\t\t<p class=\"w3-padding-top-16\">\n\t\t\t\t\xBFRegistrar preguntas y respuestas m\xE1s tarde?\n\t\t\t</p>\n\t\t\t<div class=\"w3-center w3-padding w3-margin-top\">\n\t\t\t\t<button id=\"confirmar\" class=\"w3-button w3-round-xlarge w3-blue\">S\xED</button>\n\t\t\t\t<button id=\"cancelar\" class=\"w3-button w3-round-xlarge w3-red\">No</button>\n\t\t\t</div>\n\t\t</div>\n\t";
  new Noty({
    id: 'confirmacion',
    theme: null,
    text: html,
    layout: 'center',
    closeWith: ['button'],
    callbacks: {
      onShow: esperarRespuesta
    }
  }).show();
};
validar(form, function (error, fd, e) {
  if (error) return new Noty({
    text: "<i class=\"icon-close w3-margin-right\"></i> ".concat(error),
    type: 'error',
    timeout: 3000
  }).show();
  e.preventDefault();
  overlay.style.zIndex = '999';
  overlay.classList.remove('w3-hide');
  overlay.classList.add('w3-show');
  form.classList.add('showLoader');
  $.ajax({
    url: 'backend/registrarPreguntasRespuestas.php',
    type: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: recibirRespuesta
  });
});