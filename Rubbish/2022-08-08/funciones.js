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