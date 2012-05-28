<?php
require_once '../../../../../common/server/conexion.php';

$sql = "SELECT cor_id, cor_autor_act_nombre FROM fic_concesionario ORDER BY fic_concesionario";
$registro = $db->getRecords($sql);

echo json_encode(array(
	"success" => true,
	"data"	 => $registro
));

//Spoon::dump($registro);