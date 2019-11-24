<?php


class RouterService {

    public function route() {
        // asking for web page
        if (isset($_GET['page'])) {
            // page exists
            if (array_key_exists($_GET['page'], WEB_PAGES)) {
                $page = $_GET['page'];
            }
            // page does not exists
            else {
                $page = WEB_NOT_FOUND;
            }
        }
        // request for logout, $_POST value goes over LoginController to LoginService,
        // where user is logged out
        elseif (isset($_POST["submit_login"])) {
            $page = WEB_LOGIN;
        }
        // coming in without request
        else {
            $page = WEB_DEFAULT;
        }

        // controller of required page
        $controllerName = WEB_PAGES[$page];
        // create instance of page controller
        $pageController = new $controllerName;
        // show view of required page
        echo $pageController->show();
    }
}