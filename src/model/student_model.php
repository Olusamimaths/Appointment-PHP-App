<?php
require_once 'database.php';
class StudentsModel extends Database
{
    public function getStudents()
    {
        $query = 'SELECT * FROM students';
        return $this->Select($query);
    }

    public function createStudent($student)
    {
        $query =
            'INSERT INTO students (firstName, lastName, matric, image) VALUES (?, ?, ?, ?)';
        $params = [
            'ssss',
            $student['firstName'],
            $student['lastName'],
            $student['matric'],
        ];
        return $this->Insert($query, $params);
    }

    public function getStudent($id)
    {
        $query = 'SELECT * FROM students WHERE id = ?';
        $params = ['i', $id];
        return $this->Select($query, $params);
    }
}
