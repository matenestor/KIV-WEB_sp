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