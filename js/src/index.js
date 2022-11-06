import { advertencia, notificacion } from './modules/alertas'
import comprobarBD from './modules/comprobarBD'
import registrarNegocio from './modules/registrarNegocio'

onoffline = () => advertencia.fire({ title: 'Se ha perdido la conexión' })
ononline = () => notificacion.fire({ title: 'Se ha reestablecido la conexión' })

comprobarBD().then(() => {
	document.body.setAttribute('w3-include-HTML', 'vistas/registrarNegocio.html')
	w3.includeHTML(() => {
		w3.addClass('div.w3-modal-content', 'w3-animate-zoom')
		registrarNegocio().then(() => console.log('funciona'))
	})
})