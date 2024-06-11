<?php
	session_start();
	require 'conexion.php';
	require 'funciones.php';

	if (!empty($_POST['respaldar'])):
		if ($_SESSION['cargo'] !== 'a')
			$respuesta['error'] = 'No tienes los permisos necesarios';
		
		if ($respuesta['error'])
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		
		try {
			$resultado = $conexion->query('SHOW TABLES');

			// OBTENGO LAS TABLAS en un array indexado
			while ($fila = $resultado->fetch_row()) $tablas[] = $fila[0];

			$texto = "SET foreign_key_checks=0;\n\n";

			// ITERA SOBRE CADA TABLA
			foreach ($tablas as $tabla):
				$resultado = $conexion->query("SELECT * FROM $tabla");
				$columnas = $resultado->field_count;
				$texto .= "TRUNCATE TABLE $tabla;\n";

				// ITERAR SOBRE LOS CAMPOS
				for ($i = 0; $i < $columnas; $i++):
					while ($fila = $resultado->fetch_assoc()):
						$texto .= "INSERT INTO $tabla VALUES(";
						$j = 0;
						foreach ($fila as $campo => $dato):
							if ($campo === 'id' ||
								$campo === 'activo' ||
								$campo === 'cedula' ||
								$campo === 'usuario_id' ||
								$campo === 'negocio_id' ||
								$campo === 'stock' ||
								$campo === 'excento' ||
								$campo === 'precio' ||
								$campo === 'producto_id' ||
								$campo === 'unidades' ||
								$campo === 'total' ||
								$campo === 'proveedor_id' ||
								$campo === 'cliente_id' ||
								$campo === 'iva' ||
								$campo === 'antiguo_stock' ||
								$campo === 'precio_base' ||
								$campo === 'precio_total' ||
								$campo === 'total_iva'
							)
								$texto .= "$dato";
							else
								$texto .= "'$dato'";
							if($j !== ($columnas - 1)) $texto .= ", ";
							$j++;
						endforeach;
						$texto .= ");\n\n";
					endwhile;
				endfor;
			endforeach;
			$archivo = fopen(__DIR__ . '/../database/backup.sql', 'w+');
			fwrite($archivo, $texto);
			fclose($archivo);
			$respuesta['ok'] = 'Copia de Seguridad creada exitósamente.';
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		} catch(Exception $e) {
			$respuesta['error'] = $e->getMessage();
			exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
		}
	endif;
	
	if (!empty($_POST['restaurar'])):
		$archivo   = __DIR__ . '/../database/backup.sql';
		$manejador = fopen($archivo, "r");
		$sql       = fread($manejador, filesize($archivo));
		$resultado = $conexion->multi_query($sql);
		if (!$resultado) $respuesta['error'] = $conexion->error;
		else session_destroy();
		$respuesta['ok'] = 'Copia de Seguridad restaurada exitósamente.';
		exit(json_encode($respuesta, JSON_INVALID_UTF8_IGNORE));
	endif;
?>
