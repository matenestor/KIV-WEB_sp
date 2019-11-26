<?php


class ArticlesPublicController extends ABaseController {

    private $db;

    public function __construct() {
        $this->view = "ArticlesPublicView";
        $this->title = "Articles";
        $this->db = new ArticlesModel();
    }

    public function process() {
        // get all articles in database
        $this->data = $this->db->getAllArticles();

        $this->show();
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
