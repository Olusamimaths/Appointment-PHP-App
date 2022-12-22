<?php
require_once 'database.php';
require_once 'Model.php';

class Student {
    // Properties
    public string $first_name;
    public string $last_name;
    public int $matric;
    public string $password;
    public string|null $image;

    function __construct(string $first_name, string $last_name, int $matric, string $password)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->matric = $matric;
        $this->password = $password;
    }

    function __serialize()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'matric' => $this->matric,
            'image' => $this->image
        ];
    }
}

class StudentsModel extends Model
{
    function __construct(Database $db)
    {
        $this->db = $db;
        // $this->table_name = 'Student';
    }

    public function getStudents()
    {
        $query = 'SELECT * FROM Student';
        return $this->db->Select($query);
    }

    public function createStudent(Student $student)
    {
       try {
        $query =
            'INSERT INTO Student (first_name, last_name, matric, password) VALUES (?, ?, ?, ?)';
        $params = [
            'ssis',
            $student->first_name,
            $student->last_name,
            $student->matric,
            $student->password
        ];
        return $this->db->Insert($query, $params);
      } catch (Exception $e) {
        throw new Exception($e->getMessage());
      }
    }

    public function getStudent($matric)
    {
        $query = 'SELECT * FROM Student WHERE matric = ?';
        $params = ['i', $matric];
        return $this->db->Select($query, $params);
    }
}
