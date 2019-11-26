<?php


class UserController extends ABaseController {
    private $db;
    private $login;

    public function __construct() {
        $this->db = new UserModel();
        $this->login = new LoginService();
    }

    public function process() {
        $userName = $this->login->getUserInfo()[0];
        $userRole = $this->db->getUserByName($userName);

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
                $controller = null;
        }

        // call controller's view
        if ($controller != null) {
            $controller->process();
        }
        else {
//            echo "<script>alert('Error: unknown controller request on server side.');</script>";
            echo "<h1>-- User routed</h1>";
            $controller = new AdminController();
            $controller->process();
        }
    }
}