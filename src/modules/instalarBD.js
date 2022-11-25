import { BASE_URI } from '../config'
import UI from '../UI'
import Swal from 'sweetalert2'
import axios from 'axios'

export default async () => {
	const uri = `${BASE_URI}/backend/conexion.php`
	const { data } = await axios.get(uri, { params: { comprobarBD: true } })
	if (!data) {
		axios.post(uri, { restaurarBD: true }).then(({ data }) => {
			if (data) {
				setTimeout(() => {
					Swal.close()
					Swal.fire({
						title: 'LicoSys instalado correctamente',
						icon: 'success',
						footer: 'Sólo faltan unos pocos pasos más...',
						showConfirmButton: false,
						allowEnterKey: false,
						allowEnterKey: false,
						allowOutsideClick: false,
						timer: 5000
					})
				}, 5000)
			}
		})
		UI.showLoader()
	}
}