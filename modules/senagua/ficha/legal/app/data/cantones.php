<?php
require_once '../../../../../common/server/conexion.php';

$sql = "SELECT dpa_id dpa_codigo, dpa_descripcion FROM fic_dpa WHERE dpa_grupo = ? ORDER BY dpa_descripcion";
$registro = $db->getRecords($sql, 'Cantones');

echo json_encode(array(
	"success" => true,
	"data"	 => $registro
));

//Spoon::dump($registro);