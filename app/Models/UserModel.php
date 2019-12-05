<?php

class UserModel extends BaseModel {

    /**
     * Returns all users, except for admin.
     *
     *  @return array
     */
    public function getAllUsers():array {
        $select = "*";
        $where = TABLE_USER.".role != 'admin'";
        return parent::selectFromTable($select, TABLE_USER, $where);
    }

    /**
     * Returns all users with role of reviewer.
     *
     *  @return array
     */
    public function getAllReviewers():array {
        $select = "`id_user`, `username`, `role`";
        $where = "role = 'reviewer'";
        return parent::selectFromTable($select, TABLE_USER, $where);
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
     * Get user's ID.
     *
     * @param $userName
     * @return string|null
     */
    public function getUserID($userName) {
        return $this->getUserByName($userName)[0]["id_user"];
    }

    /**
     * Get user's last login.
     *
     * @param $userName
     * @return string|null
     */
    public function getUserLastLogin($userName) {
        return $this->getUserByName($userName)[0]["last_login"];
    }

    /**
     * Get user's first name.
     *
     * @param $userName
     * @return mixed
     */
    public function getUserFirstName($userName) {
        return $this->getUserByName($userName)[0]["first_name"];
    }

    /**
     * Get user's last name.
     *
     * @param $userName
     * @return mixed
     */
    public function getUserLastName($userName) {
        return $this->getUserByName($userName)[0]["last_name"];
    }

    /**
     * Get user's full name.
     *
     * @param $userName
     * @return mixed
     */
    public function getUserFullName($userName) {
        $first_name = $this->getUserFirstName($userName);
        $last_name = $this->getUserLastName($userName);
        return $first_name." ".$last_name;
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
     * Update user's last login.
     *
     * @param $column
     * @param $value
     * @param $where
     */
    public function updateLastLogin($column, $value, $where) {
        parent::updateTable(TABLE_USER, $column, "'$value'", $where);
    }

    /**
     * Get row with given name of user.
     * @param $name
     * @return array
     */
    private function getUserByName($name) {
        $select = "*";
        $where = "username='$name'";
        return parent::selectFromTable($select, TABLE_USER, $where);
    }

    /**
     * Updates column of user.
     *
     * @param $id
     * @param $column
     * @param $value
     */
    public function updateUser($id, $column, $value) {
        $where = TABLE_USER.".id_user = ".$id;
        parent::updateTable(TABLE_USER, $column, "'$value'", $where);
    }

    /**
     * Deletes user from table.
     *
     * @param $id
     */
    public function deleteUser($id) {
        $where = TABLE_USER.".id_user = ".$id;
        parent::deleteFromTable(TABLE_USER, $where);
    }
}
