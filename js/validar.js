"use strict";

var mensajes = {
  nombreNegocio: 'El nombre debe tener entre 4 y 20 letras.',
  rif: 'El RIF debe empezar con V o E seguido de 9 a 15 números.',
  telefono: 'Introduce un teléfono válido. Ejemplos (+58 111-2222 o 04124442222)',
  direccion: 'La dirección debe tener entre 4 y 50 letras, números y símbolos (, . - # /)'
};
var expresiones = {
  // Entre 4 y 20 letras con espacios permitidos.
  nombreNegocio: /^[\wáÁéÉíÍóÓúÚñÑ\s]{4,20}$/i,
  nombreProducto: /^[\w-áÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
  // Comienza con V o E seguido de 9 a 15 números
  rif: /^(v|e){1}\d{9,15}$/i,
  // Ejemplos (04121112222 o +58 414-111-2222)
  telefono: /^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}$/,
  // Entre 4 y 50 letras, números o símbolos (, . - # /)
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

/**
 * @param  {HTMLInputElement} input
 */
var correcto = function correcto(input) {
  input.parentElement.parentElement.classList.remove('invalido');
  input.parentElement.parentElement.classList.add('valido');
};

/**
 * @param  {HTMLInputElement} input
 */
var error = function error(input) {
  input.parentElement.parentElement.classList.remove('valido');
  input.parentElement.parentElement.classList.add('invalido');
};

/**
 * @param  {RegExp} expresion
 * @param  {HTMLInputElement} input
 * @param  {string} campo
 * @param {?(error: string, FormData: FormData, e: SubmitEvent)} cb
 */
var validarCampo = function validarCampo(expresion, input, campo) {
  var cb = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : function () {};
  if (expresion.test(input.value)) {
    correcto(input);
    campos[campo] = true;
    return;
  }
  error(input);
  campos[campo] = false;
};

/**
 * @param  {string} string Convierte cada inicial en mayúscula
 * @return {string} El `string` convertido
 */
var mayuscula = function mayuscula(string) {
  var expresion = /(^[\wáÁéÉíÍóÓúÚñÑ]{1})|(\s+[\wáÁéÉíÍóÓúÚñÑ]{1})/g;
  var mayuscula = string.replace(expresion, function (letra) {
    return letra.toUpperCase();
  });
  return mayuscula;
};

/**
 * @param  {KeyboardEvent | FocusEvent} e Evento `keyup` o `blur`
 * @param {?(error: string, FormData: FormData, e: SubmitEvent)} cb
 */
var validarInput = function validarInput(e) {
  var cb = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function () {};
  /**
   * @type {HTMLInputElement}
   */
  var input = e.target;
  switch (input.name) {
    case 'nombreNegocio':
      validarCampo(expresiones[input.name], input, input.name);
      input.value = mayuscula(input.value);
      break;
    case 'rif':
      validarCampo(expresiones[input.name], input, input.name);
      input.value = mayuscula(input.value);
      break;
    case 'telefono':
      validarCampo(expresiones[input.name], input, input.name);
      break;
    case 'direccion':
      validarCampo(expresiones[input.name], input, input.name);
      input.value = mayuscula(input.value);
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
};

/**
 * @param  {HTMLFormElement} form El `<form>`a validar. DEBE TENER UN ID de los siguientes: <br><br>
 * <i>registrarNegocio <br></i>
 * <br>
 * <br>
 * Los `input` deben tener alguno de los siguientes `name` y `id` <br><br>
 * <i>nombreNegocio <br>
 * rif <br>
 * telefono <br>
 * direccion <br></i>
 * @param {?(error: string, FormData: FormData, e: SubmitEvent)} cb Contiene el resultado de la validación, los datos a enviar y el Evento `submit`
 */
var validar = function validar(form) {
  var cb = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function () {};
  var inputs = form.querySelectorAll('input');
  form.onsubmit = function (e) {
    var fd = new FormData(form);
    if (form.id === 'registrarNegocio') {
      if (!campos.nombreNegocio) {
        e.preventDefault();
        error(form.nombreNegocio);
        return cb(mensajes.nombreNegocio, fd, e);
      } else if (!campos.rif) {
        e.preventDefault();
        error(form.rif);
        return cb(mensajes.rif, fd, e);
      } else if (form.telefono.value && !campos.telefono) {
        e.preventDefault();
        error(form.telefono);
        return cb(mensajes.telefono, fd, e);
      } else if (form.direccion.value && !campos.direccion) {
        e.preventDefault();
        error(form.direccion);
        return cb(mensajes.direccion, fd, e);
      }
    }

    // if (idForm == "formMonedas") {
    // 	if (!campos.iva) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='iva']"));
    // 		alerta("Verifique el IVA");
    // 	}
    // 	if (!campos.dolar) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='dolar']"));
    // 		alerta("Verifique el monto en Bs.");
    // 	}
    // 	if (!campos.peso) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='peso']"));
    // 		alerta("Verifique el monto en Pesos");
    // 	}
    // }

    // if (idForm == "formAdmin" || idForm == "formLogin" || idForm == "formularioRegistrarUsuario" || idForm == "formPerfil") {
    // 	if (!campos.usuario) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='usuario']"));
    // 		alerta("Verifique el usuario");
    // 	}
    // }

    // if (idForm == "formAdmin" || idForm == "formularioRegistrarUsuario" || idForm == "formClave" || idForm == "formActualizarClave") {
    // 	if (!campos.clave) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='nuevaClave']"));
    // 		alerta("Verifique la contraseña");
    // 	} else if (!campos.confirmar) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='confirmar']"));
    // 		alerta("Las contraseñas deben ser iguales");
    // 	}
    // }

    // if (idForm == "formAdmin" || idForm == "formularioRegistrarCliente" || idForm == "formularioRegistrarUsuario" || idForm == "formPerfil") {
    // 	if (!campos.cedula) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='cedula']"));
    // 		alerta("Verifique la cédula");
    // 	} else if (!campos.nombre) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='nombre']"));
    // 		alerta("Verifique el nombre");
    // 	}
    // }

    // if (idForm == "formLogin") {
    // 	if (!campos.clave) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='clave']"));
    // 		alerta("Verifique la contraseña");
    // 	}
    // 	if (!campos.negocio) {
    // 		e.preventDefault();
    // 		alerta("Seleccione un negocio");
    // 	}
    // }

    // if (idForm == "formPreguntas" || idForm == "formActualizarPreguntas") {
    // 	if (!campos.respuesta) {
    // 		e.preventDefault();
    // 		inputs.forEach(input => error(input));
    // 		alerta('Verifique las respuestas');
    // 	}
    // }

    // if (idForm == "formularioRegistrarProducto" || idForm == "formEditProducto") {
    // 	if (!campos.codigo) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='codigo']"));
    // 		alerta("Verifique el código");
    // 	}
    // 	if (!campos.nombreProducto) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='nombreProducto'"));
    // 		alerta("Verifique el nombre");
    // 	}
    // 	if (!campos.stock) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='stock']"));
    // 		alerta("Verifique el campo 'Existencia'");
    // 	}
    // 	if (!campos.precio) {
    // 		e.preventDefault();
    // 		error(w3.getElement("input[name='precio']"));
    // 		alerta("Verifique el campo 'Precio'");
    // 	}

    // 	if (idForm == "formularioRegistrarProveedor") {
    // 		if (!campos.nombreProveedor) {
    // 			e.preventDefault();
    // 			error(w3.getElement("input[name='nombreProveedor']"));
    // 			alerta("Verifique el nombre");
    // 		}
    // 	}

    // 	if (idForm == "formPreguntas") {
    // 		if (!campos.pregunta) {
    // 			e.preventDefault();
    // 			inputs.foreach(input => {
    // 				if (input.name == "pregunta1" || input.name == "pregunta2" || input.name == "pregunta3") error(input);
    // 			});
    // 			alerta("Verifique que las preguntas estén bien escritas");
    // 		}
    // 	}
    // }

    cb(null, fd, e);
  };
  for (var i = 0; i <= inputs.length; ++i) {
    var input = inputs[i];
    if (!input) return;
    if (input.type !== 'text' && input.type !== 'password' && input.type !== 'number' && input.type !== 'search' && input.type !== 'email') continue;
    input.onkeyup = function (e) {
      return validarInput(e, cb);
    };
    input.onblur = function (e) {
      return validarInput(e, cb);
    };
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
};