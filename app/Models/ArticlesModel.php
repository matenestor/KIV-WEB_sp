<?php

class ArticlesModel extends BaseModel {

    /** Access to table 'user' -- foreign key */
    private $dbUser;

    public function __construct() {
        parent::__construct();
        $this->dbUser = new UserModel();
    }

    /**
     * Returns all articles.
     *
     *  Get all articles in DB
     *  @return array
     */
    public function getAllArticles():array {
        $what = "*";
        return parent::selectFromTable($what, TABLE_ARTICLE);
    }

    /**
     * Get row(s) with articles of user.
     *
     * @param $user
     * @return array
     */
    public function getArticlesByUser($user) {
        $idUser = $this->dbUser->getUserID($user);
        $what = "*";
        $where = "user_id_user=$idUser";
        return parent::selectFromTable($what, TABLE_ARTICLE, $where);
    }
}