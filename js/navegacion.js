"use strict";

/** @typedef {import('./funciones')} */

/**
 * Funcionalidad del módulo Usuarios
 * @param {HTMLElement} contenedor Contenedor del módulo.
 */
var moduloUsuarios = function moduloUsuarios(contenedor) {
  /** @type {HTMLFormElement} */
  var formRegistrar = contenedor.querySelector('#registrarUsuario');
  acordeon();
  verClave(formRegistrar.clave.nextElementSibling, formRegistrar.clave);
  verClave(formRegistrar.confirmar.nextElementSibling, formRegistrar.confirmar);
  mostrarDetails(contenedor.querySelector('details'));
  validar(formRegistrar, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    mostrarLoader(formRegistrar);
    fd.append('cargo', 'v');
    ajax('backend/registrarUsuario.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onShow', function () {
        return formRegistrar.classList.remove('showLoader');
      }).show();
      ocultarLoader(formRegistrar);
      return notificacion('Usuario registrado correctamente').on('onShow', function () {
        return $('[href="views/usuarios.php"]')[0].click();
      }).show();
    });
  });
};

/**
 * Funcionalidad del módulo log.
 * @param  {HTMLElement} _contenedor Contenedor del módulo.
 */
var moduloLog = function moduloLog(_contenedor) {
  return acordeon();
};

/**
 * Funcionalidad del módulo clientes.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
var moduloClientes = function moduloClientes(contenedor) {
  acordeon();
  mostrarDetails(contenedor.querySelector('details'));
  registrarCliente(contenedor.querySelector('#registrarCliente'), 'views/clientes.php');
};

/**
 * Funcionalidad del módulo proveedores.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
var moduloProveedores = function moduloProveedores(contenedor) {
  var formRegistrar = contenedor.querySelector('#registrarProveedor');
  acordeon();
  mostrarDetails(contenedor.querySelector('details'));
  registrarProveedor(formRegistrar, 'views/proveedores.php');
};

/**
 * Funcionalidad del módulo perfil.
 * @param  {HTMLElement} contenedor El contenedor del módulo.
 */
var moduloPerfil = function moduloPerfil(contenedor) {
  /** @type {HTMLFormElement} */
  var formFoto = contenedor.querySelector('[enctype="multipart/form-data"]');
  /** @type {HTMLButtonElement} */
  var boton = formFoto.querySelector('button');
  /** @type {HTMLImageElement} */
  var imagen = formFoto.foto.nextElementSibling;
  $('#menuNombreUsuario').html($('#nombreUsuario').html());
  actualizarImagen(formFoto.foto, imagen, function (error) {
    if (error) return alerta(error).show();
    boton.classList.remove('w3-hide');
    boton.classList.add('w3-show-inline-block');
    formFoto.onsubmit = function (e) {
      e.preventDefault();
      var fd = new FormData(formFoto);
      fd.append('foto', formFoto.foto.files[0]);
      w3.addClass('main', 'showLoader');
      ajax('backend/actualizarImagen.php', fd, function (res) {
        /** @type {Respuesta} */
        var respuesta = JSON.parse(res);
        if (respuesta.error) return alerta(respuesta.error).on('onShow', function () {
          return w3.removeClass('main', 'showLoader');
        }).show();
        w3.removeClass('main', 'showLoader');
        boton.classList.remove('w3-show-inline-block');
        boton.classList.add('w3-hide');
        return notificacion(respuesta.ok).on('onShow', function () {
          $('[href="views/miPerfil.php"]')[0].click();
          $('aside a img')[0].src = imagen.src;
        }).show();
      });
    };
  });
};

/** 
 * Funcionalidad del módulo negocios.
 * @param  {HTMLElement} contenedor El contenedor del módulo.
 */
var moduloNegocios = function moduloNegocios(contenedor) {
  /*============================================
  =            Registro de negocios            =
  ============================================*/
  /** @type {HTMLFormElement} */
  var formRegistrar = contenedor.querySelector('#registrarNegocio');
  /** @type {HTMLInputElement} */
  var inputFile = formRegistrar.logo;
  /** @type {HTMLImageElement} */
  var imagen = inputFile.nextElementSibling;
  acordeon();
  mostrarDetails(contenedor.querySelector('details'));
  actualizarImagen(inputFile, imagen, function (error) {
    if (error) return alerta(error).show();
  });
  validar(formRegistrar, function (error, fd, e) {
    if (error) return alerta(error).show();
    e.preventDefault();
    mostrarLoader(formRegistrar);
    fd.append('logo', formRegistrar.logo.files[0]);
    ajax('backend/registrarNegocio.php', fd, function (res) {
      /** @type {Respuesta} */
      var datos = JSON.parse(res);
      if (datos.error) return alerta(datos.error).on('onShow', function () {
        return formRegistrar.classList.remove('showLoader');
      }).show();
      ocultarLoader(formRegistrar);
      return notificacion(datos.ok).on('onShow', function () {
        return $('[href="views/negocios.php"]')[0].click();
      }).show();
    });
  });

  /*=================================================
  =            Actualización de imagenes            =
  =================================================*/
  $('#menuNombreNegocio').html($('#nombreNegocioActivo').html());
  $('[enctype="multipart/form-data"]').each(function (_i, form) {
    /** @type {HTMLFormElement} */
    var formFoto = form;
    /** @type {HTMLInputElement} */
    var inputFile = formFoto.querySelector('input[type="file"]');
    /** @type {HTMLButtonElement} */
    var boton = formFoto.querySelector('button');
    /** @type {HTMLImageElement} */
    var imagen = inputFile.nextElementSibling;
    actualizarImagen(inputFile, imagen, function (error) {
      if (error) return alerta(error).show();
      boton.classList.remove('w3-hide');
      boton.classList.add('w3-show-inline-block');
      formFoto.onsubmit = function (e) {
        e.preventDefault();
        var fd = new FormData(formFoto);
        fd.append('logo', inputFile.files[0]);
        w3.addClass('main', 'showLoader');
        ajax('backend/actualizarImagen.php', fd, function (res) {
          /** @type {Respuesta} */
          var respuesta = JSON.parse(res);
          if (respuesta.error) return alerta(respuesta.error).on('onShow', function () {
            return w3.removeClass('main', 'showLoader');
          }).show();
          w3.removeClass('main', 'showLoader');
          boton.classList.remove('w3-show-inline-block');
          boton.classList.add('w3-hide');
          return notificacion(respuesta.ok).on('onShow', function () {
            $('[href="views/negocios.php"]')[0].click();
            $('header a img')[0].src = imagen.src;
          }).show();
        });
      };
    });
  });
};

/**
 * Funcionalidad del módulo finanzas
 * @param  {HTMLElement} _contenedor Contenedor del módulo
 */
var moduloFinanzas = function moduloFinanzas(contenedor) {
  /*===========================================
  =            Botones de negocios            =
  ===========================================*/
  var botones = $('[role="botonPanel"]');
  var paneles = $('[role="panel"]');
  botones.each(function (_i, boton) {
    boton.onclick = function () {
      botones.each(function (_i, boton) {
        boton.classList.remove('w3-blue');
        boton.classList.add('w3-white');
      });
      paneles.each(function (_i, panel) {
        panel.classList.remove('w3-show-inline-block');
        panel.classList.add('w3-hide');
      });

      /** @type {HTMLDivElement} */
      var panelObjetivo = $(boton.getAttribute('data-target'))[0];
      panelObjetivo.classList.remove('w3-hide');
      panelObjetivo.classList.add('w3-show-inline-block');
      boton.classList.remove('w3-white');
      boton.classList.add('w3-blue');
    };
  });

  /*===============================
  =            FILTROS            =
  ===============================*/
  /** @type {HTMLTableElement} */
  var tabla = contenedor.querySelector('table');
  var contenedorGanancia = tabla.nextElementSibling;
  $('input[type="radio"]').on('click', function (e) {
    tabla.classList.add('w3-disabled');
    contenedorGanancia.classList.add('w3-disabled');
    /** @type {number} */
    var negocioID = e.target.getAttribute('negocio-id');
    /** @type {string} */
    var rol = e.target.id;
    if (rol.includes('diario')) rol = 'diario';else if (rol.includes('semanal')) rol = 'semanal';else if (rol.includes('quincenal')) rol = 'quincenal';else if (rol.includes('mensual')) rol = 'mensual';
    $.get("views/finanzas.php?negocioID=".concat(negocioID, "&rol=").concat(rol), function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      tabla.innerHTML = "\n\t\t\t\t<tr class=\"w3-blue\">\n\t\t\t\t\t<th class=\"tooltip-container\">\n\t\t\t\t\t\tUC\n\t\t\t\t\t\t<b class=\"tooltip w3-block w3-padding-small w3-card-4 w3-white\" style=\"bottom: -90%\">\n\t\t\t\t\t\t\tUnidades compradas\n\t\t\t\t\t\t</b>\n\t\t\t\t\t</th>\n\t\t\t\t\t<th class=\"tooltip-container\">\n\t\t\t\t\t\tUV\n\t\t\t\t\t\t<b class=\"tooltip w3-block w3-padding-small w3-card-4 w3-white\" style=\"bottom: -90%\">\n\t\t\t\t\t\t\tUnidades vendidas\n\t\t\t\t\t\t</b>\n\t\t\t\t\t</th>\n\t\t\t\t\t<th>Producto</th>\n\t\t\t\t\t<th class=\"w3-red\">Gastos</th>\n\t\t\t\t\t<th class=\"w3-green\">Ingresos</th>\n\t\t\t\t</tr>\n\t\t\t\t".concat(respuesta.ok, "\n\t\t\t\t<tr class=\"w3-blue\">\n\t\t\t\t\t<td colspan=\"3\">TOTAL:</td>\n\t\t\t\t\t<td class=\"w3-red\">").concat(respuesta.datos.gastos, "</td>\n\t\t\t\t\t<td class=\"w3-green\">").concat(respuesta.datos.ingresos, "</td>\n\t\t\t\t</tr>\n\t\t\t");
      tabla.classList.remove('w3-disabled');
      contenedorGanancia.innerHTML = "\n\t\t\t\t<div class=\"w3-animate-opacity\">\n\t\t\t\t\t".concat(respuesta.datos.ganancia, "\n\t\t\t\t</div>\n\t\t\t");
      contenedorGanancia.classList.remove('w3-disabled');
    });
  });
};

/**
 * Funcionalidad del módulo inventario
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
var moduloInventario = function moduloInventario(contenedor) {
  acordeon();
  mostrarDetails(contenedor.querySelector('details'));
  registrarProducto(contenedor.querySelector('#registrarProducto'), 'views/inventario.php');
};

/**
 * Funcionalidad del módulo ventas.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
var moduloVentas = function moduloVentas(_contenedor) {
  acordeon();
  $('#botones a').on('click', function (e) {
    e.preventDefault();
    document.querySelector('[href="views/nuevaVenta.php"]').click();
  });
};

/**
 * Funcionalidad del módulo compras.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
var moduloCompras = function moduloCompras(_contenedor) {
  acordeon();
  $('#botones a').on('click', function (e) {
    e.preventDefault();
    document.querySelector('[href="views/nuevaCompra.php"]').click();
  });
};

/**
 * Funcionalidad del módulo Nueva Venta.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
var moduloNuevaVenta = function moduloNuevaVenta(contenedor) {
  var formMonedas = contenedor.querySelector('#actualizarMonedas');
  registrarProducto(contenedor.querySelector('#registrarProducto'), 'views/nuevaVenta.php');
  registrarCliente(contenedor.querySelector('#registrarCliente'), 'views/nuevaVenta.php');
  if (formMonedas) actualizarMonedas(formMonedas);
  $('#productosEnCarrito').html($('#cantidadProductosEnCarrito').html());

  /*----------  SELECCIONAR CLIENTE  ----------*/
  /** @type {HTMLUListElement} */
  var datosCliente = contenedor.querySelector('#datosCliente');
  $('[cliente-id]').on('click', function (e) {
    /** @type {number} */
    var id = e.currentTarget.getAttribute('cliente-id');
    $.get("backend/nuevaVenta.php?clienteID=".concat(id), function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      datosCliente.classList.remove('w3-hide');
      datosCliente.innerHTML = "\n\t\t\t\t<li>\n\t\t\t\t\t<span class=\"w3-tag w3-blue w3-left\">C\xE9dula:</span>\n\t\t\t\t\t<b class=\"w3-right\">v-".concat(respuesta.datos.cedula, "</b>\n\t\t\t\t\t<div class=\"w3-clear\"></div>\n\t\t\t\t</li>\n\t\t\t\t<li>\n\t\t\t\t\t<span class=\"w3-tag w3-blue w3-left\">Nombre:</span>\n\t\t\t\t\t<b class=\"w3-right\">").concat(respuesta.datos.nombre, "</b>\n\t\t\t\t\t<div class=\"w3-clear\"></div>\n\t\t\t\t</li>\n\t\t\t");
    });
  });

  /*----------  OMITIR CLIENTE  ----------*/
  $('[role="omitirCliente"]').on('click', function () {
    $('[cliente-id="3"]')[0].click();
    w3.hide('#seccionCliente');
  });

  /*----------  SELECCIONAR PRODUCTO  ----------*/
  /** @type {HTMLFormElement} */
  var datosProducto = contenedor.querySelector('#datosProducto');
  $('[producto-id]').on('click', function (e) {
    /** @type {number} */
    var id = e.currentTarget.getAttribute('producto-id');
    $.get("backend/nuevaVenta.php?productoID=".concat(id), function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      datosProducto.classList.remove('w3-hide');
      var stock = respuesta.datos.stock > 0 ? "<span class=\"w3-input w3-padding w3-left-align w3-light-grey\">".concat(respuesta.datos.stock, "</span>") : "<span class=\"w3-input w3-padding w3-red\">Agotado</span>";
      datosProducto.innerHTML = "\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Producto:</div>\n\t\t\t\t\t<div class=\"w3-col s8\">\n\t\t\t\t\t\t<input class=\"w3-input w3-padding w3-light-grey w3-text-black\" disabled value=\"".concat(respuesta.datos.producto, "\">\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">C\xF3digo:</div>\n\t\t\t\t\t<div class=\"w3-col s8\">\n\t\t\t\t\t\t<input class=\"w3-input w3-padding w3-light-grey w3-text-black\" disabled value=\"").concat(respuesta.datos.codigo, "\">\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Existencia:</div>\n\t\t\t\t\t<div class=\"w3-col s8\">\n\t\t\t\t\t\t").concat(stock, "\n\t\t\t\t\t\t<input type=\"hidden\" disabled value=\"").concat(respuesta.datos.stock, "\">\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Precio (<i class=\"icon-dollar\"></i>):</div>\n\t\t\t\t\t<div class=\"w3-col s8 tooltip-container\">\n\t\t\t\t\t\t<input name=\"precio\" class=\"w3-input w3-padding w3-light-grey w3-text-black\" disabled value=\"").concat(respuesta.datos.precio, "\">\n\t\t\t\t\t\t<b class=\"tooltip w3-block w3-padding-small w3-card-4 w3-white\" style=\"bottom: -90%\">\n\t\t\t\t\t\t\tBs. ").concat(respuesta.datos.precio * respuesta.datos.dolar, "<br>\n\t\t\t\t\t\t\t").concat(respuesta.datos.precio * respuesta.datos.peso, " pesos\n\t\t\t\t\t\t</b>\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Cantidad:</div>\n\t\t\t\t\t<div class=\"w3-col s8\">\n\t\t\t\t\t\t<input type=\"number\" name=\"cantidad\" onchange=\"actualizarTotal(this, ").concat(respuesta.datos.excento, ", '#total')\" onkeyup=\"actualizarTotal(this, ").concat(respuesta.datos.excento, ", '#total')\" placeholder=\"Introduce la cantidad\" required min=\"0\" max=\"").concat(respuesta.datos.stock, "\" class=\"w3-input w3-padding\">\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Total (<i class=\"icon-dollar\"></i>):</div>\n\t\t\t\t\t<div class=\"w3-col s8 tooltip-container\">\n\t\t\t\t\t\t<span id=\"total\" class=\"w3-left-align w3-input w3-padding w3-light-grey w3-text-black\" disabled>\n\t\t\t\t\t\t\t<i class=\"w3-opacity-min\">&nbsp;</i>\n\t\t\t\t\t\t</span>\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<div class=\"w3-center\">\n\t\t\t\t\t<input type=\"hidden\" name=\"productoID\" value=\"").concat(respuesta.datos.id, "\">\n\t\t\t\t\t<input type=\"hidden\" name=\"iva\" value=\"").concat(respuesta.datos.iva, "\">\n\t\t\t\t\t<input type=\"hidden\" name=\"dolar\" value=\"").concat(respuesta.datos.dolar, "\">\n\t\t\t\t\t<input type=\"hidden\" name=\"peso\" value=\"").concat(respuesta.datos.peso, "\">\n\t\t\t\t\t<button class=\"w3-margin-top w3-medium w3-button w3-blue w3-round-xlarge w3-hide w3-animate-bottom\">\n\t\t\t\t\t\t<span class=\"icon-plus\"></span>\n\t\t\t\t\t\tA\xF1adir Producto\n\t\t\t\t\t</button>\n\t\t\t\t</div>\n\t\t\t");
    });
  });

  /*----------  AGREGAR PRODUCTO  ----------*/
  datosProducto.onsubmit = function (e) {
    e.preventDefault();
    var datos = {
      cantidad: datosProducto.cantidad.value,
      productoID: datosProducto.productoID.value,
      addProduct: true
    };
    $.post('backend/nuevaVenta.php', datos, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return notificacion(respuesta.ok).on('onShow', function () {
        return $('[href="views/nuevaVenta.php"]')[0].click();
      }).on('afterClose', function () {
        return contenedor.scrollTo(contenedor.scrollHeight);
      }).show();
    });
  };

  /** @type {HTMLFormElement} */
  var carrito = contenedor.querySelector('#carritoVenta');
  if (!carrito) return;
  carrito.onsubmit = function (e) {
    return e.preventDefault();
  };

  /*----------  ELIMINAR PRODUCTO  ----------*/
  $('[role="eliminarProducto"]').on('click', function (e) {
    e.preventDefault();
    var datos = {
      productoID: e.target.getAttribute('productoid'),
      eliminar: true
    };
    $.post('backend/nuevaVenta.php', datos, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return notificacion(respuesta.ok).on('onShow', function () {
        return $('[href="views/nuevaVenta.php"]')[0].click();
      }).on('afterClose', function () {
        return contenedor.scrollTo(contenedor.scrollHeight);
      }).show();
    });
  });

  /*----------  ANULAR VENTA  ----------*/
  $('[role="anularVenta"]').on('click', function () {
    $.post('backend/nuevaVenta.php', {
      anular: true
    }, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return informacion(respuesta.ok).on('onShow', function () {
        return $('[href="views/nuevaVenta.php"]')[0].click();
      }).show();
    });
  });

  /*----------  GENERAR VENTA  ----------*/
  $('[role="generarVenta"]').on('click', function () {
    $.post('backend/nuevaVenta.php', {
      generar: true
    }, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return notificacion(respuesta.ok).on('onShow', function () {
        return $('[href="views/nuevaVenta.php"]')[0].click();
      }).show();
    });
  });
};

/**
 * Funcionalidad del módulo Nueva Compra.
 * @param  {HTMLElement} contenedor Contenedor del módulo.
 */
var moduloNuevaCompra = function moduloNuevaCompra(contenedor) {
  var formMonedas = contenedor.querySelector('#actualizarMonedas');
  registrarProducto(contenedor.querySelector('#registrarProducto'), 'views/nuevaVenta.php');
  registrarProveedor(contenedor.querySelector('#registrarProveedor'), 'views/nuevaCompra.php');
  if (formMonedas) actualizarMonedas(formMonedas);
  $('#productosEnCarritoCompra').html($('#cantidadProductosEnCarrito').html());

  /*----------  SELECCIONAR PROVEEDOR  ----------*/
  /** @type {HTMLUListElement} */
  var datosProveedor = contenedor.querySelector('#datosProveedor');
  $('[proveedor-id]').on('click', function (e) {
    /** @type {number} */
    var id = e.currentTarget.getAttribute('proveedor-id');
    $.get("backend/nuevaCompra.php?proveedorID=".concat(id), function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      datosProveedor.classList.remove('w3-hide');
      datosProveedor.innerHTML = "\n\t\t\t\t<li>\n\t\t\t\t\t<span class=\"w3-tag w3-blue w3-left\">RIF:</span>\n\t\t\t\t\t<b class=\"w3-right\">".concat(respuesta.datos.rif, "</b>\n\t\t\t\t\t<div class=\"w3-clear\"></div>\n\t\t\t\t</li>\n\t\t\t\t<li>\n\t\t\t\t\t<span class=\"w3-tag w3-blue w3-left\">Nombre:</span>\n\t\t\t\t\t<b class=\"w3-right\">").concat(respuesta.datos.nombre, "</b>\n\t\t\t\t\t<div class=\"w3-clear\"></div>\n\t\t\t\t</li>\n\t\t\t");
    });
  });

  /*----------  SELECCIONAR PRODUCTO  ----------*/
  /** @type {HTMLFormElement} */
  var datosProducto = contenedor.querySelector('#datosProducto');
  $('[producto-id]').on('click', function (e) {
    /** @type {number} */
    var id = e.currentTarget.getAttribute('producto-id');
    $.get("backend/nuevaCompra.php?productoID=".concat(id), function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      datosProducto.classList.remove('w3-hide');
      var stock = respuesta.datos.stock > 0 ? "<span class=\"w3-input w3-padding w3-left-align w3-light-grey\">".concat(respuesta.datos.stock, "</span>") : "<span class=\"w3-input w3-padding w3-red\">Agotado</span>";
      datosProducto.innerHTML = "\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Producto:</div>\n\t\t\t\t\t<div class=\"w3-col s8\">\n\t\t\t\t\t\t<input class=\"w3-input w3-padding w3-light-grey w3-text-black\" disabled value=\"".concat(respuesta.datos.producto, "\">\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">C\xF3digo:</div>\n\t\t\t\t\t<div class=\"w3-col s8\">\n\t\t\t\t\t\t<input class=\"w3-input w3-padding w3-light-grey w3-text-black\" disabled value=\"").concat(respuesta.datos.codigo, "\">\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Existencia:</div>\n\t\t\t\t\t<div class=\"w3-col s8\">\n\t\t\t\t\t\t").concat(stock, "\n\t\t\t\t\t\t<input type=\"hidden\" disabled value=\"").concat(respuesta.datos.stock, "\">\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Precio (<i class=\"icon-dollar\"></i>):</div>\n\t\t\t\t\t<div class=\"w3-col s8 tooltip-container\">\n\t\t\t\t\t\t<input type=\"number\" step=\"0.01\" name=\"precio\" onchange=\"actualizarPrecio(this)\" onkeyup=\"actualizarPrecio(this)\" class=\"w3-input w3-padding\" value=\"").concat(respuesta.datos.precio, "\">\n\t\t\t\t\t\t<b class=\"tooltip w3-block w3-padding-small w3-card-4 w3-white\" style=\"bottom: -90%\">\n\t\t\t\t\t\t\tBs. ").concat(respuesta.datos.precio * respuesta.datos.dolar, "<br>\n\t\t\t\t\t\t\t").concat(respuesta.datos.precio * respuesta.datos.peso, " pesos\n\t\t\t\t\t\t</b>\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Cantidad:</div>\n\t\t\t\t\t<div class=\"w3-col s8\">\n\t\t\t\t\t\t<input type=\"number\" name=\"cantidad\" onchange=\"actualizarTotal(this, 0, '#total')\" onkeyup=\"actualizarTotal(this, 0, '#total')\" placeholder=\"Introduce la cantidad\" required min=\"0\" class=\"w3-input w3-padding\">\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<section class=\"w3-row\">\n\t\t\t\t\t<div class=\"w3-input w3-col s4 w3-blue\">Total (<i class=\"icon-dollar\"></i>):</div>\n\t\t\t\t\t<div class=\"w3-col s8 tooltip-container\">\n\t\t\t\t\t\t<span id=\"total\" class=\"w3-left-align w3-input w3-padding w3-light-grey w3-text-black\" disabled>\n\t\t\t\t\t\t\t<i class=\"w3-opacity-min\">&nbsp;</i>\n\t\t\t\t\t\t</span>\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t<div class=\"w3-center\">\n\t\t\t\t\t<input type=\"hidden\" name=\"productoID\" value=\"").concat(respuesta.datos.id, "\">\n\t\t\t\t\t<input type=\"hidden\" name=\"iva\" value=\"").concat(respuesta.datos.iva, "\">\n\t\t\t\t\t<input type=\"hidden\" name=\"dolar\" value=\"").concat(respuesta.datos.dolar, "\">\n\t\t\t\t\t<input type=\"hidden\" name=\"peso\" value=\"").concat(respuesta.datos.peso, "\">\n\t\t\t\t\t<button class=\"w3-margin-top w3-medium w3-button w3-blue w3-round-xlarge w3-hide w3-animate-bottom\">\n\t\t\t\t\t\t<span class=\"icon-plus\"></span>\n\t\t\t\t\t\tA\xF1adir Producto\n\t\t\t\t\t</button>\n\t\t\t\t</div>\n\t\t\t");
    });
  });

  /*----------  AGREGAR PRODUCTO  ----------*/
  datosProducto.onsubmit = function (e) {
    e.preventDefault();
    var datos = {
      precio: datosProducto.precio.value,
      cantidad: datosProducto.cantidad.value,
      productoID: datosProducto.productoID.value,
      addProduct: true
    };
    $.post('backend/nuevaCompra.php', datos, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return notificacion(respuesta.ok).on('onShow', function () {
        return $('[href="views/nuevaCompra.php"]')[0].click();
      }).on('afterClose', function () {
        return contenedor.scrollTo(contenedor.scrollHeight);
      }).show();
    });
  };

  /** @type {HTMLFormElement} */
  var carrito = contenedor.querySelector('#carritoCompra');
  if (!carrito) return;
  carrito.onsubmit = function (e) {
    return e.preventDefault();
  };

  /*----------  ELIMINAR PRODUCTO  ----------*/
  $('[role="eliminarProducto"]').on('click', function (e) {
    e.preventDefault();
    var datos = {
      productoID: e.target.getAttribute('productoid'),
      eliminar: true
    };
    $.post('backend/nuevaCompra.php', datos, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return notificacion(respuesta.ok).on('onShow', function () {
        return $('[href="views/nuevaCompra.php"]')[0].click();
      }).on('afterClose', function () {
        return contenedor.scrollTo(contenedor.scrollHeight);
      }).show();
    });
  });

  /*----------  ANULAR COMPRA  ----------*/
  $('[role="anularCompra"]').on('click', function () {
    $.post('backend/nuevaCompra.php', {
      anular: true
    }, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return informacion(respuesta.ok).on('onShow', function () {
        return $('[href="views/nuevaCompra.php"]')[0].click();
      }).show();
    });
  });

  /*----------  GENERAR COMPRA  ----------*/
  $('[role="generarCompra"]').on('click', function () {
    $.post('backend/nuevaCompra.php', {
      generar: true
    }, function (res) {
      /** @type {Respuesta} */
      var respuesta = JSON.parse(res);
      if (respuesta.error) return alerta(respuesta.error).show();
      return notificacion(respuesta.ok).on('onShow', function () {
        return $('[href="views/nuevaCompra.php"]')[0].click();
      }).show();
    });
  });
};

/** Comportamiento de la navegación */
var navegacion = function navegacion() {
  $('a[role="navegacion"]').each(function (_i, enlace) {
    enlace.addEventListener('click', function (e) {
      /** @type {HTMLAnchorElement} */
      var enlace = e.currentTarget;
      e.preventDefault();
      main.classList.add('showLoader');
      if (document.body.offsetWidth < 993) $('[role="menuOverlay"]')[0].click();

      // Quitamos el resaltado azul a todos los enlaces.
      $('a').each(function (_i, enlace) {
        return enlace.classList.remove('w3-blue');
      });

      // Si el enlace redirecciona a la nueva venta.
      if (enlace.href.includes('nuevaVenta.php')) $('a.w3-bar-item[href$="nuevaVenta.php"]').addClass('w3-blue');

      // Si el enlace redirecciona a la nueva venta.
      if (enlace.href.includes('nuevaCompra.php')) $('a.w3-bar-item[href$="nuevaCompra.php"]').addClass('w3-blue');

      // Si el enlace redirecciona a las ventas.
      if (enlace.href.includes('ventas.php')) $('a.w3-bar-item[href$="ventas.php"]').addClass('w3-blue');

      // Si el enlace redirecciona a las ventas.
      if (enlace.href.includes('compras.php')) $('a.w3-bar-item[href$="compras.php"]').addClass('w3-blue');

      // Si el enlace redirecciona al inventario.
      if (enlace.href.includes('inventario.php')) $('a.w3-bar-item[href$="inventario.php"]').addClass('w3-blue');

      // Si el enlace redirecciona a los usuarios.
      if (enlace.href.includes('usuarios.php')) $('a.w3-bar-item[href$="usuarios.php"]').addClass('w3-blue');

      // Si el enlace redirecciona a los clientes.
      if (enlace.href.includes('clientes.php')) $('a.w3-bar-item[href$="clientes.php"]').addClass('w3-blue');

      // Si el enlace redirecciona a la página principal.
      if (enlace.href.includes('dashboard.php'))
        // Espera unos segundos para simular :D
        return setTimeout(function () {
          // Pinta el enlace de azul sólo si está en el menú lateral.
          if (enlace.classList.contains('w3-bar-item')) enlace.classList.add('w3-blue');
          /*En caso que se haga click en el nombre del negocio, colorea
          el enlace en el menú lateral.*/
          $('a.w3-bar-item[href="dashboard.php"]').addClass('w3-blue');

          // Reinicia los acordeones del menú lateral.
          $('nav summary').each(function (_i, summary) {
            summary.classList.remove('w3-blue');
            summary.parentElement.classList.remove('abierto');
          });

          // Oculta el menú sólo en móviles.
          if (document.body.scrollWidth <= 600) overlay.click();

          // Oculta el loader.
          main.classList.remove('showLoader');
          // Carga la el Panel Principal.
          main.innerHTML = dashboardHTML;
          // Reajusta la navegación del Panel Principal.
          navegacion();
        }, 500);

      // Si no es un enlace al Panel Principal, solicita la vista
      $.get(enlace.getAttribute('href'), function (res) {
        // Sólo pinta los enlaces del menú.
        if (!enlace.href.includes('miPerfil.php')) enlace.classList.add('w3-blue');

        // Si el enlace está dentro de un acordeón
        if (enlace.href.includes('usuarios.php') || enlace.href.includes('log.php') || enlace.href.includes('compras.php') || enlace.href.includes('nuevaCompra.php')) {
          // Cierra todos los acordeones
          $('nav summary').each(function (_i, summary) {
            summary.classList.remove('w3-blue');
            if (summary.parentElement) summary.parentElement.classList.remove('abierto');
          });

          // Pinta el acordeón del enlace.
          if (enlace.parentElement.previousElementSibling && enlace.parentElement.parentElement) {
            enlace.parentElement.previousElementSibling.classList.add('w3-blue');
            enlace.parentElement.parentElement.classList.add('abierto');
          }
        } else $('nav summary').each(function (_i, summary) {
          // Si el enlace no está dentro de un acordeón, reinicia los acordeones.
          summary.classList.remove('w3-blue');
          summary.parentElement.classList.remove('abierto');
        });

        // Cierra el menú sólo en móvil.
        if (document.body.scrollWidth <= 600) overlay.click();
        // Quita el loader
        main.classList.remove('showLoader');
        // Carga la vista
        main.innerHTML = res;

        // Funcionalidades de la vista cargada.
        if ($('#moduloUsuarios')[0]) moduloUsuarios($('#moduloUsuarios')[0]);
        if ($('#moduloLog')[0]) moduloLog($('#moduloLog')[0]);
        if ($('#moduloClientes')[0]) moduloClientes($('#moduloClientes')[0]);
        if ($('#moduloProveedores')[0]) moduloProveedores($('#moduloProveedores')[0]);
        if ($('#moduloPerfil')[0]) moduloPerfil($('#moduloPerfil')[0]);
        if ($('#moduloNegocios')[0]) moduloNegocios($('#moduloNegocios')[0]);
        if ($('#moduloFinanzas')[0]) moduloFinanzas($('#moduloFinanzas')[0]);
        if ($('#moduloInventario')[0]) moduloInventario($('#moduloInventario')[0]);
        if ($('#moduloVentas')[0]) moduloVentas($('#moduloVentas')[0]);
        if ($('#moduloCompras')[0]) moduloCompras($('#moduloCompras')[0]);
        if ($('#moduloNuevaCompra')[0]) moduloNuevaCompra($('#moduloNuevaCompra')[0]);
        if ($('#moduloNuevaVenta')[0]) moduloNuevaVenta($('#moduloNuevaVenta')[0]);
      });
    });
  });
  $('details').each(function (_i, details) {
    return mostrarDetails(details);
  });
};