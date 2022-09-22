validar("#formulario-actualizar", true);
validar("#formulario-actualizar-clave", true);
validar("#formulario-actualizar-preguntas", true);

document.querySelector("#botonSobre").addEventListener("click", function(){
	// Mostrar
	document.querySelector("#panelSobreMi").classList.add("w3-animate-opacity");
	document.querySelector("#panelSobreMi").classList.replace("w3-hide", "w3-show");
	document.querySelector("#sobreMi").classList.add("w3-animate-opacity");
	document.querySelector("#sobreMi").classList.replace("w3-hide", "w3-show");
	document.querySelector("#botonActualizar").classList.replace("w3-hide", "w3-show");
	// Ocultar
	document.querySelector("#formulario-actualizar").classList.replace("w3-show", "w3-hide");
	document.querySelector("#panelSeguridad").classList.remove("w3-animate-opacity");
	document.querySelector("#panelSeguridad").classList.replace("w3-show", "w3-hide");
	document.querySelector("#infoClave").classList.remove("w3-animate-opacity");
	document.querySelector("#infoClave").classList.replace("w3-show", "w3-hide");
	document.querySelector("#preguntas").classList.replace("w3-show", "w3-hide");
	document.querySelector("#botonActualizarClave").classList.replace("w3-show", "w3-hide");
	document.querySelector("#botonActualizarPreguntas").classList.replace("w3-show", "w3-hide");
	document.querySelector("#formulario-actualizar-clave").classList.replace("w3-show", "w3-hide");
	document.querySelector("#formulario-actualizar-preguntas").classList.replace("w3-show", "w3-hide");
})

document.querySelector("#botonSeguridad").addEventListener("click", function(){
	// Mostrar
	document.querySelector("#panelSeguridad").classList.add("w3-animate-opacity");
	document.querySelector("#panelSeguridad").classList.replace("w3-hide", "w3-show");
	document.querySelector("#infoClave").classList.add("w3-animate-opacity");
	document.querySelector("#infoClave").classList.replace("w3-hide", "w3-show");
	document.querySelector("#preguntas").classList.replace("w3-hide", "w3-show");
	document.querySelector("#botonActualizarClave").classList.replace("w3-hide", "w3-show");
	document.querySelector("#botonActualizarPreguntas").classList.replace("w3-hide", "w3-show");
	// Ocultar
	document.querySelector("#panelSobreMi").classList.remove("w3-animate-opacity");
	document.querySelector("#panelSobreMi").classList.replace("w3-show", "w3-hide");
	document.querySelector("#sobreMi").classList.remove("w3-animate-opacity");
	document.querySelector("#sobreMi").classList.replace("w3-show", "w3-hide");
	document.querySelector("#botonActualizar").classList.replace("w3-show", "w3-hide");
	document.querySelector("#formulario-actualizar").classList.replace("w3-show", "w3-hide");
	document.querySelector("#formulario-actualizar-clave").classList.replace("w3-show", "w3-hide");
	document.querySelector("#formulario-actualizar-preguntas").classList.replace("w3-show", "w3-hide");
})

document.querySelector("#botonActualizar").addEventListener("click", function(){
	// Mostrar
	document.querySelector("#formulario-actualizar").classList.add("w3-animate-opacity");
	document.querySelector("#formulario-actualizar").classList.replace("w3-hide", "w3-show");
	// Ocultar
	document.querySelector("#botonActualizar").classList.replace("w3-show", "w3-hide");
	document.querySelector("#sobreMi").classList.replace("w3-show", "w3-hide");
})

document.querySelector("#botonActualizarClave").addEventListener("click", function(){
	// Mostrar
	document.querySelector("#formulario-actualizar-clave").classList.add("w3-animate-opacity");
	document.querySelector("#formulario-actualizar-clave").classList.replace("w3-hide", "w3-show");
	// Ocultar
	document.querySelector("#botonActualizarClave").classList.replace("w3-show", "w3-hide");
	document.querySelector("#botonActualizarPreguntas").classList.replace("w3-show", "w3-hide");
	document.querySelector("#infoClave").classList.replace("w3-show", "w3-hide");
	document.querySelector("#preguntas").classList.replace("w3-show", "w3-hide");
})

document.querySelector("#botonActualizarPreguntas").addEventListener("click", function(){
	// Mostrar
	document.querySelector("#formulario-actualizar-preguntas").classList.add("w3-animate-opacity");
	document.querySelector("#formulario-actualizar-preguntas").classList.replace("w3-hide", "w3-show");
	// Ocultar
	document.querySelector("#botonActualizarClave").classList.replace("w3-show", "w3-hide");
	document.querySelector("#botonActualizarPreguntas").classList.replace("w3-show", "w3-hide");
	document.querySelector("#infoClave").classList.replace("w3-show", "w3-hide");
	document.querySelector("#preguntas").classList.replace("w3-show", "w3-hide");
})