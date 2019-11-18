<?php

class ArticlesModel extends ABaseModel {

    /**
     * Returns all articles.
     *
     *  Get all users in DB
     *  @return array
     */
    public function getAllArticles():array {
        return parent::selectFromTable(TABLE_ARTICLE);
    }
}