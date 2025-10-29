import $ from "jquery";
import Noty from "noty";
import {
  ajax,
  alerta,
  confirmar,
  labelPreguntas,
  mostrarLoader,
  notificacion,
  ocultarLoader,
  type Respuesta,
  type RespuestaCruda,
} from "./funciones";
import validar from "./validar";

/*=====================================
=            DECLARACIONES            =
=====================================*/
const form = document.querySelector("#registrarPreguntasRespuestas");

function recibirRespuesta(res: RespuestaCruda) {
  const respuesta: Respuesta = JSON.parse(res);

  if (respuesta.error) {
    const alertaError = alerta(respuesta.error);
    alertaError.on("afterClose", () => ocultarLoader(form));

    return alertaError.show();
  }

  ocultarLoader(form);
  Noty.closeAll();

  const alertaExito = notificacion("Registro exitoso.");
  alertaExito.on("onClose", () => location.reload());
  alertaExito.show();
}
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
labelPreguntas(form);

$("#masTarde").on("click", (e) => {
  e.preventDefault();

  const textoConfirmacion = `
    <h2 class="w3-large w3-margin-bottom">
      <strong>¿Estás seguro que desea realizar este proceso más tarde?</strong>
    </h2>
    <p class="w3-padding-top-16 w3-justify w3-medium w3-text-red">
      &nbsp;&nbsp;Es recomendable que cree sus preguntas y respuestas secretas, pues
      le permitirán recuperar su contraseña en caso de extraviarla.
    </p>
    <p class="w3-padding-top-16">
      ¿Registrar preguntas y respuestas más tarde?
    </p>
  `;

  return confirmar(textoConfirmacion, "center", () => {
    form.pre1.value = "No especificada";
    form.pre2.value = "No especificada";
    form.pre3.value = "No especificada";
    const fd = new FormData(form);
    ajax("backend/registrarPreguntasRespuestas.php", fd, recibirRespuesta);
  });
});

validar(form, (error, fd, e) => {
  if (error) return alerta(error).show();

  e.preventDefault();
  mostrarLoader(form);

  ajax("backend/registrarPreguntasRespuestas.php", fd, recibirRespuesta);
});
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/
