<?php


class RouterService {
    private $userLogged;
    private $controllerKey;

    public function __construct() {
        global $login;

        $this->userLogged = $login->isUserLoged();
        $this->controllerKey = WEB_HOME;
    }

    public function route() {
        // route GET request according to if user is logged in or not
        if ($this->userLogged) {
            $this->routeGETLogged();
        }
        else {
            $this->routeGETNotLogged();
        }

        // route POST request; POST comes only in special situation (eg. form submit)
        // so when it comes, there is no GET,
        // and when it does not come, it does not change anything
        if ($_POST != null) {
            $this->routePOST();
        }

        // controller of required page
        $controllerName = WEB_PAGE_CONTROLLERS[$this->controllerKey];
        // create instance of page controller
        $pageController = new $controllerName;
        // show view of required page
        echo $pageController->process();
    }

    private function routeGETNotLogged() {
        //route page; $_GET["page"] should be set every time, when $_POST is not
        if (isset($_GET["page"])) {
            // page exists
            if (array_key_exists($_GET['page'], WEB_PAGE_CONTROLLERS)) {
                // user is not logged in and wants to go 'user' page
                // route user to 'login' page
                if ($_GET['page'] == WEB_USER) {
                    $this->controllerKey = WEB_LOGIN;
                }
                // not logged user is not supposed to be on new article page
                elseif ($_GET['page'] == WEB_NEW_ARTICLE) {
                    $this->controllerKey = WEB_HOME;
                }
                // else route where user wants to
                else {
                    $this->controllerKey = $_GET['page'];
                }
            }
            // page does not exists
            else {
                $this->controllerKey = WEB_NOT_FOUND;
            }
        }
    }

    private function routeGETLogged() {
        //route page; $_GET["page"] should be set every time, when $_POST is not
        if (isset($_GET["page"])) {
            // page exists
            if (array_key_exists($_GET['page'], WEB_PAGE_CONTROLLERS)) {
                // user is logged in and wants to go 'login' or 'register' page
                // route user to 'user' page
                if (in_array($_GET['page'], array(WEB_LOGIN, WEB_REGISTER))) {
                    $this->controllerKey = WEB_USER;
                }
                // else route where user wants to
                else {
                    $this->controllerKey = $_GET['page'];
                }
            }
            // page does not exists
            else {
                $this->controllerKey = WEB_NOT_FOUND;
            }
        }
    }

    private function routePOST() {
        // login post
        if (isset($_POST["submit_login"])) {
            $this->controllerKey = WEB_LOGIN;
        }
        // register post
        elseif (isset($_POST["submit_register"])) {
            $this->controllerKey = WEB_REGISTER;
        }
        // admin articles and users modul posts
        elseif (isset($_POST["submit_user"])
                or isset($_POST["assign_review_to"])
                or isset($_POST["assign_review_on"])
                or isset($_POST["publish_article"])
                or isset($_POST["refuse_article"])
                or isset($_POST["block_user"])
                or isset($_POST["allow_user"])
                or isset($_POST["delete_user"])) {
            $this->controllerKey = WEB_USER;
        }
        // user new article posts
        elseif (isset($_POST["submit_article"]) or isset($_POST["delete_article"])) {
            $this->controllerKey = WEB_NEW_ARTICLE;
        }
    }
}