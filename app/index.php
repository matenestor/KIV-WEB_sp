<?php

// require settings
require_once("settings.inc.php");

// set encoding
mb_internal_encoding("UTF-8");

/**
 * Function for requiring classes.
 *
 * @param $class
 */
function autoloadFunc($class) {
    // first step into web app -- router is required
    if ($class == "Router") {
        require_once "controllers/Router.php";
    }
    // require controller
    elseif (preg_match('/Controller$/', $class)) {
        require_once("controllers/".$class.".php");
    }
    // require model
    elseif (preg_match('/Model$/', $class)) {
        require_once("models/".$class.".php");
    }
    // error
    else {
        echo "! Unable to autoload a class ['$class']";
    }
}

// register autoload function
spl_autoload_register("autoloadFunc");

$router = new Router();
$router->route();

/*
 * TODO
 *
 * [x] router class
 * [ ] user registration
 * [ ] user login (includes sessions)
 * [ ] user duties
 *     [ ] author
 *     [ ] reviewer
 *     [ ] admin
 * [ ] view templates for everything
 * [ ] access to DB for everyone
 * [ ] security patch
 */
