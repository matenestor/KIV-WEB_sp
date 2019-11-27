<?php


class AuthorController extends ABaseController {
    private $dbArticles;

    public function __construct() {
        $this->view = "AuthorView";
        $this->title = "Author";
        $this->dbArticles = new ArticlesModel();
    }

    public function process() {
        global $login;

        // get all articles from logged in user
        $this->data = $this->dbArticles->getArticlesByUser($login->getUserInfo()[0]);

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