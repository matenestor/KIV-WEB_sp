<?php

class NewReviewController extends ABaseController {
    private $dbArticles;
    private $dbReview;
    private $dbUser;

    public function __construct() {
        $this->view = "NewReviewView";
        $this->title = "New review";
        $this->dbArticles = new ArticlesModel();
        $this->dbReview = new ReviewsModel();
        $this->dbUser = new UserModel();
    }

    public function process() {
        // check for submits
        $this->manageSubmits();
        // get data for view
        $this->composeData();

        $this->show();
    }

    private function manageSubmits() {
        if (isset($_POST["submit_review"])) {
            if (isset($_POST["originality"])) {
                $this->dbReview->updateReviewByIdReview("originality", $_POST["originality"], $_GET["id_review"]);
            }
            if (isset($_POST["format"])) {
                $this->dbReview->updateReviewByIdReview("format", $_POST["format"], $_GET["id_review"]);
            }
            if (isset($_POST["language"])) {
                $this->dbReview->updateReviewByIdReview("language", $_POST["language"], $_GET["id_review"]);
            }
            if (isset($_POST["comment"])) {
                $this->dbReview->updateReviewByIdReview("comment", $_POST["comment"], $_GET["id_review"]);
            }

            // go back to user page after submit review
            header("Location: index.php?page=user");
        }
    }

    private function composeData() {
        // get review information
        $this->data = $this->dbReview->getReviewById($_GET["id_review"])[0];
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