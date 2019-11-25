<?php

// database connection info

/** Database address */
define("DB_SERVER", "localhost");
/** Database name */
define("DB_NAME", "web_conference");
/** Database username */
define("DB_USER", "root");
/** Database password */
define("DB_PASS", "");

// database tables

/** Table user */
define("TABLE_USER", "user");
/** Table article */
define("TABLE_ARTICLE", "article");
/** Table review */
define("TABLE_REVIEW", "review");

// directories of mvc components

/** Root folder of app */
define("ROOT_PATH", "KIV-WEB_sp/");
/** Index path */
define("INDEX", ROOT_PATH."index.php");
/** Base path for requiring/including */
define("APP_PATH", "app/");
/** Directory of controllers */
define("DIR_CONTROLLERS", "Controllers/");
/** Directory of models */
define("DIR_MODELS", "Models/");
/** Directory of views */
define("DIR_VIEWS", "Views/");

// extensions of files

/** View extensions */
define("EXT_VIEW", ".phtml");

// footer and header

/** Basic layout with header and footer */
define("LAYOUT", "Layout");

// available websites

/** Available websites */
define("WEB_PAGES", array(
    "home"      => "HomeController",
    "articles"  => "ArticlesPublicController",
    "user"      => "UserController",
    "login"     => "LoginController",
    "register"  => "RegisterController",
    "404"       => "err404Controller",
    "goodluck"  => "GoodLuckController")
);

/** Default website key */
define("WEB_DEFAULT", "home");
/** Default website key */
define("WEB_NOT_FOUND", "404");
/** Key of login page */
define("WEB_LOGIN", "login");