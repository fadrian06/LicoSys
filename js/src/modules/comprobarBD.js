import axios from 'axios'
import Swal from 'sweetalert2'

/**
 * Comprueba si la base de datos está creada
 * @return {Promise} Retorna `true` que significa que la función terminó su ejecución
 */
const comprobarBD = () => new Promise(resolve => {
	axios.get('index.php?comprobarBD=true').then(respuesta => {
			
		if (respuesta.data) // Si existe la base de datos
			resolve('existe')
		
		// No existe la base de datos
		document.head.innerHTML += '<link rel="stylesheet" href="assets/libraries/sweetalert2/borderless.min.css">'
		Swal.fire({
			title: "<h1>Bienvenido a LicoSys</h1><div class='newtons-cradle'><div class='newtons-cradle__dot'></div><div class='newtons-cradle__dot'></div><div class='newtons-cradle__dot'></div><div class='newtons-cradle__dot'></div></div>",
			showConfirmButton: false,
			text: 'Estamos configurando algunas cosas, por favor espere...',
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			stopKeydownPropagation: true,
			willOpen: () => {
				const fd = new FormData()
				fd.append('crearBD', 'true')
				axios.post('index.php', fd)
					.then(respuesta => {
						if (respuesta.data)
							setTimeout(() => Swal.close(), 5000)
					})
			}
		}).then(() => {
			Swal.fire({
				title: 'LicoSys instalado correctamente',
				icon: 'success',
				text: 'Solo faltan unos pocos pasos más...',
				allowOutsideClick: false,
				allowEscapeKey: false,
				allowEnterKey: false,
				stopKeydownPropagation: true,
				showConfirmButton: false,
				timer: 5000
			}).then(() => resolve('creada'))
		})
	})
		
	document.body.style.background = 'rgb(54, 70, 93)'
})

export default comprobarBD;