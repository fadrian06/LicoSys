/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLDivElement} */
const contenedorReloj = document.querySelector('.reloj')
/** @type {HTMLFormElement} */
const form = document.querySelector('#login')
/** @type {HTMLElement} */
const usuarioLoader = form.querySelector('#usuarioLoader')
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reloj(contenedorReloj)
setInterval(() => reloj(contenedorReloj), 1 * 1000 * 60 /*1 minuto*/)
verClave(form.clave.nextElementSibling, form.clave)

new Typed('#typed', {
	strings: [
		'<i>Sencillo.</i>',
		'<i>Rápido.</i>',
		'<i>Moderno.</i>',
		'<i>Seguro.</i>',
		'<i>Completo.</i>'
	],
	typeSpeed: 100,
	startDelay: 1000,
	backSpeed: 50,
	loop: true,
	cursorChar: '<i class="w3-medium icon-chevron-left"></i>'
})

form.usuario.addEventListener('blur', () => {
	if (!form.usuario.value) return
	
	usuarioLoader.classList.remove('w3-hide')
	usuarioLoader.classList.add('w3-show')
	
	const post = { verificarUsuario: true, usuario: form.usuario.value }
	$.post('backend/login.php', post, res => {
		/** @type {Respuesta} */
		const datos = JSON.parse(res)
		
		if (datos.error)
			return alerta(datos.error)
				.on('onShow', () => {
					usuarioLoader.classList.remove('w3-show')
					usuarioLoader.classList.add('w3-hide')
					form.usuario.parentElement.parentElement.classList.remove('valido')
					form.usuario.parentElement.parentElement.classList.add('invalido')
				})
				.show()
		
		const spinner = usuarioLoader.querySelector('i')
		spinner.classList.remove('icon-spinner', 'w3-spin')
		spinner.classList.add('icon-check', 'w3-text-green')
		form.usuario.parentElement.parentElement.classList.add('valido')
	})
})


let intentos = 0
validar(form, (error, fd, e) => {
	if (error) return alerta(error).show()
		
	e.preventDefault()
		
	form.classList.add('showLoader')
		
	fd.append('login', true)
	ajax('backend/login.php', fd, res => {
		/** @type {Respuesta} */
		const datos = JSON.parse(res)
			
		if (datos.error) {
			let text = datos.error
			if (datos.error === 'Contraseña incorrecta') ++intentos
			if (intentos <= 3 && intentos > 0) text += ` <strong>(intento: ${intentos} / 3)</strong>`
			else {
				/**
			
					TODO:
					- Bloquear a los 3 intentos
			
				 */
				intentos = 0
			}
			return alerta(text)
				.on('onShow', () => form.classList.remove('showLoader'))
				.show()
		}
		
		form.classList.remove('showLoader')
		
		let href = location.href
		
		form.parentElement.classList.add('showLoader')
		if (!href.indexOf('index.php')) return location.href += 'dashboard.php'
			
		href = href.replace(/index\.php/g, coincidencia => {
			coincidencia = 'dashboard.php'
			return coincidencia
		})
		return location.href = href
	})
})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/