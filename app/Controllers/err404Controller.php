<?php


class err404Controller extends ABaseController {

    public function __construct() {
        $this->view = "err404View";
        $this->title = "error 404";
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