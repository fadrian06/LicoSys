function validar(form, label = false) {
	const formulario = document.querySelector(form);
	const inputs = document.querySelectorAll(`${form} input`);
	if (label) {
		const labels = document.querySelectorAll(`${form} label`);
		labels.forEach(function (label) {
			label.style = "background:var(--primario);color:black;outline:thin solid var(--negro)";
		})
	}
	form = form;

	var radios = [];
	let i = 0;
	inputs.forEach(function (input) {
		if (input.type == "radio") {
			radios[i] = input;
		}
		i++;
	})

	const expresiones = {
		usuario: /^[a-z]*[\w-]{4,20}$/i,
		clave: /^[\w.-@#/*]{4,20}$/i,
		nombre: /^[A-Z]{1}([a-z]{3,20})$/u,
		telefono: /^(0|\+57|\+58)(412|414|424|416|426)([0-9]){7,8}$/,
		cedula: /^[^e]?[0-9]{7,8}$/,
		pregunta: /^[a-z]+/i,
		respuesta: /^[a-z]+$/i,
		rif: /^[0-9]{8,15}$/,
		direccion: /^[a-z0-9\.\-\#\/]{4,50}$/i,
	}

	campos = {
		nombre: false,
		usuario: false,
		clave: false,
		negocio: false,
		telefono: false,
		nuevaClave: false,
		confirmar: false,
		pregunta: false,
		respuesta: false,
		rif: false,
		direccion: false,
	}

	function validarFormulario(e) {
		switch (e.target.name) {
			case "usuario":
				validarCampo(expresiones.usuario, e.target, 'usuario');
				break;
			case "clave":
				validarCampo(expresiones.clave, e.target, 'clave');
				break;
			case "nombre":
				validarCampo(expresiones.nombre, e.target, 'nombre');
				break;
			case "telefono":
				validarCampo(expresiones.telefono, e.target, 'telefono');
				break;
			case "cedula":
				validarCampo(expresiones.cedula, e.target, 'clave');
				break;
			case "rif":
				validarCampo(expresiones.rif, e.target, 'usuario');
				break;
			case "direccion":
				validarCampo(expresiones.direccion, e.target, 'clave');
				break;
			case "nuevaClave":
				validarCampo(expresiones.clave, e.target, 'clave');
				verificarNuevaClave("#clave", "#nuevaClave");
				compararClaves("#nuevaClave", "#confirmar");
				break;
			case "confirmar":
				validarCampo(expresiones.clave, e.target, 'clave')
				compararClaves("#nuevaClave", "#confirmar");
				break;
			case "pregunta1":
			case "pregunta2":
			case "pregunta3":
				validarCampo(expresiones.pregunta, e.target, "usuario");
				validarCampo(expresiones.pregunta, e.target, "pregunta");
				break;
			case "respuesta1":
			case "respuesta2":
			case "respuesta3":
				validarCampo(expresiones.respuesta, e.target, 'clave');
				validarCampo(expresiones.respuesta, e.target, 'respuesta');
				break;
		}
	}

	function verificarNuevaClave(clave1, clave2) {
		let $clave1 = document.querySelector(clave1);
		let $clave2 = document.querySelector(clave2);
		if ($clave1.value != $clave2.value) {
			$clave2.parentElement.style = "outline: thin solid var(--negro)";
			$clave2.classList.remove("incorrecto");
			$clave2.previousElementSibling.style = "background:var(--primario);color:black";
			campos.nuevaClave = true;
		} else {
			$clave2.parentElement.style = "outline: thick solid var(--error)";
			$clave2.classList.add("incorrecto");
			$clave2.previousElementSibling.style = "background:var(--error);color:white";
			campos.nuevaClave = false;
		}
	}

	function compararClaves(clave1, clave2) {
		let $clave1 = document.querySelector(clave1);
		let $clave2 = document.querySelector(clave2);
		if ($clave1.value == $clave2.value) {
			$clave2.parentElement.style = "outline: thin solid var(--negro)";
			$clave2.classList.remove("incorrecto");
			$clave2.previousElementSibling.style = "background:var(--primario);color:black";
			campos.confirmar = true;
		} else {
			$clave2.parentElement.style = "outline: thick solid var(--error)";
			$clave2.classList.add("incorrecto");
			$clave2.previousElementSibling.style = "background:var(--error);color:white";
			campos.confirmar = false;
		}
	}

	function validarCampo(expresion, input, campo) {
		if (expresion.test(input.value)) {
			input.parentElement.style = "outline: thin solid var(--negro)";
			input.classList.remove("incorrecto");
			input.previousElementSibling.style = "background:var(--primario);color:black";
			campos[campo] = true;
		} else {
			input.parentElement.style = "outline: thick solid var(--error)";
			input.classList.add("incorrecto");
			input.previousElementSibling.style = "background:var(--error);color:white";
			campos[campo] = false;
		}
	}

	inputs.forEach(function (input) {
		input.addEventListener('keyup', validarFormulario);
		input.addEventListener('blur', validarFormulario);
	})

	formulario.addEventListener('submit', function (e) {
		radios.forEach(function (radio) {
			if (radio.checked) campos.negocio = true;
		})

		if (!campos.negocio && form == "#formulario-login") {
			e.preventDefault();
			Swal.fire({
				title: 'Por favor seleccione un negocio',
				icon: 'error',
				toast: true,
				timer: 3000,
				timerProgressBar: true,
				position: 'bottom-end',
				showConfirmButton: false
			})
		}

		if (!campos.confirmar && (form == "#formulario-actualizar-clave" || form == "#formulario-clave")) {
			e.preventDefault();
			Swal.fire({
				title: 'Las contraseñas no coinciden',
				icon: 'error',
				toast: true,
				timer: 3000,
				timerProgressBar: true,
				position: 'bottom-end',
				showConfirmButton: false
			})
		}

		if (!campos.nuevaClave && form == "#formulario-actualizar-clave") {
			e.preventDefault();
			Swal.fire({
				title: 'La nueva contraseña no puede ser igual a la anterior',
				icon: 'error',
				toast: true,
				timer: 3000,
				timerProgressBar: true,
				position: 'bottom-end',
				showConfirmButton: false
			})
		}

		if (!campos.pregunta && form == "#formulario-actualizar-preguntas") {
			e.preventDefault();
			Swal.fire({
				title: 'Verifique que las preguntas estén bien escritas',
				icon: 'error',
				toast: true,
				timer: 3000,
				timerProgressBar: true,
				position: 'bottom-end',
				showConfirmButton: false
			})
		}

		if (!campos.respuesta && (form == "#formulario-actualizar-preguntas" || form == "#formulario-preguntas")) {
			e.preventDefault();
			Swal.fire({
				title: 'Verifique que las respuestas estén bien escritas',
				icon: 'error',
				toast: true,
				timer: 3000,
				timerProgressBar: true,
				position: 'bottom-end',
				showConfirmButton: false
			})
		}

		if (!campos.usuario && !campos.clave) {
			inputs.forEach(function (input) {
				if (input.type == "text" || input.type == "password") {
					input.parentElement.style = "outline: thick solid var(--error)";
					input.classList.add("incorrecto");
					input.previousElementSibling.style = "background:var(--error);color:white";
					Swal.fire({
						title: "Verifique los campos",
						icon: "error",
						toast: true,
						timer: 3000,
						timerProgressBar: true,
						position: "bottom-end",
						showConfirmButton: false
					})
				}

				if (!input.value) {
					Swal.fire({
						title: "Por favor rellene los campos",
						icon: "error",
						toast: true,
						timer: 3000,
						timerProgressBar: true,
						position: "bottom-end",
						showConfirmButton: false
					})
				}
			})

			e.preventDefault();
		}
	})
}