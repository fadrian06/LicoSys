"use strict";

onoffline = function onoffline() {
  return advertencia("Se ha perdido la conexión");
};

ononline = function ononline() {
  return notificacion("Se ha restablecido la conexión");
};

if (w3.getElements(".icon-eye")) {
  var ojos = w3.getElements(".icon-eye");
  ojos.forEach(function (ojo) {
    return ojo.addEventListener("click", function (e) {
      return verClave(e.target);
    });
  });
}

w3.getElement = function (id) {
  return w3.getElements(id)[0];
};

function reloj(contenedor) {
  var fecha = new Date();
  var horas = fecha.getHours(),
      ampm,
      minutos = fecha.getMinutes(),
      diaSemana = fecha.getDay(),
      dia = fecha.getDate(),
      mes = fecha.getMonth(),
      year = fecha.getFullYear();
  var semana = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"];
  var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

  if (horas >= 12) {
    horas = horas - 12;
    ampm = "PM";
  } else {
    ampm = "AM";
  }

  if (horas == 0) horas = 12;
  if (minutos < 10) minutos = "0".concat(minutos);
  contenedor.innerHTML = "\n\t\t\t<div class=\"fecha\">\n\t\t\t\t<b id=\"diaSemana\">".concat(semana[diaSemana], "</b>\n\t\t\t\t<b id=\"dia\">").concat(dia, "</b>\n\t\t\t\t<b>de </b>\n\t\t\t\t<b id=\"mes\">").concat(meses[mes], "</b>\n\t\t\t\t<b>del </b>\n\t\t\t\t<b id=\"year\">").concat(year, "</b>\n\t\t\t</div>\n\t\t\t<div class=\"reloj\">\n\t\t\t\t<b id=\"horas\">").concat(horas, "</b>\n\t\t\t\t<b>:</b>\n\t\t\t\t<b id=\"minutos\">").concat(minutos, "</b>\n\t\t\t\t<b id=\"ampm\">").concat(ampm, "</b>\n\t\t\t</div>\n\t\t");
}

function menu(boton, modal, overlay) {
  boton.addEventListener("click", function (e) {
    overlay.classList.replace("w3-hide", "w3-show");
    overlay.style.cursor = "pointer";
    modal.classList.replace("w3-hide", "w3-show");
    modal.classList.replace("animate__animated", "w3-animate-left");
    modal.classList.remove("animate__slideOutLeft");
    modal.classList.remove("animate__faster");
  });
  overlay.addEventListener("click", function (e) {
    modal.classList.replace("w3-animate-left", "animate__animated");
    modal.classList.add("animate__slideOutLeft");
    modal.classList.add("animate__faster");
    e.target.classList.replace("w3-show", "w3-hide");
    setTimeout(function () {
      return modal.classList.replace("w3-show", "w3-hide");
    }, 500);
  });
}

function actualizarFoto() {
  var inputsFile = w3.getElements("input[type='file']");
  var images = w3.getElements("img.image-result");
  var submits = false;
  var spans = false;

  if (w3.getElements("input[name='actualizarFoto']")) {
    submits = w3.getElements("input[name='actualizarFoto']");
    spans = w3.getElements(".formFoto span");
  }

  function uploadImage(file) {
    var fileReader = new FileReader();
    fileReader.readAsDataURL(file);
    fileReader.addEventListener('load', function (e) {
      return images.forEach(function (img) {
        return img.setAttribute('src', e.target.result);
      });
    });
  }

  inputsFile.forEach(function (input) {
    input.addEventListener('change', function (e) {
      var file = e.target.files[0];

      if (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "image/png") {
        if (file.size < 1 * 1000 * 2048) {
          uploadImage(file);
          if (submits) submits.forEach(function (submit) {
            return submit.classList.remove("w3-hide");
          });
          if (spans) spans.forEach(function (span) {
            return span.classList.add("w3-animate-bottom");
          });
        } else {
          alerta('La imagen no puede ser mayor a <b class=\"w3-text-red\" title=\"2 Megabytes\">2MB</b>');
        }
      } else {
        alerta('Sólo se permiten imagenes (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)');
      }
    });
  });
}

function alerta() {
  var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
  var toast = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
  var timer = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 2000;

  if (toast) {
    var position = "bottom-end";
  } else {
    var position = "center";
  }

  Swal.fire({
    title: title,
    icon: 'error',
    toast: toast,
    timer: timer,
    timerProgressBar: true,
    position: position,
    showConfirmButton: false
  });
}

function notificacion() {
  var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
  var toast = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
  var timer = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 2000;

  if (toast) {
    var position = "bottom-end";
  } else {
    var position = "center";
  }

  Swal.fire({
    title: title,
    icon: "success",
    toast: toast,
    timer: timer,
    timerProgressBar: true,
    position: position,
    showConfirmButton: false
  });
}

function advertencia() {
  var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
  Swal.fire({
    title: title,
    icon: "warning",
    toast: true,
    timer: 3000,
    timerProgressBar: true,
    position: "bottom-start",
    showConfirmButton: false
  });
}

function verClave(ojo) {
  var input = ojo.parentElement.previousElementSibling;

  if (input.type == "password") {
    input.type = "text";
    ojo.className = "icon-eye-slash";
  } else {
    input.type = "password";
    ojo.className = "icon-eye";
  }
}

function validar(form) {
  var inputs = w3.getElements("#".concat(form.id, " input"));
  var radios = false;
  var idForm = form.id;

  if (w3.getElements("#".concat(form.id, " input[type=\"radio\"]"))) {
    radios = w3.getElements("#".concat(form.id, " input[type=\"radio\"]"));
  }

  var expresiones = {
    nombreNegocio: /^[\wáÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
    nombreProducto: /^[\w-áÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
    rif: /^(v|e){1}\d{9,15}$/i,
    telefono: /^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}$/,
    direccion: /^([a-záÁéÉíÍóÓúÚñÑ\d\,\.\-\#\/]\s?){4,50}$/i,
    cedula: /^[^e]?[\d]{7,8}$/,
    nombre: /^[a-záÁéÉíÍóÓúÚñÑ]{4,20}$/i,
    usuario: /^[\w-]{4,20}$/i,
    clave: /^[\w.-@#/*]{4,20}$/i,
    pregunta: /^[\?a-záÁéÉíÍóÓúÚñÑ¿\s]+$/i,
    respuesta: /^[a-záÁéÉíÍóÓúÚñÑ\d]{4,20}$/i,
    codigo: /^[a-z\d-.#]{3,10}$/i,
    stock: /^[^e]?[\d]+$/,
    precio: /^[\d.]+$/,
    iva: /^0\.\d{2,3}$/,
    dolar: /^\d+(\.\d{1,2})?$/,
    peso: /^[^e]?\d{1,4}$/
  };
  var campos = {
    nombreNegocio: false,
    nombreProducto: false,
    nombreProveedor: false,
    rif: false,
    telefono: false,
    direccion: false,
    cedula: false,
    nombre: false,
    usuario: false,
    clave: false,
    confirmar: false,
    negocio: false,
    pregunta: false,
    respuesta: false,
    codigo: false,
    stock: false,
    precio: false,
    iva: false,
    dolar: false,
    peso: false
  };

  function validarInput(e) {
    switch (e.target.name) {
      case "nombreNegocio":
        validarCampo(expresiones.nombreNegocio, e.target, "nombreNegocio");
        e.target.value = mayuscula(e.target.value);
        break;

      case "rif":
        validarCampo(expresiones.rif, e.target, "rif");
        e.target.value = mayuscula(e.target.value);
        break;

      case "telefono":
        validarCampo(expresiones.telefono, e.target, "telefono");
        break;

      case "direccion":
        validarCampo(expresiones.direccion, e.target, "direccion");
        e.target.value = mayuscula(e.target.value);
        break;

      case "cedula":
        validarCampo(expresiones.cedula, e.target, "cedula");
        break;

      case "nombre":
        validarCampo(expresiones.nombre, e.target, "nombre");
        e.target.value = mayuscula(e.target.value);
        break;

      case "usuario":
        validarCampo(expresiones.usuario, e.target, "usuario");
        break;

      case "nuevaClave":
        validarCampo(expresiones.clave, e.target, "clave");
        break;

      case "confirmar":
        validarCampo(expresiones.clave, e.target, "confirmar");
        compararClaves();
        break;

      case "clave":
        validarCampo(expresiones.clave, e.target, "clave");
        break;

      case "respuesta1":
      case "respuesta2":
      case "respuesta3":
        validarCampo(expresiones.respuesta, e.target, "respuesta");
        break;

      case "pregunta1":
      case "pregunta2":
      case "pregunta3":
        validarCampo(expresiones.pregunta, e.target, "pregunta");
        break;

      case "codigo":
        validarCampo(expresiones.codigo, e.target, "codigo");
        e.target.value = e.target.value.toUpperCase();
        break;

      case "nombreProducto":
        validarCampo(expresiones.nombreProducto, e.target, "nombreProducto");
        e.target.value = mayuscula(e.target.value);
        break;

      case "stock":
        validarCampo(expresiones.stock, e.target, "stock");
        break;

      case "precio":
        validarCampo(expresiones.precio, e.target, "precio");
        break;

      case "nombreProveedor":
        validarCampo(expresiones.nombreNegocio, e.target, "nombreProveedor");
        e.target.value = mayuscula(e.target.value);
        break;

      case "iva":
      case "dolar":
        validarCampo(expresiones.iva, e.target, "iva");
        validarCampo(expresiones.dolar, e.target, "dolar");
        break;

      case "peso":
        validarCampo(expresiones.peso, e.target, "peso");
        break;
    }
  }

  function error(input) {
    if (input.type == "text" || input.type == "password" || input.type == "number") {
      input.parentElement.style = "outline: thick solid var(--error)";
      input.classList.add("incorrecto");
      input.previousElementSibling.style = "background:var(--error);color:white";
    }
  }

  function correcto(input) {
    if (input.type == "text" || input.type == "password" || input.type == "number") {
      input.parentElement.style = "outline: thin solid var(--negro)";
      input.classList.remove("incorrecto");
      input.previousElementSibling.style = "background:var(--primario);color:black";
    }
  }

  function verificar(e) {
    if (radios) {
      radios.forEach(function (radio) {
        if (radio.checked) campos.negocio = true;
      });
    }

    if (idForm == "formNegocio") {
      if (!campos.nombreNegocio) {
        e.preventDefault();
        error(w3.getElement("input[name='nombreNegocio']"));
        alerta("Verifique el nombre del negocio");
      } else if (!campos.rif) {
        e.preventDefault();
        error(w3.getElement("input[name='rif']"));
        alerta("Verifique el RIF");
      }
    }

    if (idForm == "formMonedas") {
      if (!campos.iva) {
        e.preventDefault();
        error(w3.getElement("input[name='iva']"));
        alerta("Verifique el IVA");
      }

      if (!campos.dolar) {
        e.preventDefault();
        error(w3.getElement("input[name='dolar']"));
        alerta("Verifique el monto en Bs.");
      }

      if (!campos.peso) {
        e.preventDefault();
        error(w3.getElement("input[name='peso']"));
        alerta("Verifique el monto en Pesos");
      }
    }

    if (idForm == "formAdmin" || idForm == "formLogin" || idForm == "formularioRegistrarUsuario" || idForm == "formPerfil") {
      if (!campos.usuario) {
        e.preventDefault();
        error(w3.getElement("input[name='usuario']"));
        alerta("Verifique el usuario");
      }
    }

    if (idForm == "formAdmin" || idForm == "formularioRegistrarUsuario" || idForm == "formClave" || idForm == "formActualizarClave") {
      if (!campos.clave) {
        e.preventDefault();
        error(w3.getElement("input[name='nuevaClave']"));
        alerta("Verifique la contraseña");
      } else if (!campos.confirmar) {
        e.preventDefault();
        error(w3.getElement("input[name='confirmar']"));
        alerta("Las contraseñas deben ser iguales");
      }
    }

    if (idForm == "formAdmin" || idForm == "formularioRegistrarCliente" || idForm == "formularioRegistrarUsuario" || idForm == "formPerfil") {
      if (!campos.cedula) {
        e.preventDefault();
        error(w3.getElement("input[name='cedula']"));
        alerta("Verifique la cédula");
      } else if (!campos.nombre) {
        e.preventDefault();
        error(w3.getElement("input[name='nombre']"));
        alerta("Verifique el nombre");
      }
    }

    if (idForm == "formLogin") {
      if (!campos.clave) {
        e.preventDefault();
        error(w3.getElement("input[name='clave']"));
        alerta("Verifique la contraseña");
      }

      if (!campos.negocio) {
        e.preventDefault();
        alerta("Seleccione un negocio");
      }
    }

    if (idForm == "formPreguntas" || idForm == "formActualizarPreguntas") {
      if (!campos.respuesta) {
        e.preventDefault();
        inputs.forEach(function (input) {
          return error(input);
        });
        alerta('Verifique las respuestas');
      }
    }

    if (idForm == "formularioRegistrarProducto" || idForm == "formEditProducto") {
      if (!campos.codigo) {
        e.preventDefault();
        error(w3.getElement("input[name='codigo']"));
        alerta("Verifique el código");
      }

      if (!campos.nombreProducto) {
        e.preventDefault();
        error(w3.getElement("input[name='nombreProducto'"));
        alerta("Verifique el nombre");
      }

      if (!campos.stock) {
        e.preventDefault();
        error(w3.getElement("input[name='stock']"));
        alerta("Verifique el campo 'Existencia'");
      }

      if (!campos.precio) {
        e.preventDefault();
        error(w3.getElement("input[name='precio']"));
        alerta("Verifique el campo 'Precio'");
      }

      if (idForm == "formularioRegistrarProveedor") {
        if (!campos.nombreProveedor) {
          e.preventDefault();
          error(w3.getElement("input[name='nombreProveedor']"));
          alerta("Verifique el nombre");
        }
      }

      if (idForm == "formPreguntas") {
        if (!campos.pregunta) {
          e.preventDefault();
          inputs.foreach(function (input) {
            if (input.name == "pregunta1" || input.name == "pregunta2" || input.name == "pregunta3") error(input);
          });
          alerta("Verifique que las preguntas estén bien escritas");
        }
      }
    }
  }

  function compararClaves() {
    var clave1 = w3.getElement("input[name='nuevaClave']");
    var clave2 = w3.getElement("input[name='confirmar']");

    if (clave1.value == clave2.value) {
      correcto(clave2);
      campos.confirmar = true;
    } else {
      error(clave2);
      campos.confirmar = false;
    }
  }

  function validarCampo(expresion, input, campo) {
    if (expresion.test(input.value)) {
      correcto(input);
      campos[campo] = true;
    } else {
      error(input);
      campos[campo] = false;
    }
  }

  inputs.forEach(function (input) {
    input.addEventListener('keyup', validarInput);
    input.addEventListener('blur', validarInput);
  });
  form.addEventListener('submit', verificar);
}

function mayuscula(string) {
  var expresion = /(^[\wáÁéÉíÍóÓúÚñÑ]{1})|(\s+[\wáÁéÉíÍóÓúÚñÑ]{1})/g;
  var mayuscula = string.replace(expresion, function (letra) {
    return letra.toUpperCase();
  });
  return mayuscula;
}

function modal(boton, formulario, overlay) {
  boton.addEventListener("click", function (e) {
    e.preventDefault();
    ventanaEmergente(formulario, overlay);
  });
}

function ventanaEmergente(formulario, overlay) {
  var cerrar = formulario.querySelector("span");
  overlay.classList.replace("w3-hide", "w3-show");
  overlay.style.cursor = "pointer";
  formulario.classList.replace("w3-hide", "w3-show");
  formulario.classList.replace("animate__fadeOutDown", "animate__fadeInUp");
  overlay.addEventListener("click", function (e) {
    e.target.classList.replace("w3-show", "w3-hide");
    formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
    setTimeout(function () {
      return formulario.classList.replace("w3-show", "w3-hide");
    }, 500);
  });
  cerrar.addEventListener("click", function (e) {
    e.target.classList.replace("w3-show", "w3-hide");
    overlay.classList.replace("w3-show", "w3-hide");
    formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
    setTimeout(function () {
      return formulario.classList.replace("w3-show", "w3-hide");
    }, 500);
  });
} // Filter


function filterFunction(input, div) {
  var filter, ul, li, a;
  div = document.getElementById(div);
  input = document.getElementById(input);
  filter = input.value.toUpperCase();
  a = div.getElementsByTagName("button");

  for (var i = 0; i < a.length; i++) {
    var txtValue = a[i].textContent || a[i].innerText;

    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}