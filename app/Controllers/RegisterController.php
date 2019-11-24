<?php


class RegisterController extends ABaseController {

    public function __construct() {
        $this->view = "RegisterView";
        $this->head["title"] = "Registration";
        $this->head["description"] = "This is registration page for new users.";
    }

    public function show() {
        $this->checkRegister();

        // get created template
        $template = parent::getView(
            $this->view,
            $this->head["title"],
            $this->head["description"]
        );

        return $template;
    }

    private function checkRegister() {
        if (isset($_POST)) {
            return;
        }
    }
}