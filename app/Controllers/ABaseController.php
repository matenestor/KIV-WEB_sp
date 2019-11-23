<?php


abstract class ABaseController {
    protected $data = array();
    protected $view = "";
    protected $head = array("title" => "", "description" => "");

    /**
     * Called to get whole view of web page.
     *
     * @param $view
     * @param $title
     * @param $descr
     * @param null $data
     * @return false|string
     */
    protected function getView($view, $title, $descr, $data=null) {
        // clean output buffer
        ob_clean();

        // create template -- header + body + footer
        require APP_PATH.DIR_VIEWS.LAYOUT.EXT_VIEW;

        // get template as string and clean output buffer
        $template = ob_get_clean();

        return $template;
    }

    public function getContent($view, $data) {
        require APP_PATH.DIR_VIEWS.$view.EXT_VIEW;
    }
}