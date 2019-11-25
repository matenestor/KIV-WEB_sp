<?php


class ArticlesPublicController extends ABaseController {

    private $db;

    public function __construct() {
        $this->view = "ArticlesPublicView";
        $this->title = "Articles";
        $this->db = new ArticlesModel();

        // note: $this->data is going to be filled in show func
    }

    public function show() {
        // get all articles in database
        $this->data = $this->db->getAllArticles();

        // get created template
        $template = parent::getView(
            $this->view,
            $this->title,
            $this->data
        );

        return $template;
    }


}
