<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("classes.inc.php");
        use_unit("controls.inc.php");

        //Class definition
        class RawInclude extends GraphicControl
        {
            protected $_include = '';

            function __construct($aowner=null)
            {
                parent::__construct($aowner);

                $this->Width = 100;
                $this->Height = 100;
            }

            function dumpContents()
            {
                if( !empty( $this->_include ) )
                    require_once( $this->_include );
            }

            function getInclude()
            {
                return $this->_include;
            }

            function setInclude( $value )
            {
                $this->_include = $value;
            }

            function defaultInclude()
            {
                return '';
            }
        }

?>
