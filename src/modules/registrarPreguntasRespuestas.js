/**
 * @type {HTMLFormElement}
 */
const form = document.querySelector('#registrarPreguntasRespuestas')
/**
 * @type {HTMLDivElement}
 */
const overlay = form.previousElementSibling

verClave(form.res1.nextElementSibling, form.res1)
verClave(form.res2.nextElementSibling, form.res2)
verClave(form.res3.nextElementSibling, form.res3)

form.pre1.addEventListener('keyup', () => {
	const legendRespuesta = form.querySelector(`sup[respuesta=${form.res1.id}]`)
	legendRespuesta.innerText = `(${form.pre1.value})`
})

form.pre3.addEventListener('keyup', () => {
	const legendRespuesta = form.querySelector(`sup[respuesta=${form.res2.id}]`)
	legendRespuesta.innerText = `(${form.pre2.value})`
})

form.pre3.addEventListener('keyup', () => {
	const legendRespuesta = form.querySelector(`sup[respuesta=${form.res3.id}]`)
	legendRespuesta.innerText = `(${form.pre3.value})`
})

/**
 * @param  {string} res {error: string, datos: []}
 */
const recibirRespuesta = res => {
	/**
	 * @type {{error: string, datos: []}}
	 */
	const datos = JSON.parse(res)
	
	if (datos.error) return new Noty({
		text: `<i class="icon-close w3-margin-right"></i> ${datos.error}`,
		type: 'error',
		timeout: 5000,
		callbacks: {
			afterClose: () => {
				overlay.classList.remove('w3-show')
				overlay.classList.add('w3-hide')
				form.classList.remove('showLoader')
			}
		}
	}).show()
	
	overlay.classList.remove('w3-show')
	overlay.classList.add('w3-hide')
	form.classList.remove('showLoader')
	
	Noty.closeAll()
	
	new Noty({
		text: `<i class="icon-check w3-margin-right"></i> Registro exitoso.`,
		type: 'success',
		timeout: 5000,
		callbacks: { afterClose: () => location.reload() }
	}).show()
}

const enviarDatos = () => {
	form.pre1.value = 'No especificada'
	form.pre2.value = 'No especificada'
	form.pre3.value = 'No especificada'
	const fd = new FormData(form)
	$.ajax({
		url: 'backend/registrarPreguntasRespuestas.php',
		type: 'POST',
		data: fd,
		contentType: false,
		processData: false,
		success: recibirRespuesta
	})
}

const esperarRespuesta = () => {
	$('.noty_close_button').click(() => {
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
	})
	$('#confirmar').click(enviarDatos)
	$('#cancelar').click(() => {
		$('#confirmacion .noty_close_button')[0].click()
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
	})
}

form.querySelector('#masTarde').onclick = e => {
	
	e.preventDefault()
	overlay.style.zIndex = '999'
	overlay.classList.remove('w3-hide')
	overlay.classList.add('w3-show')
	
	let html = `
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
	
	new Noty({
		id: 'confirmacion',
		theme: null,
		text: html,
		layout: 'center',
		closeWith: ['button'],
		callbacks: { onShow: esperarRespuesta }
	}).show()
}

validar(form, (error, fd, e) => {
	if (error) return new Noty({
		text: `<i class="icon-close w3-margin-right"></i> ${error}`,
		type: 'error',
		timeout: 3000
	}).show()
	
	e.preventDefault()
	overlay.style.zIndex = '999'
	overlay.classList.remove('w3-hide')
	overlay.classList.add('w3-show')
	form.classList.add('showLoader')
	
	$.ajax({
		url: 'backend/registrarPreguntasRespuestas.php',
		type: 'POST',
		data: fd,
		contentType: false,
		processData: false,
		success: recibirRespuesta
	})
})