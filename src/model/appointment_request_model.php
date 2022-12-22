<?php
require_once 'database.php';

class AppointmentRequest
{
    // Properties
    public string $id;
    public string $days_available_id;
    public string $student_matric;
    public string $message_id;
    public int $appointment_date;
    public string $status;

    function __construct(
        string $days_available_id,
        string $student_matric,
        int $appointment_date,
        string $status,
        $message_id = null
    ) {
        $this->days_available_id = $days_available_id;
        $this->student_matric = $student_matric;
        $this->appointment_date = $appointment_date;
        $this->status = $status;
        $this->message_id = $message_id;
    }

    function __serialize()
    {
        return [
            'days_available_id' => $this->days_available_id,
            'student_matric' => $this->student_matric,
            'appointment_date' => $this->appointment_date,
            'status' => $this->status,
            'message_id' => $this->message_id,
            'id' => $this->id,
        ];
    }
}
class AppointmentRequestModel extends Database
{
    public function getAppointmentRequests()
    {
        $query = 'SELECT * FROM appointment_requests';
        return $this->Select($query);
    }

    public function createAppointmentRequest($appointmentRequest)
    {
        if($appointmentRequest['message_id'] != null){
            $query =
                'INSERT INTO appointment_requests (days_available_id,student_id, appointment_date, status, message_id) VALUES (?, ?, ?, ?, ?)';
            $params = [
                'iissi',
                $appointmentRequest['days_available_id'],
                $appointmentRequest['student_id'],
                $appointmentRequest['appointment_date'],
                'PENDING',
                $appointmentRequest['message_id'],
            ];
            return $this->Insert($query, $params);
        }

        $query =
            'INSERT INTO appointment_requests (days_available_id,student_id, appointment_date, status, message) VALUES (?, ?, ?, ?)';
        $params = [
            'iiss',
            $appointmentRequest['days_available_id'],
            $appointmentRequest['student_id'],
            $appointmentRequest['appointment_date'],
            'PENDING',
        ];
        return $this->Insert($query, $params);
    }

    public function updateAppointmentRequestStatus($appointmentRequest)
    {
        $query = 'UPDATE appointment_requests SET status = ? WHERE id = ?';
        $params = [
            'si',
            $appointmentRequest['status'],
            $appointmentRequest['id'],
        ];
        return $this->Insert($query, $params);
    }
}
