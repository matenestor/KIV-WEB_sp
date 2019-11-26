<?php


class ReviewerController extends ABaseController {
    private $dbArticles;
    private $dbReview;

    public function __construct() {
        $this->view = "ReviewerView";
        $this->title = "Reviewer";
        $this->dbArticles = new ArticlesModel();
        $this->dbReview = new ReviewsModel();
    }

    public function process() {
        $this->show();
    }

    private function show() {
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