<?php
require_once 'database.php';
class DaysAvailableModel extends Database
{
    public function getDaysAvailable() {
        $query = 'SELECT * FROM DaysAvailable';
        return $this->Select($query);
    }

    public function createDaysAvailable($daysAvailable) {
        $query = 'INSERT INTO DaysAvailable (supervisorId, day, startTime, endTime) VALUES (?, ?, ?, ?)';
        $params = [
            'isss',
            $daysAvailable['supervisorId'],
            $daysAvailable['day'],
            $daysAvailable['startTime'],
            $daysAvailable['endTime']
        ];
        return $this->Insert($query, $params);
    }
}
