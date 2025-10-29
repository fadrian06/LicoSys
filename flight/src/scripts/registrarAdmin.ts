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
const form = document.querySelector("#registrarAdmin");
const inputFile = form?.foto;
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
validar(form, (error, fd, e) => {
  if (error) {
    return alerta(error).show();
  }

  e.preventDefault();
  mostrarLoader(form);

  fd?.append(inputFile.id, inputFile.files[0]);
  fd?.append("cargo", "a");

  ajax("backend/registrarUsuario.php", fd, (res) => {
    const respuesta: Respuesta = JSON.parse(res);

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
