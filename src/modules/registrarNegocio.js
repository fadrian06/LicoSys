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

/** @type {HTMLDivElement} */
const overlay = form.previousElementSibling
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, error => alerta(error).show())

validar(form, (error, fd, e) => {
	if (error) return alerta(error).show()
	
	e.preventDefault()
	mostrarLoader(overlay, form)
	
	fd.append(inputFile.id, inputFile.files[0])
	
	ajax('backend/registrarNegocio.php', fd, res => {
		/** @type {Respuesta} */
		let respuesta = JSON.parse(res)
		
		if (respuesta.error) return alerta(respuesta.error)
			.on('afterClose', () => ocultarLoader(overlay, form))
			.show()
		
		ocultarLoader(overlay, form)
		
		return notificacion('Negocio registrado exitósamente.')
			.on('afterClose', () => location.reload())
			.show()
	})
})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/