<?php
header('content-type:text/html; charset=utf-8');

$server = '../../../../common/server/';

//conexion base de datos
require_once $server . 'conexion.php';

require_once $server . 'libreriasImportacion.php';
require_once $server . 'libreriascomunes.php';

//libreria para lectura de excel
require_once '../../../../common/PHPExcel/PHPExcel/IOFactory.php';
require_once 'validationHecho.php';

$archivo = "excel-path";
$error_importacion = "";
$faltante = "";

//para produccion es necesario activar la validacion de usuarios

/* if(!$os->session_exists()){
  die('No existe sesión!');
} */

global $xmlSetup;
global $datosMigrarExcel;

@move_uploaded_file($_FILES[$archivo]['tmp_name'], 'uploads/' . $_FILES[$archivo]['name']);
$archivonombre = $_FILES[$archivo]['name'];


$datos_subir = migrarfichasexcel($archivonombre, 'hecho', 'parametroshecho.xml');
subirdatos($datos_subir);

setAuditoria("Usos hecho (importación Excel)", $datos_subir["sql"]);

unificaCoordenadas();