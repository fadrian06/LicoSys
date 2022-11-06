/**
 * MUESTRA U OCULTA LAS CONTRASEÑAS
 * @param  {HTMLElement} ojo El elemento que muestra u oculta la contraseña
 */
const verClave = ojo => {
	let input = ojo.parentElement.previousElementSibling
	if (input.type == 'password') {
		input.type = 'text'
		ojo.className = 'icon-eye-slash'
	} else {
		input.type = 'password'
		ojo.className = 'icon-eye'
	}
}

const ojos = w3.getElements('.icon-eye')
if (ojos !== undefined)
	ojos.forEach(ojo => ojo.addEventListener('click', e => verClave(e.target)))

/**
 * Alias de querySelector()
 * @param  {string} id Un selector CSS
 * @return {HTMLElement?}    Un elemento HTML
 */
w3.getElement = id => w3.getElements(id)[0]

/**
 * CREA UN RELOJ EN TIEMPO REAL EN EL CONTENEDOR ESPECIFICADO
 * @param  {HTMLElement} contenedor El contenedor del reloj
 */
const reloj = contenedor => {
	const fecha = new Date()
	let horas = fecha.getHours(),
		ampm,
		minutos = fecha.getMinutes(),
		diaSemana = fecha.getDay(),
		dia = fecha.getDate(),
		mes = fecha.getMonth(),
		year = fecha.getFullYear()
	const semana = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado']
	const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']

	if (horas >= 12) {
		horas = horas - 12
		ampm = 'PM'
	} else ampm = 'AM'

	if (horas == 0) horas = 12
	if (minutos < 10) minutos = `0${minutos}`

	contenedor.innerHTML = `
		<div class='fecha'>
			<b id='diaSemana'>${semana[diaSemana]}</b>
			<b id='dia'>${dia}</b>
			<b>de </b>
			<b id='mes'>${meses[mes]}</b>
			<b>del </b>
			<b id='year'>${year}</b>
		</div>
		<div class='reloj'>
			<b id='horas'>${horas}</b>
			<b>:</b>
			<b id='minutos'>${minutos}</b>
			<b id='ampm'>${ampm}</b>
		</div>
	`
}

/**
 * CONTROLA EL MÉNU DE NAVEGACION
 * @param  {HTMLElement} boton   El botón que muestra y oculta el menú
 * @param  {HTMLElement} modal   El contenedor del menú
 * @param  {HTMLElement} overlay El fondo opaco
 */
const menu = (boton, modal, overlay) => {
	
	boton.addEventListener('click', () => {
		overlay.classList.replace('w3-hide', 'w3-show')
		overlay.style.cursor = 'pointer'
		modal.classList.replace('w3-hide', 'w3-show')
		modal.classList.replace('animate__animated', 'w3-animate-left')
		modal.classList.remove('animate__slideOutLeft')
		modal.classList.remove('animate__faster')
	})
	
	overlay.addEventListener('click', () => {
		modal.classList.replace('w3-animate-left', 'animate__animated')
		modal.classList.add('animate__slideOutLeft')
		modal.classList.add('animate__faster')
		overlay.classList.replace('w3-show', 'w3-hide')
		setTimeout(() => modal.classList.replace('w3-show', 'w3-hide'), 500)
	})
}

/**
 * ACTIVA UNA VENTANA EMERGENTE
 * @param  {HTMLElement} formulario El contenedor del modal
 * @param  {HTMLElement} overlay    El fondo opaco
 */
const ventanaEmergente = (formulario, overlay) => {
	const cerrar = formulario.querySelector('span')
	overlay.classList.replace('w3-hide', 'w3-show')
	overlay.style.cursor = 'pointer'
	formulario.classList.replace('w3-hide', 'w3-show')
	formulario.classList.replace('animate__fadeOutDown', 'animate__fadeInUp')

	overlay.addEventListener('click', e => {
		e.target.classList.replace('w3-show', 'w3-hide')
		formulario.classList.replace('animate__fadeInUp', 'animate__fadeOutDown')
		setTimeout(() => formulario.classList.replace('w3-show', 'w3-hide'), 500)
	})

	cerrar.addEventListener('click', e => {
		e.target.classList.replace('w3-show', 'w3-hide')
		overlay.classList.replace('w3-show', 'w3-hide')
		formulario.classList.replace('animate__fadeInUp', 'animate__fadeOutDown')
		setTimeout(() => formulario.classList.replace('w3-show', 'w3-hide'), 500)
	})
}

/**
 * CREA UN MODAL
 * @param  {HTMLElement} boton      El botón que activa el modal
 * @param  {HTMLElement} formulario El contenedor del modal
 * @param  {HTMLElement} overlay    El fondo opaco
 */
const modal = (boton, formulario, overlay) => {
	boton.addEventListener('click', e => {
		e.preventDefault()
		ventanaEmergente(formulario, overlay)
	})
}


// Filter
function filterFunction(input, div) {
	let filter, ul, li, a
	div = document.getElementById(div)
	input = document.getElementById(input)
	filter = input.value.toUpperCase()
	a = div.getElementsByTagName('button')
	for (let i = 0; i < a.length; ++i) {
		let txtValue = a[i].textContent || a[i].innerText
		if (txtValue.toUpperCase().indexOf(filter) > -1) {
			a[i].style.display = ''
		} else {
			a[i].style.display = 'none'
		}
	}
}