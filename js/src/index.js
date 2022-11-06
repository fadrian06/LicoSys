import comprobarBD from './modules/comprobarBD';

comprobarBD().then(() => {
	document.body.setAttribute('w3-include-HTML', 'vistas/registrarNegocio.html')
	w3.includeHTML(() => w3.addClass('div.w3-modal-content', 'w3-animate-zoom'))
})