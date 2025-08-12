/** @typedef {import('./funciones')} */

import actualizarImagen from "./actualizarImagen";
import {
  ajax,
  alerta,
  mostrarLoader,
  notificacion,
  ocultarLoader,
  verClave,
} from "./funciones";
import validar from "./validar";

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
const form = document.querySelector("#registrarAdmin");
/** @type {HTMLInputElement} */
const inputFile = form.foto;
/** @type {HTMLImageElement} */
const image = form.querySelector(".image-result");
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, (error) => alerta(error).show());

verClave(form.clave.nextElementSibling, form.clave);
verClave(form.confirmar.nextElementSibling, form.confirmar);

validar(form, (error, fd, e) => {
  if (error) return alerta(error).show();

  e.preventDefault();
  mostrarLoader(form);

  fd.append(inputFile.id, inputFile.files[0]);
  fd.append("cargo", "a");
  ajax("backend/registrarUsuario.php", fd, (res) => {
    /** @type {import("./funciones").Respuesta} */
    const respuesta = JSON.parse(res);

    if (respuesta.error) {
      const alertaError = alerta(respuesta.error);
      alertaError.on("afterClose", () => ocultarLoader(form));

      return alertaError.show();
    }

    ocultarLoader(form);

    const alertaExito = notificacion(respuesta.ok);
    alertaExito.on("afterClose", () => location.reload());
    alertaExito.show();
  });
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/
