import { BASE_URI } from '../config'
import html from '../views/registrarNegocio.html'
// import Swal from 'sweetalert2'
import axios from 'axios'
import validarFormulario from './validarFormulario'
import actualizarImagen from './actualizarImagen'

const registrarNegocio = () => {
	// const container = Swal.getContainer()
	actualizarImagen()
	validarFormulario(document.forms[0])
}

export default async () => {
	let uri = `${BASE_URI}/backend/registrarNegocio.php`
	const { data } = await axios.get(uri, { params: { comprobarNegocio: true } })
	if (!data){
		document.body.style.backgroundColor = 'rgba(54, 70, 93, 0.99)'
		document.querySelector('main').innerHTML = html
		registrarNegocio()
	}
}