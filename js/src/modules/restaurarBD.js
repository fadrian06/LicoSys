import { alerta, notificacion } from './alertas'

const restaurarBD = () => {
	return new Promise(resolve => {
		const respuesta = axios.get('backup/licosys.sql')
		respuesta.then(respuesta => {
			if (respuesta.headers['content-type'] === 'application/x-sql') {
				Swal.fire({
					title: 'Hay una copia de seguridad existente.',
					html: '<b className="w3-text-green">¿Desea restaurarla?</b>',
					icon: 'question',
					toast: true,
					position: 'bottom-end',
					showCancelButton: true,
					confirmButtonText: 'Sí',
					cancelButtonText: 'No',
					showCloseButton: true,
					buttonsStyling: false,
					customClass: {
						confirmButton: 'w3-button w3-teal w3-round-large w3-width-40 w3-margin-right',
						cancelButton: 'w3-button w3-red w3-round-large w3-width-40 w3-margin-left'
					},
					showLoaderOnConfirm: true,
					preConfirm: () => {
						const fd = new FormData()
						fd.append('restaurar', true)
						const respuesta = axios.post('backend/restaurarBD.php', fd)
						respuesta.then(respuesta => {
							respuesta = respuesta.data
							if (!respuesta)
								alerta.fire({title: 'Ha ocurrido un error'})
									.then(() => restaurarBD())
							notificacion.fire({
								title: 'Copia de seguridad restaurada exitósamente',
								footer: '<b class="w3-text-green">REINICIANDO EL SISTEMA</b>, por favor espere...',
								toast: false,
								position: 'center',
								timer: 5000,
								allowOutsideClick: false,
								allowEnterKey: false,
								allowEscapeKey: false,
								stopKeydownPropagation: true
							}).then(() => resolve(true))
						})
					}
				})
			}
		})
		
		resolve(true)
	})
}

export default restaurarBD