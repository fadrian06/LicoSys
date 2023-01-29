/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
const form = document.querySelector('#registrarPreguntasRespuestas')

/** @param  {RespuestaCruda} res */
function recibirRespuesta(res) {
	/** @type {Respuesta} */
	const respuesta = JSON.parse(res)
		
	if (respuesta.error)
		return alerta(respuesta.error)
			.on('afterClose', () => ocultarLoader(form))
			.show()
		
	ocultarLoader(form)
		
	Noty.closeAll()
		
	return notificacion('Registro exitoso.')
		.on('onClose', () => location.reload())
		.show()
}
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
verClave(form.res1.nextElementSibling, form.res1)
verClave(form.res2.nextElementSibling, form.res2)
verClave(form.res3.nextElementSibling, form.res3)
labelPreguntas(form)

$('#masTarde').on('click', e => {
	e.preventDefault()
	
	let textoConfirmacion = `
		<h2 class="w3-large w3-margin-bottom">
			<strong>¿Estás seguro que desea realizar este proceso más tarde?</strong>
		</h2>
		<p class="w3-padding-top-16 w3-justify w3-medium w3-text-red">
			&nbsp;&nbsp;Es recomendable que cree sus preguntas y respuestas secretas, pues 
			le permitirán recuperar su contraseña en caso de extraviarla.
		</p>
		<p class="w3-padding-top-16">
			¿Registrar preguntas y respuestas más tarde?
		</p>
	`
	
	return confirmar(textoConfirmacion, 'center', () => {
		form.pre1.value = 'No especificada'
		form.pre2.value = 'No especificada'
		form.pre3.value = 'No especificada'
		const fd = new FormData(form)
		ajax('backend/registrarPreguntasRespuestas.php', fd, recibirRespuesta)
	}).show()
})

validar(form, (error, fd, e) => {
	if (error) return alerta(error).show()
	
	e.preventDefault()
	mostrarLoader(form)
	
	ajax('backend/registrarPreguntasRespuestas.php', fd, recibirRespuesta)
})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/