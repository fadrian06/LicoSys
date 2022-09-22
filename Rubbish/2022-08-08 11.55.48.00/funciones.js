"use strict";

onoffline = function onoffline() {
  return advertencia("Se ha perdido la conexión");
};

ononline = function ononline() {
  return notificacion("Se ha restablecido la conexión");
};

w3.getElement = function (id) {
  return w3.getElements(id)[0];
};

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
      modal.classList.replace("w3-show", "w3-hide");
    }, 500);
  });
}

function actualizarFoto() {
  var inputsFile = w3.getElements("input[type='file']");
  var images = w3.getElements("img.image-result");
  var submits = false;
  var spans = false;

  if (w3.getElements("input[name='actualizarFoto']")) {
    var submits = w3.getElements("input[name='actualizarFoto']");
    var spans = w3.getElements(".formFoto span");
  }

  function uploadImage(file) {
    var fileReader = new FileReader();
    fileReader.readAsDataURL(file);
    fileReader.addEventListener('load', function (e) {
      images.forEach(function (img) {
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
  var timer = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 3000;

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

function notificacion(title) {
  var toast = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
  var timer = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 3000;

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

function advertencia(title) {
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
  var ojo = w3.getElement(ojo);
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
    var radios = w3.getElements("#".concat(form.id, " input[type=\"radio\"]"));
  }

  var expresiones = {
    nombreNegocio: /^[a-záÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
    rif: /^(v|e){1}\d{9,15}$/i,
    telefono: /^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}$/,
    direccion: /^([a-z\d\,\.\-\#\/]\s?){4,50}$/i,
    cedula: /^[^e]?[\d]{7,8}$/,
    nombre: /^[a-z]{4,20}$/i,
    usuario: /^(\w-?){4,20}$/i,
    clave: /^[\w.-@#/*]{4,20}$/i,
    respuesta: /^[a-z\d]{4,20}$/i,
    stock: /^[^e]?[\d]+$/,
    pregunta: /^[a-z]+$/i,
    codigo: /^[a-z\d\-\.\#]{4,10}$/i,
    precio: /^[\d\.]+$/
  };
  var campos = {
    nombreNegocio: false,
    rif: false,
    telefono: false,
    direccion: false,
    cedula: false,
    nombre: false,
    usuario: false,
    clave: false,
    confirmar: false,
    negocio: false,
    respuesta: false,
    pregunta: false,
    codigo: false,
    precio: false
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
        validarCampo(expresiones.pregunta, e.target, "usuario");
        validarCampo(expresiones.pregunta, e.target, "pregunta");
        break;

      case "codigo":
        validarCampo(expresiones.codigo, e.target, "clave");
        break;

      case "stock":
        validarCampo(expresiones.stock, e.target, "usuario");
        break;

      case "precio":
        validarCampo(expresiones.precio, e.target, "precio");
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

    if (idForm == "formAdmin" || idForm == "formLogin") {
      if (!campos.usuario) {
        e.preventDefault();
        error(w3.getElement("input[name='usuario']"));
        alerta("Verifique el usuario");
      }
    }

    if (idForm == "formAdmin" || idForm == "formUsuario" || idForm == "formClave" || idForm == "formActualizarClave") {
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

    if (idForm == "formAdmin") {
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
  var cerrar = w3.getElement("#".concat(formulario.id, ">span"));
  overlay.classList.replace("w3-hide", "w3-show");
  overlay.style.cursor = "pointer";
  formulario.classList.replace("w3-hide", "w3-show");
  formulario.classList.replace("animate__fadeOutDown", "animate__fadeInUp");
  overlay.addEventListener("click", function () {
    this.classList.replace("w3-show", "w3-hide");
    formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
    setTimeout(function () {
      formulario.classList.replace("w3-show", "w3-hide");
    }, 500);
  });
  cerrar.addEventListener("click", function (e) {
    this.classList.replace("w3-show", "w3-hide");
    overlay.classList.replace("w3-show", "w3-hide");
    formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
    setTimeout(function () {
      formulario.classList.replace("w3-show", "w3-hide");
    }, 500);
  });
} // Filter


function filterFunction(input, div) {
  var input, filter, ul, li, a, i;
  input = document.getElementById(input);
  filter = input.value.toUpperCase();
  div = document.getElementById(div);
  a = div.getElementsByTagName("a");

  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;

    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

function precioTotal() {
  var cantidad = document.getElementById('cantidad').value;
  var precioB = document.getElementById('precio').value;
  var precioT = document.getElementById('precioT');

  if (cantidad != "") {
    precioT.value = (precioB * cantidad).toFixed(2);
  }
}