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
        // get created template
        $template = $this->getView();

        return $template;
    }

    /**
     * Called to get whole view of web page.
     *
     * @return false|string
     */
    private function getView() {
        // create variables for template
        // without this, it's necessary to type also $this-> into template
        $title = $this->head["title"];
        $description = $this->head["description"];

        // clean output buffer
        ob_clean();

        // create template -- header + body + footer
        require APP_PATH.DIR_VIEWS.LAYOUT.EXT_VIEW;

        // get template as string and clean output buffer
        $template = ob_get_clean();

        return $template;
    }

    /**
     * Called from Layout.phtml to get main content of web page.
     */
    private function getContent() {
        $data = $this->data;
        require APP_PATH.DIR_VIEWS.$this->view.EXT_VIEW;
    }
}
