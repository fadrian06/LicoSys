if (document.querySelector("#formulario-actualizar")) validar("#formulario-actualizar", true);
if (document.querySelector("#formulario-actualizar-clave")) validar("#formulario-actualizar-clave", true);
if (document.querySelector("#formulario-actualizar-preguntas")) validar("#formulario-actualizar-preguntas", true);

if (document.querySelector("#miPerfil")) {
	document.querySelector("#botonSobre").addEventListener("click", function () {
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

	document.querySelector("#botonSeguridad").addEventListener("click", function () {
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

	document.querySelector("#botonActualizar").addEventListener("click", function () {
		// Mostrar
		document.querySelector("#formulario-actualizar").classList.add("w3-animate-opacity");
		document.querySelector("#formulario-actualizar").classList.replace("w3-hide", "w3-show");
		// Ocultar
		document.querySelector("#botonActualizar").classList.replace("w3-show", "w3-hide");
		document.querySelector("#sobreMi").classList.replace("w3-show", "w3-hide");
	})

	document.querySelector("#botonActualizarClave").addEventListener("click", function () {
		// Mostrar
		document.querySelector("#formulario-actualizar-clave").classList.add("w3-animate-opacity");
		document.querySelector("#formulario-actualizar-clave").classList.replace("w3-hide", "w3-show");
		// Ocultar
		document.querySelector("#botonActualizarClave").classList.replace("w3-show", "w3-hide");
		document.querySelector("#botonActualizarPreguntas").classList.replace("w3-show", "w3-hide");
		document.querySelector("#infoClave").classList.replace("w3-show", "w3-hide");
		document.querySelector("#preguntas").classList.replace("w3-show", "w3-hide");
	})

	document.querySelector("#botonActualizarPreguntas").addEventListener("click", function () {
		// Mostrar
		document.querySelector("#formulario-actualizar-preguntas").classList.add("w3-animate-opacity");
		document.querySelector("#formulario-actualizar-preguntas").classList.replace("w3-hide", "w3-show");
		// Ocultar
		document.querySelector("#botonActualizarClave").classList.replace("w3-show", "w3-hide");
		document.querySelector("#botonActualizarPreguntas").classList.replace("w3-show", "w3-hide");
		document.querySelector("#infoClave").classList.replace("w3-show", "w3-hide");
		document.querySelector("#preguntas").classList.replace("w3-show", "w3-hide");
	})
}

if (document.querySelectorAll(".botonNegocio")) {
	const $botonesNegocios = document.querySelectorAll(".botonNegocio");
	const $panelesNegocios = document.querySelectorAll(".panelNegocio");
	const $panelesInfoNegocios = document.querySelectorAll(".panelInfoNegocio");
	const $formulariosNegocios = document.querySelectorAll(".formularioActualizarNegocio");
	const $botonesActualizar = document.querySelectorAll(".botonActualizarNegocio");
	$botonesNegocios.forEach(function (boton) {
		const idNegocio = boton.id.substring(12);
		boton.addEventListener("click", function () {
			$panelesNegocios.forEach(function (panelNegocio) {
				panelNegocio.classList.replace("w3-show", "w3-hide");
			})
			$formulariosNegocios.forEach(function (formulario) {
				validar(`#${formulario.id}`, true);
				formulario.classList.replace("w3-show", "w3-hide");
				formulario.previousElementSibling.classList.replace("w3-hide", "w3-show");
				formulario.previousElementSibling.previousElementSibling.classList.replace("w3-hide", "w3-show");
			})
			document.querySelector(`#panelNegocio${idNegocio}`).classList.replace("w3-hide", "w3-show");
		})
		$botonesActualizar.forEach(function (botonActualizar) {
			botonActualizar.addEventListener("click", function () {
				botonActualizar.parentElement.previousElementSibling.classList.replace("w3-show", "w3-hide");
				botonActualizar.parentElement.nextElementSibling.classList.replace("w3-hide", "w3-show");
				botonActualizar.parentElement.classList.replace("w3-show", "w3-hide");
			})
		})
	})
}

if(document.querySelector("#formularioRegistrarNegocio")){
	formularioModal("#botonAgregarNegocio", "#formularioRegistrarNegocio", "div.overlayModal");
	validar("#formularioRegistrarNegocio");
}

if(document.querySelector("#modalRegistroCambios")){
	formularioModal("#registroCambios", "#modalRegistroCambios", "div.overlayModal");
}

if(document.querySelector("#modalSoporteTecnico")){
	formularioModal("#soporteTecnico", "#modalSoporteTecnico", "div.overlayModal");
}

if(document.querySelector("#modalAcercaDe")){
	formularioModal("#acercaDeSistema", "#modalAcercaDe", "div.overlayModal");
}

if(document.querySelector("#modalManual")){
	formularioModal("#manualUsuario", "#modalManual", "div.overlayModal");
}

if(document.querySelector("#formularioRegistrarProducto")){
	formularioModal("#registrarProducto", "#formularioRegistrarProducto", "div.overlayModal");
	validar("#formularioRegistrarProducto");
}