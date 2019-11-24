<?php


class UserController extends ABaseController {
    private $login;

    public function __construct() {
        $this->login = new LoginService();
        $this->view = "UserView";
        $this->title = $this->login->getUserInfo()[0];
    }

    public function show() {
        // get created template
        $template = parent::getView(
            $this->view,
            $this->title
        );

        return $template;
    }
}