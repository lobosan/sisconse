<?php

function fileNamesFromDirectory($ruta) {
	if (is_dir($ruta)) {
		$arr_ext = array("jpg", "JPG");
		$dir = opendir($ruta);
		$index = 0;
		while ($archivo = readdir($dir)) {
			$ext = substr($archivo, -3);
			if (in_array($ext, $arr_ext)) {
				$imagenes[$index] = $archivo;
			}
			$index++;
		}
		closedir($dir);
		return $imagenes;
	}
}