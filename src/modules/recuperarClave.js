// @ts-nocheck
/** @typedef {import('./funciones')} */
/** @typedef {import('./login')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLButtonElement} */
const botonRecuperar = document.querySelector('#recuperar')
/** @type {HTMLFormElement} */
const formConsulta = document.querySelector('#consultar')
/** @type {HTMLFormElement} */
const formPreguntasRespuestas = document.querySelector('#preguntasRespuestas')
/** @type {HTMLFormElement} */
const formClave = document.querySelector('#cambiarClave')
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
botonRecuperar.onclick = e => {
	e.preventDefault()
	modal(botonRecuperar)
}

validar(formConsulta, (error, fd, e) => {
	if (error) return alerta(error).show()
		
	e.preventDefault()
	formConsulta.classList.add('showLoader')
	fd.append('consultar', true)
	ajax('backend/recuperarClave.php', fd, res => {
		/** @type {Respuesta} */
		const datos = JSON.parse(res)
		
		if (datos.error)
			return alerta(datos.error)
				.on('onShow', () => formConsulta.classList.remove('showLoader'))
				.show()
		
		formConsulta.classList.remove('showLoader')
		location.reload()
	})
})

if (formPreguntasRespuestas) {
	mostrarModal(formPreguntasRespuestas, () => {
		return $.post('backend/recuperarClave.php', { cerrar: true }, res => {
			console.log(res)
		})
	})
	verClave(formPreguntasRespuestas.res1.nextElementSibling, formPreguntasRespuestas.res1)
	verClave(formPreguntasRespuestas.res2.nextElementSibling, formPreguntasRespuestas.res2)
	verClave(formPreguntasRespuestas.res3.nextElementSibling, formPreguntasRespuestas.res3)
	validar(formPreguntasRespuestas, (error, fd, e) => {
		if (error) return alerta(error).show()
		
		e.preventDefault()
		formPreguntasRespuestas.classList.add('showLoader')
		fd.append('verificarRespuestas', true)
		return ajax('backend/recuperarClave.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			if (datos.error) return alerta(datos.error)
				.on('onShow', () => {
					formPreguntasRespuestas.classList.remove('showLoader')
				})
				.show()
		
			formPreguntasRespuestas.classList.remove('showLoader')
			location.reload()
		})
	})
}

if (formClave) {
	mostrarModal(formClave, () => {
		return $.post('backend/recuperarClave.php', { cerrar: true }, res => {
			console.log(res)
		})
	})
	verClave(formClave.clave.nextElementSibling, formClave.clave)
	verClave(formClave.confirmar.nextElementSibling, formClave.confirmar)
	
	validar(formClave, (error, fd, e) => {
		if (error) return alerta(error).show()
			
		e.preventDefault()
		formClave.classList.add('showLoader')
		fd.append('cambiarClave', true)
		return ajax('backend/recuperarClave.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			
			if (datos.error) return alerta(datos.error)
				.on('onShow', () => formClave.classList.remove('showLoader'))
				.show()
			
			formClave.classList.remove('showLoader')
			notificacion('Contraseña actualizada exitósamente.').show()
			return formClave.querySelector('.icon-close').click()
		})
	})
}
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/