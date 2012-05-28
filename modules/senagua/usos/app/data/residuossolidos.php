<?php
require_once '../../../../common/server/conexion.php';

$sql = "SELECT par_id, par_descripcion FROM fic_parametros WHERE par_grupo = ? ORDER BY par_descripcion";
$registro = $db->getRecords($sql, 'Tipo Residuos Solidos');

echo json_encode(array(
	"success" => true,
	"data"	 => $registro
));

//Spoon::dump($registro);