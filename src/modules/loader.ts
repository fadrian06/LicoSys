import Noty from "noty";

new Noty({
  id: "loader",
  type: "info",
  layout: "center",
  text: `
    <h1 class="w3-text-white w3-center w3-xlarge oswald">
      Bienvenido a Licosys
    </h1>
    <div class="newtons-cradle">
      <div class="newtons-cradle__dot"></div>
      <div class="newtons-cradle__dot"></div>
      <div class="newtons-cradle__dot"></div>
      <div class="newtons-cradle__dot"></div>
    </div>
    <p class="w3-text-white w3-center">
      Estamos configurando algunas cosas, por favor espere...
    </p>
  `,
  animation: { open: "w3-animate-opacity" },
  callbacks: {
    onShow() {
      $.post("./api/instalar-bd", (data) => {
        if (data !== "true") return console.error(data);

        return setTimeout(() => {
          $("#loader").remove();

          new Noty({
            id: "intro",
            type: "info",
            text: `
              <div class="w3-card w3-round-xlarge w3-white w3-padding-large w3-center">
                <h1 class="w3-xlarge oswald">Licosys instalado correctamente</h1>
                <h2 class="w3-large w3-padding-top-24 w3-topbar">
                  Sólo faltan unos pocos pasos...
                </h2>
              </div>
            `,
            layout: "center",
            animation: { open: "w3-animate-zoom" },
            timeout: 3000,
            callbacks: {
              afterClose() {
                location.reload();
              },
            },
          }).show();
        }, 3000);
      });
    },
  },
}).show();
