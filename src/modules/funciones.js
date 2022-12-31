//@ts-nocheck
/**
 * @typedef {object} Respuesta Respuesta del servidor
 * @property {string} Respuesta.ok El mensaje de éxito.
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

Noty.overrideDefaults({ theme: 'sunset' })

/**
 * Comportamiento de un acordión de filas en una tabla. <br>
 * <u>Requisitos</u>
 * <ul>
 *  <li>Cada acordeón debe tener el atributo `role="accordion`</li>
 *  <li>Cada acordeón debe tener un botón que sirva para abrir y cerrar</li>
 *  <li>Cada acordeón debe tener una flecha que indique su estado</li>
 * </ul>
 */
const acordeon = () => {
	const acordeones = document.querySelectorAll('[role="accordion"]')
	for (let i = 0; i < acordeones.length; ++i) {
		/** @type {HTMLButtonElement} */
		const boton = acordeones[i].firstElementChild
		const flecha = boton.querySelector('[class^="icon-chevron"]')
		boton.onclick = () => {
			boton.nextElementSibling.classList.toggle('w3-hide')
			boton.nextElementSibling.classList.toggle('w3-show')
			if (flecha) {
				flecha.classList.toggle('icon-chevron-right')
				flecha.classList.toggle('icon-chevron-down')
			}
		}
	}
}

/**
 * Comportamiento de un elemento `<details> para navegadores que no lo soportan`
 * @param  {HTMLElement} details Elemento `<details>`
 */
const mostrarDetails = details => {
	if (details) {
		const summary = details.querySelector('summary')
		const flecha = summary.querySelector('[class^="icon-chevron"]')
		summary.onclick = () => {
			details.removeAttribute('open')
			details.classList.toggle('abierto')
			if (flecha) {
				flecha.classList.toggle('icon-chevron-right')
				flecha.classList.toggle('icon-chevron-down')
			}
		}
	}
}

/** Reajusta la estructura del LicoSys, dependiendo la resolución. */
const reajustar = () => {
	if (document.body.offsetWidth < 992) {
		$('main').css('margin-left', '0')
	} else $('main').css('margin-left', '250px')
}

/** Define el comportamiento de un menú lateral. */
const menu = () => {
	/** @type {HTMLButtonElement} */
	const boton = document.querySelector('.icon-bars').parentElement
	/** @type {HTMLDivElement} */
	const overlay = document.querySelector('[role="menuOverlay"]')
	/** @type {HTMLElement} */
	const menu = document.querySelector('#menu')
	
	boton.onclick = () => {
		// Mostramos el fondo.
		overlay.classList.remove('w3-hide')
		overlay.classList.add('w3-show')
		// Mostramos el menú y cambiamos a la animación de cierre.
		menu.classList.remove('w3-hide', 'animate__animated')
		menu.classList.remove('animate__slideOutLeft', 'animate__faster')
		menu.classList.add('w3-show', 'w3-animate-left')
	}
	
	// Al cerrar el menú.
	overlay.onclick = () => {
		// Ocultar el fondo.
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
		// Cambiar a la animación de apertura.
		menu.classList.remove('w3-animate-left')
		menu.classList.add('animate__animated', 'animate__slideOutLeft')
		menu.classList.add('animate__faster')
		setTimeout(() => {
			// Ocultar el menú
			menu.classList.remove('w3-show')
			menu.classList.add('w3-hide')
		}, 500)
	}
	
	onresize = () => reajustar()
}

/**
 * @param  {HTMLElement} modal Contenedor del modal.
 * @param {()} [callback] Función adicional a ejecutar al cerrar el modal. 
 */
const mostrarModal = (modal, callback = () => {}) => {
	/** @type {HTMLSpanElement} */
	const cerrar = modal.querySelector('.icon-close')
	/** @type {HTMLDivElement} */
	const overlay = document.querySelector('[role="modalOverlay"]')
	
	// Oscurecemos el fondo
	overlay.classList.remove('w3-hide')
	overlay.classList.add('w3-show')
	
	// Mostramos el modal
	modal.classList.remove('w3-hide')
	modal.classList.add('w3-show')
	// Cambiamos a la animación de apertura
	modal.classList.remove('animate__fadeOutDown')
	modal.classList.add('animate__fadeInUp')
	
	// Al hacer click en el fondo
	overlay.onclick = () => {
		// Ocultamos el fondo
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
		// Cambiamos a la animación de cierre
		modal.classList.remove('animate__fadeInUp')
		modal.classList.add('animate__fadeOutDown')
		setTimeout(() => {
			// Ocultamos el modal
			modal.classList.remove('w3-show')
			modal.classList.add('w3-hide')
		}, 500)
		callback()
	}
	
	// Al hacer click en la X
	cerrar.onclick = () => {
		// Ocultamos el fondo
		overlay.classList.remove('w3-show')
		overlay.classList.add('w3-hide')
		// Cambiamos a la animación de cierre
		modal.classList.remove('animate__fadeInUp')
		modal.classList.add('animate__fadeOutDown')
		setTimeout(() => {
			// Ocultamos el modal
			modal.classList.remove('w3-show')
			modal.classList.add('w3-hide')
		}, 500)
		callback()
	}
}

/**
 * Define el comportamiento de un modal.<br>
 * &nbsp;<u>Requisitos</u>
 * <ul>
 *   <li>Para llamar a esta función a el botón o enlace debes agregarle el atributo `onclick="modal(this)"`.</li>
 *   <li>Define un atributo `data-target="selectorCSS"` al elemento modal, ya sea por `#id` o `.class`.</li>
 *   <li>Verifica que coincida el `selectorCSS` con el elemento del modal.</li>
 * </ul>
 * @param  {HTMLElement} boton El elemento que abre el modal al hacer click o touch.
 */
const modal = boton => {
	const selector = boton.getAttribute('data-target')
	const modal = document.querySelector(selector)
	mostrarModal(modal)
}

/**
 * Opaca el fondo y muestra el loader.
 * @param  {HTMLElement} modal Modal contenedor de algún elemento con `id='loader'`
 */
const mostrarLoader = modal => {
	const overlay = document.querySelector('[role="modalOverlay"]')
	overlay.classList.remove('w3-hide')
	overlay.classList.add('w3-show')
	modal.classList.add('showLoader')
}

/**
 * Quita el fondo opaco y el loader.
 * @param  {HTMLElement} modal    Modal contenedor de algún elemento con `id='loader'`
 */
const ocultarLoader = modal => {
	const overlay = document.querySelector('[role="modalOverlay"]')
	overlay.classList.remove('w3-show')
	overlay.classList.add('w3-hide')
	modal.classList.remove('showLoader')
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
 * Muestra un diálogo de confirmación.
 * @param  {string}   texto    Título de la ventana emergente.
 * @param  {Noty.Layout}   [posicion] Default: 'center'
 * @param  {(e: Event)} callback Función que se ejecuta al confirmar.
 * @return {Noty} Retorna un objeto Noty activado por defecto.
 */
const confirmar = (texto, posicion = 'center', callback = () => {}) => {
	let text = `
		<div class="w3-white w3-round-xlarge w3-padding w3-center w3-border" style="z-index: 1000">
			<div class="animate__animated animate__flip animate__infinite icon-question w3-xxxlarge"></div>
			<h2 class="w3-large w3-margin-bottom">
				<strong>${texto}</strong>
			</h2>
			<div class="w3-center w3-padding w3-margin-top">
				<button id="btnConfirmar" class="w3-button w3-round-xlarge w3-blue">Sí</button>
				<button id="cancelar" class="w3-button w3-round-xlarge w3-red">No</button>
			</div>
		</div>
	`
	
	return new Noty({
		id: 'confirmacion',
		theme: null,
		text,
		layout: posicion,
		modal: true,
		closeWith: ['button'],
		callbacks: {
			onShow: () => {
				$('#btnConfirmar').on('click', e => {
					$('#confirmacion .noty_close_button')[0].click()
					callback(e)
				})
				$('#cancelar').on('click', () => {
					$('#confirmacion .noty_close_button')[0].click()
				})
			}
		}
	}).show()
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

/** @param  {string} texto */
const notificacion = texto => {
	return new Noty({
		text: `<i class="icon-check w3-margin-right"></i> ${texto}`,
		type: 'success',
		timeout: 3000
	})
}

/** @param  {string} texto */
const advertencia = texto => {
	return new Noty({
		text: `<i class="icon-warning w3-margin-right"></i> ${texto}`,
		type: 'warning',
		timeout: 3000
	})
}

/**
 * @param  {string} texto
 */
const informacion = texto => {
	return new Noty({
		text: `<i class="w3-margin-right">!</i> ${texto}`,
		type: 'info',
		timeout: 3000
	})
}

/**
 * Actualiza una ayuda que vincula cada pregunta con su respectiva respuesta
 * @param  {HTMLFormElement} form El formulario que contiene a los inputs de preguntas y respuestas.
 */
const labelPreguntas = form => {
	form.pre1.addEventListener('keyup', () => {
		const legendRespuesta = form.querySelector(`sup[respuesta=${form.res1.id}]`)
		legendRespuesta.innerText = `(${form.pre1.value})`
	})

	form.pre2.addEventListener('keyup', () => {
		const legendRespuesta = form.querySelector(`sup[respuesta=${form.res2.id}]`)
		legendRespuesta.innerText = `(${form.pre2.value})`
	})

	form.pre3.addEventListener('keyup', () => {
		const legendRespuesta = form.querySelector(`sup[respuesta=${form.res3.id}]`)
		legendRespuesta.innerText = `(${form.pre3.value})`
	})
}

/**
 * Envia la petición al servidor para activar o desactivar un registro.
 * @param  {string} tabla  De qué tabla es el registro.
 * @param  {string} campo  El nombre del campo para identificar el registro.
 * @param  {number} valor  Valor único de cada registro.
 * @param  {string} accion Si quieres `activar` o `desactivar`.
 * @param  {string} hrefEnlace El HREF del enlace a clickear cuando se active o se desactive un registro.
 */
const activarDesactivar = (tabla, campo, valor, accion, hrefEnlace) => {
	const post = {
		tabla: tabla,
		campo: campo,
		valor: valor,
		accion: accion
	}
	return $.post('backend/activarDesactivar.php', post, res => {
		/** @type {Respuesta} */
		const respuesta = JSON.parse(res)
		
		if (respuesta.error) return alerta(respuesta.error).show()
		
		if (accion === 'activar')
			notificacion(respuesta.ok)
				.on('beforeShow', () => $(`[href="${hrefEnlace}"]`)[0].click())
				.show()
		else if (accion === 'desactivar')
			informacion(respuesta.ok)
				.on('beforeShow', () => $(`[href="${hrefEnlace}"]`)[0].click())
				.show()
	})
}

/**
 * Funcionalidad de activar un registro.
 * @param  {string} tabla De qué tabla es el registro.
 * @param  {string} campo Nombre del campo para identificar el registro.
 * @param  {number} valor Valor único de cada registro.
 * @param  {string} hrefEnlace El HREF del enlace a clickear al activar.
 */
const activar = (tabla, campo, valor, hrefEnlace) => {
	return activarDesactivar(tabla, campo, valor, 'activar', hrefEnlace)
}

/**
 * Funcionalidad de desactivar un registro.
 * @param  {string} tabla De qué tabla es el registro.
 * @param  {string} campo Nombre del campo para identificar el registro.
 * @param  {number} valor Valor único de cada registro.
 * @param  {string} hrefEnlace El HREF del enlace a clickear al activar.
 */
const desactivar = (tabla, campo, valor, hrefEnlace) => {
	return activarDesactivar(tabla, campo, valor, 'desactivar', hrefEnlace)
}

/**
 * Funcionalidad del módulo Usuarios
 * @param {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloUsuarios = contenedor => {
	/** @type {HTMLFormElement} */
	const formRegistrar = contenedor.querySelector('#registrarUsuario')
	acordeon()
	verClave(formRegistrar.clave.nextElementSibling, formRegistrar.clave)
	verClave(formRegistrar.confirmar.nextElementSibling, formRegistrar.confirmar)
	mostrarDetails(contenedor.querySelector('details'))
	
	validar(formRegistrar, (error, fd, e) => {
		if (error) return alerta(error).show()
			
		e.preventDefault()
		mostrarLoader(formRegistrar)
		fd.append('cargo', 'v')
		ajax('backend/registrarUsuario.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			
			if (datos.error)
				return alerta(datos.error)
					.on('onShow', () => formRegistrar.classList.remove('showLoader'))
					.show()
			
			ocultarLoader(formRegistrar)
			return notificacion('Usuario registrado correctamente')
				.on('onShow', () => $('[href="views/usuarios.php"]')[0].click())
				.show()
		})
	})
}

/**
 * Funcionalidad del módulo log.
 * @param  {HTMLElement} _contenedor Contenedor del módulo.
 */
const moduloLog = _contenedor => acordeon()

/**
 * Funcionalidad del módulo clientes.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloClientes = contenedor => {
	/** @type {HTMLFormElement} */
	const formRegistrar = contenedor.querySelector('#registrarCliente')
	acordeon()
	mostrarDetails(contenedor.querySelector('details'))
	validar(formRegistrar, (error, fd, e) => {
		if (error) return alerta(error).show()
			
		e.preventDefault()
		mostrarLoader(formRegistrar)
		ajax('backend/registrarCliente.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			
			if (datos.error)
				return alerta(datos.error)
					.on('onShow', () => ocultarLoader(formRegistrar))
					.show()
			
			ocultarLoader(formRegistrar)
			return notificacion(datos.ok)
				.on('onShow', () => $('[href="views/clientes.php"]')[0].click())
				.show()
		})
	})
}

/**
 * Funcionalidad del módulo proveedores.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloProveedores = contenedor => {
	const formRegistrar = contenedor.querySelector('#registrarProveedor')
	acordeon()
	mostrarDetails(contenedor.querySelector('details'))
	validar(formRegistrar, (error, fd, e) => {
		if (error) return alerta(error).show()
			
		e.preventDefault()
		mostrarLoader(formRegistrar)
		ajax('backend/registrarProveedor.php', fd, res => {
			console.log(res)
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			
			if (datos.error) return alerta(datos.error)
				.on('onShow', () => formRegistrar.classList.remove('showLoader'))
				.show()
			
			ocultarLoader(formRegistrar)
			return notificacion(datos.ok)
				.on('onShow', () => $('[href="views/proveedores.php"]')[0].click())
				.show()
		})
	})
}

/**
 * Funcionalidad del módulo perfil.
 * @param  {HTMLElement} contenedor El contenedor del módulo.
 */
const moduloPerfil = contenedor => {
	/** @type {HTMLFormElement} */
	const formFoto = contenedor.querySelector('[enctype="multipart/form-data"]')
	/** @type {HTMLButtonElement} */
	const boton = formFoto.querySelector('button')
	/** @type {HTMLImageElement} */
	const imagen = formFoto.foto.nextElementSibling
	
	$('#menuNombreUsuario').html($('#nombreUsuario').html())
	
	actualizarImagen(formFoto.foto, imagen, error => {
		if (error) return alerta(error).show()
			
		boton.classList.remove('w3-hide')
		boton.classList.add('w3-show-inline-block')
		
		formFoto.onsubmit = e => {
			e.preventDefault()
			const fd = new FormData(formFoto)
			fd.append('foto', formFoto.foto.files[0])
			w3.addClass('main', 'showLoader')
			ajax('backend/actualizarImagen.php', fd, res => {
				/** @type {Respuesta} */
				const respuesta = JSON.parse(res)
				
				if (respuesta.error) return alerta(respuesta.error)
					.on('onShow', () => w3.removeClass('main', 'showLoader'))
					.show()
				
				w3.removeClass('main', 'showLoader')
				boton.classList.remove('w3-show-inline-block')
				boton.classList.add('w3-hide')
				
				return notificacion(respuesta.ok)
					.on('onShow', () => {
						$('[href="views/miPerfil.php"]')[0].click()
						$('aside a img')[0].src = imagen.src
					})
					.show()
			})
		}
	})
}

/** Comportamiento de la navegación */
const navegacion = () => {
	$('a[role="navegacion"]').each((_i, enlace) => {
		enlace.addEventListener('click', e => {
			/** @type {HTMLAnchorElement} */
			const enlace = e.currentTarget
			e.preventDefault()
			main.classList.add('showLoader')
			
			if (document.body.offsetWidth < 993)
				$('[role="menuOverlay"]')[0].click()
			
			// Quitamos el resaltado azul a todos los enlaces.
			$('a').each((_i, enlace) => enlace.classList.remove('w3-blue'))
			
			// Si el enlace redirecciona a la nueva venta.
			if (enlace.href.includes('nuevaVenta.php'))
				$('a.w3-bar-item[href$="nuevaVenta.php"]').addClass('w3-blue')
			
			// Si el enlace redirecciona a la nueva venta.
			if (enlace.href.includes('nuevaCompra.php'))
				$('a.w3-bar-item[href$="nuevaCompra.php"]').addClass('w3-blue')
			
			// Si el enlace redirecciona a las ventas.
			if (enlace.href.includes('ventas.php'))
				$('a.w3-bar-item[href$="ventas.php"]').addClass('w3-blue')
			
			// Si el enlace redirecciona a las ventas.
			if (enlace.href.includes('compras.php'))
				$('a.w3-bar-item[href$="compras.php"]').addClass('w3-blue')
			
			// Si el enlace redirecciona al inventario.
			if (enlace.href.includes('inventario.php'))
				$('a.w3-bar-item[href$="inventario.php"]').addClass('w3-blue')
			
			// Si el enlace redirecciona a los usuarios.
			if (enlace.href.includes('usuarios.php'))
				$('a.w3-bar-item[href$="usuarios.php"]').addClass('w3-blue')
			
			// Si el enlace redirecciona a los clientes.
			if (enlace.href.includes('clientes.php'))
				$('a.w3-bar-item[href$="clientes.php"]').addClass('w3-blue')
			
			// Si el enlace redirecciona a la página principal.
			if (enlace.href.includes('dashboard.php'))
				// Espera unos segundos para simular :D
				return setTimeout(() => {
					// Pinta el enlace de azul sólo si está en el menú lateral.
					if (enlace.classList.contains('w3-bar-item'))
						enlace.classList.add('w3-blue')
					/*En caso que se haga click en el nombre del negocio, colorea
					el enlace en el menú lateral.*/
					$('a.w3-bar-item[href="dashboard.php"]').addClass('w3-blue')
					
					// Reinicia los acordeones del menú lateral.
					$('nav summary').each((_i, summary) => {
						summary.classList.remove('w3-blue')
						summary.parentElement.classList.remove('abierto')
					})
					
					// Oculta el menú sólo en móviles.
					if (document.body.scrollWidth <= 600) overlay.click()
						
					// Oculta el loader.
					main.classList.remove('showLoader')
					// Carga la el Panel Principal.
					main.innerHTML = dashboardHTML
					// Reajusta la navegación del Panel Principal.
					navegacion()
				}, 500)
			
			// Si no es un enlace al Panel Principal, solicita la vista
			$.get(enlace.getAttribute('href'), res => {
				// Sólo pinta los enlaces del menú.
				if (!enlace.href.includes('miPerfil.php'))
					enlace.classList.add('w3-blue')
				
				// Si el enlace está dentro de un acordeón
				if (enlace.href.includes('usuarios.php')
					|| enlace.href.includes('log.php')
					|| enlace.href.includes('compras.php')
					|| enlace.href.includes('nuevaCompra.php')
				) {
					// Cierra todos los acordeones
					$('nav summary').each((_i, summary) => {
						summary.classList.remove('w3-blue')
						if (summary.parentElement)
							summary.parentElement.classList.remove('abierto')
					})
					
					// Pinta el acordeón del enlace.
					if (enlace.parentElement.previousElementSibling
						&& enlace.parentElement.parentElement
					) {
						enlace.parentElement.previousElementSibling.classList.add('w3-blue')
						enlace.parentElement.parentElement.classList.add('abierto')
					}
				} else $('nav summary').each((_i, summary) => {
					// Si el enlace no está dentro de un acordeón, reinicia los acordeones.
					summary.classList.remove('w3-blue')
					summary.parentElement.classList.remove('abierto')
				})
				
				// Cierra el menú sólo en móvil.
				if (document.body.scrollWidth <= 600) overlay.click()
				// Quita el loader
				main.classList.remove('showLoader')
				// Carga la vista
				main.innerHTML = res
				
				// Funcionalidades de la vista cargada.
				if ($('#moduloUsuarios')[0]) moduloUsuarios($('#moduloUsuarios')[0])			
				if ($('#moduloLog')[0]) moduloLog($('#moduloLog')[0])			
				if ($('#moduloClientes')[0]) moduloClientes($('#moduloClientes')[0])			
				if ($('#moduloProveedores')[0]) moduloProveedores($('#moduloProveedores')[0])			
				if ($('#moduloPerfil')[0]) moduloPerfil($('#moduloPerfil')[0])			
			})
		})
	})
	
	$('details').each((_i, details) => mostrarDetails(details))
}

const vaciarLog = () => {
	return confirmar('¿Seguro que desea vaciar el registro?', 'center', () => {
		w3.addClass('main', 'showLoader')
		return $.post('backend/vaciarLog.php', { vaciar: true }, res => {
			w3.removeClass('main', 'showLoader')
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
			
			return notificacion(respuesta.ok)
				.on('onShow', () => $('nav [href="views/log.php"]')[0].click())
				.show()
		})
	})
}

const cerrarSesion = () => {
	return confirmar('¿Seguro que desea cerrar sesión?', 'center', () => {
		w3.addClass('main', 'showLoader')
		const url = location.href.split('/')
		url[url.length - 1] = 'salir.php'
		location.href = url.join('/')
	})
}

/**
 * Funcionalidad de editar registros.
 * @param  {HTMLElement} boton  El botón del registro que quieres editar.
 * @param  {string} tabla  La tabla a la cual pertenecen los registros.
 * @param  {string} campo  El nombre del campo que identifica cada registro.
 * @param  {number} valor  Un valor único por cada registro.
 * @param  {string} hrefEnlace El HREF del enlace al clickear tras editar.
 */
const editar = (boton, tabla, campo, valor, hrefEnlace = '') => {
	const url = 'backend/editar.php'
	const datos = {
		editar: true,
		tabla: tabla,
		campo: campo,
		valor: valor
	}
	$.post(url, datos, res => {
		const respuesta = JSON.parse(res)
		
		if (respuesta.error) return alerta(respuesta.error).show()
		
		/** @type {HTMLFormElement} */
		const form = document.querySelector(boton.getAttribute('data-target'))
		form.innerHTML = respuesta.ok
		modal(boton)
		
		if (tabla === 'usuarios:preguntasRespuestas') {
			labelPreguntas(form)
			verClave(form.res1.nextElementSibling, form.res1)
			verClave(form.res2.nextElementSibling, form.res2)
			verClave(form.res3.nextElementSibling, form.res3)
		}
		
		if (tabla === 'usuarios:clave') {
			verClave(form.clave.nextElementSibling, form.clave)
			verClave(form.confirmar.nextElementSibling, form.confirmar)
		}
		
		validar(form, (error, fd, e) => {
			if (error) return alerta(error).show()
			
			e.preventDefault()
			fd.append('tabla', tabla)
			mostrarLoader(form)
			ajax(url, fd, res => {
				console.log(res)
				const respuesta = JSON.parse(res)
				
				if (respuesta.error) return alerta(respuesta.error)
					.on('onShow', () => form.classList.remove('showLoader'))
					.show()
				
				return notificacion(respuesta.ok)
					.on('onShow', () => {
						ocultarLoader(form)
						if (hrefEnlace)
							$(`a[href="${hrefEnlace}"]`)[0].click()
					})
					.show()
			})
		})
	})
}

/**
 * Comportamiento de cambiar los páneles.
 * @param  {HTMLElement} boton El botón clickeado.
 * @param  {string} id    El ID del panel a mostrar (incluido el #).
 */
const mostrarPanel = (boton, id) => {
	/** @type {HTMLDivElement} */
	const panel = $(id)[0]
	$('[role="botonPanel"]').each((_i, boton) => boton.classList.remove('w3-blue'))
	boton.classList.add('w3-blue')
	$('[role="panel"]').each((_i, panel) => {
		panel.classList.remove('w3-show')
		panel.classList.add('w3-hide')
	})
	
	panel.classList.remove('w3-hide')
	panel.classList.add('w3-show')
}

onoffline = () => advertencia('Se ha perdido la conexión').show()
ononline = () => notificacion('Se ha restablecido la conexión').show()

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