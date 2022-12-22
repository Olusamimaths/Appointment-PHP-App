<?php
require_once 'database.php';
class DaysAvailableModel extends Database
{
    public function getDaysAvailable() {
        $query = 'SELECT * FROM DaysAvailable';
        return $this->Select($query);
    }

    public function createDaysAvailable($daysAvailable) {
        $query = 'INSERT INTO DaysAvailable (supervisor_id, day, start_time, end_time) VALUES (?, ?, ?, ?)';
        $params = [
            'isss',
            $daysAvailable['supervisor_id'],
            $daysAvailable['day'],
            $daysAvailable['start_time'],
            $daysAvailable['end_time']
        ];
        return $this->Insert($query, $params);
    }
}
