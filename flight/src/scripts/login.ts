import $ from "jquery";
import Typed from "typed.js";
import { ajax, alerta, type Respuesta } from "./funciones";
import { reloj } from "./reloj";
import validar from "./validar";

/*=====================================
=            DECLARACIONES            =
=====================================*/
const contenedorReloj = document.querySelector(".reloj");
const form = document.querySelector("#login");
const usuarioLoader = form?.querySelector("#usuarioLoader");
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reloj(contenedorReloj);
setInterval(() => reloj(contenedorReloj), 1 * 1000 * 60 /*1 minuto*/);

new Typed("#typed", {
  strings: [
    "<i>Sencillo.</i>",
    "<i>Rápido.</i>",
    "<i>Moderno.</i>",
    "<i>Seguro.</i>",
    "<i>Completo.</i>",
  ],
  typeSpeed: 100,
  startDelay: 1000,
  backSpeed: 50,
  loop: true,
  cursorChar: '<i class="w3-medium icon-chevron-left"></i>',
});

form?.usuario.addEventListener("blur", () => {
  if (!form?.usuario.value) {
    return;
  }

  usuarioLoader?.classList.remove("w3-hide");
  usuarioLoader?.classList.add("w3-show");

  $.post(
    "backend/login.php",
    { verificarUsuario: true, usuario: form?.usuario.value },
    (res) => {
      const datos: Respuesta = JSON.parse(res);

      if (datos.error) {
        const alertaError = alerta(datos.error);

        alertaError.on("onShow", () => {
          usuarioLoader?.classList.remove("w3-show");
          usuarioLoader?.classList.add("w3-hide");
          form?.usuario.parentElement.parentElement.classList.remove("valido");
          form?.usuario.parentElement.parentElement.classList.add("invalido");
        });

        return alertaError.show();
      }

      const spinner = usuarioLoader?.querySelector("i");

      spinner?.classList.remove("icon-spinner", "w3-spin");
      spinner?.classList.add("icon-check", "w3-text-green");
      form?.usuario.parentElement.parentElement.classList.add("valido");
    },
  );
});

let intentos = 0;

validar(form, (error, fd, e) => {
  if (error) {
    return alerta(error).show();
  }

  e.preventDefault();
  form?.classList.add("showLoader");
  fd?.append("login", true);

  ajax("backend/login.php", fd, (res) => {
    const datos: Respuesta = JSON.parse(res);

    if (datos.error) {
      let text = datos.error;

      if (datos.error === "Contraseña incorrecta") {
        ++intentos;
      }

      if (intentos <= 3 && intentos > 0) {
        text += ` <strong>(intento: ${intentos} / 3)</strong>`;
      } else {
        /**

          TODO:
          - Bloquear a los 3 intentos

         */
        intentos = 0;
      }

      const alertaError = alerta(text);

      alertaError.on("onShow", () => form.classList.remove("showLoader"));
      return alertaError.show();
    }

    form?.classList.remove("showLoader");
    form?.parentElement?.classList.add("showLoader");

    let href = location.href;

    if (!href.indexOf("index.php")) {
      location.href += "dashboard.php";

      return;
    }

    href = href.replace(/index\.php/g, "dashboard.php");
    location.href = href;
  });
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/
