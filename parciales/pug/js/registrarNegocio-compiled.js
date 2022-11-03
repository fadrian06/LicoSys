"use strict";

var formulario = w3.getElement('#formNegocio');
actualizarFoto();
var ajax = function ajax(e) {
  e.preventDefault();
  var icono = w3.getElement('.icon-refresh');
  icono.classList.toggle('w3-hide');
  icono.style.display = 'inline-block';
  var formData = new FormData(formulario);
  var file = formulario.registroLogo.files[0];
  if (file) formData.append('foto', file);
  axios.post('ajax/registrarNegocio.php', formData).then(function (respuesta) {
    respuesta = respuesta.data;
    if (!respuesta.ok) {
      icono.classList.toggle('w3-hide');
      icono.style.display = 'none';
      alerta(respuesta.mensaje, true, 5000);
    } else {
      formulario.classList.add('w3-hide');
      setTimeout(function () {
        return location.reload();
      }, 5000);
      notificacion(respuesta.mensaje, false, 5000);
    }
  })["catch"](function (error) {
    return console.log(error);
  });
};
formulario.addEventListener('submit', ajax);
