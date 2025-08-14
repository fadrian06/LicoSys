const mensajes = {
  nombreNegocio: "El nombre debe tener entre 4 y 20 letras.",
  rif: "El RIF debe empezar con V o E seguido de 9 a 15 números.",
  telefono:
    "Introduce un teléfono válido. Ejemplos (+58 111-2222 o 04124442222)",
  direccion:
    "La dirección debe tener entre 4 y 50 letras, números y símbolos (, . - # /)",
  cedula: "La cédula debe tener entre 7 y 8 números.",
  nombre: "El nombre debe tener entre 4 y 20 letras.",
  usuario:
    "El usuario debe tener entre 4 y 20 letras, números o símbolos (- _)",
  clave:
    "La clave debe tener entre 4 y 20 letras, números o símbolos (- _ . @ # / *)",
  confirmar: "Ambas claves deben ser iguales.",
  pregunta: "Las preguntas deben tener entre 1 y 50 letras y símbolos (¿ ?)",
  respuesta: "Las respuestas deben tener entre 4 y 20 letras y números.",
  negocio: "Por favor seleccione un negocio",
  iva: "El IVA debe ser un número con decimales o un porcentaje.",
  dolar: "El monto en Bs. debe ser un número con o sin decimales.",
  pesos: "El monto en Pesos debe ser tener entre 1 y 4 números.",
  codigo:
    "El código debe tener entre 3 y 10 letras, números y símbolos ( - . # )",
  stock: "La existencia debe ser un número mayor a 0 sin decimales.",
  precio: "El precio debe ser un número con o sin decimales.",
  excento: "Debes seleccionar si el producto es excento o no.",
};

const expresiones = {
  // Entre 4 y 20 letras con espacios permitidos.
  nombreNegocio: /^[\wáÁéÉíÍóÓúÚñÑ\s]{4,20}$/i,

  // Comienza con V o E seguido de 9 a 15 números
  rif: /^(v|e){1}\d{9,15}$/i,

  // Ejemplos (04121112222 o +58 414-111-2222)
  telefono: /^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}$/,

  // Entre 4 y 50 letras, números o símbolos (, . - # /)
  direccion: /^([a-záÁéÉíÍóÓúÚñÑ\d,.\-#/]\s?){4,50}$/i,

  // Entre 7 y 8 números
  cedula: /^[^e]?[\d]{7,8}$/,

  // Entre 4 y 20 letras
  nombre: /^[a-záÁéÉíÍóÓúÚñÑ\s]{4,20}$/i,

  // Entre 4 y 20 letras, números y símbolos (- _)
  usuario: /^[\w-]{4,20}$/i,

  // Entre 4 y 20 letras, números y símbolos (- _ . @ # / *)
  clave: /^[!#$%&/=?¿¡@+.\-*\w]{4,20}$/i,

  // Entre 1 y 50 letras y símbolos (¿ ?)
  pregunta: /^[?a-záÁéÉíÍóÓúÚñÑ¿\s]+$/i,

  // Entre 4 y 50 letras y números
  respuesta: /^[a-záÁéÉíÍóÓúÚñÑ\d\s]{4,20}$/i,

  // Un número con decimales, o un porcentaje
  iva: /^((0\.\d)|[0-9]){2,3}$/,

  // Números con o sin decimales
  dolar: /^\d+\.?(\d{1,2})?$/,

  // Entre 1 y 4 números
  pesos: /^[^e]?\d{1,4}$/,

  // Entre 3 y 10 letras, números y símbolos ( - . # )
  codigo: /^[a-z\d-.#]{3,10}$/i,

  // Un número sin decimales
  stock: /^[^e]?[\d]+$/,

  // Un número con o sin decimales.
  precio: /^[\d.]+$/,
};

const campos = {
  nombreNegocio: false,
  rif: false,
  telefono: false,
  direccion: false,
  cedula: false,
  nombre: false,
  usuario: false,
  clave: false,
  confirmar: false,
  pregunta: false,
  respuesta: false,
  negocio: false,
  codigo: false,
  stock: false,
  precio: false,
  iva: false,
  dolar: false,
  pesos: false,
};

function correcto(input: HTMLInputElement): void {
  input.parentElement?.parentElement?.classList.remove("invalido");
  input.parentElement?.parentElement?.classList.add("valido");
}

function error(input: HTMLInputElement): void {
  input.parentElement?.parentElement?.classList.remove("valido");
  input.parentElement?.parentElement?.classList.add("invalido");
}

function validarCampo(
  expresion: RegExp,
  input: HTMLInputElement,
  campo: keyof typeof campos,
): void {
  if (expresion.test(input.value)) {
    correcto(input);
    campos[campo] = true;

    return;
  }

  error(input);
  campos[campo] = false;
}

/**
 * @param string Convierte cada inicial en mayúscula
 * @return El `string` convertido
 */
function mayuscula(string: string): string {
  const expresion = /(^[\wáÁéÉíÍóÓúÚñÑ]{1})|(\s+[\wáÁéÉíÍóÓúÚñÑ]{1})/g;
  const mayuscula = string.replace(expresion, (letra) => letra.toUpperCase());

  return mayuscula;
}

/**
 * @param clave `<input name="clave">`
 * @param confirmar `<input name="confirmar">`
 */
function compararClaves(clave: HTMLInputElement, confirmar: HTMLInputElement) {
  if (clave.value === confirmar.value) {
    correcto(confirmar);
    campos.confirmar = true;

    return;
  }

  error(confirmar);
  campos.confirmar = false;
}

function validarInput(event: KeyboardEvent | FocusEvent) {
  const input = event.target;

  switch (input.name) {
    case "nombreNegocio":
      validarCampo(expresiones[input.name], input, input.name);
      input.value = mayuscula(input.value);
      break;

    case "rif":
      validarCampo(expresiones[input.name], input, input.name);
      input.value = mayuscula(input.value);
      break;

    case "telefono":
      validarCampo(expresiones[input.name], input, input.name);
      break;

    case "direccion":
      validarCampo(expresiones[input.name], input, input.name);
      input.value = mayuscula(input.value);
      break;

    case "cedula":
      validarCampo(expresiones[input.name], input, input.name);
      break;

    case "nombre":
      validarCampo(expresiones[input.name], input, input.name);
      input.value = mayuscula(input.value);
      break;

    case "usuario":
      validarCampo(expresiones[input.name], input, input.name);
      break;

    case "clave":
      validarCampo(expresiones[input.name], input, input.name);
      break;

    case "confirmar":
      validarCampo(expresiones.clave, input, input.name);
      compararClaves(input.form.clave, input);
      break;

    case "pre1":
    case "pre2":
    case "pre3":
      validarCampo(expresiones.pregunta, input, "pregunta");
      break;

    case "res1":
    case "res2":
    case "res3":
      validarCampo(expresiones.respuesta, input, "respuesta");
      break;

    case "iva":
      validarCampo(expresiones[input.name], input, input.name);
      break;

    case "dolar":
      validarCampo(expresiones[input.name], input, input.name);
      break;

    case "pesos":
      validarCampo(expresiones[input.name], input, input.name);
      break;

    case "codigo":
      validarCampo(expresiones[input.name], input, input.name);
      input.value = input.value.toUpperCase();
      break;

    case "stock":
      validarCampo(expresiones[input.name], input, input.name);
      break;

    case "precio":
      validarCampo(expresiones[input.name], input, input.name);
      break;
  }
}

/**
 * @param form El `<form>`a validar. DEBE TENER UN ID de los siguientes:
 *
 * - registrarNegocio
 * - registrarAdmin
 * - registrarUsuario
 * - registrarPreguntasRespuestas
 * - registrarCliente
 * - registrarProveedor
 * - registrarProducto
 * - editarCliente
 * - editarProveedor
 * - editarUsuario
 * - login
 * - consultar
 * - preguntasRespuestas
 * - cambiarClave
 * - actualizarMonedas
 *
 * Los `input` deben tener alguno de los siguientes `name`
 *
 * - nombreNegocio
 * - rif
 * - telefono
 * - direccion
 * - cedula
 * - nombre
 * - usuario
 * - clave
 * - confirmar
 * - pre1, pre2 o pre3
 * - res1, res2 o res3
 * - iva
 * - dolar
 * - pesos
 * - codigo
 * - stock
 * - precio
 * @param [cb] Contiene el resultado de la validación, los datos a enviar y el Evento `submit`
 */
export default function validar(
  form: HTMLFormElement,
  cb: (
    error?: string,
    formData?: FormData,
    event?: SubmitEvent,
  ) => void = () => {},
) {
  const inputs = form?.querySelectorAll("input");

  const radios: NodeListOf<HTMLInputElement> = form?.querySelectorAll(
    'input[type="radio"]',
  );

  form?.addEventListener("submit", (e) => {
    const fd = new FormData(form);

    if (form.id === "registrarNegocio") {
      if (!campos.nombreNegocio) {
        e.preventDefault();

        error(form.nombreNegocio);

        return cb(mensajes.nombreNegocio);
      }

      if (!campos.rif) {
        e.preventDefault();
        error(form.rif);

        return cb(mensajes.rif);
      }

      if (form.telefono.value && !campos.telefono) {
        e.preventDefault();
        error(form.telefono);

        return cb(mensajes.telefono);
      }

      if (form.direccion.value && !campos.direccion) {
        e.preventDefault();
        error(form.direccion);

        return cb(mensajes.direccion);
      }
    }

    if (form.id === "registrarAdmin" || form.id === "registrarUsuario") {
      if (!campos.cedula) {
        e.preventDefault();
        error(form.cedula);

        return cb(mensajes.cedula);
      }

      if (!campos.nombre) {
        e.preventDefault();
        error(form.nombre);

        return cb(mensajes.nombre);
      }

      if (!campos.usuario) {
        e.preventDefault();
        error(form.usuario);

        return cb(mensajes.usuario);
      }

      if (!campos.clave) {
        e.preventDefault();
        error(form.clave);

        return cb(mensajes.clave);
      }

      if (!campos.confirmar) {
        e.preventDefault();
        error(form.confirmar);

        return cb(mensajes.confirmar);
      }

      if (form.telefono.value && !campos.telefono) {
        e.preventDefault();
        error(form.telefono);

        return cb(mensajes.telefono);
      }
    }

    if (form.id === "registrarPreguntasRespuestas") {
      if (!campos.pregunta) {
        e.preventDefault();
        error(form.pre1);
        error(form.pre2);
        error(form.pre3);

        return cb(mensajes.pregunta);
      }

      if (!campos.respuesta) {
        e.preventDefault();
        error(form.res1);
        error(form.res2);
        error(form.res3);

        return cb(mensajes.respuesta);
      }
    }

    if (form.id === "login") {
      for (let i = 0; i < radios.length; ++i)
        if (radios[i].checked) campos.negocio = true;

      if (!campos.negocio) {
        e.preventDefault();

        return cb(mensajes.negocio);
      }

      if (!campos.usuario) {
        e.preventDefault();
        error(form.usuario);

        return cb(mensajes.usuario);
      }

      if (!campos.clave) {
        e.preventDefault();
        error(form.clave);

        return cb(mensajes.clave);
      }
    }

    if (form.id === "consultar") {
      if (!campos.cedula) {
        e.preventDefault();
        error(form.cedula);

        return cb(mensajes.cedula);
      }

      if (!campos.usuario) {
        e.preventDefault();
        error(form.usuario);

        return cb(mensajes.usuario);
      }
    }

    if (form.id === "preguntasRespuestas") {
      if (!campos.respuesta) {
        e.preventDefault();
        error(form.res1);
        error(form.res2);
        error(form.res3);

        return cb(mensajes.respuesta);
      }
    }

    if (form.id === "cambiarClave") {
      if (!campos.clave) {
        e.preventDefault();
        error(form.clave);

        return cb(mensajes.clave);
      }

      if (!campos.confirmar) {
        e.preventDefault();
        error(form.confirmar);

        return cb(mensajes.confirmar);
      }
    }

    if (form.id === "actualizarMonedas") {
      if (!form.iva.value) {
        e.preventDefault();
        error(form.iva);

        return cb(mensajes.iva);
      }

      if (!form.dolar.value) {
        e.preventDefault();
        error(form.dolar);

        return cb(mensajes.dolar);
      }

      if (!form.pesos.value) {
        e.preventDefault();
        error(form.pesos);

        return cb(mensajes.pesos);
      }
    }

    if (form.id === "registrarProveedor") {
      if (!campos.cedula) {
        e.preventDefault();
        error(form.cedula);

        return cb(mensajes.cedula);
      }

      if (!campos.nombre) {
        e.preventDefault();
        error(form.nombre);

        return cb(mensajes.nombre);
      }

      if (!campos.rif) {
        e.preventDefault();
        error(form.rif);

        return cb(mensajes.rif);
      }

      if (!campos.nombreNegocio) {
        e.preventDefault();
        error(form.nombreNegocio);

        return cb(mensajes.nombreNegocio);
      }

      if (form.telefono.value && !campos.telefono) {
        e.preventDefault();
        error(form.telefono);

        return cb(mensajes.telefono);
      }

      if (form.direccion.value && !campos.direccion) {
        e.preventDefault();
        error(form.direccion);

        return cb(mensajes.direccion);
      }
    }

    if (form.id === "registrarCliente") {
      if (!campos.cedula) {
        e.preventDefault();
        error(form.cedula);

        return cb(mensajes.cedula);
      }

      if (!campos.nombre) {
        e.preventDefault();
        error(form.nombre);

        return cb(mensajes.nombre);
      }
    }

    if (form.id === "registrarProducto") {
      if (!campos.codigo) {
        e.preventDefault();
        error(form.codigo);

        return cb(mensajes.codigo);
      }

      if (!campos.nombre) {
        e.preventDefault();
        error(form.nombre);

        return cb(mensajes.nombre);
      }

      if (!campos.precio) {
        e.preventDefault();
        error(form.precio);

        return cb(mensajes.precio);
      }

      if (!form.excento.value) {
        e.preventDefault();
        error(form.excento);

        return cb(mensajes.excento);
      }

      if (form.stock.value && !campos.stock) {
        e.preventDefault();
        error(form.stock);

        return cb(mensajes.stock);
      }
    }

    if (form.id === "editarCliente") {
      if (!form.nombre.value || (form.nombre.value && !campos.nombre)) {
        e.preventDefault();
        error(form.nombre);

        return cb(mensajes.nombre);
      }
    }

    if (form.id === "editarProveedor") {
      if (!form.cedula.value || (form.cedula.value && !campos.cedula)) {
        e.preventDefault();
        error(form.cedula);

        return cb(mensajes.cedula);
      }

      if (!form.nombre.value || (form.nombre.value && !campos.nombre)) {
        e.preventDefault();
        error(form.nombre);

        return cb(mensajes.nombre);
      }

      if (!form.rif.value || (form.rif.value && !campos.rif)) {
        e.preventDefault();
        error(form.rif);

        return cb(mensajes.rif);
      }

      if (
        !form.nombreNegocio.value ||
        (form.nombreNegocio.value && !campos.nombreNegocio)
      ) {
        e.preventDefault();
        error(form.nombreNegocio);

        return cb(mensajes.nombreNegocio);
      }

      if (!form.telefono.value || (form.telefono.value && !campos.telefono)) {
        e.preventDefault();
        error(form.telefono);

        return cb(mensajes.telefono);
      }

      if (
        !form.direccion.value ||
        (form.direccion.value && !campos.direccion)
      ) {
        e.preventDefault();
        error(form.direccion);

        return cb(mensajes.direccion);
      }
    }

    if (form.id === "editarUsuario") {
      if (!campos.nombre) {
        e.preventDefault();
        error(form.nombre);

        return cb(mensajes.nombre);
      }

      if (!campos.usuario) {
        e.preventDefault();
        error(form.usuario);

        return cb(mensajes.usuario);
      }

      if (form.telefono.value && !campos.telefono) {
        e.preventDefault();
        error(form.telefono);

        return cb(mensajes.telefono);
      }
    }

    cb(undefined, fd, e);
  });

  for (let i = 0; i <= inputs?.length; ++i) {
    const input = inputs[i];

    if (!input) return;

    if (
      input.type !== "text" &&
      input.type !== "password" &&
      input.type !== "number" &&
      input.type !== "search" &&
      input.type !== "email" &&
      input.type !== "tel"
    )
      continue;

    input.onkeyup = validarInput;
    input.onblur = validarInput;
  }
}
