/** @typedef {import('./funciones')} */
/** @typedef {import('./login')} */

import {
  ajax,
  alerta,
  modal,
  mostrarModal,
  notificacion,
  verClave,
} from "./funciones";
import validar from "./validar";

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLButtonElement} */
const botonRecuperar = document.querySelector("#recuperar");
/** @type {HTMLFormElement} */
const formConsulta = document.querySelector("#consultar");
/** @type {HTMLFormElement} */
const formPreguntasRespuestas = document.querySelector("#preguntasRespuestas");
/** @type {HTMLFormElement} */
const formClave = document.querySelector("#cambiarClave");
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
botonRecuperar.onclick = (e) => {
  e.preventDefault();
  modal(botonRecuperar);
};

validar(formConsulta, (error, fd, e) => {
  if (error) return alerta(error).show();

  e.preventDefault();
  formConsulta.classList.add("showLoader");
  fd.append("consultar", true);
  ajax("backend/recuperarClave.php", fd, (res) => {
    /** @type {import("./funciones").Respuesta} */
    const datos = JSON.parse(res);
    if (datos.error) {
      const alertaError = alerta(datos.error);
      alertaError.on("onShow", () =>
        formConsulta.classList.remove("showLoader"),
      );
      return alertaError.show();
    }

    formConsulta.classList.remove("showLoader");
    location.reload();
  });
});

if (formPreguntasRespuestas) {
  mostrarModal(formPreguntasRespuestas, () => {
    return $.post("backend/recuperarClave.php", { cerrar: true }, (res) => {
      console.log(res);
    });
  });
  verClave(
    formPreguntasRespuestas.res1.nextElementSibling,
    formPreguntasRespuestas.res1,
  );
  verClave(
    formPreguntasRespuestas.res2.nextElementSibling,
    formPreguntasRespuestas.res2,
  );
  verClave(
    formPreguntasRespuestas.res3.nextElementSibling,
    formPreguntasRespuestas.res3,
  );
  validar(formPreguntasRespuestas, (error, fd, e) => {
    if (error) return alerta(error).show();

    e.preventDefault();
    formPreguntasRespuestas.classList.add("showLoader");
    fd.append("verificarRespuestas", true);
    return ajax("backend/recuperarClave.php", fd, (res) => {
      /** @type {import("./funciones").Respuesta} */
      const datos = JSON.parse(res);
      if (datos.error) {
        const alertaError = alerta(datos.error);
        alertaError.on("onShow", () => {
          formPreguntasRespuestas.classList.remove("showLoader");
        });

        return alertaError.show();
      }

      formPreguntasRespuestas.classList.remove("showLoader");
      location.reload();
    });
  });
}

if (formClave) {
  mostrarModal(formClave, () => {
    return $.post("backend/recuperarClave.php", { cerrar: true }, (res) => {
      console.log(res);
    });
  });
  verClave(formClave.clave.nextElementSibling, formClave.clave);
  verClave(formClave.confirmar.nextElementSibling, formClave.confirmar);

  validar(formClave, (error, fd, e) => {
    if (error) return alerta(error).show();

    e.preventDefault();
    formClave.classList.add("showLoader");
    fd.append("cambiarClave", true);
    return ajax("backend/recuperarClave.php", fd, (res) => {
      /** @type {import("./funciones").Respuesta} */
      const datos = JSON.parse(res);

      if (datos.error) {
        const alertaError = alerta(datos.error);
        alertaError.on("onShow", () =>
          formClave.classList.remove("showLoader"),
        );

        return alertaError.show();
      }

      formClave.classList.remove("showLoader");
      notificacion("Contraseña actualizada exitósamente.").show();

      return formClave.querySelector(".icon-close")?.click();
    });
  });
}
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/
