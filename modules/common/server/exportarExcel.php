<?php
require_once 'conexion.php';
require_once("libreriascomunes.php");
require_once '../PHPExcel/PHPExcel.php';

$tipo = $_GET["tipo"];

$rows = recuperaConcesionesUltimoFiltros($tipo);

exportaexcel($rows, $tipo);