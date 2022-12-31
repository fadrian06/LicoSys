/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
const form = document.querySelector('#registrarPreguntasRespuestas')
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
verClave(form.res1.nextElementSibling, form.res1)
verClave(form.res2.nextElementSibling, form.res2)
verClave(form.res3.nextElementSibling, form.res3)
labelPreguntas(form)

/** @param  {RespuestaCruda} res */
const recibirRespuesta = res => {
	/** @type {Respuesta} */
	const datos = JSON.parse(res)
		
	if (datos.error)
		return alerta(datos.error)
			.on('afterClose', () => ocultarLoader(form))
			.show()
		
	ocultarLoader(form)
		
	Noty.closeAll()
		
	return notificacion('Registro exitoso.')
		.on('onClose', () => location.reload())
		.show()
}

$('#masTarde').on('click', e => {
	e.preventDefault()
	
	let text = `
		<div class="w3-white w3-round-xlarge w3-padding w3-center w3-border" style="z-index: 1000">
			<div class="animate__animated animate__flip animate__infinite icon-question w3-xxxlarge"></div>
			<h2 class="w3-large w3-margin-bottom">
				<strong>¿Estás seguro que desea realizar este proceso más tarde?</strong>
			</h2>
			<p class="w3-padding-top-16 w3-justify">
				&nbsp;&nbsp;Es recomendable que cree sus preguntas y respuestas secretas, pues 
				le permitirán recuperar su contraseña. <strong>Tenga en cuenta que 
				si no agrega respuestas secretas, estas por defecto 
				estarán vacías y con su cédula y usuario podrán cambiar su contraseña e 
				ingresar a su perfil.</strong>
			</p>
			<p class="w3-padding-top-16">
				¿Registrar preguntas y respuestas más tarde?
			</p>
			<div class="w3-center w3-padding w3-margin-top">
				<button id="confirmar" class="w3-button w3-round-xlarge w3-blue">Sí</button>
				<button id="cancelar" class="w3-button w3-round-xlarge w3-red">No</button>
			</div>
		</div>
	`
	
	return new Noty({
		id: 'confirmacion',
		theme: null,
		text,
		layout: 'center',
		closeWith: ['button'],
		modal: true,
		callbacks: {
			onShow: () => {
				$('#confirmar').on('click', () => {
					form.pre1.value = 'No especificada'
					form.pre2.value = 'No especificada'
					form.pre3.value = 'No especificada'
					const fd = new FormData(form)
					ajax('backend/registrarPreguntasRespuestas.php', fd, recibirRespuesta)
				})
				
				$('#cancelar').on('click', () => {
					$('#confirmacion .noty_close_button')[0].click()
				})
			}
		}
	}).show()
})

validar(form, (error, fd, e) => {
	if (error) return alerta(error).show()
	
	e.preventDefault()
	mostrarLoader(form)
	
	ajax('backend/registrarPreguntasRespuestas.php', fd, recibirRespuesta)
})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/