<?php


class LoginController extends ABaseController {

    private $login;

    public function __construct() {
        $this->view = "LoginView";
        $this->head["title"] = "Log in";
        $this->head["description"] = "This is log in page for users.";
        $this->login = new LoginService();
    }

    public function show() {
        echo "post<br>";
        print_r($_POST);
        echo "<br>get<br>";
        print_r($_GET);
        echo "<br>";

        // get view, which should be displayed
        $this->view = $this->login->checkLogin();
//
        // get created template
        $template = parent::getView(
            $this->view,
            $this->head["title"],
            $this->head["description"]
        );

        return $template;
    }
}
