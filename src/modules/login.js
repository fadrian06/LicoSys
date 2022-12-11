const overlay       = document.querySelector(".w3-overlay");
const formNegocio   = document.querySelector("#formNegocio");
const formAdmin     = document.querySelector("#formAdmin");
const formLogin     = document.querySelector("#formLogin");
const formRecuperar = document.querySelector("#formConsulta");
const formPreguntas = document.querySelector("#formPreguntas");
const formClave     = document.querySelector("#formClave");
const enlace        = document.querySelector("a.recuperarClave");

if (formNegocio) {
	validar(formNegocio);
	ventanaEmergente(formNegocio, overlay);
	actualizarFoto();
}

if (formAdmin) {
	validar(formAdmin);
	ventanaEmergente(formAdmin, overlay);
}

if (formLogin) {
	validar(formLogin);
	validar(formRecuperar);
	modal(enlace, formRecuperar, overlay);

	const contenedorReloj = w3.getElement(".widget");
	reloj(contenedorReloj);
	setInterval(() => reloj(contenedorReloj), 1000 * 60);

	if (formPreguntas) {
		validar(formPreguntas);
		ventanaEmergente(formPreguntas, overlay);
	}

	if (formClave) {
		validar(formClave);
		ventanaEmergente(formClave, overlay);
	}
}