"use strict";

/**
 * @param  {HTMLInputElement} input `<input type="file">`
 * @param  {HTMLImageElement} image La <img> a actualizar
 * @param {?(error: string)} cb Un callback cuando algo salga mal
 */
var actualizarImagen = function actualizarImagen(input, image) {
  var cb = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : function () {};
  input.onchange = function () {
    var file = input.files[0];
    if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png') return cb('Sólo se permiten imagenes JPG y PNG');
    if (file.size > 1 * 1000 * 2048) return cb('La imagen no puede ser mayor a 2MB');
    var fr = new FileReader();
    fr.readAsDataURL(file);
    fr.onload = function (e) {
      return image.setAttribute('src', e.target.result);
    };
  };
};