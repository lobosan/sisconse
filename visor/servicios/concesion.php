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
class PConcesion extends Page
{
       public $TTabla = null;
       public $QGeneral = null;

/*******************************************************************************/

/*************************  Actualizacion de Ubicaciones  **********************/
/*******************************************************************************/

       function presentarInfo() {


          $xml .= "<lista>\n";

$uso="";
if(isset($_REQUEST['fic_id'])) {
$consulta = "select
							fic_ficha.fic_id as fic_id,
							fic_ficha.fic_formulario as fic_formulario,
							fic_ficha.fic_fecha_toma as fic_fecha_toma,
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
							caudal_medido.caudal_medido as caudal_domestico_medido,
							fic_concesionario.cor_autor_act_nombre as concesionario_actual,
							fic_responsable.resp_nombre as resp_nombre,
							observaciones.val_valor_cadena as observaciones
						from fic_ficha fic_ficha
						left join fic_concesionario fic_concesionario on fic_concesionario.cor_id = fic_ficha.cor_id
						left join fic_responsable fic_responsable on fic_responsable.resp_id = fic_ficha.resp_id

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
						left join
						(
							select val_id, ind_id, fic_id, val_valor_cadena
							from fic_valor
							where ind_id=207
						) as observaciones
						on fic_ficha.fic_id = observaciones.fic_id
						left join
						(
							select max(cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '0','g'),',', '.') as numeric)) as caudal_medido, fic_id
							from 
							fic_indicador, 
							fic_valor
							where nombre_del_indicador like 'caudal_medido%'
							and fic_indicador.ind_id = fic_valor.ind_id
							group by fic_valor.fic_id
						) as caudal_medido
						on fic_ficha.fic_id = caudal_medido.fic_id
						   WHERE fic_ficha.fic_id = " . $_REQUEST['fic_id'];
}else{
$consulta = "select
							fic_ficha.fic_id as fic_id,
							fic_ficha.fic_formulario as fic_formulario,
							fic_ficha.fic_fecha_toma as fic_fecha_toma,
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
							caudal_medido.caudal_medido as caudal_domestico_medido,
							fic_concesionario.cor_autor_act_nombre as concesionario_actual,
							fic_responsable.resp_nombre as resp_nombre,
							observaciones.val_valor_cadena as observaciones
						from fic_ficha fic_ficha
						left join fic_concesionario fic_concesionario on fic_concesionario.cor_id = fic_ficha.cor_id
						left join fic_responsable fic_responsable on fic_responsable.resp_id = fic_ficha.resp_id

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
						left join
						(
							select val_id, ind_id, fic_id, val_valor_cadena
							from fic_valor
							where ind_id=207
						) as observaciones
						on fic_ficha.fic_id = observaciones.fic_id
						left join
						(
							select max(cast(replace(regexp_replace(val_valor_cadena, '[a-z,A-Z,[:space:]]', '0','g'),',', '.') as numeric)) as caudal_medido, fic_id
							from 
							fic_indicador, 
							fic_valor
							where nombre_del_indicador like 'caudal_medido%'
							and fic_indicador.ind_id = fic_valor.ind_id
							group by fic_valor.fic_id
						) as caudal_medido
						on fic_ficha.fic_id = caudal_medido.fic_id";

}

          $this->QGeneral->setSQL($consulta);
          $this->QGeneral->refresh();
          $this->QGeneral->first();
          while (!$this->QGeneral->EOF) {

            $xml .= '<item ';
			$xml .= 'formulario="'.trim($this->QGeneral->fieldget('fic_formulario')).'" ';
            $xml .= 'responsable_datos="'.trim($this->QGeneral->fieldget('resp_nombre')).'" ';
            $xml .= 'fecha_toma_datos="'.trim($this->QGeneral->fieldget('fic_fecha_toma')).'" ';
            $xml .= 'concesionario_actual="'.trim($this->QGeneral->fieldget('concesionario_actual')).'" ';
            $xml .= 'provincia="'.trim($this->QGeneral->fieldget('provincia')).'" ';
            $xml .= 'canton="'.trim($this->QGeneral->fieldget('canton')).'" ';
            $xml .= 'parroquia="'.trim($this->QGeneral->fieldget('parroquia')).'" ';
            $xml .= 'sistema_hidrografico="'.trim($this->QGeneral->fieldget('sistema_hidrografico')).'" ';
            $xml .= 'cuenca_hidrografica="'.trim($this->QGeneral->fieldget('cuenca_hidrografica')).'" ';
            $xml .= 'subcuenca_hidrografica="'.trim($this->QGeneral->fieldget('subcuenca_hidrografica')).'" ';
            $xml .= 'sector_microcuenca="'.trim($this->QGeneral->fieldget('sector_microcuenca')).'" ';
            $xml .= 'proceso="'.trim($this->QGeneral->fieldget('fic_proceso')).'" ';
            $xml .= 'caudal_domestico_medido="'.trim($this->QGeneral->fieldget('caudal_domestico_medido')).'" ';
            $xml .= 'tarifa_anual="'.trim($this->QGeneral->fieldget('tarifa_anual')).'" ';
            $xml .= 'fecha_pago="'.trim($this->QGeneral->fieldget('fecha_pago')).'" ';
            $xml .= 'hasta_cuando="'.trim($this->QGeneral->fieldget('hasta_cuando')).'" ';
            $xml .= 'observaciones="'.trim($this->QGeneral->fieldget('observaciones')).'" ';

			$xml .= "/>\n";


            $this->QGeneral->next();
          }
          $xml .= "</lista>";
		  header("Content-type: text/xml");
		  echo '<?xml version="1.0"?>';
/*		  $xml = "<?xml version='1.0' encoding='utf-8'?>";  */

		 echo $xml;
          //return $xml;
       }

       function PConcesionShow($sender, $params)
       {
          if(isset($_REQUEST["funcion"]))
          {
             //die($this->$_REQUEST["funcion"]());
			 die("asdf");
          }
          else
          {
             die("asdf");
          }
       }
}




global $application;

global $PConcesion;

//Crea el formulario
$PConcesion=new PConcesion($application);

//Lee del archivo de recursos
$PConcesion->loadResource(__FILE__);

//Muestra el formulario
$PConcesion->presentarInfo();
//print $globalXml;

?>