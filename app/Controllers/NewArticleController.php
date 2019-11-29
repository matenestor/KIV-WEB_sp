<?php


class NewArticleController extends ABaseController {
    private $dbUser;
    private $dbArticles;
    private $fileControl;

    public function __construct() {
        $this->view = "NewArticleView";
        $this->title = "New article";
        $this->dbUser = new UserModel();
        $this->dbArticles = new ArticlesModel();
        $this->fileControl = new FileController();
    }

    public function process() {
        // manage requests
        $this->manageArticle();

        $this->show();
    }

    private function manageArticle() {
        // check if article have been uploaded, edited or deleted
        if (isset($_POST["submit_article"]) or isset($_POST["delete_article"])) {
            $this->checkSubmits();
        }
        // check if there is request for article editing, so the article can be filled
        else {
            $this->checkFillArticleView();
        }
    }

    private function checkFillArticleView() {
        // get data for request for editing existing article
        if (isset($_GET["id_article"])) {
            $this->data = $this->dbArticles->getArticleByID($_GET["id_article"])[0];
        }
    }

    private function checkSubmits() {
        global $login;
        $userName = $login->getLoginUserName();

        // request for posting new article
        if (isset($_POST["submit_article"]) and $_POST["submit_article"] == "new") {
            // if there is no article with same title
            if (!$this->dbArticles->isArticleInDB($_POST["title"])) {
                // if uploaded file is saved, insert into database
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
        }
        // request for editing existing article
        elseif (isset($_POST["submit_article"]) and ctype_digit($_POST["submit_article"])) {
            $where = TABLE_ARTICLE.".id_article=".$_POST["submit_article"];

            // title have been edited
            if ($_POST["title"] != $this->dbArticles->getArticleTitle($_POST["submit_article"])) {
                $this->dbArticles->updateArticle("title", $_POST["title"], $where);
            }

            // abstract have been edited
            if ($_POST["abstract"] != $this->dbArticles->getArticleAbstract($_POST["submit_article"])) {
                $this->dbArticles->updateArticle("abstract", $_POST["abstract"], $where);
            }

            // file have been edited
            if (isset($_POST["file"]) and $_POST["file"] != $this->dbArticles->getArticleFile($_POST["submit_article"])) {
                // if uploaded file is saved, update database
                if ($this->fileControl->receiveFile()) {
                    $this->dbArticles->updateArticle("file", $_POST["file"], $where);
                }
                // else notify user about failure
                else {
                    echo "<script>alert('Unable to upload file.');</script>";
                }
            }
        }
        // request for article delete
        elseif (isset($_POST["delete_article"])) {
            $where = "id_article=".$_POST["delete_article"];
            $this->data = $this->dbArticles->deleteArticle($where);
        }

        // redirect to author's articles and exit
        $redirect = new AuthorController();
        $redirect->process();
        exit();
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