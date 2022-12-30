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
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, error => alerta(error).show())

verClave(form.clave.nextElementSibling, form.clave)
verClave(form.confirmar.nextElementSibling, form.confirmar)

validar(form, (error, fd, e) => {
	if (error) return alerta(error).show()
	
	e.preventDefault()
	mostrarLoader(form)
	
	fd.append(inputFile.id, inputFile.files[0])
	fd.append('cargo', 'a')
	ajax('backend/registrarUsuario.php', fd, res => {
		/** @type {Respuesta} */
		const datos = JSON.parse(res)
		
		if (datos.error)
			return alerta(datos.error)
				.on('afterClose', () => ocultarLoader(form))
				.show()
		
		ocultarLoader(form)
		
		return notificacion('Administrador registrado exitósamente.')
			.on('afterClose', () => location.reload())
			.show()
	})
})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/