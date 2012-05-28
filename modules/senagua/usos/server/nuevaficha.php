<?php
require_once '../../../common/server/conexion.php';
require_once("../../../common/server/libreriascomunes.php");

$fic_id = "SELECT MAX (fic_id) FROM fic_ficha";
$fic_id = $db->getVar($fic_id);
$nuevoId = $fic_id + 1;

$sql = "INSERT INTO fic_ficha(fic_id) VALUES('$nuevoId');";
$db->execute($sql);

$sqlAudit = "INSERT; TABLA fic_ficha; ID:" . $nuevoId ;
setAuditoria("Usos hecho (Nueva)", $sqlAudit);

header("Location: ../usos_hecho.php?ficha=$nuevoId");
