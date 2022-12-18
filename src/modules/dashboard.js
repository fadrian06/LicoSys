// @ts-nocheck
/** @typedef {import('./funciones')} */
/** @typedef {import('./main')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLButtonElement} */
const btnAcercaDe = document.querySelector('#btn-acercaDe')
/** @type {HTMLButtonElement} */
const btnRegistro = document.querySelector('#btn-registro')
/** @type {HTMLButtonElement} */
const btnSoporte = document.querySelector('#btn-soporte')
/** @type {HTMLButtonElement} */
const btnManual = document.querySelector('#btn-manual')

/** @type {HTMLDivElement} */
const modalRegistro = document.querySelector('#registroCambios')
/** @type {HTMLDivElement} */
const modalSoporte = document.querySelector('#soporte')
/** @type {HTMLDivElement} */
const modalManual = document.querySelector('#manual')
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
modal(btnAcercaDe, modalAcercaDe, overlay)
modal(btnRegistro, modalRegistro, overlay)
modal(btnSoporte, modalSoporte, overlay)
modal(btnManual, modalManual, overlay)
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/