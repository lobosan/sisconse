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


   function encrypt($target, $targetHashed = NULL){
      $saltLength = 10;
      $hashingMethod = 'sha1';

      //If no password to validate
      if ($targetHashed == NULL){
         $randomSalt = '';

         //Build 16 character random salt
         for ($i = 0; $i<16; $i++){
            $randNum = rand(33, 255); //Get random number between 33 - 255
            $randomSalt .= chr($randNum); //Get ascii character based on random number
         }
         $randomSalt = hash($hashingMethod, $randomSalt); //hash the random salt
      }else{ //Password to validate
         $randomSalt = $targetHashed; //set random salt to hashed password to be checked
      }

      //This code makes sure at least 10 characters from the original password remain in the hashed result.  Prevents from situations where $saltLength is set
      //too long and entire password is cut out, leaving only the salt in which case the result would always be true.
      if($saltLength > (strlen($randomSalt) - 10)){
         $saltLength = (strlen($randomSalt) - 10);
      }

      //$hLPosition is used to determine what part of the salt will actually be used
      $hLPosition = strlen($target); //Set hLPosition to length of password to be encrypted

      while ($hLPosition > $saltLength){ //while length of password is greater than length of salt
         $hNumber = substr($hLPosition, -1); //grabs last number of hLPosition (Ex. If hLPosition = 19 then hNumber = 9)
         $hLPosition = $hLPosition * ($hNumber/10); //resets hLPosition
      }

      $hLPosition = (integer)$hLPosition; //Cast decimal to integer (2.4 becomes 2)
      $hRPosition = $saltLength - $hLPosition; //Determines the start position for the rest of the salt that will be used

      $hFSalt = substr($randomSalt, 0, $hLPosition); //Set the hFSalt to a substring of the actual salt (begining)
      $hLSalt = substr($randomSalt, -$hRPosition, $hRPosition); //Set hLSalt to another substring of the actual salt (end)

      $hPassHash = hash($hashingMethod, ($hLSalt . $target . $hFSalt)); //Hash the two salt substrings and password together

      if($saltLength != 0){
         if($hRPosition == 0){
            $hPassHash = substr($hPassHash, $hLPosition);
         }else{
            $hPassHash = substr($hPassHash, $hLPosition, -$hRPosition);
         }
      }

      return $hFSalt . $hPassHash . $hLSalt;
   }

//Definicin de clase
class PLogin extends Page
{
       public $QUsuarios = null;

	   function iniciarSesion()
       {
          if(isset($_REQUEST["usuario"]) && isset($_REQUEST["password"]))
          {
             $usuario = $_REQUEST["usuario"];
			  if($_REQUEST["usuario"] != ''){
				 $Consulta = "SELECT
						password
						FROM
						qo_members
						WHERE
						cedula = '".$_REQUEST["usuario"]."'";

				$this->QUsuarios->setSQL($Consulta);
				$this->QUsuarios->refresh();
				if ($this->QUsuarios->RecordCount > 0)
				{
					$password_original=trim($this->QUsuarios->fieldget("password"));
				}
			  }
             $password = $_REQUEST["password"];
			 $password = encrypt($password, $password_original);
             /* Sesion como invitado */
             $_SESSION["usu_codigo"]=-999;
             $Consulta = 'SELECT id, first_name, last_name, email_address, password, locale, 
							active, id_dcz, cedula
							FROM qo_members
							where password = \''.$password.'\'
							and cedula= \''.trim($usuario).'\' ';
             $this->QUsuarios->setSQL($Consulta);
             $this->QUsuarios->refresh();
             if ($this->QUsuarios->RecordCount <= 0)
             {
                  // Usuario no registrado
                  unset($_POST["usuario"]);
                  unset($_POST["password"]);
                  // Enviar "Usuario no registrado"
                  $resultado="no";
             }
             else
             {
                  // Iniciar sesion
                  $_SESSION["cedula"]=trim($this->QUsuarios->fieldget("cedula"));
				  //$_SESSION["per_codigo"]=trim($this->QUsuarios->fieldget("per_codigo"));
                  // Enviar "Usuario registrado"
                  $resultado="si";
             }
             // Sacar el XML
             $xml = "<mensaje>".$resultado."</mensaje>";
          }
          else
          {
             $xml = "<mensaje>no</mensaje>";
          }
          return $xml;
       }

       function comprobarSesion()
       {
          if(isset($_SESSION["usu_codigo"]))
          {
              $resultado="con_sesion";
          }
          else
          {
              $resultado="sin_sesion";
          }
          $xml = "<mensaje>".$resultado."</mensaje>";
          return $xml;
       }

       function PLoginShow($sender, $params)
       {
          if(isset($_POST["funcion"]) || isset($_GET["funcion"]))
          {
             if(isset($_GET["funcion"]))
             {
                die($this->$_GET["funcion"]());
             }
             else
             {
                die($this->$_POST["funcion"]());
             }
          }
          else
          {
             die("");
          }
       }
}

global $application;

global $PLogin;

//Crea el formulario
$PLogin=new PLogin($application);

//Lee del archivo de recursos
$PLogin->loadResource(__FILE__);

//Muestra el formulario
$PLogin->show();

?>