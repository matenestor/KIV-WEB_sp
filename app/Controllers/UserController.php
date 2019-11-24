<?php


class UserController extends ABaseController {
    private $login;

    public function __construct() {
        $this->login = new LoginService();
        $this->view = "UserView";
        $this->head["title"] = $this->login->getUserInfo()[0];
        $this->head["description"] = "This is page of logged in user.";
    }

    public function show() {
        // get created template
        $template = parent::getView(
            $this->view,
            $this->head["title"],
            $this->head["description"]
        );

        return $template;
    }
}