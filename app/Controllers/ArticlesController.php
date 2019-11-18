<?php


class ArticlesController extends ABaseController {

    private $db;

    public function __construct() {
        $this->view = "ArticlesView";
        $this->head["title"] = "Articles";
        $this->head["description"] = "This is web page with articles.";
        $this->db = new ArticlesModel();

        // note: $this->data is going to be filled in show func
    }

    public function show() {
        // get all articles in database
        $this->data = $this->db->getAllArticles();

        // create variables for template
        // without this, it's necessary to type also $this-> into template
        $msg = "<h2>HEADER</h2>";
        $msg2 = "<h2>FOOTER</h2>";
        $data = $this->data;
        $title = $this->head["title"];
        $description = $this->head["description"];

        // clean output buffer
        ob_clean();

        // create template -- header + body + footer
        require APP_PATH.DIR_VIEWS.HEADER.EXT_VIEW;
        require APP_PATH.DIR_VIEWS.$this->view.EXT_VIEW;
        require APP_PATH.DIR_VIEWS.FOOTER.EXT_VIEW;

        // get template as string and clean output buffer
        $template = ob_get_clean();

        return $template;
    }
}