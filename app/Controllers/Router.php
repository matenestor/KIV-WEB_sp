<?php


class Router {

    public function route() {
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
    }
}