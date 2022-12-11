/**
 * @param  {HTMLInputElement} input `<input type="file">`
 * @param  {HTMLImageElement} image La <img> a actualizar
 * @param {?(error: string)} cb Un callback cuando algo salga mal
 */
const actualizarImagen = (input, image, cb = () => {}) => {
	input.onchange = () => {
		const file = input.files[0]
		if (file.type !== 'image/jpeg'
			&& file.type !== 'image/jpg'
			&& file.type !== 'image/png'
		) return cb('Sólo se permiten imagenes JPG y PNG')
		
		if (file.size > (1 * 1000 * 2048))
			return cb('La imagen no puede ser mayor a 2MB')
		
		const fr = new FileReader()
		fr.readAsDataURL(file)
		fr.onload = e => image.setAttribute('src', e.target.result)
	}
}