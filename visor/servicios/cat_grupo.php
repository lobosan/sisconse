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

//Definición de clase
class PCatGrupo extends Page
{
	public $TTabla = null;
	public $QGeneral = null;

	//
	// Listado de Grupos y Objetos
	//
	
	
	// Listar todos los objetos
	function listarObjetos() {
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$consulta = "SELECT
					gru_secuencial,
					gru_codigo,
					gru_nombre,
					gru_descripcion,
					gru_referencia,
					gru_es_objeto,
					gru_cobertura,
					gru_tipo_objeto, 
					gru_proyeccion, 
					gru_srs
					FROM cat_grupo";
		$this->QGeneral->setSQL($consulta);
		$this->QGeneral->refresh();
		$this->QGeneral->first();
		if($this->QGeneral->RecordCount != 0) {
			$xml .= '<lista>';
			while (!$this->QGeneral->EOF) {
				$xml .= "<item>
							<secuencial>".trim($this->QGeneral->fieldget("gru_secuencial"))."</secuencial>
							<codigo>".trim($this->QGeneral->fieldget("gru_codigo"))."</codigo>
							<nombre>".trim($this->QGeneral->fieldget("gru_nombre"))."</nombre>
							<descripcion>".trim($this->QGeneral->fieldget("gru_descripcion"))."</descripcion>
							<referencia>".trim($this->QGeneral->fieldget("gru_referencia"))."</referencia>
							<es_objeto>".trim($this->QGeneral->fieldget("gru_es_objeto"))."</es_objeto>
							<cobertura>".trim($this->QGeneral->fieldget("gru_cobertura"))."</cobertura>
							<tipo_objeto>".trim($this->QGeneral->fieldget("gru_tipo_objeto"))."</tipo_objeto>
							<proyeccion>".trim($this->QGeneral->fieldget("gru_proyeccion"))."</proyeccion>
							<srs>".trim($this->QGeneral->fieldget("gru_srs"))."</srs>
						</item>";
				$this->QGeneral->next();
			}
			$xml .= "</lista>";
		}else{
		   $xml .= '<mensaje>Error: No existen elementos<mensaje/>';
		}
		return $xml;
	}
	
	
	// Listar por tipo de objeto
	function listarTipoObjeto() {
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$consulta = "SELECT
					gru_tipo_objeto
					FROM cat_grupo
					GROUP BY gru_tipo_objeto
					ORDER BY gru_tipo_objeto";
		$this->QGeneral->setSQL($consulta);
		$this->QGeneral->refresh();
		$this->QGeneral->first();
		if($this->QGeneral->RecordCount != 0) {
			$xml .= '<lista>';
			while (!$this->QGeneral->EOF) {
				$xml .= "<item>
							<tipo_objeto>".trim($this->QGeneral->fieldget("gru_tipo_objeto"))."</tipo_objeto>
						</item>";
				$this->QGeneral->next();
			}
			$xml .= "</lista>";
		}else{
		   $xml .= '<mensaje>Error: No existen elementos<mensaje/>';
		}
		return $xml;
	}
	
	//
	// Edicion
	//
	
	
	// Grabar
	function grabar() {
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		if(isset($_POST["secuencial"])) {
			try {
				if($_POST["secuencial"]=="-9") {
					$this->TTabla->cancel();
					$this->TTabla->append();
					$this->QGeneral->setSQL('Select max(gru_secuencial) as maximo from cat_grupo');
					$this->QGeneral->refresh();
					$this->QGeneral->first();
					$cod = $this->QGeneral->fieldget('maximo') + 1;
					$this->TTabla->fieldset('gru_secuencial', $cod);
					$xml = "<secuencial>".$cod."</secuencial>";
				}
				else {
					$this->TTabla->close();
					$this->TTabla->setFilter('gru_secuencial = '.$_POST["secuencial"]);
					$this->TTabla->open();
					$xml = "<secuencial>".$_POST["secuencial"]."</secuencial>";
					$xml = "<mensaje>Datos guardados</mensaje>";
				}
				if(isset($_POST["codigo"]))			{ $this->TTabla->fieldset('gru_codigo',			$_POST["codigo"]); }
				if(isset($_POST["nombre"]))			{ $this->TTabla->fieldset('gru_nombre',			$_POST["nombre"]); }
				if(isset($_POST["descripcion"]))	{ $this->TTabla->fieldset('gru_descripcion',	$_POST["descripcion"]); }
				if(isset($_POST["referencia"]))		{ $this->TTabla->fieldset('gru_referencia',		$_POST["referencia"]); }
				if(isset($_POST["es_objeto"]))		{ $this->TTabla->fieldset('gru_es_objeto',		$_POST["es_objeto"]); }
				if(isset($_POST["cobertura"]))		{ $this->TTabla->fieldset('gru_cobertura',		$_POST["cobertura"]); }
				if(isset($_POST["tipo_objeto"]))	{ $this->TTabla->fieldset('gru_tipo_objeto',	$_POST["tipo_objeto"]); }
				if(isset($_POST["proyeccion"]))		{ $this->TTabla->fieldset('gru_proyeccion',		$_POST["proyeccion"]); }
				if(isset($_POST["srs"]))			{ $this->TTabla->fieldset('gru_srs',			$_POST["srs"]); }
				
				$this->TTabla->post();
			}
			catch (Exception $e) {
				$xml = "<mensaje>Ocurrió un error al grabar el registro. Revise la conexión con la base de datos o los datos enviados y vuelva a intentar.</mensaje>";
			}
		}
		return $xml;
	}
	
	
	// Eliminar
	function eliminar() {
		if(isset($_POST["secuencial"]) && $_POST["secuencial"]!="-9") {
			$this->TTabla->setFilter('gru_secuencial = '.$_POST["secuencial"]);
			$this->TTabla->refresh();
			$this->TTabla->delete();
			$this->TTabla->refresh();
			$xml = "<mensaje>Registro eliminado</mensaje>";
		}
		return $xml;
	}
	
	//
	// Función principal
	//
	
	
	function PCatGrupoShow($sender, $params) {
		if(isset($_REQUEST["funcion"])) {
			die($this->$_REQUEST["funcion"]());
		} else {
			die("");
		}
	}
}

global $application;

global $PCatGrupo;

//Crea el formulario
$PCatGrupo=new PCatGrupo($application);

//Lee del archivo de recursos
$PCatGrupo->loadResource(__FILE__);

//Muestra el formulario
$PCatGrupo->show();

?>