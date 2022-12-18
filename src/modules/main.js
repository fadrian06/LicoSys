/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLButtonElement} */
const btnVersion = document.querySelector('#version')
/** @type {HTMLDivElement} */
const modalAcercaDe = document.querySelector('#acercaDe')
/** @type {HTMLDivElement} */
const overlay = document.querySelector('.w3-overlay')
/** @type {HTMLButtonElement} */
const barras = document.querySelector('.icon-bars').parentElement
/** @type {HTMLElement} [description] */
const menuLateral = document.querySelector('#menu')
/** @type {HTMLButtonElement} */
const btnModenas = document.querySelector('#btn-monedas')
/** @type {HTMLFormElement} */
const formMonedas = document.querySelector('#actualizarModenas')
const main = document.querySelector('main')
const dashboardHTML = main.innerHTML
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
$('a').each((_i, enlace) => {
	enlace.addEventListener('click', e => {
		/** @type {HTMLAnchorElement} */
		const enlace = e.currentTarget
		e.preventDefault()
		main.classList.add('showLoader')
		
		if (enlace.href.includes('dashboard.php')) 
			return setTimeout(() => {
				main.classList.remove('showLoader')
				main.innerHTML = dashboardHTML
			}, 500)
		
		if (enlace.href.includes('salir.php'))
			return main.classList.remove('showLoader')
		
		$.get(enlace.href, res => {
			main.classList.remove('showLoader')
			main.innerHTML = res
		})
	})
})

if (formMonedas) {
	modal(btnModenas, formMonedas, overlay)
	validar(formMonedas, (error, fd, e) => {
		if (error) return alerta(error).show()
		
		e.preventDefault()
		formMonedas.classList.add('showLoader')
		ajax('backend/actualizarMonedas.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			if (datos.error)
				return alerta(datos.error)
					.on('afterClose', () => formMonedas.classList.remove('showLoader'))
					.show()
			
			formMonedas.classList.remove('showLoader')
			
			return notificacion('Valores actualizados correctamente.')
				.on('onShow', () => formMonedas.querySelector('.icon-close').click())
				.show()
		})
	})
}

modal(btnVersion, modalAcercaDe, overlay)
menu(barras, menuLateral, overlay)

$('summary').each((_i, summary) => {
	summary.onclick = () => {
		summary.parentElement.classList.toggle('abierto')
		summary.parentElement.removeAttribute('open')
	}
})

$('[href="salir.php"]').on('click', e => {
	e.preventDefault()
	return confirmar(overlay, '¿Seguro que desea cerrar sesión?', 'center', () => {
		const url = location.href.split('/')
		url[url.length - 1] = 'salir.php'
		location.href = url.join('/')
	})
})
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/