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
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reajustar();
menu();
navegacion();
if (formMonedas) actualizarMonedas(formMonedas);
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/