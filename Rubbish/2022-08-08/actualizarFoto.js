const $fileInput = document.getElementById('foto');
const $dropZone = document.getElementById('result-image');
const $img = document.getElementById('img-result');
const $submit = document.getElementById('submit');
const $span = document.querySelectorAll("#formulario-foto span");

const uploadImage = (file) => {
	const fileReader = new FileReader();
	fileReader.readAsDataURL(file);
	fileReader.addEventListener('load', (e) => {
		$img.setAttribute('src', e.target.result)
	})
}

$fileInput.addEventListener('change', (e) => {
	const file = e.target.files[0];
	if (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "image/png") {
		if (file.size < 1 * 1000 * 2048) {
			uploadImage(file);
			$submit.classList.remove("w3-hide");
			$span.forEach(function (span) {
				span.classList.add("w3-animate-bottom");
			})
		} else {
			Swal.fire({
				title: 'La imagen no puede ser mayor a <b class=\"w3-text-red\" title=\"2 Megabytes\">2MB</b>',
				icon: 'error',
				timer: 5000,
				timerProgressBar: true,
				position: 'bottom-end',
				showConfirmButton: false
			})
		}
	} else {
		Swal.fire({
			title: 'Sólo se permiten imagenes (<b>jpeg, jpg</b>&nbsp;o <b>png</b>)',
			icon: 'error',
			timer: 5000,
			timerProgressBar: true,
			position: 'bottom-end',
			showConfirmButton: false
		})
	}
})