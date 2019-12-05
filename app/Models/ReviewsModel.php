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
        $groupBy = TABLE_ARTICLE.".id_article";

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
     * Updates review column.
     *
     * result query example:
     *
     * UPDATE review
     * SET user_id_user <column> = '1' <value_rev>
     * WHERE review.id_review = (
     *   SELECT review.id_review
     *   FROM review
     *   WHERE review.user_id_user IS NULL AND review.article_id_article = '1' <value_art>
     *   GROUP BY review.article_id_article
     * )
     *
     * @param string $column
     * @param string $value_rev
     * @param string $value_art
     */
    public function updateReview(string $column, string $value_rev, string $value_art) {
        $select = TABLE_REVIEW.".id_review";
        $where_inner = TABLE_REVIEW.".user_id_user IS NULL AND ".TABLE_REVIEW.".article_id_article = ".$value_art;
        $groupBy = TABLE_REVIEW.".article_id_article";

        $id_review = $this->selectFromTable($select, TABLE_REVIEW, $where_inner, "", "", $groupBy)[0]["id_review"];
        $where = TABLE_REVIEW.".id_review = ".$id_review;

        parent::updateTable(TABLE_REVIEW, $column, $value_rev, $where);
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