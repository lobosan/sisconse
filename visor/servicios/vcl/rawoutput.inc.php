<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("classes.inc.php");
        use_unit("controls.inc.php");

        //Class definition
        class RawOutput extends GraphicControl
        {
            protected $_value = '';

            function __construct($aowner=null)
            {
                parent::__construct($aowner);

                $this->Width = 75;
                $this->Height = 25;
            }

            function dumpContents()
            {
                print( $this->_value );
            }

            function getValue()
            {
                return $this->_value;
            }

            function setValue( $value )
            {
                $this->_value = $value;
            }

            function defaultValue()
            {
                return '';
            }
        }

?>
