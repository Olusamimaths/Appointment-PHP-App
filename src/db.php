<?php

// $servername = "127.0.0.1";
// $username = "guest";
// $password = "guest123*";
// $dbName = "csc415";

define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'guest');
define('DB_PASSWORD', 'guest123*');
define('DB_DATABASE_NAME', 'csc415');

class Database
{
    protected $conn = null;

    public function __construct()
    {
        try {
            $this->conn = new mysqli(
                DB_HOST,
                DB_USERNAME,
                DB_PASSWORD,
                DB_DATABASE_NAME
            );

            if (mysqli_connect_errno()) {
                throw new Exception('Database connection failed: ' . mysqli_connect_error());
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function insert($query = '', $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $result = $stmt->insert_id;
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function select($query = '', $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    private function executeStatement($query = '', $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                throw new Exception(
                    'Unable to do prepared statement: ' . $query
                );
            }
            if ($params) {
                $stmt->bind_param(...$params);
            }
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}