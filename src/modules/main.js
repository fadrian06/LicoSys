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
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
reajustar()
menu()
navegacion()
if (formMonedas) actualizarMonedas(formMonedas)
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/