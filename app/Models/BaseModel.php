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
     * @param string $tableName
     * @param string $where
     * @param string $orderBy
     * @return array
     */
    protected function selectFromTable(string $tableName, string $where="", string $orderBy="") {
        $query = "SELECT * FROM ".$tableName
            .(($where=="") ? "" : " WHERE ".$where)
            .(($orderBy=="") ? "" : " ORDER BY ".$orderBy);

        $result = $this->executeQuery($query);

        if ($result == null) {
            return [];
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
}