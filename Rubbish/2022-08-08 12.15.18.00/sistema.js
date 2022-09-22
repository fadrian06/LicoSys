const overlay     = w3.getElement("#modalOverlay");
/*============================
=            MENU            =
============================*/
const menuOverlay = w3.getElement("#menuOverlay");
const barras      = w3.getElement("#barras");
const sidebar     = w3.getElement("#mySidebar");

menu(barras, sidebar, menuOverlay);

/*=================================
=            MI PERFIL            =
=================================*/
if(w3.getElement("#miPerfil")){
	var formDatosPerfil = w3.getElement("#formulario-actualizar");
	var formActualizarClave     = w3.getElement("#formulario-actualizar-clave");
	var formActualizarPreguntas = w3.getElement("#formulario-actualizar-preguntas");
	const botonSobreMi   = w3.getElement("#botonSobre");
	const botonSeguridad = w3.getElement("#botonSeguridad");
	const botonActualizarDatos     = w3.getElement("#botonActualizar");
	const botonActualizarClave     = w3.getElement("#botonActualizarClave");
	const botonActualizarPreguntas = w3.getElement("#botonActualizarPreguntas");
	const panelSobreMi   = w3.getElement("#panelSobreMi");
	const sobreMi        = w3.getElement("#sobreMi");
	const panelSeguridad = w3.getElement("#panelSeguridad");
	const infoClave      = w3.getElement("#infoClave");
	const preguntas      = w3.getElement("#preguntas");

	validar(formDatosPerfil);
	validar(formActualizarClave);
	validar(formActualizarPreguntas);
	actualizarFoto();

	botonSobreMi.addEventListener("click", () => {
		// Mostrar
		panelSobreMi.classList.add("w3-animate-opacity");
		panelSobreMi.classList.replace("w3-hide", "w3-show");
		sobreMi.classList.add("w3-animate-opacity");
		sobreMi.classList.replace("w3-hide", "w3-show");
		botonActualizarDatos.classList.replace("w3-hide", "w3-show");
		// Ocultar
		formDatosPerfil.classList.replace("w3-show", "w3-hide");
		panelSeguridad.classList.remove("w3-animate-opacity");
		panelSeguridad.classList.replace("w3-show", "w3-hide");
		infoClave.classList.remove("w3-animate-opacity");
		infoClave.classList.replace("w3-show", "w3-hide");
		preguntas.classList.replace("w3-show", "w3-hide");
		botonActualizarClave.classList.replace("w3-show", "w3-hide");
		botonActualizarPreguntas.classList.replace("w3-show", "w3-hide");
		formActualizarClave.classList.replace("w3-show", "w3-hide");
		formActualizarPreguntas.classList.replace("w3-show", "w3-hide");
	})

	botonSeguridad.addEventListener("click", function () {
		// Mostrar
		panelSeguridad.classList.add("w3-animate-opacity");
		panelSeguridad.classList.replace("w3-hide", "w3-show");
		infoClave.classList.add("w3-animate-opacity");
		infoClave.classList.replace("w3-hide", "w3-show");
		preguntas.classList.replace("w3-hide", "w3-show");
		botonActualizarClave.classList.replace("w3-hide", "w3-show");
		botonActualizarPreguntas.classList.replace("w3-hide", "w3-show");
		// Ocultar
		panelSobreMi.classList.remove("w3-animate-opacity");
		panelSobreMi.classList.replace("w3-show", "w3-hide");
		sobreMi.classList.remove("w3-animate-opacity");
		sobreMi.classList.replace("w3-show", "w3-hide");
		botonActualizarDatos.classList.replace("w3-show", "w3-hide");
		formDatosPerfil.classList.replace("w3-show", "w3-hide");
		formActualizarClave.classList.replace("w3-show", "w3-hide");
		formActualizarPreguntas.classList.replace("w3-show", "w3-hide");
	})

	botonActualizarDatos.addEventListener("click", function () {
		// Mostrar
		formDatosPerfil.classList.add("w3-animate-opacity");
		formDatosPerfil.classList.replace("w3-hide", "w3-show");
		// Ocultar
		botonActualizarDatos.classList.replace("w3-show", "w3-hide");
		sobreMi.classList.replace("w3-show", "w3-hide");
	})

	botonActualizarClave.addEventListener("click", function () {
		// Mostrar
		formActualizarClave.classList.add("w3-animate-opacity");
		formActualizarClave.classList.replace("w3-hide", "w3-show");
		// Ocultar
		botonActualizarClave.classList.replace("w3-show", "w3-hide");
		botonActualizarPreguntas.classList.replace("w3-show", "w3-hide");
		infoClave.classList.replace("w3-show", "w3-hide");
		preguntas.classList.replace("w3-show", "w3-hide");
	})

	botonActualizarPreguntas.addEventListener("click", function () {
		// Mostrar
		formActualizarPreguntas.classList.add("w3-animate-opacity");
		formActualizarPreguntas.classList.replace("w3-hide", "w3-show");
		// Ocultar
		botonActualizarClave.classList.replace("w3-show", "w3-hide");
		botonActualizarPreguntas.classList.replace("w3-show", "w3-hide");
		infoClave.classList.replace("w3-show", "w3-hide");
		preguntas.classList.replace("w3-show", "w3-hide");
	})
}

/*================================
=            NEGOCIOS            =
================================*/
if(w3.getElement("#negocios")){
	const $botonesNegocios      = w3.getElements(".botonNegocio");
	const botonRegistrarNegocio = w3.getElement("#botonAgregarNegocio");
	const $panelesNegocios      = w3.getElements(".panelNegocio");
	const $panelesInfoNegocios  = w3.getElements(".panelInfoNegocio");
	const $formulariosNegocios  = w3.getElements(".formularioActualizarNegocio");
	const $botonesActualizar    = w3.getElements(".botonActualizarNegocio");
	const formRegistrarNegocio  = w3.getElement("#formulario-registrarNegocio");

	validar(formRegistrarNegocio);
	modal(botonRegistrosNegocio, formRegistrarNegocio, overlay);

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

/*=====================================
=            MODALES INDEX            =
=====================================*/
if(w3.getElement("#index")){
	const enlaceRegistroCambios = w3.getElement("#registroCambios");
	const enlaceSoporteTecnico  = w3.getElement("#soporteTecnico");
	const enlaceAcercaDe        = w3.getElement("#acercaDeSistema");
	const enlaceManual          = w3.getElement("#manualUsuario");
	const modalRegistroCambios  = w3.getElement("#modalRegistroCambios");
	const modalSoporteTecnico   = w3.getElement("#modalSoporteTecnico");
	const modalAcercaDe         = w3.getElement("#modalAcercaDe");
	const modalManual           = w3.getElement("#modalManual");

	modal(enlaceRegistroCambios, modalRegistroCambios, overlay);
	modal(enlaceSoporteTecnico, modalSoporteTecnico, overlay);
	modal(enlaceAcercaDe, modalAcercaDe, overlay);
	modal(enlaceManual, modalManual, overlay);
}

/*========================================
=            MODALES REGISTRO            =
========================================*/
if(w3.getElement("#formularioRegistrarProducto")){
	var botonRegistrarProducto = w3.getElement("#registrarProducto");
	var modalRegistroProducto = w3.getElement("#formularioRegistrarProducto");
	modal(botonRegistrarProducto, modalRegistroProducto, overlay);
	validar(modalRegistroProducto);
}

if(w3.getElement("#formularioRegistrarCliente")){
	var botonRegistrarCliente = w3.getElement("#registrarCliente");
	var modalRegistroCliente = w3.getElement("#formularioRegistrarCliente");
	modal(botonRegistrarCliente, modalRegistroCliente, overlay);
	validar(modalRegistroCliente);
}

if(w3.getElement("#formularioRegistrarProveedor")){
	var botonRegistrarProveedor = w3.getElement("#registrarProveedor");
	var modalRegistroProveedor = w3.getElement("#formularioRegistrarProveedor");
	modal(botonRegistrarProveedor, modalRegistroProveedor, overlay);
	validar(modalRegistroProveedor);
}

if(w3.getElement("#formularioRegistrarUsuario")){
	var botonRegistrarUsuario = w3.getElement("#registrarUsuario");
	var modalRegistroUsuario = w3.getElement("#formularioRegistrarUsuario");
	modal(botonRegistrarUsuario, modalRegistroUsuario, overlay);
	validar(modalRegistroUsuario);
}

/*===================================
=            NUEVA VENTA            =
===================================*/
if(w3.getElement("#panelNuevaVenta")){
	var botonRegistrarCliente = w3.getElement("#agregarCliente");
	
}