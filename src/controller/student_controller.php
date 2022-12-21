<?php

require_once 'src/model/student_model.php';
require_once 'src/model/appointment_request_model.php';

class StudentController
{
    private $studentModel = null;
    private $appointmentRequestModel = null;

    public function __construct()
    {
        $this->studentModel = new StudentsModel();
        $this->appointmentRequestModel = new AppointmentRequestModel();
    }

    public function register($student)
    {
        $password = $student['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $student['password'] = $hashedPassword;
        $this->studentModel->createStudent($student);
    }

    public function login($student)
    {
        $password = $student['password'];
        $validPassword = password_verify($password, $student['password']);
        if($validPassword)
        {
            // login
            return json_encode($student);
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
