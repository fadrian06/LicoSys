const mensajes = {
	nombreNegocio: 'El nombre debe tener entre 4 y 20 letras.',
	rif: 'El RIF debe empezar con V o E seguido de 9 a 15 números.',
	telefono: 'Introduce un teléfono válido. Ejemplos (+58 111-2222 o 04124442222)',
	direccion: 'La dirección debe tener entre 4 y 50 letras, números y símbolos (, . - # /)',
	cedula: 'La cédula debe tener entre 7 y 8 números.',
	nombre: 'El nombre debe tener entre 4 y 20 letras.',
	usuario: 'El usuario debe tener entre 4 y 20 letras, números o símbolos (- _)',
	clave: 'La clave debe tener entre 4 y 20 letras, números o símbolos (- _ . @ # / *)',
	confirmar: 'Ambas claves deben ser iguales.',
	pregunta: 'Las preguntas deben tener entre 1 y 50 letras y símbolos (¿ ?)',
	respuesta: 'Las respuestas deben tener entre 4 y 20 letras y números.',
	negocio: 'Por favor seleccione un negocio'
}

const expresiones = {
	// Entre 4 y 20 letras con espacios permitidos.
	nombreNegocio: /^[\wáÁéÉíÍóÓúÚñÑ\s]{4,20}$/i,
	
	nombreProducto: /^[\w-áÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
	
	// Comienza con V o E seguido de 9 a 15 números
	rif: /^(v|e){1}\d{9,15}$/i,
	
	// Ejemplos (04121112222 o +58 414-111-2222)
	telefono: /^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}$/,
	
	// Entre 4 y 50 letras, números o símbolos (, . - # /)
	direccion: /^([a-záÁéÉíÍóÓúÚñÑ\d\,\.\-\#\/]\s?){4,50}$/i,
	
	// Entre 7 y 8 números
	cedula: /^[^e]?[\d]{7,8}$/,
	
	// Entre 4 y 20 letras
	nombre: /^[a-záÁéÉíÍóÓúÚñÑ]{4,20}$/i,
	
	// Entre 4 y 20 letras, números y símbolos (- _)
	usuario: /^[\w-]{4,20}$/i,
	
	// Entre 4 y 20 letras, números y símbolos (- _ . @ # / *)
	clave: /^[\w.-@#/*]{4,20}$/i,
	
	// Entre 1 y 50 letras y símbolos (¿ ?)
	pregunta: /^[\?a-záÁéÉíÍóÓúÚñÑ¿\s]+$/i,
	
	// Entre 4 y 50 letras y números
	respuesta: /^[a-záÁéÉíÍóÓúÚñÑ\d\s]{4,20}$/i,
	codigo: /^[a-z\d-.#]{3,10}$/i,
	stock: /^[^e]?[\d]+$/,
	precio: /^[\d.]+$/,
	iva: /^0\.\d{2,3}$/,
	dolar: /^\d+(\.\d{1,2})?$/,
	peso: /^[^e]?\d{1,4}$/,
}

const campos = {
	nombreNegocio   : false,
	nombreProducto  : false,
	nombreProveedor : false,
	rif             : false,
	telefono        : false,
	direccion       : false,
	cedula          : false,
	nombre          : false,
	usuario         : false,
	clave           : false,
	confirmar       : false,
	pregunta        : false,
	respuesta       : false,
	negocio         : false,
	codigo          : false,
	stock           : false,
	precio          : false,
	iva             : false,
	dolar           : false,
	peso            : false
}

/**
 * @param  {HTMLInputElement} input
 */
const correcto = input => {
	input.parentElement.parentElement.classList.remove('invalido')
	input.parentElement.parentElement.classList.add('valido')
}

/**
 * @param  {HTMLInputElement} input
 */
const error = input => {
	input.parentElement.parentElement.classList.remove('valido')
	input.parentElement.parentElement.classList.add('invalido')
}

/**
 * @param  {RegExp} expresion
 * @param  {HTMLInputElement} input
 * @param  {string} campo
 */
const validarCampo = (expresion, input, campo) => {
	if (expresion.test(input.value)) {
		correcto(input)
		campos[campo] = true
		return
	}
	
	error(input)
	campos[campo] = false
}

/**
 * @param  {string} string Convierte cada inicial en mayúscula
 * @return {string} El `string` convertido
 */
const mayuscula = string => {
	let expresion = /(^[\wáÁéÉíÍóÓúÚñÑ]{1})|(\s+[\wáÁéÉíÍóÓúÚñÑ]{1})/g
	let mayuscula = string.replace(expresion, letra => letra.toUpperCase())
	return mayuscula
}

/**
 * @param  {HTMLInputElement} clave `<input name="clave">`
 * @param  {HTMLInputElement} confirmar `<input name="confirmar">`
 */
const compararClaves = (clave, confirmar) => {
	if (clave.value === confirmar.value) {
		correcto(confirmar)
		campos.confirmar = true
		return
	}
	
	error(confirmar)
	campos.confirmar = false;
}

/**
 * @param  {KeyboardEvent | FocusEvent} e Evento `keyup` o `blur`
 */
const validarInput = e => {
	/**
	 * @type {HTMLInputElement}
	 */
	const input = e.target
	
	switch (input.name) {
		case 'nombreNegocio':
			validarCampo(expresiones[input.name], input, input.name)
			input.value = mayuscula(input.value)
			break
			
		case 'rif':
			validarCampo(expresiones[input.name], input, input.name)
			input.value = mayuscula(input.value)
			break
			
		case 'telefono':
			validarCampo(expresiones[input.name], input, input.name)
			break
			
		case 'direccion':
			validarCampo(expresiones[input.name], input, input.name)
			input.value = mayuscula(input.value)
			break
			
		case 'cedula':
			validarCampo(expresiones[input.name], input, input.name)
			break
			
		case 'nombre':
			validarCampo(expresiones[input.name], input, input.name)
			input.value = mayuscula(input.value)
			break
			
		case 'usuario':
			validarCampo(expresiones[input.name], input, input.name)
			break
			
		case 'clave':
			validarCampo(expresiones[input.name], input, input.name)
			break
		
		case 'confirmar':
			validarCampo(expresiones.clave, input, input.name)
			compararClaves(input.form.clave, input)
			break
		
		case 'pre1':
		case 'pre2':
		case 'pre3':
			validarCampo(expresiones.pregunta, input, 'pregunta')
			break
			
		case 'res1':
		case "res2":
		case 'res3':
			validarCampo(expresiones.respuesta, input, 'respuesta')
			break
	}
}

/**
 * @param  {HTMLFormElement} form El `<form>`a validar. DEBE TENER UN ID de los siguientes: <br><br>
 * <i>registrarNegocio <br>
 * registrarAdmin <br>
 * registrarPreguntasRespuestas <br>
 * login <br>
 * consultar <br>
 * preguntasRespuestas <br>
 * cambiarClave <br></i>
 * <br>
 * <br>
 * Los `input` deben tener alguno de los siguientes `name` y `id` <br><br>
 * <i>nombreNegocio <br>
 * rif <br>
 * telefono <br>
 * direccion <br>
 * cedula <br>
 * nombre <br>
 * usuario <br>
 * clave <br>
 * confirmar <br>
 * pre1, pre2 o pre3 <br>
 * res1, res2 o res3 <br></i>
 * @param {?(error: string, FormData: FormData, e: SubmitEvent)} cb Contiene el resultado de la validación, los datos a enviar y el Evento `submit`
 */
const validar = (form, cb = () => {}) => {
	
	const inputs = form.querySelectorAll('input')
	/**
	 * @type {NodeListOf<HTMLInputElement>}
	 */
	const radios = form.querySelectorAll('input[type="radio"]')
	
	form.onsubmit = e => {
		
		const fd = new FormData(form)
		
		if (form.id === 'registrarNegocio') {
			if (!campos.nombreNegocio) {
				e.preventDefault()
				
				error(form.nombreNegocio)
					
				return cb(mensajes.nombreNegocio)
					
			} else if (!campos.rif) {
				e.preventDefault()
				error(form.rif)
					
				return cb(mensajes.rif)
					
			} else if (form.telefono.value && !campos.telefono) {
				e.preventDefault()
				error(form.telefono)
					
				return cb(mensajes.telefono)
					
			} else if (form.direccion.value && !campos.direccion) {
				e.preventDefault()
				error(form.direccion)
					
				return cb(mensajes.direccion)
			}
		}
		
		if (form.id === 'registrarAdmin') {
			if (!campos.cedula) {
				e.preventDefault()
				error(form.cedula)
				
				return cb(mensajes.cedula)
			} else if (!campos.nombre) {
				e.preventDefault()
				error(form.nombre)
				
				return cb(mensajes.nombre)
			} else if (!campos.usuario) {
				e.preventDefault()
				error(form.usuario)
				
				return cb(mensajes.usuario)
			} else if (!campos.clave) {
				e.preventDefault()
				error(form.clave)
				
				return cb(mensajes.clave)
			} else if (!campos.confirmar) {
				e.preventDefault()
				error(form.confirmar)
				
				return cb(mensajes.confirmar)
			} else if (form.telefono.value && !campos.telefono) {
				e.preventDefault()
				error(form.telefono)
				
				return cb(mensajes.telefono)
			}
		}
		
		if (form.id === 'registrarPreguntasRespuestas') {
			if (!campos.pregunta) {
				e.preventDefault()
				error(form.pre1)
				error(form.pre2)
				error(form.pre3)
				
				return cb(mensajes.pregunta)
			} else if (!campos.respuesta) {
				e.preventDefault()
				error(form.res1)
				error(form.res2)
				error(form.res3)
				
				return cb(mensajes.respuesta)
			}
		}
		
		if (form.id === 'login') {
			for (let i = 0; i < radios.length; ++i)
				if (radios[i].checked) campos.negocio = true
			
			if (!campos.negocio) {
				e.preventDefault()
				
				return cb(mensajes.negocio)
			} else if (!campos.usuario) {
				e.preventDefault()
				error(form.usuario)
				
				return cb(mensajes.usuario)
			} else if (!campos.clave) {
				e.preventDefault()
				error(form.clave)
				
				return cb(mensajes.clave)
			}
		}
		
		if (form.id === 'consultar') {
			if (!campos.cedula) {
				e.preventDefault()
				error(form.cedula)
				
				return cb(mensajes.cedula)
			} else if (!campos.usuario) {
				e.preventDefault()
				error(form.usuario)
				
				return cb(mensajes.usuario)
			}
		}
		
		if (form.id === 'preguntasRespuestas') {
			if (!campos.respuesta) {
				e.preventDefault()
				error(form.res1)
				error(form.res2)
				error(form.res3)
				
				return cb(mensajes.respuesta)
			}
		}
		
		if (form.id === 'cambiarClave') {
			if (!campos.clave) {
				e.preventDefault()
				error(form.clave)
				
				return cb(mensajes.clave)
			} else if (!campos.confirmar) {
				e.preventDefault()
				error(form.confirmar)
				
				return cb(mensajes.confirmar)
			}
		}
					
		cb(null, fd, e)
	}
	
	for (let i = 0; i <= inputs.length; ++i) {
		const input = inputs[i]
		
		if (!input) return
		
		if (input.type !== 'text'
			&& input.type !== 'password'
			&& input.type !== 'number'
			&& input.type !== 'search'
			&& input.type !== 'email'
			&& input.type !== 'tel'
		) continue
			
		
		input.onkeyup = validarInput
		input.onblur = validarInput
	}
}