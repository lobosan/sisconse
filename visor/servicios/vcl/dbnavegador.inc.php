<?php
require_once("vcl/vcl.inc.php");
//Includes
use_unit("db.inc.php");
use_unit("extctrls.inc.php");

//Class definition
class DBNavegador extends CustomControl
{
    protected $_datasource = null;
    protected $_controlesAjax = array();

    protected $_onAjaxNuevoClic = null;
    protected $_onAjaxEditarClic = null;
    protected $_onAjaxEliminarClic = null;
    protected $_onAjaxAceptarClic = null;
    protected $_onAjaxCancelarClic = null;

    protected $_jsOnNuevoClic = null;
    protected $_jsOnEditarClic = null;
    protected $_jsOnEliminarClic = null;
    protected $_jsOnAceptarClic = null;
    protected $_jsOnCancelarClic = null;

    function __construct($aowner = null)
    {
        parent::__construct($aowner);

        $this->Width = 300;
        $this->Height = 30;
        $this->_controlesAjax = array();
    }

    function dumpContents()
    {
       echo "<table width=\"100\">";
       echo "<tr>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "</tr>";
       echo "<tr>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "</tr>";
       echo "<tr>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "</tr>";
       echo "<tr>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "<td><div onClick>Nuevo</div></td>";
       echo "</tr>";
       echo "</table>";
    }

    function dumpJsEvents()
    {
       parent::dumpJsEvents();
       $this->dumpJSEvent($this->_jsOnNuevoClic);
    }

    function getDataSource() { return $this->_datasource; }
    function setDataSource($value) { $this->_datasource=$this->fixupProperty($value); }
}

?>