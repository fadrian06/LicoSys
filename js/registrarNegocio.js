"use strict";

/**
 * @type {HTMLFormElement}
 */
var form = document.querySelector('#registrarNegocio');
/**
 * @type {HTMLInputElement}
 */
var inputFile = form.logo;
/**
 * @type {HTMLImageElement}
 */
var image = form.querySelector('.image-result');
/**
 * @type {HTMLDivElement}
 */
var overlay = form.previousElementSibling;
actualizarImagen(inputFile, image, function (error) {
  new Noty({
    text: "<i class=\"icon-close w3-margin-right\"></i> ".concat(error),
    type: 'error',
    timeout: 3000
  }).show();
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
  new Noty({
    text: "<i class=\"icon-check w3-margin-right\"></i> Negocio registrado exit\xF3samente.",
    type: 'success',
    timeout: 5000,
    callbacks: {
      afterClose: function afterClose() {
        return location.reload();
      }
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
  fd.append(inputFile.id, inputFile.files[0]);
  $.ajax({
    url: 'backend/registrarNegocio.php',
    type: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: recibirRespuesta
  });
});