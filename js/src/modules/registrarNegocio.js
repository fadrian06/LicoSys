const formulario = w3.getElement('#registrarNegocio')
const icono = w3.getElement('.icon-refresh');
actualizarFoto()
validar(formulario)

const ajax = e => {
	e.preventDefault()
	
	icono.classList.toggle('w3-hide')
	icono.style.display = 'inline-block'
	
	const formData = new FormData(formulario)
	const file = formulario.imagen.files[0]
	
	if(file) formData.append('foto', file)

	axios.post('ajax/registrarNegocio.php', formData)
		.then(respuesta => {
			respuesta = respuesta.data
			if (!respuesta.ok) {
				icono.classList.toggle('w3-hide')
				icono.style = null
				alerta(respuesta.mensaje, true, 5000)
			} else {
				formulario.classList.add('w3-hide');
				setTimeout(() => location.reload(), 5000)
				notificacion(respuesta.mensaje, false, 5000)
			}
		})
}

formulario.addEventListener('submit', ajax)