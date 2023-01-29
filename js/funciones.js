"use strict";

//@ts-nocheck
/**
 * @typedef {object} Respuesta Respuesta del servidor
 * @property {string} Respuesta.ok El mensaje de éxito.
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
 * Comportamiento de un acordión de filas en una tabla. <br>
 * <u>Requisitos</u>
 * <ul>
 *  <li>Cada acordeón debe tener el atributo `role="accordion`</li>
 *  <li>Cada acordeón debe tener un botón que sirva para abrir y cerrar</li>
 *  <li>Cada acordeón debe tener una flecha que indique su estado</li>
 * </ul>
 */
var acordeon = function acordeon() {
  var acordeones = document.querySelectorAll('[role="accordion"]');
  var _loop = function _loop(i) {
    /** @type {HTMLButtonElement} */
    var boton = acordeones[i].firstElementChild;
    var flecha = boton.querySelector('[class^="icon-chevron"]');
    boton.onclick = function () {
      boton.nextElementSibling.classList.toggle('w3-hide');
      boton.nextElementSibling.classList.toggle('w3-show');
      if (flecha) {
        flecha.classList.toggle('icon-chevron-right');
        flecha.classList.toggle('icon-chevron-down');
      }
    };
  };
  for (var i = 0; i < acordeones.length; ++i) {
    _loop(i);
  }
};

/**
 * Redirige a una ruta especificada
 * @param  {string} destino Ruta destino
 * @returns {string} La nueva ruta
 */
var redirigir = function redirigir(destino) {
  var href = location.href.split('/');
  href[href.length - 1] = destino;
  href = href.join('/');
  return location.href = href;
};

/**
 * Comportamiento de un Dropdown Click
 * @param  {string} id El ID del content (incluido el '#')
 */
var dropdown = function dropdown(id) {
  /** @type {HTMLElement} */
  var content = document.querySelector(id);
  content.classList.toggle('w3-show');
};

/**
 * Comportamiento de un elemento `<details> para navegadores que no lo soportan`
 * @param  {HTMLElement} details Elemento `<details>`
 */
var mostrarDetails = function mostrarDetails(details) {
  if (details) {
    var summary = details.querySelector('summary');
    var flecha = summary.querySelector('[class^="icon-chevron"]');
    summary.onclick = function () {
      details.removeAttribute('open');
      details.classList.toggle('abierto');
      if (flecha) {
        flecha.classList.toggle('icon-chevron-right');
        flecha.classList.toggle('icon-chevron-down');
      }
    };
  }
};

/** Reajusta la estructura del LicoSys, dependiendo la resolución. */
var reajustar = function reajustar() {
  if (document.body.offsetWidth < 992) {
    $('main').css('margin-left', '0');
  } else $('main').css('margin-left', '250px');
};

/** Define el comportamiento de un menú lateral. */
var menu = function menu() {
  /** @type {HTMLButtonElement} */
  var boton = document.querySelector('.icon-bars').parentElement;
  /** @type {HTMLDivElement} */
  var overlay = document.querySelector('[role="menuOverlay"]');
  /** @type {HTMLElement} */
  var menu = document.querySelector('#menu');
  boton.onclick = function () {
    // Mostramos el fondo.
    overlay.classList.remove('w3-hide');
    overlay.classList.add('w3-show');
    // Mostramos el menú y cambiamos a la animación de cierre.
    menu.classList.remove('w3-hide', 'animate__animated');
    menu.classList.remove('animate__slideOutLeft', 'animate__faster');
    menu.classList.add('w3-show', 'w3-animate-left');
  };

  // Al cerrar el menú.
  overlay.onclick = function () {
    // Ocultar el fondo.
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
    // Cambiar a la animación de apertura.
    menu.classList.remove('w3-animate-left');
    menu.classList.add('animate__animated', 'animate__slideOutLeft');
    menu.classList.add('animate__faster');
    setTimeout(function () {
      // Ocultar el menú
      menu.classList.remove('w3-show');
      menu.classList.add('w3-hide');
    }, 500);
  };
  onresize = function onresize() {
    return reajustar();
  };
};

/**
 * @param  {HTMLElement} modal Contenedor del modal.
 * @param {()} [callback] Función adicional a ejecutar al cerrar el modal. 
 */
var mostrarModal = function mostrarModal(modal) {
  var callback = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function () {};
  /** @type {HTMLSpanElement} */
  var cerrar = modal.querySelector('.icon-close');
  /** @type {HTMLDivElement} */
  var overlay = document.querySelector('[role="modalOverlay"]');

  // Oscurecemos el fondo
  overlay.classList.remove('w3-hide');
  overlay.classList.add('w3-show');

  // Mostramos el modal
  modal.classList.remove('w3-hide');
  modal.classList.add('w3-show');
  // Cambiamos a la animación de apertura
  modal.classList.remove('animate__fadeOutDown');
  modal.classList.add('animate__fadeInUp');

  // Al hacer click en el fondo
  overlay.onclick = function () {
    // Ocultamos el fondo
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
    // Cambiamos a la animación de cierre
    modal.classList.remove('animate__fadeInUp');
    modal.classList.add('animate__fadeOutDown');
    setTimeout(function () {
      // Ocultamos el modal
      modal.classList.remove('w3-show');
      modal.classList.add('w3-hide');
    }, 500);
    callback();
  };

  // Al hacer click en la X
  cerrar.onclick = function () {
    // Ocultamos el fondo
    overlay.classList.remove('w3-show');
    overlay.classList.add('w3-hide');
    // Cambiamos a la animación de cierre
    modal.classList.remove('animate__fadeInUp');
    modal.classList.add('animate__fadeOutDown');
    setTimeout(function () {
      // Ocultamos el modal
      modal.classList.remove('w3-show');
      modal.classList.add('w3-hide');
    }, 500);
    callback();
  };
};

/**
 * Define el comportamiento de un modal.<br>
 * &nbsp;<u>Requisitos</u>
 * <ul>
 *   <li>Para llamar a esta función a el botón o enlace debes agregarle el atributo `onclick="modal(this)"`.</li>
 *   <li>Define un atributo `data-target="selectorCSS"` al elemento modal, ya sea por `#id` o `.class`.</li>
 *   <li>Verifica que coincida el `selectorCSS` con el elemento del modal.</li>
 * </ul>
 * @param  {HTMLElement} boton El elemento que abre el modal al hacer click o touch.
 */
var modal = function modal(boton) {
  var selector = boton.getAttribute('data-target');
  var modal = document.querySelector(selector);
  mostrarModal(modal);
};

/**
 * Opaca el fondo y muestra el loader.
 * @param  {HTMLElement} modal Modal contenedor de algún elemento con `id='loader'`
 */
var mostrarLoader = function mostrarLoader(modal) {
  var overlay = document.querySelector('[role="modalOverlay"]');
  overlay.classList.remove('w3-hide');
  overlay.classList.add('w3-show');
  modal.classList.add('showLoader');
};

/**
 * Quita el fondo opaco y el loader.
 * @param  {HTMLElement} modal    Modal contenedor de algún elemento con `id='loader'`
 */
var ocultarLoader = function ocultarLoader(modal) {
  var overlay = document.querySelector('[role="modalOverlay"]');
  overlay.classList.remove('w3-show');
  overlay.classList.add('w3-hide');
  modal.classList.remove('showLoader');
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
 * @param  {string}   texto    Título de la ventana emergente.
 * @param  {Noty.Layout}   [posicion] Default: 'center'
 * @param  {(e: Event)} callback Función que se ejecuta al confirmar.
 * @return {Noty} Retorna un objeto Noty activado por defecto.
 */
var confirmar = function confirmar(texto) {
  var posicion = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'center';
  var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : function () {};
  var text = "\n\t\t<div class=\"w3-white w3-round-xlarge w3-padding w3-center w3-border\" style=\"z-index: 1000\">\n\t\t\t<div class=\"animate__animated animate__flip animate__infinite icon-question w3-xxxlarge\"></div>\n\t\t\t<h2 class=\"w3-large w3-margin-bottom\">\n\t\t\t\t<strong>".concat(texto, "</strong>\n\t\t\t</h2>\n\t\t\t<div class=\"w3-center w3-padding w3-margin-top\">\n\t\t\t\t<button id=\"btnConfirmar\" class=\"w3-button w3-round-xlarge w3-blue\">S\xED</button>\n\t\t\t\t<button id=\"btnCancelar\" class=\"w3-button w3-round-xlarge w3-red\">No</button>\n\t\t\t</div>\n\t\t</div>\n\t");
  return new Noty({
    id: 'confirmacion',
    theme: null,
    text: text,
    layout: posicion,
    modal: true,
    closeWith: ['button'],
    callbacks: {
      onShow: function onShow() {
        $('#btnConfirmar').on('click', function (e) {
          $('#confirmacion .noty_close_button')[0].click();
          callback(e);
        });
        $('#btnCancelar').on('click', function () {
          $('#confirmacion .noty_close_button')[0].click();
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
    text: "<strong><i class=\"icon-close w3-margin-right\"></i> ".concat(texto, "</strong>"),
    type: 'error',
    timeout: timer
  });
};

/** @param  {string} texto */
var notificacion = function notificacion(texto) {
  return new Noty({
    text: "<i class=\"icon-check w3-margin-right\"></i> ".concat(texto),
    type: 'success',
    timeout: 3000
  });
};

/** @param  {string} texto */
var advertencia = function advertencia(texto) {
  return new Noty({
    text: "<strong class=\"w3-text-black\"><i class=\"icon-warning w3-margin-right\"></i> ".concat(texto, "</strong>"),
    type: 'warning',
    timeout: 3000
  });
};

/**
 * @param  {string} texto
 */
var informacion = function informacion(texto) {
  return new Noty({
    text: "<i class=\"w3-margin-right\">!</i> ".concat(texto),
    type: 'info',
    timeout: 3000
  });
};

/**
 * Actualiza una ayuda que vincula cada pregunta con su respectiva respuesta
 * @param  {HTMLFormElement} form El formulario que contiene a los inputs de preguntas y respuestas.
 */
var labelPreguntas = function labelPreguntas(form) {
  form.pre1.addEventListener('keyup', function () {
    var legendRespuesta = form.querySelector("sup[respuesta=".concat(form.res1.id, "]"));
    legendRespuesta.innerText = "(".concat(form.pre1.value, ")");
  });
  form.pre2.addEventListener('keyup', function () {
    var legendRespuesta = form.querySelector("sup[respuesta=".concat(form.res2.id, "]"));
    legendRespuesta.innerText = "(".concat(form.pre2.value, ")");
  });
  form.pre3.addEventListener('keyup', function () {
    var legendRespuesta = form.querySelector("sup[respuesta=".concat(form.res3.id, "]"));
    legendRespuesta.innerText = "(".concat(form.pre3.value, ")");
  });
};

/**
 * Envia la petición al servidor para activar o desactivar un registro.
 * @param  {string} tabla  De qué tabla es el registro.
 * @param  {string} campo  El nombre del campo para identificar el registro.
 * @param  {number} valor  Valor único de cada registro.
 * @param  {string} accion Si quieres `activar` o `desactivar`.
 * @param  {string} hrefEnlace El HREF del enlace a clickear cuando se active o se desactive un registro.
 */
var activarDesactivar = function activarDesactivar(tabla, campo, valor, accion, hrefEnlace) {
  var post = {
    tabla: tabla,
    campo: campo,
    valor: valor,
    accion: accion
  };
  return $.post('backend/activarDesactivar.php', post, function (res) {
    /** @type {Respuesta} */
    var respuesta = JSON.parse(res);
    if (respuesta.error) return alerta(respuesta.error).show();
    if (accion === 'activar') notificacion(respuesta.ok).on('beforeShow', function () {
      return $("[href=\"".concat(hrefEnlace, "\"]"))[0].click();
    }).show();else if (accion === 'desactivar') informacion(respuesta.ok).on('beforeShow', function () {
      return $("[href=\"".concat(hrefEnlace, "\"]"))[0].click();
    }).show();
  });
};

/**
 * Funcionalidad de activar un registro.
 * @param  {string} tabla De qué tabla es el registro.
 * @param  {string} campo Nombre del campo para identificar el registro.
 * @param  {number} valor Valor único de cada registro.
 * @param  {string} hrefEnlace El HREF del enlace a clickear al activar.
 */
var activar = function activar(tabla, campo, valor, hrefEnlace) {
  return activarDesactivar(tabla, campo, valor, 'activar', hrefEnlace);
};

/**
 * Funcionalidad de desactivar un registro.
 * @param  {string} tabla De qué tabla es el registro.
 * @param  {string} campo Nombre del campo para identificar el registro.
 * @param  {number} valor Valor único de cada registro.
 * @param  {string} hrefEnlace El HREF del enlace a clickear al activar.
 */
var desactivar = function desactivar(tabla, campo, valor, hrefEnlace) {
  return activarDesactivar(tabla, campo, valor, 'desactivar', hrefEnlace);
};
var vaciarLog = function vaciarLog() {
  return confirmar('¿Seguro que desea vaciar el registro?', 'center', function () {
    w3.addClass('main', 'showLoader');
    return $.post('backend/vaciarLog.php', {
      vaciar: true
    }, function (res) {
      w3.removeClass('main', 'showLoader');
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return notificacion(respuesta.ok).on('onShow', function () {
        return $('nav [href="views/log.php"]')[0].click();
      }).show();
    });
  });
};
var cerrarSesion = function cerrarSesion() {
  return confirmar('¿Seguro que desea cerrar sesión?', 'center', function () {
    w3.addClass('main', 'showLoader');
    var url = location.href.split('/');
    url[url.length - 1] = 'salir.php';
    location.href = url.join('/');
  });
};

/**
 * Funcionalidad de editar registros.
 * @param  {HTMLElement} boton  El botón del registro que quieres editar.
 * @param  {string} tabla  La tabla a la cual pertenecen los registros.
 * @param  {string} campo  El nombre del campo que identifica cada registro.
 * @param  {number} valor  Un valor único por cada registro.
 * @param  {string} hrefEnlace El HREF del enlace al clickear tras editar.
 */
var editar = function editar(boton, tabla, campo, valor) {
  var hrefEnlace = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : '';
  var url = 'backend/editar.php';
  var datos = {
    editar: true,
    tabla: tabla,
    campo: campo,
    valor: valor
  };
  $.post(url, datos, function (res) {
    var respuesta = JSON.parse(res);
    if (respuesta.error) return alerta(respuesta.error).show();

    /** @type {HTMLFormElement} */
    var form = document.querySelector(boton.getAttribute('data-target'));
    form.innerHTML = respuesta.ok;
    modal(boton);
    if (tabla === 'usuarios:preguntasRespuestas') {
      labelPreguntas(form);
      verClave(form.res1.nextElementSibling, form.res1);
      verClave(form.res2.nextElementSibling, form.res2);
      verClave(form.res3.nextElementSibling, form.res3);
    }
    if (tabla === 'usuarios:clave') {
      verClave(form.clave.nextElementSibling, form.clave);
      verClave(form.confirmar.nextElementSibling, form.confirmar);
    }
    validar(form, function (error, fd, e) {
      if (error) return alerta(error).show();
      e.preventDefault();
      fd.append('tabla', tabla);
      mostrarLoader(form);
      ajax(url, fd, function (res) {
        var respuesta = JSON.parse(res);
        if (respuesta.error) return alerta(respuesta.error).on('onShow', function () {
          return form.classList.remove('showLoader');
        }).show();
        return notificacion(respuesta.ok).on('onShow', function () {
          ocultarLoader(form);
          if (hrefEnlace) $("a[href=\"".concat(hrefEnlace, "\"]"))[0].click();
        }).show();
      });
    });
  });
};

/**
 * Consulta la factura de una venta específica.
 * @param {HTMLElement} boton El botón de esa venta.
 * @param {string} ventaID El ID de la venta.
 */
var verFacturaVenta = function verFacturaVenta(boton, ventaID) {
  /** @type {HTMLElement} */
  var modalFactura = document.querySelector('#modalFactura');
  ventaID = ventaID.slice(7);
  ventaID = ventaID.slice(0, -8);
  $.get("views/ventas.php?ventaID=".concat(ventaID), function (res) {
    /** @type {Respuesta} */
    var respuesta = JSON.parse(res);
    if (respuesta.error) return alerta(respuesta.error).show();
    var textoTelefono = respuesta.datos.telefonoNegocio ? "\n\t\t\t\t<tr>\n\t\t\t\t\t<th>Tel\xE9fono:</th>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t&nbsp;<span class=\"icon-whatsapp w3-text-green\"></span>\n\t\t\t\t\t\t&nbsp;".concat(respuesta.datos.telefonoNegocio, "\n\t\t\t\t\t</td>\n\t\t\t\t</tr>\n\t\t\t") : '';
    var textoDireccion = respuesta.datos.direccionNegocio ? "\n\t\t\t\t<tr>\n\t\t\t\t\t<th>Direcci\xF3n:</th>\n\t\t\t\t\t<td>&nbsp;".concat(respuesta.datos.direccionNegocio, "</td>\n\t\t\t\t</tr>\n\t\t\t") : '';
    var textoCliente = respuesta.datos.cedulaCliente != 40000000 ? "\n\t\t\t\t<div class=\"w3-margin\">\n\t\t\t\t\t<h5 class=\"w3-container w3-xlarge\">Datos del cliente:</h5>\n\t\t\t\t\t<table class=\"w3-table-all\">\n\t\t\t\t\t\t<tr></tr>\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class=\"w3-tag w3-blue\">Nombre:</th>\n\t\t\t\t\t\t\t<td>".concat(respuesta.datos.nombreCliente, "</td>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class=\"w3-tag w3-blue\">C\xE9dula:</th>\n\t\t\t\t\t\t\t<td>").concat(respuesta.datos.cedulaCliente, "</td>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t</table>\n\t\t\t\t</div>\n\t\t\t") : '';
    modalFactura.innerHTML = "\n\t\t\t<div class=\"w3-right-align\">\n\t\t\t\t<span class=\"icon-close w3-button w3-transparent w3-hover-red\"></span>\n\t\t\t</div>\n\t\t\t<h2 class=\"w3-center w3-xxlarge oswald w3-margin-bottom\">\n\t\t\t\t<div class=\"w3-container\">\n\t\t\t\t\t<img src=\"images/logo.png\" class=\"w3-margin-right w3-responsive\" width=\"100px\">\n\t\t\t\t\t".concat(respuesta.datos.nombreNegocio, "\n\t\t\t\t</div>\n\t\t\t</h2>\n\t\t\t<h3 class=\"w3-container w3-xlarge w3-right-align w3-blue\">Comprobante</h3>\n\t\t\t").concat(textoCliente, "\n\t\t\t<div class=\"w3-responsive w3-margin\">\n\t\t\t\t<h5 class=\"w3-container w3-xlarge\">Datos de la venta</h5>\n\t\t\t\t<table class=\"w3-table-all w3-centered\">\n\t\t\t\t\t<tr class=\"w3-bottombar\">\n\t\t\t\t\t\t<th>Cantidad</th>\n\t\t\t\t\t\t<th>Producto</th>\n\t\t\t\t\t\t<th>Precio unitario</th>\n\t\t\t\t\t\t<th>Monto total</th>\n\t\t\t\t\t</tr>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td>").concat(respuesta.datos.cantidad, "</td>\n\t\t\t\t\t\t<td>").concat(respuesta.datos.producto, "</td>\n\t\t\t\t\t\t<td>$ ").concat(respuesta.datos.precio, "</td>\n\t\t\t\t\t\t<td>$ ").concat(respuesta.datos.total, "</td>\n\t\t\t\t\t</tr>\n\t\t\t\t</table>\n\t\t\t\t<div class=\"w3-container w3-center w3-padding-top-24 w3-large\">\n\t\t\t\t\t<div class=\"w3-left\">\n\t\t\t\t\t\tTotal IVA\n\t\t\t\t\t\t<span class=\"w3-xlarge\">(").concat(respuesta.datos.iva * 100, "%)</span>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class=\"w3-right\">\n\t\t\t\t\t\tMonto total:\n\t\t\t\t\t\t&nbsp;<span class=\"icon-dollar w3-text-green w3-xlarge\"></span>\n\t\t\t\t\t\t<b class=\"w3-xlarge\">").concat(respuesta.datos.total, "</b></div>\n\t\t\t\t</div>\n\t\t\t\t<div class=\"w3-row w3-padding-top-48\">\n\t\t\t\t\t<table class=\"w3-col s8 w3-container w3-left-align\">\n\t\t\t\t\t\t").concat(textoDireccion, "\n\t\t\t\t\t\t").concat(textoTelefono, "\n\t\t\t\t\t</table>\n\t\t\t\t\t<button onclick=\"generarPDF()\" class=\"w3-rest w3-auto w3-button w3-blue w3-round-xlarge\">\n\t\t\t\t\t\t<i class=\"icon-save\"></i>\n\t\t\t\t\t\tGuardar\n\t\t\t\t\t</button>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t");
    modal(boton);
  });
};
var generarPDF = function generarPDF() {
  /** @type {HTMLElement} */
  var modalFactura = document.querySelector('#modalFactura');
  html2pdf(modalFactura.innerHTML);
};

/**
 * Comportamiento de cambiar los páneles.
 * @param  {HTMLElement} boton El botón clickeado.
 * @param  {string} id    El ID del panel a mostrar (incluido el #).
 */
var mostrarPanel = function mostrarPanel(boton, id) {
  /** @type {HTMLDivElement} */
  var panel = $(id)[0];
  $('[role="botonPanel"]').each(function (_i, boton) {
    return boton.classList.remove('w3-blue');
  });
  boton.classList.add('w3-blue');
  $('[role="panel"]').each(function (_i, panel) {
    panel.classList.remove('w3-show');
    panel.classList.add('w3-hide');
  });
  panel.classList.remove('w3-hide');
  panel.classList.add('w3-show');
};
var respaldarBD = function respaldarBD() {
  return confirmar('¿Desea crear una copia de seguridad de todos los datos?', 'center', function () {
    w3.addClass('main', 'showLoader');
    $.post('backend/backupBD.php', {
      respaldar: true
    }, function (res) {
      w3.removeClass('main', 'showLoader');
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return notificacion(respuesta.ok).show();
    });
  });
};
var restaurarBD = function restaurarBD() {
  var texto = "\n\t\tTener en cuenta que al restaurar se perder\xE1n cambios \n\t\tque no hayan sido respaldados<br>\n\t\t<strong class=\"w3-text-red\">\xBFDesea continuar?</strong>\n\t";
  return confirmar(texto, 'center', function () {
    w3.addClass('main', 'showLoader');
    $.post('backend/backupBD.php', {
      restaurar: true
    }, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).on('onShow', function () {
        return w3.removeClass('main', 'showLoader');
      }).show();
      var html = "\n\t\t\t\t<div class=\"w3-card w3-round-xlarge w3-white w3-padding-large w3-center\">\n\t\t\t\t\t<h1 class=\"w3-xlarge oswald\">".concat(respuesta.ok, "</h1>\n\t\t\t\t\t<h2 class=\"w3-large w3-padding-top-24 w3-topbar\">\n\t\t\t\t\t\tReiniciando el Sistema...\n\t\t\t\t\t</h2>\t\n\t\t\t\t</div>\n\t\t\t");
      new Noty({
        theme: null,
        id: 'intro',
        type: 'info',
        text: html,
        layout: 'center',
        modal: true,
        closeWith: [null],
        animation: {
          open: 'w3-animate-zoom'
        },
        timeout: 5000,
        callbacks: {
          afterClose: function afterClose() {
            return location.reload();
          }
        }
      }).show();
    });
  });
};

/**
 * Filtra elementos en una lista.
 * @param  {HTMLInputElement} input Entrada de texto.
 * @param  {string} contenedorID   ID del contenedor de la lista
 */
var filter = function filter(input, contenedorID) {
  var contenedor = document.querySelector("#".concat(contenedorID));
  /** @type {string} Texto a buscar en mayúsculas */
  var texto = input.value.toUpperCase();
  var elementos = contenedor.querySelectorAll('button');
  for (var i = 0; i < elementos.length; ++i) {
    /** @type {string} Texto del elemento */
    var txtValue = elementos[i].textContent || elementos[i].innerText;
    if (txtValue.toUpperCase().indexOf(texto) > -1) elementos[i].style.display = '';else elementos[i].style.display = 'none';
  }
};

/**
 * Funcionalidad del formulario para registrar productos.
 * @param  {HTMLFormElement} formulario El formulario de registro.
 * @param  {string} enlace     El HREF del enlace a clickear terminado el registro.
 */
var registrarProducto = function registrarProducto(formulario, enlace) {
  validar(formulario, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    mostrarLoader(formulario);
    ajax('backend/registrarProducto.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onShow', function () {
        return ocultarLoader(formulario);
      }).show();
      ocultarLoader(formulario);
      return notificacion(datos.ok).on('onShow', function () {
        return $("[href=\"".concat(enlace, "\"]"))[0].click();
      }).show();
    });
  });
};

/**
 * Funcionalidad del formulario para registrar clientes.
 * @param  {HTMLFormElement} formulario El formulario de registro.
 * @param  {string} enlace     El HREF del enlace a clickear terminado el registro.
 */
var registrarCliente = function registrarCliente(formulario, enlace) {
  validar(formulario, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    mostrarLoader(formulario);
    ajax('backend/registrarCliente.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onShow', function () {
        return ocultarLoader(formulario);
      }).show();
      ocultarLoader(formulario);
      return notificacion(datos.ok).on('onShow', function () {
        return $("[href=\"".concat(enlace, "\"]"))[0].click();
      }).show();
    });
  });
};

/**
 * Funcionalidad del formulario para registrar proveedores.
 * @param  {HTMLFormElement} formulario El formulario de registro.
 * @param  {string} enlace     El HREF del enlace a clickear terminado el registro.
 */
var registrarProveedor = function registrarProveedor(formulario, enlace) {
  validar(formulario, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    mostrarLoader(formulario);
    ajax('backend/registrarProveedor.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onShow', function () {
        return formulario.classList.remove('showLoader');
      }).show();
      ocultarLoader(formulario);
      return notificacion(datos.ok).on('onShow', function () {
        return $("[href=\"".concat(enlace, "\"]"))[0].click();
      }).show();
    });
  });
};

/**
 * Funcionalidad de actualizar el valor de las monedas.
 * @param  {HTMLFormElement} formulario El formulario de actualización.
 */
var actualizarMonedas = function actualizarMonedas(formulario) {
  validar(formulario, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    formulario.classList.add('showLoader');
    ajax('backend/actualizarMonedas.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onClose', function () {
        return formulario.classList.remove('showLoader');
      }).show();
      $('#tablaMonedas').html("\n\t\t\t\t<tr>\n\t\t\t\t\t<td>IVA</td>\n\t\t\t\t\t<td colspan=\"2\"><b>".concat(formulario.iva.value, "%</b></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr>\n\t\t\t\t\t<td>D\xD3LAR</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<b><i>Bs. </i>").concat(formulario.dolar.value, "</b>\n\t\t\t\t\t</td>\n\t\t\t\t\t<td><b>").concat(formulario.pesos.value, "<i> Pesos</i></b></td>\n\t\t\t\t</tr>\t\n\t\t\t"));
      formulario.classList.remove('showLoader');
      return notificacion(datos.ok).on('onShow', function () {
        formulario.querySelector('.icon-close').click();
      }).on('afterClose', function () {
        return location.reload();
      }).show();
    });
  });
};

/**
 * Actualiza dinámicamente el total de un producto.
 * @param  {HTMLInputElement} cantidad   Un elemento `<input>` con `name="cantidad`
 * @param  {number} excento Representa si el producto es o no es excento de IVA.
 * @param  {string} inputTotalID ID del `<input>` en dónde mostrar el total.
 */
var actualizarTotal = function actualizarTotal(cantidad, excento, inputTotalID) {
  var precio = Number(cantidad.form.querySelector('[name="precio"]').value);
  var iva = Number(cantidad.form.querySelector('[name="iva"]').value);
  var dolar = Number(cantidad.form.querySelector('[name="dolar"]').value);
  var peso = Number(cantidad.form.querySelector('[name="peso"]').value);
  /** @type {HTMLInputElement} */
  var total = cantidad.form.querySelector(inputTotalID);
  total.value = (precio * cantidad.value).toFixed(2);
  total.setAttribute('total', total.value);
  if (excento) {
    var totalIVA = Number(total.getAttribute('total')) * iva;
    var precioBS = ((Number(total.getAttribute('total')) + totalIVA) * dolar).toFixed(2);
    var precioPesos = ((Number(total.getAttribute('total')) + totalIVA) * peso).toFixed(0);
    total.parentElement.innerHTML = "\n\t\t\t<span id=\"total\" class=\"w3-left-align w3-input w3-padding w3-light-grey w3-text-black\" disabled>\n\t\t\t\t".concat(Number(total.value) + totalIVA, " <span class=\"w3-text-green\">+").concat(totalIVA, " IVA</span>\n\t\t\t</span>\n\t\t\t<div class=\"w3-dropdown-content w3-padding-small w3-card-4 w3-white\">\n\t\t\t\t<b>Bs. ").concat(precioBS, "<br>\n\t\t\t\t").concat(precioPesos, " pesos</b>\n\t\t\t</div>\n\t\t");
  } else {
    var _precioBS = (Number(total.getAttribute('total')) * dolar).toFixed(2);
    var _precioPesos = (Number(total.getAttribute('total')) * peso).toFixed(0);
    total.parentElement.innerHTML = "\n\t\t\t<span id=\"total\" class=\"w3-left-align w3-input w3-padding w3-light-grey w3-text-black\" disabled>\n\t\t\t\t".concat(total.value, "\n\t\t\t</span>\n\t\t\t<div class=\"w3-dropdown-content w3-padding-small w3-card-4 w3-white\">\n\t\t\t\t<b>Bs. ").concat(_precioBS, "<br>\n\t\t\t\t").concat(_precioPesos, " pesos</b>\n\t\t\t</div>\n\t\t");
  }
  if (cantidad.value != 0) cantidad.form.querySelector('button').classList.remove('w3-hide');
};

/**
 * Actualiza dinámicamente el tooltip del precio.
 * @param  {HTMLInputElement} inputPrecio El `<input>` con el precio.
 */
var actualizarPrecio = function actualizarPrecio(inputPrecio) {
  var precio = Number(inputPrecio.value);
  var dolar = Number(inputPrecio.form.querySelector('[name="dolar"]').value);
  var peso = Number(inputPrecio.form.querySelector('[name="peso"]').value);
  var precioBS = (precio * dolar).toFixed(2);
  var precioPesos = (precio * peso).toFixed(0);
  inputPrecio.parentElement.querySelector('.w3-dropdown-content').innerHTML = "\n\t\t<b>\n\t\t\tBs. ".concat(precioBS, "<br>\n\t\t\t").concat(precioPesos, " pesos\n\t\t</b>\n\t");
};
onoffline = function onoffline() {
  return advertencia('Se ha perdido la conexión').show();
};
ononline = function ononline() {
  return notificacion('Se ha restablecido la conexión').show();
};