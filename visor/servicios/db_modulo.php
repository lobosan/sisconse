<?php
require_once("vcl/vcl.inc.php");
require_once("config.php");
//Inclusiones
use_unit("dbtables.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

//Definicin de clase
class PDBModulo extends DataModule
{
   public $Master = null;

   function loaded()
   {
      global $DbHost, $DbUser, $DbPass, $DbName;

      parent::loaded();

      $this->Master->Host = $DbHost;
      $this->Master->UserName = $DbUser;
      $this->Master->UserPassword = $DbPass;
      $this->Master->DatabaseName = $DbName;
      $this->Master->Connected = true;
   }
}

global $application;

global $PDBModulo;

//Crea el formulario
$PDBModulo=new PDBModulo($application);

//Lee del archivo de recursos
$PDBModulo->loadResource(__FILE__);

function modulo_db()
{
   global $PDBModule;

   return $PDBModule;
}
?>