<?php


class RegisterController extends ABaseController {

    private $dbUser;

    public function __construct() {
        $this->view = "RegisterView";
        $this->title = "Registration";
        $this->dbUser = new UserModel();
    }

    public function process() {
        $redirect = $this->registerManage();

        // if user was registered, redirect user
        if ($redirect != "") {
            header($redirect);
        }
        // no action -- show registration page
        else {
            $this->show();
        }
    }

    private function registerManage() {
        global $login;
        $redirect = "";

        if (isset($_POST["submit_register"])
                and $_POST["submit_register"] == "register") {
            // username is not in database -- register user
            if (!$this->dbUser->isUserInDB($_POST["username"])) {
                $insertStatement = "username, first_name, last_name, role, last_login, access, password";
                $values = sprintf("'%s', '%s', '%s', '%s', %s, '%s', '%s'",
                    $_POST["username"],
                    $_POST["first_name"],
                    $_POST["last_name"],
                    $_POST["role"] == "author" ? "author" : "reviewer",
                    "CURRENT_TIMESTAMP()",
                    "ok",
                    password_hash($_POST["password"], PASSWORD_DEFAULT)
                );
                // insert user to database
                $this->dbUser->insertUser($insertStatement, $values);
                // login user right after registration
                $login->login($_POST["username"]);
                // set redirect to user page
                $redirect = "Location: index.php?page=user";

                echo "<script>alert('Successfully registered.');</script>";
            }
            // username is already in database
            else {
                echo "<script>alert('Username already exists.');</script>";
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