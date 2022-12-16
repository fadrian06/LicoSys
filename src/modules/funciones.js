/**
 * @typedef {object} Respuesta Respuesta del servidor
 * @property {string} Respuesta.error Errores que lanza el servidor.
 * @property {object} Respuesta.datos Objeto con datos de la posible consulta.
 * @typedef {string} RespuestaCruda Respuesta serializada `"{error: string, datos: {}}"`
 * @typedef {import('../../libs/noty/index').*} Noty
 * @typedef {import('../../libs/jquery.min.js').*} $
 * @typedef {import('../../libs/typedjs/index').*} Typed
 * @typedef {import('../../libs/w3/w3.min').*} w3
 * @typedef {import('./validar')}
 * @typedef {import('./actualizarImagen')}
 * @typedef {import('./reloj')}
 */

Noty.overrideDefaults({
	theme: 'sunset'
})

/**
 * Muestra el modal :V
 * @param  {HTMLElement} modal Contenedor del modal.
 * @param  {HTMLDivElement} overlay Elemento que opaca el fondo.
 * @param {()} [callback] Función adicional a ejecutar al cerrar el modal. 
 */
const mostrarModal = (modal, overlay, callback = () => {}) => {
	/** @type {HTMLSpanElement} */
	const cerrar = modal.querySelector('.icon-close')
	overlay.classList.remove('w3-hide')
	overlay.classList.add('w3-show')
	overlay.style.cursor = 'pointer'
	overlay.style.zIndex = '999'
	modal.style.paddingTop = '0'
	modal.style.paddingRight = '0'
	modal.style.paddingLeft = '0'
	modal.classList.remove('w3-hide')
	modal.classList.add('w3-show')
	modal.classList.remove('animate__fadeOutDown')
	modal.classList.add('animate__fadeInUp')
	
	overlay.onclick = () => {
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
		modal.classList.remove('animate__fadeInUp')
		modal.classList.add('animate__fadeOutDown')
		setTimeout(() => {
			modal.classList.remove('w3-show')
			modal.classList.add('w3-hide')
		}, 500)
		callback()
	}
	
	cerrar.onclick = () => {
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
		modal.classList.remove('animate__fadeInUp')
		modal.classList.add('animate__fadeOutDown')
		setTimeout(() => {
			modal.classList.remove('w3-show')
			modal.classList.add('w3-hide')
		}, 500)
		callback()
	}
}

/**
 * Define el comportamiento de un modal.
 * @param  {HTMLElement} boton Un element `<button>` o `<a>`
 * @param  {HTMLElement} modal El contenedor del modal.
 * @param  {HTMLDivElement} overlay El elemento que opaca el fondo.
 */
const modal = (boton, modal, overlay) => {
	boton.onclick = e => {
		e.preventDefault()
		mostrarModal(modal, overlay)
	}
}

/**
 * Opaca el fondo y muestra el loader.
 * @param  {HTMLDivElement} overlay Elemento `<div>` que opaca el fondo.
 * @param  {HTMLFormElement} form Formulario contenedor de algún elemento con `id='loader'`
 */
const mostrarLoader = (overlay, form) => {
	overlay.style.zIndex = '999'
	overlay.classList.remove('w3-hide')
	overlay.classList.add('w3-show')
	form.classList.add('showLoader')
}

/**
 * Quita el fondo opaco y el loader.
 * @param  {HTMLDivElement} overlay Elemento `<div>` que opaca el fondo.
 * @param  {HTMLFormElement} form    Formulario contenedor de algún elemento con `id='loader'`
 */
const ocultarLoader = (overlay, form) => {
	overlay.classList.remove('w3-show')
	overlay.classList.add('w3-hide')
	form.classList.remove('showLoader')
}

/**
 * Realiza una petición POST
 * @param  {string} url     Ruta relativa al fichero PHP
 * @param  {FormData} data    Datos a enviar.
 * @param  {(res: RespuestaCruda)} success Una función que recibe la respuesta del servidor.
 */
const ajax = (url, data, success) => {
	$.ajax({
		url,
		type: 'POST',
		data,
		contentType: false,
		processData: false,
		success
	})
}

/**
 * Muestra u oculta la contraseña
 * @param  {HTMLElement} ojo El ícono
 * @param {HTMLInputElement} input `<input type="password">`
 */
const verClave = (ojo, input) => {
	ojo.onclick = () => {
		if (input.type === 'password') {
			input.type = 'text'
			ojo.classList.remove('icon-eye')
			ojo.classList.add('icon-eye-slash')
			return
		}
		
		input.type = 'password'
		ojo.classList.remove('icon-eye-slash')
		ojo.classList.add('icon-eye')
	}
}

/**
 * Muestra una alerta :V
 * @param  {string} texto Texto de la alerta.
 * @param {number} timer Milisegundos que deben pasar para ocultar la alerta.
 */
const alerta = (texto, timer = 2000) => {
	return new Noty({
		text: `<i class="icon-close w3-margin-right"></i> ${texto}`,
		type: 'error',
		timeout: timer
	})
}

/**
 * @param  {string} texto
 */
const notificacion = texto => {
	return new Noty({
		text: `<i class="icon-check w3-margin-right"></i> ${texto}`,
		type: 'success',
		timeout: 3000
	})
}

/**
 * @param  {string} texto
 */
const advertencia = texto => {
	return new Noty({
		text: `<i class="icon-warning w3-margin-right"></i> ${texto}`,
		type: 'warning',
		timeout: 3000
	})
}

onoffline = () => advertencia('Se ha perdido la conexión').show()
ononline  = () => notificacion('Se ha restablecido la conexión').show()

// function menu(boton, modal, overlay) {
// 	boton.addEventListener("click", e => {
// 		overlay.classList.replace("w3-hide", "w3-show");
// 		overlay.style.cursor = "pointer";
// 		modal.classList.replace("w3-hide", "w3-show");
// 		modal.classList.replace("animate__animated", "w3-animate-left");
// 		modal.classList.remove("animate__slideOutLeft");
// 		modal.classList.remove("animate__faster");
// 	});
// 	overlay.addEventListener("click", e => {
// 		modal.classList.replace("w3-animate-left", "animate__animated");
// 		modal.classList.add("animate__slideOutLeft");
// 		modal.classList.add("animate__faster");
// 		e.target.classList.replace("w3-show", "w3-hide");
// 		setTimeout(() => modal.classList.replace("w3-show", "w3-hide"), 500);
// 	});
// }

// // Filter
// function filterFunction(input, div) {
// 	let filter, ul, li, a;
// 	div    = document.getElementById(div);
// 	input  = document.getElementById(input);
// 	filter = input.value.toUpperCase();
// 	a      = div.getElementsByTagName("button");
// 	for (let i = 0; i < a.length; i++) {
// 		let txtValue = a[i].textContent || a[i].innerText;
// 		if (txtValue.toUpperCase().indexOf(filter) > -1) {
// 			a[i].style.display = "";
// 		} else {
// 			a[i].style.display = "none";
// 		}
// 	}
// }