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
                    // LoginController communicates with UserController
                    $redirect = new UserController();

                    // if user is in database
                    if ($redirect->getDBConn()->isUserInDB($_POST["username"])) {
                        $password_hash = $redirect->getDBConn()->getUserPassword($_POST["username"]);

                        // if password is correct
                        if (password_verify($_POST["password"], $password_hash)) {
                            // log in user
                            $login->login($_POST["username"]);
                            // redirect user to 'user' page
                            $redirect->process();
                            exit();
                        }
                    }

                    // user input wrong username and/or password
                    // note: if both username and password were correct, this scripts ends after being redirected to UserController
                    echo "<script>alert('Wrong user name or password.');</script>";
                    break;

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
        // get created template
        $template = parent::getView(
            $this->view,
            $this->title
        );

        return $template;
    }
}
