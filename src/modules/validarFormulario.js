import w3 from '../libs/w3'
import { alerta } from './mixins'
import { BASE_URI, expresiones } from '../config'
import axios from 'axios'

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

/*====================================
=            COMPLEMENTOS            =
====================================*/
/**
 * @param  {HTMLInputElement} input
 */
const error = input => {
	if (input.type == 'text'
		|| input.type == 'password'
		|| input.type == "number"
		|| input.type == "tel"
	) {
		w3.removeClass(input.parentElement, 'valido')
		w3.addClass(input.parentElement, 'invalido')
		setTimeout(() => {
			w3.removeClass(input.parentElement, 'invalido')
			input.parentElement.querySelector('label').style = {
				top: '-20px',
				fontSize: '14px'
			}
		}, 3000)
	}
}

/**
 * @param {HTMLInputElement} input
 */
const correcto = input => {
	if (input.type == 'text'
		|| input.type == 'password'
		|| input.type == 'number'
		|| input.type == 'tel'
	) {
		w3.removeClass(input.parentElement, 'invalido')
		w3.addClass(input.parentElement, 'valido')
	}
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
	} else {
		error(input)
		campos[campo] = false
	}
}

/**
 * @param {string} string
 */
const mayuscula = string => {
	let expresion = /(^[\wáÁéÉíÍóÓúÚñÑ]{1})|(\s+[\wáÁéÉíÍóÓúÚñÑ]{1})/g
	let mayuscula = string.replace(expresion, letra => letra.toUpperCase())
	return mayuscula
}

const compararClaves = () => {
	const clave1 = document.querySelector('input[name="nuevaClave"]')
	const clave2 = document.querySelector('input[name="confirmar"]')
	if (clave1.value == clave2.value) {
		correcto(clave2)
		campos.confirmar = true
	} else {
		error(clave2)
		campos.confirmar = false
	}
}

/**
 * @param  {KeyboardEvent} e
 */
const validarInput = e => {
	switch (e.target.name) {
		case 'nombreNegocio':
			validarCampo(expresiones.nombreNegocio, e.target, 'nombreNegocio')
			e.target.value = mayuscula(e.target.value)
			break

		case 'rif':
			validarCampo(expresiones.rif, e.target, 'rif')
			e.target.value = mayuscula(e.target.value)
			break

		case 'telefono':
			validarCampo(expresiones.telefono, e.target, 'telefono')
			break

		case 'direccion':
			validarCampo(expresiones.direccion, e.target, 'direccion')
			e.target.value = mayuscula(e.target.value)
			break

		case 'cedula':
			validarCampo(expresiones.cedula, e.target, 'cedula')
			break

		case 'nombre':
			validarCampo(expresiones.nombre, e.target, 'nombre')
			e.target.value = mayuscula(e.target.value)
			break

		case 'usuario':
			validarCampo(expresiones.usuario, e.target, 'usuario')
			break

		case 'nuevaClave':
			validarCampo(expresiones.clave, e.target, 'clave')
			break

		case 'confirmar':
			validarCampo(expresiones.clave, e.target, 'confirmar')
			compararClaves()
			break

		case 'clave':
			validarCampo(expresiones.clave, e.target, 'clave')
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
			validarCampo(expresiones.codigo, e.target, 'codigo')
			e.target.value = e.target.value.toUpperCase()
			break

		case 'nombreProducto':
			validarCampo(expresiones.nombreProducto, e.target, 'nombreProducto')
			e.target.value = mayuscula(e.target.value)
			break

		case 'stock':
			validarCampo(expresiones.stock, e.target, 'stock')
			break

		case 'precio':
			validarCampo(expresiones.precio, e.target, 'precio')
			break

		case 'nombreProveedor':
			validarCampo(expresiones.nombreNegocio, e.target, 'nombreProveedor')
			e.target.value = mayuscula(e.target.value)
			break

		case 'iva':
		case 'dolar':
			validarCampo(expresiones.iva, e.target, 'iva')
			validarCampo(expresiones.dolar, e.target, 'dolar')
			break

		case 'peso':
			validarCampo(expresiones.peso, e.target, 'peso')
			break
	}
}

/**
 * @param  {FormData} formData
 * @param {string} url Default: `${BASE_URI}/backend/ajax.php`
 * @param {string} param example `registrar`
 */
const enviarFormulario = async (formData, url, param) => {
	formData.append(param, 'true')
	const { data } = await axios.post(url, formData)
	console.log(data)
}

/*=========================================
=            FUNCIÓN PRINCIPAL            =
=========================================*/
/**
 * Esta función requiere que el `formulario` y los `inputs` tengan un `ID`
 * en `camelCase`.<br> Para formularios con imagenes declarar un elemento
 * `img` con la clase `image-result`.
 * @param {HTMLFormElement} form
 */
export default form => {
	
	const idForm = form.id
	/**
	 * @type {NodeListOf<HTMLInputElement>}
	 */
	const inputs = form.querySelectorAll('input')
	
	/**
	 * @type {NodeListOf<HTMLInputElement>}
	 */
	const radios = form.querySelectorAll('input[type="radio"]')
	
	/**
	 * @type {HTMLInputElement}
	 */
	const file = form.querySelector('input[type="file"]')

	inputs.forEach(input => {
		input.addEventListener('keyup', validarInput)
		input.addEventListener('blur', validarInput)
	})

	/*=====================================
	=            EVENTO SUBMIT            =
	=====================================*/
	form.addEventListener('submit', async e => {
		
		if (radios)
			radios.forEach(radio => {
				if (radio.checked) campos.negocio = true
			})
		
		if (idForm === 'registrarNegocio') {
			if (!campos.nombreNegocio) {
				e.preventDefault()
				error(form.nombreNegocio)
				alerta(form.nombreNegocio.getAttribute('title'))
			} else if (!campos.rif) {
				e.preventDefault()
				error(form.rif)
				alerta(form.rif.getAttribute('title'))
			}
		}
		
		if (idForm == 'formMonedas') {
			if (!campos.iva) {
				e.preventDefault()
				// error(w3.getElement("input[name='iva']"))
				alerta("Verifique el IVA")
			}
			if (!campos.dolar) {
				e.preventDefault()
				// error(w3.getElement("input[name='dolar']"))
				alerta("Verifique el monto en Bs.")
			}
			if (!campos.peso) {
				e.preventDefault()
				// error(w3.getElement("input[name='peso']"))
				alerta("Verifique el monto en Pesos")
			}
		}

		if (idForm == "formAdmin" || idForm == "formLogin" || idForm == "formularioRegistrarUsuario" || idForm == "formPerfil") {
			if (!campos.usuario) {
				e.preventDefault()
				// error(w3.getElement("input[name='usuario']"))
				alerta("Verifique el usuario")
			}
		}

		if (idForm == "formAdmin" || idForm == "formularioRegistrarUsuario" || idForm == "formClave" || idForm == "formActualizarClave") {
			if (!campos.clave) {
				e.preventDefault()
				// error(w3.getElement("input[name='nuevaClave']"))
				alerta("Verifique la contraseña")
			} else if (!campos.confirmar) {
				e.preventDefault()
				// error(w3.getElement("input[name='confirmar']"))
				alerta("Las contraseñas deben ser iguales")
			}
		}

		if (idForm == "formAdmin" || idForm == "formularioRegistrarCliente" || idForm == "formularioRegistrarUsuario" || idForm == "formPerfil") {
			if (!campos.cedula) {
				e.preventDefault()
				// error(w3.getElement("input[name='cedula']"))
				alerta("Verifique la cédula")
			} else if (!campos.nombre) {
				e.preventDefault()
				// error(w3.getElement("input[name='nombre']"))
				alerta("Verifique el nombre")
			}
		}

		if (idForm == "formLogin") {
			if (!campos.clave) {
				e.preventDefault()
				// error(w3.getElement("input[name='clave']"))
				alerta("Verifique la contraseña")
			}
			if (!campos.negocio) {
				e.preventDefault()
				alerta("Seleccione un negocio")
			}
		}

		if (idForm == "formPreguntas" || idForm == "formActualizarPreguntas") {
			if (!campos.respuesta) {
				e.preventDefault()
				inputs.forEach(input => error(input))
				alerta('Verifique las respuestas')
			}
		}

		if (idForm == "formularioRegistrarProducto" || idForm == "formEditProducto") {
			if (!campos.codigo) {
				e.preventDefault()
				// error(w3.getElement("input[name='codigo']"))
				alerta("Verifique el código")
			}
			if (!campos.nombreProducto) {
				e.preventDefault()
				// error(w3.getElement("input[name='nombreProducto'"))
				alerta("Verifique el nombre")
			}
			if (!campos.stock) {
				e.preventDefault()
				// error(w3.getElement("input[name='stock']"))
				alerta("Verifique el campo 'Existencia'")
			}
			if (!campos.precio) {
				e.preventDefault()
				// error(w3.getElement("input[name='precio']"))
				alerta("Verifique el campo 'Precio'")
			}

			if (idForm == "formularioRegistrarProveedor") {
				if (!campos.nombreProveedor) {
					e.preventDefault()
					// error(w3.getElement("input[name='nombreProveedor']"))
					alerta("Verifique el nombre")
				}
			}

			if (idForm == "formPreguntas") {
				if (!campos.pregunta) {
					e.preventDefault()
					inputs.foreach(input => {
						if (input.name == "pregunta1" || input.name == "pregunta2" || input.name == "pregunta3") error(input)
					})
					alerta("Verifique que las preguntas estén bien escritas")
				}
			}
		}
		
		const fd = new FormData(form)
		
		await enviarFormulario(fd, )
	})
}