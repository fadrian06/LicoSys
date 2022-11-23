Swal.fire({
	title: 'Hay una copia de seguridad existente.',
	html: '<b class="w3-text-green">¿Desea restaurarla?</b>',
	icon: 'question',
	toast: true,
	position: 'bottom-end',
	showCancelButton: true,
	confirmButtonText: 'Si',
	cancelButtonText: 'No',
	confirmButtonColor: '#00796B',
	cancelButtonColor: '#a6001a',
	showCloseButton: true,
	showLoaderOnConfirm: true,
	preConfirm: async () => {
		return await axios('sistema/php/restaurarBD.php', {
			params: {
				restaurar: true
			}
		})
	}
}).then(resultado => {
	if (!resultado.isDismissed && resultado.value.status === 200 && resultado.value.data) {
		let tiempo = 1000 * 20 /*20seg*/
		Swal.fire({
			title: 'Copia de seguridad restaurada exitósamente',
			html: '<b class="w3-xlarge w3-text-green">REINICIANDO EL SISTEMA</b>',
			icon: 'success',
			timer: tiempo,
			timerProgressBar: true,
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			showConfirmButton: false,
		})
		setTimeout(() => location.reload(), tiempo);
	} else if (!resultado.isDismissed)
		alerta('Ha ocurrido un error, por favor intente nuevamente')
})