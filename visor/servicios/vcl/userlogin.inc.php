<?php
//Includes
require_once("vcl/vcl.inc.php");
use_unit("classes.inc.php");
use_unit("controls.inc.php");
use_unit("dbtables.inc.php");

//Class definition
class UserLogin extends GraphicControl
{
    // Property variables.
    protected $LoginLink = '';
    protected $LogoutLink = '';
    protected $Database;
    protected $UserTable = '';
    protected $CookieName = 'loginid';
    protected $CookieExpirySeconds = '0';

    // Other variables.
    protected $LoggedInUser = false;
    protected $HasCheckedLogin = false;

    function __construct($aowner=null)
    {
        parent::__construct($aowner);

        $this->Width = 100;
        $this->Height = 25;
    }

    function dumpContents()
    {
        if( $this->GetLoggedInUser() === false )
        {
            // User not logged in.
            print( '<a href="' . $this->getLoginLink() . '" title="Login">Login</a>' );
        }
        else
        {
            // User is logged in.
            print( 'Welcome ' . $this->GetLoggedInUser() . '. <a href="' . $this->getLogoutLink() . '" title="Logout">Logout</a>' );
        }
    }

    function loaded()
    {
        parent::loaded();

        $this->setDatabase( $this->Database );
    }

    // User called functions.
    function LoginUser( $username, $password )
    {
        if( !$this->Database )
            throw new Exception( 'Database property not assigned for ' . $this->Name );

        if( !strlen( $this->UserTable ) )
            throw new Exception( 'UserTable property not assigned for '  . $this->Name );

        $query = new Query();
        $query->Database = $this->Database;
        $query->LimitStart = '-1';
        $query->LimitCount = '-1';
        $query->SQL =
            'SELECT * FROM ' . $this->UserTable . ' ' .
            'WHERE Username = ' . $this->Database->Param( 'Username' ) . ' AND Password = ' . $this->Database->Param( 'Password' );
        $query->Params = array( $username, $password );
        $query->open();

        if( $query->RecordCount == 0 )
            return false;

        $query->close();

        $loginid = md5( uniqid( rand(), true ) . time() );

        $sql =
            'UPDATE ' . $this->UserTable . ' ' .
            'SET LoginID = ' . $this->Database->Param( 'LoginID' ) . ' ' .
            'WHERE Username = ' . $this->Database->Param( 'Username' ) . ' AND Password = ' . $this->Database->Param( 'Password' );

        $params = array( $loginid, $username, $password );

        $this->Database->execute( $sql, $params );

        if( $this->getCookieExpirySeconds() == 0 )
            $cookietime = '0';
        else
            $cookietime = time() + $this->getCookieExpirySeconds();

        setcookie( $this->getCookieName(), $loginid, $cookietime );

        return true;
    }

    function LogoutUser()
    {
        if( !$this->Database )
            throw new Exception( 'Database property not assigned for ' . $this->Name );

        if( !strlen( $this->UserTable ) )
            throw new Exception( 'UserTable property not assigned for '  . $this->Name );

        $loginid = $this->GetCookieValue();

        $sql =
            "UPDATE " . $this->UserTable . " SET LoginID = '' " .
            'WHERE LoginID = ' . $this->Database->Param( 'LoginID' );

        $params = array( $loginid );

        $this->Database->execute( $sql, $params );

        setcookie( $this->getCookieName(), '', time() - 3600 );

        return true;
    }

    function GetLoggedInUser()
    {
        $this->checkIfLoggedIn();

        return $this->LoggedInUser;
    }

    // Protected functions.
    protected function checkIfLoggedIn()
    {
        if( $this->HasCheckedLogin )
            return;

        $this->HasCheckedLogin = true;
        $this->LoggedInUser = false;

        if( ( $this->ControlState & csLoading) == csLoading || ( $this->ControlState & csDesigning ) == csDesigning )
            return;

        $loginid = $this->GetCookieValue();

        if( empty( $loginid ) )
            return;

        if( !$this->Database )
            throw new Exception( 'Database property not assigned for ' . $this->Name );

        if( !strlen( $this->UserTable ) )
            throw new Exception( 'UserTable property not assigned for '  . $this->Name );

        $query = new Query();
        $query->Database = $this->Database;
        $query->LimitStart = -1;
        $query->LimitCount = -1;
        $query->SQL =
            'SELECT Username FROM ' . $this->UserTable . ' ' .
            'WHERE LoginID = ' . $this->Database->Param( 'LoginID' );
        $query->Params = array( $loginid );
        $query->open();

        if( $query->RecordCount == 0 )
            return;

        $this->LoggedInUser = $query->Username;

        $query->close();
    }

    protected function GetCookieValue()
    {
        if( array_key_exists( $this->getCookieName(), $_COOKIE ) )
            return $_COOKIE[ $this->getCookieName() ];
        else
            return "";
    }

    // Property functions.
    function getLoginLink()
    {
        return $this->LoginLink;
    }

    function setLoginLink( $value )
    {
        $this->LoginLink = $value;
    }

    function defaultLoginLink()
    {
        return '';
    }

    function getLogoutLink()
    {
        return $this->LogoutLink;
    }

    function setLogoutLink( $value )
    {
        $this->LogoutLink = $value;
    }

    function defaultLogoutLink()
    {
        return '';
    }

    function getDatabase()
    {
        return $this->Database;
    }

    function setDatabase( $value )
    {
        $this->Database = $this->fixupProperty( $value );
    }

    function getUserTable()
    {
        return $this->UserTable;
    }

    function setUserTable( $value )
    {
        $this->UserTable = $value;
    }

    function defaultUserTable()
    {
        return '';
    }

    function getCookieName()
    {
        return $this->CookieName;
    }

    function setCookieName( $value )
    {
        $this->CookieName = $value;
    }

    function defaultCookieName()
    {
        return 'loginid';
    }

    function getCookieExpirySeconds()
    {
        return $this->CookieExpirySeconds;
    }

    function setCookieExpirySeconds( $value )
    {
        $this->CookieExpirySeconds = $value;
    }

    function defaultCookieExpirySeconds()
    {
        return '0';
    }
}
?>
