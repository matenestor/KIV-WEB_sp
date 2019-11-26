<?php


class UserController extends ABaseController {
    private $db;

    public function __construct() {
        $this->db = new UserModel();
    }

    /**
     * Return true if user is in database, else return false.
     *
     * @param $userName
     * @return bool
     */
    public function isUserInDB($userName) {
        $dbRow = $this->db->getUserByName($userName);

        return $dbRow != null;
    }

    public function getUserPassword($userName) {
        return $this->db->getUserByName($userName)[0]["password"];
    }

    public function process() {
        global $login;

        // get user role by login name
        $userName = $login->getUserInfo()[0];
        $userRole = $this->db->getUserByName($userName)[0]["role"];

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
}