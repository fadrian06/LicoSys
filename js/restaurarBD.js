"use strict";

var html = "\n\t<div class=\"w3-white w3-round-xlarge w3-padding w3-center w3-border\">\n\t\t<div class=\"animate__animated animate__flip animate__infinite icon-question w3-xxxlarge\"></div>\n\t\t<h2 class=\"w3-medium\">Hay una copia de seguridad existente.</h2>\n\t\t<b>\xBFDesea restaurarla?</b>\n\t\t<div class=\"w3-center w3-padding\">\n\t\t\t<button id=\"si\" class=\"w3-button w3-blue w3-round-xlarge\">Si</button>\n\t\t\t<button id=\"no\" class=\"w3-button w3-red w3-round-xlarge\">No</button>\n\t\t</div>\n\t</div>\n";
/**
 * @param  {Event} e
 */
var enviarPeticion = function enviarPeticion(e) {
  e.target.innerHTML = '<i class="w3-spin icon-spinner"></i>';
  $('.w3-spin').removeClass('icon-question');
  $('.w3-spin').addClass('icon-spinner');
  $.post('backend/backupBD.php', {
    restaurar: true
  }, function (res) {
    /** @type {Respuesta} */
    var respuesta = JSON.parse(res);
    if (respuesta.error) return alerta(respuesta.error).show();
    $('#no')[0].click();
    var html = "\n\t\t\t<div class=\"w3-card w3-round-xlarge w3-white w3-padding-large w3-center\">\n\t\t\t\t<h1 class=\"w3-xlarge oswald\">".concat(respuesta.ok, "</h1>\n\t\t\t\t<h2 class=\"w3-large w3-padding-top-24 w3-topbar\">\n\t\t\t\t\tReiniciando el Sistema...\n\t\t\t\t</h2>\t\n\t\t\t</div>\n\t\t");
    new Noty({
      theme: null,
      id: 'intro',
      type: 'info',
      text: html,
      layout: 'center',
      modal: true,
      closeWith: [null],
      animation: {
        open: 'w3-animate-zoom'
      },
      timeout: 5000,
      callbacks: {
        onShow: function onShow() {
          return mostrarLoader($('form')[0]);
        },
        afterClose: function afterClose() {
          return location.reload();
        }
      }
    }).show();
  });
};
var esperarRespuesta = function esperarRespuesta() {
  $('.noty_close_button').on('click', function () {
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
  });
  $('#si').on('click', function (e) {
    return enviarPeticion(e);
  });
  $('#no').on('click', function () {
    $('#restaurar .noty_close_button')[0].click();
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
  });
};
new Noty({
  id: 'restaurar',
  text: html,
  layout: 'bottomRight',
  closeWith: ['button'],
  callbacks: {
    onShow: esperarRespuesta
  },
  theme: null
}).show();

// Swal.fire({
// 	title: 'Hay una copia de seguridad existente.',
// 	html: '<b class="w3-text-green">¿Desea restaurarla?</b>',
// 	icon: 'question',
// 	toast: true,
// 	position: 'bottom-end',
// 	showCancelButton: true,
// 	confirmButtonText: 'Si',
// 	cancelButtonText: 'No',
// 	confirmButtonColor: '#00796B',
// 	cancelButtonColor: '#a6001a',
// 	showCloseButton: true,
// 	showLoaderOnConfirm: true,
// 	preConfirm: async () => {
// 		return await axios('sistema/php/restaurarBD.php', {
// 			params: {
// 				restaurar: true
// 			}
// 		})
// 	}
// }).then(resultado => {
// 	if (!resultado.isDismissed && resultado.value.status === 200 && resultado.value.data) {
// 		let tiempo = 1000 * 20 /*20seg*/
// 		Swal.fire({
// 			title: 'Copia de seguridad restaurada exitósamente',
// 			html: '<b class="w3-xlarge w3-text-green">REINICIANDO EL SISTEMA</b>',
// 			icon: 'success',
// 			timer: tiempo,
// 			timerProgressBar: true,
// 			allowOutsideClick: false,
// 			allowEscapeKey: false,
// 			allowEnterKey: false,
// 			showConfirmButton: false,
// 		})
// 		setTimeout(() => location.reload(), tiempo);
// 	} else if (!resultado.isDismissed)
// 		alerta('Ha ocurrido un error, por favor intente nuevamente')
// })