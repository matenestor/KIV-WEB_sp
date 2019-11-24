<?php


class GoodLuckController extends ABaseController {

    public function __construct() {
        $this->view = "GoodLuckView";
        $this->head["title"] = "Good luck";
        $this->head["description"] = "This page wishes you good luck.";
    }

    public function show() {
        // get created template
        $template = parent::getView(
            $this->view,
            $this->head["title"],
            $this->head["description"]
        );

        return $template;
    }
}