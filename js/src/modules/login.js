const overlay       = w3.getElement(".w3-overlay");
const formAdmin     = w3.getElement("#formAdmin");
const formLogin     = w3.getElement("#formLogin");
const formRecuperar = w3.getElement("#formConsulta");
const formPreguntas = w3.getElement("#formPreguntas");
const formClave     = w3.getElement("#formClave");
const enlace        = w3.getElement("a.recuperarClave");

if(formAdmin){
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

	if(formPreguntas){
		validar(formPreguntas);
		ventanaEmergente(formPreguntas, overlay);
	}

	if(formClave){
		validar(formClave);
		ventanaEmergente(formClave, overlay);
	}
}