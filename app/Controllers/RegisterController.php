<?php


class RegisterController extends ABaseController {

    public function __construct() {
        $this->view = "RegisterView";
        $this->title = "Registration";
    }

    public function show() {
        $this->checkRegister();

        // get created template
        $template = parent::getView(
            $this->view,
            $this->title
        );

        return $template;
    }

    private function checkRegister() {
        if (isset($_POST)) {
            return;
        }
    }
}