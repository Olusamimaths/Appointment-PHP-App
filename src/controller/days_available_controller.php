<?php

require_once 'base_controller.php';
require_once 'src/model/database.php';
require_once 'src/model/available_days_model.php';

class DaysAvailabaleController extends Controller
{
    private $daysAvailableModel = null;
    private $appointmentRequestModel = null;
    private $messageModel = null;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->daysAvailableModel = new DaysAvailableModel($this->db);
        $this->appointmentRequestModel = new AppointmentRequestModel();
    }

    public function createSchedule($schedules)
    {
        try {
            $days_available = [];
            foreach ($schedules as $schedule) {
                $days_available[] = new DaysAvailable(
                    $schedule['supervisor_id'],
                    $schedule['day'],
                    $schedule['start_time'],
                    $schedule['end_time']
                );
            }
            $this->daysAvailableModel->createDaysAvailable($days_available);
            return $days_available;
        } catch (Exception $e) {
            printf($e->getMessage());
            return null;
        }
    }

    public function createAppointmentRequest($body)
    {
        $days_available_id = $body['days_available_id'];
        $student_matric = $body['student_matric'];
        $appointment_date = $body['appointment_date'];
        $status = $body['status'];
        $message = $body['message'];
        $supervisor_id = $body['supervisor_id'];

        try {
            if ($message != '') {
                $message_id = $this->messageModel->createMessage($message);
                $appointmentRequest = new Message(
                    $student_matric,
                    $supervisor_id,
                    'student',
                    $message
                );
                $this->appointmentRequestModel->createAppointmentRequest(
                    $appointmentRequest
                );

                $appointmentRequest = new AppointmentRequest(
                    $days_available_id,
                    $student_matric,
                    $appointment_date,
                    $status,
                    $message_id
                );
            } else {
                $appointmentRequest = new AppointmentRequest(
                    $days_available_id,
                    $student_matric,
                    $appointment_date,
                    $status,
                );
            }

            $this->appointmentRequestModel->createAppointmentRequest(
                $appointmentRequest
            );

            return $appointmentRequest;
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }
}
