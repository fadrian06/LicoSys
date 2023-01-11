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
		text: `<strong><i class="icon-close w3-margin-right"></i> ${texto}</strong>`,
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
		text: `<strong class="w3-text-black"><i class="icon-warning w3-margin-right"></i> ${texto}</strong>`,
		type: 'warning',
		timeout: 3000,
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

const respaldarBD = () => {
	return confirmar('¿Desea crear una copia de seguridad de todos los datos?', 'center', () => {
		w3.addClass('main', 'showLoader')
		$.post('backend/backupBD.php', { respaldar: true }, res => {
			w3.removeClass('main', 'showLoader')
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			if (respuesta.error) return alerta(respuesta.error).show()
			
			return notificacion(respuesta.ok).show()
		})
	})
}

const restaurarBD = () => {
	let texto = `
		Tener en cuenta que al restaurar se perderán cambios 
		que no hayan sido respaldados<br>
		<strong class="w3-text-red">¿Desea continuar?</strong>
	`
	return confirmar(texto, 'center', () => {
		w3.addClass('main', 'showLoader')
		$.post('backend/backupBD.php', { restaurar: true }, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error)
				.on('onShow', () => w3.removeClass('main', 'showLoader'))
				.show()
			
			let html = `
				<div class="w3-card w3-round-xlarge w3-white w3-padding-large w3-center">
					<h1 class="w3-xlarge oswald">${respuesta.ok}</h1>
					<h2 class="w3-large w3-padding-top-24 w3-topbar">
						Reiniciando el Sistema...
					</h2>	
				</div>
			`
			new Noty({
				theme: null,
				id: 'intro',
				type: 'info',
				text: html,
				layout: 'center',
				modal: true,
				closeWith: [null],
				animation: { open: 'w3-animate-zoom' },
				timeout: 5000,
				callbacks: { afterClose: () => location.reload() }
			}).show()
		})
	})
}

/**
 * Filtra elementos en una lista.
 * @param  {HTMLInputElement} input Entrada de texto.
 * @param  {string} contenedorID   ID del contenedor de la lista
 */
const filter = (input, contenedorID) => {
	const contenedor = document.querySelector(`#${contenedorID}`)
	/** @type {string} Texto a buscar en mayúsculas */
	let texto = input.value.toUpperCase();
	const elementos = contenedor.querySelectorAll('button')
	for (let i = 0; i < elementos.length; ++i) {
		/** @type {string} Texto del elemento */
		let txtValue = elementos[i].textContent || elementos[i].innerText;
		if (txtValue.toUpperCase().indexOf(texto) > -1)
			elementos[i].style.display = '';
		else elementos[i].style.display = 'none';
	}
}

/**
 * Funcionalidad del formulario para registrar productos.
 * @param  {HTMLFormElement} formulario El formulario de registro.
 * @param  {string} enlace     El HREF del enlace a clickear terminado el registro.
 */
const registrarProducto = (formulario, enlace) => {
	validar(formulario, (error, fd, e) => {
		if (error) return alerta(error).show()
		
		e.preventDefault()
		mostrarLoader(formulario)
		ajax('backend/registrarProducto.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			
			if (datos.error)
				return alerta(datos.error)
					.on('onShow', () => ocultarLoader(formulario))
					.show()
			
			ocultarLoader(formulario)
			return notificacion(datos.ok)
				.on('onShow', () => $(`[href="${enlace}"]`)[0].click())
				.show()
		})
	})
}

/**
 * Funcionalidad del formulario para registrar clientes.
 * @param  {HTMLFormElement} formulario El formulario de registro.
 * @param  {string} enlace     El HREF del enlace a clickear terminado el registro.
 */
const registrarCliente = (formulario, enlace) => {
	validar(formulario, (error, fd, e) => {
		if (error) return alerta(error).show()
			
		e.preventDefault()
		mostrarLoader(formulario)
		ajax('backend/registrarCliente.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			
			if (datos.error)
				return alerta(datos.error)
					.on('onShow', () => ocultarLoader(formulario))
					.show()
			
			ocultarLoader(formulario)
			return notificacion(datos.ok)
				.on('onShow', () => $(`[href="${enlace}"]`)[0].click())
				.show()
		})
	})
}

/**
 * Funcionalidad de actualizar el valor de las monedas.
 * @param  {HTMLFormElement} formulario El formulario de actualización.
 */
const actualizarMonedas = formulario => {
	validar(formulario, (error, fd, e) => {
		if (error) return alerta(error).show()
		
		e.preventDefault()
		formulario.classList.add('showLoader')
		ajax('backend/actualizarMonedas.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			if (datos.error)
				return alerta(datos.error)
					.on('onClose', () => formulario.classList.remove('showLoader'))
					.show()
			
			$('#tablaMonedas').html(`
				<tr>
					<td>IVA</td>
					<td colspan="2"><b>${formulario.iva.value}%</b></td>
				</tr>
				<tr>
					<td>DÓLAR</td>
					<td>
						<b><i>Bs. </i>${formulario.dolar.value}</b>
					</td>
					<td><b>${formulario.pesos.value}<i> Pesos</i></b></td>
				</tr>	
			`)
			formulario.classList.remove('showLoader')
			
			return notificacion('Valores actualizados correctamente.')
				.on('onShow', () => {
					formulario.querySelector('.icon-close').click()
				})
				.show()
		})
	})
}

/**
 * Actualiza dinámicamente el total de un producto.
 * @param  {HTMLInputElement} cantidad   Un elemento `<input>` con `name="cantidad`
 * @param  {number} excento Representa si el producto es o no es excento de IVA.
 * @param  {string} inputTotalID ID del `<input>` en dónde mostrar el total.
 * @param {()} cb Funcionalidad adicional tras actualizar el total.
 */
const actualizarTotal = (cantidad, excento, inputTotalID) => {
	/** @type {number} El precio del producto */
	const precio = cantidad.form.querySelector('[name="precio"]').value
	/** @type {number} El IVA actual */
	const iva = cantidad.form.querySelector('[name="iva"]').value
	/** @type {HTMLInputElement} */
	const total = cantidad.form.querySelector(inputTotalID)
	total.value = precio * cantidad.value
	
	if (excento) {
		let totalIVA = total.value * iva
		total.value = Number(total.value) + totalIVA
	}
	
	if (cantidad.value != 0)
		cantidad.form.querySelector('button').classList.remove('w3-hide')
}

onoffline = () => advertencia('Se ha perdido la conexión').show()
ononline = () => notificacion('Se ha restablecido la conexión').show()