onoffline = ()=>{
	Swal.fire({
		title: "Se ha perdido la conexión",
		icon: "warning",
		toast: true,
		timer: 3000,
		timerProgressBar: true,
		position: "bottom-start",
		showConfirmButton: false
	})
}

ononline = ()=>{
	Swal.fire({
		title: "Se ha restablecido la conexión",
		icon: "success",
		toast: true,
		timer: 3000,
		timerProgressBar: true,
		position: "bottom-start",
		showConfirmButton: false
	})
}