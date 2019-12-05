<?php


class NewArticleController extends ABaseController {
    private $dbUser;
    private $dbArticles;
    private $dbReviews;
    private $fileService;

    public function __construct() {
        $this->view = "NewArticleView";
        $this->title = "New article";
        $this->dbUser = new UserModel();
        $this->dbArticles = new ArticlesModel();
        $this->dbReviews = new ReviewsModel();
        $this->fileService = new FileService();
    }

    public function process() {
        // manage requests
        $this->manageArticle();

        $this->show();
    }

    private function manageArticle() {
        // check if article have been uploaded, edited or deleted
        if (isset($_POST["submit_article"]) or isset($_POST["delete_article"])) {
            // process article submit or delete
            $this->checkSubmits();
            // and go back to user author page
            header("Location: index.php?page=user");
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
    }

    private function manageNew($userName) {
        // if there is no article with same title
        if (!$this->dbArticles->isArticleInDB($_POST["title"])) {
            // get non-duplicate filename
            $fileName = $this->fileService->checkFileDuplicate();

            // if uploaded file is saved, insert into database
            if ($this->fileService->receiveFile($fileName)) {
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
                // get inserted article ID
                $id = $this->dbArticles->getNewestArticleID();
                // insert review row assigned to this article 3 times
                for ($i = 0; $i < 3; $i++) {
                    $this->dbReviews->insertReview($id);
                }
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
        $edited = false;
        $id = $_POST["submit_article"];
        $where = TABLE_ARTICLE.".id_article=".$id;

        // title have been edited
        if ($_POST["title"] != $this->dbArticles->getArticleTitle($id)) {
            $this->dbArticles->updateArticle("title", $_POST["title"], $where);
            $edited = true;
        }

        // abstract have been edited
        if ($_POST["abstract"] != $this->dbArticles->getArticleAbstract($id)) {
            $this->dbArticles->updateArticle("abstract", $_POST["abstract"], $where);
            $edited = true;
        }

        // file have been edited
        if (isset($_FILES["file"]) and $_FILES["file"]["name"] != "") {
            // get non-duplicate file name
            $fileName = $this->dbArticles->getArticleFile($id);

            // edited file name is same
            if ($_FILES["file"]["name"] == $fileName) {
                if (!$this->fileService->receiveFile($fileName)) {
                    // notify user about failure
                    echo "<script>alert('Unable to upload file.');</script>";
                }
            }
            // edited file name is different
            else {
                // get new non-duplicate name of edited file
                $newFileName = $this->fileService->checkFileDuplicate();
                // if uploaded file is saved, update database
                if ($this->fileService->receiveFile($newFileName)) {
                    // use old name for deleting old file from server
                    if (file_exists(FILES.$fileName)) {
                        unlink(FILES.$fileName);
                    }
                    // insert the name to the database
                    $this->dbArticles->updateArticle("file", $newFileName, $where);
                    $edited = true;
                }
                // else notify user about failure
                else {
                    echo "<script>alert('Unable to upload file.');</script>";
                }
            }
        }

        // if article was edited, renew its reviews
        if ($edited) {
            // null reviews fo edited article
            $this->dbReviews->nullReview($id);
        }
    }

    private function manageDelete() {
        $id = $_POST["delete_article"];
        $fileName = FILES.$this->dbArticles->getArticleFile($id);

        // delete file from server
        if (file_exists($fileName)) {
            unlink($fileName);
        }
        // delete file from database
        $where = "id_article=".$id;
        $this->data = $this->dbArticles->deleteArticle($where);
        // delete assigned reviews
        $this->dbReviews->deleteReview($id);
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