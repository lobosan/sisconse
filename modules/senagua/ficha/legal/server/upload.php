<?php

function thumbnail_calcsize($w, $h, $square) {
	$k = $square / max($w, $h);
	return array($w * $k, $h * $k);
}

function thumbnail_generator($srcfile, &$params) {
	// getting source image size
	@list($w, $h) = getimagesize($srcfile);
	if ($w == false)
		return false;

	// checking params array
	if (!is_array($params))
		return false;

	$src = ImageCreateFromJpeg($srcfile);
	list($s1_w, $s1_h) = thumbnail_calcsize($w, $h, $params['size']);

	// Create first thumbnail
	$img_s1 = imagecreatetruecolor($s1_w, $s1_h);
	imagecopyresampled($img_s1, $src, 0, 0, 0, 0, $s1_w, $s1_h, $w, $h);

	// Destroy source image
	imagedestroy($src);
	list($cur_w, $cur_h) = thumbnail_calcsize($w, $h, $params['size']);
	$img_cur = imagecreatetruecolor($cur_w, $cur_h);
	imagecopyresampled($img_cur, $img_s1, 0, 0, 0, 0, $cur_w, $cur_h, $s1_w, $s1_h);
	imagejpeg($img_cur, $params['file'], 90);
	imagedestroy($img_cur);

	// Saving first thumbnail
	imagejpeg($img_s1, $params['file'], 90);
	imagedestroy($img_s1);
	return true;
}

function uploadFile($file, $upload_dir) {
	$nombre_archivo = $_FILES[$file]['name'];
	$tipo_archivo = $_FILES[$file]['type'];
	$tamano_archivo = $_FILES[$file]['size'];
	$error_archivo = $_FILES[$file]['error'];
	$nombre_temporal = $_FILES[$file]['tmp_name'];
	
	if ($error_archivo > 0) {
		switch ($error_archivo) {
			case 1: echo '{success: false, msg: "El tamaño del archivo cargado supera el especificado en php.ini"}';
				break;
			case 2: echo '{success: false, msg: "El tamaño del archivo cargado supera el especificado en el formulario HTML"}';
				break;
			case 3: echo '{success: false, msg: "El archivo se ha cargado parcialmente"}';
				break;
			case 4: echo '{success: false, msg: "No se he cargado ningun archivo"}';
				break;
			case 6: echo '{success: false, msg: "No se ha especificado ningun directorio temporal en el archivo php.ini"}';
				break;
			case 7: echo '{success: false, msg: "Carga Fallida. No se puede escribir en el directorio"}';
				break;
		}
		return false;
	} else {
		if (!strpos($tipo_archivo, "jpeg")) {
			echo '{success: false, msg: "La extensión del archivo tiene que ser .jpg"}';
			return false;
		} elseif (file_exists($upload_dir . $nombre_archivo)) {
			echo '{success: false, msg: "La imagen ' . $nombre_archivo . ' ya existe"}';
			return false;
		} elseif ($tamano_archivo > 1000000) {
			echo '{success: false, msg: "La imagen ' . $nombre_archivo . ' pesa más de 1Mb"}';
			return false;
		} else {
			move_uploaded_file($nombre_temporal, $upload_dir . $nombre_archivo);

			// Setting params array for thumbnail_generator
			$params = array('size' => 80, 'file' => $upload_dir . '/thumbnails/' . $nombre_archivo);

			if (thumbnail_generator($upload_dir . $nombre_archivo, $params) == false) {
				echo '{success: false, msg: "Hubo un error al generar la miniatura"}';
				return false;
			}
		}
	}
	return true;
}