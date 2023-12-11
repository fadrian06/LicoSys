/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
const form = document.querySelector('#registrarNegocio')
/** @type {HTMLInputElement} */
const inputFile = form.logo
/** @type {HTMLImageElement} */
const image = form.querySelector('.image-result')
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, error => {
	if (error) return alerta(error).show()
})

validar(form, (error, fd, e) => {
	if (error) return alerta(error).show()
	
	e.preventDefault()
	mostrarLoader(form)
	
	fd.append(inputFile.id, inputFile.files[0])
	
	ajax('backend/registrarNegocio.php', fd, res => {
		/** @type {Respuesta} */
		const respuesta = JSON.parse(res)
		
		if (respuesta.error) return alerta(respuesta.error)
			.on('afterClose', () => ocultarLoader(form))
			.show()
		
		ocultarLoader(form)
		
		return notificacion(respuesta.ok)
			.on('onClose', () => location.reload())
			.show()
	})
})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/