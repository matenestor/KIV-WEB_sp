<?php


class err404Controller extends ABaseController {

    public function __construct() {
        $this->view = "err404View";
        $this->head["title"] = "error 404";
        $this->head["description"] = "This is error 404 page.";
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