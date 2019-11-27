<?php

class UserModel extends BaseModel {

    /**
     * Returns all users.
     *
     *  Get all users in DB
     *  @return array
     */
    public function getAllUsers():array {
        return parent::selectFromTable(TABLE_USER);
    }

    /**
     * Return true if user is in database, else return false.
     *
     * @param $userName
     * @return bool
     */
    public function isUserInDB($userName) {
        $dbRow = $this->getUserByName($userName);
        return $dbRow != null;
    }

    /**
     * Get user's password.
     *
     * @param $userName
     * @return string|null
     */
    public function getUserPassword($userName) {
        return $this->getUserByName($userName)[0]["password"];
    }

    /**
     * Get user's role.
     *
     * @param $userName
     * @return string|null
     */
    public function getUserRole($userName) {
        return $this->getUserByName($userName)[0]["role"];
    }

    /**
     * Insert new user into database.
     *
     * @param $insertStatement
     * @param $values
     */
    public function insertUser($insertStatement, $values) {
        parent::insertIntoTable(TABLE_USER, $insertStatement, $values);
    }

    /**
     * Get row with given name of user.
     * @param $name
     * @return array
     */
    private function getUserByName($name) {
        $where = "username='$name'";
        return parent::selectFromTable(TABLE_USER, $where);
    }
}