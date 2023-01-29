<?php
	if (isset($mostrarManual)):
		/*=========================================
		=            MANUAL DE USUARIO            =
		=========================================*/
		$titulo = <<<HTML
			<span class="w3-padding">Manual de Usuario</span>
		HTML;
		$contenido = <<<HTML
			<div class="w3-display-container">
				<a href="#temario" class="w3-button w3-grey w3-round-large w3-border w3-display-bottomright w3-margin">
					<i class="icon-chevron-up"></i>
				</a>
				<ul id="temario" class="w3-ul w3-container w3-row-padding">
					<li class="w3-text-indigo w3-xlarge w3-padding">Temario</li>
					<div class="w3-half">
						<li>
							<a href="#manualIntroduccion" class="w3-block w3-button w3-left-align">
								1. Introducción
							</a>
						</li>
						<li>
							<a href="#manualRequisitos" class="w3-block w3-button w3-left-align">
								2. Requisitos
							</a>
						</li>
						<li>
							<a href="#manualInstalacion" class="w3-block w3-button w3-left-align">
								3. Instalación
							</a>
						</li>
						<li class="w3-dropdown-hover w3-block">
							<button class="w3-block w3-button w3-left-align">
								<span class="w3-left">4. Primeros pasos</span>
								<i class="w3-right icon-chevron-right"></i>
							</button>
							<div class="w3-dropdown-content w3-card-4">
								<a href="#manualPrimerNegocio" class="w3-block w3-button w3-left-align">
									Primer negocio
								</a>
								<a href="#manualCuentaAdministrador" class="w3-block w3-button w3-left-align">
									Su cuenta de administración
								</a>
							</div>
						</li>
						<li class="w3-dropdown-hover w3-block">
							<button class="w3-block w3-button w3-left-align">
								<span class="w3-left">5. Preguntas y Respuestas secretas</span>
								<i class="w3-right icon-chevron-right"></i>
							</button>
							<div class="w3-dropdown-content w3-card-4">
								<a href="#manualUsoPreguntasRespuestas" class="w3-block w3-button w3-left-align">
									Uso de las preguntas y respuestas secretas
								</a>
								<a href="#manualCrearPreguntasRespuestas" class="w3-block w3-button w3-left-align">
									¿Cómo registro mis preguntas y respuestas secretas?
								</a>
							</div>
						</li>
						<li>
							<a href="#manualRecuperarContraseña" class="w3-block w3-button w3-left-align">
								6. ¡Hé olvidado mi contraseña!
							</a>
						</li>
						<li>
							<a href="#manualQueHacer" class="w3-block w3-button w3-left-align">
								7. ¿Qué puedo hacer en LicoSys?
							</a>
						</li>
						<li>
							<a href="#manualRegistrarVentas" class="w3-block w3-button w3-left-align">
								8. ¿Cómo registrar ventas?
							</a>
						</li>
					</div>
					<div class="w3-half">
						<li class="w3-dropdown-hover w3-block">
							<button class="w3-block w3-button w3-left-align w3-white">
								<span class="w3-left">9. Clientes</span>
								<i class="w3-right icon-chevron-right"></i>
							</button>
							<div class="w3-dropdown-content w3-card-4">
								<a href="#manualRegistrarClientes" class="w3-block w3-button w3-left-align">
									Registrar un cliente
								</a>
								<a href="#manualActualizarCliente" class="w3-block w3-button w3-left-align">
									Actualizar un cliente
								</a>
							</div>
						</li>
						<li class="w3-dropdown-hover w3-block">
							<button class="w3-block w3-button w3-left-align w3-white">
								<span class="w3-left">10. Inventario</span>
								<i class="w3-right icon-chevron-right"></i>
							</button>
							<div class="w3-dropdown-content w3-card-4">
								<a href="#manualRegistrarProducto" class="w3-block w3-button w3-left-align">
									Registrar un artículo
								</a>
								<a href="#manualProductoAgotado" class="w3-block w3-button w3-left-align">
									Producto AGOTADO
								</a>
							</div>
						</li>
						<li>
							<a href="#manualActualizarDatos" class="w3-block w3-button w3-left-align">
								11. Ingresé mal un dato, ¿cómo arreglarlo?
							</a>
						</li>
						<li>
							<a href="#manualUsuarioDesactivado" class="w3-block w3-button w3-left-align">
								12. Este usuario se encuentra desactivado
							</a>
						</li>
						<li>
							<a href="#manualFinanzas" class="w3-block w3-button w3-left-align">
								13. Tengo las finanzas en negativo
							</a>
						</li>
						<li>
							<a href="#manualConversionMonetaria" class="w3-block w3-button w3-left-align">
								14. Conversión monetaria
							</a>
						</li>
						<li>
							<a href="#manualSoporteTecnico" class="w3-block w3-button w3-left-align">
								15. ¿Cómo consulto a soporte técnico?
							</a>
						</li>
						<li>
							<a href="#manualPreguntasFrecuentes" class="w3-block w3-button w3-left-align">
								16. Preguntas frecuentes de LicoSys
							</a>
						</li>
					</div>
				</ul>
				<div role="contenido">
					<section id="manualIntroduccion"></section>
					<section id="manualRequisitos"></section>
					<section id="manualInstalacion"></section>
					<section id="manualPrimerosPasos"></section>
					<section id="manualPrimerNegocio"></section>
					<section id="manualCuentaAdministrador"></section>
					<section id="manualUsoPreguntasRespuestas"></section>
					<section id="manualCrearPreguntasRespuestas"></section>
					<section id="manualRecuperarContraseña"></section>
					<section id="manualQueHacer"></section>
					<section id="manualRegistrarVentas"></section>
					<section id="manualRegistrarClientes"></section>
					<section id="manualActualizarCliente"></section>
					<section id="modalRegistrarProducto"></section>
					<section id="manualProductoAgotado"></section>
					<section id="manualActualizarDatos"></section>
					<section id="manualUsuarioDesactivado"></section>
					<section id="manualUsuarioDesactivado"></section>
					<section id="manualFinanzas"></section>
					<section id="manualConversionMonetaria"></section>
					<section id="manualSoporteTecnico"></section>
					<section id="manualPreguntasFrecuentes"></section>
				</div>
			</div>
		HTML;
		generarModal('div', 'manual', $titulo, $contenido);
	endif;
?>