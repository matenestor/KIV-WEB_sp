<?php


class LoginController extends ABaseController {

    public function __construct() {
        $this->view = "LoginView";
        $this->title = "Log in";
    }

    public function process() {
        // check if came request for log IN or log OUT
        $redirect = $this->loginManage();

        // if user was logged in or logged out, redirect user
        if ($redirect != "") {
            header($redirect);
        }
        // no action -- show login page
        else {
            $this->show();
        }
    }

    private function loginManage() {
        global $login;
        $redirect = "";

        // user wants to log in or out
        if (isset($_POST["submit_login"])) {
            // LoginController communicates with UserController
            $userContr = new UserController();

            switch ($_POST["submit_login"]) {
                // log request
                case "login":
                    // error message to display, when user is blocked or input wrong credentials
                    $err_msg = "";
                    $userName = htmlspecialchars($_POST["username"]);

                    // if user is in database
                    if ($userContr->getDBConn()->isUserInDB($userName)) {
                        // if user is allowed to login
                        if ($userContr->getDBConn()->getUserAccess($userName) == "ok") {
                            // get true user's password
                            $password_hash = $userContr->getDBConn()->getUserPassword($userName);

                            // if password is correct
                            if (password_verify($_POST["password"], $password_hash)) {
                                // log in user
                                $login->login($userName);
                                // set redirect to 'user' page
                                $redirect = "Location: index.php?page=user";
                            }
                            // user input wrong password
                            else {
                                $err_msg = "Wrong password";
                            }
                        }
                        // user is blocked
                        else {
                            $err_msg = "You are blocked on this website.";
                        }
                    }
                    // user input wrong username or is not registered
                    else {
                        $err_msg = "Unknown user.";
                    }
                    
                    // note: if both username and password were correct, this scripts ends after being redirected to UserController
                    echo "<script>alert('".$err_msg."');</script>";
                    break;

                // log out request
                case "logout":
                    // update last login with session value
                    $userContr->updateLastLogin();
                    // log out user
                    $login->logout();
                    // set redirect to 'home' page
                    $redirect = "Location: index.php?page=home";
                    break;

                // error alert, just in case
                default:
                echo "<script>alert('Error: Unknown login request on server side.');</script>";
            }
        }

        return $redirect;
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
