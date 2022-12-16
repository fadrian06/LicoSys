/**
 * Crea un reloj
 * @param  {HTMLDivElement} contenedor Contenedor para el reloj
 */
const reloj = contenedor => {
	const fecha = new Date()
	let horas = fecha.getHours(),
		ampm,
		minutos = fecha.getMinutes(),
		diaSemana = fecha.getDay(),
		dia = fecha.getDate(),
		mes = fecha.getMonth(),
		year = fecha.getFullYear();
		const semana = [
			'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'
		]
		const meses = [
			'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
			'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
		]

		if (horas >= 12) {
			horas -= 12
			ampm = 'PM'
		} else
			ampm = 'AM'

		if (horas === 0) horas = 12
		if (minutos < 10) minutos = `0${minutos}`

		contenedor.innerHTML = `
			<div class="fecha">
				<b>${semana[diaSemana]}</b>
				<b>${dia}</b>
				<b>de </b>
				<b>${meses[mes]}</b>
				<b>del </b>
				<b>${year}</b>
			</div>
			<div class="hora">
				<b>${horas}</b>
				<b>:</b>
				<b>${minutos}</b>
				<b>${ampm}</b>
			</div>
		`
}