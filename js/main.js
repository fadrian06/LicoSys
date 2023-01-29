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
if (document.body.offsetWidth < 600) $('#temario').addClass('w3-small');
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
  inputBS.type = 'text';
  inputDolar.type = 'text';
  inputDolar.maxLength = 20;
  inputPesos.type = 'text';
  var resultadoDolar = 0;
  var resultadoPesos = 0;
  var resultadoBS = 0;
  var calcularDeBS = function calcularDeBS() {
    resultadoDolar = Number(inputBS.value / valorDolar).toFixed(2);
    resultadoPesos = Number(resultadoDolar * valorPesos).toFixed(0);
    if (isNaN(resultadoDolar) || isNaN(resultadoPesos)) {
      try {
        resultadoBS = Number(eval(inputBS.value)).toFixed(2);
      } catch (error) {
        true;
      }
      if (resultadoBS < 0) resultadoBS *= -1;
      resultadoDolar = Number(resultadoBS / valorDolar).toFixed(2);
      resultadoPesos = Number(resultadoDolar * valorPesos).toFixed(0);
      inputDolar.value = resultadoDolar;
      inputPesos.value = resultadoPesos;
    }
    inputDolar.value = resultadoDolar;
    inputPesos.value = resultadoPesos;
  };
  var calcularDeDolar = function calcularDeDolar() {
    resultadoBS = Number((inputDolar.value * valorDolar).toFixed(2));
    resultadoPesos = Number((inputDolar.value * valorPesos).toFixed(0));
    if (isNaN(resultadoBS) || isNaN(resultadoPesos)) {
      try {
        resultadoDolar = Number(eval(inputDolar.value).toFixed(2));
      } catch (error) {
        true;
      }
      if (resultadoDolar < 0) resultadoDolar *= -1;
      resultadoBS = Number((resultadoDolar * valorDolar).toFixed(2));
      resultadoPesos = Number((resultadoDolar * valorPesos).toFixed(0));
      inputBS.value = resultadoBS;
      inputPesos.value = resultadoPesos;
    }
    inputBS.value = resultadoBS;
    inputPesos.value = resultadoPesos;
  };
  var calcularDePesos = function calcularDePesos() {
    resultadoDolar = Number(inputPesos.value / valorPesos).toFixed(2);
    resultadoBS = Number(resultadoDolar * valorDolar).toFixed(2);
    if (isNaN(resultadoDolar) || isNaN(resultadoBS)) {
      try {
        resultadoPesos = eval(inputPesos.value).toFixed(0);
      } catch (error) {
        true;
      }
      if (resultadoPesos < 0) resultadoPesos *= -1;
      resultadoDolar = Number(resultadoPesos / valorPesos).toFixed(2);
      resultadoBS = Number(resultadoDolar * valorDolar).toFixed(2);
      inputDolar.value = resultadoDolar;
      inputBS.value = resultadoBS;
    }
    inputDolar.value = resultadoDolar;
    inputBS.value = resultadoBS;
  };
  inputBS.onkeyup = calcularDeBS;
  inputBS.onchange = calcularDeBS;
  inputBS.onblur = function () {
    return inputBS.value = resultadoBS;
  };
  inputDolar.onkeyup = calcularDeDolar;
  inputDolar.onchange = calcularDeDolar;
  inputDolar.onblur = function () {
    return inputDolar.value = resultadoDolar;
  };
  inputPesos.onkeyup = calcularDePesos;
  inputPesos.onchange = calcularDePesos;
  inputPesos.onblur = function () {
    return inputPesos.value = resultadoPesos;
  };
}
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/