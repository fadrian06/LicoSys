validar('#formulario-login');
validar("#formulario-recuperar");
if (document.querySelector("#formulario-preguntas")) {
	validar("#formulario-preguntas");
	mostrarFormulario("#formulario-preguntas");
	cerrarFormulario("#formulario-preguntas");
}

if (document.querySelector("#formulario-clave")) {
	validar("#formulario-clave");
	mostrarFormulario("#formulario-clave");
	cerrarFormulario("#formulario-clave");
}

if (document.querySelector("a.recuperarClave")) recuperarClave("a.recuperarClave", "#formulario-recuperar");
if (document.querySelector("a#recuperarClave")) recuperarClave("a#recuperarClave", "#formulario-recuperar");

function recuperarClave(boton, formulario) {
	document.querySelector(boton).addEventListener("click", function (e) {
		e.preventDefault();
		mostrarFormulario(formulario);
		cerrarFormulario(formulario);
	})
}

function cerrarFormulario(formulario) {
	$X = document.querySelector(`${formulario}>span`);
	$formulario = document.querySelector(formulario);
	$X.addEventListener("click", function (e) {
		this.classList.replace("w3-show", "w3-hide");
		$overlay.classList.replace("w3-show", "w3-hide");
		$formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
		setTimeout(function () {
			$formulario.classList.replace("w3-show", "w3-hide");
		}, 500);
	})
}

function mostrarFormulario(formulario) {
	$overlay = document.querySelector("div.w3-overlay");
	$formulario = document.querySelector(formulario);
	$overlay.classList.replace("w3-hide", "w3-show");
	$overlay.style.cursor = "pointer";
	$formulario.classList.replace("w3-hide", "w3-show");
	$formulario.classList.replace("animate__fadeOutDown", "animate__fadeInUp");

	$overlay.addEventListener("click", function () {
		this.classList.replace("w3-show", "w3-hide");
		$formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
		setTimeout(function () {
			$formulario.classList.replace("w3-show", "w3-hide");
		}, 500);
	})
}