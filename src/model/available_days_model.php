<?php
require_once 'database.php';
require_once 'Model.php';

class DaysAvailable {
    // Properties
    public int $supervisor_id;
    public string $day;
    public string $start_time;
    public string $end_time;
    public int $max_student;

    function __construct(int $supervisor_id, int $max_student, string $day, string $start_time, string $end_time)
    {
        $this->supervisor_id = $supervisor_id;
        $this->max_student = $max_student;
        $this->day = $day;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }

    function __serialize()
    {
        return [
            'supervisor_id' => $this->supervisor_id,
            'max_student' => $this->max_student,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time
        ];
    }
}
class DaysAvailableModel extends Database
{
        function __construct(Database $db)
    {
        $this->db = $db;
        // $this->table_name = 'Student';
    }

    public function getDaysAvailable() {
        $query = 'SELECT * FROM DaysAvailable';
        return $this->db->Select($query);
    }

    public function getScheduleForADay(string $day) {
        $query = 'SELECT * FROM DaysAvailable WHERE day = ?';
        $params = ['s', $day];
        return $this->db->Select($query, $params);
    }

    public function createDaysAvailable(DaysAvailable $daysAvailable) {
        $query = 'INSERT INTO DaysAvailable (supervisor_id, max_student, day, start_time, end_time) VALUES (?, ?, ?, ?, ?)';
        $params = [
            'iisss',
            $daysAvailable->supervisor_id,
            $daysAvailable->max_student,
            $daysAvailable->day,
            $daysAvailable->start_time,
            $daysAvailable->end_time
        ];
        return $this->db->Insert($query, $params);
    }
}
