<?php


class UserController extends ABaseController {
    private $db;

    public function __construct() {
        $this->db = new UserModel();
    }

    public function process() {
        global $login;

        // get user role by login name
        $userName = $login->getUserInfo()[0];
        $userRole = $this->db->getUserRole($userName);

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
        return $this->db;
    }
}