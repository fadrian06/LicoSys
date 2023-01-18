// @ts-nocheck
/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLDivElement} */
const overlay = document.querySelector('.w3-overlay')
/** @type {HTMLButtonElement} */
const barras = document.querySelector('.icon-bars').parentElement
/** @type {HTMLElement} [description] */
const menuLateral = document.querySelector('#menu')
/** @type {HTMLButtonElement} */
const btnModenas = document.querySelector('#btn-monedas')
/** @type {HTMLFormElement} */
const formMonedas = document.querySelector('#actualizarMonedas')
const main = document.querySelector('main')
const dashboardHTML = main.innerHTML

const conversionMonetaria = document.querySelector('#conversionMonetaria')
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reajustar()
menu()
navegacion()
if (formMonedas) actualizarMonedas(formMonedas)
if (conversionMonetaria) {
	const valorDolar = Number(conversionMonetaria.valorDolar.value)
	const valorPesos = Number(conversionMonetaria.valorPesos.value)
	
	/** @type {HTMLInputElement} */
	const inputBS = conversionMonetaria.bs
	/** @type {HTMLInputElement} */
	const inputDolar = conversionMonetaria.dolar
	/** @type {HTMLInputElement} */
	const inputPesos = conversionMonetaria.pesos
	
	inputBS.onkeyup = () => {
		inputDolar.value = Number(inputBS.value / valorDolar).toFixed(2)
		inputPesos.value = Number(inputDolar.value * valorPesos).toFixed(0)
	}
	
	inputDolar.onkeyup = () => {
		inputBS.value = Number(inputDolar.value * valorDolar).toFixed(2)
		inputPesos.value = Number(inputDolar.value * valorPesos).toFixed(0)
	}
	
	inputPesos.onkeyup = () => {
		inputDolar.value = Number(inputPesos.value / valorPesos).toFixed(2)
		inputBS.value = Number(inputDolar.value * valorDolar).toFixed(2)
	}
}
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/