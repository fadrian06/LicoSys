"use strict";

// @ts-nocheck
/** @typedef {import('./funciones')} */
/** @typedef {import('./main')} */

/*=====================================
=            DECLARACIONES            =
=====================================*/
/** @type {HTMLButtonElement} */
var btnAcercaDe = document.querySelector('#btn-acercaDe');
/** @type {HTMLButtonElement} */
var btnRegistro = document.querySelector('#btn-registro');
/** @type {HTMLButtonElement} */
var btnSoporte = document.querySelector('#btn-soporte');
/** @type {HTMLButtonElement} */
var btnManual = document.querySelector('#btn-manual');

/** @type {HTMLDivElement} */
var modalRegistro = document.querySelector('#registroCambios');
/** @type {HTMLDivElement} */
var modalSoporte = document.querySelector('#soporte');
/** @type {HTMLDivElement} */
var modalManual = document.querySelector('#manual');
/*=====  End of DECLARACIONES  ======*/

/*==============================================
=            EJECUCIÓN DE FUNCIONES            =
==============================================*/
modal(btnAcercaDe, modalAcercaDe, overlay);
modal(btnRegistro, modalRegistro, overlay);
modal(btnSoporte, modalSoporte, overlay);
modal(btnManual, modalManual, overlay);
/*=====  End of EJECUCIÓN DE FUNCIONES  ======*/