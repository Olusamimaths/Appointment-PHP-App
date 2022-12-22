<?php
require_once 'database.php';
require_once 'Model.php';

class Supervisor {
    // Properties
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $username;
    public string $password;
    public string|null $image;

    function __construct(string $first_name, string $last_name, string $email, string $username, string $password)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
    }

    function __serialize()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            'image' => $this->image
        ];
    }
}
class SupervisorModel extends Model
{
    function __construct(Database $db)
    {
        $this->db = $db;
        // $this->table_name = 'Student';
    }

    public function createSupervisor(Supervisor $supervisor)
    {
        
        try {
       $query =
            'INSERT INTO Supervisor (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)';
        $params = [
            'sssss',
            $supervisor->first_name,
            $supervisor->last_name,
            $supervisor->username,
            $supervisor->email,
            $supervisor->password,
        ];
        return $this->db->Insert($query, $params);
      } catch (Exception $e) {
        throw new Exception($e->getMessage());
      }
    }

    public function getSupervisor($id)
    {
        $query = 'SELECT * FROM supervisor WHERE id = ?';
        $params = ['i', $id];
        return $this->db->Select($query, $params);
    }

    public function getSupervisorByEmail($email) {
            $query = 'SELECT * FROM supervisor WHERE email = ?';
        $params = ['i', $email];
        return $this->db->Select($query, $params);
    }
}
