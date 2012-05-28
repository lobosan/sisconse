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
class PCatAlias extends Page
{
       public $TTabla = null;
       public $QGeneral = null;

/*******************************************************************************/

/*************************  Actualizacion de Ubicaciones  **********************/
/*******************************************************************************/

       function presentarAtributo() {
          $xml = '<?xml version="1.0" encoding="UTF-8" ?>
                  <lista>';
          if(isset($_REQUEST["atributo"]) && isset($_REQUEST["valor"]) && isset($_REQUEST["cobertura"])) {
            $consulta = "SELECT atributo, alias
                         FROM cat_alias
                         WHERE atributo = '".$_REQUEST['atributo']."' and cobertura = '".$_REQUEST['cobertura']."'";
            $this->QGeneral->setSQL($consulta);
            $this->QGeneral->refresh();
            $this->QGeneral->first();
            if($this->QGeneral->RecordCount != 0) {

               while (!$this->QGeneral->EOF) {
                  $xml .= "<item elemento='".trim($this->QGeneral->fieldget("alias"))."' valor='".$_REQUEST['valor']."'/>";
                  /*$xml .= "<item>
                           <elemento>".trim($this->QGeneral->fieldget("alias"))."</elemento>
                           <valor>".$_REQUEST['valor']."</valor>
                           </item>";*/
                  $this->QGeneral->next();
               }
            }else{
               $xml .= '<item elemento="'.$_REQUEST['atributo'].'" valor="'.$_REQUEST['valor'].'"/>';
               /*$xml .= "<item>
                        <elemento>".$_REQUEST['atributo']."</elemento>
                        <valor>".$_REQUEST['valor']."</valor>
                        </item>";*/
            }
          }
          $xml .= "</lista>";
          return $xml;
       }
       function PCatAliasShow($sender, $params)
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

global $PCatAlias;

//Crea el formulario
$PCatAlias=new PCatAlias($application);

//Lee del archivo de recursos
$PCatAlias->loadResource(__FILE__);

//Muestra el formulario
$PCatAlias->show();

?>