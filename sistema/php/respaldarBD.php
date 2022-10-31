<?php
	if(isset($_GET['respaldar'])):
		try {
			require '../../php/conexion.php';
			require '../../php/funciones.php';
			$resultado = mysqli_query($conexion, 'SHOW TABLES');

			// OBTENGO LAS TABLAS en un array indexado
			while ($fila = mysqli_fetch_row($resultado)) $tablas[] = $fila[0];

			$texto = "SET foreign_key_checks=0;\n\n";

			// ITERA SOBRE CADA TABLA
			foreach($tablas as $tabla):
				$resultado = mysqli_query($conexion, "SELECT * FROM $tabla");
				$columnas = mysqli_num_fields($resultado);
				$texto .= "TRUNCATE TABLE $tabla;\n";

				// ITERAR SOBRE LOS CAMPOS
				for($i = 0; $i < $columnas; $i++):
					while($fila = mysqli_fetch_assoc($resultado)):
						$texto .= "INSERT INTO $tabla VALUES(";
						$j = 0;
						foreach($fila as $campo => $dato):
							if($campo == "stock" ||
								$campo == "cantidad" ||
								$campo == "precio_b" ||
								$campo == "ci_c" ||
								$campo == "ci_u" ||
								$campo == "id_c" ||
								$campo == "unidades" ||
								$campo == "id_p" ||
								$campo == "id_n" ||
								$campo == "activo" ||
								$campo == "id_v"
							):
								$texto .= "$dato";
							else:
								$texto .= "'$dato'";
							endif;
							if($j != ($columnas - 1)) $texto .= ", ";
							$j++;
						endforeach;
						$texto .= ");\n\n";
					endwhile;
				endfor;
			endforeach;
			$archivo = fopen("../../backup/licosys.sql", "w+");
			fwrite($archivo, $texto);
			fclose($archivo);
			echo "true";
		} catch(Exception $e){
			echo "false";
		}
	endif;
?>