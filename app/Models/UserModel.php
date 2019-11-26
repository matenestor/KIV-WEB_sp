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

    public function getUserByName($name) {
        $where = "username='$name'";
        return parent::selectFromTable(TABLE_USER, $where);
    }
}
