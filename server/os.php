<?php
/*
 * qWikiOffice Desktop 1.0
 * Copyright(c) 2007-2010, Murdock Technologies, Inc.
 * licensing@qwikioffice.com
 *
 * http://www.qwikioffice.com/license
 */

require('kernal.php');

class os extends kernal
{

    /**
     * __construct()
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * init() Initial page load or refresh has occured.
     * Called from index.php.
     *
     * @access public
     */
    public function init()
    {
        // clear the session data
        $this->load('session');
        $this->session->set_data();
    }

    // get the login url

    /**
     * get_login_url()
     *
     * @access public
     */
    public function get_login_url()
    {
        return $this->config->LOGIN_URL;
    } // end get_login_url()

    // get the document root

    /**
     * get_document_root()
     *
     * @access public
     */
    public function get_document_root()
    {
        return $this->config->DOCUMENT_ROOT;
    } // end get_document_root()

    // get directories

    /**
     * get_library_dir()
     *
     * @access public
     */
    public function get_library_dir()
    {
        return $this->config->LIBRARIES_DIR;
    } // end get_library_dir()

    /**
     * get_module_dir()
     *
     * @access public
     */
    public function get_module_dir()
    {
        return $this->config->MODULES_DIR;
    } // end get_module_dir()

    /**
     * get_theme_dir()
     *
     * @access public
     */
    public function get_theme_dir()
    {
        return $this->config->THEMES_DIR;
    } // end get_theme_dir()

    /**
     * get_wallpaper_dir()
     *
     * @access public
     */
    public function get_wallpaper_dir()
    {
        return $this->config->WALLPAPERS_DIR;
    } // end get_wallpaper_dir()

    // session data

    /**
     * session_exists() Checks if a session exists.
     *
     * @return {boolean}
     */
    public function session_exists()
    {
        $this->load('session');
        return $this->session->exists();
    } // end session_exists()

    /**
     * get_group_id() Returns the current group id for the session.
     *
     * @access public
     * @return {integer}
     */
    public function get_group_id()
    {
        $this->load('session');
        return $this->session->get_group_id();
    } // end get_group_id()

    /**
     * get_member_id() Returns the current member id for the session.
     *
     * @access public
     * @return {integer}
     */
    public function get_member_id()
    {
        $this->load('session');
        return $this->session->get_member_id();
    } // end get_member_id()

    // privileges

    /**
     * is_group_allowed() Returns true if a group has allow privilege to the module (optionally its method).
     *
     * @param {integer} $group_id The group id
     * @param {integer} $module_id The module id
     * @param {string} $method_name (optional) The method name
     * @return {boolean}
     */
    public function is_group_allowed($group_id, $module_id, $method_name = null)
    {
        // do we have the required params?
        if (!isset($group_id, $module_id) || $group_id == '' || $module_id == '') {
            return false;
        }

        // get the privilege id for the group
        $this->load('group');
        $privilege_id = $this->group->get_privilege_id($group_id);

        if (!$privilege_id) {
            return false;
        }

        // return true if allowed
        $this->load('privilege');
        if ($this->privilege->is_allowed($privilege_id, $module_id, $method_name)) {
            return true;
        }

        return false;
    } // end is_group_allowed()

    // modules

    /**
     * get_modules() Returns an array of validated modules that the member/group has access to.
     *
     * @access public
     * @return {array} An associative array of modules.
     */
    public function get_modules()
    {
        $this->load('module');

        // do we have the valid module ids already in session data?
        $ids = $this->get_valid_module_ids();
        if ($ids) {
            $valid_modules = array();

            foreach ($ids as $id) {
                $module = $this->module->get_by_id($id);
                if ($module) {
                    $valid_modules[$id] = $module;
                }
            }

            return $valid_modules;
        }

        // we do not have them in session data, get all active modules and validate them
        $active_modules = $this->module->get_active();

        if (isset($active_modules) && is_array($active_modules) && count($active_modules) > 0) {
            $arg = new stdClass();
            $valid_ids = array();
            $valid_modules = array();

            foreach ($active_modules as $id => $module) {
                $arg->id = $id;
                $arg->type = 'module';

                $success = $this->validate($arg);
                if ($success) {
                    $valid_ids[] = $id;
                    $valid_modules[$id] = $module;
                }
            }

            // set the valid module ids for quick lookup
            if (count($valid_ids) > 0) {
                $this->set_valid_module_ids($valid_ids);
            }

            return $valid_modules;
        }

        return null;
    } // end get_modules()

    // print css

    /**
     * print_module_css() Prints all the css link tags for the theme and the modules (and their dependencies) that the member can load
     *
     * @access public
     */
    public function print_module_css()
    {
        $arg = new stdClass();
        $modules = $this->get_modules();

        if (isset($modules) && is_array($modules) && count($modules) > 0) {
            foreach ($modules as $id => $module) {
                $arg->id = $id;
                $arg->type = 'module';

                $this->print_css($arg);
            }
        }
    } // end print_module_css()

    // load module

    /**
     * load_module()
     *
     * @access public
     * @param {string} $module_id The module id.
     */
    public function load_module($module_id)
    {
        if (isset($module_id) && $module_id != '') {
            $arg = new stdClass();
            $arg->id = $module_id;
            $arg->type = 'module';
            $this->print_javascript($arg);
        }
    } // end load_module()

    // module requests

    /** make_request() Will check the group privileges of the member and call the requested method if allowed.
     *
     * @param {string} $module_id The module id.
     * @param {string} $method_name The name of the method.
     **/
    public function make_request($module_id, $method_name)
    {
        // do we have the required params?
        if (!isset($module_id, $method_name) || $module_id == '' || $method_name == '') {
            die("{success: false, msg: 'Missing required params!'}");
        }

        // get the group id from session
        $this->load('session');
        $group_id = $this->session->get_group_id();

        if (!isset($group_id)) {
            die("{success: false, msg: 'You are not currently logged in'}");
        }

        // check group privilege (is the member allowed to execute this method)
        if (!$this->is_group_allowed($group_id, $module_id, $method_name)) {
            die("{success: false, msg: 'You do not have the required privileges!'}");
        }

        $error_found = false;
        $error_message = '';

        // get the module data
        $this->load('module');
        $module = $this->module->get_by_id($module_id);

        // do we have the module data
        if (!isset($module)) {
            $error_found = true;
            $error_message = 'Message: Missing data for module: ' . $module_id;
        }

        // do we have the required server data
        if (!isset($module->server, $module->server->class, $module->server->file)) {
            $error_found = true;
            $error_message = 'Message: missing server data for module : ' . $module_id;
        }

        $document_root = $this->get_document_root();
        $module_dir = $document_root . $this->get_module_dir();
        $file = $module_dir . $module->server->file;
        $class = $module->server->class;

        // does the file exist and is a regular file
        if (!is_file($file)) {
            $error_found = true;
            $error_message = 'Message: File (' . $file . ') not found for module: ' . $module_id;
        }

        require($file);

        // does the class exist?
        if (!class_exists($class)) {
            $error_found = true;
            $error_message = 'Message: ' . $class . ' does not exist for server module: ' . $module_id;
        }

        $module = new $class($this);

        // does the method exist?
        if (!method_exists($module, $method_name)) {
            $error_found = true;
            $error_message = 'Message: ' . $method_name . ' does not exist for server module: ' . $module_id;
        }

        if (!$error_found) {
            $module->$method_name();
        }

        // log errors
        if ($error_found) {
            $this->errors[] = 'Script: os.php, Method: call_module_method, Message: ' . $error_message;
            $this->load('log');
            $this->log->error($this->errors);
        }
    } // end make_request()

    // member information

    /**
     * get_locale() Returns the locale for the member.
     *
     * @access public
     * @param {integer} $member_id The member id.
     */
    public function get_member_locale($member_id)
    {
        // do we have the required param?
        if (!isset($member_id)) {
            return null;
        }

        $this->load('member');
        return $this->member->get_locale($member_id);
    } // end get_locale()

    /**
     * get_member_preference() Returns the id of the theme set for the group/member.
     *
     * @access public
     * @param {integer} $member_id
     * @param {integer} $group_id
     * @return {stdClass}
     */
    public function get_member_preference($member_id, $group_id)
    {
        // do we have the required params?
        if (!isset($member_id, $group_id)) {
            return null;
        }

        $this->load('preference');
        $preference = $this->preference->get($member_id, $group_id);

        // use the default?
        if (!$preference) {
            $preference = $this->preference->get('0', '0');
        }

        if ($preference) {
            return $preference;
        }

        return null;
    } // end get_member_preference()

    // login and logout functions

    /**
     * login()
     *
     * @access public
     * @param $module string
     * @param $user string
     * @param $pass string
     */
    public function login($user, $pass, $group_id = '')
    {
        // do we have the email address?
        if (!isset($user) || !strlen($user)) {
            die("{errors:[{id:'user', msg:'Required Field'}]}");
        }

        // do we have the password?
        if (!isset($pass) || !strlen($pass)) {
            die("{errors:[{id:'pass', msg:'Required Field'}]}");
        }

        $this->load('member');
        // does the member exist?
        if (!$this->member->exists_cedula_todos($user)) {
            die("{errors:[{id:'user', msg:'Usuario no encontrado.'}]}");
        }

        // is the member active?
        if (!$this->member->is_active($user)) {
            die("{errors:[{id:'user', msg:'Su cuenta no ha sido activada, inténtelo más tarde o comuníquese con el Administrador del sistema'}]}");
        }


        // do we have a successful login?
        $member_id = $this->member->get_id($user, $pass, false); // pass in false to flag that $pass is not encrypted
        if (!$member_id) {
            die("{errors:[{id:'user', msg:'Contraseña incorrecta.'}]}");
        }

        // was a group id supplied?
        if ($group_id == '') {
            $this->load('group');

            // get the active groups for the member
            $groups = $this->group->get_by_member_id($member_id, true);

            // any groups returned?
            if (!$groups) {
                die("{errors:[{id:'user', msg:'Esta cuenta no está vinculada a ningún grupo.'}]}");
            }

            $count = count($groups);

            // if the member is assigned to more than one group, allow the member to choose which group to login under
            if ($count > 1) {
                die("{success:true, groups: " . json_encode($groups) . "}");
            }

            // the member is assigned to only one group, login with this group id
            $group_id = $groups[0]['id'];
        }

        // get our random session id
        $this->load('utility');
        $session_id = $this->utility->build_random_id();

        $this->load('session');

        // delete any existing sessions for the member
        //$this->session->delete(null, $member_id);

        // attempt to save login session
        $success = $this->session->add($session_id, $member_id, $group_id);

        if ($success) {
            die("{success: true, sessionId: '" . $session_id . "'}");
        }

        print "{errors: [{id: 'user', msg: 'Login Failed'}]}";
    } // end login()

    /**
     * logout()
     *
     * @access public
     */
    public function logout()
    {
        $this->load('session');
        $session_id = $this->session->get_id();

        if (isset($session_id)) {
            $success = $this->session->delete($session_id);
            if ($success) {
                // no longer using PHP session
                //session_destroy();

                // clear the cookie
                setcookie('sessionId', '');

                // redirect to login page
                header('Location: ' . $this->get_login_url());
            }
        }
    } // end logout()

    // forgot password

    /**
     * forgot_password()
     *
     * @access public
     * @param {string} $email
     * @return {JSON}
     */
    public function forgot_password($email)
    {
        $response = "{success: false}";

        if (function_exists('mail')) {
            if (!isset($email) || !strlen($email)) {
                $response = "{ errors: [{ id: 'user', msg:'Required Field' }] }";
            } else if (class_exists('config')) {

                $sql = "SELECT
					password
					FROM
					qo_members
					WHERE
					email_address = '" . $email . "'";

                $result = $this->db->conn->query($sql);
                if ($result) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    if ($row) {
                        $password = $row['password'];

                        $to = $email;
                        $subject = "Your " . $this->config->DOMAIN . " Account";
                        $from_header = "From: " . $this->config->EMAIL;
                        $contents = "An 'I forgot my password' request was received from your account.\n\nYour password is: " . $password;

                        if (mail($to, $subject, $contents, $from_header)) {
                            $response = "{success: true}";
                        }
                    } else {
                        $response = "{ errors:[{ id: 'user', msg: 'Email de usuario no encontrado.' }] }";
                    }
                }
            }
        }

        return $response;
    } // end forgot_password()

    // signup requests

    /**
     * signup()
     *
     * @access public
     * @param {string} $first_name
     * @param {string} $last_name
     * @param {string} $email
     * @param {string} $email_verify
     */
    public function signup($nombre, $apellido, $cedula, $email, $dcz, $password, $vpassword, $active)
    {
        $response = "{success: false}";
        $member = new member($this);

        if (!isset($nombre) || !strlen($nombre)) {
            $response = "{errors:[{id:'nombre', msg:'Su nombre es requerido'}]}";
        } elseif (!isset($apellido) || !strlen($apellido)) {
            $response = "{errors:[{id:'apellido', msg:'Su apellido es requerido'}]}";
        } elseif (!isset($cedula) || !strlen($cedula)) {
            $response = "{errors:[{id:'cedula', msg:'Su cédula es requerida'}]}";
        } elseif (!isset($email) || !strlen($email)) {
            $response = "{errors:[{id:'email', msg:'Su email es requerido'}]}";
        } elseif (!isset($dcz) || !strlen($dcz)) {
            $response = "{errors:[{id:'dcz', msg:'Seleccione una demarcación'}]}";
        } elseif (!isset($vpassword) || !strlen($vpassword)) {
            $response = "{errors:[{id:'verificar_contraseña', msg:'Las contraseñas no coinciden'}]}";
        } else if ($password !== $vpassword) {
            $response = "{errors:[{id:'verificar_contraseña', msg:'Las contraseñas no coinciden'}]}";
        } else if ($member->is_spam($email)) {
            $response = "{errors:[{id:'email', msg:'Su email ha sido reportado como spam'}]}";
        } else if ($member->exists($email)) {
            $response = "{errors:[{id:'email', msg:'Su dirección de email está en uso'}]}";
        } else if ($member->signup_exists($email)) {
            $response = "{errors:[{id:'email', msg:'Su dirección de email ya ha sido registrada'}]}";
        } else if ($member->exists_cedula($cedula)) {
            $response = "{errors:[{id:'cedula', msg:'Su cédula está en uso'}]}";
        } else if ($member->signup_exists_cedula($cedula)) {
            $response = "{errors:[{id:'email', msg:'Su cédula ya ha sido registrada'}]}";
        }
        else {

            $this->load('security');
            $password = $this->security->encrypt($password);

            $sql = "INSERT INTO qo_members (first_name, last_name, cedula, email_address, id_dcz, password, active) VALUES (?, ?, ?, ?, ?, ?, ?)";

            // prepare the statement, prevents SQL injection by calling the PDO::quote() method internally
            $sql = $this->db->conn->prepare($sql);
            $sql->bindParam(1, $nombre);
            $sql->bindParam(2, $apellido);
            $sql->bindParam(3, $cedula);
            $sql->bindParam(4, $email);
            $sql->bindParam(5, $dcz);
            $sql->bindParam(6, $password);
            $sql->bindParam(7, $active);
            $sql->execute();

            $code = $sql->errorCode();
            if ($code == '00000') {
                $response = "{success: true}";
            } else {
                $this->errors[] = "Script: member.php, Method: signup, Message: PDO error code - " . $code;
                $this->os->load('log');
                $this->os->log->error($this->errors);
            }
        }

        return $response;
    } // end signup()

    public function auditoria($modulo, $query)
    {
        $userid = $this->get_member_id();
        $result = $this->db->conn->query("SELECT (first_name || ' ' || last_name) AS nombre FROM qo_members WHERE id=$userid;");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $user = $row["nombre"];
        $query = str_replace("'", "\'", $query);
        $query = str_replace("\"", "\"", $query);

        $sql = "INSERT INTO auditoria(usuario, modulo, fecha, query) VALUES('$user', '$modulo', now(), '$query');";
        $sql = $this->db->conn->prepare($sql);
        $sql->execute();
    }
}