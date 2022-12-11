"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
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
    botonActualizarDatos.classList.replace("w3-hide", "w3-show");
    // Ocultar
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
    botonActualizarPreguntas.classList.replace("w3-hide", "w3-show");
    // Ocultar
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
  var btnRespaldar = w3.getElement("#boton-respaldar");
  btnRespaldar.addEventListener("click", function () {
    Swal.fire({
      title: "¿Desea crear una copia de seguridad de todos los datos?",
      showCancelButton: true,
      confirmButtonText: "Crear",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#223a5e",
      cancelButtonColor: "#a6001a",
      reverseButtons: true,
      showCloseButton: true,
      showLoaderOnConfirm: true,
      preConfirm: function () {
        var _preConfirm = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
          return _regeneratorRuntime().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  _context.next = 2;
                  return axios("php/respaldarBD.php", {
                    params: {
                      respaldar: true
                    }
                  });
                case 2:
                  return _context.abrupt("return", _context.sent);
                case 3:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee);
        }));
        function preConfirm() {
          return _preConfirm.apply(this, arguments);
        }
        return preConfirm;
      }()
    }).then(function (resultado) {
      if (!resultado.isDismissed && resultado.value.status == 200 && resultado.value.data) {
        notificacion("Copia de seguridad creada exitósamente", false);
      } else if (!resultado.isDismissed) {
        alerta("Ha ocurrido un error, por favor intente nuevamente");
        btnRespaldar.click();
      }
    });
  });
  var btnRestaurar = w3.getElement("#boton-restaurar");
  btnRestaurar.addEventListener("click", function () {
    Swal.fire({
      title: "Tener en cuenta que al restaurar se perderán cambios que no hayan sido respaldados",
      html: "<b class='w3-text-red'>¿Desea continuar?</b>",
      showCancelButton: true,
      confirmButtonText: "Continuar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#223a5e",
      cancelButtonColor: "#a6001a",
      reverseButtons: true,
      showCloseButton: true,
      showLoaderOnConfirm: true,
      preConfirm: function () {
        var _preConfirm2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
          return _regeneratorRuntime().wrap(function _callee2$(_context2) {
            while (1) {
              switch (_context2.prev = _context2.next) {
                case 0:
                  _context2.next = 2;
                  return axios("php/restaurarBD.php", {
                    params: {
                      restaurar: true
                    }
                  });
                case 2:
                  return _context2.abrupt("return", _context2.sent);
                case 3:
                case "end":
                  return _context2.stop();
              }
            }
          }, _callee2);
        }));
        function preConfirm() {
          return _preConfirm2.apply(this, arguments);
        }
        return preConfirm;
      }()
    }).then(function (resultado) {
      if (!resultado.isDismissed && resultado.value.status == 200 && resultado.value.data) {
        Swal.fire({
          title: "Copia de seguridad restaurada exitósamente",
          html: '<b class="w3-xlarge w3-text-green">REINICIANDO EL SISTEMA</b>',
          icon: "success",
          timer: 3000,
          timerProgressBar: true,
          allowOutsideClick: false,
          allowEscapeKey: false,
          allowEnterKey: false,
          showConfirmButton: false
        });
        setTimeout(function () {
          var href = window.location.href;
          href = href.replace(/negocio/g, function (coincidencia) {
            coincidencia = 'salir';
            console.log(coincidencia);
          });
          window.location.href = href;
        }, 3000);
      } else if (!resultado.isDismissed) {
        alerta("Ha ocurrido un error, por favor intente nuevamente");
        btnRestaurar.click();
      }
    });
  });
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
    boton.addEventListener("click", function () {
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
    boton.addEventListener("click", function () {
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
if (w3.getElement('#formEditar')) {
  var form = w3.getElement('#formEditar');
  ventanaEmergente(form, overlay);
}

/*===================================
=            VER FACTURA            =
===================================*/
if (w3.getElement('#modalFactura')) {
  var _form = w3.getElement('form[method="POST"]');
  _form.onsubmit = function (e) {
    return e.preventDefault();
  };
  var modalFactura = w3.getElement('#modalFactura');
  var botones = w3.getElements('a[name="factura"]');
  botones.forEach(function (boton) {
    return modal(boton, modalFactura, overlay);
  });
}

/*===========================
=            LOG            =
===========================*/
if (w3.getElement("#log")) {
  var btnVaciar = w3.getElement("#boton-vaciar");
  btnVaciar.addEventListener("click", function () {
    axios(location.href, {
      params: {
        vaciar: true
      }
    }).then(function () {
      return location.reload();
    });
  });
}

/*================================
=            FINANZAS            =
================================*/