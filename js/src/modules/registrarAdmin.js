import actualizarFoto from './actualizarFoto'
import validar from './validar'
import verClave from './verClave'

/**
 * @return {[Promise<bool>]}
 */
const registrarAdmin = () => {
	return new Promise(resolve => {
		
		axios.get('backend/registrarAdmin.php', { params: { comprobarAdmin: true } })
			.then(respuesta => {
				if (respuesta.data)
					setTimeout(() => resolve(true), 1000)
			})
		
		const formulario = document.querySelector('#registrarAdmin')
		const icono      = document.querySelector('.icon-refresh')
		actualizarFoto()
		verClave()
		validar(formulario)

		formulario.addEventListener('submit', e => {
			e.preventDefault()
			
			icono.classList.toggle('w3-hide')
			icono.style.display = 'inline-block'
			
			const formData = new FormData(formulario)
			formData.append('registrarAdmin', true)
			const file = formulario.foto.files[0]
			
			if (file) formData.append('foto', file)

			axios.post('backend/registrarAdmin.php', formData)
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

export default registrarAdmin