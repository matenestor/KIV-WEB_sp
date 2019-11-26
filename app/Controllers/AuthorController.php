<?php


class AuthorController extends ABaseController {
    private $dbArticles;

    public function __construct() {
        $this->view = "AuthorView";
        $this->title = "Author";
        $this->dbArticles = new ArticlesModel();
    }

    public function process() {
        // get all articles in database
        $this->data = $this->dbArticles->getAllArticles();

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