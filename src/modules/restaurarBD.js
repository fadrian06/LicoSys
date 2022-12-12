let html = `
	<div class="w3-white w3-round-xlarge w3-padding w3-center w3-border">
		<div class="animate__animated animate__flip animate__infinite icon-question w3-xxxlarge"></div>
		<h2 class="w3-medium">Hay una copia de seguridad existente.</h2>
		<b>¿Desea restaurarla?</b>
		<div class="w3-center w3-padding">
			<button id="si" class="w3-button w3-blue w3-round-xlarge">Si</button>
			<button id="no" class="w3-button w3-red w3-round-xlarge">No</button>
		</div>
	</div>
`
/**
 * @param  {Event} e
 */
const enviarPeticion = e => {
	e.target.innerHTML = '<i class="w3-spin icon-spinner"></i>'
	$('.w3-spin').removeClass('icon-question')
	$('.w3-spin').addClass('icon-spinner')
}

const esperarRespuesta = () => {
	$('.noty_close_button').click(() => {
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
	})
	$('#si').click(enviarPeticion)
	$('#no').click(() => {
		$('#restaurar .noty_close_button')[0].click()
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
	})
}

new Noty({
	id: 'restaurar',
	text: html,
	layout: 'bottomRight',
	closeWith: ['button'],
	callbacks: {
		onShow: esperarRespuesta
	},
	theme: null
}).show()

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