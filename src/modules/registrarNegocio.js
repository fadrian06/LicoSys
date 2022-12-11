/**
 * @type {HTMLFormElement}
 */
const form = document.querySelector('#registrarNegocio')
/**
 * @type {HTMLInputElement}
 */
const inputFile = form.logo
/**
 * @type {HTMLImageElement}
 */
const image = form.querySelector('.image-result')
/**
 * @type {HTMLDivElement}
 */
const overlay = form.previousElementSibling

actualizarImagen(inputFile, image, error => {
	new Noty({
		text: `<i class="icon-close w3-margin-right"></i> ${error}`,
		type: 'error',
		timeout: 3000
	}).show()
})

/**
 * @param  {string} res {error: string, datos: []}
 */
const recibirRespuesta = res => {
	/**
	 * @type {{error: string, datos: []}}
	 */
	const datos = JSON.parse(res)
	
	if (datos.error) return new Noty({
		text: `<i class="icon-close w3-margin-right"></i> ${datos.error}`,
		type: 'error',
		timeout: 5000,
		callbacks: {
			afterClose: () => {
				overlay.classList.remove('w3-show')
				overlay.classList.add('w3-hide')
				form.classList.remove('showLoader')
			}
		}
	}).show()
	
	overlay.classList.remove('w3-show')
	overlay.classList.add('w3-hide')
	form.classList.remove('showLoader')
	
	new Noty({
		text: `<i class="icon-check w3-margin-right"></i> Negocio registrado exitósamente.`,
		type: 'success',
		timeout: 5000,
		callbacks: { afterClose: () => location.reload() }
	}).show()
}

validar(form, (error, fd, e) => {
	if (error) return new Noty({
		text: `<i class="icon-close w3-margin-right"></i> ${error}`,
		type: 'error',
		timeout: 3000
	}).show()
	
	e.preventDefault()
	overlay.style.zIndex = '999'
	overlay.classList.remove('w3-hide')
	overlay.classList.add('w3-show')
	form.classList.add('showLoader')
	
	fd.append(inputFile.id, inputFile.files[0])
	$.ajax({
		url: 'backend/registrarNegocio.php',
		type: 'POST',
		data: fd,
		contentType: false,
		processData: false,
		success: recibirRespuesta
	})
})