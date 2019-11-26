<?php


class LoginController extends ABaseController {

    public function __construct() {
        $this->view = "LoginView";
        $this->title = "Log in";
    }

    public function process() {
        // check if came request for log IN or log OUT
        $this->loginManage();

        $this->show();
    }

    private function loginManage() {
        global $login;

        // user wants to log in or out
        if (isset($_POST["submit_login"])) {
            switch ($_POST["submit_login"]) {
                // log request
                case "login":
                    // log in user
                    $login->login($_POST["username"]);
                    // redirect user to 'user' page
                    $redirect = new UserController();
                    $redirect->process();
                    exit();

                // log out request
                case "logout":
                    // log out user
                    $login->logout();
                    // redirect user to 'home' page
                    $redirect = new HomeController();
                    $redirect->process();
                    exit();

                // error alert, just in case
                default:
                echo "<script>alert('Error: Unknown login request on server side.');</script>";
            }
        }
    }

    private function show() {
        // get view, which should be displayed
//        $meta = $this->login->checkLogin();
//        $this->view = $meta[0];
//        $this->title = $meta[1];

        // get created template
        $template = parent::getView(
            $this->view,
            $this->title
        );

        return $template;
    }
}
