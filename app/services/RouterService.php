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
        if (isset($_POST["submit_login"])) {
            $this->controllerKey = WEB_LOGIN;
        }
        elseif (isset($_POST["submit_register"])) {
            $this->controllerKey = WEB_REGISTER;
        }
        elseif (isset($_POST["submit_user"])) {
            $this->controllerKey = WEB_USER;
        }
        elseif (isset($_POST["submit_article"])) {
            $this->controllerKey = WEB_USER;
        }
    }
}