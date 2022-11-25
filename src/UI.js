import loader from './views/loader.html'
import Swal from 'sweetalert2'
import '@sweetalert2/themes/borderless/borderless.min.css'

const showLoader = () => {
	Swal.fire({
		title: 'BIENVENIDO',
		html: loader,
		footer: 'Estamos configurando algunas cosas, por favor espere...',
		showConfirmButton: false,
		customClass: {
			title: 'w3-xxxlarge oswald',
			footer: 'w3-center',
			htmlContainer: 'no-scroll'
		},
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false
	})
}

export default {
	showLoader
}