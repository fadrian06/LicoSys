let html = `
	<h1 class="w3-text-white w3-center w3-xlarge oswald">
		Bienvenido a Licosys
	</h1>
	<div class="newtons-cradle">
		<div class="newtons-cradle__dot"></div>
		<div class="newtons-cradle__dot"></div>
		<div class="newtons-cradle__dot"></div>
		<div class="newtons-cradle__dot"></div>
	</div>
	<p class="w3-text-white w3-center">
		Estamos configurando algunas cosas, por favor espere...
	</p>
`

const showIntro = () => {
	$('#loader').remove()
	html = `
		<div class="w3-card w3-round-xlarge w3-white w3-padding-large w3-center">
			<h1 class="w3-xlarge oswald">Licosys instalado correctamente</h1>
			<h2 class="w3-large w3-padding-top-24 w3-topbar">
				Sólo faltan unos pocos pasos...
			</h2>	
		</div>
	`
	new Noty({
		theme: null,
		id: 'intro',
		type: 'info',
		text: html,
		layout: 'center',
		closeWith: [null],
		animation: { open: 'w3-animate-zoom' },
		timeout: 3000,
		callbacks: { afterClose: () => location.reload() }
	}).show()
}

const capturarRespuesta = data => {
	if (data !== 'true')
		return console.log(data)
	
	setTimeout(showIntro, 3000)
}

const showLoader = () => {
	$.post('backend/conexion.php', { instalarBD: true }, capturarRespuesta)
}

new Noty({
	theme: null,
	id: 'loader',
	type: 'info',
	layout: 'center',
	text: html,
	closeWith: [null],
	animation: { open: 'w3-animate-opacity' },
	callbacks: { onShow: showLoader }
}).show()