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
        $this->manageSubmits();

        // get data according to page
        $this->composeData();

        // show view
        $this->show();
    }

    private function manageSubmits() {
        // check if article have been uploaded, edited or deleted
        if (isset($_POST["publish_article"]) or isset($_POST["refuse_article"])) {
            $this->manageArticle();
        }
        // check if there is assigment for reviewer
        elseif (isset($_POST["assign_review_to"]) or isset($_POST["assign_review_on"])) {
            $this->manageAssign();
        }
        // check for users manipulation
        elseif (isset($_POST["block_user"])
                or isset($_POST["allow_user"])
                or isset($_POST["delete_user"])) {
            $this->view = "AdminUsersView";
            $this->manageUsers();
        }
        // check if there is request for article editing, so the article can be filled
        else {
            $this->checkPageSwitch();
        }
    }

    private function manageArticle() {
        // article will be published
        if (isset($_POST["publish_article"])) {
            $column = "status";
            $value = "published";
            $where = "article.id_article = ".$_POST["publish_article"];
            $this->dbArticles->updateArticle($column, $value, $where);
        }
        // article will be refused
        elseif (isset($_POST["refuse_article"])) {
            $column = "status";
            $value = "refused";
            $where = "article.id_article = ".$_POST["refuse_article"];
            $this->dbArticles->updateArticle($column, $value, $where);
        }
    }

    private function manageAssign() {
        // assign review to reviewer
        $column = "user_id_user";
        $assign_to = $_POST["assign_review_to"];
        $assign_on = $_POST["assign_review_on"];
        $this->dbReview->updateReviewByIdArticle($column, $assign_to, $assign_on);
    }

    private function manageUsers() {
        // user will be blocked
        if (isset($_POST["block_user"])) {
            $column = "access";
            $this->dbUser->updateUser($_POST["block_user"], $column, "blocked");
        }
        // user will be allowed
        elseif (isset($_POST["allow_user"])) {
            $column = "access";
            $this->dbUser->updateUser($_POST["allow_user"], $column, "ok");
        }
        // user will be deleted
        elseif (isset($_POST["delete_user"])) {
            $this->dbUser->deleteUser($_POST["delete_user"]);
        }
    }

    private function checkPageSwitch() {
        if (isset($_GET["sub_page"])) {
            switch ($_GET["sub_page"]) {
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
        if ($this->view == "AdminArticlesView") {
            $this->composeDataArticles();
        }
        elseif ($this->view == "AdminUsersView") {
            $this->composeDataUsers();
        }
    }

    private function composeDataArticles() {
        global $login;
        $userName = $login->getLoginUserName();

        // get info about all articles in database
        $attributes = $this->dbReview->getArticleAttributes();
        // get reviews in database
        $reviews = $this->dbReview->getReviewsOfArticle();
        // get all reviewers in database
        $all_reviewers = $this->dbUser->getAllReviewers();

        // prepare attribute values
        // foreach ($attributes as $idx => $atr) {
        for ($i = 0; $i < count($attributes); $i++) {
            $this->data["article".$attributes[$i]["id_article"]]["attributes"] = $attributes[$i];
        }

        // prepare reviews values
        foreach ($reviews as $rev) {
            if (!isset($this->data["article".$rev["id_article"]]["reviews"])) {
                $this->data["article".$rev["id_article"]]["reviews"] = [];
            }

            $count = count($this->data["article".$rev["id_article"]]["reviews"]) + 1;
            $this->data["article".$rev["id_article"]]["reviews"]["rev".$count] = $rev;
        }


        // insert all reviewers to data array
        $this->data["all_revs"] = $all_reviewers;

        // get last login of user
        $this->data["last_login"] = $this->dbUser->getUserLastLogin($userName);
    }

    private function composeDataUsers() {
        global $login;
        $userName = $login->getLoginUserName();

        // get all users in database
        $this->data = $this->dbUser->getAllUsers();

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