// const BASE_URI = '/licoreria'
const BASE_URI = 'http://192.168.1.199/licoreria'

const expresiones = {
	nombreNegocio: /^[\wáÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
	nombreProducto: /^[\w-áÁéÉíÍóÓúÚñÑ\s]{4,50}$/i,
	rif: /^(v|e){1}\d{9,15}$/i,
	telefono: /^(0|\+57|\+58)\s?-?(412|414|424|416|426)-?[0-9]{3}-?[0-9]{4}$/,
	direccion: /^([a-záÁéÉíÍóÓúÚñÑ\d\,\.\-\#\/]\s?){4,50}$/i,
	cedula: /^[^e]?[\d]{7,8}$/,
	nombre: /^[a-záÁéÉíÍóÓúÚñÑ]{4,20}$/i,
	usuario: /^[\w-]{4,20}$/i,
	clave: /^[\w.-@#/*]{4,20}$/i,
	pregunta: /^[\?a-záÁéÉíÍóÓúÚñÑ¿\s]+$/i,
	respuesta: /^[a-záÁéÉíÍóÓúÚñÑ\d]{4,20}$/i,
	codigo: /^[a-z\d-.#]{3,10}$/i,
	stock: /^[^e]?[\d]+$/,
	precio: /^[\d.]+$/,
	iva: /^0\.\d{2,3}$/,
	dolar: /^\d+(\.\d{1,2})?$/,
	peso: /^[^e]?\d{1,4}$/,
}

export { BASE_URI, expresiones }