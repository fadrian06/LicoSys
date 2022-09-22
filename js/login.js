"use strict";

var overlay = w3.getElement(".w3-overlay");
var formNegocio = w3.getElement("#formNegocio");
var formAdmin = w3.getElement("#formAdmin");
var formLogin = w3.getElement("#formLogin");
var formRecuperar = w3.getElement("#formConsulta");
var formPreguntas = w3.getElement("#formPreguntas");
var formClave = w3.getElement("#formClave");
var enlace = w3.getElement("a.recuperarClave");

if (formNegocio) {
  validar(formNegocio);
  ventanaEmergente(formNegocio, overlay);
  actualizarFoto();
}

if (formAdmin) {
  validar(formAdmin);
  ventanaEmergente(formAdmin, overlay);
}

if (formLogin) {
  validar(formLogin);
  validar(formRecuperar);
  modal(enlace, formRecuperar, overlay);
  var contenedorReloj = w3.getElement(".widget");
  reloj(contenedorReloj);
  setInterval(function () {
    return reloj(contenedorReloj);
  }, 1000 * 60);

  if (formPreguntas) {
    validar(formPreguntas);
    ventanaEmergente(formPreguntas, overlay);
  }

  if (formClave) {
    validar(formClave);
    ventanaEmergente(formClave, overlay);
  }
}