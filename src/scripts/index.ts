import "@fontsource/roboto";
import "@fontsource/oswald";
import "@icomoon/fontawesome/style.css";
import "noty/lib/noty.css";
import "w3s/w3.min.css";
import "animate.css/animate.min.css";
import "../styles/index.css";
import "alpinejs/dist/cdn.min";

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
