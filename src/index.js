import './index.styl'
// import './modules/funciones.js'

// import './modules/login.js'
// import './modules/sistema.js'

import instalarBD from './modules/instalarBD'
import registrarNegocio from './modules/registrarNegocio'

(async () => {
	await instalarBD()
	await registrarNegocio()
})()