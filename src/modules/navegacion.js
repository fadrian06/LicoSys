/** @typedef {import('./funciones')} */

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
	acordeon()
	mostrarDetails(contenedor.querySelector('details'))
	registrarCliente(contenedor.querySelector('#registrarCliente'), 'views/clientes.php')
}

/**
 * Funcionalidad del módulo proveedores.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloProveedores = contenedor => {
	const formRegistrar = contenedor.querySelector('#registrarProveedor')
	acordeon()
	mostrarDetails(contenedor.querySelector('details'))
	registrarProveedor(formRegistrar, 'views/proveedores.php')
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

/** 
 * Funcionalidad del módulo negocios.
 * @param  {HTMLElement} contenedor El contenedor del módulo.
 */
const moduloNegocios = contenedor => {
	/*============================================
	=            Registro de negocios            =
	============================================*/
	/** @type {HTMLFormElement} */
	const formRegistrar = contenedor.querySelector('#registrarNegocio')
	/** @type {HTMLInputElement} */
	const inputFile = formRegistrar.logo
	/** @type {HTMLImageElement} */
	const imagen = inputFile.nextElementSibling
	acordeon()
	mostrarDetails(contenedor.querySelector('details'))
	actualizarImagen(inputFile, imagen, error => {
		if (error) return alerta(error).show()
	})
	validar(formRegistrar, (error, fd, e) => {
		if (error) return alerta(error).show()
			
		e.preventDefault()
		mostrarLoader(formRegistrar)
		fd.append('logo', formRegistrar.logo.files[0])
		ajax('backend/registrarNegocio.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			
			if (datos.error) return alerta(datos.error)
				.on('onShow', () => formRegistrar.classList.remove('showLoader'))
				.show()
			
			ocultarLoader(formRegistrar)
			return notificacion(datos.ok)
				.on('onShow', () => $('[href="views/negocios.php"]')[0].click())
				.show()
		})
	})
	
	/*=================================================
	=            Actualización de imagenes            =
	=================================================*/
	$('#menuNombreNegocio').html($('#nombreNegocioActivo').html())
	$('[enctype="multipart/form-data"]').each((_i, form) => {
		/** @type {HTMLFormElement} */
		const formFoto = form
		/** @type {HTMLInputElement} */
		const inputFile = formFoto.querySelector('input[type="file"]')
		/** @type {HTMLButtonElement} */
		const boton = formFoto.querySelector('button')
		/** @type {HTMLImageElement} */
		const imagen = inputFile.nextElementSibling
		
		actualizarImagen(inputFile, imagen, error => {
			if (error) return alerta(error).show()
			
			boton.classList.remove('w3-hide')
			boton.classList.add('w3-show-inline-block')
			
			formFoto.onsubmit = e => {
				e.preventDefault()
				const fd = new FormData(formFoto)
				fd.append('logo', inputFile.files[0])
				w3.addClass('main', 'showLoader')
				ajax('backend/actualizarImagen.php', fd, res => {
					console.log(res)
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
							$('[href="views/negocios.php"]')[0].click()
							$('header a img')[0].src = imagen.src
						})
						.show()
				})
			}
		})
	})
}

/**
 * Funcionalidad del módulo finanzas
 * @param  {HTMLElement} _contenedor Contenedor del módulo
 */
const moduloFinanzas = contenedor => {
	/*===========================================
	=            Botones de negocios            =
	===========================================*/
	const botones = $('[role="botonPanel"]')
	const paneles = $('[role="panel"]')
	botones.each((_i, boton) => {
		boton.onclick = () => {
			botones.each((_i, boton) => {
				boton.classList.remove('w3-blue')
				boton.classList.add('w3-white')
			})
			paneles.each((_i, panel) => {
				panel.classList.remove('w3-show-inline-block')
				panel.classList.add('w3-hide')
			})
			
			/** @type {HTMLDivElement} */
			const panelObjetivo = $(boton.getAttribute('data-target'))[0]
			panelObjetivo.classList.remove('w3-hide')
			panelObjetivo.classList.add('w3-show-inline-block')
			boton.classList.remove('w3-white')
			boton.classList.add('w3-blue')
		}
	})
	
	/*===============================
	=            FILTROS            =
	===============================*/
	/** @type {HTMLTableElement} */
	const tabla = contenedor.querySelector('table')
	const contenedorGanancia = tabla.nextElementSibling
	$('input[type="radio"]').on('click', e => {
		tabla.classList.add('w3-disabled')
		contenedorGanancia.classList.add('w3-disabled')
		/** @type {number} */
		const negocioID = e.target.getAttribute('negocio-id')
		/** @type {string} */
		let rol = e.target.id
		if (rol.includes('diario'))
			rol = 'diario'
		else if (rol.includes('semanal'))
			rol = 'semanal'
		else if (rol.includes('quincenal'))
			rol = 'quincenal'
		else if (rol.includes('mensual'))
			rol = 'mensual'
		
		$.get(`views/finanzas.php?negocioID=${negocioID}&rol=${rol}`, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			tabla.innerHTML = `
				<tr class="w3-blue">
					<th class="tooltip-container">
						UC
						<b class="tooltip w3-block w3-padding-small w3-card-4 w3-white" style="bottom: -90%">
							Unidades compradas
						</b>
					</th>
					<th class="tooltip-container">
						UV
						<b class="tooltip w3-block w3-padding-small w3-card-4 w3-white" style="bottom: -90%">
							Unidades vendidas
						</b>
					</th>
					<th>Producto</th>
					<th class="w3-red">Gastos</th>
					<th class="w3-green">Ingresos</th>
				</tr>
				${respuesta.ok}
				<tr class="w3-blue">
					<td colspan="3">TOTAL:</td>
					<td class="w3-red">${respuesta.datos.gastos}</td>
					<td class="w3-green">${respuesta.datos.ingresos}</td>
				</tr>
			`
			tabla.classList.remove('w3-disabled')
			contenedorGanancia.innerHTML = `
				<div class="w3-animate-opacity">
					${respuesta.datos.ganancia}
				</div>
			`
			contenedorGanancia.classList.remove('w3-disabled')
		})
	})
}

/**
 * Funcionalidad del módulo inventario
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloInventario = contenedor => {
	acordeon()
	mostrarDetails(contenedor.querySelector('details'))
	registrarProducto(contenedor.querySelector('#registrarProducto'), 'views/inventario.php')
}

/**
 * Funcionalidad del módulo ventas.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloVentas = _contenedor => {
	acordeon()
	$('#botones a').on('click', e => {
		e.preventDefault()
		document.querySelector('[href="views/nuevaVenta.php"]').click()
	})
}

/**
 * Funcionalidad del módulo compras.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloCompras = _contenedor => {
	acordeon()
	$('#botones a').on('click', e => {
		e.preventDefault()
		document.querySelector('[href="views/nuevaCompra.php"]').click()
	})
}

/**
 * Funcionalidad del módulo Nueva Venta.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloNuevaVenta = contenedor => {
	const formMonedas = contenedor.querySelector('#actualizarMonedas')
	registrarProducto(contenedor.querySelector('#registrarProducto'), 'views/nuevaVenta.php')
	registrarCliente(contenedor.querySelector('#registrarCliente'), 'views/nuevaVenta.php')
	if (formMonedas) actualizarMonedas(formMonedas)
	
	$('#productosEnCarrito').html($('#cantidadProductosEnCarrito').html())
	
	/*----------  SELECCIONAR CLIENTE  ----------*/
	/** @type {HTMLUListElement} */
	const datosCliente = contenedor.querySelector('#datosCliente')
	
	$('[cliente-id]').on('click', e => {
		/** @type {number} */
		const id = e.currentTarget.getAttribute('cliente-id')
		$.get(`backend/nuevaVenta.php?clienteID=${id}`, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			datosCliente.classList.remove('w3-hide');
			datosCliente.innerHTML = `
				<li>
					<span class="w3-tag w3-blue w3-left">Cédula:</span>
					<b class="w3-right">v-${respuesta.datos.cedula}</b>
					<div class="w3-clear"></div>
				</li>
				<li>
					<span class="w3-tag w3-blue w3-left">Nombre:</span>
					<b class="w3-right">${respuesta.datos.nombre}</b>
					<div class="w3-clear"></div>
				</li>
			`
		})
	})
	
	/*----------  OMITIR CLIENTE  ----------*/
	$('[role="omitirCliente"]').on('click', () => {
		$('[cliente-id="3"]')[0].click()
		w3.hide('#seccionCliente')
	})
	
	/*----------  SELECCIONAR PRODUCTO  ----------*/
	/** @type {HTMLFormElement} */
	const datosProducto = contenedor.querySelector('#datosProducto')
	
	$('[producto-id]').on('click', e => {
		/** @type {number} */
		const id = e.currentTarget.getAttribute('producto-id')
		$.get(`backend/nuevaVenta.php?productoID=${id}`, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			datosProducto.classList.remove('w3-hide');
			const stock = respuesta.datos.stock > 0
				? `<span class="w3-input w3-padding w3-left-align w3-light-grey">${respuesta.datos.stock}</span>`
				: `<span class="w3-input w3-padding w3-red">Agotado</span>`
			datosProducto.innerHTML = `
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Producto:</div>
					<div class="w3-col s8">
						<input class="w3-input w3-padding w3-light-grey w3-text-black" disabled value="${respuesta.datos.producto}">
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Código:</div>
					<div class="w3-col s8">
						<input class="w3-input w3-padding w3-light-grey w3-text-black" disabled value="${respuesta.datos.codigo}">
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Existencia:</div>
					<div class="w3-col s8">
						${stock}
						<input type="hidden" disabled value="${respuesta.datos.stock}">
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Precio (<i class="icon-dollar"></i>):</div>
					<div class="w3-col s8 w3-dropdown-hover w3-transparent">
						<input name="precio" class="w3-input w3-padding w3-light-grey w3-text-black" disabled value="${respuesta.datos.precio}">
						<div class="w3-dropdown-content w3-padding-small w3-card-4 w3-white">
							<b>Bs. ${(respuesta.datos.precio * respuesta.datos.dolar).toFixed(2)}<br>
							${(respuesta.datos.precio * respuesta.datos.peso).toFixed(0)} pesos</b>
						</div>
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Cantidad:</div>
					<div class="w3-col s8">
						<input type="number" name="cantidad" onchange="actualizarTotal(this, ${respuesta.datos.excento}, '#total')" onkeyup="actualizarTotal(this, ${respuesta.datos.excento}, '#total')" placeholder="Introduce la cantidad" required min="0" max="${respuesta.datos.stock}" class="w3-input w3-padding">
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Total (<i class="icon-dollar"></i>):</div>
					<div class="w3-col s8 w3-dropdown-hover">
						<span id="total" class="w3-left-align w3-input w3-padding w3-light-grey w3-text-black" disabled>
							<i class="w3-opacity-min">&nbsp;</i>
						</span>
					</div>
				</section>
				<div class="w3-center">
					<input type="hidden" name="productoID" value="${respuesta.datos.id}">
					<input type="hidden" name="iva" value="${respuesta.datos.iva}">
					<input type="hidden" name="dolar" value="${respuesta.datos.dolar}">
					<input type="hidden" name="peso" value="${respuesta.datos.peso}">
					<button class="w3-margin-top w3-medium w3-button w3-blue w3-round-xlarge w3-hide w3-animate-bottom">
						<span class="icon-plus"></span>
						Añadir Producto
					</button>
				</div>
			`
		})
	})
	
	/*----------  AGREGAR PRODUCTO  ----------*/
	datosProducto.onsubmit = e => {
		e.preventDefault()
		const datos = {
			cantidad: datosProducto.cantidad.value,
			productoID: datosProducto.productoID.value,
			addProduct: true
		}
		$.post('backend/nuevaVenta.php', datos, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
			
			return notificacion(respuesta.ok)
				.on('onShow', () => $('[href="views/nuevaVenta.php"]')[0].click())
				.on('afterClose', () => contenedor.scrollTo(contenedor.scrollHeight))
				.show()
		})
	}
	
	/** @type {HTMLFormElement} */
	const carrito = contenedor.querySelector('#carritoVenta')
	if (!carrito) return
	
	carrito.onsubmit = e => e.preventDefault()
	
	/*----------  ELIMINAR PRODUCTO  ----------*/
	$('[role="eliminarProducto"]').on('click', e => {
		e.preventDefault()
		const datos = {
			productoID: e.target.getAttribute('productoid'),
			eliminar: true
		}
		$.post('backend/nuevaVenta.php', datos, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
			
			return notificacion(respuesta.ok)
				.on('onShow', () => $('[href="views/nuevaVenta.php"]')[0].click())
				.on('afterClose', () => contenedor.scrollTo(contenedor.scrollHeight))
				.show()
		})
	})
			
	/*----------  ANULAR VENTA  ----------*/
	$('[role="anularVenta"]').on('click', () => {
		$.post('backend/nuevaVenta.php', { anular: true }, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
				
			return informacion(respuesta.ok)
				.on('onShow', () => $('[href="views/nuevaVenta.php"]')[0].click())
				.show()
		})
	})
	
	/*----------  GENERAR VENTA  ----------*/
	$('[role="generarVenta"]').on('click', () => {
		$.post('backend/nuevaVenta.php', { generar: true }, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
				
			return notificacion(respuesta.ok)
				.on('onShow', () => $('[href="views/nuevaVenta.php"]')[0].click())
				.show()
		})
	})
}

/**
 * Funcionalidad del módulo Nueva Compra.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
const moduloNuevaCompra = contenedor => {
	const formMonedas = contenedor.querySelector('#actualizarMonedas')
	registrarProducto(contenedor.querySelector('#registrarProducto'), 'views/nuevaVenta.php')
	registrarProveedor(contenedor.querySelector('#registrarProveedor'), 'views/nuevaCompra.php')
	if (formMonedas) actualizarMonedas(formMonedas)
	
	$('#productosEnCarritoCompra').html($('#cantidadProductosEnCarrito').html())
	
	/*----------  SELECCIONAR PROVEEDOR  ----------*/
	/** @type {HTMLUListElement} */
	const datosProveedor = contenedor.querySelector('#datosProveedor')
	
	$('[proveedor-id]').on('click', e => {
		/** @type {number} */
		const id = e.currentTarget.getAttribute('proveedor-id')
		$.get(`backend/nuevaCompra.php?proveedorID=${id}`, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			datosProveedor.classList.remove('w3-hide');
			datosProveedor.innerHTML = `
				<li>
					<span class="w3-tag w3-blue w3-left">RIF:</span>
					<b class="w3-right">${respuesta.datos.rif}</b>
					<div class="w3-clear"></div>
				</li>
				<li>
					<span class="w3-tag w3-blue w3-left">Nombre:</span>
					<b class="w3-right">${respuesta.datos.nombre}</b>
					<div class="w3-clear"></div>
				</li>
			`
		})
	})
	
	/*----------  SELECCIONAR PRODUCTO  ----------*/
	/** @type {HTMLFormElement} */
	const datosProducto = contenedor.querySelector('#datosProducto')
	
	$('[producto-id]').on('click', e => {
		/** @type {number} */
		const id = e.currentTarget.getAttribute('producto-id')
		$.get(`backend/nuevaCompra.php?productoID=${id}`, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			datosProducto.classList.remove('w3-hide');
			const stock = respuesta.datos.stock > 0
				? `<span class="w3-input w3-padding w3-left-align w3-light-grey">${respuesta.datos.stock}</span>`
				: `<span class="w3-input w3-padding w3-red">Agotado</span>`
			datosProducto.innerHTML = `
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Producto:</div>
					<div class="w3-col s8">
						<input class="w3-input w3-padding w3-light-grey w3-text-black" disabled value="${respuesta.datos.producto}">
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Código:</div>
					<div class="w3-col s8">
						<input class="w3-input w3-padding w3-light-grey w3-text-black" disabled value="${respuesta.datos.codigo}">
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Existencia:</div>
					<div class="w3-col s8">
						${stock}
						<input type="hidden" disabled value="${respuesta.datos.stock}">
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Precio (<i class="icon-dollar"></i>):</div>
					<div class="w3-col s8 w3-dropdown-hover">
						<input type="number" step="0.01" name="precio" onchange="actualizarPrecio(this)" onkeyup="actualizarPrecio(this)" class="w3-input w3-padding" value="${respuesta.datos.precio}">
						<div class="w3-dropdown-content w3-padding-small w3-card-4 w3-white w3-left-align">
							<b>Bs. ${(respuesta.datos.precio * respuesta.datos.dolar).toFixed(2)}<br>
							${(respuesta.datos.precio * respuesta.datos.peso).toFixed(0)} pesos</b>
						</div>
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Cantidad:</div>
					<div class="w3-col s8">
						<input type="number" name="cantidad" onchange="actualizarTotal(this, 0, '#total')" onkeyup="actualizarTotal(this, 0, '#total')" placeholder="Introduce la cantidad" required min="0" class="w3-input w3-padding">
					</div>
				</section>
				<section class="w3-row">
					<div class="w3-input w3-col s4 w3-blue">Total (<i class="icon-dollar"></i>):</div>
					<div class="w3-col s8 w3-dropdown-hover">
						<span id="total" class="w3-left-align w3-input w3-padding w3-light-grey w3-text-black" disabled>
							<i class="w3-opacity-min">&nbsp;</i>
						</span>
					</div>
				</section>
				<div class="w3-center">
					<input type="hidden" name="productoID" value="${respuesta.datos.id}">
					<input type="hidden" name="iva" value="${respuesta.datos.iva}">
					<input type="hidden" name="dolar" value="${respuesta.datos.dolar}">
					<input type="hidden" name="peso" value="${respuesta.datos.peso}">
					<button class="w3-margin-top w3-medium w3-button w3-blue w3-round-xlarge w3-hide w3-animate-bottom">
						<span class="icon-plus"></span>
						Añadir Producto
					</button>
				</div>
			`
		})
	})
	
	/*----------  AGREGAR PRODUCTO  ----------*/
	datosProducto.onsubmit = e => {
		e.preventDefault()
		const datos = {
			precio: datosProducto.precio.value,
			cantidad: datosProducto.cantidad.value,
			productoID: datosProducto.productoID.value,
			addProduct: true
		}
		$.post('backend/nuevaCompra.php', datos, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
			
			return notificacion(respuesta.ok)
				.on('onShow', () => $('[href="views/nuevaCompra.php"]')[0].click())
				.on('afterClose', () => contenedor.scrollTo(contenedor.scrollHeight))
				.show()
		})
	}
	
	/** @type {HTMLFormElement} */
	const carrito = contenedor.querySelector('#carritoCompra')
	if (!carrito) return
	
	carrito.onsubmit = e => e.preventDefault()
	
	/*----------  ELIMINAR PRODUCTO  ----------*/
	$('[role="eliminarProducto"]').on('click', e => {
		e.preventDefault()
		const datos = {
			productoID: e.target.getAttribute('productoid'),
			eliminar: true
		}
		$.post('backend/nuevaCompra.php', datos, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
			
			return notificacion(respuesta.ok)
				.on('onShow', () => $('[href="views/nuevaCompra.php"]')[0].click())
				.on('afterClose', () => contenedor.scrollTo(contenedor.scrollHeight))
				.show()
		})
	})
			
	/*----------  ANULAR COMPRA  ----------*/
	$('[role="anularCompra"]').on('click', () => {
		$.post('backend/nuevaCompra.php', { anular: true }, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
				
			return informacion(respuesta.ok)
				.on('onShow', () => $('[href="views/nuevaCompra.php"]')[0].click())
				.show()
		})
	})
	
	/*----------  GENERAR COMPRA  ----------*/
	$('[role="generarCompra"]').on('click', () => {
		$.post('backend/nuevaCompra.php', { generar: true }, res => {
			/** @type {Respuesta} */
			const respuesta = JSON.parse(res)
			
			if (respuesta.error) return alerta(respuesta.error).show()
				
			return notificacion(respuesta.ok)
				.on('onShow', () => $('[href="views/nuevaCompra.php"]')[0].click())
				.show()
		})
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
					
					// Recargamos el gráfico
					if (document.querySelector('#productosMasVendidos'))
						new Chart('productosMasVendidos', {
							type: 'bar',
							data: {
								labels: xValues,
								datasets: [{
									backgroundColor: barColors,
									data: yValues
								}]
							},
							options: {
								legend: {display: false},
								scales: {
									y: {
										beginAtZero: true
									}
								}
							}
						})
					
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
				if ($('#moduloNegocios')[0]) moduloNegocios($('#moduloNegocios')[0])
				if ($('#moduloFinanzas')[0]) moduloFinanzas($('#moduloFinanzas')[0])
				if ($('#moduloInventario')[0]) moduloInventario($('#moduloInventario')[0])
				if ($('#moduloVentas')[0]) moduloVentas($('#moduloVentas')[0])
				if ($('#moduloCompras')[0]) moduloCompras($('#moduloCompras')[0])
				if ($('#moduloNuevaCompra')[0]) moduloNuevaCompra($('#moduloNuevaCompra')[0])
				if ($('#moduloNuevaVenta')[0]) moduloNuevaVenta($('#moduloNuevaVenta')[0])
			})
		})
	})
	
	$('details').each((_i, details) => mostrarDetails(details))
}