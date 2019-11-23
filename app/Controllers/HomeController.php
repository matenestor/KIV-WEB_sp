<?php


class HomeController extends ABaseController {

    public function __construct() {
        $this->view = "HomeView";
        $this->head["title"] = "HomePage";
        $this->head["description"] = "This is home page of conference web site.";
    }

    function show() {
        // get created template
        $template = parent::getView(
            $this->view,
            $this->head["title"],
            $this->head["description"]
        );

        return $template;
    }
}