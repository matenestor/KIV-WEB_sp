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
/** File to download directory */
define("FILES", "files/");
/** Files to download path */
define("FILES_PATH", ROOT_PATH.FILES);
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
define("WEB_PAGE_CONTROLLERS", array(
    "home"      => "HomeController",
    "articles"  => "ArticlesPublicController",
    "user"      => "UserController",
    "login"     => "LoginController",
    "register"  => "RegisterController",
    "404"       => "err404Controller",
    "goodluck"  => "GoodLuckController",
    "new_article" => "NewArticleController"
));

/** Default website key */
define("WEB_HOME", "home");
/** Key of login page */
define("WEB_LOGIN", "login");
/** Key of register page */
define("WEB_REGISTER", "register");
/** Key of user (admin, reviewer, author) page */
define("WEB_USER", "user");
/** Default website key */
define("WEB_NOT_FOUND", "404");
/** New article page */
define("WEB_NEW_ARTICLE", "new_article");
