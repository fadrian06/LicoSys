import $ from "jquery";
import Noty from "noty";
import w3 from "w3s";
import validar from "./validar";

export interface Respuesta {
  ok: string;
  error: string;
  datos: object;
}

export type RespuestaCruda = string;

Noty.overrideDefaults({ theme: "sunset" });

/**
 * Comportamiento de un acordión de filas en una tabla.
 * <u>Requisitos</u>
 *
 * - Cada acordeón debe tener el atributo `role="accordion`
 * - Cada acordeón debe tener un botón que sirva para abrir y cerrar
 * - Cada acordeón debe tener una flecha que indique su estado
 */
export function acordeon(): void {
  const acordeones = document.querySelectorAll('[role="accordion"]');

  for (let i = 0; i < acordeones.length; ++i) {
    const boton = acordeones[i].firstElementChild as HTMLButtonElement | null;
    const flecha = boton?.querySelector('[class^="icon-chevron"]');

    if (!boton) {
      console.warn(
        "El acordeón debe tener un botón para abrir y cerrar el acordeón.",
      );
    } else {
      boton.onclick = () => {
        boton.nextElementSibling?.classList.toggle("w3-hide");
        boton.nextElementSibling?.classList.toggle("w3-show");

        if (flecha) {
          flecha.classList.toggle("icon-chevron-right");
          flecha.classList.toggle("icon-chevron-down");
        }
      };
    }
  }
}

/** Redirige a una ruta especificada. */
export function redirigir(destino: string): void {
  let href = location.href.split("/");
  href[href.length - 1] = destino;
  href = href.join("/");
  location.href = href;
}

/**
 * Comportamiento de un Dropdown Click
 * @param id El ID del content (incluido el '#')
 */
export function dropdown(id: string): void {
  const content = document.querySelector(id) as HTMLElement | null;

  content?.classList.toggle("w3-show");
}

/** Comportamiento de un elemento `<details> para navegadores que no lo soportan`. */
export const mostrarDetails = (details: HTMLDetailsElement): void => {
  const summary = details.querySelector("summary");
  const flecha = summary?.querySelector('[class^="icon-chevron"]');

  if (!summary) {
    console.warn(
      "El elemento <details> debe tener un <summary> para poder abrir y cerrar.",
    );

    return;
  }

  summary.onclick = () => {
    details.removeAttribute("open");
    details.classList.toggle("abierto");
    if (flecha) {
      flecha.classList.toggle("icon-chevron-right");
      flecha.classList.toggle("icon-chevron-down");
    }
  };
};

/** Reajusta la estructura del LicoSys, dependiendo la resolución. */
export function reajustar(): void {
  if (document.body.offsetWidth < 992) {
    $("main").css("margin-left", "0");

    return;
  }

  $("main").css("margin-left", "250px");
}

/** Define el comportamiento de un menú lateral. */
export function menu(): void {
  const boton = document.querySelector(".icon-bars")
    ?.parentElement as HTMLButtonElement | null;
  const overlay = document.querySelector(
    '[role="menuOverlay"]',
  ) as HTMLDivElement | null;
  const menu = document.querySelector("#menu") as HTMLMenuElement | null;

  if (!boton) {
    console.warn(
      "El menú debe tener un botón con la clase 'icon-bars' para poder abrir y cerrar el menú.",
    );

    return;
  }

  if (!overlay) {
    console.warn(
      "El menú debe tener un elemento con el atributo 'role=menuOverlay' para poder abrir y cerrar el menú.",
    );

    return;
  }

  if (!menu) {
    console.warn(
      "El menú debe tener un elemento con el ID 'menu' para poder abrir y cerrar el menú.",
    );

    return;
  }

  boton.onclick = () => {
    // Mostramos el fondo.
    overlay.classList.remove("w3-hide");
    overlay.classList.add("w3-show");
    // Mostramos el menú y cambiamos a la animación de cierre.
    menu.classList.remove("w3-hide", "animate__animated");
    menu.classList.remove("animate__slideOutLeft", "animate__faster");
    menu.classList.add("w3-show", "w3-animate-left");
  };

  // Al cerrar el menú.
  overlay.onclick = () => {
    // Ocultar el fondo.
    overlay.classList.remove("w3-show");
    overlay.classList.add("w3-hide");
    // Cambiar a la animación de apertura.
    menu.classList.remove("w3-animate-left");
    menu.classList.add("animate__animated", "animate__slideOutLeft");
    menu.classList.add("animate__faster");

    setTimeout(() => {
      // Ocultar el menú
      menu.classList.remove("w3-show");
      menu.classList.add("w3-hide");
    }, 500);
  };

  globalThis.onresize = reajustar;
}

/**
 * @param modal Contenedor del modal.
 * @param [callback] Función adicional a ejecutar al cerrar el modal.
 */
export function mostrarModal(
  modal: HTMLElement,
  callback: () => void = () => {},
): void {
  const cerrar = modal.querySelector(".icon-close") as HTMLSpanElement | null;
  const overlay = document.querySelector(
    '[role="modalOverlay"]',
  ) as HTMLDivElement | null;

  if (!overlay) {
    console.warn(
      "El modal debe tener un elemento con el atributo 'role=modalOverlay' para poder abrir y cerrar el modal.",
    );

    return;
  }

  if (!cerrar) {
    console.warn(
      "El modal debe tener un elemento con la clase 'icon-close' para poder cerrar el modal.",
    );

    return;
  }

  // Oscurecemos el fondo
  overlay.classList.remove("w3-hide");
  overlay.classList.add("w3-show");

  // Mostramos el modal
  modal.classList.remove("w3-hide");
  modal.classList.add("w3-show");
  // Cambiamos a la animación de apertura
  modal.classList.remove("animate__fadeOutDown");
  modal.classList.add("animate__fadeInUp");

  // Al hacer click en el fondo
  overlay.onclick = () => {
    // Ocultamos el fondo
    overlay.classList.remove("w3-show");
    overlay.classList.add("w3-hide");
    // Cambiamos a la animación de cierre
    modal.classList.remove("animate__fadeInUp");
    modal.classList.add("animate__fadeOutDown");
    setTimeout(() => {
      // Ocultamos el modal
      modal.classList.remove("w3-show");
      modal.classList.add("w3-hide");
    }, 500);
    callback();
  };

  // Al hacer click en la X
  cerrar.onclick = () => {
    // Ocultamos el fondo
    overlay.classList.remove("w3-show");
    overlay.classList.add("w3-hide");
    // Cambiamos a la animación de cierre
    modal.classList.remove("animate__fadeInUp");
    modal.classList.add("animate__fadeOutDown");
    setTimeout(() => {
      // Ocultamos el modal
      modal.classList.remove("w3-show");
      modal.classList.add("w3-hide");
    }, 500);
    callback();
  };
}

/**
 * Define el comportamiento de un modal.
 * <u>Requisitos</u>
 *
 * - Para llamar a esta función a el botón o enlace debes agregarle el atributo `onclick="modal(this)"`.
 * - Define un atributo `data-target="selectorCSS"` al elemento modal, ya sea por `#id` o `.class`.
 * - Verifica que coincida el `selectorCSS` con el elemento del modal.
 * @param boton El elemento que abre el modal al hacer click o touch.
 */
export function modal(boton: HTMLElement): void {
  const selector = String(boton.getAttribute("data-target"));
  const modal = document.querySelector(selector) as HTMLElement | null;

  if (!modal) {
    console.warn(`No se encontró el modal con el selector: ${selector}`);

    return;
  }

  mostrarModal(modal);
}

/**
 * Opaca el fondo y muestra el loader.
 * @param modal Modal contenedor de algún elemento con `id='loader'`
 */
export function mostrarLoader(modal: HTMLElement): void {
  const overlay = document.querySelector('[role="modalOverlay"]');
  overlay?.classList.remove("w3-hide");
  overlay?.classList.add("w3-show");
  modal.classList.add("showLoader");
}

/**
 * Quita el fondo opaco y el loader.
 * @param modal Modal contenedor de algún elemento con `id='loader'`
 */
export function ocultarLoader(modal: HTMLElement): void {
  const overlay = document.querySelector('[role="modalOverlay"]');
  overlay?.classList.remove("w3-show");
  overlay?.classList.add("w3-hide");
  modal.classList.remove("showLoader");
}

/**
 * Realiza una petición POST
 * @param url     Ruta relativa al fichero PHP
 * @param data    Datos a enviar.
 * @param success Una función que recibe la respuesta del servidor.
 */
export function ajax(
  url: string,
  data: FormData,
  success: (res: RespuestaCruda) => void,
): void {
  $.ajax({
    url,
    type: "POST",
    data,
    contentType: false,
    processData: false,
    success,
  });
}

/**
 * Muestra u oculta la contraseña
 * @param ojo El ícono
 * @param input `<input type="password">`
 */
export function verClave(ojo: HTMLElement, input: HTMLInputElement): void {
  ojo.onclick = () => {
    if (input.type === "password") {
      input.type = "text";
      ojo.classList.remove("icon-eye");
      ojo.classList.add("icon-eye-slash");

      return;
    }

    input.type = "password";
    ojo.classList.remove("icon-eye-slash");
    ojo.classList.add("icon-eye");
  };
}

/**
 * Muestra un diálogo de confirmación.
 * @param texto Título de la ventana emergente.
 * @param [posicion] Default: 'center'
 * @param [callback] Función que se ejecuta al confirmar.
 * @return Retorna un objeto Noty activado por defecto.
 */
export function confirmar(
  texto: string,
  posicion: Noty.Layout = "center",
  callback: (e: JQuery.ClickEvent) => void = () => {},
): Noty {
  const text = `
    <div class="w3-white w3-round-xlarge w3-padding w3-center w3-border" style="z-index: 1000">
      <div class="animate__animated animate__flip animate__infinite icon-question w3-xxxlarge"></div>
      <h2 class="w3-large w3-margin-bottom">
        <strong>${texto}</strong>
      </h2>
      <div class="w3-center w3-padding w3-margin-top">
        <button id="btnConfirmar" class="w3-button w3-round-xlarge w3-blue">Sí</button>
        <button id="btnCancelar" class="w3-button w3-round-xlarge w3-red">No</button>
      </div>
    </div>
  `;

  const noty = new Noty({
    id: "confirmacion",
    theme: undefined,
    text,
    layout: posicion,
    modal: true,
    closeWith: ["button"],
    callbacks: {
      onShow: () => {
        $("#btnConfirmar").on("click", (e) => {
          $("#confirmacion .noty_close_button")[0].click();
          callback(e);
        });
        $("#btnCancelar").on("click", () => {
          $("#confirmacion .noty_close_button")[0].click();
        });
      },
    },
  });

  noty.show();

  return noty;
}

/**
 * Muestra una alerta :V
 * @param texto Texto de la alerta.
 * @param timer Milisegundos que deben pasar para ocultar la alerta.
 */
export function alerta(texto: string, timer: number = 2000): Noty {
  return new Noty({
    text: `<strong><i class="icon-close w3-margin-right"></i> ${texto}</strong>`,
    type: "error",
    timeout: timer,
  });
}

export function notificacion(texto: string): Noty {
  return new Noty({
    text: `<i class="icon-check w3-margin-right"></i> ${texto}`,
    type: "success",
    timeout: 3000,
  });
}

export function advertencia(texto: string): Noty {
  return new Noty({
    text: `<strong class="w3-text-black"><i class="icon-warning w3-margin-right"></i> ${texto}</strong>`,
    type: "warning",
    timeout: 3000,
  });
}

export function informacion(texto: string): Noty {
  return new Noty({
    text: `<i class="w3-margin-right">!</i> ${texto}`,
    type: "info",
    timeout: 3000,
  });
}

/**
 * Actualiza una ayuda que vincula cada pregunta con su respectiva respuesta
 * @param form El formulario que contiene a los inputs de preguntas y respuestas.
 */
export function labelPreguntas(form: HTMLFormElement): void {
  form.pre1.addEventListener("keyup", () => {
    const legendRespuesta = form.querySelector(
      `sup[respuesta=${form.res1.id}]`,
    ) as HTMLLegendElement | null;

    if (!legendRespuesta) {
      console.warn(
        "No se encontró el elemento sup que vincula la pregunta con la respuesta.",
      );

      return;
    }

    legendRespuesta.innerText = `(${form.pre1.value})`;
  });

  form.pre2.addEventListener("keyup", () => {
    const legendRespuesta = form.querySelector(
      `sup[respuesta=${form.res2.id}]`,
    ) as HTMLLegendElement | null;

    if (!legendRespuesta) {
      console.warn(
        "No se encontró el elemento sup que vincula la pregunta con la respuesta.",
      );

      return;
    }

    legendRespuesta.innerText = `(${form.pre2.value})`;
  });

  form.pre3.addEventListener("keyup", () => {
    const legendRespuesta = form.querySelector(
      `sup[respuesta=${form.res3.id}]`,
    ) as HTMLLegendElement | null;

    if (!legendRespuesta) {
      console.warn(
        "No se encontró el elemento sup que vincula la pregunta con la respuesta.",
      );

      return;
    }

    legendRespuesta.innerText = `(${form.pre3.value})`;
  });
}

/**
 * Envia la petición al servidor para activar o desactivar un registro.
 * @param tabla  De qué tabla es el registro.
 * @param campo  El nombre del campo para identificar el registro.
 * @param valor  Valor único de cada registro.
 * @param accion Si quieres `activar` o `desactivar`.
 * @param hrefEnlace El HREF del enlace a clickear cuando se active o se desactive un registro.
 */
export function activarDesactivar(
  tabla: string,
  campo: string,
  valor: number,
  accion: string,
  hrefEnlace: string,
): void {
  const post = {
    tabla: tabla,
    campo: campo,
    valor: valor,
    accion: accion,
  };

  $.post("backend/activarDesactivar.php", post, (res) => {
    const respuesta: Respuesta = JSON.parse(res);

    if (respuesta.error) return alerta(respuesta.error).show();

    if (accion === "activar") {
      const alertaExito = notificacion(respuesta.ok);
      alertaExito.on("beforeShow", () =>
        $(`[href="${hrefEnlace}"]`)[0].click(),
      );
      alertaExito.show();
    } else if (accion === "desactivar") {
      const alertaInfo = informacion(respuesta.ok);
      alertaInfo.on("beforeShow", () => $(`[href="${hrefEnlace}"]`)[0].click());
      alertaInfo.show();
    }
  });
}

/**
 * Funcionalidad de activar un registro.
 * @param tabla De qué tabla es el registro.
 * @param campo Nombre del campo para identificar el registro.
 * @param valor Valor único de cada registro.
 * @param hrefEnlace El HREF del enlace a clickear al activar.
 */
export function activar(
  tabla: string,
  campo: string,
  valor: number,
  hrefEnlace: string,
): void {
  activarDesactivar(tabla, campo, valor, "activar", hrefEnlace);

  return;
}

/**
 * Funcionalidad de desactivar un registro.
 * @param tabla De qué tabla es el registro.
 * @param campo Nombre del campo para identificar el registro.
 * @param valor Valor único de cada registro.
 * @param hrefEnlace El HREF del enlace a clickear al activar.
 */
export function desactivar(
  tabla: string,
  campo: string,
  valor: number,
  hrefEnlace: string,
): void {
  activarDesactivar(tabla, campo, valor, "desactivar", hrefEnlace);

  return;
}

export function vaciarLog(): void {
  confirmar("¿Seguro que desea vaciar el registro?", "center", () => {
    w3.addClass("main", "showLoader");

    return $.post("backend/vaciarLog.php", { vaciar: true }, (res) => {
      w3.removeClass("main", "showLoader");
      const respuesta: Respuesta = JSON.parse(res);

      if (respuesta.error) return alerta(respuesta.error).show();

      const alertaExito = notificacion(respuesta.ok);
      alertaExito.on("onShow", () =>
        $('nav [href="views/log.php"]')[0].click(),
      );

      alertaExito.show();
    });
  });
}

export function cerrarSesion(): void {
  confirmar("¿Seguro que desea cerrar sesión?", "center", () => {
    w3.addClass("main", "showLoader");
    const url = location.href.split("/");
    url[url.length - 1] = "salir.php";
    location.href = url.join("/");
  });
}

/**
 * Funcionalidad de editar registros.
 * @param boton  El botón del registro que quieres editar.
 * @param tabla  La tabla a la cual pertenecen los registros.
 * @param campo  El nombre del campo que identifica cada registro.
 * @param valor  Un valor único por cada registro.
 * @param [hrefEnlace] El HREF del enlace al clickear tras editar.
 */
export function editar(
  boton: HTMLElement,
  tabla: string,
  campo: string,
  valor: number,
  hrefEnlace: string = "",
): void {
  const url = "backend/editar.php";
  const datos = {
    editar: true,
    tabla: tabla,
    campo: campo,
    valor: valor,
  };
  $.post(url, datos, (res) => {
    const respuesta = JSON.parse(res);

    if (respuesta.error) return alerta(respuesta.error).show();

    const form = document.querySelector(
      String(boton.getAttribute("data-target")),
    ) as HTMLFormElement | null;

    if (!form) {
      console.warn(
        `No se encontró el formulario con el selector: ${boton.getAttribute("data-target")}`,
      );

      return;
    }

    form.innerHTML = respuesta.ok;
    modal(boton);

    if (tabla === "usuarios:preguntasRespuestas") {
      labelPreguntas(form);
      verClave(form.res1.nextElementSibling, form.res1);
      verClave(form.res2.nextElementSibling, form.res2);
      verClave(form.res3.nextElementSibling, form.res3);
    }

    if (tabla === "usuarios:clave") {
      verClave(form.clave.nextElementSibling, form.clave);
      verClave(form.confirmar.nextElementSibling, form.confirmar);
    }

    validar(form, (error, fd, e) => {
      if (error) return alerta(error).show();

      e.preventDefault();
      fd.append("tabla", tabla);
      mostrarLoader(form);
      ajax(url, fd, (res) => {
        const respuesta = JSON.parse(res);

        if (respuesta.error) {
          const alertaError = alerta(respuesta.error);
          alertaError.on("onShow", () => form.classList.remove("showLoader"));
          return alertaError.show();
        }

        const alertaExito = notificacion(respuesta.ok);
        alertaExito.on("onShow", () => {
          ocultarLoader(form);
          if (hrefEnlace) $(`a[href="${hrefEnlace}"]`)[0].click();
        });
        alertaExito.show();
      });
    });
  });
}

/**
 * Consulta la factura de una venta específica.
 * @param boton El botón de esa venta.
 * @param ventaID El ID de la venta.
 */
export function verFacturaVenta(boton: HTMLElement, ventaID: string): void {
  const modalFactura = document.querySelector("#modalFactura");
  const ventaIdFormateado = ventaID.slice(7).slice(0, -8);

  if (!modalFactura) {
    console.warn("No se encontró el modal con el ID: #modalFactura");

    return;
  }

  $.get(`views/ventas.php?ventaID=${ventaIdFormateado}`, (res) => {
    const respuesta: Respuesta = JSON.parse(res);

    if (respuesta.error) return alerta(respuesta.error).show();

    const textoTelefono = respuesta.datos.telefonoNegocio
      ? `
        <tr>
          <th>Teléfono:</th>
          <td>
            &nbsp;<span class="icon-whatsapp w3-text-green"></span>
            &nbsp;${respuesta.datos.telefonoNegocio}
          </td>
        </tr>
      `
      : "";

    const textoDireccion = respuesta.datos.direccionNegocio
      ? `
        <tr>
          <th>Dirección:</th>
          <td>&nbsp;${respuesta.datos.direccionNegocio}</td>
        </tr>
      `
      : "";

    const textoCliente =
      respuesta.datos.cedulaCliente !== 40000000
        ? `
        <div class="w3-margin">
          <h5 class="w3-container w3-xlarge">Datos del cliente:</h5>
          <table class="w3-table-all">
            <tr></tr>
            <tr>
              <th class="w3-tag w3-blue">Nombre:</th>
              <td>${respuesta.datos.nombreCliente}</td>
            </tr>
            <tr>
              <th class="w3-tag w3-blue">Cédula:</th>
              <td>${respuesta.datos.cedulaCliente}</td>
            </tr>
          </table>
        </div>
      `
        : "";

    modalFactura.innerHTML = `
      <div class="w3-right-align">
        <span class="icon-close w3-button w3-transparent w3-hover-red"></span>
      </div>
      <h2 class="w3-center w3-xxlarge oswald w3-margin-bottom">
        <div class="w3-container">
          <img src="assets/images/logo.png" class="w3-margin-right w3-responsive" width="100px">
          ${respuesta.datos.nombreNegocio}
        </div>
      </h2>
      <h3 class="w3-container w3-xlarge w3-right-align w3-blue">Comprobante</h3>
      ${textoCliente}
      <div class="w3-responsive w3-margin">
        <h5 class="w3-container w3-xlarge">Datos de la venta</h5>
        <table class="w3-table-all w3-centered">
          <tr class="w3-bottombar">
            <th>Cantidad</th>
            <th>Producto</th>
            <th>Precio unitario</th>
            <th>Monto total</th>
          </tr>
          <tr>
            <td>${respuesta.datos.cantidad}</td>
            <td>${respuesta.datos.producto}</td>
            <td>$ ${respuesta.datos.precio}</td>
            <td>$ ${respuesta.datos.total}</td>
          </tr>
        </table>
        <div class="w3-container w3-center w3-padding-top-24 w3-large">
          <div class="w3-left">
            Total IVA
            <span class="w3-xlarge">(${respuesta.datos.iva * 100}%)</span>
          </div>
          <div class="w3-right">
            Monto total:
            &nbsp;<span class="icon-dollar w3-text-green w3-xlarge"></span>
            <b class="w3-xlarge">${respuesta.datos.total}</b></div>
        </div>
        <div class="w3-row w3-padding-top-48">
          <table class="w3-col s8 w3-container w3-left-align">
            ${textoDireccion}
            ${textoTelefono}
          </table>
          <button onclick="generarPDF()" class="w3-rest w3-auto w3-button w3-blue w3-round-xlarge">
            <i class="icon-save"></i>
            Guardar
          </button>
        </div>
      </div>
    `;
    modal(boton);
  });
}

export function generarPDF(): void {
  const modalFactura = document.querySelector("#modalFactura");
  html2pdf(String(modalFactura?.innerHTML));
}

/**
 * Comportamiento de cambiar los páneles.
 * @param boton El botón clickeado.
 * @param id    El ID del panel a mostrar (incluido el #).
 */
export function mostrarPanel(boton: HTMLElement, id: string): void {
  const panel = $(id)[0];

  $('[role="botonPanel"]').each((_i, boton) =>
    boton.classList.remove("w3-blue"),
  );
  boton.classList.add("w3-blue");
  $('[role="panel"]').each((_i, panel) => {
    panel.classList.remove("w3-show");
    panel.classList.add("w3-hide");
  });

  panel.classList.remove("w3-hide");
  panel.classList.add("w3-show");
}

export function respaldarBD(): void {
  confirmar(
    "¿Desea crear una copia de seguridad de todos los datos?",
    "center",
    () => {
      w3.addClass("main", "showLoader");
      $.post("backend/backupBD.php", { respaldar: true }, (res) => {
        w3.removeClass("main", "showLoader");
        const respuesta: Respuesta = JSON.parse(res);
        if (respuesta.error) return alerta(respuesta.error).show();

        return notificacion(respuesta.ok).show();
      });
    },
  );
}

export function restaurarBD(): void {
  const texto = `
    Tener en cuenta que al restaurar se perderán cambios
    que no hayan sido respaldados<br>
    <strong class="w3-text-red">¿Desea continuar?</strong>
  `;

  confirmar(texto, "center", () => {
    w3.addClass("main", "showLoader");
    $.post("backend/backupBD.php", { restaurar: true }, (res) => {
      const respuesta: Respuesta = JSON.parse(res);

      if (respuesta.error) {
        const alertaError = alerta(respuesta.error);
        alertaError.on("onShow", () => w3.removeClass("main", "showLoader"));
        return alertaError.show();
      }

      const html = `
        <div class="w3-card w3-round-xlarge w3-white w3-padding-large w3-center">
          <h1 class="w3-xlarge oswald">${respuesta.ok}</h1>
          <h2 class="w3-large w3-padding-top-24 w3-topbar">
            Reiniciando el Sistema...
          </h2>
        </div>
      `;

      new Noty({
        id: "intro",
        type: "info",
        text: html,
        layout: "center",
        modal: true,
        animation: { open: "w3-animate-zoom" },
        timeout: 5000,
        callbacks: { afterClose: () => location.reload() },
      }).show();
    });
  });
}

/**
 * Filtra elementos en una lista.
 * @param input Entrada de texto.
 * @param contenedorID   ID del contenedor de la lista
 */
export function filter(input: HTMLInputElement, contenedorID: string): void {
  const contenedor = document.querySelector(`#${contenedorID}`);

  if (!contenedor) {
    console.warn(`No se encontró el contenedor con el ID: ${contenedorID}`);

    return;
  }

  /** Texto a buscar en mayúsculas */
  const texto = input.value.toUpperCase();
  const elementos = contenedor.querySelectorAll("button");
  for (let i = 0; i < elementos.length; ++i) {
    /** Texto del elemento */
    const txtValue = elementos[i].textContent || elementos[i].innerText;
    if (txtValue.toUpperCase().indexOf(texto) > -1)
      elementos[i].style.display = "";
    else elementos[i].style.display = "none";
  }
}

/**
 * Funcionalidad del formulario para registrar productos.
 * @param formulario El formulario de registro.
 * @param enlace     El HREF del enlace a clickear terminado el registro.
 */
export function registrarProducto(
  formulario: HTMLFormElement,
  enlace: string,
): void {
  validar(formulario, (error, fd, e) => {
    if (error) return alerta(error).show();

    e.preventDefault();
    mostrarLoader(formulario);
    ajax("backend/registrarProducto.php", fd, (res) => {
      /** @type {Respuesta} */
      const datos: Respuesta = JSON.parse(res);

      if (datos.error) {
        const alertaError = alerta(datos.error);
        alertaError.on("onShow", () => ocultarLoader(formulario));
        return alertaError.show();
      }

      ocultarLoader(formulario);
      const alertaExito = notificacion(datos.ok);
      alertaExito.on("onShow", () => $(`[href="${enlace}"]`)[0].click());
      alertaExito.show();
    });
  });
}

/**
 * Funcionalidad del formulario para registrar clientes.
 * @param formulario El formulario de registro.
 * @param enlace     El HREF del enlace a clickear terminado el registro.
 */
export function registrarCliente(
  formulario: HTMLFormElement,
  enlace: string,
): void {
  validar(formulario, (error, fd, e) => {
    if (error) return alerta(error).show();

    e.preventDefault();
    mostrarLoader(formulario);
    ajax("backend/registrarCliente.php", fd, (res) => {
      const datos: Respuesta = JSON.parse(res);

      if (datos.error) {
        const alertaError = alerta(datos.error);
        alertaError.on("onShow", () => ocultarLoader(formulario));
        alertaError.show();
      }

      ocultarLoader(formulario);
      const alertaExito = notificacion(datos.ok);
      alertaExito.on("onShow", () => $(`[href="${enlace}"]`)[0].click());
      alertaExito.show();
    });
  });
}

/**
 * Funcionalidad del formulario para registrar proveedores.
 * @param  {HTMLFormElement} formulario El formulario de registro.
 * @param  {string} enlace     El HREF del enlace a clickear terminado el registro.
 */
export function registrarProveedor(
  formulario: HTMLFormElement,
  enlace: string,
): void {
  validar(formulario, (error, fd, e) => {
    if (error) return alerta(error).show();

    e.preventDefault();
    mostrarLoader(formulario);
    ajax("backend/registrarProveedor.php", fd, (res) => {
      const datos: Respuesta = JSON.parse(res);

      if (datos.error) {
        const alertaError = alerta(datos.error);
        alertaError.on("onShow", () =>
          formulario.classList.remove("showLoader"),
        );
        return alertaError.show();
      }

      ocultarLoader(formulario);
      const alertaExito = notificacion(datos.ok);
      alertaExito.on("onShow", () => $(`[href="${enlace}"]`)[0].click());
      alertaExito.show();
    });
  });
}

/**
 * Funcionalidad de actualizar el valor de las monedas.
 * @param formulario El formulario de actualización.
 */
export function actualizarMonedas(formulario: HTMLFormElement): void {
  validar(formulario, (error, fd, e) => {
    if (error) return alerta(error).show();

    e.preventDefault();
    formulario.classList.add("showLoader");
    ajax("backend/actualizarMonedas.php", fd, (res) => {
      const datos: Respuesta = JSON.parse(res);
      if (datos.error) {
        const alertaError = alerta(datos.error);
        alertaError.on("onClose", () =>
          formulario.classList.remove("showLoader"),
        );
        alertaError.show();
      }

      $("#tablaMonedas").html(`
        <tr>
          <td>IVA</td>
          <td colspan="2"><b>${formulario.iva.value}%</b></td>
        </tr>
        <tr>
          <td>DÓLAR</td>
          <td>
            <b><i>Bs. </i>${formulario.dolar.value}</b>
          </td>
          <td><b>${formulario.pesos.value}<i> Pesos</i></b></td>
        </tr>
      `);

      formulario.classList.remove("showLoader");

      const alertaNotificacion = notificacion(datos.ok);
      alertaNotificacion.on("onShow", () => {
        const iconClose = formulario.querySelector(".icon-close");

        if (iconClose instanceof HTMLElement) {
          iconClose.click();
        } else {
          console.warn(
            "No se encontró el elemento con la clase 'icon-close' en el formulario.",
          );
        }
      });

      alertaNotificacion.on("afterClose", () => location.reload());
      alertaNotificacion.show();
    });
  });
}

/**
 * Actualiza dinámicamente el total de un producto.
 * @param cantidad   Un elemento `<input>` con `name="cantidad`
 * @param excento Representa si el producto es o no es excento de IVA.
 * @param inputTotalID ID del `<input>` en dónde mostrar el total.
 */
export function actualizarTotal(
  cantidad: HTMLInputElement,
  excento: number,
  inputTotalID: string,
): void {
  const precio = Number(cantidad.form?.querySelector('[name="precio"]')?.value);
  const iva = Number(cantidad.form?.querySelector('[name="iva"]')?.value);
  const dolar = Number(cantidad.form?.querySelector('[name="dolar"]')?.value);
  const peso = Number(cantidad.form?.querySelector('[name="peso"]')?.value);
  const total = cantidad.form?.querySelector(
    inputTotalID,
  ) as HTMLInputElement | null;

  total.value = (precio * cantidad.value).toFixed(2);
  total?.setAttribute("total", total.value);

  if (excento) {
    const totalIVA = Number(total?.getAttribute("total")) * iva;
    const precioBS = (
      (Number(total?.getAttribute("total")) + totalIVA) *
      dolar
    ).toFixed(2);
    const precioPesos = (
      (Number(total?.getAttribute("total")) + totalIVA) *
      peso
    ).toFixed(0);
    total.parentElement.innerHTML = `
      <span id="total" class="w3-left-align w3-input w3-padding w3-light-grey w3-text-black" disabled>
        ${Number(total.value) + totalIVA} <span class="w3-text-green">+${totalIVA} IVA</span>
      </span>
      <div class="w3-dropdown-content w3-padding-small w3-card-4 w3-white">
        <b>Bs. ${precioBS}<br>
        ${precioPesos} pesos</b>
      </div>
    `;
  } else {
    const precioBS = (Number(total?.getAttribute("total")) * dolar).toFixed(2);
    const precioPesos = (Number(total?.getAttribute("total")) * peso).toFixed(
      0,
    );
    total.parentElement.innerHTML = `
      <span id="total" class="w3-left-align w3-input w3-padding w3-light-grey w3-text-black" disabled>
        ${total.value}
      </span>
      <div class="w3-dropdown-content w3-padding-small w3-card-4 w3-white">
        <b>Bs. ${precioBS}<br>
        ${precioPesos} pesos</b>
      </div>
    `;
  }

  if (Number.parseInt(cantidad.value) !== 0) {
    cantidad.form?.querySelector("button")?.classList.remove("w3-hide");
  }
}

/**
 * Actualiza dinámicamente el tooltip del precio.
 * @param inputPrecio El `<input>` con el precio.
 */
export function actualizarPrecio(inputPrecio: HTMLInputElement) {
  const precio = Number(inputPrecio.value);
  const dolar = Number(
    inputPrecio.form?.querySelector('[name="dolar"]')?.value,
  );
  const peso = Number(inputPrecio.form?.querySelector('[name="peso"]')?.value);

  const precioBS = (precio * dolar).toFixed(2);
  const precioPesos = (precio * peso).toFixed(0);
  inputPrecio.parentElement.querySelector(".w3-dropdown-content").innerHTML = `
    <b>
      Bs. ${precioBS}<br>
      ${precioPesos} pesos
    </b>
  `;
}

globalThis.onoffline = () => advertencia("Se ha perdido la conexión").show();

globalThis.ononline = () =>
  notificacion("Se ha restablecido la conexión").show();
