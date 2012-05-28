<?php
require_once("vcl/vcl.inc.php");
require_once("db_modulo.php");
//Inclusiones
use_unit("comctrls.inc.php");
use_unit("dbgrids.inc.php");
use_unit("db.inc.php");
use_unit("dbtables.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

//public string $globalXml;
//Definicin de clase
class PGeneral extends Page
{
	public $TTabla = null;
	public $QGeneral = null;

/*******************************************************************************/
/*************************  Actualizacion de Ubicaciones  **********************/
/*******************************************************************************/
	function gruposProvincias() {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>
				<lista>\n';
		$consulta = "select
						provincia.cod_provincia as codigo,
						fic_dpa.dpa_descripcion as provincia
					from 
					(
						select provincia.dpa_id as cod_provincia
						from
						fic_ficha,
						fic_dpa provincia,
						fic_dpa parroquia
						where
						provincia.dpa_id = substr(parroquia.dpa_id, 1, 2)
						and parroquia.dpa_id = fic_ficha.dpa_id
						group by provincia.dpa_id
					) as provincia
					left join fic_dpa fic_dpa
					on fic_dpa.dpa_id = provincia.cod_provincia";
		$this->QGeneral->setSQL($consulta);
		$this->QGeneral->refresh();
		$this->QGeneral->first();
		$xml .= '<item ';
		$xml .= ' provincia="- No seleccionado -" ';
		$xml .= ' codigo="-1" ';
		$xml .= '/>\n';
		while (!$this->QGeneral->EOF) {
			$xml .= '<item ';
			$xml .= ' provincia="'.trim($this->QGeneral->fieldget('provincia')).'" ';
			$xml .= ' codigo="'.trim($this->QGeneral->fieldget('codigo')).'" ';
			$xml .= '/>\n';
			$this->QGeneral->next();
		}
		$xml .= "</lista>";
		return $xml;
	}
	function gruposCantones() {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>
				<lista>\n';
		$consulta = "select
						canton.cod_canton as codigo,
						fic_dpa.dpa_descripcion as canton
					from 
					(
						select canton.dpa_id as cod_canton
						from
						fic_ficha,
						fic_dpa canton,
						fic_dpa parroquia
						where
						canton.dpa_id = substr(parroquia.dpa_id, 1, 4)
						and parroquia.dpa_id = fic_ficha.dpa_id
						group by canton.dpa_id
					) as canton
					left join fic_dpa fic_dpa
					on fic_dpa.dpa_id = canton.cod_canton";
		$this->QGeneral->setSQL($consulta);
		$this->QGeneral->refresh();
		$this->QGeneral->first();
		$xml .= '<item ';
		$xml .= ' canton="- No seleccionado -" ';
		$xml .= ' codigo="-1" ';
		$xml .= "/>\n";
		while (!$this->QGeneral->EOF) {
			$xml .= '<item ';
			$xml .= ' canton="'.trim($this->QGeneral->fieldget('canton')).'" ';
			$xml .= ' codigo="'.trim($this->QGeneral->fieldget('codigo')).'" ';
			$xml .= "/>\n";
			$this->QGeneral->next();
		}
		$xml .= "</lista>";
		return $xml;
	}
	function gruposParroquias() {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>
				<lista>\n';
		$consulta = "select
						parroquia.cod_parroquia as codigo,
						fic_dpa.dpa_descripcion as parroquia
					from 
					(
						select parroquia.dpa_id as cod_parroquia
						from
						fic_ficha,
						fic_dpa parroquia
						where
						parroquia.dpa_id = fic_ficha.dpa_id
						group by parroquia.dpa_id
					) as parroquia
					left join fic_dpa fic_dpa
					on fic_dpa.dpa_id = parroquia.cod_parroquia";
		$this->QGeneral->setSQL($consulta);
		$this->QGeneral->refresh();
		$this->QGeneral->first();
		$xml .= '<item ';
		$xml .= ' parroquia="- No seleccionado -" ';
		$xml .= ' codigo="-1" ';
		$xml .= "/>\n";
		while (!$this->QGeneral->EOF) {
			$xml .= '<item ';
			$xml .= ' parroquia="'.trim($this->QGeneral->fieldget('parroquia')).'" ';
			$xml .= ' codigo="'.trim($this->QGeneral->fieldget('codigo')).'" ';
			$xml .= "/>\n";
			$this->QGeneral->next();
		}
		$xml .= "</lista>";
		return $xml;
	}
	function gruposTiposUso() {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>
				<lista>\n';
		$consulta = "select par_valor
					from cat_parametros
					where par_grupo = 'TIPO_CONCESION'";
		$this->QGeneral->setSQL($consulta);
		$this->QGeneral->refresh();
		$this->QGeneral->first();
		$xml .= '<item ';
		$xml .= ' valor="-1" ';
		$xml .= ' descripcion="- No seleccionado -" ';
		$xml .= "/>\n";
		while (!$this->QGeneral->EOF) {
			list($descripcion, $valor) = explode(";", trim($this->QGeneral->fieldget('par_valor')));
			$xml .= '<item ';
			$xml .= ' valor="'.$valor.'" ';
			$xml .= ' descripcion="'.$descripcion.'"';
			$xml .= "/>\n";
			$this->QGeneral->next();
		}
		$xml .= "</lista>";
		return $xml;
	}
	function contarRegistros() {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$consulta = "select count(fic_ficha.fic_id) as n_registros
					from fic_ficha
					where fic_proceso >= 0";
		$this->QGeneral->setSQL($consulta);
		$this->QGeneral->refresh();
		$this->QGeneral->first();
        if($this->QGeneral->RecordCount != 0) {
			$xml .= "<lista>\n";
			while (!$this->QGeneral->EOF) {
				$xml .= '<item ';
				$xml .= 'n_registros="'.trim($this->QGeneral->fieldget('n_registros')).'" ';
				$xml .= "/>\n";
				$this->QGeneral->next();
			}
			$xml .= "</lista>";
		}else{
		   $xml .= '<mensaje>No se encontraron elementos</mensaje>';
		}
		return $xml;
	}
	function presentarInfo() {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$consulta = "select
						fic_ficha.fic_id as fic_id,
						fic_ficha.fic_formulario as fic_formulario,
						fic_ficha.fic_fecha_toma as fic_fecha_toma,
						fic_ficha.fic_fecha_autor_ini as fic_fecha_autor_ini,
						fic_ficha.fic_proceso as fic_proceso,
						provincia.provincia as provincia,
						canton.canton as canton,
						parroquia.parroquia as parroquia,
						sistema_hidrografico.sistema_hidrografico as sistema_hidrografico,
						cuenca_hidrografica.cuenca_hidrografica as cuenca_hidrografica,
						subcuenca_hidrografica.subcuenca_hidrografica as subcuenca_hidrografica,
						sector_microcuenca.sector_microcuenca as sector_microcuenca,
						fic_ficha.fic_fecha_autor_ini as fic_fecha_autor_ini,
						fic_ficha.fic_tarifa_anual as tarifa_anual,
						fic_ficha.fic_fecha_pago as fecha_pago,
						fic_ficha.fic_fecha_haspag as hasta_cuando,
						fic_ficha.fic_longitud as longitud,
						fic_ficha.fic_latitud as latitud,
						fic_concesionario.cor_autor_act_nombre as concesionario_actual,
						fic_uso.tipo_uso as tipo_uso,
						fic_responsable.resp_nombre as resp_nombre,
						caudal_autorizado.caudal_autorizado as caudal_autorizado
					from 
					("; 					
		if(isset($_REQUEST["ubicacion"])){
			if(isset($_REQUEST["tipo_uso"])){
				$consulta .= "
								select fic_ficha.* 
								from
								fic_ficha,
								fic_valor,
								fic_dpa
								where
								fic_valor.fic_id = fic_ficha.fic_id
								and fic_dpa.dpa_id = fic_ficha.dpa_id
								and fic_valor.ind_id = ".$_REQUEST["tipo_uso"]."
								and fic_valor.val_valor_cadena = '1'
								and fic_dpa.dpa_id like '".$_REQUEST["ubicacion"]."%'
							"; 
			}else{
				$consulta .= "
								select fic_ficha.* 
								from
								fic_ficha,
								fic_dpa
								where
								fic_dpa.dpa_id = fic_ficha.dpa_id
								and fic_dpa.dpa_id like '".$_REQUEST["ubicacion"]."%'
							"; 
			}
		}else{
			if(isset($_REQUEST["tipo_uso"])){
				$consulta .= "
								select fic_ficha.* 
								from
								fic_ficha,
								fic_valor
								where
								fic_valor.fic_id = fic_ficha.fic_id
								and fic_valor.val_valor_cadena = '1'
								and fic_valor.ind_id = ".$_REQUEST["tipo_uso"]."
							"; 
			}else{
				$consulta .= "
								select fic_ficha.* 
								from fic_ficha
							"; 
			}
		}
		$consulta .= "
					) as fic_ficha
					left join fic_concesionario fic_concesionario on fic_concesionario.cor_id = fic_ficha.cor_id
					left join fic_responsable fic_responsable on fic_responsable.resp_id = fic_ficha.resp_id
					left join \"fic_cuadal_DPA_uso\" fic_uso on fic_uso.fic_id = fic_ficha.fic_id

					left join
					(
						select fic_ficha.fic_id as fic_id, provincia.dpa_descripcion as provincia
						from
						fic_ficha,
						fic_dpa provincia,
						fic_dpa parroquia
						where
						provincia.dpa_id = substr(parroquia.dpa_id, 1, 2)
						and parroquia.dpa_id = fic_ficha.dpa_id
					) as provincia
					on fic_ficha.fic_id = provincia.fic_id
					left join
					(
						select fic_ficha.fic_id as fic_id, canton.dpa_descripcion as canton
						from
						fic_ficha,
						fic_dpa canton,
						fic_dpa parroquia
						where
						canton.dpa_id = substr(parroquia.dpa_id, 1, 4)
						and parroquia.dpa_id = fic_ficha.dpa_id
					) as canton
					on fic_ficha.fic_id = canton.fic_id
					left join
					(
						select fic_ficha.fic_id as fic_id, dpa_descripcion as parroquia
						from
						fic_ficha,
						fic_dpa
						where
						fic_dpa.dpa_id = fic_ficha.dpa_id
					) as parroquia
					on fic_ficha.fic_id = parroquia.fic_id
					left join
					(
						select fic_ficha.fic_id as fic_id, sistema_hidrografico.hid_nombre as sistema_hidrografico
						from
						fic_ficha,
						fic_hidrograficas sistema_hidrografico,
						fic_hidrograficas sector_microcuenca
						where
						sistema_hidrografico.hid_id = substr(sector_microcuenca.hid_id, 1, 2)
						and sector_microcuenca.hid_id = fic_ficha.hid_id
					) as sistema_hidrografico
					on fic_ficha.fic_id = sistema_hidrografico.fic_id
					left join
					(
						select fic_ficha.fic_id as fic_id, cuenca_hidrografica.hid_nombre as cuenca_hidrografica
						from
						fic_ficha,
						fic_hidrograficas cuenca_hidrografica,
						fic_hidrograficas sector_microcuenca
						where
						cuenca_hidrografica.hid_id = substr(sector_microcuenca.hid_id, 1, 4)
						and sector_microcuenca.hid_id = fic_ficha.hid_id
					) as cuenca_hidrografica
					on fic_ficha.fic_id = cuenca_hidrografica.fic_id
					left join
					(
						select fic_ficha.fic_id as fic_id, subcuenca_hidrografica.hid_nombre as subcuenca_hidrografica
						from
						fic_ficha,
						fic_hidrograficas subcuenca_hidrografica,
						fic_hidrograficas sector_microcuenca
						where
						subcuenca_hidrografica.hid_id = substr(sector_microcuenca.hid_id, 1, 6)
						and sector_microcuenca.hid_id = fic_ficha.hid_id
					) as subcuenca_hidrografica
					on fic_ficha.fic_id = subcuenca_hidrografica.fic_id
					left join
					(
						select fic_ficha.fic_id as fic_id, hid_nombre as sector_microcuenca
						from
						fic_ficha,
						fic_hidrograficas sector_microcuenca
						where
						sector_microcuenca.hid_id = fic_ficha.hid_id
					) as sector_microcuenca
					on fic_ficha.fic_id = sector_microcuenca.fic_id
					left join (
						SELECT 
							fic_ficha.fic_id, 
							(SELECT MAX (val_valor_cadena) FROM fic_valor a WHERE val_valor_cadena <> '0' AND a.ind_id IN (39,43,63,66,74,79,95,103,113) AND a.fic_id = fic_ficha.fic_id) 
							AS caudal_autorizado,
							fic_fecha_autor_ini
						FROM fic_ficha
					) as caudal_autorizado
					on fic_ficha.fic_id = caudal_autorizado.fic_id
					where
						fic_ficha.fic_longitud <> 0
						and fic_ficha.fic_latitud <> 0
					";
			if(isset($_REQUEST["busqueda"])){
				if(isset($_REQUEST["buscar_por"])){
					if($_REQUEST["buscar_por"]=="proceso"){
						$consulta .= "
										and fic_proceso >= 0
										and
										fic_ficha.fic_proceso = ".$_REQUEST["busqueda"]."
									"; 
					}
					if($_REQUEST["buscar_por"]=="concesionario"){
						$consulta .= "
										and fic_proceso >= 0
										and
										fic_concesionario.cor_autor_act_nombre like '%".$_REQUEST["busqueda"]."%'
									"; 
					}
					if($_REQUEST["buscar_por"]=="responsable"){
						$consulta .= "
										and fic_proceso >= 0
										and
										fic_responsable.resp_nombre like '%".$_REQUEST["busqueda"]."%'
									"; 
					}
					if($_REQUEST["buscar_por"]=="codigo"){
						$consulta .= "
										and
										fic_ficha.fic_id = ".$_REQUEST["busqueda"]."
									"; 
					}
				}
			}
		$this->QGeneral->setSQL($consulta);
		$this->QGeneral->refresh();
		$this->QGeneral->first();
        if($this->QGeneral->RecordCount != 0) {
			$xml .= "<lista>\n";
			while (!$this->QGeneral->EOF) {
				/*$xml .= '<item ';
				$xml .= 'fic_id="'.trim($this->QGeneral->fieldget('fic_id')).'" ';
				$xml .= 'formulario="'.trim($this->QGeneral->fieldget('fic_formulario')).'" ';
				$xml .= 'fecha_toma_datos="'.trim($this->QGeneral->fieldget('fic_fecha_toma')).'" ';
				$xml .= 'provincia="'.trim($this->QGeneral->fieldget('provincia')).'" ';
				$xml .= 'canton="'.trim($this->QGeneral->fieldget('canton')).'" ';
				$xml .= 'parroquia="'.trim($this->QGeneral->fieldget('parroquia')).'" ';
				$xml .= 'sistema_hidrografico="'.trim($this->QGeneral->fieldget('sistema_hidrografico')).'" ';
				$xml .= 'cuenca_hidrografica="'.trim($this->QGeneral->fieldget('cuenca_hidrografica')).'" ';
				$xml .= 'subcuenca_hidrografica="'.trim($this->QGeneral->fieldget('subcuenca_hidrografica')).'" ';
				$xml .= 'sector_microcuenca="'.trim($this->QGeneral->fieldget('sector_microcuenca')).'" ';
				$xml .= 'proceso="'.trim($this->QGeneral->fieldget('fic_proceso')).'" ';
				$xml .= 'tarifa_anual="'.trim($this->QGeneral->fieldget('tarifa_anual')).'" ';
				$xml .= 'fecha_pago="'.trim($this->QGeneral->fieldget('fecha_pago')).'" ';
				$xml .= 'hasta_cuando="'.trim($this->QGeneral->fieldget('hasta_cuando')).'" ';
				$xml .= 'longitud="'.trim($this->QGeneral->fieldget('longitud')).'" ';
				$xml .= 'latitud="'.trim($this->QGeneral->fieldget('latitud')).'" ';
				$xml .= 'responsable_datos="'.trim($this->QGeneral->fieldget('resp_nombre')).'" ';
				$xml .= 'concesionario_actual="'.trim($this->QGeneral->fieldget('concesionario_actual')).'" ';
				$xml .= "/>\n";*/

				$xml .= '<item>';
				$xml .= '<fic_id>'.trim($this->QGeneral->fieldget('fic_id')).'</fic_id>';
				$xml .= '<formulario>'.trim($this->QGeneral->fieldget('fic_formulario')).'</formulario>';
				$xml .= '<fecha_toma_datos>'.trim($this->QGeneral->fieldget('fic_fecha_toma')).'</fecha_toma_datos>';
				$xml .= '<fecha_inicio>'.trim($this->QGeneral->fieldget('fic_fecha_autor_ini')).'</fecha_inicio>';
				$xml .= '<provincia>'.trim($this->QGeneral->fieldget('provincia')).'</provincia>';
				$xml .= '<canton>'.trim($this->QGeneral->fieldget('canton')).'</canton>';
				$xml .= '<parroquia>'.trim($this->QGeneral->fieldget('parroquia')).'</parroquia>';
				$xml .= '<sistema_hidrografico>'.trim($this->QGeneral->fieldget('sistema_hidrografico')).'</sistema_hidrografico>';
				$xml .= '<cuenca_hidrografica>'.trim($this->QGeneral->fieldget('cuenca_hidrografica')).'</cuenca_hidrografica>';
				$xml .= '<subcuenca_hidrografica>'.trim($this->QGeneral->fieldget('subcuenca_hidrografica')).'</subcuenca_hidrografica>';
				$xml .= '<sector_microcuenca>'.trim($this->QGeneral->fieldget('sector_microcuenca')).'</sector_microcuenca>';
				$xml .= '<proceso>'.trim($this->QGeneral->fieldget('fic_proceso')).'</proceso>';
				$xml .= '<tarifa_anual>'.trim($this->QGeneral->fieldget('tarifa_anual')).'</tarifa_anual>';
				$xml .= '<fecha_pago>'.trim($this->QGeneral->fieldget('fecha_pago')).'</fecha_pago>';
				$xml .= '<hasta_cuando>'.trim($this->QGeneral->fieldget('hasta_cuando')).'</hasta_cuando>';
				$xml .= '<longitud>'.trim($this->QGeneral->fieldget('longitud')).'</longitud>';
				$xml .= '<latitud>'.trim($this->QGeneral->fieldget('latitud')).'</latitud>';
				$xml .= '<responsable_datos>'.trim($this->QGeneral->fieldget('resp_nombre')).'</responsable_datos>';
				$xml .= '<concesionario_actual>'.trim($this->QGeneral->fieldget('concesionario_actual')).'</concesionario_actual>';
				$xml .= '<tipo_uso>'.trim($this->QGeneral->fieldget('tipo_uso')).'</tipo_uso>';
				$xml .= '<caudal_autorizado>'.trim($this->QGeneral->fieldget('caudal_autorizado')).'</caudal_autorizado>';
				$xml .= "</item>\n";
				$this->QGeneral->next();
			}
			$xml .= "</lista>";

		}else{
		   $xml .= '<mensaje>No se encontraron elementos</mensaje>';
		}
		return $xml;
	}

	function PGeneralShow($sender, $params)
	{
		if(isset($_REQUEST["funcion"]))
		{
			die($this->$_REQUEST["funcion"]());
		}
		else
		{
			die("");
		}
	}
}




global $application;

global $PGeneral;

//Crea el formulario
$PGeneral=new PGeneral($application);

//Lee del archivo de recursos
$PGeneral->loadResource(__FILE__);

//Muestra el formulario
$PGeneral->show();

?>