/** @typedef {import('./funciones')} */

let textoConfirmacion = `
	<h2 class="w3-medium">Hay una copia de seguridad existente.</h2>
	<strong>¿Desea restaurarla?</strong>
`

confirmar(textoConfirmacion, 'bottomRight', peticionRestaurarBD).show()

function peticionRestaurarBD(e) {
	e.target.innerHTML = '<i class="w3-spin icon-spinner"></i>'
	$('.w3-spin').removeClass('icon-question')
	$('.w3-spin').addClass('icon-spinner')
	
	$.post('backend/backupBD.php', { restaurar: true }, recibirRespuesta)	
}

function recibirRespuesta(res) {
	/** @type {Respuesta} */
	const respuesta = JSON.parse(res)	
	if (respuesta.error) return alerta(respuesta.error).show()
	
	let textoReiniciandoSistema = `
		<div class="w3-card w3-round-xlarge w3-white w3-padding-large w3-center">
			<h1 class="w3-xlarge oswald">${respuesta.ok}</h1>
			<h2 class="w3-large w3-padding-top-24 w3-topbar">
				Reiniciando el Sistema...
			</h2>	
		</div>
	`
	
	const alertaReiniciando = new Noty({
		theme: null,
		id: 'intro',
		type: 'info',
		text: textoReiniciandoSistema,
		layout: 'center',
		modal: true,
		closeWith: [null],
		animation: { open: 'w3-animate-zoom' },
		timeout: 5000,
		callbacks: {
			onShow: () => mostrarLoader($('form')[0]),
			afterClose: () => redirigir('salir.php')
		}
	})
	
	alertaReiniciando.show()
}