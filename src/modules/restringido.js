/** @typedef {import('./funciones')} */

let html = `
	<div class="w3-white w3-round-xlarge w3-padding w3-center w3-border" style="z-index: 1000">
		<div class="animate__animated animate__flip animate__infinite icon-close w3-xxxlarge w3-text-red"></div>
		<h2 class="w3-large w3-margin-bottom">
			<strong>ACCESO DENEGADO</strong>
		</h2>
		<p class="w3-topbar w3-center w3-padding w3-margin-top">
			Volviendo a la página principal
		</p>
	</div>
`

new Noty({
	text: html,
	theme: null,
	closeWith: [null],
	modal: true,
	timeout: 3000,
	layout: 'center',
	callbacks: { onClose: () => location.reload() }
}).show()