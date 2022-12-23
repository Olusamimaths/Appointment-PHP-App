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
            return null;
        }
    }

    public function login(string $matric, string $password)
    {
        try {
            $student = $this->studentModel->getStudent($matric);
            if ($student && password_verify($password, $student[0]['password'])) {
                unset($student[0]['password']);
                return base64_encode($student[0]['matric']);
            }
            return null;
        } catch (Exception $e) {
            printf($e->getMessage());
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
