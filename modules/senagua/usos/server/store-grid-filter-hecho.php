<?php
require_once "../../../../server/os.php";
$os = new os();
require_once("../../../common/server/libreriascomunes.php");
require_once '../../../common/server/conexion.php';


$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

$data = recuperaConcesionesFiltros($tipo);
$rows = $data ["rows"];
$where = $data ["where"];
$count = totalconcesiones($where);

echo json_encode(Array(
    "total" => $count['count'],
    "data" => $rows
));