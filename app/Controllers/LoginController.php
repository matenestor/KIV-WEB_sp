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
                // log in request
                case "login":
//                    $meta = array("UserView", "User");
                    $login->login($_POST["username"]);

                    $redirect = new UserController();
                    $redirect->process();
                    exit();

                    break;

                // log out request
                case "logout":
//                    $meta = array("HomeView", "Home page");
                    $login->logout();

                    $redirect = new HomeController();
                    $redirect->process();
                    exit();

                    break;

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
