<?php


class ReviewsModel extends BaseModel {

    /**
     * Get review by Id.
     *
     * @param $id
     * @return array
     */
    public function getReviewById($id) {
        $where = "id_review = ".$id;
        return parent::selectFromTable("*", TABLE_REVIEW, $where);
    }

    /**
     * Get all reviews of given user.
     *
     * example of result query:
     *
     * SELECT review.id_review, review.user_id_user, review.originality, review.format, review.language, review.comment,
     * article.id_article, article.title, article.author, article.date, article.file, article.status
     * FROM article JOIN review on article.id_article = review.article_id_article
     * WHERE review.user_id_user = 1
     *
     * @param $id
     * @return array
     */
    public function getAllReviewsOfUser($id) {
        $select = TABLE_REVIEW.".id_review, ".TABLE_REVIEW.".user_id_user, ".TABLE_REVIEW.".originality, ".TABLE_REVIEW.".format, ".TABLE_REVIEW.".language, ".TABLE_REVIEW.".comment, "
                 .TABLE_ARTICLE.".id_article, ".TABLE_ARTICLE.".title, ".TABLE_ARTICLE.".author, ".TABLE_ARTICLE.".date, ".TABLE_ARTICLE.".file, ".TABLE_ARTICLE.".status";
        $tableKey1 = TABLE_ARTICLE.".id_article";
        $tableKey2 = TABLE_REVIEW.".article_id_article";
        $where = TABLE_REVIEW.".user_id_user = ".$id;

        return parent::selectJoin($select, TABLE_ARTICLE, TABLE_REVIEW, $tableKey1, $tableKey2, "", $where);
    }

    /**
     * Joins tables 'article' and 'review' for columns with article attributes and returns rows.
     *
     * @return array
     */
    public function getArticleAttributes():array {
        $select = TABLE_ARTICLE.".id_article, ".TABLE_ARTICLE.".title, ".TABLE_ARTICLE.".author, ".TABLE_ARTICLE.".date, ".TABLE_ARTICLE.".file, ".TABLE_ARTICLE.".status";
        $tableKey1 = TABLE_ARTICLE.".id_article";
        $tableKey2 = TABLE_REVIEW.".article_id_article";
        $groupBy = TABLE_ARTICLE.".id_article";

        return parent::selectJoin($select, TABLE_ARTICLE, TABLE_REVIEW, $tableKey1, $tableKey2, $groupBy);
    }

    /**
     * Joins tables 'article', 'review', 'user' for single review and returns rows.
     *
     * @return array
     */
    public function getReviewsOfArticle():array {
        $select = TABLE_ARTICLE.".id_article, ".TABLE_USER.".username, ".TABLE_REVIEW.".originality, ".TABLE_REVIEW.".format, ".TABLE_REVIEW.".language, ".TABLE_REVIEW.".comment";
        $tableKey1 = TABLE_ARTICLE.".id_article";
        $tableKey2 = TABLE_REVIEW.".article_id_article";
        $tableKey3 = TABLE_USER.".id_user";
        $tableKey4 = TABLE_REVIEW.".user_id_user";

        return parent::selectJoinLeftJoin($select, TABLE_ARTICLE, TABLE_REVIEW, TABLE_USER, $tableKey1, $tableKey2, $tableKey3, $tableKey4);
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
     * Updates column in review according to id_article.
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
    public function updateReviewByIdArticle(string $column, string $value_rev, string $value_art) {
        $select = TABLE_REVIEW.".id_review";
        $where_inner = TABLE_REVIEW.".user_id_user IS NULL AND ".TABLE_REVIEW.".article_id_article = ".$value_art;
        $groupBy = TABLE_REVIEW.".article_id_article";

        $id_review = $this->selectFromTable($select, TABLE_REVIEW, $where_inner, "", "", $groupBy)[0]["id_review"];
        $where = TABLE_REVIEW.".id_review = ".$id_review;

        parent::updateTable(TABLE_REVIEW, $column, $value_rev, $where);
    }

    /**
     * Updates given column with given value according to given id_review
     *
     * @param $column
     * @param $value
     * @param $idRev
     */
    public function updateReviewByIdReview($column, $value, $idRev) {
        $where = "id_review = ".$idRev;
        parent::updateTable(TABLE_REVIEW, $column, "'$value'", $where);
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