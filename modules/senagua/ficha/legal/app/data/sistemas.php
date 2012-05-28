<?php
require_once '../../../../../common/server/conexion.php';

$sql = "SELECT hid_id AS hid_codigo, hid_nombre FROM fic_hidrograficas WHERE hid_grupo = ? ORDER BY hid_nombre";
$registro = $db->getRecords($sql, 'Sistemas');

echo json_encode(array(
	"success" => true,
	"data"	 => $registro
));

//Spoon::dump($registro);