import { advertencia, notificacion } from './modules/alertas'
import comprobarBD from './modules/comprobarBD'
import registrarAdmin from './modules/registrarAdmin'
import registrarNegocio from './modules/registrarNegocio'
import restaurarBD from './modules/restaurarBD'

onoffline = () => advertencia.fire({ title: 'Se ha perdido la conexión' })
ononline  = () => notificacion.fire({ title: 'Se ha reestablecido la conexión' })

comprobarBD().then(resultado => {
	console.log(resultado)
	document.head.innerHTML += '<link rel="stylesheet" href="assets/libraries/sweetalert2/borderless.min.css">'
	document.body.setAttribute('w3-include-HTML', 'vistas/registrarNegocio.html')
	w3.includeHTML(() => {
		w3.addClass('.w3-modal-content', 'w3-animate-zoom')
		restaurarBD()
		registrarNegocio().then(() => {
			document.body.setAttribute('w3-include-HTML', 'vistas/registrarAdmin.html')
			w3.includeHTML(() => {
				w3.addClass('.w3-modal-content', 'w3-animate-right')
				restaurarBD()
				registrarAdmin().then(() => {
					notificacion.fire({
						title: 'Bienvenido a LicoSys',
						html: 'Realizando últimas configuraciones, por favor espere...',
						toast: false,
						position: 'center',
						timer: 5000
					}).then(() => {
						document.body.setAttribute('w3-include-HTML', 'vistas/login.html')
						w3.includeHTML(() => {
							// login code here
						})
					}
				)})
			})
		})
	})
})