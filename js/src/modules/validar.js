import {alerta} from './alertas'

/**
 * CONVIERTE CADA INICIAL EN MAYÚSCULA
 * @param  {String} string El string a capitalizar
 * @return {String}        El string capitalizado
 */
const mayuscula = string => {
	let expresion = /(^[\wáÁéÉíÍóÓúÚñÑ]{1})|(\s+[\wáÁéÉíÍóÓúÚñÑ]{1})/g
	let mayuscula = string.replace(expresion, letra => letra.toUpperCase())
	return mayuscula
}

/**
 * MUESTRA QUE LA VALIDACIÓN RECHAZÓ LA ENTRADA
 * @param  {HTMLElement} input El input a colorear
 */
const error = input => {
	if (input.type === 'text'
		|| input.type === 'password'
		|| input.type === 'number'
		|| input.type === 'tel'
	) {
		const contenedorInput = input.parentElement.parentElement
		const iconoLabel = input.parentElement.previousElementSibling
		const iconoCheck = contenedorInput.querySelector('.icon-check')
		const iconoX = contenedorInput.querySelector('.icon-close')
		const ojo = contenedorInput.querySelector('.icon-eye, .icon-eye-slash')
		
		if (!ojo) iconoX.classList.replace('w3-hide', 'w3-show')

		contenedorInput.classList.add('w3-border-red')
		iconoLabel.classList.replace('w3-teal', 'w3-red')
		iconoCheck.classList.replace('w3-show', 'w3-hide')
	}
}

/**
 * MUESTRA QUE LA VALIDACIÓN ACEPTÓ LA ENTRADA
 * @param  {HTMLElement} input El input a colorear
 */
const correcto = input => {
	if (input.type === 'text'
		|| input.type === 'password'
		|| input.type === 'number'
		|| input.type === 'tel'
	) {
		const contenedorInput = input.parentElement.parentElement
		const iconoLabel = input.parentElement.previousElementSibling
		const iconoCheck = contenedorInput.querySelector('.icon-check')
		const iconoX = contenedorInput.querySelector('.icon-close')
		const ojo = contenedorInput.querySelector('.icon-eye, .icon-eye-slash')
		
		if (ojo) ojo.classList.add('w3-hide')
		else iconoCheck.classList.replace('w3-hide', 'w3-show')

		contenedorInput.classList.remove('w3-border-red')
		iconoLabel.classList.replace('w3-red', 'w3-teal')
		iconoX.classList.replace('w3-show', 'w3-hide')
	}
}

/**
 * Valida formularios antes de enviarlos
 * @param  {HTMLElement} formulario El formulario a validar
 */
const validar = formulario => {
	const inputs = w3.getElements(`#${formulario.id} input`)
	const radios = w3.getElements(`#${formulario.id} input[type='radio']`)
	const idForm = formulario.id

	const expresiones = {
		nombreNegocio: /^[\wáÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
		nombreProducto: /^[\w-áÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
		rif: /^(v|e){1}\d{9,15}$/i,
		telefono: /^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?\d{3}-?\d{4}$/,
		direccion: /^([a-záÁéÉíÍóÓúÚñÑ\d\,\.\-\#\/]\s?){4,50}$/i,
		cedula: /^[^e]?\d{7,8}$/,
		nombre: /^[A-Z][a-záÁéÉíÍóÓúÚñÑ]{4,20}$/i,
		usuario: /^@?[\w-]{4,20}$/i,
		clave: /^[\w.-@#*]{4,20}$/i,
		pregunta: /^[\?a-záÁéÉíÍóÓúÚñÑ¿\s]+$/i,
		respuesta: /^[a-záÁéÉíÍóÓúÚñÑ\d]{4,20}$/i,
		codigo: /^[a-z\d-.#]{3,10}$/i,
		stock: /^[^e]?[\d]+$/,
		precio: /^[\d.]+$/,
		iva: /^0\.\d{2,3}$/,
		dolar: /^\d+(\.\d{1,2})?$/,
		peso: /^[^e]?\d{1,4}$/,
	}

	const campos = {
		nombreNegocio: false,
		nombreProducto: false,
		nombreProveedor: false,
		rif: false,
		telefono: false,
		direccion: false,
		cedula: false,
		nombre: false,
		usuario: false,
		clave: false,
		confirmar: false,
		negocio: false,
		pregunta: false,
		respuesta: false,
		codigo: false,
		stock: false,
		precio: false,
		iva: false,
		dolar: false,
		peso: false
	}

	/**
	 * COMPARA DOS CAMPOS DE CONTRASEÑAS
	 */
	const compararClaves = () => {
		const clave1 = document.querySelector("input[name='nuevaClave']")
		const clave2 = document.querySelector("input[name='confirmar']")
		if (clave1.value === clave2.value) {
			correcto(clave2)
			campos.confirmar = true
		} else {
			error(clave2)
			campos.confirmar = false
		}
	}

	/**
	 * Valida un campo de entrada
	 * @param  {RegularExpression} expresion Una expresión regular a utilizar
	 * @param  {HTMLElement} input     Un elemento `input`
	 * @param  {String} campo     Valor del atributo `name` del elemento `input`
	 */
	const validarCampo = (expresion, input, campo) => {
		if (expresion.test(input.value)) {
			correcto(input)
			campos[campo] = true
		} else {
			error(input)
			campos[campo] = false
		}
	}

	/**
	 * VALIDA UN INPUT
	 * @param  {Event} e El input que recibe un evento
	 */
	const validarInput = e => {
		const input = e.target
		switch (input.name) {
			case 'nombreNegocio':
				validarCampo(expresiones.nombreNegocio, input, input.name)
				input.value = mayuscula(input.value)
				break

			case 'rif':
				validarCampo(expresiones.rif, input, input.name)
				input.value = mayuscula(input.value)
				break

			case 'telefono':
				validarCampo(expresiones.telefono, input, input.name)
				break

			case 'direccion':
				validarCampo(expresiones.direccion, input, input.name)
				input.value = mayuscula(input.value)
				break

			case 'cedula':
				validarCampo(expresiones.cedula, input, input.name)
				break

			case 'nombre':
				validarCampo(expresiones.nombre, input, input.name)
				input.value = mayuscula(input.value)
				break

			case 'usuario':
				validarCampo(expresiones.usuario, input, input.name)
				break

			case 'nuevaClave':
				validarCampo(expresiones.clave, input, 'clave')
				break

			case 'confirmar':
				validarCampo(expresiones.clave, input, input.name)
				compararClaves()
				break

			case 'clave':
				validarCampo(expresiones.clave, input, input.name)
				break

			case 'respuesta1':
			case 'respuesta2':
			case 'respuesta3':
				validarCampo(expresiones.respuesta, input, 'respuesta')
				break

			case 'pregunta1':
			case 'pregunta2':
			case 'pregunta3':
				validarCampo(expresiones.pregunta, input, 'pregunta')
				break

			case 'codigo':
				validarCampo(expresiones.codigo, input, input.name)
				input.value = input.value.toUpperCase()
				break

			case 'nombreProducto':
				validarCampo(expresiones.nombreProducto, input, input.name)
				input.value = mayuscula(input.value)
				break

			case 'stock':
				validarCampo(expresiones.stock, input, input.name)
				break

			case 'precio':
				validarCampo(expresiones.precio, input, input.name)
				break

			case 'nombreProveedor':
				validarCampo(expresiones.nombreNegocio, input, input.name)
				input.value = mayuscula(input.value)
				break

			case 'iva':
				validarCampo(expresiones.iva, input, input.name)
				break

			case 'dolar':
				validarCampo(expresiones.dolar, input, input.name)
				break

			case 'peso':
				validarCampo(expresiones.peso, input, input.name)
				break
		}
	}

	inputs.forEach(input => {
		input.addEventListener('keyup', validarInput)
		input.addEventListener('blur', validarInput)
	})

	formulario.addEventListener('submit', e => {
		if (radios.length)
			radios.forEach(radio => {
				if (radio.checked)
					campos.negocio = true
			})

		if (idForm === 'registrarNegocio')
			if (!campos.nombreNegocio) {
				e.preventDefault()
				error(formulario.nombreNegocio)
				alerta.fire({title: 'Verifique el nombre del negocio'})
			} else if (!campos.rif) {
				e.preventDefault()
				error(formulario.rif)
				alerta.fire({title: 'Verifique el RIF'})
			}

		if (idForm === 'formMonedas') {
			if (!campos.iva) {
				e.preventDefault()
				error(w3.getElement("input[name='iva']"))
				alerta('Verifique el IVA')
			}
			if (!campos.dolar) {
				e.preventDefault()
				error(w3.getElement("input[name='dolar']"))
				alerta('Verifique el monto en Bs.')
			}
			if (!campos.peso) {
				e.preventDefault()
				error(w3.getElement("input[name='peso']"))
				alerta('Verifique el monto en Pesos')
			}
		}

		if (idForm === 'registrarAdmin'
			|| idForm === 'formLogin'
			|| idForm === 'formularioRegistrarUsuario'
			|| idForm == 'formPerfil'
		)
			if (!campos.usuario) {
				e.preventDefault()
				error(formulario.usuario)
				alerta.fire({title: 'Verifique el usuario'})
			}

		if (idForm === 'registrarAdmin'
			|| idForm === 'formularioRegistrarUsuario'
			|| idForm === 'formClave'
			|| idForm === 'formActualizarClave'
		)
			if (!campos.clave) {
				e.preventDefault()
				error(formulario.nuevaClave)
				alerta.fire({title: 'Verifique la contraseña'})
			} else if (!campos.confirmar) {
				e.preventDefault()
				error(formulario.confirmar)
				alerta({title: 'Las contraseñas deben ser iguales'})
			}

		if (idForm === 'registrarAdmin'
			|| idForm === 'formularioRegistrarCliente'
			|| idForm === 'formularioRegistrarUsuario'
			|| idForm === 'formPerfil'
		)
			if (!campos.cedula) {
				e.preventDefault()
				error(formulario.cedula)
				alerta({title: 'Verifique la cédula'})
			} else if (!campos.nombre) {
				e.preventDefault()
				error(formulario.nombre)
				alerta.fire({title: 'Verifique el nombre'})
			} else if (formulario.telefono.value && !campos.telefono) {
				e.preventDefault()
				error(formulario.telefono)
				alerta.fire({title: 'Verifique el teléfono'})
			}

		if (idForm === 'formLogin') {
			if (!campos.clave) {
				e.preventDefault()
				error(w3.getElement("input[name='clave']"))
				alerta('Verifique la contraseña')
			}
			if (!campos.negocio) {
				e.preventDefault()
				alerta('Seleccione un negocio')
			}
		}

		if (idForm === 'formPreguntas' || idForm === 'formActualizarPreguntas')
			if (!campos.respuesta) {
				e.preventDefault()
				inputs.forEach(input => error(input))
				alerta('Verifique las respuestas')
			}

		if (idForm === 'formularioRegistrarProducto' || idForm === 'formEditProducto') {
			if (!campos.codigo) {
				e.preventDefault()
				error(w3.getElement("input[name='codigo']"))
				alerta('Verifique el código')
			}
			if (!campos.nombreProducto) {
				e.preventDefault()
				error(w3.getElement("input[name='nombreProducto'"))
				alerta('Verifique el nombre')
			}
			if (!campos.stock) {
				e.preventDefault()
				error(w3.getElement("input[name='stock']"))
				alerta('Verifique el campo \'Existencia\'')
			}
			if (!campos.precio) {
				e.preventDefault()
				error(w3.getElement("input[name='precio']"))
				alerta('Verifique el campo \'Precio\'')
			}
		}

		if (idForm === 'formularioRegistrarProveedor')
			if (!campos.nombreProveedor) {
				e.preventDefault()
				error(w3.getElement("input[name='nombreProveedor']"))
				alerta('Verifique el nombre')
			}

		if (idForm === 'formPreguntas')
			if (!campos.pregunta) {
				e.preventDefault()
				inputs.foreach(input => {
					if (input.name === 'pregunta1'
						|| input.name === 'pregunta2'
						|| input.name === 'pregunta3')
						error(input)
				})
				alerta('Verifique que las preguntas estén bien escritas')
			}
	})
}

export default validar