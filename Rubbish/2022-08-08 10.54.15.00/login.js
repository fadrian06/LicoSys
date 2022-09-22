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

if (document.querySelector("a.recuperarClave")) formularioModal("a.recuperarClave", "#formulario-recuperar");
if (document.querySelector("a#recuperarClave")) formularioModal("a#recuperarClave", "#formulario-recuperar");