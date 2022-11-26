import Swal from 'sweetalert2'

/**
 * @param  {string}  title
 * @param  {bool} toast Default: true
 * @param  {Number}  timer Default: 3000ms
 * @returns {bool} siempre retorna `false`
 */
const alerta = (title, toast = true, timer = 3000) => {
	let position = toast ? 'bottom-end' : 'center'

	Swal.fire({
		title: title,
		icon: 'error',
		toast: toast,
		timer: timer,
		timerProgressBar: true,
		position: position,
		showConfirmButton: false
	})
	return false
}

/**
 * @param  {string}  title
 * @param  {bool} toast Default: true
 * @param  {number}  timer Default: 3000
 * @returns {bool} Siempre retorna `true`
 */
const notificacion = (title, toast = true, timer = 3000) => {
	let position = toast ? 'bottom-end' : 'center'

	Swal.fire({
		title: title,
		icon: 'success',
		toast: toast,
		timer: timer,
		timerProgressBar: true,
		position: position,
		showConfirmButton: false
	})
	return true
}

/**
 * @param  {String} title
 * @returns {bool} Siempre retorna `false`
 */
const advertencia = title => {
	Swal.fire({
		title: title,
		icon: 'warning',
		toast: true,
		timer: 3000,
		timerProgressBar: true,
		position: 'bottom-start',
		showConfirmButton: false
	})
	return false
}

export { alerta, notificacion, advertencia }