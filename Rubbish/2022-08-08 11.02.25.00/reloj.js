(function () {
  if (document.querySelector(".widget")) {
    var actualizarHora = function () {
      var fecha = new Date(),
          horas = fecha.getHours(),
          ampm,
          minutos = fecha.getMinutes(),
          diaSemana = fecha.getDay(),
          dia = fecha.getDate(),
          mes = fecha.getMonth(),
          year = fecha.getFullYear();
      var pHoras = document.getElementById("horas"),
          pAMPM = document.getElementById("ampm"),
          pMinutos = document.getElementById("minutos"),
          pDiaSemana = document.getElementById("diaSemana"),
          pDia = document.getElementById("dia"),
          pMes = document.getElementById("mes"),
          pYear = document.getElementById("year");
      var semana = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"];
      pDiaSemana.textContent = semana[diaSemana];
      pDia.textContent = dia;
      var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
      pMes.textContent = meses[mes];
      pYear.textContent = year;

      if (horas >= 12) {
        horas = horas - 12;
        ampm = "PM";
      } else {
        ampm = "AM";
      }

      if (horas == 0) {
        horas = 12;
      }

      if (minutos < 10) {
        minutos = "0" + minutos;
      }

      pHoras.textContent = horas;
      pAMPM.textContent = ampm;
      pMinutos.textContent = minutos;
    };

    actualizarHora();
    var intervalo = setInterval(actualizarHora, 1000 * 60);
  }
})();