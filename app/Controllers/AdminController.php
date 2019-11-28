<?php


class AdminController extends ABaseController {
    private $dbUser;
    private $dbArticles;
    private $dbReview;

    public function __construct() {
        $this->view = "AdminUsersView";
        $this->title = "Admin";
        $this->dbUser = new UserModel();
        $this->dbArticles = new ArticlesModel();
        $this->dbReview = new ReviewsModel();
    }

    public function process() {
        var_dump($_SESSION);
        $this->show();
    }

    private function show() {
        // TODO change view on Users/Articles button
        // get all articles in database
        $this->data = $this->dbArticles->getAllArticles();

        // get created template
        $template = parent::getView(
            $this->view,
            $this->title,
            $this->data
        );

        return $template;
    }
}