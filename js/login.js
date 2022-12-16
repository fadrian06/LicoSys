"use strict";

/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLDivElement} */
var contenedorReloj = document.querySelector('.reloj');

/** @type {HTMLFormElement} */
var form = document.querySelector('#login');

/** @type {HTMLDivElement} */
var overlay = document.querySelector('.w3-overlay');

/** @type {HTMLElement} */
var loader = form.querySelector('#loader');
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reloj(contenedorReloj);
setInterval(function () {
  return reloj(contenedorReloj);
}, 1 * 1000 * 60);
verClave(form.clave.nextElementSibling, form.clave);
new Typed('#typed', {
  strings: ['<i>Sencillo.</i>', '<i>Moderno.</i>', '<i>Seguro.</i>'],
  typeSpeed: 100,
  startDelay: 1000,
  backSpeed: 50,
  loop: true,
  cursorChar: '/'
});
form.usuario.addEventListener('blur', function () {
  if (!form.usuario.value) return;
  loader.classList.remove('w3-hide');
  loader.classList.add('w3-show');
  var post = {
    verificarUsuario: true,
    usuario: form.usuario.value
  };
  $.post('backend/login.php', post, function (res) {
    /** @type {Respuesta} */
    var datos = JSON.parse(res);
    if (datos.error) return alerta(datos.error).on('onShow', function () {
      loader.classList.remove('w3-show');
      loader.classList.add('w3-hide');
      form.usuario.parentElement.parentElement.classList.remove('valido');
      form.usuario.parentElement.parentElement.classList.add('invalido');
    }).show();
    var spinner = loader.querySelector('i');
    spinner.classList.remove('icon-spinner', 'w3-spin');
    spinner.classList.add('icon-check', 'w3-text-green');
    form.usuario.parentElement.parentElement.classList.add('valido');
  });
});
var intentos = 0;
/**
 * @param  {string} res {error: string, datos: []}
 */
var recibirRespuesta = validar(form, function (error, fd, e) {
  if (error) return alerta(error).show();
  e.preventDefault();
  form.classList.add('showLoader');
  fd.append('login', true);
  ajax('backend/login.php', fd, function (res) {
    /** @type {Respuesta} */
    var datos = JSON.parse(res);
    if (datos.error) {
      var text = "<i class=\"icon-close w3-margin-right\"></i> ".concat(datos.error);
      if (datos.error === 'Contraseña incorrecta') ++intentos;
      if (intentos <= 3) text += " <strong>(intento: ".concat(intentos, " / 3)</strong>");
      return alerta(text).on('afterClose', function () {
        return form.classList.remove('showLoader');
      }).show();
    }
    form.classList.remove('showLoader');
    var href = location.href;
    if (!href.indexOf('index.php')) return location.href += 'dashboard.php';
    href = href.replace(/index\.php/g, function (coincidencia) {
      return coincidencia = 'dashboard.php';
    });
    return location.href = href;
  });
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/