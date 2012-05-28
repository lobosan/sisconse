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

//Definicin de clase
class PConfigXml extends Page
{
	public $QGeneral = null;
	function PConfigXmlShow($sender, $params){
		if(isset($_REQUEST['cod'])){
			$codPerfil = $_REQUEST['cod'];
		}else{
			$codPerfil = 1;
		}
		$Consulta = 'SELECT
					cop_xml1
					FROM cop_perfil
					WHERE
					cop_codigo='.$codPerfil;
		$this->QGeneral->setSQL($Consulta);
		$this->QGeneral->refresh();
		if ($this->QGeneral->RecordCount > 0){
			$xml=trim($this->QGeneral->fieldget("cop_xml1"));
		}
		die($xml);
	}
}

global $application;

global $PConfigXml;

//Crea el formulario
$PConfigXml=new PConfigXml($application);

//Lee del archivo de recursos
$PConfigXml->loadResource(__FILE__);

//Muestra el formulario
$PConfigXml->show();

?>