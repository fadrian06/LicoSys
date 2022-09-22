validar('#formulario-login');
validar("#formulario-recuperar");
if (document.querySelector("#formulario-preguntas")) {
	validar("#formulario-preguntas");
	mostrarFormulario("#formulario-preguntas", "div.w3-overlay");
}

if (document.querySelector("#formulario-clave")) {
	validar("#formulario-clave");
	mostrarFormulario("#formulario-clave", "div.w3-overlay");
}

if (document.querySelector("a.recuperarClave")) formularioModal("a.recuperarClave", "#formulario-recuperar", "div.w3-overlay");
if (document.querySelector("a#recuperarClave")) formularioModal("a#recuperarClave", "#formulario-recuperar", "div.w3-overlay");