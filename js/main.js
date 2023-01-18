"use strict";

// @ts-nocheck
/** @typedef {import('./funciones')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLDivElement} */
var overlay = document.querySelector('.w3-overlay');
/** @type {HTMLButtonElement} */
var barras = document.querySelector('.icon-bars').parentElement;
/** @type {HTMLElement} [description] */
var menuLateral = document.querySelector('#menu');
/** @type {HTMLButtonElement} */
var btnModenas = document.querySelector('#btn-monedas');
/** @type {HTMLFormElement} */
var formMonedas = document.querySelector('#actualizarMonedas');
var main = document.querySelector('main');
var dashboardHTML = main.innerHTML;
var conversionMonetaria = document.querySelector('#conversionMonetaria');
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reajustar();
menu();
navegacion();
if (formMonedas) actualizarMonedas(formMonedas);
if (conversionMonetaria) {
  var valorDolar = Number(conversionMonetaria.valorDolar.value);
  var valorPesos = Number(conversionMonetaria.valorPesos.value);

  /** @type {HTMLInputElement} */
  var inputBS = conversionMonetaria.bs;
  /** @type {HTMLInputElement} */
  var inputDolar = conversionMonetaria.dolar;
  /** @type {HTMLInputElement} */
  var inputPesos = conversionMonetaria.pesos;
  inputBS.onkeyup = function () {
    inputDolar.value = Number(inputBS.value / valorDolar).toFixed(2);
    inputPesos.value = Number(inputDolar.value * valorPesos).toFixed(0);
  };
  inputDolar.onkeyup = function () {
    inputBS.value = Number(inputDolar.value * valorDolar).toFixed(2);
    inputPesos.value = Number(inputDolar.value * valorPesos).toFixed(0);
  };
  inputPesos.onkeyup = function () {
    inputDolar.value = Number(inputPesos.value / valorPesos).toFixed(2);
    inputBS.value = Number(inputDolar.value * valorDolar).toFixed(2);
  };
}
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/