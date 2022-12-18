"use strict";

/**
 * @typedef {object} Respuesta Respuesta del servidor
 * @property {string} Respuesta.error Errores que lanza el servidor.
 * @property {object} Respuesta.datos Objeto con datos de la posible consulta.
 * @typedef {string} RespuestaCruda Respuesta serializada `"{error: string, datos: {}}"`
 * @typedef {import('../../libs/noty/index').*} Noty
 * @typedef {import('../../libs/jquery.min.js').*} $
 * @typedef {import('../../libs/typedjs/index').*} Typed
 * @typedef {import('../../libs/w3/w3.min').*} w3
 * @typedef {import('./validar')}
 * @typedef {import('./actualizarImagen')}
 * @typedef {import('./reloj')}
 */

Noty.overrideDefaults({
  theme: 'sunset'
});

/**
 * Define el comportamiento de un menú lateral.
 * @param  {HTMLElement} boton Botón que activa el menú, puede ser `<button>` o `<à>`
 * @param  {HTMLElement} menu Contenedor del menú.
 * @param  {HTMLDivElement} overlay Elemento que opaca el fondo.
 */
var menu = function menu(boton, _menu, overlay) {
  boton.onclick = function () {
    overlay.classList.remove('w3-hide');
    overlay.classList.add('w3-show');
    overlay.style.cursor = 'pointer';
    _menu.classList.remove('w3-hide', 'animate__animated');
    _menu.classList.remove('animate__slideOutLeft', 'animate__faster');
    _menu.classList.add('w3-show', 'w3-animate-left');
  };
  overlay.onclick = function () {
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
    _menu.classList.remove('w3-animate-left');
    _menu.classList.add('animate__animated', 'animate__slideOutLeft');
    _menu.classList.add('animate__faster');
    setTimeout(function () {
      _menu.classList.remove('w3-show');
      _menu.classList.add('w3-hide');
    }, 500);
  };
};

/**
 * Muestra el modal :V
 * @param  {HTMLElement} modal Contenedor del modal.
 * @param  {HTMLDivElement} overlay Elemento que opaca el fondo.
 * @param {()} [callback] Función adicional a ejecutar al cerrar el modal. 
 */
var mostrarModal = function mostrarModal(modal, overlay) {
  var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : function () {};
  /** @type {HTMLSpanElement} */
  var cerrar = modal.querySelector('.icon-close');
  overlay.classList.remove('w3-hide');
  overlay.classList.add('w3-show');
  overlay.style.cursor = 'pointer';
  overlay.style.zIndex = '999';
  modal.style.paddingTop = '0';
  modal.style.paddingRight = '0';
  modal.style.paddingLeft = '0';
  modal.classList.remove('w3-hide');
  modal.classList.add('w3-show');
  modal.classList.remove('animate__fadeOutDown');
  modal.classList.add('animate__fadeInUp');
  overlay.onclick = function () {
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
    modal.classList.remove('animate__fadeInUp');
    modal.classList.add('animate__fadeOutDown');
    setTimeout(function () {
      modal.classList.remove('w3-show');
      modal.classList.add('w3-hide');
    }, 500);
    callback();
  };
  cerrar.onclick = function () {
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
    modal.classList.remove('animate__fadeInUp');
    modal.classList.add('animate__fadeOutDown');
    setTimeout(function () {
      modal.classList.remove('w3-show');
      modal.classList.add('w3-hide');
    }, 500);
    callback();
  };
};

/**
 * Define el comportamiento de un modal.
 * @param  {HTMLElement} boton Un element `<button>` o `<a>`
 * @param  {HTMLElement} modal El contenedor del modal.
 * @param  {HTMLDivElement} overlay El elemento que opaca el fondo.
 */
var modal = function modal(boton, _modal, overlay) {
  boton.onclick = function (e) {
    e.preventDefault();
    mostrarModal(_modal, overlay);
  };
};

/**
 * Opaca el fondo y muestra el loader.
 * @param  {HTMLDivElement} overlay Elemento `<div>` que opaca el fondo.
 * @param  {HTMLFormElement} form Formulario contenedor de algún elemento con `id='loader'`
 */
var mostrarLoader = function mostrarLoader(overlay, form) {
  overlay.style.zIndex = '999';
  overlay.classList.remove('w3-hide');
  overlay.classList.add('w3-show');
  form.classList.add('showLoader');
};

/**
 * Quita el fondo opaco y el loader.
 * @param  {HTMLDivElement} overlay Elemento `<div>` que opaca el fondo.
 * @param  {HTMLFormElement} form    Formulario contenedor de algún elemento con `id='loader'`
 */
var ocultarLoader = function ocultarLoader(overlay, form) {
  overlay.classList.remove('w3-show');
  overlay.classList.add('w3-hide');
  form.classList.remove('showLoader');
};

/**
 * Realiza una petición POST
 * @param  {string} url     Ruta relativa al fichero PHP
 * @param  {FormData} data    Datos a enviar.
 * @param  {(res: RespuestaCruda)} success Una función que recibe la respuesta del servidor.
 */
var ajax = function ajax(url, data, success) {
  $.ajax({
    url: url,
    type: 'POST',
    data: data,
    contentType: false,
    processData: false,
    success: success
  });
};

/**
 * Muestra u oculta la contraseña
 * @param  {HTMLElement} ojo El ícono
 * @param {HTMLInputElement} input `<input type="password">`
 */
var verClave = function verClave(ojo, input) {
  ojo.onclick = function () {
    if (input.type === 'password') {
      input.type = 'text';
      ojo.classList.remove('icon-eye');
      ojo.classList.add('icon-eye-slash');
      return;
    }
    input.type = 'password';
    ojo.classList.remove('icon-eye-slash');
    ojo.classList.add('icon-eye');
  };
};

/**
 * Muestra un diálogo de confirmación.
 * @param  {HTMLDivElement}   overlay  Elemento que opaca el fondo.
 * @param  {string}   texto    Título de la ventana emergente.
 * @param  {Noty.Layout}   [posicion] Default: 'center'
 * @param  {(e: Event)} callback Función que se ejecuta al confirmar.
 * @return {Noty} Retorna un objeto Noty activado por defecto.
 */
var confirmar = function confirmar(overlay, texto) {
  var posicion = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'center';
  var callback = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : function () {};
  overlay.style.zIndex = '999';
  overlay.classList.remove('w3-hide');
  overlay.classList.add('w3-show');
  var html = "\n\t\t<div class=\"w3-white w3-round-xlarge w3-padding w3-center w3-border\" style=\"z-index: 1000\">\n\t\t\t<div class=\"animate__animated animate__flip animate__infinite icon-question w3-xxxlarge\"></div>\n\t\t\t<h2 class=\"w3-large w3-margin-bottom\">\n\t\t\t\t<strong>".concat(texto, "</strong>\n\t\t\t</h2>\n\t\t\t<div class=\"w3-center w3-padding w3-margin-top\">\n\t\t\t\t<button id=\"confirmar\" class=\"w3-button w3-round-xlarge w3-blue\">S\xED</button>\n\t\t\t\t<button id=\"cancelar\" class=\"w3-button w3-round-xlarge w3-red\">No</button>\n\t\t\t</div>\n\t\t</div>\n\t");
  return new Noty({
    id: 'confirmacion',
    theme: null,
    text: html,
    layout: posicion,
    closeWith: ['button'],
    callbacks: {
      onShow: function onShow() {
        $('.noty_close_button').on('click', function () {
          overlay.classList.remove('w3-show');
          overlay.classList.add('w3-hide');
        });
        $('#confirmar').on('click', function (e) {
          return callback(e);
        });
        $('#cancelar').on('click', function () {
          $('#confirmacion .noty_close_button')[0].click();
          overlay.classList.remove('w3-show');
          overlay.classList.add('w3-hide');
        });
      }
    }
  }).show();
};

/**
 * Muestra una alerta :V
 * @param  {string} texto Texto de la alerta.
 * @param {number} timer Milisegundos que deben pasar para ocultar la alerta.
 */
var alerta = function alerta(texto) {
  var timer = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2000;
  return new Noty({
    text: "<i class=\"icon-close w3-margin-right\"></i> ".concat(texto),
    type: 'error',
    timeout: timer
  });
};

/**
 * @param  {string} texto
 */
var notificacion = function notificacion(texto) {
  return new Noty({
    text: "<i class=\"icon-check w3-margin-right\"></i> ".concat(texto),
    type: 'success',
    timeout: 3000
  });
};

/**
 * @param  {string} texto
 */
var advertencia = function advertencia(texto) {
  return new Noty({
    text: "<i class=\"icon-warning w3-margin-right\"></i> ".concat(texto),
    type: 'warning',
    timeout: 3000
  });
};
onoffline = function onoffline() {
  return advertencia('Se ha perdido la conexión').show();
};
ononline = function ononline() {
  return notificacion('Se ha restablecido la conexión').show();
};

// // Filter
// function filterFunction(input, div) {
// 	let filter, ul, li, a;
// 	div    = document.getElementById(div);
// 	input  = document.getElementById(input);
// 	filter = input.value.toUpperCase();
// 	a      = div.getElementsByTagName("button");
// 	for (let i = 0; i < a.length; i++) {
// 		let txtValue = a[i].textContent || a[i].innerText;
// 		if (txtValue.toUpperCase().indexOf(filter) > -1) {
// 			a[i].style.display = "";
// 		} else {
// 			a[i].style.display = "none";
// 		}
// 	}
// }