/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
const form = document.querySelector('#registrarAdmin')

/** @type {HTMLInputElement} */
const inputFile = form.foto

/** @type {HTMLImageElement} */
const image = form.querySelector('.image-result')

/** @type {HTMLDivElement} */
const overlay = form.previousElementSibling
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, error => alerta(error).show())

verClave(form.clave.nextElementSibling, form.clave)
verClave(form.confirmar.nextElementSibling, form.confirmar)

/**
 * @param  {string} res {error: string, datos: []}
 */
const recibirRespuesta = 

	validar(form, (error, fd, e) => {
		if (error) return alerta(error).show()
	
		e.preventDefault()
		mostrarLoader(overlay, form)
	
		fd.append(inputFile.id, inputFile.files[0])
		ajax('backend/registrarAdmin.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
		
			if (datos.error)
				return alerta(datos.error)
					.on('afterClose', () => ocultarLoader(overlay, form))
					.show()
		
			ocultarLoader(overlay, form)
		
			return notificacion('Administrador registrado exitósamente.')
				.on('afterClose', () => location.reload())
				.show()
		})
	})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/