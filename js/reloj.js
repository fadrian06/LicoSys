"use strict";

/**
 * Crea un reloj
 * @param  {HTMLDivElement} contenedor Contenedor para el reloj
 */
var reloj = function reloj(contenedor) {
  var fecha = new Date();
  var horas = fecha.getHours(),
    ampm,
    minutos = fecha.getMinutes(),
    diaSemana = fecha.getDay(),
    dia = fecha.getDate(),
    mes = fecha.getMonth(),
    year = fecha.getFullYear();
  var semana = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'];
  var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  if (horas >= 12) {
    horas -= 12;
    ampm = 'PM';
  } else ampm = 'AM';
  if (horas === 0) horas = 12;
  if (minutos < 10) minutos = "0".concat(minutos);
  contenedor.innerHTML = "\n\t\t\t<div class=\"fecha\">\n\t\t\t\t<b>".concat(semana[diaSemana], "</b>\n\t\t\t\t<b>").concat(dia, "</b>\n\t\t\t\t<b>de </b>\n\t\t\t\t<b>").concat(meses[mes], "</b>\n\t\t\t\t<b>del </b>\n\t\t\t\t<b>").concat(year, "</b>\n\t\t\t</div>\n\t\t\t<div class=\"hora\">\n\t\t\t\t<b>").concat(horas, "</b>\n\t\t\t\t<b>:</b>\n\t\t\t\t<b>").concat(minutos, "</b>\n\t\t\t\t<b>").concat(ampm, "</b>\n\t\t\t</div>\n\t\t");
};