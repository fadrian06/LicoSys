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
	if (input.type == 'text' || input.type == 'password' || input.type == 'number') {
		const contenedorInput = input.parentElement.parentElement
		const iconoLabel = input.parentElement.previousElementSibling
		const iconoCheck = input.parentElement.nextElementSibling
		const iconoX = input.parentElement.nextElementSibling.nextElementSibling

		contenedorInput.classList.add('w3-border-red')
		iconoLabel.classList.replace('w3-teal', 'w3-red')
		iconoCheck.classList.replace('w3-show', 'w3-hide')
		iconoX.classList.replace('w3-hide', 'w3-show')
	}
}

/**
 * MUESTRA QUE LA VALIDACIÓN ACEPTÓ LA ENTRADA
 * @param  {HTMLElement} input El input a colorear
 */
const correcto = input => {
	if (input.type == 'text' || input.type == 'password' || input.type == 'number') {
		const contenedorInput = input.parentElement.parentElement
		const iconoLabel = input.parentElement.previousElementSibling
		const iconoCheck = input.parentElement.nextElementSibling
		const iconoX = input.parentElement.nextElementSibling.nextElementSibling

		contenedorInput.classList.remove('w3-border-red')
		iconoLabel.classList.replace('w3-red', 'w3-teal')
		iconoCheck.classList.replace('w3-hide', 'w3-show')
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
		telefono: /^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}$/,
		direccion: /^([a-záÁéÉíÍóÓúÚñÑ\d\,\.\-\#\/]\s?){4,50}$/i,
		cedula: /^[^e]?[\d]{7,8}$/,
		nombre: /^[a-záÁéÉíÍóÓúÚñÑ]{4,20}$/i,
		usuario: /^[\w-]{4,20}$/i,
		clave: /^[\w.-@#/*]{4,20}$/i,
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
		const clave1 = w3.getElement("input[name='nuevaClave']")
		const clave2 = w3.getElement("input[name='confirmar']")
		if (clave1.value === clave2.value) {
			correcto(clave2)
			campos.confirmar = true
		} else {
			error(clave2)
			campos.confirmar = false
		}
	}

	/**
	 * VALIDA UN CAMPO DE ENTRADA
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
		switch (e.target.name) {
			case 'nombreNegocio':
				validarCampo(expresiones.nombreNegocio, e.target, e.target.name)
				e.target.value = mayuscula(e.target.value)
				break

			case 'rif':
				validarCampo(expresiones.rif, e.target, e.target.name)
				e.target.value = mayuscula(e.target.value)
				break

			case 'telefono':
				validarCampo(expresiones.telefono, e.target, e.target.name)
				break

			case 'direccion':
				validarCampo(expresiones.direccion, e.target, e.target.name)
				e.target.value = mayuscula(e.target.value)
				break

			case 'cedula':
				validarCampo(expresiones.cedula, e.target, e.target.name)
				break

			case 'nombre':
				validarCampo(expresiones.nombre, e.target, e.target.name)
				e.target.value = mayuscula(e.target.value)
				break

			case 'usuario':
				validarCampo(expresiones.usuario, e.target, e.target.name)
				break

			case 'nuevaClave':
				validarCampo(expresiones.clave, e.target, 'clave')
				break

			case 'confirmar':
				validarCampo(expresiones.clave, e.target, e.target.name)
				compararClaves()
				break

			case 'clave':
				validarCampo(expresiones.clave, e.target, e.target.name)
				break

			case 'respuesta1':
			case 'respuesta2':
			case 'respuesta3':
				validarCampo(expresiones.respuesta, e.target, 'respuesta')
				break

			case 'pregunta1':
			case 'pregunta2':
			case 'pregunta3':
				validarCampo(expresiones.pregunta, e.target, 'pregunta')
				break

			case 'codigo':
				validarCampo(expresiones.codigo, e.target, e.target.name)
				e.target.value = e.target.value.toUpperCase()
				break

			case 'nombreProducto':
				validarCampo(expresiones.nombreProducto, e.target, e.target.name)
				e.target.value = mayuscula(e.target.value)
				break

			case 'stock':
				validarCampo(expresiones.stock, e.target, e.target.name)
				break

			case 'precio':
				validarCampo(expresiones.precio, e.target, e.target.name)
				break

			case 'nombreProveedor':
				validarCampo(expresiones.nombreNegocio, e.target, e.target.name)
				e.target.value = mayuscula(e.target.value)
				break

			case 'iva':
				validarCampo(expresiones.iva, e.target, e.target.name)
				break

			case 'dolar':
				validarCampo(expresiones.dolar, e.target, e.target.name)
				break

			case 'peso':
				validarCampo(expresiones.peso, e.target, e.target.name)
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
				alerta('Verifique el nombre del negocio')
			} else if (!campos.rif) {
				e.preventDefault()
				error(formulario.rif)
				alerta("Verifique el RIF")
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

		if (idForm === 'formAdmin'
			|| idForm === 'formLogin'
			|| idForm === 'formularioRegistrarUsuario'
			|| idForm == 'formPerfil')
			if (!campos.usuario) {
				e.preventDefault()
				error(w3.getElement("input[name='usuario']"))
				alerta('Verifique el usuario')
			}

		if (idForm === 'formAdmin'
			|| idForm === 'formularioRegistrarUsuario'
			|| idForm === 'formClave'
			|| idForm === 'formActualizarClave')
			if (!campos.clave) {
				e.preventDefault()
				error(w3.getElement("input[name='nuevaClave']"))
				alerta('Verifique la contraseña')
			} else if (!campos.confirmar) {
				e.preventDefault()
				error(w3.getElement("input[name='confirmar']"))
				alerta('Las contraseñas deben ser iguales')
			}

		if (idForm === 'formAdmin'
			|| idForm === 'formularioRegistrarCliente'
			|| idForm === 'formularioRegistrarUsuario'
			|| idForm === 'formPerfil')
			if (!campos.cedula) {
				e.preventDefault()
				error(w3.getElement("input[name='cedula']"))
				alerta('Verifique la cédula')
			} else if (!campos.nombre) {
				e.preventDefault()
				error(w3.getElement("input[name='nombre']"))
				alerta('Verifique el nombre')
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