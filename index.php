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
        echo "! Unable to autoload a class ['$class']";
    }
}

// register autoload function
spl_autoload_register("autoload");

$router = new RouterService();
$router->route();

//unset($_SESSION["username"]);
//unset($_SESSION["date"]);
