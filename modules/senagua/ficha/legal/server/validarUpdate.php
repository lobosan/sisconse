<?php

/*
 * Fechas
 */
if ($_POST['con_fecha_toma_datos'] == '') $_POST['con_fecha_toma_datos'] = NULL;
if ($_POST['con_fecha_autoriz_ini'] == '') $_POST['con_fecha_autoriz_ini'] = NULL;
if ($_POST['con_fecha_autoriz_fin'] == '') $_POST['con_fecha_autoriz_fin'] = NULL;
if ($_POST['con_fecha_pago_ini'] == '') $_POST['con_fecha_pago_ini'] = NULL;
if ($_POST['con_fecha_pago_fin'] == '') $_POST['con_fecha_pago_fin'] = NULL;
if ($_POST['con_fecha_validacion'] == '') $_POST['con_fecha_validacion'] = NULL;

/*
 * Números
 */
$_POST['con_tarifa'] = ($_POST['con_tarifa'] == '') ? 0 : str_replace (",", ".", $_POST['con_tarifa']);
$_POST['pfastetter'] = ($_POST['pfastetter'] == '') ? 0 : str_replace (",", ".", $_POST['pfastetter']);
$_POST['con_proceso'] = ($_POST['con_proceso'] == '') ? 0 : str_replace (",", ".", $_POST['con_proceso']);
$_POST['dom_caudal_autorizado'] = ($_POST['dom_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['dom_caudal_autorizado']);
$_POST['dom_caudal_medido'] = ($_POST['dom_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['dom_caudal_medido']);
$_POST['dom_poblacion'] = ($_POST['dom_poblacion'] == '') ? 0 : str_replace (",", ".", $_POST['dom_poblacion']);
$_POST['dom_dotacion'] = ($_POST['dom_dotacion'] == '') ? 0 : str_replace (",", ".", $_POST['dom_dotacion']);
$_POST['pis_caudal_autorizado'] = ($_POST['pis_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['pis_caudal_autorizado']);
$_POST['pis_caudal_medido'] = ($_POST['pis_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['pis_caudal_medido']);
$_POST['pis_truchas_anual'] = ($_POST['pis_truchas_anual'] == '') ? 0 : str_replace (",", ".", $_POST['pis_truchas_anual']);
$_POST['pis_tilapias_anual'] = ($_POST['pis_tilapias_anual'] == '') ? 0 : str_replace (",", ".", $_POST['pis_tilapias_anual']);
$_POST['pis_camarones_anual'] = ($_POST['pis_camarones_anual'] == '') ? 0 : str_replace (",", ".", $_POST['pis_camarones_anual']);
$_POST['pis_otros_anual'] = ($_POST['pis_otros_anual'] == '') ? 0 : str_replace (",", ".", $_POST['pis_otros_anual']);
$_POST['pis_cota'] = ($_POST['pis_cota'] == '') ? 0 : str_replace (",", ".", $_POST['pis_cota']);
$_POST['pis_latitud'] = ($_POST['pis_latitud'] == '') ? 0 : str_replace (",", ".", $_POST['pis_latitud']);
$_POST['pis_longitud'] = ($_POST['pis_longitud'] == '') ? 0 : str_replace (",", ".", $_POST['pis_longitud']);
$_POST['pis_estanques'] = ($_POST['pis_estanques'] == '') ? 0 : str_replace (",", ".", $_POST['pis_estanques']);
$_POST['pis_area_total'] = ($_POST['pis_area_total'] == '') ? 0 : str_replace (",", ".", $_POST['pis_area_total']);
$_POST['env_caudal_autorizado'] = ($_POST['env_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['env_caudal_autorizado']);
$_POST['env_caudal_medido'] = ($_POST['env_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['env_caudal_medido']);
$_POST['env_anual'] = ($_POST['env_anual'] == '') ? 0 : str_replace (",", ".", $_POST['env_anual']);
$_POST['ter_caudal_autorizado'] = ($_POST['ter_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['ter_caudal_autorizado']);
$_POST['ter_caudal_medido'] = ($_POST['ter_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['ter_caudal_medido']);
$_POST['ter_dias'] = ($_POST['ter_dias'] == '') ? 0 : str_replace (",", ".", $_POST['ter_dias']);
$_POST['ter_volumen'] = ($_POST['ter_volumen'] == '') ? 0 : str_replace (",", ".", $_POST['ter_volumen']);
$_POST['ter_cota'] = ($_POST['ter_cota'] == '') ? 0 : str_replace (",", ".", $_POST['ter_cota']);
$_POST['ter_latitud'] = ($_POST['ter_latitud'] == '') ? 0 : str_replace (",", ".", $_POST['ter_latitud']);
$_POST['ter_longitud'] = ($_POST['ter_longitud'] == '') ? 0 : str_replace (",", ".", $_POST['ter_longitud']);
$_POST['ind_caudal_autorizado'] = ($_POST['ind_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['ind_caudal_autorizado']);
$_POST['ind_caudal_medido'] = ($_POST['ind_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['ind_caudal_medido']);
$_POST['rie_caudal_autorizado'] = ($_POST['rie_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['rie_caudal_autorizado']);
$_POST['rie_caudal_medido'] = ($_POST['rie_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['rie_caudal_medido']);
$_POST['rie_area'] = ($_POST['rie_area'] == '') ? 0 : str_replace (",", ".", $_POST['rie_area']);
$_POST['rie_nfamilias'] = ($_POST['rie_nfamilias'] == '') ? 0 : str_replace (",", ".", $_POST['rie_nfamilias']);
$_POST['rie_dotacion'] = ($_POST['rie_dotacion'] == '') ? 0 : str_replace (",", ".", $_POST['rie_dotacion']);
$_POST['mec_caudal_autorizado'] = ($_POST['mec_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['mec_caudal_autorizado']);
$_POST['mec_caudal_medido'] = ($_POST['mec_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['mec_caudal_medido']);
$_POST['mec_potencia'] = ($_POST['mec_potencia'] == '') ? 0 : str_replace (",", ".", $_POST['mec_potencia']);
$_POST['mec_altura'] = ($_POST['mec_altura'] == '') ? 0 : str_replace (",", ".", $_POST['mec_altura']);
$_POST['abr_caudal_autorizado'] = ($_POST['abr_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['abr_caudal_autorizado']);
$_POST['abr_caudal_medido'] = ($_POST['abr_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['abr_caudal_medido']);
$_POST['abr_sem_vacuno'] = ($_POST['abr_sem_vacuno'] == '') ? 0 : str_replace (",", ".", $_POST['abr_sem_vacuno']);
$_POST['abr_sem_porcino'] = ($_POST['abr_sem_porcino'] == '') ? 0 : str_replace (",", ".", $_POST['abr_sem_porcino']);
$_POST['abr_sem_caprino'] = ($_POST['abr_sem_caprino'] == '') ? 0 : str_replace (",", ".", $_POST['abr_sem_caprino']);
$_POST['abr_sem_aves'] = ($_POST['abr_sem_aves'] == '') ? 0 : str_replace (",", ".", $_POST['abr_sem_aves']);
$_POST['abr_sem_bovino'] = ($_POST['abr_sem_bovino'] == '') ? 0 : str_replace (",", ".", $_POST['abr_sem_bovino']);
$_POST['abr_sem_otros'] = ($_POST['abr_sem_otros'] == '') ? 0 : str_replace (",", ".", $_POST['abr_sem_otros']);
$_POST['hid_caudal_autorizado'] = ($_POST['hid_caudal_autorizado'] == '') ? 0 : str_replace (",", ".", $_POST['hid_caudal_autorizado']);
$_POST['hid_caudal_medido'] = ($_POST['hid_caudal_medido'] == '') ? 0 : str_replace (",", ".", $_POST['hid_caudal_medido']);
$_POST['hid_potencia'] = ($_POST['hid_potencia'] == '') ? 0 : str_replace (",", ".", $_POST['hid_potencia']);
$_POST['hid_altura'] = ($_POST['hid_altura'] == '') ? 0 : str_replace (",", ".", $_POST['hid_altura']);
$_POST['hid_cota'] = ($_POST['hid_cota'] == '') ? 0 : str_replace (",", ".", $_POST['hid_cota']);
$_POST['hid_latitud'] = ($_POST['hid_latitud'] == '') ? 0 : str_replace (",", ".", $_POST['hid_latitud']);
$_POST['hid_longitud'] = ($_POST['hid_longitud'] == '') ? 0 : str_replace (",", ".", $_POST['hid_longitud']);
$_POST['cota'] = ($_POST['cota'] == '') ? 0 : str_replace (",", ".", $_POST['cota']);
$_POST['latitud'] = ($_POST['latitud'] == '') ? 0 : str_replace (",", ".", $_POST['latitud']);
$_POST['longitud'] = ($_POST['longitud'] == '') ? 0 : str_replace (",", ".", $_POST['longitud']);
$_POST['anio_inicio'] = ($_POST['anio_inicio'] == '') ? 0 : str_replace (",", ".", $_POST['anio_inicio']);
$_POST['pot_poblacion'] = ($_POST['pot_poblacion'] == '') ? 0 : str_replace (",", ".", $_POST['pot_poblacion']);
$_POST['pot_anios'] = ($_POST['pot_anios'] == '') ? 0 : str_replace (",", ".", $_POST['pot_anios']);
$_POST['pot_dotacion'] = ($_POST['pot_dotacion'] == '') ? 0 : str_replace (",", ".", $_POST['pot_dotacion']);
$_POST['pot_n_medidores'] = ($_POST['pot_n_medidores'] == '') ? 0 : str_replace (",", ".", $_POST['pot_n_medidores']);
$_POST['pot_volumen_reservas'] = ($_POST['pot_volumen_reservas'] == '') ? 0 : str_replace (",", ".", $_POST['pot_volumen_reservas']);
$_POST['pot_vida_util'] = ($_POST['pot_vida_util'] == '') ? 0 : str_replace (",", ".", $_POST['pot_vida_util']);
$_POST['pot_longitud'] = ($_POST['pot_longitud'] == '') ? 0 : str_replace (",", ".", $_POST['pot_longitud']);
$_POST['san_caudal'] = ($_POST['san_caudal'] == '') ? 0 : str_replace (",", ".", $_POST['san_caudal']);
$_POST['san_cota'] = ($_POST['san_cota'] == '') ? 0 : str_replace (",", ".", $_POST['san_cota']);
$_POST['san_latitud'] = ($_POST['san_latitud'] == '') ? 0 : str_replace (",", ".", $_POST['san_latitud']);
$_POST['san_longitud'] = ($_POST['san_longitud'] == '') ? 0 : str_replace (",", ".", $_POST['san_longitud']);
$_POST['res_volumen'] = ($_POST['res_volumen'] == '') ? 0 : str_replace (",", ".", $_POST['res_volumen']);
$_POST['res_cota'] = ($_POST['res_cota'] == '') ? 0 : str_replace (",", ".", $_POST['res_cota']);
$_POST['res_latitud'] = ($_POST['res_latitud'] == '') ? 0 : str_replace (",", ".", $_POST['res_latitud']);
$_POST['res_longitud'] = ($_POST['res_longitud'] == '') ? 0 : str_replace (",", ".", $_POST['res_longitud']);


/*
 * Combos
 */
if (!isset($_POST['dpa_provincia'])) $_POST['dpa_provincia'] = NULL;
if (!isset($_POST['dpa_canton'])) $_POST['dpa_canton'] = NULL;
if (!isset($_POST['dpa_parroquia'])) $_POST['dpa_parroquia'] = NULL;
if (!isset($_POST['hid_id'])) $_POST['hid_id'] = NULL;
if (!isset($_POST['cue_id'])) $_POST['cue_id'] = NULL;
if (!isset($_POST['sub_id'])) $_POST['sub_id'] = NULL;
if (!isset($_POST['mic_id'])) $_POST['mic_id'] = NULL;

if (!isset($_POST['rio_telefono'])) $_POST['rio_telefono'] = NULL;
if (!isset($_POST['rio_celular'])) $_POST['rio_celular'] = NULL;
if (!isset($_POST['rio_email'])) $_POST['rio_email'] = NULL;

if (!isset($_POST['rio_autoriz_inicial_id'])) $_POST['rio_autoriz_inicial_id'] = NULL;
if (!isset($_POST['rio_autoriz_actual_id'])) $_POST['rio_autoriz_actual_id'] = NULL;
if (!isset($_POST['pis_impactos_yn'])) $_POST['pis_impactos_yn'] = NULL;
if (!isset($_POST['ind_uso'])) $_POST['ind_uso'] = NULL;
if (!isset($_POST['ind_explotacion'])) $_POST['ind_explotacion'] = NULL;
if (!isset($_POST['existe_captacion_yn'])) $_POST['existe_captacion_yn'] = NULL;
if (!isset($_POST['percepcion_contaminacion_yn'])) $_POST['percepcion_contaminacion_yn'] = NULL;
if (!isset($_POST['cobertura_vegetal'])) $_POST['cobertura_vegetal'] = NULL;
if (!isset($_POST['pot_cloracion_yn'])) $_POST['pot_cloracion_yn'] = NULL;
if (!isset($_POST['pot_medidores_yn'])) $_POST['pot_medidores_yn'] = NULL;
if (!isset($_POST['pot_tipo_almacenamiento'])) $_POST['pot_tipo_almacenamiento'] = NULL;
if (!isset($_POST['pot_tratamiento'])) $_POST['pot_tratamiento'] = NULL;
if (!isset($_POST['pot_abastecimiento'])) $_POST['pot_abastecimiento'] = NULL;
if (!isset($_POST['san_tipo_descarga'])) $_POST['san_tipo_descarga'] = NULL;
if (!isset($_POST['san_tratamiento'])) $_POST['san_tratamiento'] = NULL;
if (!isset($_POST['san_tipo_receptor'])) $_POST['san_tipo_receptor'] = NULL;
if (!isset($_POST['san_tipo_alcantarillado'])) $_POST['san_tipo_alcantarillado'] = NULL;
if (!isset($_POST['res_tipo_residuos'])) $_POST['res_tipo_residuos'] = NULL;

/*
 * Radio buttons
 */
if (!isset($_POST['rie_estado_sistema_riego'])) $_POST['rie_estado_sistema_riego'] = NULL;
if (!isset($_POST['rie_tipo_regante'])) $_POST['rie_tipo_regante'] = NULL;
if (!isset($_POST['metodo_medicion'])) $_POST['metodo_medicion'] = NULL;
if (!isset($_POST['estado_captacion'])) $_POST['estado_captacion'] = NULL;
if (!isset($_POST['operacion_actual'])) $_POST['operacion_actual'] = NULL;
if (!isset($_POST['tenencia'])) $_POST['tenencia'] = NULL;