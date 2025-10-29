import {
  ajax,
  alerta,
  mostrarLoader,
  notificacion,
  ocultarLoader,
  type Respuesta,
} from "./funciones";
import validar from "./validar";

/*=====================================
=            DECLARACIONES            =
=====================================*/
const form = document.querySelector("#registrarNegocio");
const inputFile = form?.logo;
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
validar(form, (error, fd, e) => {
  if (error) return alerta(error).show();

  e.preventDefault();
  mostrarLoader(form);

  fd.append(inputFile.name, inputFile.files[0]);

  ajax("backend/registrarNegocio.php", fd, (res) => {
    const respuesta: Respuesta = JSON.parse(res);

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
