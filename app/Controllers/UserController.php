<?php


class UserController extends ABaseController {
    private $dbUser;

    public function __construct() {
        $this->dbUser = new UserModel();
    }

    public function updateLastLogin() {
        global $login;

        $column = "last_login";
        $value = sprintf("%s", $login->getLoginUserDate());
        $where = "user.id_user = ".$this->dbUser->getUserID($login->getLoginUserName());

        $this->dbUser->updateLastLogin($column, $value, $where);
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