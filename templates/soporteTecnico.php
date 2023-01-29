<?php
	if (isset($mostrarSoporteTecnico)):
		/*=======================================
		=            SOPORTE TÉCNICO            =
		=======================================*/
		$contenido = <<<HTML
			<dl class="w3-left-align w3-container">
				<dt class="w3-tag w3-blue">
					<i class="icon-envelope-o"></i> Correo Electrónico
				</dt>
					<dd class="w3-section w3-hover-text-grey">
						<u>
							<a href="mailto:franyeradriansanchez@gmail.com">
								franyeradriansanchez@gmail.com
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<u>
							<a href="mailto:ftutorials610@gmail.com">
								ftutorials610@gmail.com
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<u>
							<a href="mailto:franyeradriansanchez@outlook.com">
								franyeradriansanchez@outlook.com
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<u>
							<a href="mailto:franyersanchez06@hotmail.com">
								franyersanchez06@hotmail.com
							</a>
						</u>
					</dd>
				<dt class="w3-tag w3-blue">
					<i class="icon-phone-square"></i> Teléfono
				</dt>
					<dd class="w3-section w3-hover-text-grey">
						<i class="icon-whatsapp w3-text-green"> </i>
						<u>
							<a target="_blank" href="https://api.whatsapp.com/send?phone=04165335826">
								+58 416-533-5826
							</a>
						</u>
					</dd>
					<dd class="w3-section w3-hover-text-grey">
						<i class="icon-whatsapp w3-text-green"> </i>
						<u>
							<a target="_blank" href="https://api.whatsapp.com/send?phone=04165462946">
								+58 416-546-2946
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<i class="icon-telegram w3-text-blue"> </i>
						<u>
							<a target="_blank" href="https://t.me/fsanchez61001">
								+58 416-533-5826
							</a>
						</u>
					</dd>
					<dd class="w3-margin-bottom w3-hover-text-grey">
						<i class="icon-telegram w3-text-blue"> </i>
						<u>
							<a target="_blank" href="https://t.me/YenderSanchez">
								+58 424-715-7381
							</a>
						</u>
					</dd>
			</dl>
		HTML;
		generarModal('div', 'soporte', 'Soporte Técnico', $contenido);
	endif;
?>