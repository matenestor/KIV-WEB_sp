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


// ----------------------------------------------
//$pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
//// set encoding UTF-8
//$pdo->exec("set names utf8");
//
//if ($pdo) echo "pdo sth<br>";
//else      echo "pdo empty<br>";
//
//$stmt = $pdo->query("SELECT * FROM ".TABLE_ARTICLE);
//
//if ($stmt) echo "stmt sth<br>";
//else       echo "stmt empty<br>";
//
//$arr = $stmt->fetchAll();
//foreach ($arr as $row) {
//    print_r($row);
//    echo "<br>";
//}
// ----------------------------------------------


// route request
if (isset($_GET['page']) && array_key_exists($_GET['page'], WEB_PAGES)) {
    $pageKey = $_GET['page'];
}
else {
    $pageKey = DEFAULT_WEB_PAGE_KEY;
}

echo "pageinfo<br>";
// array with info about required page
$pageInfo = WEB_PAGES[$pageKey];

echo "new contro<br>";
// controller of required page
$pageController = new $pageInfo["class_name"];

echo "show<br>";
// show view of required page
echo $pageController->show();
