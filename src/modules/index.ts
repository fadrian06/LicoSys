import "@fontsource/roboto";
import "@fontsource/oswald";
import {
  advertencia,
  alerta,
  confirmar,
  modal,
  respaldarBD,
  restaurarBD,
  vaciarLog,
} from "./funciones";

globalThis.modal = modal;
globalThis.vaciarLog = vaciarLog;
globalThis.respaldarBD = respaldarBD;
globalThis.restaurarBD = restaurarBD;
globalThis.confirmar = confirmar;
globalThis.alerta = alerta;
globalThis.advertencia = advertencia;
