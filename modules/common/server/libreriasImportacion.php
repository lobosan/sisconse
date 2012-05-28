<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Byron
 * Date: 29/02/12
 * Time: 14:39
 */

/*librerias para la exportacion y recuperacion de datos */


function subirdatos($resul_migracion)
{
    global $db;
    $parametros = array();
    // se realizan las inserciones
    if (isset($resul_migracion["parametros"])):
        $parametros = $resul_migracion["parametros"];
    endif;
    if (count($parametros) == 0):
        if (($resul_migracion["stop"] == 0)and ($resul_migracion["sql"] != "")) :
            $db->execute($resul_migracion["sql"]);
            echo $resul_migracion["ok"];
        else:
            echo $resul_migracion["errores"];
        endif;
    else:
        if (($resul_migracion["stop"] == 0)and ($resul_migracion["sql"] != "")) :
            $db->execute($resul_migracion["sql"], $parametros);
            echo $resul_migracion["ok"];
        else:
            echo $resul_migracion["errores"];
        endif;
    endif;
}






function claveExternaConcesion($nombrefila, $tabla, $parametro, $retorna, $inserta, $rio_telefono, $rio_celular, $rio_email)
{
    global $db;
    //verifica si existe
    $sql = "SELECT COUNT(*) total FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
    $row = $db->getRecord($sql);
    if ($row["total"] != "0"):
        $sql = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    else:
        if (($inserta == "1") and ($nombrefila != '0')):
            $sql = "INSERT INTO fic_concesionario (cor_autor_act_nombre, cor_autor_act_telefono, cor_autor_act_celular, cor_autor_act_mail) VALUES ('$nombrefila', '$rio_telefono', '$rio_celular', '$rio_email')";
            $row1 = $db->execute($sql);
            $sql2 = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
            $row2 = $db->getRecord($sql2);
            return "'" . $row2["resultado"] . "'";
        else :
            return "NULL";
        endif;
    endif;
}


function unificaCoordenadas()
{
    global $db;

    $sql = "update fic_ficha set fic_latitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 55 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_latitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 72 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_latitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 120 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_latitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 135 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_latitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 194 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_latitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 203 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;

	update fic_ficha set fic_longitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 56 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_longitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 73 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_longitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 121 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_longitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 136 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_longitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 195 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	update fic_ficha set fic_longitud = cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '','g'),',', '.') as numeric) from fic_ficha fic inner join fic_valor ind on fic.fic_id=ind.fic_id where ind.ind_id = 204 and val_valor_cadena <> '' and val_valor_cadena <> '0' and fic_ficha.fic_id=ind.fic_id;
	";
    $db->getRecord($sql);
    $sql = "UPDATE fic_ficha b SET fic_caudal_medido =
    (SELECT MAX (val_valor_cadena) FROM fic_valor a WHERE val_valor_cadena <> '0' AND a.ind_id IN (40,44,64,67,75,80,96,104,114) AND a.fic_id = b.fic_id )::NUMERIC;
	";
    $db->getRecord($sql);

    return;
}

/* librerias de recuperacion de datos */

function idHidro($mic_id, $sub_id, $cue_id, $hid_id)
{
    if ($mic_id != null) :
        return $mic_id;
    endif;
    if ($sub_id != null) :
        return $sub_id;
    endif;
    if ($cue_id != null) :
        return $cue_id;
    endif;
    if ($hid_id != null) :
        return $hid_id;
    endif;
    return NULL;
}

function mantieneTamanoMensaje($error_importacion)
{
    $MaxLENGTH = 1000;
    $cadena = substr($error_importacion, 0, strrpos(substr($error_importacion, 0, $MaxLENGTH), " ")) . "...";
    return $cadena;
}

function leeSetup($archivoXML)
{
    $url = $archivoXML;
    $contenido_xml = "";
    if ($d = fopen($url, "r")) {
        while ($aux = fgets($d, 1024)) {
            $contenido_xml .= $aux;
        }
        fclose($d);
    } else {
        echo '{success:false, msg:"No se pudo abrir el XML"}';
    }
    $xmlSetup = simplexml_load_string($contenido_xml);
    return $xmlSetup;
}


function get_tipoDatosCSV($datosCSV)
{
    return isset($datosCSV ['res_receptor']) ? 'legal' : 'hecho';
}

/*librerias comunes */

function quitatildes($cadena)
{
    $patron[0] = "/á/";
    $reemplazo[0] = "a";
    $patron[1] = "/é/";
    $reemplazo[1] = "e";
    $patron[2] = "/í/";
    $reemplazo[2] = "i";
    $patron[3] = "/ó/";
    $reemplazo[3] = "o";
    $patron[4] = "/ú/";
    $reemplazo[4] = "u";

    $patron[0] = "/Á/";
    $reemplazo[0] = "A";
    $patron[1] = "/É/";
    $reemplazo[1] = "E";
    $patron[2] = "/Í/";
    $reemplazo[2] = "I";
    $patron[3] = "/Ó/";
    $reemplazo[3] = "O";
    $patron[4] = "/Ú/";
    $reemplazo[4] = "U";

    $patron[0] = "/ñ/";
    $reemplazo[0] = "n";
    $patron[1] = "/Ñ/";
    $reemplazo[1] = "N";

    $resultado = preg_replace($patron, $reemplazo, $cadena);
    return "'" . $resultado . "'";
}
function validaCadena($cadena, $limpiar)
{
    //remplazamos comillas simples por doble comilla simple
    // Cadena de caracteres:
    // Patrones:
    //patron que permite poner espacios cuado se presenta
    //TNLG.0JOSE0ALEJANDRO0PAZ 010  reemplaza por
    //TNLG. JOSE ALEJANDRO PAZ 010
    if ($cadena == "0") return "''";
    $patron[0] = "/([a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü])0([a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü])/";
    $reemplazo[0] = "$1 $2";
    // reemplaza B'0' por 0
    $patron[1] = "/B'0'/";
    $reemplazo[1] = "0";
    // reemplaza B'1' por 1
    $patron[2] = "/B'1'/";
    $reemplazo[2] = "1";
    // reemplaza ' '' (para que en caso necesario se inserten en las comillas simples
    $patron[3] = "/'/";
    $reemplazo[3] = "''";
    // reemplaza doble espacio por esacio simple
    $patron[4] = "/  /";
    $reemplazo[4] = " ";

    if ($limpiar == '1') {
        $patron[5] = "/^0+/";
        $reemplazo[5] = "";
    }

    $cadena  = ltrim ($cadena);

    $resultado = preg_replace($patron, $reemplazo, $cadena);
    return "'" . $resultado . "'";
}

function validaEntero($cadena)
{
    // Patrones:
    $patron[0] = "/([a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü#-+])0([a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü#-+])/";
    $reemplazo[0] = "$1 $2";
    // reemplaza B'0' por 0
    $patron[1] = "/B'0'/";
    $reemplazo[1] = "0";
    // reemplaza B'1' por 1
    $patron[2] = "/B'1'/";
    $reemplazo[2] = "1";
    // reemplaza ' '' (para que en caso necesario se inserten en las comillas simples
    $patron[3] = "/'/";
    $reemplazo[3] = "''";
    // reemplaza doble espacio por esacio simple
    $patron[4] = "/  /";
    $reemplazo[4] = " ";
    $resultado = preg_replace($patron, $reemplazo, $cadena);
    if (($cadena == " ") or (ord($cadena) == 32) or ($resultado == " ") or ($resultado == "") or ($resultado == "/")) return "NULL";
    return "'" . $resultado . "'";
}

function validaTextInt($cadena)
{
    // quitamos letras o simbolos
    $patron[0] = "/[a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü]/";
    $reemplazo[0] = "";

    // reemplaza doble espacio por esacio simple
    $patron[1] = "/ /";
    $reemplazo[1] = "";

    $resultado = preg_replace($patron, $reemplazo, $cadena);
    if ($cadena == '#N/A')
        $resultado = NULL;

    if ($cadena == NULL)
        $resultado = 0;
    return $resultado;
}

function validaTextNumeric($cadena)
{
    $resultado = $cadena;
    if ($cadena == "")
        $resultado = 0;
    if ($cadena == '#N/A')
        $resultado = NULL;
    return $resultado;
}

function redondear_seis_decimal($valor)
{
    $float_redondeado = round($valor * 1000000) / 1000000;
    return $float_redondeado;
}

function validaTextFloat($cadena)
{
    // quitamos letras o simbolos
    $patron[0] = "/[a-zA-Z:;-_áéíóúÁÉÍÓÚÑñÜü]/";
    $reemplazo[0] = "";

    // eliminamos los espacios
    $patron[1] = "/ /";
    $reemplazo[1] = "";

    $patron[2] = "/,/";
    $reemplazo[2] = ".";

    $resultado = preg_replace($patron, $reemplazo, $cadena);

    $resultadonumber = (float)$resultado;
    $resultadonumber = redondear_seis_decimal($resultadonumber);

    if ($cadena == "")
        $resultadonumber = 0;
    return $resultadonumber;
}

function validaTextDate($cadena)
{
    $resultado = $cadena;
    if ($cadena == "")
        $resultado = 0;
    if ($cadena == '#N/A')
        $resultado = NULL;
    return $resultado;
}

function validaText($cadena)
{
    $resultado = $cadena;
    if ($cadena == NULL)
        $resultado = "";
    return $resultado;
}

function validaAlcantarillado($cadena)
{
    $patron[1] = "/ /";
    $reemplazo[1] = "";

    $patron[2] = "/x/";
    $reemplazo[2] = "1";

    $patron[3] = "/X/";
    $reemplazo[3] = "1";

    $patron[5] = "/SI/";
    $reemplazo[5] = "1";

    $patron[4] = "/[a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü]/";
    $reemplazo[4] = "";

    $resultado = preg_replace($patron, $reemplazo, $cadena);

    if (($cadena == "") || ($resultado == ""))
        $resultado = 0;
    return $resultado;
}

function validaCombo($cadena)
{
    $resultado = $cadena;
    if ($cadena == "")
        $resultado = 0;
    return $resultado;
}

function validaNumeric($cadena)
{

    $resultado = $cadena;
    if ($cadena == "")
        $resultado = 0;
    return $resultado;
}

function validaFloat($cadena)
{

    // reemplaza doble espacio por esacio simple
    $patron[1] = "/,/";
    $reemplazo[1] = ".";

    $patron[2] = "/ /";
    $reemplazo[2] = "";

    $patron[5] = "/[a-zA-ZáéíóúÁÉÍÓÚÑñÜü#]/";
    $reemplazo[5] = "";
    $resultado = preg_replace($patron, $reemplazo, $cadena);

    if (($cadena == "") || ($resultado == "") or ($resultado == "/"))
        $resultado = 0;
    return $resultado;
}


function validaCheck($cadena)
{
    // reemplaza B'0' por 0
    $patron[0] = "/B'0'/";
    $reemplazo[0] = "0";
    // reemplaza B'1' por 1
    $patron[1] = "/B'1'/";
    $reemplazo[1] = "1";
    // reemplaza doble espacio por esacio simple
    $patron[2] = "/ /";
    $reemplazo[2] = "";

    $patron[3] = "/x/";
    $reemplazo[3] = "1";

    $patron[4] = "/X/";
    $reemplazo[4] = "1";

    $patron[5] = "/[a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü]/";
    $reemplazo[5] = "";
    $resultado = preg_replace($patron, $reemplazo, $cadena);

    if (($cadena == "") || ($resultado == ""))
        $resultado = 0;
    return $resultado;
}


function verificaUsosdeAgua($indicador, $valor)
{
    global $usoDeAgua;
    $usosopciones = array(28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38);
    if (in_array($indicador, $usosopciones)):
        if ($valor == 1):
            $usoDeAgua = true;
        endif;
    endif;
}

function limpiaCeros($cadena)
{
    if ($cadena == '0') $cadena = '';
    return $cadena;
}


function  recuperausoCSV($uso, $descripcion)
{
    global $db;
    if ($descripcion != ""):
        $sql = "SELECT
			par_descripcion resultado
			FROM
			fic_parametros
			WHERE
			par_grupo = '$uso' AND par_id = '$descripcion'
			";
        $row = $db->getRecord($sql);
        return $row["resultado"];
    else:
        return '0';
    endif;

}

function  recuperauso($uso, $descripcion)
{
    global $db;
    $sql = "SELECT
			par_id resultado
			FROM
			fic_parametros
			WHERE
			par_grupo = '$uso' AND (
			par_descripcion = '$descripcion'
			or par_alternativas = '$descripcion')
			";
    $row = $db->getRecord($sql);
    return $descripcion;
    return $row["resultado"];
}

function validaDateCSV($cadena)
{
    if ($cadena != ""):
        return "'" . $cadena . "'";
    else:
        return "NULL";
    endif;
}

function validaDate($cadena)
{
    if (((string)$cadena == "") or ($cadena == 0))
        return "NULL";
    $dateValue = PHPExcel_Shared_Date::ExcelToPHP($cadena);
    $resultado = date('d-m-Y', $dateValue);
    return "'" . $resultado . "'";
}

function validaRadioCSV($cadena, $radiovar)
{
    global $db;
    if ($cadena != ""):
        $sql = "select count (*) resultado from fic_parametros where par_id = $cadena and ind_id = $radiovar";
        $row = $db->getRecord($sql);
        return $row["resultado"];
    else:
        return '';
    endif;
}

function validaRadio($cadena)
{
    $patron[1] = "/ /";
    $reemplazo[1] = "";

    $patron[2] = "/x/";
    $reemplazo[2] = "1";

    $patron[3] = "/X/";
    $reemplazo[3] = "1";

    $patron[4] = "/[a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü]/";
    $reemplazo[4] = "";
    $resultado = preg_replace($patron, $reemplazo, $cadena);

    if (($cadena == "") || ($resultado == ""))
        $resultado = 0;
    return $resultado;
}

function buscarExisteFicha($tipo, $formulario, $parroquia, $proceso)
{
    /*devuelve true en caso de que la ficha exista
    * falso en caso de que la ficha no exista
     * parametros
     * $formulario valor alfanumerico con numero de formulario y una letra secuencial A B C ..
     * Sprovincia codigo (dpa) de parroquia
     * $proceso valor numerico del id del proceso.
    */

    global $db;
    global $faltante;

    $faltante = "";
    /*si no esta definido */
    if ($formulario == NULL) $faltante .= ", formulario faltante";
    if ($parroquia == "NULL") $faltante .= ", dpa faltante o incorrecto.";

    if (($formulario == NULL) or ($parroquia == "NULL")) return -1;


    if ($tipo == 'legal'):
        if ($proceso == NULL) $faltante .= " proceso faltante";
        if ($proceso == NULL) return -1;
        $sql = "SELECT COUNT (*) AS resultado FROM fic_ficha WHERE fic_formulario = '$formulario' AND dpa_id = $parroquia AND fic_proceso = $proceso ;";
        $row = $db->getRecord($sql);
        return $row["resultado"];
    else:
        $sql = "SELECT COUNT (*) AS resultado FROM fic_ficha WHERE fic_formulario = '$formulario' AND dpa_id = $parroquia AND fic_proceso ISNULL;";
        $row = $db->getRecord($sql);
        return $row["resultado"];
    endif;
}

function leearchivoCSV($archivo)
{
    global $datosMigrarCSV;
    $fp = fopen('uploads/' . $archivo, "r");
    $resultado = array();
    while ($data = fgetcsv($fp, 0, "|")) {
        for ($i = 0; $i < count($data); $i++) {
            $data[$i] = str_replace("+", " ", $data[$i]);
            $pieces = explode(":", $data[$i]);
            if (count($pieces) > 1) :
                if (isset($pieces[1])) :
                    $resultado [$pieces[0]] = $pieces[1];
                else:
                    $resultado [$pieces[0]] = "";
                endif;
            endif;
        }
    }
    fclose($fp);
    $datosMigrarCSV = $resultado;
}

function leearchivoExcel($archivo)
{
    global $datosMigrarExcel;
    if (!file_exists('uploads/' . $archivo)) {
        exit("Archivo no encontrado.\n");
    }
    //funcion para la carga del archivo de excel
    $datosMigrarExcel = PHPExcel_IOFactory::load('uploads/' . $archivo);
}
function validaCadenaDetalleCSV($cadena, $uso, $tipodato, $variante, $radiovar)
{
    //remplazamos comillas simples por doble comilla simple
    // Cadena de caracteres:
    // Patrones:
    //patron que permite poner espacios cuado se presenta
    //TNLG.0JOSE0ALEJANDRO0PAZ 010  reemplaza por
    //TNLG. JOSE ALEJANDRO PAZ 010
    $patron[0] = "/([a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü])0([a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü])/";
    $reemplazo[0] = "$1 $2";
    // reemplaza B'0' por 0
    $patron[1] = "/B'0'/";
    $reemplazo[1] = "0";
    // reemplaza B'1' por 1
    $patron[2] = "/B'1'/";
    $reemplazo[2] = "1";
    // reemplaza ' '' (para que en caso necesario se inserten en las comillas simples
    $patron[3] = "/'/";
    $reemplazo[3] = "''";
    // reemplaza doble espacio por esacio simple
    $patron[4] = "/  /";
    $reemplazo[4] = " ";
    $cadena = preg_replace($patron, $reemplazo, $cadena);
    switch ($uso):
        case "check" :
            $resultado = validaCheck($cadena);
            break;
        case "radio" :
            $resultado = validaRadioCSV($cadena, $radiovar);
            break;

        case "alcantarillado" :
            $resultado = validaAlcantarillado($cadena);
            break;

        case "combo" :
            switch ($variante):
                case "0" :
                    if ($cadena == "x" or $cadena == "X" or $cadena == "SI" or $cadena == "si" or $cadena == "Si" or $cadena == "1"):
                        $resultado = "1";
                    else:
                        $resultado = "0";
                    endif;
                    break;
                case "existencia" :

                    switch ($cadena):
                        case "1":
                            $resultado = "1";
                            break;
                        default:
                            $resultado = "0";
                            break;
                    endswitch;
                    break;
                case "Usos Industriales" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Explotacion Minera":
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Cobertura Vegetal" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Tipo Almacenamiento" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Tratamiento" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Forma Abastecimiento" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Tipo Descarga" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Tipo Almacenamiento" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Tratamiento Descarga" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Tipo Receptor" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
                case "Tipo Residuos Solidos" :
                    $resultado = recuperausoCSV($variante, $cadena);
                    break;
            endswitch;
            break;
        case "text" :
            switch ($tipodato):
                case "int" :
                    $resultado = validaTextInt($cadena);
                    break;
                case "numeric" :
                    $resultado = validaTextNumeric($cadena);
                    break;
                case "float":
                    $resultado = validaTextFloat($cadena);
                    break;
                case "date" :
                    $resultado = validaTextDate($cadena);
                    break;
                case "varchar" :
                    if ($cadena == "0"):
                        $cadena = "";
                    endif;
                    $resultado = validaText($cadena);
                    break;
            endswitch;
            break;
    endswitch;
    return "'" . $resultado . "'";
}

function validaCadenaDetalle($cadena, $uso, $tipodato, $variante)
{
    //remplazamos comillas simples por doble comilla simple
    // Cadena de caracteres:
    // Patrones:
    //patron que permite poner espacios cuado se presenta
    //TNLG.0JOSE0ALEJANDRO0PAZ 010  reemplaza por
    //TNLG. JOSE ALEJANDRO PAZ 010
    $patron[0] = "/([a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü])0([a-zA-Z.:,áéíóúÁÉÍÓÚÑñÜü])/";
    $reemplazo[0] = "$1 $2";
    // reemplaza B'0' por 0
    $patron[1] = "/B'0'/";
    $reemplazo[1] = "0";
    // reemplaza B'1' por 1
    $patron[2] = "/B'1'/";
    $reemplazo[2] = "1";
    // reemplaza ' '' (para que en caso necesario se inserten en las comillas simples
    $patron[3] = "/'/";
    $reemplazo[3] = "''";
    // reemplaza doble espacio por esacio simple
    $patron[4] = "/  /";
    $reemplazo[4] = " ";
    $cadena = preg_replace($patron, $reemplazo, $cadena);
    switch ($uso):
        case "check" :
            $resultado = validaCheck($cadena);
            break;
        case "radio" :
            $resultado = validaRadio($cadena);
            break;

        case "alcantarillado" :
            $resultado = validaAlcantarillado($cadena);
            break;

        case "combo" :
            switch ($variante):
                case "0" :
                    if ($cadena == "x" or $cadena == "X" or $cadena == "SI" or $cadena == "si" or $cadena == "Si" or $cadena == "1"):
                        $resultado = "1";
                    else:
                        $resultado = "0";
                    endif;
                    break;
                case "existencia" :

                    switch ($cadena):
                        case "X":
                            $resultado = "1";
                            break;
                        default:
                            $resultado = "0";
                            break;
                    endswitch;
                    break;
                case "Usos Industriales" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Explotacion Minera":
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Cobertura Vegetal" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Tipo Almacenamiento" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Tratamiento" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Forma Abastecimiento" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Tipo Descarga" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Tipo Almacenamiento" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Tratamiento Descarga" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Tipo Receptor" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
                case "Tipo Residuos Solidos" :
                    $resultado = recuperauso($variante, $cadena);
                    break;
            endswitch;
            break;
        case "text" :
            switch ($tipodato):
                case "int" :
                    $resultado = validaTextInt($cadena);
                    break;
                case "numeric" :
                    $resultado = validaTextNumeric($cadena);
                    break;
                case "float":
                    $resultado = validaTextFloat($cadena);
                    break;
                case "date" :
                    $resultado = validaTextDate($cadena);
                    break;
                case "varchar" :
                    if ($cadena == "0"):
                        $cadena = "";
                    endif;
                    $resultado = validaText($cadena);
                    break;
            endswitch;
            break;
    endswitch;
    return "'" . $resultado . "'";
}

function migrarFichasExcel($archivo, $tipo, $setupXML)
{
    global $xmlSetup;
    global $datosMigrarExcel;
    global $error_importacion;
    global $faltante;

    $cabeceratotal = "";
    $cuerpototal = "";
    $resul_migracion = array("sql" => "", "ok" => "", "errores" => "", "stop" => 0, "warning" => "", "warningclave" => "", "warninghidro" => "", "warningdpa" => "");

    $xmlSetup = leeSetup($setupXML);
    leearchivoExcel($archivo);

    $primerRegistro = (int)$xmlSetup->config[0]->columnainicio;
    $ultimoRegistro = (int)$xmlSetup->config[0]->columnafin;
    $nombrehoja = $xmlSetup->config[0]->nombrehoja;
    $nombrehoja2 = $xmlSetup->config[0]->nombrehoja2;
    $nombrehoja3 = $xmlSetup->config[0]->nombrehoja3;

    //verificar si existe la hoja para dar mensaje de error
    $testhoja = $datosMigrarExcel->getSheetByName($nombrehoja);
    if (count($testhoja) == 0):
        $testhoja = $datosMigrarExcel->getSheetByName($nombrehoja2);
        if (count($testhoja) == 0):
            $testhoja = $datosMigrarExcel->getSheetByName($nombrehoja3);
            if (count($testhoja) == 0):
                $error_importacion = "No existe la hoja <br>" . $nombrehoja . "<br>Revise que este nombre este en el archivo EXCEL.";
                $resul_migracion["errores"] = '{success:false, msg:"' . $error_importacion . '"}';
                $resul_migracion["stop"] = 1;
                return $resul_migracion;
            else:
                $nombrehoja = $nombrehoja3;
            endif;
        else:
            $nombrehoja = $nombrehoja2;
        endif;
    endif;
    // fin 	verificar si existe la hoja para dar mensaje de error

    $testcolumna = (string)$xmlSetup->config[0]->nombrecolumna;
    $testcmpo = (string)$xmlSetup->config[0]->nombrecampo;
    $compruebacolumna = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($testcmpo)->getValue();
    if ($compruebacolumna != $testcolumna):
        $error_importacion = "Número de columnas no válido,<br> no se puede cargar la información.";
        $resul_migracion["errores"] = '{success:false, msg:"' . $error_importacion . '"}';
        $resul_migracion["stop"] = 1;
        return $resul_migracion;
    endif;
    // fin verificar si no se han cambiado los campos

    $tabla = $xmlSetup->config[0]->tabla;
    $tabladetalle = $xmlSetup->config[0]->tabladetalle;
    //generamos un string con los nombres de los campos
    $nombrescampos = "fic_id ";
    $nombrescamposdetalle = "";
    $valoresinsert = "";

    $fic_id = lastInsertId($tabla, "fic_id");
    //nombres campos de cabecera
    for ($j = 0; $j < count($xmlSetup->parametro); $j++) {
        //validamos cada dato preveio a generar el query
        if ($xmlSetup->parametro[$j]->importar != 0):
            $nombrescampos .= ", " . $xmlSetup->parametro[$j]->campo;
        endif;
    }

    // nombres campos para el detalle
    for ($j = 0; $j < count($xmlSetup->camposdetalle); $j++) {
        //validamos cada dato preveio a generar el query
        if ($xmlSetup->camposdetalle[$j]->importar != 0):
            if ($j != 1)
                $nombrescamposdetalle .= ", ";
            $nombrescamposdetalle .= $xmlSetup->camposdetalle[$j]->nombre;
        endif;
    }
    // generamos un string con los valores a insertar
    for ($i = $primerRegistro; $i <= $ultimoRegistro; $i++) {
        //verifico
        //insercion cabecera fic_ficha
        $valorescampos = "( " . ($fic_id + $i - $primerRegistro + 1) . " ";
        //validamos cada dato preveio a generar el query
        for ($j = 0; $j < count($xmlSetup->parametro); $j++) {
            //verificamos si el campo se importa o no
            if ($xmlSetup->parametro[$j]->importar != 0
            ):
                //verificamos si es un campo simple o uno externo
                if ($xmlSetup->parametro[$j]->tablaRelacionada == ""):
                    $valorescampos .= ",  ";
                    $nombrefila = (string)$xmlSetup->parametro[$j]->fila;
                    $tipodato = (string)$xmlSetup->parametro[$j]->tipodato;
                    switch ($tipodato):
                        case "varchar":
                            $valorescampos .= validaCadena($datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila . $i)->getValue(), $tipodato = (string)$xmlSetup->parametro[$j]->limpiar);
                            break;
                        case "int":
                            $valorescampos .= validaEntero($datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila . $i)->getValue());
                            break;
                        case "date":
                            $valorescampos .= validaDate($datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila . $i)->getValue());
                            break;
                        case "numeric":
                            $valorescampos .= validaNumeric($datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila . $i)->getValue());
                            break;
                        case "float":
                            $valorescampos .= validaFloat($datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila . $i)->getValue());
                            break;
                        case "constante":
                            $constante = $xmlSetup->parametro[$j]->default;
                            $valorescampos .= "'" . $constante . "'";
                            break;
                    endswitch;
                else:
                    $nombrefila = (string)$xmlSetup->parametro[$j]->fila;
                    $dato = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila . $i)->getValue();
                    $parametro = $xmlSetup->parametro[$j]->parametro;
                    $retorna = $xmlSetup->parametro[$j]->retorna;
                    $inserta = $xmlSetup->parametro[$j]->insertar;
                    $tablaRelacionada = $xmlSetup->parametro[$j]->tablaRelacionada;
                    $nombrefila2 = (string )$xmlSetup->parametro[$j]->fila2;
                    $nombrefila3 = (string )$xmlSetup->parametro[$j]->fila3;
                    $nombrefila4 = (string )$xmlSetup->parametro[$j]->fila4;
                    switch ($tablaRelacionada):
                        case "fic_hidrograficas":
                            $datoSistema = limpiaCeros($dato);
                            $datoCuenca = limpiaCeros($datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila2 . $i)->getValue());
                            $datoSubcuenca = limpiaCeros($datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila3 . $i)->getValue());
                            $claveMicrocuenca = limpiaCeros($datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila4 . $i)->getValue());
                            $claveexterna = claveExternahidroExcel($datoSistema, $datoCuenca, $datoSubcuenca, $claveMicrocuenca, $tablaRelacionada, $parametro, $retorna);
                            if ($claveexterna == -1):
                                $resul_migracion["warninghidro"] .= "Fila: " . $i . "</br>";
                                $resul_migracion["stop"] = 1;
                                $claveexterna = 'NULL';
                            endif;
                            break;
                        case "fic_dpa":
                            $datoprovincia = $dato;
                            $provinciadefault = (string)$xmlSetup->parametro[$j]->default;
                            $datocanton = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila2 . $i)->getValue();
                            $datoparroquia = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila3 . $i)->getValue();
                            $claveexterna = claveExternadpa($datoprovincia, $datocanton, $datoparroquia, $tablaRelacionada, $parametro, $retorna, $provinciadefault);
                            $clavedpa = $claveexterna;
                            if ($clavedpa == -1):
                                $resul_migracion["warningdpa"] .= "Fila: " . $i . "</br>";
                                $resul_migracion["stop"] = 1;
                                $clavedpa = 'NULL';
                            endif;

                            break;
                        case "fic_concesionario":
                            if ($nombrefila2 != '')
                                $rio_telefono = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila2 . $i)->getValue();
                            else
                                $rio_telefono = '';
                            if ($nombrefila3 != '')
                                $rio_celular = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila3 . $i)->getValue();
                            else
                                $rio_celular = '';
                            if ($nombrefila4 != '')
                                $rio_email = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila4 . $i)->getValue();
                            else
                                $rio_email = '';
                            $claveexterna = claveExternaConcesion($dato, $tablaRelacionada, $parametro, $retorna, $inserta, $rio_telefono, $rio_celular, $rio_email);
                            break;
                        default:
                            $claveexterna = claveExterna($dato, $tablaRelacionada, $parametro, $retorna, $inserta);
                    endswitch;
                    if ($j != 0)
                        $valorescampos .= ",  ";
                    $valorescampos .= $claveexterna;
                endif;
            endif;
        }

        $valorescampos .= " )";
        $valoresinsert .= $valorescampos;

        //insercion de la cabecera si no existe el registro entonces se puede insertar uno nuevo
        $columnaformulario = (string)$xmlSetup->parametro[6]->fila;
        $formulario = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($columnaformulario . $i)->getValue();
        if ($tipo == "legal") :
            $columnaprocesos = (string)$xmlSetup->parametro[0]->fila;
            $proceso = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($columnaprocesos . $i)->getValue();
        else:
            $proceso = "";
        endif;
        /*validacion de la existencia de los parametros */
        $siExisteFicha = buscarExisteFicha($tipo, $formulario, $clavedpa, $proceso);
        if ($siExisteFicha == 0) :
            $sqlcabecera = "INSERT INTO " . $tabla . " ( " . $nombrescampos . " ) VALUES " . ' ' . $valoresinsert . ';';
            $cabeceratotal .= $sqlcabecera;
        else:
            if ($siExisteFicha != -1):
                if ($tipo == 'legal'):
                    $resul_migracion["warning"] .= "Fila: " . $i . ", ficha " . $formulario . ", proceso:" . $proceso . "</br>";
                else:
                    $resul_migracion["warning"] .= "Fila: " . $i . ", ficha " . $formulario . "</br>";
                endif;
                $resul_migracion["stop"] = 1;
            else:
                $resul_migracion["warningclave"] .= "Fila: " . $i . ", " . $faltante . "</br>";
                $resul_migracion["stop"] = 1;
            endif;
        endif;
        $valoresinsert = "";
        //fin insercion cabecera fic_ficha

        //insercion detalle fic_valor
        $sql = "";
        $fic_id = lastInsertId($tabla, "fic_id");
        if ($siExisteFicha == 0) :
            $sql = "INSERT INTO " . $tabladetalle . " ( " . $nombrescamposdetalle . " ) VALUES  ";
            for ($j = 0; $j < count($xmlSetup->parametro_detalle); $j++) {
                if ($xmlSetup->parametro_detalle[$j]->importar != 0):
                    $valorescampos = "( '" . ($fic_id + $i - $primerRegistro + 1) . "', '" . $xmlSetup->parametro_detalle[$j]->id_indicador . "', ";
                    $valoresinsertdetalle = "";
                    $nombrefila = $xmlSetup->parametro_detalle[$j]->fila;
                    $usoindicador = $xmlSetup->parametro_detalle[$j]->uso;
                    $tipodato = $xmlSetup->parametro_detalle[$j]->tipodato;
                    $variante = $xmlSetup->parametro_detalle[$j]->combo_cat;
                    $datoCargar = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell($nombrefila . $i)->getValue();
                    $datovalidado = validaCadenaDetalle($datoCargar, $usoindicador, $tipodato, $variante);
                    $valorescampos .= $datovalidado;
                    $valorescampos .= " )";
                    $valoresinsertdetalle .= $valorescampos;
                    /*
                     * para el caso de valores nulos, valores con 0 se omite la inserción
                    */
                    $seguir = true;
                    if ($datovalidado == "'0'")
                        $seguir = false;
                    if ($datovalidado == "''")
                        $seguir = false;
                    if ($seguir):
                        $sql .= $valoresinsertdetalle . ',';
                    endif;
                    $valoresinsert = "";
                endif;
            }
        endif;
        /*para el caso de el ultimo contenido a insertar le cambiamos la , por un ;*/
        if ($sql != ""):
            $sql = substr_replace($sql, ';', -1, 1);
            $cuerpototal .= $sql;
        endif;
        //fin insercion detalle fic_valor
        //verifico que exista datos para la siguiente fila
        $reg = $i + 1;
        $siguientevalor = $datosMigrarExcel->getSheetByName($nombrehoja)->getCell('B' . $reg)->getValue();
        if ($siguientevalor == "") :
            $i = $ultimoRegistro;
        endif;
    }
    //copiamos la coordenada de uso de la ficha  en fic_ficha

    //Mensaje de retorno
    $resul_migracion["sql"] = $cabeceratotal . $cuerpototal;
    if ($resul_migracion["warninghidro"] != ""):
        $error_importacion .= "La división hidrográfica proporcionada no se encuentra en la base de datos, revise<br>" . $resul_migracion["warninghidro"] . "<br>";
    endif;
    if ($resul_migracion["warningdpa"] != ""):
        $error_importacion .= "La DPA proporcionada no se encuentra en la base de datos, revise<br>" . $resul_migracion["warningdpa"] . "<br>";
    endif;
    if ($resul_migracion["warning"] != ""):
        $error_importacion .= "Los siguientes registros ya existen:<br>" . $resul_migracion["warning"];
    endif;
    if ($resul_migracion["warningclave"] != ""):
        $error_importacion .= "Registros clave incompleta:  <br>" . $resul_migracion["warningclave"];
    endif;

    $error_importacion = mantieneTamanoMensaje($error_importacion);

    $resul_migracion["errores"] = '{success:false, msg:"' . $error_importacion . '"}';
    $resul_migracion["ok"] = '{success:true, msg:"El archivo ' . $archivo . ' ha sido importado, ( ' . ($reg - $primerRegistro) . ' registros)"}';
    return $resul_migracion;
}

// Migracion funciones

function claveExternadpa($datoprovincia, $datocanton, $datoparroquia, $tabla, $parametro, $retorna, $provinciadefault)
{
    global $db;

    if ($datoprovincia == '0')
        $datoprovincia = $provinciadefault;

    //verifica si existe
    $sql = "SELECT COUNT(*) total FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoparroquia', ' ', '' ,'g'))) AND
			substr((fic_dpa.dpa_id)::text, 1, 2) = (SELECT provincia FROM fic_provincia WHERE upper(sinacentos (regexp_replace(dpa_descripcion, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoprovincia', ' ', '' ,'g'))) ) AND
			substr((fic_dpa.dpa_id)::text, 1, 4) = (SELECT canton FROM fic_canton WHERE upper(sinacentos (regexp_replace(dpa_descripcion, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datocanton', ' ', '' ,'g')))) AND dpa_grupo = 'Parroquias';";
    $row = $db->getRecord($sql);

    // si no encuentra pero existen todos los datos entonces devuelve error
    if (($datoprovincia != '') and ($datocanton != '') and ($datoparroquia != '')  and ($row["total"] == "0")):
        return -1;
    endif;

    if (($row["total"] != "0") and (is_string($datoparroquia))):
        $sql = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoparroquia', ' ', '' ,'g'))) AND
			substr((fic_dpa.dpa_id)::text, 1, 2) = (SELECT provincia FROM fic_provincia WHERE upper(sinacentos (regexp_replace(dpa_descripcion, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoprovincia', ' ', '' ,'g'))) ) AND
			substr((fic_dpa.dpa_id)::text, 1, 4) = (SELECT canton FROM fic_canton WHERE upper(sinacentos (regexp_replace(dpa_descripcion, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datocanton', ' ', '' ,'g')))) AND dpa_grupo = 'Parroquias';";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    endif;

    //verifica si existe
    $sql = "SELECT COUNT(*) total FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datocanton', ' ', '' ,'g'))) AND
			substr((fic_dpa.dpa_id)::text, 1, 2) = (SELECT provincia FROM fic_provincia WHERE upper(sinacentos (regexp_replace(dpa_descripcion, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoprovincia', ' ', '' ,'g'))) ) AND dpa_grupo = 'Cantones';";
    $row = $db->getRecord($sql);
    if (($row["total"] != "0") and (is_string($datocanton))):
        $sql = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datocanton', ' ', '' ,'g'))) AND
			substr((fic_dpa.dpa_id)::text, 1, 2) = (SELECT provincia FROM fic_provincia WHERE upper(sinacentos (regexp_replace(dpa_descripcion, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoprovincia', ' ', '' ,'g'))) ) AND dpa_grupo = 'Cantones';";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    endif;
    //verifica si existe
    $sql = "SELECT COUNT(*) total FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoprovincia', ' ', '' ,'g'))) AND dpa_grupo = 'Provincias';";
    $row = $db->getRecord($sql);
    if (($row["total"] != "0") and (is_string($datoprovincia))):
        $sql = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoprovincia', ' ', '' ,'g'))) AND dpa_grupo = 'Provincias';";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    endif;

    return "NULL";
}

function claveExternahidroExcel($datoSistema, $datoCuenca, $datoSubcuenca, $claveMicrocuenca, $tabla, $parametro, $retorna)
{
    global $db;


    //verifica si existe microcuenca para devolver clave de microcuenca
    $sql = "SELECT COUNT (*) total  FROM $tabla
				WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$claveMicrocuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'MICROCUENCAS' AND
				substr((hid_id)::text, 1, 2) = (SELECT hid_id FROM fic_hidrograficas WHERE sinrio(upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g')))) = sinrio(upper (sinacentos (regexp_replace('$datoSistema', ' ', '' ,'g')))) AND upper (hid_grupo) = 'SISTEMAS') AND
				substr((hid_id)::text, 1, 4) = (SELECT hid_id FROM fic_hidrograficas WHERE upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoCuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'CUENCAS') AND
				substr((hid_id)::text, 1, 6) = (SELECT hid_id FROM fic_hidrograficas WHERE upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoSubcuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'SUBCUENCAS');";
    $row = $db->getRecord($sql);

    // si no encuentra pero existen todos los datos entonces devuelve error
    if (($datoSistema != '') and ($datoCuenca != '') and ($datoSubcuenca != '') and ($claveMicrocuenca != '') and ($row["total"] == "0")):
        return -1;

    endif;
    //si existe microcuenca devuelde el codigo
    if (($row["total"] != "0") and (is_string($claveMicrocuenca))):
        $sql = "SELECT $retorna as resultado FROM $tabla
				WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$claveMicrocuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'MICROCUENCAS' AND
				substr((hid_id)::text, 1, 2) = (SELECT hid_id FROM fic_hidrograficas WHERE sinrio(upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g')))) = sinrio(upper (sinacentos (regexp_replace('$datoSistema', ' ', '' ,'g')))) AND upper (hid_grupo) = 'SISTEMAS') AND
				substr((hid_id)::text, 1, 4) = (SELECT hid_id FROM fic_hidrograficas WHERE upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoCuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'CUENCAS') AND
				substr((hid_id)::text, 1, 6) = (SELECT hid_id FROM fic_hidrograficas WHERE upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoSubcuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'SUBCUENCAS');";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    endif;

    //verifica si existe microcuenca para devolver clave de subcuenca
    $sql = "SELECT COUNT (*) total  FROM $tabla
				WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoSubcuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'SUBCUENCAS' AND
				substr((hid_id)::text, 1, 2) = (SELECT hid_id FROM fic_hidrograficas WHERE sinrio(upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g')))) = sinrio(upper (sinacentos (regexp_replace('$datoSistema', ' ', '' ,'g')))) AND upper (hid_grupo) = 'SISTEMAS') AND
				substr((hid_id)::text, 1, 4) = (SELECT hid_id FROM fic_hidrograficas WHERE upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoCuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'CUENCAS') ;";
    $row = $db->getRecord($sql);

    if (($row["total"] != "0") and (is_string($datoSubcuenca))):
        $sql = "SELECT $retorna as resultado FROM $tabla
				WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoSubcuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'SUBCUENCAS' AND
				substr((hid_id)::text, 1, 2) = (SELECT hid_id FROM fic_hidrograficas WHERE sinrio(upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g')))) = sinrio(upper (sinacentos (regexp_replace('$datoSistema', ' ', '' ,'g')))) AND upper (hid_grupo) = 'SISTEMAS') AND
				substr((hid_id)::text, 1, 4) = (SELECT hid_id FROM fic_hidrograficas WHERE upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoCuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'CUENCAS') ;";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    endif;

    //verifica si existe microcuenca para devolver clave de microcuenca
    $sql = "SELECT COUNT (*) total  FROM $tabla
				WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoCuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'CUENCAS' AND
				substr((hid_id)::text, 1, 2) = (SELECT hid_id FROM fic_hidrograficas WHERE sinrio(upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g')))) = sinrio(upper (sinacentos (regexp_replace('$datoSistema', ' ', '' ,'g')))) AND upper (hid_grupo) = 'SISTEMAS') ;";
    $row = $db->getRecord($sql);
    //si existe microcuenca devuelde el codigo
    if (($row["total"] != "0") and (is_string($datoCuenca))):
        $sql = "SELECT $retorna as resultado FROM $tabla
				WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoCuenca', ' ', '' ,'g'))) AND upper (hid_grupo) = 'CUENCAS' AND
				substr((hid_id)::text, 1, 2) = (SELECT hid_id FROM fic_hidrograficas WHERE sinrio(upper(sinacentos (regexp_replace(hid_nombre, ' ', '' ,'g')))) = sinrio(upper (sinacentos (regexp_replace('$datoSistema', ' ', '' ,'g')))) AND upper (hid_grupo) = 'SISTEMAS');";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    endif;

    //verifica si existe microcuenca para devolver clave de microcuenca
    $sql = "SELECT COUNT (*) total  FROM $tabla
				WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoSistema', ' ', '' ,'g'))) AND upper (hid_grupo) = 'SISTEMAS' ;";
    $row = $db->getRecord($sql);
    //si existe microcuenca devuelde el codigo
    if (($row["total"] != "0") and (is_string($datoSistema))):
        $sql = "SELECT $retorna as resultado FROM $tabla
				WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$datoSistema', ' ', '' ,'g'))) AND upper (hid_grupo) = 'SISTEMAS';";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    endif;

    return "NULL";
}
/*funcinon importacion csv*/
/*inicio validaciones de unicidad de usuario */
function validacionFicha($tipo, $formulario, $dpa, $proceso)
{
    /**
     * tipo (legal, hecho)
     * $formulario - número de ficha que registra la concesion
     * $dpa - codigo dpa de la parroquia , canton o provincia a la que pertenezca en ese orden de precedencia
     * $proceso - numero de proceso para el caso de tipo legal
     * retorna true si el usuario no existe / false si el usuario ya existe
     */
    /*validacion de la existencia de los parametros caso contrario devuelve error*/
    if (validaParamUsuario($tipo, $formulario, $dpa, $proceso)) :
        if ($tipo == 'legal'):
            return existeFichaLegal($formulario, $dpa, $proceso);
        endif;
        if ($tipo == 'hecho'):
            return existeFichaHecho($formulario, $dpa);
        endif;
    else:
        return 'error';
    endif;
}

function validaParamUsuario($tipo, $formulario, $dpa, $proceso)
{
    /*validamos que los parámetros ficha dpa proceso sean distintos de 0 o null o '' */
    if (($formulario == null) or ($formulario == '')) return false;
    if (($dpa == null) or ($dpa == '')) return false;
    if ($tipo == 'legal'):
        if (($proceso == null) or ($proceso == 0)) return false;
    endif;
    return true;
}

function existeFichaLegal($formulario, $dpa, $proceso)
{
    global $db;
    //verifica si existe
    $sql = "SELECT COUNT (*) resultado FROM fic_ficha WHERE fic_formulario = '$formulario' AND dpa_id = $dpa AND fic_proceso = $proceso ;";
    $row = $db->getRecord($sql);
    if ((int)$row ["resultado"] >= 1):
        return false;
    else:
        return true;
    endif;
}

function existeFichaHecho($formulario, $dpa)
{
    global $db;
    //verifica si existe
    $sql = "SELECT COUNT (*) resultado FROM fic_ficha WHERE fic_formulario = '$formulario' AND dpa_id = $dpa AND fic_proceso ISNULL;";
    $row = $db->getRecord($sql);
    if ((int)$row ["resultado"] == 1):
        return false;
    else:
        return true;
    endif;
}

/*fin validaciones de unicidad de usuario */

function seleccionaDPAclave($datoprovincia, $datocanton, $datoparroquia)
{
    //verifica si existe
    if ($datoparroquia != ''):
        return "'" . $datoparroquia . "'";
    elseif ($datocanton != ''):
        return "'" . $datocanton . "'";
    elseif ($datoprovincia != ''):
        return "'" . $datoprovincia . "'";
    else :
        return '';
    endif;
}

function seleccionaHidClave($sistema, $cuenca, $subcuenca, $microcuenca)
{
    //verifica si existe
    if ($microcuenca != ''):
        return "'" . $microcuenca . "'";
    elseif ($subcuenca != ''):
        return "'" . $subcuenca . "'";
    elseif ($cuenca != ''):
        return "'" . $cuenca . "'";
    elseif ($sistema != ''):
        return "'" . $sistema . "'";
    else :
        return '';
    endif;
}

function esFichaNuevaLegal($ficha)
{
    global $db;
    //verifica si existe
    $sql = "SELECT dpa_id, fic_proceso, fic_formulario FROM fic_ficha WHERE fic_id = ?;";
    $row = $db->getRecord($sql, $ficha);
    if (($row ["dpa_id"] == null) and ($row ["fic_proceso"] == null) and ($row ["fic_formulario"] == null)):
        return true;
    else:
        return false;
    endif;
}

function esFichaNuevaUso($ficha)
{
    global $db;
    //verifica si existe
    $sql = "SELECT dpa_id, fic_formulario FROM fic_ficha WHERE fic_id = ? AND fic_proceso ISNULL;";
    $row = $db->getRecord($sql, $ficha);
    if (($row ["dpa_id"] == null) and ($row ["fic_formulario"] == null)):
        return true;
    else:
        return false;
    endif;
}

/*inicio validaciones de unicidad de usuario */
function validacionFichaSelf($tipo, $formulario, $dpa, $proceso, $ficha)
{
    /*validacion de la existencia de los parametros caso contrario devuelve error*/
    if (validaParamUsuario($tipo, $formulario, $dpa, $proceso)) :
        if ($tipo == 'legal'):
            return esmismaFichaLegal($formulario, $dpa, $proceso, $ficha);
        endif;
        if ($tipo == 'hecho'):
            return esmismaFichaHecho($formulario, $dpa, $ficha);
        endif;
    else:
        return 'error';
    endif;
}

function esmismaFichaLegal($formulario, $dpa, $proceso, $ficha)
{
    $fichagrabada = recuperaFichaLegal($formulario, $dpa, $proceso);
    // comparamos $fichagrabada con $ficha
    if ($fichagrabada != false):
        if ($fichagrabada == $ficha):
            return true;
        else:
            return false;
        endif;
    else:
        return false;
    endif;
}

function recuperaFichaLegal($formulario, $dpa, $proceso)
{
    global $db;
    //verifica si existe
    $sql = "SELECT COUNT (*) resultado FROM fic_ficha WHERE fic_formulario = '$formulario' AND dpa_id = $dpa AND fic_proceso = $proceso ;";
    $row = $db->getRecord($sql);
    if ((int)$row ["resultado"] == 0):
        return false;
    else:
        $sql = "SELECT fic_id resultado FROM fic_ficha WHERE fic_formulario = '$formulario' AND dpa_id = $dpa AND fic_proceso = $proceso ;";
        $row = $db->getRecord($sql);
        return $row ["resultado"];
    endif;
}

function esmismaFichaHecho($formulario, $dpa, $ficha)
{
    $fichagrabada = recuperaFichaHecho($formulario, $dpa);
    // comparamos $fichagrabada con $ficha
    if ($fichagrabada != false):
        if ($fichagrabada == $ficha):
            return true;
        else:
            return false;
        endif;
    else:
        return false;
    endif;
}

function recuperaFichaHecho($formulario, $dpa)
{
    global $db;
    //verifica si existe
    $sql = "SELECT COUNT (*) resultado FROM fic_ficha WHERE fic_formulario = '$formulario' AND dpa_id = $dpa  ;";
    $row = $db->getRecord($sql);
    if ((int)$row ["resultado"] == 0):
        return false;
    else:
        $sql = "SELECT fic_id resultado FROM fic_ficha WHERE fic_formulario = '$formulario' AND dpa_id = $dpa ;";
        $row = $db->getRecord($sql);
        return $row ["resultado"];
    endif;
}

//librerias comunes importacion CSV

function recuperaDatosMigrar($datosMigrarCSV, $campo)
{
    if (isset ($datosMigrarCSV [$campo])):
        return $datosMigrarCSV [$campo];
    else:
        return "";
    endif;
}

// Migracion funciones

function claveExterna($nombrefila, $tabla, $parametro, $retorna, $inserta)
{
    global $db;
    //verifica si existe
    $sql = "SELECT COUNT(*) total FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
    $row = $db->getRecord($sql);
    if ($row["total"] != "0"):
        $sql = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    else:
        if ($inserta == "1"):
            $sql = "INSERT INTO $tabla ($parametro) VALUES ('$nombrefila');";
            $row1 = $db->execute($sql);
            $sql2 = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
            $row2 = $db->getRecord($sql2);
            return "'" . $row2["resultado"] . "'";
        else :
            return "NULL";
        endif;
    endif;
    //crear mensajes en caso de no retornar nada
}

function claveExternahidroCSV($datoSistema, $datoCuenca, $datoSubcuenca, $claveMicrocuenca, $tabla, $parametro, $retorna)
{
    global $error_importacion;
    if ($claveMicrocuenca != ''):
        return "'" . $claveMicrocuenca . "'";
    elseif ($datoSubcuenca != ''):
        return "'" . $datoSubcuenca . "'";
    elseif ($datoCuenca != ''):
        return "'" . $datoCuenca . "'";
    elseif ($datoSistema != ''):
        return "'" . $datoSistema . "'";
    else :
        return 'NULL';
    endif;
}

function lastInsertId($tabla, $id)
{
    global $db;
    $sql = "SELECT MAX ($id)as resultado FROM $tabla;";
    $row = $db->getRecord($sql);
    return $row["resultado"];
}


function migrarFichasCSV($archivo, $tipo, $setupXML)
{
    global $xmlSetup;
    global $datosMigrarCSV;
    global $error_importacion;

    $cabeceratotal = "";
    $cuerpototal = "";
    $resul_migracion = array("sql" => "", "ok" => "", "errores" => "", "stop" => 0, "warning" => "", "parametros" => array());

    $xmlSetup = leeSetup($setupXML);

    leearchivoCSV($archivo);

    $tipoDatos = get_tipoDatosCSV($datosMigrarCSV);

    if ($tipoDatos != $tipo):
        $error_importacion = "Archivo CSV no es de tipo " . $tipo;
        $resul_migracion["errores"] = '{success:false, msg:"' . $error_importacion . '"}';
        $resul_migracion["stop"] = 1;
        return $resul_migracion;
    endif;
    // fin verificar si no se han cambiado los campos


    $tabla = $xmlSetup->config[0]->tabla;
    $tabladetalle = $xmlSetup->config[0]->tabladetalle;
    //generamos un string con los nombres de los campos
    $nombrescampos = "fic_id, ";
    $nombrescamposdetalle = "";
    $valoresinsert = "";

    //verificar si registro a insertar ya a sido insertado
    $formulario = recuperaDatosMigrar($datosMigrarCSV, 'con_formulario');

    $datoprovincia = recuperaDatosMigrar($datosMigrarCSV, 'dpa_provincia');
    $datocanton = recuperaDatosMigrar($datosMigrarCSV, 'dpa_canton');
    $datoparroquia = recuperaDatosMigrar($datosMigrarCSV, 'dpa_parroquia');

    $dpa = seleccionaDPAclave($datoprovincia, $datocanton, $datoparroquia);
    $proceso = recuperaDatosMigrar($datosMigrarCSV, 'con_proceso');

    //esFichaNueva ($ficha);

    $validaFicha = validacionFicha($tipo, $formulario, $dpa, $proceso);
    if (!$validaFicha):
        $error_importacion = "Ficha ya existe.";
        $resul_migracion["errores"] = '{success:false, msg:"' . $error_importacion . '"}';
        $resul_migracion["stop"] = 1;
        return $resul_migracion;
    endif;
    //fin verificar si registro a insertar ya a sido insertado


    $fic_id = lastInsertId($tabla, "fic_id");
    //nombres campos de cabecera
    for ($j = 0; $j < count($xmlSetup->parametro); $j++) {
        //validamos cada dato preveio a generar el query
        if ($xmlSetup->parametro[$j]->importar != 0):
            if ($j != 0)
                $nombrescampos .= ", ";
            $nombrescampos .= $xmlSetup->parametro[$j]->campo;
        endif;
    }

    // ombres campos para el detalle
    for ($j = 0; $j < count($xmlSetup->camposdetalle); $j++) {
        //validamos cada dato preveio a generar el query
        if ($xmlSetup->camposdetalle[$j]->importar != 0):
            if ($j != 1)
                $nombrescamposdetalle .= ", ";
            $nombrescamposdetalle .= $xmlSetup->camposdetalle[$j]->nombre;
        endif;
    }
    // generamos un string con los valores a insertar
    //insercion cabecera fic_ficha
    $valorescampos = "( " . ($fic_id + 1) . " ,";
    //validamos cada dato preveio a generar el query
    for ($j = 0; $j < count($xmlSetup->parametro); $j++) {
        //verificamos si el campo se importa o no
        if ($xmlSetup->parametro[$j]->importar != 0
        ):
            //verificamos si es un campo simple o uno externo
            if ($xmlSetup->parametro[$j]->tablaRelacionada == ""):
                if ($j != 0)
                    $valorescampos .= ",  ";
                $nombrefila = (string)$xmlSetup->parametro[$j]->campo_old[0];
                $tipodato = $xmlSetup->parametro[$j]->tipodato;
                $dato = recuperaDatosMigrar($datosMigrarCSV, $nombrefila);
                switch ($tipodato):
                    case "varchar":
                        $valorescampos .= validaCadena($dato, 0);
                        break;
                    case "int":
                        $valorescampos .= validaEntero($dato);
                        break;
                    case "date":
                        $valorescampos .= validaDateCSV($dato);
                        break;
                    case "numeric":
                        $valorescampos .= validaNumeric($dato);
                        break;
                    case "float":
                        $valorescampos .= validaFloat($dato);
                        break;
                    case "constante":
                        $constante = $xmlSetup->parametro[$j]->default;
                        $valorescampos .= "'" . $constante . "'";
                        break;
                endswitch;
            else:
                $nombrefila = (string)$xmlSetup->parametro[$j]->campo_old;
                $dato = recuperaDatosMigrar($datosMigrarCSV, $nombrefila);
                $parametro = $xmlSetup->parametro[$j]->parametro;
                $retorna = $xmlSetup->parametro[$j]->retorna;
                $inserta = $xmlSetup->parametro[$j]->insertar;
                $tablaRelacionada = $xmlSetup->parametro[$j]->tablaRelacionada;
                switch ($tablaRelacionada):
                    case "fic_hidrograficas":
                        $datoSistema = recuperaDatosMigrar($datosMigrarCSV, 'hid_id');
                        $datoCuenca = recuperaDatosMigrar($datosMigrarCSV, 'cue_id');
                        $datoSubcuenca = recuperaDatosMigrar($datosMigrarCSV, 'sub_id');
                        $claveMicrocuenca = recuperaDatosMigrar($datosMigrarCSV, 'mic_id');
                        $claveexterna = claveExternahidroCSV($datoSistema, $datoCuenca, $datoSubcuenca, $claveMicrocuenca, $tablaRelacionada, $parametro, $retorna);
                        break;
                    case "fic_dpa":
                        $claveexterna = $dpa;
                        break;
                    case "fic_concesionario":
                        $rio_telefono = recuperaDatosMigrar($datosMigrarCSV, 'rio_telefono');
                        $rio_celular = recuperaDatosMigrar($datosMigrarCSV, 'rio_celular');
                        $rio_email = recuperaDatosMigrar($datosMigrarCSV, 'rio_email');
                        $claveexterna = claveExternaConcesion($dato, $tablaRelacionada, $parametro, $retorna, $inserta, $rio_telefono, $rio_celular, $rio_email);
                        break;
                    default:
                        $claveexterna = claveExternaCSV($dato, $tablaRelacionada, $parametro, $retorna, $inserta);
                endswitch;
                if ($j != 0)
                    $valorescampos .= ",  ";
                $valorescampos .= $claveexterna;
            endif;
        endif;
    }
    $valorescampos .= " )";
    $valoresinsert .= $valorescampos;

    //insercion de la cabecera si no existe el registro entonces se puede insertar uno nuevo
    $formulario = recuperaDatosMigrar($datosMigrarCSV, 'con_proceso'); // M oooooohoooooooo
    $proceso = recuperaDatosMigrar($datosMigrarCSV, 'con_formulario'); // B oooooohoooooooo
    if (buscarExisteFicha($tipo, $formulario, $dpa, $proceso) == 0) :
        $sqlcabecera = "INSERT INTO " . $tabla . " ( " . $nombrescampos . " ) VALUES " . ' ' . $valoresinsert . ';';
        $cabeceratotal .= $sqlcabecera;
    else:
        $resul_migracion["warning"] .= "Fila: no subida</br>";
    endif;
    ///fin insercion de la cabecera

    $valoresinsert = "";
    //fin insercion cabecera fic_ficha
    //insercion detalle fic_valor
    $sql = "";
    $fic_id = lastInsertId($tabla, "fic_id");
    if (buscarExisteFicha($tipo, $formulario, $dpa, $proceso) == 0) :
        $sql = "INSERT INTO " . $tabladetalle . " ( " . $nombrescamposdetalle . " ) VALUES  ";
        $valoresinsertdetalle = "";
        for ($j = 0; $j < count($xmlSetup->parametro_detalle); $j++) {
            if ($xmlSetup->parametro_detalle[$j]->importar != 0):
                $valorescampos = "( '" . ($fic_id + 1) . "', '" . $xmlSetup->parametro_detalle[$j]->id_indicador . "', ";
                //$nombrefila = (int)$xmlSetup->parametro_detalle[$j]->fila;
                $nombrefila = (string)$xmlSetup->parametro_detalle[$j]->indicador_old;
                $usoindicador = $xmlSetup->parametro_detalle[$j]->uso;
                $tipodato = $xmlSetup->parametro_detalle[$j]->tipodato;
                $variante = $xmlSetup->parametro_detalle[$j]->combo_cat;
                $datoCargar = recuperaDatosMigrar($datosMigrarCSV, $nombrefila);
                $valorescampos .= validaCadenaDetalleCSV($datoCargar, $usoindicador, $tipodato, $variante, $xmlSetup->parametro_detalle[$j]->id_indicador);
                $valorescampos .= " ),";
                /*
                 * para el caso de valores nulos, valores con 0 se omite la inserción
                */
                if (($datoCargar == 0) or ($datoCargar == null) or ($datoCargar == '')) :
                    $valorescampos = '';
                endif;
                $valoresinsertdetalle .= $valorescampos;
            endif;
        }
    endif;
    /*para el caso de el ultimo contenido a insertar le cambiamos la , por un ;*/
    if (isset($valoresinsertdetalle)):
        if ($valoresinsertdetalle != "") :
            $valoresinsertdetalle = substr_replace($valoresinsertdetalle, ';', -1, 1);
            $cuerpototal .= $sql . $valoresinsertdetalle;
        endif;
    endif;
    //fin insercion detalle fic_valor
    //copiamos la coordenada de uso de la ficha  en fic_ficha

    //Mensaje de retorno
    $resul_migracion["sql"] = $cabeceratotal . $cuerpototal;
    if ($resul_migracion["warning"] != ""):
        $error_importacion .= "El registro ya existe.<br>";
    endif;
    $resul_migracion["errores"] = '{success:false, msg:"' . $error_importacion . '"}';
    $resul_migracion["ok"] = '{success:true, msg:"El archivo ' . $archivo . ' ha sido importado."}';
    return $resul_migracion;
}

// Migracion funciones

function claveExternaCSV($nombrefila, $tabla, $parametro, $retorna, $inserta)
{
    global $db;
    //verifica si existe
    $sql = "SELECT COUNT(*) total FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
    $row = $db->getRecord($sql);
    if ($row["total"] != "0"):
        $sql = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
        $row = $db->getRecord($sql);
        return "'" . $row["resultado"] . "'";
    else:
        if ($inserta == "1"):
            $sql = "INSERT INTO $tabla ($parametro) VALUES ('$nombrefila');";
            $row1 = $db->execute($sql);
            $sql2 = "SELECT $retorna as resultado FROM $tabla WHERE upper(sinacentos (regexp_replace($parametro, ' ', '' ,'g'))) = upper (sinacentos (regexp_replace('$nombrefila', ' ', '' ,'g'))) LIMIT 1;";
            $row2 = $db->getRecord($sql2);
            return "'" . $row2["resultado"] . "'";
        else :
            return "NULL";
        endif;
    endif;
    //crear mensajes en caso de no retornar nada
}