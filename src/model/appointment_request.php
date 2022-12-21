<?php
require_once 'src/db.php';
class AppointmentRequestModel extends Database
{
    public function getAppointmentRequests()
    {
        $query = 'SELECT * FROM appointment_requests';
        return $this->Select($query);
    }

    public function createAppointmentRequest($appointmentRequest)
    {
        $query =
            'INSERT INTO appointment_requests (daysAvailableId,studentId, appointmentDate, status) VALUES (?, ?, ?, ?)';
        $params = [
            'iis',
            $appointmentRequest['daysAvailableId'],
            $appointmentRequest['studentId'],
            $appointmentRequest['appointmentDate'],
            "PENDING"
        ];
        return $this->Insert($query, $params);
    }

    public function updateAppointmentRequestStatus($appointmentRequest)
    {
        $query =
            'UPDATE appointment_requests SET status = ? WHERE id = ?';
        $params = [
            'si',
            $appointmentRequest['status'],
            $appointmentRequest['id']
        ];
        return $this->Insert($query, $params);
    }
}
