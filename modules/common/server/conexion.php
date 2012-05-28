<?php
define('PATH_LIBRARY', '/var/www/');
set_include_path(get_include_path() . PATH_SEPARATOR . PATH_LIBRARY);

require_once 'spoon/spoon.php';

$db = new SpoonDatabase('pgsql', 'localhost', 'postgres', 'root', 'sisconse', '5432');
