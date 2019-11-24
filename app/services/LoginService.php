<?php


class LoginService {

    /** Session user name */
    private $name;
    /** Session user date login */
    private $date;
    /** Session object */
    private $sess;

    public function __construct() {
        $this->name = "username";
        $this->date = "date";
        $this->sess = new SessionService();
    }

    /**
     * Add user name and date of login to session -- log in.
     *
     * @param string $userName
     */
    public function login($userName) {
        $this->sess->addSession($this->name, $userName);
        $this->sess->addSession($this->date, date("d. m. Y, G:m:s"));
    }

    /**
     * Remove user name and date of login from session -- log out.
     */
    public function logout() {
        $this->sess->removeSession($this->name);
        $this->sess->removeSession($this->date);
    }

    /**
     * Return if user is logged in.
     *
     * @return boolean
     */
    public function isUserLoged() {
        return $this->sess->isSessionSet($this->name);
    }

    /**
     * Return info about user.
     *
     * @return array
     */
    public function getUserInfo() {
        $name = $this->sess->readSession($this->name);
        $date = $this->sess->readSession($this->date);
        return array($name, $date);
    }

    /**
     * Return which view should be displayed and its title.
     *
     * @return array
     */
    public function checkLogin() {
        $meta = array("LoginView", "Log in");

        // user want to log in or out
        if (isset($_POST["submit_login"])) {
            $meta = array("HomeView", "Home page");

            // log in request
            if($_POST["submit_login"] == "login") {
                $this->login($_POST["username"]);
            }
            // log out request
            else if($_POST["submit_login"] == "logout") {
                $this->logout();
            }
            // error alert, just in case
            else {
                echo "<script>alert('Error: unknown request on server side.');</script>";
            }
        }
        // user is already logged in
        elseif ($this->isUserLoged()) {
            $meta = array("UserView", $this->getUserInfo()[0]);
        }

        return $meta;
    }
}
