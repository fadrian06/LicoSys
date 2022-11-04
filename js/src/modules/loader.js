const promesa = Swal.fire({
	title: '<div class="newtons-cradle"><div class="newtons-cradle__dot"></div><div class="newtons-cradle__dot"></div><div class="newtons-cradle__dot"></div><div class="newtons-cradle__dot"></div></div>',
	showConfirmButton: false,
	text: 'Estamos configurando algunas cosas, por favor espere...',
	timer: 5000,
	allowOutsideClick: false,
	allowEscapeKey: false,
	allowEnterKey: false,
	stopKeydownPropagation: false
})
promesa.then(() => {
	w3.getElement('#formNegocio').classList.replace('w3-hide', 'w3-show');
	Swal.fire({
		title: '<div class="loader"><span>B</span><span>I</span><span>E</span><span>N</span><span>V</span><span>E</span><span>N</span><span>I</span><span>D</span><span>O</span><span>.</span><span>.</span><span>.</span></div>',
		showConfirmButton: false,
		timer: 5000,
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		stopKeydownPropagation: false,
		grow: 'row'
	});
});