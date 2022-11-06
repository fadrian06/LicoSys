import { alerta } from './alertas'

/**
 * Actualiza la imagen
 * @param  {File} file El objeto que contiene los datos de la imagen
 * @param {HTMLCollection} images Las imagenes a actualizar
 */
const cargarImagen = (file, images) => {
	const fileReader = new FileReader()
	fileReader.readAsDataURL(file)
	fileReader.addEventListener('load', e =>
		images.forEach(img => img.setAttribute('src', e.target.result))
	)
}

/**
 * Comprueba la imagen antes de cargarla
 * @param  {Event} e El evento `change` de un `ìnput[type="file"]`
 * @return {Bool} Retorna `true` si se pudo cargar la imagen, caso contrario retorna `false`
 */
const comprobarImagen = e => {
	const images = w3.getElements('img.image-result')
	const submits = w3.getElements("input[name='actualizarFoto']")
	const file = e.target.files[0]
	switch (file.type) {
		case 'image/jpeg':
		case 'image/jpg':
		case 'image/png':
			if (file.size > (1 * 1000 * 2048)) {
				alerta.fire({ title: "La imagen no puede ser mayor a <b class='w3-text-red' title='2 Megabytes'>2MB</b>" })
				return false
			}
			
			cargarImagen(file, images)
			if (submits)
				submits.forEach(submit => submit.classList.remove('w3-hide'))
			return true
		default:
			alerta.fire({ title: 'Sólo se permiten imagenes (<b>jpeg, jpg o png</b>)' })
			return false
	}
}

/**
 * Cambio de foto automático
 */
const actualizarFoto = () => {
	const inputsFile = w3.getElements("input[type='file']")
	inputsFile.forEach(input => input.addEventListener('change', comprobarImagen))
}

export default actualizarFoto