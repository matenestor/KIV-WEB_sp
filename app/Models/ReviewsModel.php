<?php


class ReviewsModel extends BaseModel {

    /**
     * Joins tables 'article' and 'review' for columns with article attributes and returns rows.
     *
     * @return array
     */
    public function getArticleAttributes():array {
        $select = TABLE_ARTICLE.".id_article, ".TABLE_ARTICLE.".title, ".TABLE_ARTICLE.".author, ".TABLE_ARTICLE.".date, ".TABLE_ARTICLE.".file, ".TABLE_ARTICLE.".status";
        $tableName1 = TABLE_ARTICLE;
        $tableName2 = TABLE_REVIEW;
        $tableKey1 = TABLE_ARTICLE.".id_article";
        $tableKey2 = TABLE_REVIEW.".article_id_article";
        $groupBy = "article.id_article";

        return parent::selectJoin($select, $tableName1, $tableName2, $tableKey1, $tableKey2, $groupBy);
    }

    /**
     * Joins tables 'article', 'review', 'user' for single review and returns rows.
     *
     * @return array
     */
    public function getReviewsOfArticle():array {
        $select = TABLE_USER.".username, ".TABLE_REVIEW.".originality, ".TABLE_REVIEW.".format, ".TABLE_REVIEW.".language, ".TABLE_REVIEW.".comment";
        $tableName1 = TABLE_ARTICLE;
        $tableName2 = TABLE_REVIEW;
        $tableName3 = TABLE_USER;
        $tableKey1 = TABLE_ARTICLE.".id_article";
        $tableKey2 = TABLE_REVIEW.".article_id_article";
        $tableKey3 = TABLE_USER.".id_user";
        $tableKey4 = TABLE_REVIEW.".user_id_user";

        return parent::selectJoinLeftJoin($select, $tableName1, $tableName2, $tableName3, $tableKey1, $tableKey2, $tableKey3, $tableKey4);
    }

    /**
     * Insert review row connected with article by given name.
     *
     * @param $values
     * @return bool
     */
    public function insertReview($values) {
        $insertStatements = "article_id_article";

        return parent::insertIntoTable(TABLE_REVIEW, $insertStatements, $values);
    }

    /**
     * Delete review row connected with article by given name.
     *
     * @param $id
     * @return bool
     */
    public function deleteReview($id) {
        $where = "article_id_article=".$id;

        return parent::deleteFromTable(TABLE_REVIEW, $where);
    }

    /**
     * Sets NULL to columns `originality`, `format`, `language`, `comment`
     *
     * @param $id
     */
    public function nullReview($id) {
        $columns = array("`originality`", "`format`", "`language`", "`comment`");
        $null = "NULL";
        $where = "article_id_article=".$id;

        // update review columns to null in all 3 reviews
        foreach ($columns as $column) {
            parent::updateTable(TABLE_REVIEW, $column, $null, $where);
        }
    }
}