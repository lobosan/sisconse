<?php
require_once '../../../../common/server/conexion.php';

$sql = "SELECT * FROM fichas WHERE con_id = ?";

$registro = $db->getRecord($sql, $_GET['id']);

echo json_encode(array(
	"success" => true,
	"data"	 => $registro
));

//Spoon::dump($registro);