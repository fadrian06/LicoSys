/**
 * Esta funciona vigila un cambio de imagen y valida si cumple algunos requisitos:
 * <ul>
 * <li>La imagen sólo puede tener formato JPG o PNG</li>
 * <li>La imagen sólo puede tener un tamaño menor a 2 megabytes</li>
 * </ul>
 * @param  {HTMLInputElement} input `<input type="file">`
 * @param  {HTMLImageElement} image La `<img>` a actualizar
 * @param {(error: string)} [cb] Una función que se ejecuta si algo sale mal. <i>(opcional)</i>
 */
const actualizarImagen = (input, image, cb = () => {}) => {
	input.onchange = () => {
		const file = input.files[0]
		if (file.type !== 'image/jpeg'
			&& file.type !== 'image/jpg'
			&& file.type !== 'image/png'
		) return cb('Sólo se permiten imagenes JPG y PNG')
		
		if (file.size > (1 * 1000 * 1024 * 2)) /*1b * 1000 = 1kb * 1024 = 1mb * 2 = :D*/
			return cb('La imagen no puede ser mayor a 2MB')
		
		const fileReader = new FileReader()
		fileReader.readAsDataURL(file)
		fileReader.onload = e => image.setAttribute('src', e.target.result)
	}
}