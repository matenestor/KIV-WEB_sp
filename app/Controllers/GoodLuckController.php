<?php


class GoodLuckController extends ABaseController {

    public function __construct() {
        $this->view = "GoodLuckView";
        $this->title = "Good luck";
    }

    public function process() {
        $this->show();
    }

    private function show() {
        // get created template
        $template = parent::getView(
            $this->view,
            $this->title
        );

        return $template;
    }
}