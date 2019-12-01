<?php


class AdminController extends ABaseController {
    private $dbUser;
    private $dbArticles;
    private $dbReview;

    public function __construct() {
        $this->view = "AdminArticlesView";
        $this->title = "Admin";
        $this->dbUser = new UserModel();
        $this->dbArticles = new ArticlesModel();
        $this->dbReview = new ReviewsModel();
    }

    public function process() {
        // manage review of article
        $this->manageArticleReview();

        $this->composeData();
        $this->show();
    }

    private function manageArticleReview() {
        // check if article have been uploaded, edited or deleted
        if (isset($_POST["submit_article"]) or isset($_POST["delete_article"])) {
            $this->checkSubmits();
        }
        // check if there is request for article editing, so the article can be filled
        else {
            $this->checkPageSwitch();
        }
    }

    private function checkSubmits() {

    }

    private function checkPageSwitch() {
        if (isset($_GET["page"])) {
            switch ($_GET["page"]) {
                case "admin_articles":
                    $this->view = "AdminArticlesView";
                    break;

                case "admin_users":
                    $this->view = "AdminUsersView";
                    break;
            }
        }
    }

    private function composeData() {
        global $login;
        $userName = $login->getLoginUserName();

        // get info about all articles in database
        $attributes = $this->dbReview->getArticleAttributes();
        // get reviews in database
        $reviews = $this->dbReview->getReviewsOfArticle();

        // prepare attribute values
        foreach ($attributes as $idx => $atr) {
            $this->data["article".$idx]["attributes"] = $atr;
        }

        // prepare reviews values
        for ($i = 0, $j = 0; $i < count($reviews); $i+=3, $j++) {
            $this->data["article".$j]["reviews"]["rev1"] = $reviews[$i];
            $this->data["article".$j]["reviews"]["rev2"] = $reviews[$i+1];
            $this->data["article".$j]["reviews"]["rev3"] = $reviews[$i+2];
        }

        // get last login of user
        $this->data["last_login"] = $this->dbUser->getUserLastLogin($userName);
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