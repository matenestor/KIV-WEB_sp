<?php


abstract class ABaseController {
    protected $view = "";
    protected $title = "";
    protected $data = array();

    /**
     * Called to get whole view of web page.
     *
     * @param $view
     * @param $title
     * @param null $data Data to be displayed
     * @return false|string
     */
    protected function getView($view, $title, $data=null) {
        // clean output buffer
        ob_clean();

        // create template -- header + body + footer
        require APP_PATH.DIR_VIEWS.LAYOUT.EXT_VIEW;

        // get template as string and clean output buffer
        ob_flush(); flush();
        $template = ob_get_clean();

        return $template;
    }

    public function getContent($view, $data) {
        require APP_PATH.DIR_VIEWS.$view.EXT_VIEW;
    }
}