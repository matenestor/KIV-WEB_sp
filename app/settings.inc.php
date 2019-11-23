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

/** Index path */
define("IDX_PATH", "conf/index.php?");
/** Base path for requiring/including */
define("APP_PATH", "D:/ws/PHP/KIV-WEB_sp/app/");
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

    "home" => array(
        "file_name" => "HomeController.php",
        "class_name" => "HomeController",
        "title" => "Home page"),

    "articles" => array(
        "file_name" => "ArticlesController.php",
        "class_name" => "ArticlesController",
        "title" => "Articles"),
));

/** Key of default website key */
define("DEFAULT_WEB_PAGE_KEY", "articles");