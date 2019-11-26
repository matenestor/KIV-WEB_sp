<?php

// require settings
require_once("app/settings.inc.php");

// set encoding
mb_internal_encoding("UTF-8");

/**
 * Function for requiring classes.
 *
 * @param $class
 */
function autoload($class) {
    // require service
    if (preg_match('/Service$/', $class)) {
        require_once("app/services/".$class.".php");
    }
    // require controller
    elseif (preg_match('/Controller$/', $class)) {
        require_once("app/controllers/".$class.".php");
    }
    // require model
    elseif (preg_match('/Model$/', $class)) {
        require_once("app/models/".$class.".php");
    }
    // error
    else {
        echo "<script>alert('Error: Unable to autoload a class [\'$class\'].');</script>";
    }
}

// register autoload function
spl_autoload_register("autoload");

// create global login service, which also creates session service, which starts session
$login = new LoginService();

// route requests
$router = new RouterService();
$router->route();
