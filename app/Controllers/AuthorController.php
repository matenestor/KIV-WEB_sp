<?php


class AuthorController extends ABaseController {
    private $dbUser;
    private $dbArticles;
    private $fileControl;

    public function __construct() {
        $this->view = "AuthorView";
        $this->title = "Author";
        $this->dbUser = new UserModel();
        $this->dbArticles = new ArticlesModel();
        $this->fileControl = new FileController();
    }

    public function process() {
        global $login;
        $userName = $login->getLoginUserName();

        // check if article has been uploaded or edited
        $this->manageArticle();

        // get all articles from logged in user
        $this->data = $this->dbArticles->getArticlesByUser($userName);
        // get last login of user
        $this->data["last_login"] = $this->dbUser->getUserLastLogin($userName);

        $this->show();
    }

    private function manageArticle() {
        global $login;
        $userName = $login->getLoginUserName();

        if (isset($_POST["submit_article"])) {
            switch ($_POST["submit_article"]) {
                case "new":
                    // if there is no article with same title
                    if (!$this->dbArticles->isArticleInDB($_POST["title"])) {
                        // if uploaded file is saved, update database
                        if ($this->fileControl->receiveFile()) {
                            $insertStatement = "user_id_user, title, author, date, file, abstract";
                            $values = sprintf("'%s', '%s', '%s', %s, '%s', '%s'",
                                $this->dbUser->getUserID($userName),
                                $_POST["title"],
                                $this->dbUser->getUserFullName($userName),
                                "CURRENT_TIMESTAMP()",
                                basename($_FILES["file"]["name"]),
                                $_POST["abstract"]
                            );
                            $this->dbArticles->insertArticle($insertStatement, $values);
                        }
                        // else notify user about failure
                        else {
                            echo "<script>alert('Unable to upload file.');</script>";
                        }
                    }
                    else {
                        echo "<script>alert('Article already exists.');</script>";
                    }
                    break;
            }
        }
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