"use strict";

var overlay = w3.getElement("#modalOverlay");
/*============================
=            MENU            =
============================*/

var menuOverlay = w3.getElement("#menuOverlay");
var barras = w3.getElement("#barras");
var sidebar = w3.getElement("#mySidebar");
menu(barras, sidebar, menuOverlay);
/*=================================
=            MI PERFIL            =
=================================*/

if (w3.getElement("#miPerfil")) {
  var formDatosPerfil = w3.getElement("#formulario-actualizar");
  var formActualizarClave = w3.getElement("#formulario-actualizar-clave");
  var formActualizarPreguntas = w3.getElement("#formulario-actualizar-preguntas");
  var botonSobreMi = w3.getElement("#botonSobre");
  var botonSeguridad = w3.getElement("#botonSeguridad");
  var botonActualizarDatos = w3.getElement("#botonActualizar");
  var botonActualizarClave = w3.getElement("#botonActualizarClave");
  var botonActualizarPreguntas = w3.getElement("#botonActualizarPreguntas");
  var panelSobreMi = w3.getElement("#panelSobreMi");
  var sobreMi = w3.getElement("#sobreMi");
  var panelSeguridad = w3.getElement("#panelSeguridad");
  var infoClave = w3.getElement("#infoClave");
  var preguntas = w3.getElement("#preguntas");
  validar(formDatosPerfil);
  validar(formActualizarClave);
  validar(formActualizarPreguntas);
  actualizarFoto();
  botonSobreMi.addEventListener("click", function () {
    // Mostrar
    panelSobreMi.classList.add("w3-animate-opacity");
    panelSobreMi.classList.replace("w3-hide", "w3-show");
    sobreMi.classList.add("w3-animate-opacity");
    sobreMi.classList.replace("w3-hide", "w3-show");
    botonActualizarDatos.classList.replace("w3-hide", "w3-show"); // Ocultar

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
  });
  botonSeguridad.addEventListener("click", function () {
    // Mostrar
    panelSeguridad.classList.add("w3-animate-opacity");
    panelSeguridad.classList.replace("w3-hide", "w3-show");
    infoClave.classList.add("w3-animate-opacity");
    infoClave.classList.replace("w3-hide", "w3-show");
    preguntas.classList.replace("w3-hide", "w3-show");
    botonActualizarClave.classList.replace("w3-hide", "w3-show");
    botonActualizarPreguntas.classList.replace("w3-hide", "w3-show"); // Ocultar

    panelSobreMi.classList.remove("w3-animate-opacity");
    panelSobreMi.classList.replace("w3-show", "w3-hide");
    sobreMi.classList.remove("w3-animate-opacity");
    sobreMi.classList.replace("w3-show", "w3-hide");
    botonActualizarDatos.classList.replace("w3-show", "w3-hide");
    formDatosPerfil.classList.replace("w3-show", "w3-hide");
    formActualizarClave.classList.replace("w3-show", "w3-hide");
    formActualizarPreguntas.classList.replace("w3-show", "w3-hide");
  });
  botonActualizarDatos.addEventListener("click", function () {
    // Mostrar
    formDatosPerfil.classList.add("w3-animate-opacity");
    formDatosPerfil.classList.replace("w3-hide", "w3-show"); // Ocultar

    botonActualizarDatos.classList.replace("w3-show", "w3-hide");
    sobreMi.classList.replace("w3-show", "w3-hide");
  });
  botonActualizarClave.addEventListener("click", function () {
    // Mostrar
    formActualizarClave.classList.add("w3-animate-opacity");
    formActualizarClave.classList.replace("w3-hide", "w3-show"); // Ocultar

    botonActualizarClave.classList.replace("w3-show", "w3-hide");
    botonActualizarPreguntas.classList.replace("w3-show", "w3-hide");
    infoClave.classList.replace("w3-show", "w3-hide");
    preguntas.classList.replace("w3-show", "w3-hide");
  });
  botonActualizarPreguntas.addEventListener("click", function () {
    // Mostrar
    formActualizarPreguntas.classList.add("w3-animate-opacity");
    formActualizarPreguntas.classList.replace("w3-hide", "w3-show"); // Ocultar

    botonActualizarClave.classList.replace("w3-show", "w3-hide");
    botonActualizarPreguntas.classList.replace("w3-show", "w3-hide");
    infoClave.classList.replace("w3-show", "w3-hide");
    preguntas.classList.replace("w3-show", "w3-hide");
  });
}
/*================================
=            NEGOCIOS            =
================================*/


if (w3.getElement("#negocios")) {
  var $botonesNegocios = w3.getElements(".botonNegocio");
  var botonRegistrarNegocio = w3.getElement("#botonAgregarNegocio");
  var $panelesNegocios = w3.getElements(".panelNegocio");
  var $panelesInfoNegocios = w3.getElements(".panelInfoNegocio");
  var $formulariosNegocios = w3.getElements(".formularioActualizarNegocio");
  var $botonesActualizar = w3.getElements(".botonActualizarNegocio");
  var formRegistrarNegocio = w3.getElement("#formulario-registrarNegocio");
  validar(formRegistrarNegocio);
  modal(botonRegistrosNegocio, formRegistrarNegocio, overlay);
  $botonesNegocios.forEach(function (boton) {
    var idNegocio = boton.id.substring(12);
    boton.addEventListener("click", function () {
      $panelesNegocios.forEach(function (panelNegocio) {
        panelNegocio.classList.replace("w3-show", "w3-hide");
      });
      $formulariosNegocios.forEach(function (formulario) {
        validar("#".concat(formulario.id), true);
        formulario.classList.replace("w3-show", "w3-hide");
        formulario.previousElementSibling.classList.replace("w3-hide", "w3-show");
        formulario.previousElementSibling.previousElementSibling.classList.replace("w3-hide", "w3-show");
      });
      document.querySelector("#panelNegocio".concat(idNegocio)).classList.replace("w3-hide", "w3-show");
    });
    $botonesActualizar.forEach(function (botonActualizar) {
      botonActualizar.addEventListener("click", function () {
        botonActualizar.parentElement.previousElementSibling.classList.replace("w3-show", "w3-hide");
        botonActualizar.parentElement.nextElementSibling.classList.replace("w3-hide", "w3-show");
        botonActualizar.parentElement.classList.replace("w3-show", "w3-hide");
      });
    });
  });
}
/*=====================================
=            MODALES INDEX            =
=====================================*/


if (w3.getElement("#index")) {
  var enlaceRegistroCambios = w3.getElement("#registroCambios");
  var enlaceSoporteTecnico = w3.getElement("#soporteTecnico");
  var enlaceAcercaDe = w3.getElement("#acercaDeSistema");
  var enlaceManual = w3.getElement("#manualUsuario");
  var modalRegistroCambios = w3.getElement("#modalRegistroCambios");
  var modalSoporteTecnico = w3.getElement("#modalSoporteTecnico");
  var modalAcercaDe = w3.getElement("#modalAcercaDe");
  var modalManual = w3.getElement("#modalManual");
  modal(enlaceRegistroCambios, modalRegistroCambios, overlay);
  modal(enlaceSoporteTecnico, modalSoporteTecnico, overlay);
  modal(enlaceAcercaDe, modalAcercaDe, overlay);
  modal(enlaceManual, modalManual, overlay);
}
/*========================================
=            MODALES REGISTRO            =
========================================*/


if (document.querySelector("#formularioRegistrarProducto")) {
  formularioModal("#registrarProducto", "#formularioRegistrarProducto", "div.overlayModal");
  validar("#formularioRegistrarProducto");
}

if (document.querySelector("#formularioRegistrarCliente")) {
  formularioModal("#registrarCliente", "#formularioRegistrarCliente", "div.overlayModal");
  validar("#formularioRegistrarCliente");
}

if (document.querySelector("#formularioRegistrarProveedor")) {
  formularioModal("#registrarProveedor", "#formularioRegistrarProveedor", "div.overlayModal");
}

if (document.querySelector("#formularioRegistrarUsuario")) {
  formularioModal("#registrarUsuario", "#formularioRegistrarUsuario", "div.overlayModal");
  validar("#formularioRegistrarUsuario");
}