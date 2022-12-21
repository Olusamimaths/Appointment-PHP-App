<?php
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'guest');
define('DB_PASSWORD', 'guest123*');
define('DB_DATABASE_NAME', 'csc415');

class Database
{
    private $connection = null;

    public function __construct(
    ) {
        try {
            $this->connection = new mysqli(
                DB_HOST,
                DB_USERNAME,
                DB_PASSWORD,
                DB_DATABASE_NAME
            );

            if (mysqli_connect_errno()) {
                throw new Exception('Could not connect to database.');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function Insert($query = '', $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $stmt->close();

            return $this->connection->insert_id;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return false;
    }

    public function Select($query = '', $params = [])
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

    public function Update($query = '', $params = [])
    {
        try {
            $this->executeStatement($query, $params)->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return false;
    }

    public function Remove($query = '', $params = [])
    {
        try {
            $this->executeStatement($query, $params)->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return false;
    }

    private function executeStatement($query = '', $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);

            if ($stmt === false) {
                throw new Exception(
                    'Unable to do prepared statement: ' . $query
                );
            }

            if ($params) {
                call_user_func_array([$stmt, 'bind_param'], $params);
            }

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
