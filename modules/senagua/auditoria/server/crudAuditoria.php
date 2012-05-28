<?php

require_once '../../../../server/os.php';

$os = new os();
if (!$os->session_exists()) {
    die('No existe sesión!');
}

$start = (integer) (isset($_POST['start']) ? $_POST['start'] : 0);
$fin = (integer) (isset($_POST['limit']) ? $_POST['limit'] : 200);

/* borrar registros que no son auditables */
$sql0 = "DELETE FROM auditoria WHERE modulo='Usos hecho (filtrar)' OR modulo='Usos legales (filtrar)';";
$result0 = $os->db->conn->query($sql0);
/* fin borrar registros que no son auditables */


$sql_count  = "SELECT * FROM auditoria ORDER BY fecha ASC";
$sql  = $sql_count . " LIMIT $fin OFFSET $start";


$total = cuentaAudit ($sql_count);
$result = $os->db->conn->query($sql);
$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

$resultado =  json_encode(array(
    "success" => true,
    "total" => $total,
    "data" => $data)
);
echo $resultado;

function cuentaAudit (){
    global $os;
    $sql_count =  "SELECT COUNT (*) total FROM auditoria ";
    $sql_count = $os->db->conn->query  ($sql_count);
    $sql_count ->execute ();
    $row = $sql_count->fetch(PDO::FETCH_ASSOC);
    return $row ["total"];
}