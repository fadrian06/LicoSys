// @ts-nocheck
/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLDivElement} */
const overlay = document.querySelector('.w3-overlay')
/** @type {HTMLButtonElement} */
const barras = document.querySelector('.icon-bars').parentElement
/** @type {HTMLElement} [description] */
const menuLateral = document.querySelector('#menu')
/** @type {HTMLButtonElement} */
const btnModenas = document.querySelector('#btn-monedas')
/** @type {HTMLFormElement} */
const formMonedas = document.querySelector('#actualizarMonedas')
const main = document.querySelector('main')
const dashboardHTML = main.innerHTML
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reajustar()
menu()
navegacion()

if (formMonedas) {
	validar(formMonedas, (error, fd, e) => {
		if (error) return alerta(error).show()
		
		e.preventDefault()
		formMonedas.classList.add('showLoader')
		ajax('backend/actualizarMonedas.php', fd, res => {
			/** @type {Respuesta} */
			const datos = JSON.parse(res)
			if (datos.error)
				return alerta(datos.error)
					.on('onClose', () => formMonedas.classList.remove('showLoader'))
					.show()
			
			$('#tablaMonedas').html(`
				<tr>
					<td>IVA</td>
					<td colspan="2"><b>${formMonedas.iva.value}%</b></td>
				</tr>
				<tr>
					<td>DÓLAR</td>
					<td>
						<b><i>Bs. </i>${formMonedas.dolar.value}</b>
					</td>
					<td><b>${formMonedas.pesos.value}<i> Pesos</i></b></td>
				</tr>	
			`)
			formMonedas.classList.remove('showLoader')
			
			return notificacion('Valores actualizados correctamente.')
				.on('onShow', () => {
					formMonedas.querySelector('.icon-close').click()
				})
				.show()
		})
	})
}
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/