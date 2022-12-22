<?php
require_once 'database.php';

class DaysAvailable {
    // Properties
    public string $supervisor_id;
    public string $day;
    public int $start_time;
    public string $end_time;

    function __construct(string $supervisor_id, string $day, int $start_time, string $end_time)
    {
        $this->supervisor_id = $supervisor_id;
        $this->day = $day;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }

    function __serialize()
    {
        return [
            'supervisor_id' => $this->supervisor_id,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time
        ];
    }
}
class DaysAvailableModel extends Database
{
    public function getDaysAvailable() {
        $query = 'SELECT * FROM DaysAvailable';
        return $this->Select($query);
    }

    public function getScheduleForADay(string $day) {
        $query = 'SELECT * FROM DaysAvailable WHERE day = ?';
        $params = ['s', $day];
        return $this->Select($query, $params);
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
