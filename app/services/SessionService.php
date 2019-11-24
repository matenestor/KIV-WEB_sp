<?php


class SessionService {

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Add value to session.
     *
     * @param $key
     * @param $value
     */
    public function addSession($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Remove session key.
     *
     * @param string $key
     */
    public function removeSession($key) {
        unset($_SESSION[$key]);
    }

    /**
     * Return value of actual session key or null, if not set.
     *
     * @param string $key
     * @return mixed|null
     */
    public function readSession($key) {
        $value = null;

        if($this->isSessionSet($key)) {
            $value = $_SESSION[$key];
        }

        return $value;
    }

    /**
     * Return if session key exists.
     *
     * @param string $key
     * @return boolean
     */
    public function isSessionSet($key) {
        return isset($_SESSION[$key]);
    }
}