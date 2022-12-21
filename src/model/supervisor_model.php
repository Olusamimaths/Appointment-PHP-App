<?php
require_once 'database.php';
class SupervisorModel extends Database
{
    public function createSupervisor($supervisor)
    {
        $query =
            'INSERT INTO supervisors (firstName, lastName, username, email, image) VALUES (?, ?, ?, ?)';
        $params = [
            'sssss',
            $supervisor['firstName'],
            $supervisor['lastName'],
            $supervisor['username'],
            $supervisor['email'],
            $supervisor['image'],
        ];
        return $this->Insert($query, $params);
    }

    public function getSupervisor($id)
    {
        $query = 'SELECT * FROM supervisors WHERE id = ?';
        $params = ['i', $id];
        return $this->Select($query, $params);
    }
}
