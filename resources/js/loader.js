/** @typedef {import('./funciones')} */

const APP_NAME = document.documentElement.dataset.appName

function getLoaderHtml(titulo = '', parrafo = '') {
  return `
    <h1 class="w3-text-white w3-center w3-xlarge oswald">${titulo}</h1>
    <div class="newtons-cradle">
      <div class="newtons-cradle__dot"></div>
      <div class="newtons-cradle__dot"></div>
      <div class="newtons-cradle__dot"></div>
      <div class="newtons-cradle__dot"></div>
    </div>
    <p class="w3-text-white w3-center">${parrafo}</p>
  `
}

const alertaBienvenido = new Noty({
  layout: 'center',
  text: getLoaderHtml(
    `${APP_NAME} instalado correctamente`,
    'Sólo faltan unos pocos pasos...',
  ),
  closeWith: [null],
  callbacks: {
    onShow() {
      setTimeout(() => location.reload(), 2500)
    },
  }
})

const alertaCargando = new Noty({
  layout: 'center',
  text: getLoaderHtml(
    `Bienvenido a ${APP_NAME}`,
    'Estamos configurando algunas cosas, por favor espere...',
  ),
  closeWith: [null],
  callbacks: {
    onShow() {
      $.post('./', { instalarBD: true }, data => {
        if (data !== 'true') return console.error(data)

        return setTimeout(() => {
          alertaCargando.close()
        }, 2500)
      })
    },
    afterClose() {
      alertaBienvenido.show()
    },
  }
})

alertaCargando.show()
