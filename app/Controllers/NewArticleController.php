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

        // if request for new or edit an article came
        if (isset($_POST["submit_article"])) {
            // request for posting new article
            if ($_POST["submit_article"] == "new") {
                $this->manageNew($userName);
            }
            // request for editing existing article
            elseif (ctype_digit($_POST["submit_article"])) {
                $this->manageEdit();
            }
        }
        // request for article delete
        elseif (isset($_POST["delete_article"])) {
            $this->manageDelete();
        }

        // redirect to author's articles and exit
        $redirect = new AuthorController();
        $redirect->process();
        exit();
    }

    private function manageNew($userName) {
        // if there is no article with same title
        if (!$this->dbArticles->isArticleInDB($_POST["title"])) {
            // get non-duplicate filename
            $fileName = $this->fileControl->checkFileDuplicate();

            // if uploaded file is saved, insert into database
            if ($this->fileControl->receiveFile($fileName)) {
                // prepare statements
                $insertStatement = "user_id_user, title, author, date, file, abstract";
                // fill values
                $values = sprintf("'%s', '%s', '%s', %s, '%s', '%s'",
                    $this->dbUser->getUserID($userName),
                    $_POST["title"],
                    $this->dbUser->getUserFullName($userName),
                    "CURRENT_TIMESTAMP()",
                    $fileName,
                    $_POST["abstract"]
                );
                // insert everything into database
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

    private function manageEdit() {
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
        if (isset($_FILES["file"]) and $_FILES["file"]["name"] != "") {
            // get non-duplicate file name
            $fileName = $this->dbArticles->getArticleFile($_POST["submit_article"]);

            // edited file name is same
            if ($_FILES["file"]["name"] == $fileName) {
                if (!$this->fileControl->receiveFile($fileName)) {
                    // notify user about failure
                    echo "<script>alert('Unable to upload file.');</script>";
                }
            }
            // edited file name is different
            else {
                // use old name for deleting old file from server
                if (file_exists(FILES.$fileName)) {
                    unlink(FILES.$fileName);
                }

                // get new non-duplicate name of edited file
                $fileName = $this->fileControl->checkFileDuplicate();
                // if uploaded file is saved, update database
                if ($this->fileControl->receiveFile($fileName)) {
                    // insert the name to the database
                    $this->dbArticles->updateArticle("file", $fileName, $where);
                }
                // else notify user about failure
                else {
                    echo "<script>alert('Unable to upload file.');</script>";
                }
            }
        }
    }

    private function manageDelete() {
        $fileName = FILES.$this->dbArticles->getArticleFile($_POST["delete_article"]);

        // delete file from server
        if (file_exists($fileName)) {
            unlink($fileName);
        }
        // delete file from database
        $where = "id_article=".$_POST["delete_article"];
        $this->data = $this->dbArticles->deleteArticle($where);
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