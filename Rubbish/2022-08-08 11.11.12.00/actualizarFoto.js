const $fileInputs = document.querySelectorAll("input[type='file']");
const $dropZones  = document.querySelectorAll("label.w3-display-container.w3-hover-opacity");
const $images     = document.querySelectorAll("img.image-result");
const $submits    = document.querySelectorAll("input[name='actualizarFoto']");
const $spans      = document.querySelectorAll(".formulario-foto span");

const uploadImage = (file) => {
	const fileReader = new FileReader();
	fileReader.readAsDataURL(file);
	fileReader.addEventListener('load', (e) => {
		$images.forEach(function ($img) {
			$img.setAttribute('src', e.target.result)
		})
	})
}

$fileInputs.forEach(function ($fileInput) {
	$fileInput.addEventListener('change', (e) => {
		const file = e.target.files[0];
		if (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "image/png") {
			if (file.size < 1 * 1000 * 2048) {
				uploadImage(file);
				$submits.forEach(function ($submit) {
					$submit.classList.remove("w3-hide");
				})
				$spans.forEach(function (span) {
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
})