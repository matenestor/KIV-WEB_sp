<?php

// database connection info

/** Database address */
define("DB_SERVER", "localhost");
/** Database name */
define("DB_NAME", "web_conference");
/** Database username */
define("DB_USER", "root");
/** Database password */
define("DB_PASS", "root");

// database tables

/** Table user */
define("TABLE_USER", "user");
/** Table article */
define("TABLE_ARTICLE", "article");
/** Table review */
define("TABLE_REVIEW", "review");

// directories of mvc components

/** Base path for requiring/including */
define("APP_PATH", "/home/kuub/ws/KIV-WEB_sp/app/");
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

/** Header constant */
define("HEADER", "HeaderView");
/** Footer constant */
define("FOOTER", "FooterView");

// available websites

/** Available websites */
define("WEB_PAGES", array(
    "articles" => array("file_name" => "ArticlesController.php",
                        "class_name" => "ArticlesController",
                        "title" => "Articles"),
));

/** Key of default website key */
define("DEFAULT_WEB_PAGE_KEY", "articles");