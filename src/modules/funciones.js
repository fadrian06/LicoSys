Noty.overrideDefaults({
	theme: 'sunset'
})

// onoffline = () => advertencia("Se ha perdido la conexión");
// ononline  = () => notificacion("Se ha restablecido la conexión");

// const ojos = w3.getElements('.icon-eye');
// if(ojos !== undefined)
// ojos.forEach(ojo => ojo.addEventListener('click', e => verClave(e.target)));

// function reloj(contenedor){
// 	const fecha = new Date();
// 	let horas = fecha.getHours(),
// 		ampm,
// 		minutos = fecha.getMinutes(),
// 		diaSemana = fecha.getDay(),
// 		dia = fecha.getDate(),
// 		mes = fecha.getMonth(),
// 		year = fecha.getFullYear();
// 		const semana = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"];
// 		const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

// 		if (horas >= 12) {
// 			horas = horas - 12;
// 			ampm = "PM";
// 		} else {
// 			ampm = "AM";
// 		}

// 		if (horas == 0) horas = 12;

// 		if (minutos < 10) minutos = `0${minutos}`;

// 		contenedor.innerHTML = `
// 			<div class="fecha">
// 				<b id="diaSemana">${semana[diaSemana]}</b>
// 				<b id="dia">${dia}</b>
// 				<b>de </b>
// 				<b id="mes">${meses[mes]}</b>
// 				<b>del </b>
// 				<b id="year">${year}</b>
// 			</div>
// 			<div class="reloj">
// 				<b id="horas">${horas}</b>
// 				<b>:</b>
// 				<b id="minutos">${minutos}</b>
// 				<b id="ampm">${ampm}</b>
// 			</div>
// 		`;
// }

// function menu(boton, modal, overlay) {
// 	boton.addEventListener("click", e => {
// 		overlay.classList.replace("w3-hide", "w3-show");
// 		overlay.style.cursor = "pointer";
// 		modal.classList.replace("w3-hide", "w3-show");
// 		modal.classList.replace("animate__animated", "w3-animate-left");
// 		modal.classList.remove("animate__slideOutLeft");
// 		modal.classList.remove("animate__faster");
// 	});
// 	overlay.addEventListener("click", e => {
// 		modal.classList.replace("w3-animate-left", "animate__animated");
// 		modal.classList.add("animate__slideOutLeft");
// 		modal.classList.add("animate__faster");
// 		e.target.classList.replace("w3-show", "w3-hide");
// 		setTimeout(() => modal.classList.replace("w3-show", "w3-hide"), 500);
// 	});
// }

// function alerta(title = "", toast = true, timer = 2000) {
// 	if (toast) {
// 		var position = "bottom-end";
// 	} else {
// 		var position = "center";
// 	}

// 	Swal.fire({
// 		title: title,
// 		icon: 'error',
// 		toast: toast,
// 		timer: timer,
// 		timerProgressBar: true,
// 		position: position,
// 		showConfirmButton: false
// 	});
// }

// function notificacion(title = "", toast = true, timer = 2000) {
// 	if (toast) {
// 		var position = "bottom-end";
// 	} else {
// 		var position = "center";
// 	}

// 	Swal.fire({
// 		title: title,
// 		icon: "success",
// 		toast: toast,
// 		timer: timer,
// 		timerProgressBar: true,
// 		position: position,
// 		showConfirmButton: false
// 	});
// }

// function advertencia(title = "") {
// 	Swal.fire({
// 		title: title,
// 		icon: "warning",
// 		toast: true,
// 		timer: 3000,
// 		timerProgressBar: true,
// 		position: "bottom-start",
// 		showConfirmButton: false
// 	});
// }

// function verClave(ojo) {
// 	let input = ojo.parentElement.previousElementSibling;
// 	if (input.type == "password") {
// 		input.type    = "text";
// 		ojo.className = "icon-eye-slash";
// 	} else {
// 		input.type    = "password";
// 		ojo.className = "icon-eye";
// 	}
// }

// function modal(boton, formulario, overlay) {
// 	boton.addEventListener("click", e => {
// 		e.preventDefault();
// 		ventanaEmergente(formulario, overlay);
// 	});
// }

// function ventanaEmergente(formulario, overlay) {
// 	const cerrar = formulario.querySelector("span");
// 	overlay.classList.replace("w3-hide", "w3-show");
// 	overlay.style.cursor = "pointer";
// 	formulario.classList.replace("w3-hide", "w3-show");
// 	formulario.classList.replace("animate__fadeOutDown", "animate__fadeInUp");

// 	overlay.addEventListener("click", e => {
// 		e.target.classList.replace("w3-show", "w3-hide");
// 		formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
// 		setTimeout(() => formulario.classList.replace("w3-show", "w3-hide"), 500);
// 	});

// 	cerrar.addEventListener("click", e => {
// 		e.target.classList.replace("w3-show", "w3-hide");
// 		overlay.classList.replace("w3-show", "w3-hide");
// 		formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
// 		setTimeout(() => formulario.classList.replace("w3-show", "w3-hide"), 500);
// 	});
// }

// // Filter
// function filterFunction(input, div) {
// 	let filter, ul, li, a;
// 	div    = document.getElementById(div);
// 	input  = document.getElementById(input);
// 	filter = input.value.toUpperCase();
// 	a      = div.getElementsByTagName("button");
// 	for (let i = 0; i < a.length; i++) {
// 		let txtValue = a[i].textContent || a[i].innerText;
// 		if (txtValue.toUpperCase().indexOf(filter) > -1) {
// 			a[i].style.display = "";
// 		} else {
// 			a[i].style.display = "none";
// 		}
// 	}
// }