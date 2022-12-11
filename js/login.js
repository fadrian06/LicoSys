"use strict";

var overlay = document.querySelector(".w3-overlay");
var formNegocio = document.querySelector("#formNegocio");
var formAdmin = document.querySelector("#formAdmin");
var formLogin = document.querySelector("#formLogin");
var formRecuperar = document.querySelector("#formConsulta");
var formPreguntas = document.querySelector("#formPreguntas");
var formClave = document.querySelector("#formClave");
var enlace = document.querySelector("a.recuperarClave");
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