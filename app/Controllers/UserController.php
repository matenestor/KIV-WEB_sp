<?php


class UserController extends ABaseController {
    private $dbUser;

    public function __construct() {
        $this->dbUser = new UserModel();
    }

    public function updateLastLogin() {
        global $login;
        $userName = $login->getLoginUserName();

        // get login from this session
        $value = sprintf("%s", $login->getLoginUserDate());
        // set new last login value
        $this->dbUser->updateLastLogin($userName, $value);
    }

    public function process() {
        global $login;

        // get user role by login name
        $userName = $login->getLoginUserName();
        $userRole = $this->dbUser->getUserRole($userName);

        // create controller according to logged in user
        switch ($userRole) {
            case "admin":
                $controller = new AdminController();
                break;
            case "reviewer":
                $controller = new ReviewerController();
                break;
            case "author":
                $controller = new AuthorController();
                break;
            default:
                $controller = new RegisterController();
        }

        $controller->process();
    }

    public function getDBConn() {
        return $this->dbUser;
    }
}