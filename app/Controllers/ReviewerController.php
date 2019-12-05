<?php


class ReviewerController extends ABaseController {
    private $dbReview;
    private $dbUser;

    public function __construct() {
        $this->view = "ReviewerView";
        $this->title = "Reviewer";
        $this->dbReview = new ReviewsModel();
        $this->dbUser = new UserModel();
    }

    public function process() {
        global $login;
        $userName = $login->getLoginUserName();

        // get Id of user
        $userId = $this->dbUser->getUserID($userName);
        // get review information
        $this->data = $this->dbReview->getAllReviewsOfUser($userId);
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