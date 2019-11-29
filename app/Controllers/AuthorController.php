<?php


class AuthorController extends ABaseController {
    private $dbUser;
    private $dbArticles;

    public function __construct() {
        $this->view = "AuthorView";
        $this->title = "Author";
        $this->dbUser = new UserModel();
        $this->dbArticles = new ArticlesModel();
    }

    public function process() {
        global $login;
        $userName = $login->getLoginUserName();

        // get all articles from logged in user
        $this->data = $this->dbArticles->getArticlesByUser($userName);
        // get last login of user
        $this->data["last_login"] = $this->dbUser->getUserLastLogin($userName);

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