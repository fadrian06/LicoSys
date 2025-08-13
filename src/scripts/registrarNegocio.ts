import actualizarImagen from "./actualizarImagen";
import {
  ajax,
  alerta,
  mostrarLoader,
  notificacion,
  ocultarLoader,
} from "./funciones";
import validar from "./validar";

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLFormElement} */
const form = document.querySelector("#registrarNegocio");
/** @type {HTMLInputElement} */
const inputFile = form.logo;
/** @type {HTMLImageElement} */
const image = form.querySelector(".image-result");
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
actualizarImagen(inputFile, image, (error) => {
  if (error) return alerta(error).show();
});

validar(form, (error, fd, e) => {
  if (error) return alerta(error).show();

  e.preventDefault();
  mostrarLoader(form);

  fd.append(inputFile.id, inputFile.files[0]);

  ajax("backend/registrarNegocio.php", fd, (res) => {
    /** @type {import("./funciones").Respuesta} */
    const respuesta = JSON.parse(res);

    if (respuesta.error) {
      const alertaError = alerta(respuesta.error);
      alertaError.on("afterClose", () => ocultarLoader(form));

      return alertaError.show();
    }

    ocultarLoader(form);

    const alertaExito = notificacion(respuesta.ok);
    alertaExito.on("onClose", () => location.reload());
    alertaExito.show();
  });
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/
