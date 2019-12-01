<?php

class ArticlesModel extends BaseModel {

    /** Access to table 'user' -- foreign key */
    private $dbUser;

    public function __construct() {
        parent::__construct();
        $this->dbUser = new UserModel();
    }

    /**
     * Returns true if article is in database, else return false.
     *
     * @param $articleTitle
     * @return bool
     */
    public function isArticleInDB($articleTitle) {
        $dbRow = $this->getArticleByTitle($articleTitle);
        return $dbRow != null;
    }

    /**
     * Get title of article.
     *
     * @param $id
     * @return mixed
     */
    public function getArticleTitle($id) {
        return $this->getArticleByID($id)[0]["title"];
    }

    /**
     * Get file of article.
     *
     * @param $id
     * @return mixed
     */
    public function getArticleFile($id) {
        return $this->getArticleByID($id)[0]["file"];
    }

    /**
     * Get abstract of article.
     *
     * @param $id
     * @return mixed
     */
    public function getArticleAbstract($id) {
        return $this->getArticleByID($id)[0]["abstract"];
    }

    /**
     * Returns all articles.
     *
     *  Get all articles in DB
     *  @return array
     */
    public function getAllArticles():array {
        $select = "*";
        return parent::selectFromTable($select, TABLE_ARTICLE);
    }

    /**
     * Get row(s) with articles of user.
     *
     * @param $user
     * @return array
     */
    public function getArticlesByUser($user) {
        $idUser = $this->dbUser->getUserID($user);
        $select = "*";
        $where = "user_id_user=$idUser";
        return parent::selectFromTable($select, TABLE_ARTICLE, $where);
    }

    /**
     * Get article by its ID.
     * @param $id
     * @return array
     */
    public function getArticleByID($id) {
        $select = "*";
        $where = "id_article='$id'";
        return parent::selectFromTable($select, TABLE_ARTICLE, $where);
    }

    /**
     * Get ID of newest article.
     *
     * @return mixed
     */
    public function getNewestArticleID() {
        $select = "*";
        $where = "";
        $orderBy = "id_article";
        $sort = "DESC";

        // get all articles in database with DESCending order
        $result = parent::selectFromTable($select, TABLE_ARTICLE, $where, $orderBy, $sort);

        // return ID of first article, which is newest
        return $result[0]["id_article"];
    }

    /**
     * Deletes article from database.
     *
     * @param $where
     */
    public function deleteArticle($where) {
        parent::deleteFromTable(TABLE_ARTICLE, $where);
    }

    /**
     * Inserts article into database.
     *
     * @param $insertStatement
     * @param $values
     * @return bool
     */
    public function insertArticle($insertStatement, $values) {
        return parent::insertIntoTable(TABLE_ARTICLE, $insertStatement, $values);
    }

    /**
     * Updates article column.
     *
     * @param string $column
     * @param $value
     * @param string $where
     */
    public function updateArticle(string $column, $value, string $where) {
        parent::updateTable(TABLE_ARTICLE, $column, "'$value'", $where);
    }

    /**
     * Get row with given title of article.
     *
     * @param $title
     * @return array
     */
    private function getArticleByTitle($title) {
        $select = "*";
        $where = "title='$title'";
        return parent::selectFromTable($select, TABLE_ARTICLE, $where);
    }
}