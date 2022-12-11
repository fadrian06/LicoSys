"use strict";

var html = "\n\t<div class=\"w3-white w3-round-xlarge w3-padding w3-center w3-border\">\n\t\t<div class=\"w3-spin icon-question w3-xxxlarge\"></div>\n\t\t<h2 class=\"w3-medium\">Hay una copia de seguridad existente.</h2>\n\t\t<b>\xBFDesea restaurarla?</b>\n\t\t<div class=\"w3-center w3-padding\">\n\t\t\t<button id=\"si\" class=\"w3-button w3-blue w3-round-xlarge\">Si</button>\n\t\t\t<button id=\"no\" class=\"w3-button w3-red w3-round-xlarge\">No</button>\n\t\t</div>\n\t</div>\n";
/**
 * @param  {Event} e
 */
var enviarPeticion = function enviarPeticion(e) {
  e.target.innerHTML = '<i class="w3-spin icon-spinner"></i>';
  $('.w3-spin').removeClass('icon-question');
  $('.w3-spin').addClass('icon-spinner');
};
var esperarRespuesta = function esperarRespuesta() {
  $('#si').click(enviarPeticion);
  $('#no').click(function () {
    return document.querySelector('.noty_close_button').click();
  });
};
new Noty({
  id: 'solicitud',
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