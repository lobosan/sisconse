<?php
/**
 * Created by JetBrains PhpStorm.
 * User:
 * Date: 29/02/12
 * Time: 14:39
 */

function recuperaConcesionesFiltros($tipo)
{
    global $db;
    global $os;
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
    $count = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 500;
    $filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;
    $sorters = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';

    $filters = json_decode($filters);
    if ($tipo == 'legal'):
        $where = 'con_proceso IS NOT NULL';
        $auditado = 'Usos legales (filtrar)';
    else:
        $where = 'con_proceso IS NULL';
        $auditado = 'Usos hecho (filtrar)';
    endif;

    $qs = '';

    if (is_array($filters)) {
        for ($i = 0; $i < count($filters); $i++) {
            $filter = $filters[$i];

            $field = $filter->field;
            $value = $filter->value;
            $compare = isset($filter->comparison) ? $filter->comparison : null;
            $filterType = $filter->type;

            switch ($filterType) {
                case 'string' :
                    $qs .= " AND " . $field . " ~* '" . $value . "'";
                    break;
                case 'numeric' :
                    switch ($compare) {
                        case 'eq' :
                            $qs .= " AND " . $field . " = " . $value;
                            break;
                        case 'lt' :
                            $qs .= " AND " . $field . " < " . $value;
                            break;
                        case 'gt' :
                            $qs .= " AND " . $field . " > " . $value;
                            break;
                    }
                    break;
            }
        }
        $where .= $qs;
    }

    $query = "SELECT * FROM filtros WHERE " . $where;

    if ($sorters != "") {
        $sorters = json_decode($sorters);

        for ($i = 0; $i < count($sorters); $i++) {
            $sortby = $sorters[$i];
            $sort = $sortby->property;
            $dir = $sortby->direction;
        }

        $query .= " ORDER BY " . $sort . " " . $dir;
    }
    $query .= " LIMIT " . $count . " OFFSET " . $start;

    $os->auditoria($auditado, $query);
    quitarRegistrosBlanco();

    $rows = $db->getRecords($query);
    return array("rows" => $rows, "where" => $where);
}

function quitarRegistrosBlanco()
{
    global $db;
    $query = "DELETE FROM fic_ficha WHERE dpa_id ISNULL AND fic_formulario ISNULL AND fic_proceso ISNULL;";
    $db->execute($query);
}


function totalconcesiones($where)
{
    global $db;

    return $db->getRecord("SELECT COUNT(*) FROM filtros WHERE " . $where);
}

function setAuditoria($tipoaudit, $sql)
{

    if (is_file('../../../server/os.php')) {
        require_once('../../../server/os.php');
    }

    if (is_file('../../../../../server/os.php')) {
        require_once('../../../../../server/os.php');
    }

    //para el caso de librerias de hecho
    if (is_file('../../../../server/os.php')) {
        require_once('../../../../server/os.php');
    }

    if (is_file('../../../../../../server/os.php')) {
        require_once('../../../../../../server/os.php');
    }
    $os = new os();
    if ($sql != ''):
        $os->auditoria($tipoaudit, $sql);
    endif;
    return;
}

/*Exportar excel*/
function recuperaConcesionesUltimoFiltros($tipo)
{
    global $db;

    if ($tipo == 'legal'):
        $query = recuperaUltimoQuery('Usos legales (filtrar)');
    else:
        $query = recuperaUltimoQuery('Usos hecho (filtrar)');
    endif;

    return $db->getRecords($query);
}

/*Libreira Usada en exportacion de excel */
function recuperaUltimoQuery($tipoauditoria)
{
    require_once '../../../server/os.php';
    $os = new os();
    $sql = "SELECT query FROM auditoria  WHERE  modulo ='$tipoauditoria' ORDER BY fecha DESC LIMIT 1";
    $result = $os->db->conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row['query'];
}


/*usada en exportacion excel */
function exportaexcel($data, $tipo)
{

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(8);
    if ($tipo == 'legal'):
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', 'INFORMACION DE LOS USOS Y APROVECHAMIENTOS HIDRICOS DEL ECUADOR')
            ->setCellValue('I1', 'Fecha reporte: ' . date("d/m/Y"))
            ->setCellValue('A2', 'Proceso')
            ->setCellValue('B2', 'Autorizado Actual')
            ->setCellValue('C2', 'Provincia')
            ->setCellValue('D2', 'Cantón')
            ->setCellValue('E2', 'Parroquia')
            ->setCellValue('F2', 'Sistema Hidrográfico')
            ->setCellValue('G2', 'Cuenca')
            ->setCellValue('H2', 'Subcuenca')
            ->setCellValue('I2', 'Microcuenca');
    else:
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', 'INFORMACION DE LOS USOS DE HECHO DE LOS APROVECHAMIENTOS HIDRICOS DEL ECUADOR')
            ->setCellValue('I1', 'Fecha reporte: ' . date("d/m/Y"))
            ->setCellValue('A2', 'Ficha')
            ->setCellValue('B2', 'Autorizado Actual')
            ->setCellValue('C2', 'Provincia')
            ->setCellValue('D2', 'Cantón')
            ->setCellValue('E2', 'Parroquia')
            ->setCellValue('F2', 'Sistema Hidrográfico')
            ->setCellValue('G2', 'Cuenca')
            ->setCellValue('H2', 'Subcuenca')
            ->setCellValue('I2', 'Microcuenca');
    endif;


    for ($i = 0; $i < count($data); $i++) {
        $indice = $i + 3;
        if ($tipo == 'legal'):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $indice, $data[$i]['con_proceso'])
                ->setCellValue('B' . $indice, $data[$i]['rio_autoriz_actual_id'])
                ->setCellValue('C' . $indice, $data[$i]['dpa_provincia'])
                ->setCellValue('D' . $indice, $data[$i]['dpa_canton'])
                ->setCellValue('E' . $indice, $data[$i]['dpa_parroquia'])
                ->setCellValue('F' . $indice, $data[$i]['hid_id'])
                ->setCellValue('G' . $indice, $data[$i]['cue_id'])
                ->setCellValue('H' . $indice, $data[$i]['sub_id'])
                ->setCellValue('I' . $indice, $data[$i]['mic_id']);
        else:
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $indice, $data[$i]['con_formulario'])
                ->setCellValue('B' . $indice, $data[$i]['rio_autoriz_actual_id'])
                ->setCellValue('C' . $indice, $data[$i]['dpa_provincia'])
                ->setCellValue('D' . $indice, $data[$i]['dpa_canton'])
                ->setCellValue('E' . $indice, $data[$i]['dpa_parroquia'])
                ->setCellValue('F' . $indice, $data[$i]['hid_id'])
                ->setCellValue('G' . $indice, $data[$i]['cue_id'])
                ->setCellValue('H' . $indice, $data[$i]['sub_id'])
                ->setCellValue('I' . $indice, $data[$i]['mic_id']);
        endif;
    }

    $objPHPExcel->getActiveSheet()->setTitle('Listado ');
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);

    //-----Put in some formatting to the table data to make it easier to read-----

    $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
    $highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();

    //set heading row to bold and put a border on the top and bottom rows
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(100);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);

    $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setSize(11);


    $objPHPExcel->getActiveSheet()->getStyle('A2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($highestRow + 1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //Loop through all of the rows and put in fill and borders on the edges
    for ($row = 3; $row < $highestRow; $row++)
    {
        //Set the colors, mid blue/grey for the top and bottom rows, with alternating white and light blue/grey
        if ($row == 1 || $row == $highestRow + 1) $color = 'FFCFDAE7';
        else if ($row % 2 == 0) $color = 'FFFFFFFF';
        else $color = 'FFE7EDF5';

        // set the fill type and apply the color
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getFill()->getStartColor()->setARGB($color);

        //duplicate the first cells style (fill plus the top and bottom borders) across the whole row
        $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A' . $row), 'B' . $row . ':' . $highestColumn . $row); //copy style set in first column to the rest of the row

        //Put some borders on the far left and right cells of the row
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    }

    //set the width of the columns

    $highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn(); //e.g., 'G'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); //e.g., 6

    for ($column = 1; $column < $highestColumnIndex; $column++) //start from 1 as columns are 0 indexed, but we don’t want to change the first row which we have already set explicitly
    {
        $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column))->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($column) . '2')->getFont()->setBold(true);

    }

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(48);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);

    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);

    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setPath('../images/logoSenagua.png');
    $objDrawing->setHeight(100);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="concesion-' . $tipo . '.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
}


/*fin libreiras para la exportacion y recuperacion de datos */

function muestra_croquis($ficha)
{
    if (tiene_croquis($ficha)) :
        echo '<li><a href="http://186.66.127.99:8085/sisconse/croquis/croquis.php?cod='.$ficha.'&iframe=true&width=600&height=500" rel="prettyPhoto[gallery1]">';
        echo '<img src="../../../../modules/common/images/vercroquis.png" width="80" height="60"/>';
        echo '</a></li>';
    endif;
}

;

function tiene_croquis($ficha)
{
    global $db;
    $query = "SELECT COUNT (*) RESULTADO FROM fic_ficha WHERE fic_id = $ficha AND fic_longitud IS NOT NULL AND fic_latitud IS NOT NULL";
    $coordenadas = $db->getRecord($query);
    $resultado =$coordenadas['resultado'];
    if ( $resultado == '1'):
        return true;
    else:
        return false;
    endif;
}