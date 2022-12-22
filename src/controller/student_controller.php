<?php

require_once 'base_controller.php';
require_once 'src/model/database.php';
require_once 'src/model/student_model.php';
require_once 'src/model/appointment_request_model.php';

class StudentController extends Controller
{
    private $studentModel = null;
    private $appointmentRequestModel = null;
    private $messageModel = null;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->studentModel = new StudentsModel($this->db);
        $this->appointmentRequestModel = new AppointmentRequestModel();
    }

    public function register(
        string $first_name,
        string $last_name,
        int $matric,
        string $password
    ) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $student = new Student(
                $first_name,
                $last_name,
                $matric,
                $hashed_password
            );
            $this->studentModel->createStudent($student);
            unset($student->password);
            return $student;
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }

    public function login(string $matric, string $password)
    {
        try {
            $student = $this->studentModel->getStudent($matric);
            if (password_verify($password, $student->password)) {
                unset($student->password);
                return $student;
            }
            return base64_encode($student->matric);
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }

    public function createAppointmentRequest($body)
    {
        $days_available_id = $body['days_available_id'];
        $student_id = $body['student_id'];
        $appointment_date = $body['appointment_date'];
        $status = $body['status'];
        $message = $body['message'];

        try {
            if ($message != '') {
                $message_id = $this->messageModel->createMessage($message);
                $appointmentRequest = new AppointmentRequest(
                    $days_available_id,
                    $student_id,
                    $appointment_date,
                    $status,
                    $message_id
                );
                $this->appointmentRequestModel->createAppointmentRequest(
                    $appointmentRequest
                );
            }

            $appointmentRequest = new AppointmentRequest(
                $days_available_id,
                $student_id,
                $appointment_date,
                $status
            );
            $this->appointmentRequestModel->createAppointmentRequest(
                $appointmentRequest
            );

            return $appointmentRequest;
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }
}
