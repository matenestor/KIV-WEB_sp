<?php

class ArticlesModel extends BaseModel {

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
    private function getArticlesByUser($user) {
        $where = "username='$user'";
        return parent::selectFromTable(TABLE_USER, $user);
    }
}