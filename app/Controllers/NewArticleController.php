<?php


class NewArticleController extends ABaseController {

    public function __construct() {
        $this->view = "NewArticleView";
        $this->title = "New article";
    }

    public function process() {
        $this->show();
    }

    private function show() {
        // get created template
        $template = parent::getView(
            $this->view,
            $this->title,
            $this->data
        );

        return $template;
    }
}