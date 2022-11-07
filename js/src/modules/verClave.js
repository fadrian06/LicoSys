/**
 * Muestra u oculta las contraseñas
 */
const verClave = () => {
	const ojos = w3.getElements('.icon-eye')
	ojos.forEach(ojo => {
		ojo.addEventListener('click', () => {
			const input = ojo.parentElement.querySelector('input')
			if (input.type === 'password') {
				input.type = 'text'
				ojo.classList.replace('icon-eye', 'icon-eye-slash')
			} else ojo.classList.replace('icon-eye-slash', 'icon-eye')
		})
	})
}

export default verClave