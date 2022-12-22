<?php
require_once 'src/inc/config.php';

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
                DB_DATABASE_NAME,
                DB_PORT
            );

            if (mysqli_connect_errno()) {
                throw new Exception('Could not connect to database.');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create_tables()
    {
        try {
            $student_sql = "CREATE TABLE IF NOT EXISTS Student (
                matric int NOT NULL PRIMARY KEY,
                first_name varchar(50)  NOT NULL,
                last_name varchar(50)  NOT NULL,
                password varchar(255)  NOT NULL,
                image varchar(255) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );";

            $supervisor_sql = "CREATE TABLE IF NOT EXISTS Supervisor (
                id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                first_name varchar(50)  NOT NULL,
                last_name varchar(50)  NOT NULL,
                username varchar(50)  NOT NULL,
                image varchar(255) NULL,
                email varchar(255) NOT NULL,
                
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );";

            $message_sql = "CREATE TABLE IF NOT EXISTS Message (
                id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                source varchar(50)  NOT NULL,
                destination varchar(50)  NOT NULL,
                sentBy varchar(50) NOT NULL,
                body text NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );";

            $semester_sql = "CREATE TABLE IF NOT EXISTS Semester (
                id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                start_date varchar(50)  NOT NULL,
                end_date varchar(50)  NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );";

            $days_available_sql = "CREATE TABLE IF NOT EXISTS DaysAvailable (
                id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                day varchar(50)  NOT NULL,
                max_student int default(0),
                start_time varchar(50) NOT NULL,
                end_time varchar(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );";

            $appointment_request_sql = "CREATE TABLE IF NOT EXISTS AppointmentRequest (
                id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                days_available_id int  NOT NULL,
                FOREIGN KEY (days_available_id) REFERENCES DaysAvailable(id),
                appointment_date varchar(50) NOT NULL,
                student_matric int NOT NULL,
                FOREIGN KEY (student_matric) REFERENCES Student(matric),

                message_id int NULL,
                FOREIGN KEY (message_id) REFERENCES Message(id),

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );";
        
            $queries = [$student_sql, $supervisor_sql, $message_sql, $semester_sql, $days_available_sql, $appointment_request_sql];

            foreach($queries as $query){
                $this->connection->query($query);
            }
            // var_dump("Tables Created Successfully");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
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
                $stmt->bind_param(...$params);
            }

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
