<?php

require_once '../../../common/server/conexion.php';
require_once("../../../common/server/libreriascomunes.php");

$sql = '';
$sqlAudit = '';
$data = json_decode(stripslashes($_POST["data"]));

if (is_array($data)) {
    foreach ($data as $value) {
        $sql .= "DELETE FROM fic_ficha WHERE fic_id = $value->con_id;";
        $sqlAudit .= "DELETE FROM fic_ficha WHERE fic_id = $value->con_id;";
    }
    $registro = $db->execute($sql);
} else {
    $sql = "DELETE FROM fic_ficha WHERE fic_id = ?";
    $registro = $db->execute($sql, $data->con_id);
    $sqlAudit = "DELETE; TABLA fic_ficha; ID:" . $data->con_id;
}

echo json_encode(array(
    "success" => true,
    "data" => $registro
));

setAuditoria("Usos hecho (eliminar)", $sqlAudit);