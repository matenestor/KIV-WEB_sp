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
     * Get row with given title of article.
     * @param $title
     * @return array
     */
    private function getArticleByTitle($title) {
        $select = "*";
        $where = "title='$title'";
        return parent::selectFromTable($select, TABLE_ARTICLE, $where);
    }
}