<?php


class LoginController extends ABaseController {

    private $login;

    public function __construct() {
        $this->view = "LoginView";
        $this->title = "Log in";
        $this->login = new LoginService();
    }

    public function show() {
        // get view, which should be displayed
        $meta = $this->login->checkLogin();
        $this->view = $meta[0];
        $this->title = $meta[1];

        // get created template
        $template = parent::getView(
            $this->view,
            $this->title
        );

        return $template;
    }
}
