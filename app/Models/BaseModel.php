<?php


class BaseModel {
    private $pdo;

    public function __construct() {
        $this->pdo = $this->connectDB();
    }

    public function __destruct() {
        $this->disconnectDB();
    }

    /**
     * Connects to database.
     *
     * @return PDO
     */
    private function connectDB() {
        try {
            // initialization of DB
            $pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
            // set encoding UTF-8
            $pdo->exec("set names utf8");
        }
        catch(PDOException $ex){
            die("Unable to connect to database. Please try again in a few minutes.");
        }

        return $pdo;
    }

    /**
     * Disconnects from database.
     */
    private function disconnectDB() {
        $this->pdo = null;
    }

    /**
     * Executes given query on connected DB.
     *
     * @param string $query
     * @return false|PDOStatement|null
     */
    protected function executeQuery(string $query) {
        // statement
        $stmt = $this->pdo->query($query);

        // get query successful
        if ($stmt) {
            return $stmt;
        }
        // query returned empty array
        else {
            $error = $this->pdo->errorInfo();
            echo $error[2];

            // return null
            return null;
        }
    }

    /**
     * Selects rows from given table with given specifics.
     *
     * @param string $select
     * @param string $tableName
     * @param string $where
     * @param string $orderBy
     * @param string $sort
     * @return array
     */
    protected function selectFromTable(string $select, string $tableName, string $where="", string $orderBy="", string $sort="") {
        $query = "SELECT ".$select." FROM ".$tableName
            .(($where=="") ? "" : " WHERE ".$where)
            .(($orderBy=="") ? "" : " ORDER BY ".$orderBy)
            .(($sort=="") ? "" : " ".$sort);

        $result = $this->executeQuery($query);

        if ($result == null) {
            return null;
        }

        return $result->fetchAll();
    }

    /**
     * Executes JOIN on 2 given tables with given keys.
     *
     * @param string $select
     * @param string $tableName1
     * @param string $tableName2
     * @param string $tableKey1
     * @param string $tableKey2
     * @param string $groupBy
     * @return array|null
     */
    protected function selectJoin(string $select, string $tableName1, string $tableName2,
                                  string $tableKey1, string $tableKey2, string $groupBy="") {
        $query = "SELECT ".$select
                ." FROM ".$tableName1." JOIN ".$tableName2
                ." on ".$tableKey1." = ".$tableKey2
                .(($groupBy=="") ? "" : " GROUP BY ".$groupBy);

        $result = $this->executeQuery($query);

        if ($result == null) {
            return null;
        }

        return $result->fetchAll();
    }

    /**
     * Executes JOIN on 2 given tables with given keys.
     *
     * @param string $select
     * @param string $tableName1
     * @param string $tableName2
     * @param string $tableName3
     * @param string $tableKey1
     * @param string $tableKey2
     * @param string $tableKey3
     * @param string $tableKey4
     * @param string $where
     * @return array|null
     */
    protected function selectJoinLeftJoin(string $select, string $tableName1, string $tableName2, string $tableName3,
                                  string $tableKey1, string $tableKey2, string $tableKey3, string $tableKey4, string $where="") {
        $query = "SELECT ".$select
            ." FROM ".$tableName1
            ." JOIN ".$tableName2." on ".$tableKey1." = ".$tableKey2
            ." LEFT JOIN ".$tableName3." on ".$tableKey3." = ".$tableKey4;

        $result = $this->executeQuery($query);

        if ($result == null) {
            return null;
        }

        return $result->fetchAll();
    }

    /**
     * Inserts into given table with given specifics.
     *
     * @param string $tableName
     * @param string $insertStatement
     * @param string $values
     * @return bool
     */
    protected function insertIntoTable(string $tableName, string $insertStatement, string $values) {
        $q = "INSERT INTO $tableName($insertStatement) VALUES ($values)";
        $result = $this->executeQuery($q);

        return $result == null;
    }

    /**
     * Updates given values in given table.
     *
     * @param string $tableName
     * @param string $column
     * @param $value
     * @param string $where
     * @return bool
     */
    protected function updateTable(string $tableName, string $column, $value, string $where) {
       $q = "UPDATE $tableName SET $column = $value WHERE $where";
       $result = $this->executeQuery($q);

       return $result == null;
    }

    /**
     * Deletes given row from given table.
     *
     * @param string $tableName
     * @param string $where
     * @return bool
     */
    protected function deleteFromTable(string $tableName, string $where) {
        $q = "DELETE FROM $tableName WHERE $where";
        $result = $this->executeQuery($q);

        return $result == null;
    }
}