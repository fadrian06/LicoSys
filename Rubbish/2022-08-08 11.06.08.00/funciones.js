function formularioModal(boton, formulario, overlay) {
	document.querySelector(boton).addEventListener("click", function (e) {
		e.preventDefault();
		mostrarFormulario(formulario, overlay);
	})
}

function mostrarFormulario(formulario, overlay) {
	$overlay = document.querySelector(overlay);
	$formulario = document.querySelector(formulario);
	$overlay.classList.replace("w3-hide", "w3-show");
	$overlay.style.cursor = "pointer";
	$formulario.classList.replace("w3-hide", "w3-show");
	$formulario.classList.replace("animate__fadeOutDown", "animate__fadeInUp");

	$overlay.addEventListener("click", function () {
		this.classList.replace("w3-show", "w3-hide");
		$formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
		setTimeout(function () {
			$formulario.classList.replace("w3-show", "w3-hide");
		}, 500);
	})
	cerrarFormulario(formulario);
}

function cerrarFormulario(formulario) {
	$X = document.querySelector(`${formulario}>span`);
	$formulario = document.querySelector(formulario);
	$X.addEventListener("click", function (e) {
		this.classList.replace("w3-show", "w3-hide");
		$overlay.classList.replace("w3-show", "w3-hide");
		$formulario.classList.replace("animate__fadeInUp", "animate__fadeOutDown");
		setTimeout(function () {
			$formulario.classList.replace("w3-show", "w3-hide");
		}, 500);
	})
}


// Filter
function filterFunction(input, div) {
	var input, filter, ul, li, a, i;
	input = document.getElementById(input);
	filter = input.value.toUpperCase();
	div = document.getElementById(div);
	a = div.getElementsByTagName("a");
	for (i = 0; i < a.length; i++) {
		txtValue = a[i].textContent || a[i].innerText;
		if (txtValue.toUpperCase().indexOf(filter) > -1) {
			a[i].style.display = "";
		} else {
			a[i].style.display = "none";
		}
	}
}

function precioTotal(){
	let cantidad=document.getElementById('cantidad').value;
	let precioB=document.getElementById('precio').value;
	let precioT=document.getElementById('precioT');

	if(cantidad!=""){
		precioT.value=(precioB * cantidad).toFixed(2);
	}
}