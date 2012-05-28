<?php
require_once '../../../common/server/conexion.php';
require_once 'validarUpdate.php';
require_once 'upload.php';

require_once("../../../common/server/libreriasImportacion.php");
require_once("../../../common/server/libreriascomunes.php");

//bandera para indicar que se a usado en al menos una vez el agua
$usoDeAgua = false;
$sql = "";
$parameters = array();
$parameters['con_id'] = $_GET['ficha'];
$ficha = $_GET['ficha'];
$upload = true;

/*
 * Consulta de actualización
 */
$sql .= "UPDATE
		fic_ficha
		SET
			fic_formulario = :con_formulario,
			fic_fecha_toma = :con_fecha_toma_datos,
			fic_repr_nombre = :con_representante_junta,
			fic_repr_direccion = :con_direccion,
			fic_repr_telefono = :con_telefonos,
			fic_resp_nombre = :con_responsable_validacion,
			fic_resp_fecha = :con_fecha_validacion,
			resp_id   = :con_responsable_datos,
			dpa_id    = :dpa_parroquia,
			hid_id    = :mic_id,
			cor_id    = :rio_autoriz_inicial_id,
			cor_id_ini= :rio_autoriz_inicial_id
		WHERE
		fic_id = :con_id;
		";

if ($_FILES["ruta"]["name"] != "") {
    $parroquia = $_POST['dpa_parroquia'];
    $formulario = $_POST['con_formulario'];
    $ruta = '../../../../fotos/legales/';

    if (!is_dir($ruta . $parroquia))
        mkdir($ruta . $parroquia, 0777);

    if (!is_dir($ruta . $parroquia . '/' . $formulario))
        mkdir($ruta . $parroquia . '/' . $formulario, 0777);

    if (!is_dir($ruta . $parroquia . '/' . $formulario . '/thumbnails'))
        mkdir($ruta . $parroquia . '/' . $formulario . '/thumbnails', 0777);

    $upload_dir = $ruta . $parroquia . '/' . $formulario . '/';

    $upload = uploadFile('ruta', $upload_dir);
}

/*
 * Parámetros de consulta
 */
// fic_ficha
$parameters['con_formulario'] = $_POST['con_formulario'];
$parameters['con_fecha_toma_datos'] = $_POST['con_fecha_toma_datos'];
//$parameters['con_proceso'] = $_POST['con_proceso'];
//$parameters['con_fecha_autoriz_ini'] = $_POST['con_fecha_autoriz_ini'];
//$parameters['con_fecha_autoriz_fin'] = $_POST['con_fecha_autoriz_fin'];
//$parameters['con_tarifa'] = $_POST['con_tarifa'];
//$parameters['con_fecha_pago_ini'] = $_POST['con_fecha_pago_ini'];
//$parameters['con_fecha_pago_fin'] = $_POST['con_fecha_pago_fin'];
$parameters['con_representante_junta'] = $_POST['con_representante_junta'];
$parameters['con_direccion'] = $_POST['con_direccion'];
$parameters['con_telefonos'] = $_POST['con_telefonos'];
$parameters['con_responsable_validacion'] = $_POST['con_responsable_validacion'];
$parameters['con_fecha_validacion'] = $_POST['con_fecha_validacion'];

$parameters['rio_autoriz_inicial_id'] = idConcesionario($_POST['rio_autoriz_inicial_id']);
//$parameters['rio_autoriz_actual_id'] = idConcesionario($_POST['rio_autoriz_actual_id']);
valores_detalle_concesionario ($_POST['rio_telefono'],$_POST['rio_celular'] , $_POST['rio_email'] , $parameters['rio_autoriz_inicial_id'] , $ficha );

$parameters['dpa_parroquia'] = $_POST['dpa_parroquia'];
$parameters['mic_id'] = idHidro($_POST['mic_id'] , $_POST['sub_id'],$_POST['cue_id'],$_POST['hid_id']);

$parameters['con_responsable_datos'] = idResponsable($_POST['con_responsable_datos']);
valores('con_observaciones', 207);
valores('pfastetter', 8);
valores_detalle_concesionario($_POST['rio_telefono'], $_POST['rio_celular'], $_POST['rio_email'], $parameters['rio_autoriz_inicial_id'], $ficha);
// fic_concesion_uso
valores('dom_consumo_humano_yn', 28);
valores('ter_termales_yn', 29);
valores('rie_riego_yn', 30);
valores('abr_abrevadero_yn', 31);
valores('hid_hidrolectricas_yn', 32);
valores('env_agua_envasada_yn', 33);
valores('pis_piscicola_yn', 34);
valores('tur_turistico_yn', 35);
valores('mec_fuerza_mecanica_yn', 36);
valores('ind_industria_yn', 37);
valores('otros_yn', 38);
valores('dom_caudal_autorizado', 39);
valores('dom_caudal_medido', 40);
valores('dom_poblacion', 41);
valores('dom_dotacion', 42);
valores('pis_caudal_autorizado', 43);
valores('pis_caudal_medido', 44);
valores('pis_truchas_yn', 45);
valores('pis_truchas_anual', 46);
valores('pis_tilapias_yn', 47);
valores('pis_tilapias_anual', 48);
valores('pis_camarones_yn', 49);
valores('pis_camarones_anual', 50);
valores('pis_otros_yn', 51);
valores('pis_otros_anual', 52);
valores('pis_receptor', 53);
valores('pis_cota', 54);
valores('pis_latitud', 55);
valores('pis_longitud', 56);
valores('pis_impactos_yn', 57);
valores('pis_estanques', 58);
valores('pis_area_total', 59);
//valores ('env_caudal_autorizado',63 );
valores('env_caudal_medido', 64);
valores('env_anual', 65);
//valores ('ter_caudal_autorizado',66 );
valores('ter_caudal_medido', 67);
valores('ter_dias', 68);
valores('ter_volumen', 69);
valores('ter_cota', 71);
valores('ter_latitud', 72);
valores('ter_longitud', 73);
//valores ('ind_caudal_autorizado', 74);
valores('ind_caudal_medido', 75);
valores_param('ind_uso', 76);
valores('ind_receptor', 77);
valores_param('ind_explotacion', 78);
valores('rie_caudal_autorizado', 79);
valores('rie_caudal_medido', 80);

valores_radio('rie_estado_sistema_riego'); /*81*/

valores('rie_metodo_riego_gravedad', 84);
valores('rie_metodo_riego_goteo', 85);
valores('rie_metodo_riego_aspersion', 86);
valores('rie_metodo_riego_otros', 87);
valores('rie_area', 88);
valores('rie_tipo_cultivo1', 89);
valores('rie_tipo_cultivo2', 90);
valores('rie_nfamilias', 91);
valores('rie_dotacion', 92);

valores_radio('rie_tipo_regante'); /*93*/

//valores ('mec_caudal_autorizado',95 );
valores('mec_caudal_medido', 96);
valores('mec_potencia', 97);
valores('mec_altura', 98);
//valores ('abr_caudal_autorizado', 103);
valores('abr_caudal_medido', 104);
valores('abr_sem_vacuno', 105);
valores('abr_sem_porcino', 106);
valores('abr_sem_caprino', 107);
valores('abr_sem_aves', 108);
valores('abr_sem_bovino', 109);
valores('abr_sem_otros', 110);
//valores ('hid_caudal_autorizado', 113 );
valores('hid_caudal_medido', 114);
valores('hid_central', 115);
valores('hid_potencia', 116);
valores('hid_altura', 117);
valores('hid_receptor', 118);
valores('hid_cota', 119);
valores('hid_latitud', 120);
valores('hid_longitud', 121);


// fic_concesion_fuente
valores('nombre', 122);
valores('tipo_fuente_quebrada', 123);
valores('tipo_fuente_rio', 124);
valores('tipo_fuente_pozo', 125);
valores('tipo_fuente_vertiente', 129);
valores('tipo_fuente_lago', 126);
valores('tipo_fuente_estero', 130);
valores('tipo_fuente_drenajes', 127);
valores('tipo_fuente_remanentes', 131);
valores('tipo_fuente_canales', 128);
valores('tipo_fuente_otros', 132);
valores('cota', 134);
valores('latitud', 135);
valores('longitud', 136);
valores('sector', 137);
valores('existe_captacion_yn', 138); /******/
valores('tipo_captacion_tanques', 140);
valores('tipo_captacion_tuberias', 141);
valores('tipo_captacion_equipos', 142);
valores('tipo_captacion_acequias', 143);
valores('tipo_captacion_compuertas', 144);
valores('tipo_captacion_ovalos', 145);
valores('tipo_captacion_diques', 146);
valores('tipo_captacion_otros', 147);

valores_radio('metodo_medicion'); /*148*/

valores_radio('estado_captacion');/**152 **/

valores_radio('operacion_actual');/**156**/

valores('anio_inicio', 160);

valores_radio('tenencia'); /***161**/

valores('propietario', 165);
valores('percepcion_contaminacion_yn', 166);
valores('color_agua', 167);
valores('olor_agua', 168);
valores('flora', 170);
valores('tipo_contaminacion', 171);
valores_param('cobertura_vegetal', 169);

// fic_concesion_potable
valores('pot_nombre', 172);
valores('pot_organizacion', 173);
valores('pot_poblacion', 174);
valores('pot_anios', 175);
valores('pot_dotacion', 176);
valores('pot_cloracion_yn', 177);
valores('pot_medidores_yn', 178);
valores('pot_n_medidores', 179);
valores_param('pot_tipo_almacenamiento', 180); /*****/
valores_param('pot_tratamiento', 181); /*******/
valores_param('pot_abastecimiento', 182); /******/
valores('pot_volumen_reservas', 183);
valores('pot_vida_util', 184);
valores('pot_longitud', 185);

// fic_concesion_saneamiento
valores('san_nombre', 186);
valores('san_organizacion', 187);
valores_param('san_tipo_descarga', 188); /*****/
valores('san_caudal', 189);
valores('san_receptor', 190);
valores_param('san_tipo_receptor', 192);
valores_param('san_tratamiento', 191); /****/
valores('san_cota', 193);
valores('san_latitud', 194);
valores('san_longitud', 195);
valores_combo('san_tipo_alcantarillado'); /*196*/


// fic_concesion_residuos
valores('res_organizacion', 198);
valores('res_volumen', 199);
valores_param('res_tipo_residuos', 200); /*****/
valores('res_receptor', 201);
valores('res_cota', 202);
valores('res_latitud', 203);
valores('res_longitud', 204);

/*generacion de mensaje de error en caso de no tener asignado ningun uso*/

if ($upload) {
    global $db;

    $resul_migracion = array("sql" => "", "ok" => "", "errores" => "", "stop" => 0, "warning" => "");
    //verificar si registro a insertar ya a sido insertado
    $tipo = 'hecho';
    /*ficha ya esta definida*/
    $formulario = $_POST['con_formulario'];
    $parameters['dpa_parroquia'] = $_POST['dpa_parroquia'];
    $parameters['mic_id'] = idHidro($_POST['mic_id'] , $_POST['sub_id'],$_POST['cue_id'],$_POST['hid_id']);

    $datoprovincia = $_POST['dpa_provincia'];
    $datocanton = $_POST['dpa_canton'];
    $datoparroquia = $_POST['dpa_parroquia'];

    $dpa = seleccionaDPAclave($datoprovincia, $datocanton, $datoparroquia);
    if (!isset($_POST['con_proceso'])) $_POST['con_proceso'] = '';

    $proceso = $_POST['con_proceso'];
    $validaFicha = validacionFicha($tipo, $formulario, $dpa, $proceso);

    $resul_migracion = array("sql" => "", "ok" => "", "errores" => "", "stop" => 0, "warning" => "", "parametros" => array());

    if (esFichaNuevaUso($ficha)):
        if (!$validaFicha):
            $resul_migracion["errores"] = '{success: false, msg:"Ficha ya existe. No se grabarán los cambios"}';
            $resul_migracion["stop"] = 1;
        else:
            $resul_migracion["sql"] = $sql;
            $resul_migracion["parametros"] = $parameters;
            $resul_migracion["ok"] = '{success: true, msg:"La información ha sido guardada."}';
        endif;
    else:
        // verifico si se trata de grabar en la misma ficha
        if (validacionFichaSelf($tipo, $formulario, $dpa, $proceso, $ficha)):
            $resul_migracion["sql"] = $sql;
            $resul_migracion["parametros"] = $parameters;
            $resul_migracion["ok"] = '{success: true, msg:"La información ha sido guardada."}';
            setAuditoria("Usos hecho (Actualizar)", $sql);
        else:
            if (!$validaFicha):
                $resul_migracion["errores"] = '{success: false, msg:"Ficha ya existe. No se grabarán los cambios"}';
                $resul_migracion["stop"] = 1;
            else:
                $resul_migracion["sql"] = $sql;
                $resul_migracion["parametros"] = $parameters;
                $resul_migracion["ok"] = '{success: true, msg:"La información ha sido guardada."}';
                setAuditoria("Usos hecho (Actualizar)",  $sql);
            endif;
        endif;
    endif;
    /*if (!$usoDeAgua):
        $resul_migracion["errores"] = '{success: false, msg:"Ficha no tiene seleccionado ningún uso de agua"}';
        $resul_migracion["stop"] = 1;
    endif;*/
    subirdatos($resul_migracion);
    unificaCoordenadas();
}

function valores_combo($nombreindicador)
{
    global $sql;

    $valor_radio = $_POST[$nombreindicador];
    if ($valor_radio != "" or $valor_radio != null) {
        // recupero el valor de par_grupo
        $sql .= "UPDATE fic_valor SET val_valor_cadena ='0' WHERE fic_id = :con_id AND ind_id in (select ind_id from fic_parametros WHERE par_grupo in (select par_grupo from fic_parametros WHERE par_id = $valor_radio ));
		UPDATE fic_valor SET val_valor_cadena ='1' WHERE fic_id = :con_id and ind_id in (select ind_id from fic_parametros WHERE par_id = $valor_radio );
		";
    }
}

function valores_radio($nombreindicador)
{
    global $sql;
    global $ficha;
    inicia_valores_radio($ficha);
    $valor_radio = intval($_POST[$nombreindicador]);

    if ($valor_radio != "" or $valor_radio != null) {
        $sql .= "
			UPDATE fic_valor SET val_valor_cadena ='1' WHERE fic_id = $ficha AND ind_id in (select ind_id from fic_parametros WHERE par_id = $valor_radio);
			UPDATE fic_valor SET val_valor_cadena ='0' WHERE fic_id = $ficha AND ind_id in (select ind_id from fic_parametros WHERE par_grupo in (select par_grupo from fic_parametros WHERE par_id = $valor_radio )AND par_id not in ( $valor_radio));
			";
    }
}

// graba la descripcion de la tabla parametros en el campo
function valores_param($nombreindicador, $indicador)
{
    global $parameters;
    global $sql;
    global $ficha;

    if ($_POST[$nombreindicador] != '' or $_POST[$nombreindicador] != null) :
        if (verificaexisteIndicador($indicador, $ficha) != 0):
            $parameters[$nombreindicador] = $_POST[$nombreindicador];
            $sql .= "UPDATE fic_valor SET
			val_valor_cadena = buscar_desc_parametro(:$nombreindicador)
			WHERE ind_id=$indicador AND fic_id = :con_id;
			";
        else:
            if (isset ($_POST[$nombreindicador]) and $_POST[$nombreindicador] != "0" and $_POST[$nombreindicador] != "" )  {
            $sql .= "INSERT INTO fic_valor (ind_id, fic_id, val_valor_cadena) VALUES ('$indicador', :con_id, buscar_desc_parametro($_POST[$nombreindicador]));";
            }
        endif;
    endif;
}

function valores($nombreindicador, $indicador)
{
    global $parameters;
    global $sql;
    global $ficha;
    global $_POST;
    if ($nombreindicador != "") :
        if (verificaexisteIndicador($indicador, $ficha) != 0):
            if (isset ($_POST[$nombreindicador])) :
                if (($_POST[$nombreindicador])!='0'):
                    $parameters[$nombreindicador] = $_POST[$nombreindicador];
                    $sql .= " UPDATE fic_valor SET
                    val_valor_cadena=:$nombreindicador
                    WHERE ind_id=$indicador AND fic_id = :con_id;
                    ";
                else:
                    $sql .= "DELETE FROM fic_valor WHERE ind_id=$indicador AND (fic_id=:con_id);
                    ";
                endif;
            endif;
        else:
            if (isset ($_POST[$nombreindicador]) and $_POST[$nombreindicador] != "0" and $_POST[$nombreindicador] != "" )  {
                $parameters[$nombreindicador] = $_POST[$nombreindicador];
                $sql .= "INSERT INTO fic_valor (ind_id, fic_id, val_valor_cadena) VALUES ('$indicador', :con_id, :$nombreindicador);
                ";
            }
        endif;
    endif;
    if (isset ($_POST[$nombreindicador])):
        verificaUsosdeAgua($indicador, $_POST[$nombreindicador]);
    endif;
}

function verificaexisteIndicador($indicador, $id_ficha)
{
    global $db;
    $sql = "select count(*) resultado FROM fic_valor WHERE ind_id=$indicador AND fic_id = $id_ficha;";
    $row = $db->getRecord($sql);
    return intval($row["resultado"]);
}

function verificaUsuario ($usuario )
{
    global $db;
    //tambien actualiza el caudal
    $sql = "select count(*) resultado FROM fic_concesionario WHERE REPLACE (UPPER(cor_autor_act_nombre),' ','') = REPLACE (UPPER (?),' ',''); ";
    $row = $db->getRecord($sql, $usuario);
    $usuario = trim ($usuario);

    if ($row["resultado"] != '0' ):
        // build our query
        $sql = "SELECT cor_id FROM fic_concesionario WHERE REPLACE (UPPER(cor_autor_act_nombre),' ','') = REPLACE (UPPER (?),' ','') LIMIT 1; ";
        $usuarioid  = $db->getVar($sql, $usuario);
        return $usuarioid;
    else:
        return intval($row["resultado"]);
    endif;
}

function idConcesionario($user)
{
    /* Consulta de la clave de un concesionario si no existe se inserta en la base
    */
    global $db;
    /*retiramos espacios en blanco al inicio y al final de la cadena*/
    if ($user == "") return NULL;
    // reemplaza doble espacio por esacio simple y se retira espacios de inicio y final de la cadena
    if (verificaUsuario ($user) != 0) :
        return verificaUsuario ($user)   ;
    else:
        $sql = "SELECT nextval ('fic_concesionario_cor_id');";
        $idnuevo = $db->getVar ($sql);
        /*convertimos a mayusculas el nombre*/
        $user = strtoupper($user);
        $user = trim ($user);
        $sql = "INSERT INTO fic_concesionario (cor_id, cor_autor_act_nombre) VALUES (?, ?)";
        $db->execute($sql, array($idnuevo, $user));
        return $idnuevo;
    endif;
}

function verificaResponsable ($usuario )
{
    global $db;
    //tambien actualiza el caudal

    $sql = "select count(*) resultado FROM fic_responsable WHERE REPLACE (UPPER(resp_nombre),' ','') = REPLACE (UPPER (?),' ','') ";
    $row = $db->getRecord($sql, $usuario);
    if ($row["resultado"] != '0'):
        $usuario = trim ($usuario);
        // build our query
        $sql = "SELECT resp_id FROM fic_responsable WHERE REPLACE (UPPER(resp_nombre),' ','') = REPLACE (UPPER (?),' ','') LIMIT 1; ";
        $usuarioid  = $db->getVar($sql, $usuario);
        return $usuarioid;
    else:
        return intval($row["resultado"]);
    endif;
}

function idResponsable($user)
{
    /* Consulta de la clave de un concesionario si no existe se inserta en la base
    */
    global $db;

    if ($user == "") return NULL;

    $usuarioid = verificaResponsable ($user);
    if ($usuarioid != 0) :
        return $usuarioid ;
    else:
        $sql = "SELECT nextval ('fic_responsable_resp_id');";
        $idnuevo = $db->getVar ($sql);
        /*convertimos a mayusculas el nombre*/
        $user = strtoupper($user);
        $sql = "INSERT INTO fic_responsable (resp_id, resp_nombre) VALUES (?, ?)";
        $db->execute($sql, array($idnuevo, $user));
        return $idnuevo;
    endif;
}


function inicia_valores_radio($idficha)
{
    global $db;
    $sql = "";
    //tambien actualiza el caudal
    $sql = insertaExiste($idficha, 81, 'rie_estado_sistema_riego');
    $sql .= insertaExiste($idficha, 82, 'rie_estado_sistema_riego');
    $sql .= insertaExiste($idficha, 83, 'rie_estado_sistema_riego');
    $sql .= insertaExiste($idficha, 93, 'rie_tipo_regante');
    $sql .= insertaExiste($idficha, 94, 'rie_tipo_regante');
    $sql .= insertaExiste($idficha, 148, 'metodo_medicion');
    $sql .= insertaExiste($idficha, 149,'metodo_medicion');
    $sql .= insertaExiste($idficha, 150,'metodo_medicion');
    $sql .= insertaExiste($idficha, 151,'metodo_medicion');
    $sql .= insertaExiste($idficha, 152,'estado_captacion');
    $sql .= insertaExiste($idficha, 153,'estado_captacion');
    $sql .= insertaExiste($idficha, 154,'estado_captacion');
    $sql .= insertaExiste($idficha, 155,'estado_captacion');
    $sql .= insertaExiste($idficha, 156,'operacion_actual');
    $sql .= insertaExiste($idficha, 157,'operacion_actual');
    $sql .= insertaExiste($idficha, 158,'operacion_actual');
    $sql .= insertaExiste($idficha, 159,'operacion_actual');
    $sql .= insertaExiste($idficha, 161,'tenencia');
    $sql .= insertaExiste($idficha, 162,'tenencia');
    $sql .= insertaExiste($idficha, 163,'tenencia');
    $sql .= insertaExiste($idficha, 164,'tenencia');
    $sql .= insertaExiste($idficha, 196,'san_tipo_alcantarillado');
    $sql .= insertaExiste($idficha, 197,'san_tipo_alcantarillado');
    if ($sql != ""):
        $row = $db->getRecord($sql);
    endif;
}


function insertaExiste($idficha, $idindicar, $nombreindicador)
{
    $sql = '';
    if (isset ($_POST[$nombreindicador]) and $_POST[$nombreindicador] != "0" and $_POST[$nombreindicador] != "" )  {
        if (verificaexisteIndicador($idindicar, $idficha) == 0):
            $sql = "INSERT INTO fic_valor (ind_id, fic_id, val_valor_cadena) VALUES ($idindicar, $idficha, 0);";
        endif;
    }
    return $sql;
}

function valores_detalle_concesionario($telefono, $celular, $email, $ficha)
{
    global $db;
    if ($ficha == "" ) return;
    $sql = "UPDATE fic_concesionario SET cor_autor_act_telefono=?, cor_autor_act_celular=?, cor_autor_act_mail=? WHERE (cor_id=?)";
    $db->execute($sql, array($telefono, $celular, $email, $ficha));
}
