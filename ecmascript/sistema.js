const overlay     = w3.getElement("#modalOverlay");
/*============================
=            MENU            =
============================*/
const menuOverlay = w3.getElement("#menuOverlay");
const barras      = w3.getElement("#barras");
const sidebar     = w3.getElement("#mySidebar");
menu(barras, sidebar, menuOverlay);

/*=================================
=            MI PERFIL            =
=================================*/
if(w3.getElement("#miPerfil")){
	var formDatosPerfil = w3.getElement("#formPerfil");
	var formActualizarClave     = w3.getElement("#formClave");
	var formActualizarPreguntas = w3.getElement("#formPreguntas");
	const botonSobreMi   = w3.getElement("#botonSobre");
	const botonSeguridad = w3.getElement("#botonSeguridad");
	const botonActualizarDatos     = w3.getElement("#botonActualizar");
	const botonActualizarClave     = w3.getElement("#botonActualizarClave");
	const botonActualizarPreguntas = w3.getElement("#botonActualizarPreguntas");
	const panelSobreMi   = w3.getElement("#panelSobreMi");
	const sobreMi        = w3.getElement("#sobreMi");
	const panelSeguridad = w3.getElement("#panelSeguridad");
	const infoClave      = w3.getElement("#infoClave");
	const preguntas      = w3.getElement("#preguntas");

	validar(formDatosPerfil);
	validar(formActualizarClave);
	validar(formActualizarPreguntas);
	actualizarFoto();
	modal(botonActualizarDatos, formDatosPerfil, overlay);
	modal(botonActualizarClave, formActualizarClave, overlay);
	modal(botonActualizarPreguntas, formActualizarPreguntas, overlay);

	botonSobreMi.addEventListener("click", () => {
		// Mostrar
		panelSobreMi.classList.add("w3-animate-opacity");
		panelSobreMi.classList.replace("w3-hide", "w3-show");
		sobreMi.classList.add("w3-animate-opacity");
		sobreMi.classList.replace("w3-hide", "w3-show");
		botonActualizarDatos.classList.replace("w3-hide", "w3-show");
		// Ocultar
		panelSeguridad.classList.remove("w3-animate-opacity");
		panelSeguridad.classList.replace("w3-show", "w3-hide");
		infoClave.classList.remove("w3-animate-opacity");
		infoClave.classList.replace("w3-show", "w3-hide");
		preguntas.classList.replace("w3-show", "w3-hide");
		botonActualizarClave.classList.replace("w3-show", "w3-hide");
		botonActualizarPreguntas.classList.replace("w3-show", "w3-hide");
	});

	botonSeguridad.addEventListener("click", () => {
		// Mostrar
		panelSeguridad.classList.add("w3-animate-opacity");
		panelSeguridad.classList.replace("w3-hide", "w3-show");
		infoClave.classList.add("w3-animate-opacity");
		infoClave.classList.replace("w3-hide", "w3-show");
		preguntas.classList.replace("w3-hide", "w3-show");
		botonActualizarClave.classList.replace("w3-hide", "w3-show");
		botonActualizarPreguntas.classList.replace("w3-hide", "w3-show");
		// Ocultar
		panelSobreMi.classList.remove("w3-animate-opacity");
		panelSobreMi.classList.replace("w3-show", "w3-hide");
		sobreMi.classList.remove("w3-animate-opacity");
		sobreMi.classList.replace("w3-show", "w3-hide");
		botonActualizarDatos.classList.replace("w3-show", "w3-hide");
	});
}

/*================================
=            NEGOCIOS            =
================================*/
if(w3.getElement("#negocios")){
	const btnRespaldar = w3.getElement("#boton-respaldar");
	btnRespaldar.addEventListener("click", () => {
		Swal.fire({
			title: "¿Desea crear una copia de seguridad de todos los datos?",
			showCancelButton: true,
			confirmButtonText: "Crear",
			cancelButtonText: "Cancelar",
			confirmButtonColor: "#223a5e",
			cancelButtonColor: "#a6001a",
			reverseButtons: true,
			showCloseButton: true,
			showLoaderOnConfirm: true,
			preConfirm: async () => {
				return await axios("php/respaldarBD.php", {
					params: {
						respaldar: true
					}
				});
			}
		}).then(resultado => {
			if(!resultado.isDismissed && resultado.value.status == 200 && resultado.value.data){
				notificacion("Copia de seguridad creada exitósamente", false);
			} else if(!resultado.isDismissed) {
				alerta("Ha ocurrido un error, por favor intente nuevamente");
				btnRespaldar.click();
			}
		});
	});

	const btnRestaurar = w3.getElement("#boton-restaurar");
	btnRestaurar.addEventListener("click", () => {
		Swal.fire({
			title: "Tener en cuenta que al restaurar se perderán cambios que no hayan sido respaldados",
			html: "<b class='w3-text-red'>¿Desea continuar?</b>",
			showCancelButton: true,
			confirmButtonText: "Continuar",
			cancelButtonText: "Cancelar",
			confirmButtonColor: "#223a5e",
			cancelButtonColor: "#a6001a",
			reverseButtons: true,
			showCloseButton: true,
			showLoaderOnConfirm: true,
			preConfirm: async () => {
				return await axios("php/restaurarBD.php", {
					params: {
						restaurar: true
					}
				});
			}
		}).then(resultado => {
			if(!resultado.isDismissed && resultado.value.status == 200 && resultado.value.data){
				Swal.fire({
					title: "Copia de seguridad restaurada exitósamente",
					html: '<b class="w3-xlarge w3-text-green">REINICIANDO EL SISTEMA</b>',
					icon: "success",
					timer: 3000,
					timerProgressBar: true,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false,
					showConfirmButton: false,
				});
				setTimeout(() => {
					let href = window.location.href;
					href = href.replace(/negocio/g, coincidencia => {coincidencia = 'salir'; console.log(coincidencia)});
					window.location.href = href;
				}, 3000);
			} else if(!resultado.isDismissed) {
				alerta("Ha ocurrido un error, por favor intente nuevamente");
				btnRestaurar.click();
			}
		});
	});

	const botonesNegocios       = w3.getElements(".botonNegocio");
	const botonRegistrarNegocio = w3.getElement("#botonAgregarNegocio");
	const panelesNegocios       = w3.getElements(".panelNegocio");
	const formRegistrarNegocio  = w3.getElement("#formularioRegistrarNegocio");

	validar(formRegistrarNegocio);
	modal(botonRegistrarNegocio, formRegistrarNegocio, overlay);
	actualizarFoto();

	botonesNegocios.forEach(botonNegocio => {
		const id = botonNegocio.id.substring(12);
		const panelNegocio = w3.getElement(`#panelNegocio${id}`);
		const formNegocio = w3.getElement(`#formularioActualizar${id}`);
		const botonActualizar = w3.getElement(`#botonActualizarNegocio${id}`);
		modal(botonActualizar, formNegocio, overlay);
		validar(formNegocio);
		botonNegocio.addEventListener("click", () => {
			panelesNegocios.forEach(panel => panel.classList.replace("w3-show", "w3-hide"));
			panelNegocio.classList.replace("w3-hide", "w3-show");
		});
	});
}

/*=====================================
=            MODALES INDEX            =
=====================================*/
const modalAcercaDe         = w3.getElement("#modalAcercaDe");
const version               = w3.getElement("#version");
modal(version, modalAcercaDe, overlay);

if(w3.getElement("#index")){
	axios.get("https://s3.amazonaws.com/dolartoday/data.json").then(respuesta=>{
		let fecha = respuesta.data._timestamp.fecha;
		let dolarT = respuesta.data.USD.transferencia;
		let dolarE = respuesta.data.USD.efectivo;
		w3.getElement("#fD").innerHTML = `<i class="w3-small">${fecha}</i>`;
		w3.getElement("#dT").innerHTML = `<i class="w3-small">Transferencia </i> ${dolarT}`;
		w3.getElement("#dE").innerHTML = `<i class="w3-small">Efectivo </i> ${dolarE}`;
		w3.getElement("#dolarToday").classList.replace("w3-hide", "w3-show");
	}).catch(error=>console.log(error));
	const enlaceRegistroCambios = w3.getElement("#registroCambios");
	const enlaceSoporteTecnico  = w3.getElement("#soporteTecnico");
	const enlaceAcercaDe        = w3.getElement("#acercaDeSistema");
	const enlaceManual          = w3.getElement("#manualUsuario");
	const modalRegistroCambios  = w3.getElement("#modalRegistroCambios");
	const modalSoporteTecnico   = w3.getElement("#modalSoporteTecnico");
	const modalManual           = w3.getElement("#modalManual");

	modal(enlaceRegistroCambios, modalRegistroCambios, overlay);
	modal(enlaceSoporteTecnico, modalSoporteTecnico, overlay);
	modal(enlaceAcercaDe, modalAcercaDe, overlay);
	modal(enlaceManual, modalManual, overlay);

	const botonActualizarMonedas = w3.getElement("#actualizarMonedas");
	const formMonedas = w3.getElement("#formMonedas");

	if(botonActualizarMonedas){
		validar(formMonedas);
		modal(botonActualizarMonedas, formMonedas, overlay);
	}
}

/*==================================
=            INVENTARIO            =
==================================*/
if(w3.getElement("#inventario") && w3.getElements("input[name='editar']")){
	const btnEdit = w3.getElements("input[name='editar']");
	const formEdit = w3.getElement("#formEditProducto");
	btnEdit.forEach(boton => {
		boton.addEventListener("click", e => {
			e.preventDefault();
			ventanaEmergente(formEdit, overlay);
			const data  = boton.parentElement.parentElement.querySelectorAll("input[readonly]");
			let codigo  = data[0].value;
			let nombre  = data[1].value;
			let stock   = data[2].value;
			let excento = data[3].value;
			let precio  = data[4].value;
			formEdit.querySelector("input[name='codigo']").value = codigo;
			formEdit.querySelector("input[name='cod']").value = codigo;
			formEdit.querySelector("input[name='nombreProducto']").value = nombre;
			formEdit.querySelector("input[name='stock']").value = stock;
			formEdit.querySelector("input[name='precio']").value = precio;
			formEdit.querySelector("select[name='excento']").value = excento;
		});
	})
}

/*==================================
=            CLIENTES              =
==================================*/
if(w3.getElement("#clientes") && w3.getElements("input[name='editar']")){
	const btnEdit = w3.getElements("input[name='editar']");
	const formEdit = w3.getElement("#formEditCliente");
	btnEdit.forEach(boton => {
		boton.addEventListener("click", e => {
			e.preventDefault();
			ventanaEmergente(formEdit, overlay);
			const data = boton.parentElement.parentElement.querySelectorAll("input[readonly]");
			let cedula = data[0].value;
			let nombre = data[1].value;
			formEdit.querySelector("input[name='cedula']").value = cedula;
			formEdit.querySelector("input[name='ci']").value = cedula;
			formEdit.querySelector("input[name='nombre']").value = nombre;
		});
	});
}

/*==================================
=            PROVEEDOR             =
==================================*/
if(w3.getElement("#proveedores") && w3.getElements("input[name='editar']")){
	const btnEdit = w3.getElements("input[name='editar']");
	const formEdit = w3.getElement("#formEditProveedor");
	btnEdit.forEach(boton => {
		boton.addEventListener("click", e => {
			e.preventDefault();
			ventanaEmergente(formEdit, overlay);
			const data = boton.parentElement.parentElement.querySelectorAll("input[readonly]");
			let id = data[0].value;
			let nombre = data[1].value;
			formEdit.querySelector("input[name='id']").value = id;
			formEdit.querySelector("input[name='nombreProveedor']").value = nombre;
		});
	});
}

/*========================================
=            MODALES REGISTRO            =
========================================*/
if(w3.getElement("#formularioRegistrarProducto")){
	var botonRegistrarProducto = w3.getElement("#registrarProducto");
	var modalRegistroProducto = w3.getElement("#formularioRegistrarProducto");
	modal(botonRegistrarProducto, modalRegistroProducto, overlay);
	validar(modalRegistroProducto);
}

if(w3.getElement("#formularioRegistrarCliente")){
	var botonRegistrarCliente = w3.getElement("#registrarCliente");
	var modalRegistroCliente = w3.getElement("#formularioRegistrarCliente");
	modal(botonRegistrarCliente, modalRegistroCliente, overlay);
	validar(modalRegistroCliente);
}

if(w3.getElement("#formularioRegistrarProveedor")){
	var botonRegistrarProveedor = w3.getElement("#registrarProveedor");
	var modalRegistroProveedor = w3.getElement("#formularioRegistrarProveedor");
	modal(botonRegistrarProveedor, modalRegistroProveedor, overlay);
	validar(modalRegistroProveedor);
}

if(w3.getElement("#formularioRegistrarUsuario")){
	var botonRegistrarUsuario = w3.getElement("#registrarUsuario");
	var modalRegistroUsuario = w3.getElement("#formularioRegistrarUsuario");
	modal(botonRegistrarUsuario, modalRegistroUsuario, overlay);
	validar(modalRegistroUsuario);
}

/*===================================
=            NUEVA VENTA            =
===================================*/
if(w3.getElement("#panelNuevaVenta")){
	const inputCliente    = w3.getElements(".inputCliente");
	const botonesClientes = w3.getElements(".botonCliente");
	const dolar = parseFloat(w3.getElement("#dolar").textContent.substring(4));
	const peso = parseInt(w3.getElement("#peso").textContent);
	const tooltips = w3.getElement(".tooltip").children;
	
	botonesClientes.forEach(boton => {
		const spans = boton.children;
		boton.addEventListener("click", () => {
			let texto = spans[0].innerHTML;
			inputCliente[1].value = texto.substring(2);
			inputCliente[0].nextElementSibling.innerHTML = "v-" + texto.substring(2);
			inputCliente[0].value = spans[1].innerHTML;
		});
	});

	const inputsProducto   = w3.getElements(".inputProducto");
	const inputCodigo      = w3.getElement("input[name='codigo']");
	const inputStock       = w3.getElement("input[name='stock']");
	const inputPrecio      = w3.getElement("input[name='precioB']");
	const inputExcento		 = w3.getElement("input[name='excento']");
	const inputCantidad    = w3.getElement("input[name='cantidad']");
	const inputTotal       = w3.getElement("input[name='precioT']");
	const nombresProductos = w3.getElements(".nombreProducto");
	const botonAgregar     = w3.getElement("input[name='agregarProducto']");

	nombresProductos.forEach(producto => {
		const spans = producto.children;
		producto.addEventListener("click", () => {
			inputsProducto[0].value = spans[0].innerHTML;
			inputsProducto[1].value = spans[0].innerHTML;
			inputCodigo.value   = spans[1].innerHTML;
			inputStock.value    = spans[2].innerHTML;
			inputExcento.value  = spans[4].innerHTML;
			inputCantidad.setAttribute("max", spans[2].innerHTML);
			inputPrecio.value   = spans[3].innerHTML;
			let precio = parseFloat(inputPrecio.value.substring(2));
			let precioBs = (dolar * precio).toFixed(2);
			let precioPesos = peso * precio;
			tooltips[0].innerHTML = `<b class="w3-block">Bs. ${precioBs}</b>`;
			tooltips[1].innerHTML = `<b class="w3-block">Pesos. ${precioPesos}</b>`;
			if(inputStock.value == "0"){
				inputStock.value = "Agotado";
				inputStock.classList.replace("w3-disabled", "w3-red");
				inputCantidad.setAttribute("disabled", "true");
			} else {
				inputCantidad.removeAttribute("disabled");
				inputStock.classList.replace("w3-red", "w3-disabled");
			}
		});
	});

	inputCantidad.addEventListener("change", actualizarPrecio);
	inputCantidad.addEventListener("keypress", actualizarPrecio);

	function actualizarPrecio(){
		inputTotal.value = (inputCantidad.value * inputPrecio.value.substring(2)).toFixed(2);
		botonAgregar.classList.add("w3-animate-right");
		botonAgregar.classList.replace("w3-hide", "w3-show");
	}

	if(inputCantidad.value){
		botonAgregar.classList.add("w3-animate-right");
		botonAgregar.classList.replace("w3-hide", "w3-show");
	}

	const botonActualizarMonedas = w3.getElement("#actualizarMonedas");
	const formMonedas = w3.getElement("#formMonedas");

	if(botonActualizarMonedas){
		validar(formMonedas);
		modal(botonActualizarMonedas, formMonedas, overlay);
	}
}

/*====================================
=            NUEVA COMPRA            =
====================================*/
if(w3.getElement("#panelNuevaCompra")){
	const inputProveedor    = w3.getElements(".inputProveedor");
	const botonesProveedores = w3.getElements(".botonProveedor");
	const dolar = parseFloat(w3.getElement("#dolar").textContent.substring(4));
	const peso = parseInt(w3.getElement("#peso").textContent);
	const tooltips = w3.getElement(".tooltip").children;
	
	botonesProveedores.forEach(boton => {
		const spans = boton.children;
		boton.addEventListener("click", () => {
			let texto = spans[0].innerHTML;
			inputProveedor[0].value = texto;
			inputProveedor[0].nextElementSibling.innerHTML = "ID-" + spans[1].innerHTML;
			inputProveedor[1].value = spans[1].innerHTML;
		});
	});

	const inputsProducto   = w3.getElements(".inputProducto");
	const inputCodigo      = w3.getElement("input[name='codigo']");
	const inputStock       = w3.getElement("input[name='stock']");
	const inputPrecio      = w3.getElement("input[name='precioB']");
	const inputExcento		 = w3.getElement("input[name='excento']");
	const inputCantidad    = w3.getElement("input[name='cantidad']");
	const inputTotal       = w3.getElement("input[name='precioT']");
	const nombresProductos = w3.getElements(".nombreProducto");
	const botonAgregar     = w3.getElement("input[name='agregarProducto']");

	if(inputStock.value == "0"){
		inputStock.value = "Agotado";
		inputStock.classList.replace("w3-disabled", "w3-red");
	} else {
		inputStock.classList.replace("w3-red", "w3-disabled");
	}

	nombresProductos.forEach(producto => {
		const spans = producto.children;
		producto.addEventListener("click", () => {
			inputsProducto[0].value = spans[0].innerHTML;
			inputsProducto[1].value = spans[0].innerHTML;
			inputCodigo.value   = spans[1].innerHTML;
			inputStock.value    = spans[2].innerHTML;
			inputPrecio.value   = spans[3].innerHTML;
			let precio = parseFloat(inputPrecio.value.substring(2));
			let precioBs = (dolar * precio).toFixed(2);
			let precioPesos = peso * precio;
			tooltips[0].innerHTML = `<b class="w3-block">Bs. ${precioBs}</b>`;
			tooltips[1].innerHTML = `<b class="w3-block">Pesos. ${precioPesos}</b>`;
			inputExcento.value  = spans[4].innerHTML;
			if(inputStock.value == "0"){
				inputStock.value = "Agotado";
				inputStock.classList.replace("w3-disabled", "w3-red");
			} else {
				inputStock.classList.replace("w3-red", "w3-disabled");
			}
		});
	});

	inputCantidad.addEventListener("change", actualizarPrecio);
	inputCantidad.addEventListener("keydown", actualizarPrecio);

	function actualizarPrecio(){
		inputTotal.value = (inputCantidad.value * inputPrecio.value.substring(2)).toFixed(2);
		botonAgregar.classList.add("w3-animate-right");
		botonAgregar.classList.replace("w3-hide", "w3-show");
	}

	if(inputCantidad.value){
		botonAgregar.classList.add("w3-animate-right");
		botonAgregar.classList.replace("w3-hide", "w3-show");
	}

	const botonActualizarMonedas = w3.getElement("#actualizarMonedas");
	const formMonedas = w3.getElement("#formMonedas");

	if(botonActualizarMonedas){
		validar(formMonedas);
		modal(botonActualizarMonedas, formMonedas, overlay);
	}
}

/*====================================
=            EDITAR DATOS            =
====================================*/
if(w3.getElement('#formEditar')){
	const form = w3.getElement('#formEditar');
	ventanaEmergente(form, overlay);
}

/*===================================
=            VER FACTURA            =
===================================*/
if(w3.getElement('#modalFactura')){
	const form = w3.getElement('form[method="POST"]')
	form.onsubmit = e => e.preventDefault()
	
	const modalFactura = w3.getElement('#modalFactura')
	const botones = w3.getElements('a[name="factura"]')
	botones.forEach(boton => modal(boton, modalFactura, overlay))
}

/*===========================
=            LOG            =
===========================*/
if(w3.getElement("#log")){
	const btnVaciar = w3.getElement("#boton-vaciar");
	btnVaciar.addEventListener("click", ()=>{
		axios(location.href, {
				params: {
					vaciar: true
				}
		}).then(() => location.reload());
	});
}