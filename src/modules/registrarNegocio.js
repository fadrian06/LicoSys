import { BASE_URI } from '../config'
import html from '../views/registrarNegocio.html'
import Swal from 'sweetalert2'
import axios from 'axios'
import validarFormulario from './validarFormulario'

const registrarNegocio = () => {
	const container = Swal.getContainer()
	validarFormulario(container.querySelector('form'))
}

export default async () => {
	let uri = `${BASE_URI}/backend/registrarNegocio.php`
	const { data } = await axios.get(uri, { params: { comprobarNegocio: true } })
	if (!data)
		Swal.fire({
			html,
			showConfirmButton: false,
			allowOutsideClick: false,
			allowEnterKey: false,
			allowEscapeKey: false,
			customClass: {
				popup: 'w3-card-4 w3-white scroll',
				htmlContainer: 'w3-text-black w3-margin'
			},
			didOpen: registrarNegocio
		})
}