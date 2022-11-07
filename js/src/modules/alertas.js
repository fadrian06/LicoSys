/**
 * Mixin para alertas
 * @type {Swal.mixin}
 */
const alerta = Swal.mixin({
	icon: 'error',
	toast: true,
	timerProgressBar: true,
	timer: 3000,
	position: 'bottom-end',
	showConfirmButton: false
})

/**
 * Mixin para advertencias
 * @type {Swal.mixin}
 */
const advertencia = Swal.mixin({
	icon: 'warning',
	toast: true,
	timer: 3000,
	timerProgressBar: true,
	position: 'bottom-end',
	showConfirmButton: false
})

/**
 * Mixin para notificaciones
 * @type {Swal.mixin}
 */
const notificacion = Swal.mixin({
	icon: 'success',
	toast: true,
	timer: 3000,
	timerProgressBar: true,
	position: 'bottom-end',
	showConfirmButton: false
})

export { alerta, advertencia, notificacion }