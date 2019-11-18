<?php

// require settings
require_once("settings.inc.php");

// set encoding
mb_internal_encoding("UTF-8");

/**
 * Function for requiring classes
 * @param $class
 */
function autoloadFunc($class) {
    // require controller
    if (preg_match('/Controller$/', $class)) {
        require_once("Controllers/".$class.".php");
    }
    // require model
    elseif (preg_match('/Model$/', $class)) {
        require_once("Models/".$class.".php");
    }
    // error
    else {
        echo "! Unknown class";
    }
}

// register autoload function
spl_autoload_register("autoloadFunc");


// route request
if (isset($_GET['page']) && array_key_exists($_GET['page'], WEB_PAGES)) {
    $pageKey = $_GET['page'];
}
else {
    $pageKey = DEFAULT_WEB_PAGE_KEY;
}

// array with info about required page
$pageInfo = WEB_PAGES[$pageKey];
// controller of required page
$pageController = new $pageInfo["class_name"];
// show view of required page
echo $pageController->show();
