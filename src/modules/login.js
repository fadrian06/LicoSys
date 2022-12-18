/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLDivElement} */
const contenedorReloj = document.querySelector('.reloj')

/** @type {HTMLFormElement} */
const form = document.querySelector('#login')

/** @type {HTMLDivElement} */
const overlay = document.querySelector('.w3-overlay')

/** @type {HTMLElement} */
const loader = form.querySelector('#loader')
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
$('#typed-container').css('cursor', 'pointer')
modal($('#typed-container')[0], $('#acercaDe')[0], overlay)

reloj(contenedorReloj)
setInterval(() => reloj(contenedorReloj), 1 * 1000 * 60)

verClave(form.clave.nextElementSibling, form.clave)

new Typed('#typed', {
	strings: [
		'<i>Sencillo.</i>',
		'<i>Moderno.</i>',
		'<i>Seguro.</i>'
	],
	typeSpeed: 100,
	startDelay: 1000,
	backSpeed: 50,
	loop: true,
	cursorChar: '/'
})

form.usuario.addEventListener('blur', () => {
	if (!form.usuario.value) return
	
	loader.classList.remove('w3-hide')
	loader.classList.add('w3-show')
	
	const post = { verificarUsuario: true, usuario: form.usuario.value }
	$.post('backend/login.php', post, res => {
		/** @type {Respuesta} */
		const datos = JSON.parse(res)
		
		if (datos.error)
			return alerta(datos.error)
				.on('onShow', () => {
					loader.classList.remove('w3-show')
					loader.classList.add('w3-hide')
					form.usuario.parentElement.parentElement.classList.remove('valido')
					form.usuario.parentElement.parentElement.classList.add('invalido')
				})
				.show()
		
		const spinner = loader.querySelector('i')
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
			let text = `<i class="icon-close w3-margin-right"></i> ${datos.error}`
			if (datos.error === 'Contraseña incorrecta') ++intentos
			if (intentos <= 3) text += ` <strong>(intento: ${intentos} / 3)</strong>`
			return alerta(text)
				.on('afterClose', () => form.classList.remove('showLoader'))
				.show()
		}
		
		form.classList.remove('showLoader')
			
		let href = location.href
			
		if (!href.indexOf('index.php'))
			return location.href += 'dashboard.php'
			
		href = href.replace(/index\.php/g, coincidencia => {
			console.log(coincidencia)
			return coincidencia = 'dashboard.php'
		})
		return location.href = href
	})
})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/