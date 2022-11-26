import w3 from '../libs/w3'
import { alerta } from './mixins'

/**
 * @param {blob} file
 * @param {NodeListOf<HTMLImageElement>} images
 */
const uploadImage = (file, images) => {
	const fileReader = new FileReader()
	fileReader.readAsDataURL(file)
	fileReader.addEventListener('load',
		e => images.forEach(img => img.setAttribute('src', e.target.result))
	)
}

/**
 * @param {Event} e
 * @returns {bool}
 */
const validarImagen = e => {
	
	/**
	 * @type {NodeListOf<HTMLImageElement>}
	 */
	const images = w3.getElements('img.image-result')
	
	/**
	 * @type {NodeListOf<HTMLInputElement>}
	 */
	const submits = w3.getElements('input[name="actualizarFoto"]')
	let spans
	if (submits.length)
		spans = submits[0].form.querySelectorAll('span')
	
	const file = e.target.files[0]
	
	/*====================================
	=            VALIDACIONES            =
	====================================*/
	if (!file.type === 'image/jpeg'
		|| !file.type === 'image/jpg'
		|| !file.type === 'image/png'
	) alerta('Sólo se permiten images (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)')
	
	if (!file.size > (1 * 1000 * 2048))
		alerta('La imagen no puede ser mayor a <b class="w3-text-red" title="2 Megabytes">2MB</b>')
	
	uploadImage(file, images)
	
	if (submits)
		submits.forEach(submit => submit.classList.remove('w3-hide'))
	if (spans)
		spans.forEach(span => span.classList.add('w3-animate-bottom'))
}

/**
 * Requiere un `input[type="file"]` y un elemento `img` con la clase `image-result`
 */
export default () => {
	/**
	 * @type {NodeListOf<HTMLInputElement>}
	 */
	const inputsFile = w3.getElements('input[type="file"]')
	inputsFile.forEach(input => input.addEventListener('change', validarImagen))
}