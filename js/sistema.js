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
  var formDatosPerfil = w3.getElement("#formPerfil");
  var formActualizarClave = w3.getElement("#formClave");
  var formActualizarPreguntas = w3.getElement("#formPreguntas");
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
  modal(botonActualizarDatos, formDatosPerfil, overlay);
  modal(botonActualizarClave, formActualizarClave, overlay);
  modal(botonActualizarPreguntas, formActualizarPreguntas, overlay);
  botonSobreMi.addEventListener("click", function () {
    // Mostrar
    panelSobreMi.classList.add("w3-animate-opacity");
    panelSobreMi.classList.replace("w3-hide", "w3-show");
    sobreMi.classList.add("w3-animate-opacity");
    sobreMi.classList.replace("w3-hide", "w3-show");
    botonActualizarDatos.classList.replace("w3-hide", "w3-show"); // Ocultar

    panelSeguridad.classList.remove("w3-animate-opacity");
    panelSeguridad.classList.replace("w3-show", "w3-hide");
    infoClave.classList.remove("w3-animate-opacity");
    infoClave.classList.replace("w3-show", "w3-hide");
    preguntas.classList.replace("w3-show", "w3-hide");
    botonActualizarClave.classList.replace("w3-show", "w3-hide");
    botonActualizarPreguntas.classList.replace("w3-show", "w3-hide");
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
  });
}
/*================================
=            NEGOCIOS            =
================================*/


if (w3.getElement("#negocios")) {
  var botonesNegocios = w3.getElements(".botonNegocio");
  var botonRegistrarNegocio = w3.getElement("#botonAgregarNegocio");
  var panelesNegocios = w3.getElements(".panelNegocio");
  var formRegistrarNegocio = w3.getElement("#formularioRegistrarNegocio");
  validar(formRegistrarNegocio);
  modal(botonRegistrarNegocio, formRegistrarNegocio, overlay);
  actualizarFoto();
  botonesNegocios.forEach(function (botonNegocio) {
    var id = botonNegocio.id.substring(12);
    var panelNegocio = w3.getElement("#panelNegocio".concat(id));
    var formNegocio = w3.getElement("#formularioActualizar".concat(id));
    var botonActualizar = w3.getElement("#botonActualizarNegocio".concat(id));
    modal(botonActualizar, formNegocio, overlay);
    validar(formNegocio);
    botonNegocio.addEventListener("click", function () {
      panelesNegocios.forEach(function (panel) {
        return panel.classList.replace("w3-show", "w3-hide");
      });
      panelNegocio.classList.replace("w3-hide", "w3-show");
    });
  });
}
/*=====================================
=            MODALES INDEX            =
=====================================*/


var modalAcercaDe = w3.getElement("#modalAcercaDe");
var version = w3.getElement("#version");
modal(version, modalAcercaDe, overlay);

if (w3.getElement("#index")) {
  axios.get("https://s3.amazonaws.com/dolartoday/data.json").then(function (respuesta) {
    var fecha = respuesta.data._timestamp.fecha;
    var dolarT = respuesta.data.USD.transferencia;
    var dolarE = respuesta.data.USD.efectivo;
    w3.getElement("#fD").innerHTML = "<i class=\"w3-small\">".concat(fecha, "</i>");
    w3.getElement("#dT").innerHTML = "<i class=\"w3-small\">Transferencia </i> ".concat(dolarT);
    w3.getElement("#dE").innerHTML = "<i class=\"w3-small\">Efectivo </i> ".concat(dolarE);
    w3.getElement("#dolarToday").classList.replace("w3-hide", "w3-show");
  })["catch"](function (error) {
    return console.log(error);
  });
  var enlaceRegistroCambios = w3.getElement("#registroCambios");
  var enlaceSoporteTecnico = w3.getElement("#soporteTecnico");
  var enlaceAcercaDe = w3.getElement("#acercaDeSistema");
  var enlaceManual = w3.getElement("#manualUsuario");
  var modalRegistroCambios = w3.getElement("#modalRegistroCambios");
  var modalSoporteTecnico = w3.getElement("#modalSoporteTecnico");
  var modalManual = w3.getElement("#modalManual");
  modal(enlaceRegistroCambios, modalRegistroCambios, overlay);
  modal(enlaceSoporteTecnico, modalSoporteTecnico, overlay);
  modal(enlaceAcercaDe, modalAcercaDe, overlay);
  modal(enlaceManual, modalManual, overlay);
  var botonActualizarMonedas = w3.getElement("#actualizarMonedas");
  var formMonedas = w3.getElement("#formMonedas");

  if (botonActualizarMonedas) {
    validar(formMonedas);
    modal(botonActualizarMonedas, formMonedas, overlay);
  }
}
/*==================================
=            INVENTARIO            =
==================================*/


if (w3.getElement("#inventario") && w3.getElements("input[name='editar']")) {
  var btnEdit = w3.getElements("input[name='editar']");
  var formEdit = w3.getElement("#formEditProducto");
  btnEdit.forEach(function (boton) {
    boton.addEventListener("click", function (e) {
      e.preventDefault();
      ventanaEmergente(formEdit, overlay);
      var data = boton.parentElement.parentElement.querySelectorAll("input[readonly]");
      var codigo = data[0].value;
      var nombre = data[1].value;
      var stock = data[2].value;
      var excento = data[3].value;
      var precio = data[4].value;
      formEdit.querySelector("input[name='codigo']").value = codigo;
      formEdit.querySelector("input[name='cod']").value = codigo;
      formEdit.querySelector("input[name='nombreProducto']").value = nombre;
      formEdit.querySelector("input[name='stock']").value = stock;
      formEdit.querySelector("input[name='precio']").value = precio;
      formEdit.querySelector("select[name='excento']").value = excento;
    });
  });
}
/*==================================
=            CLIENTES              =
==================================*/


if (w3.getElement("#clientes") && w3.getElements("input[name='editar']")) {
  var _btnEdit = w3.getElements("input[name='editar']");

  var _formEdit = w3.getElement("#formEditCliente");

  _btnEdit.forEach(function (boton) {
    boton.addEventListener("click", function (e) {
      e.preventDefault();
      ventanaEmergente(_formEdit, overlay);
      var data = boton.parentElement.parentElement.querySelectorAll("input[readonly]");
      var cedula = data[0].value;
      var nombre = data[1].value;
      _formEdit.querySelector("input[name='cedula']").value = cedula;
      _formEdit.querySelector("input[name='ci']").value = cedula;
      _formEdit.querySelector("input[name='nombre']").value = nombre;
    });
  });
}
/*==================================
=            PROVEEDOR             =
==================================*/


if (w3.getElement("#proveedores") && w3.getElements("input[name='editar']")) {
  var _btnEdit2 = w3.getElements("input[name='editar']");

  var _formEdit2 = w3.getElement("#formEditProveedor");

  _btnEdit2.forEach(function (boton) {
    boton.addEventListener("click", function (e) {
      e.preventDefault();
      ventanaEmergente(_formEdit2, overlay);
      var data = boton.parentElement.parentElement.querySelectorAll("input[readonly]");
      var id = data[0].value;
      var nombre = data[1].value;
      _formEdit2.querySelector("input[name='id']").value = id;
      _formEdit2.querySelector("input[name='nombreProveedor']").value = nombre;
    });
  });
}
/*========================================
=            MODALES REGISTRO            =
========================================*/


if (w3.getElement("#formularioRegistrarProducto")) {
  var botonRegistrarProducto = w3.getElement("#registrarProducto");
  var modalRegistroProducto = w3.getElement("#formularioRegistrarProducto");
  modal(botonRegistrarProducto, modalRegistroProducto, overlay);
  validar(modalRegistroProducto);
}

if (w3.getElement("#formularioRegistrarCliente")) {
  var botonRegistrarCliente = w3.getElement("#registrarCliente");
  var modalRegistroCliente = w3.getElement("#formularioRegistrarCliente");
  modal(botonRegistrarCliente, modalRegistroCliente, overlay);
  validar(modalRegistroCliente);
}

if (w3.getElement("#formularioRegistrarProveedor")) {
  var botonRegistrarProveedor = w3.getElement("#registrarProveedor");
  var modalRegistroProveedor = w3.getElement("#formularioRegistrarProveedor");
  modal(botonRegistrarProveedor, modalRegistroProveedor, overlay);
  validar(modalRegistroProveedor);
}

if (w3.getElement("#formularioRegistrarUsuario")) {
  var botonRegistrarUsuario = w3.getElement("#registrarUsuario");
  var modalRegistroUsuario = w3.getElement("#formularioRegistrarUsuario");
  modal(botonRegistrarUsuario, modalRegistroUsuario, overlay);
  validar(modalRegistroUsuario);
}
/*===================================
=            NUEVA VENTA            =
===================================*/


if (w3.getElement("#panelNuevaVenta")) {
  var actualizarPrecio = function actualizarPrecio() {
    inputTotal.value = (inputCantidad.value * inputPrecio.value.substring(2)).toFixed(2);
    botonAgregar.classList.add("w3-animate-right");
    botonAgregar.classList.replace("w3-hide", "w3-show");
  };

  var inputCliente = w3.getElements(".inputCliente");
  var botonesClientes = w3.getElements(".botonCliente");
  var dolar = parseFloat(w3.getElement("#dolar").textContent.substring(4));
  var peso = parseInt(w3.getElement("#peso").textContent);
  var tooltips = w3.getElement(".tooltip").children;
  botonesClientes.forEach(function (boton) {
    var spans = boton.children;
    boton.addEventListener("click", function (e) {
      var texto = spans[0].innerHTML;
      inputCliente[1].value = texto.substring(2);
      inputCliente[0].nextElementSibling.innerHTML = "v-" + texto.substring(2);
      inputCliente[0].value = spans[1].innerHTML;
    });
  });
  var inputsProducto = w3.getElements(".inputProducto");
  var inputCodigo = w3.getElement("input[name='codigo']");
  var inputStock = w3.getElement("input[name='stock']");
  var inputPrecio = w3.getElement("input[name='precioB']");
  var inputExcento = w3.getElement("input[name='excento']");
  var inputCantidad = w3.getElement("input[name='cantidad']");
  var inputTotal = w3.getElement("input[name='precioT']");
  var nombresProductos = w3.getElements(".nombreProducto");
  var botonAgregar = w3.getElement("input[name='agregarProducto']");
  nombresProductos.forEach(function (producto) {
    var spans = producto.children;
    producto.addEventListener("click", function () {
      inputsProducto[0].value = spans[0].innerHTML;
      inputsProducto[1].value = spans[0].innerHTML;
      inputCodigo.value = spans[1].innerHTML;
      inputStock.value = spans[2].innerHTML;
      inputExcento.value = spans[4].innerHTML;
      inputCantidad.setAttribute("max", spans[2].innerHTML);
      inputPrecio.value = spans[3].innerHTML;
      var precio = parseFloat(inputPrecio.value.substring(2));
      var precioBs = (dolar * precio).toFixed(2);
      var precioPesos = peso * precio;
      tooltips[0].innerHTML = "<b class=\"w3-block\">Bs. ".concat(precioBs, "</b>");
      tooltips[1].innerHTML = "<b class=\"w3-block\">Pesos. ".concat(precioPesos, "</b>");

      if (inputStock.value == "0") {
        inputStock.value = "Agotado";
        inputStock.classList.replace("w3-disabled", "w3-red");
        inputCantidad.setAttribute("disabled", "true");
      } else {
        inputCantidad.removeAttribute("disabled");
        inputStock.classList.replace("w3-red", "w3-disabled");
      }
    });
  });
  inputCantidad.addEventListener("change", actualizarPrecio);
  inputCantidad.addEventListener("keypress", actualizarPrecio);

  if (inputCantidad.value) {
    botonAgregar.classList.add("w3-animate-right");
    botonAgregar.classList.replace("w3-hide", "w3-show");
  }

  var _botonActualizarMonedas = w3.getElement("#actualizarMonedas");

  var _formMonedas = w3.getElement("#formMonedas");

  if (_botonActualizarMonedas) {
    validar(_formMonedas);
    modal(_botonActualizarMonedas, _formMonedas, overlay);
  }
}
/*====================================
=            NUEVA COMPRA            =
====================================*/


if (w3.getElement("#panelNuevaCompra")) {
  var _actualizarPrecio = function _actualizarPrecio() {
    _inputTotal.value = (_inputCantidad.value * _inputPrecio.value.substring(2)).toFixed(2);

    _botonAgregar.classList.add("w3-animate-right");

    _botonAgregar.classList.replace("w3-hide", "w3-show");
  };

  var inputProveedor = w3.getElements(".inputProveedor");
  var botonesProveedores = w3.getElements(".botonProveedor");

  var _dolar = parseFloat(w3.getElement("#dolar").textContent.substring(4));

  var _peso = parseInt(w3.getElement("#peso").textContent);

  var _tooltips = w3.getElement(".tooltip").children;
  botonesProveedores.forEach(function (boton) {
    var spans = boton.children;
    boton.addEventListener("click", function (e) {
      var texto = spans[0].innerHTML;
      inputProveedor[0].value = texto;
      inputProveedor[0].nextElementSibling.innerHTML = "ID-" + spans[1].innerHTML;
      inputProveedor[1].value = spans[1].innerHTML;
    });
  });

  var _inputsProducto = w3.getElements(".inputProducto");

  var _inputCodigo = w3.getElement("input[name='codigo']");

  var _inputStock = w3.getElement("input[name='stock']");

  var _inputPrecio = w3.getElement("input[name='precioB']");

  var _inputExcento = w3.getElement("input[name='excento']");

  var _inputCantidad = w3.getElement("input[name='cantidad']");

  var _inputTotal = w3.getElement("input[name='precioT']");

  var _nombresProductos = w3.getElements(".nombreProducto");

  var _botonAgregar = w3.getElement("input[name='agregarProducto']");

  if (_inputStock.value == "0") {
    _inputStock.value = "Agotado";

    _inputStock.classList.replace("w3-disabled", "w3-red");
  } else {
    _inputStock.classList.replace("w3-red", "w3-disabled");
  }

  _nombresProductos.forEach(function (producto) {
    var spans = producto.children;
    producto.addEventListener("click", function () {
      _inputsProducto[0].value = spans[0].innerHTML;
      _inputsProducto[1].value = spans[0].innerHTML;
      _inputCodigo.value = spans[1].innerHTML;
      _inputStock.value = spans[2].innerHTML;
      _inputPrecio.value = spans[3].innerHTML;
      var precio = parseFloat(_inputPrecio.value.substring(2));

      var precioBs = (_dolar * precio).toFixed(2);

      var precioPesos = _peso * precio;
      _tooltips[0].innerHTML = "<b class=\"w3-block\">Bs. ".concat(precioBs, "</b>");
      _tooltips[1].innerHTML = "<b class=\"w3-block\">Pesos. ".concat(precioPesos, "</b>");
      _inputExcento.value = spans[4].innerHTML;

      if (_inputStock.value == "0") {
        _inputStock.value = "Agotado";

        _inputStock.classList.replace("w3-disabled", "w3-red");
      } else {
        _inputStock.classList.replace("w3-red", "w3-disabled");
      }
    });
  });

  _inputCantidad.addEventListener("change", _actualizarPrecio);

  _inputCantidad.addEventListener("keydown", _actualizarPrecio);

  if (_inputCantidad.value) {
    _botonAgregar.classList.add("w3-animate-right");

    _botonAgregar.classList.replace("w3-hide", "w3-show");
  }

  var _botonActualizarMonedas2 = w3.getElement("#actualizarMonedas");

  var _formMonedas2 = w3.getElement("#formMonedas");

  if (_botonActualizarMonedas2) {
    validar(_formMonedas2);
    modal(_botonActualizarMonedas2, _formMonedas2, overlay);
  }
}
/*====================================
=            EDITAR DATOS            =
====================================*/


if (w3.getElement("#formEditar")) {
  var form = w3.getElement("#formEditar");
  ventanaEmergente(form, overlay);
}