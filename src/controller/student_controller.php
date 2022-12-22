<?php

require_once 'base_controller.php';
require_once 'src/model/database.php';
require_once 'src/model/student_model.php';
require_once 'src/model/appointment_request_model.php';

class StudentController extends Controller
{
    private $studentModel = null;
    private $appointmentRequestModel = null;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->studentModel = new StudentsModel($this->db);
        $this->appointmentRequestModel = new AppointmentRequestModel();
    }

    public function register(string $first_name, string $last_name, int $matric, string $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $student = new Student($first_name, $last_name, $matric, $hashedPassword);
            $this->studentModel->createStudent($student);
            unset($student->password);
            return $student;
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }

    public function login($password)
    {
        //$validPassword = password_verify($password, $student['password']);
        if(null)
        {
            // login
            return json_encode(null);
        }
        else
        {
            return json_encode(['error' => 'Invalid password']);
        }
    }

    public function createAppointmentRequest($body)
    {
        // $availableDaysId = $body['availableDaysId'];
        // $appointmentDate = $body['appointmentDate'];
        // $studentId = $body['studentId'];
        $this->appointmentRequestModel->createAppointmentRequest($body);
    }
}
