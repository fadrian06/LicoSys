import actualizarFoto from './actualizarFoto'
import validar from './validar'
import axios from 'axios'

/**
 * @return {[Promise<bool>]}
 */
const registrarNegocio = () => {
	return new Promise(resolve => {
		axios.get('backend/registrarNegocio.php', { params: { comprobarNegocio: true } })
			.then(respuesta => {
				if (respuesta.data)
					setTimeout(() => resolve(true), 1000)
			})
		
		const formulario = document.querySelector('#registrarNegocio')
		const icono      = document.querySelector('.icon-refresh')
		actualizarFoto()
		validar(formulario)

		formulario.addEventListener('submit', e => {
			e.preventDefault()
			
			icono.classList.toggle('w3-hide')
			icono.style.display = 'inline-block'
			
			const formData = new FormData(formulario)
			formData.append('registrarNegocio', true)
			const file = formulario.logo.files[0]
			
			if (file) formData.append('logo', file)

			axios.post('backend/registrarNegocio.php', formData)
				.then(respuesta => {
					respuesta = respuesta.data
					
					if (!respuesta.ok) {
						icono.classList.toggle('w3-hide')
						icono.style = null
						Swal.fire({
							title: respuesta.mensaje,
							icon: 'error',
							toast: true,
							position: 'bottom-end',
							timer: 3000,
							showConfirmButton: false
						})
						return
					}
					
					Swal.fire({
						title: respuesta.mensaje,
						icon: 'success',
						timer: 3000,
						showConfirmButton: false
					}).then(() => resolve(true))
				})
		})
	})
}

export default registrarNegocio