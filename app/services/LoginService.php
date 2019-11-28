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
        $this->sess->addSession($this->date, date("Y-m-d G:i:s"));
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
}
