<?php


class HomeController extends ABaseController {

    public function __construct() {
        $this->view = "HomeView";
        $this->title = "Home page";
    }

    public function show() {
        // get created template
        $template = parent::getView(
            $this->view,
            $this->title
        );

        return $template;
    }
}