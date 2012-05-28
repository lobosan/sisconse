<?php
header('Content-type:text/html; charset=utf-8');
$server = '../../../../../common/server/';
//conexion base de datos
require_once $server . 'conexion.php';

//libreria para lectura de excel
require_once 'validation.php';
require_once $server . 'libreriasImportacion.php';
require_once $server . 'libreriascomunes.php';

$archivo = "csv-path";
$error_importacion = "";

global $xmlSetup;
global $datosMigrarCSV;

//para cuando se envio el archivo como parametro
@move_uploaded_file($_FILES[$archivo]['tmp_name'], 'uploads/' . $_FILES[$archivo]['name']);
$archivonombre = $_FILES[$archivo]['name'];

$datos_subir = migrarFichasCSV($archivonombre, 'legal', 'parametrosCSV.xml');
subirdatos($datos_subir);

setAuditoria("Usos legales (importación CSV)", $datos_subir["sql"]);

unificaCoordenadas();