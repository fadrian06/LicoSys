document.querySelector("#barras").addEventListener("click", function(){
	w3.toggleShow("#mySidebar");
	w3.toggleShow("#myOverlay");
});

document.querySelector("#myOverlay").addEventListener("click", function(){
	w3.hide("#myOverlay");
	w3.hide("#mySidebar");
});

document.querySelector("#cerrarMenu").addEventListener("click", function(){
	w3.hide("#myOverlay");
	w3.hide("#mySidebar");
});