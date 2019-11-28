<?php


class UserController extends ABaseController {
    private $dbUser;

    public function __construct() {
        $this->dbUser = new UserModel();
    }

    public function updateLastLogin() {
        global $login;

        $column = "last_login";
        $values = sprintf("'%s'", $login->getUserInfo()[1]);
        $where = "user.id_user = ".$this->dbUser->getUserID($login->getUserInfo()[0]);

        $this->dbUser->updateLastLogin($column, $values, $where);
    }

    public function process() {
        global $login;

        // get user role by login name
        $userName = $login->getUserInfo()[0];
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