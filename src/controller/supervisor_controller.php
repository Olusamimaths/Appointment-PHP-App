<?php

require_once 'base_controller.php';
require_once 'src/model/supervisor_model.php';
require_once 'src/model/available_days_model.php';
require_once 'src/model/database.php';

class SupervisorController extends Controller
{
    private $supervisorModel = null;
    private $daysAvailableModel = null;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->supervisorModel = new SupervisorModel($this->db);
        $this->daysAvailableModel = new DaysAvailableModel($this->db);
    }

    public function register(
        string $first_name,
        string $last_name,
        string $email,
        string $username,
        string $password
    ) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $supervisor = new Supervisor(
                $first_name,
                $last_name,
                $email,
                $username,
                $hashed_password
            );
            $this->supervisorModel->createSupervisor($supervisor);
            unset($supervisor->password);
            return $supervisor;
        } catch (Exception $e) {
            printf($e->getMessage());
            return null;
        }
    }

    public function login(string $email, string $password)
    {
        try {
            $supervisor = $this->supervisorModel->getSupervisorByEmail($email);
            if ($supervisor && password_verify($password, $supervisor[0]['password'])) {
                unset($supervisor[0]['password']);
                return base64_encode($supervisor[0]['email']);
            }
            return null;
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }

    public function createSchedule($schedules)
    {
        for ($i = 0; $i < count($schedules); $i++) {
            $schedule = $schedules[$i];
            $this->daysAvailableModel->createDaysAvailable($schedule);
        }
        $this->daysAvailableModel->createDaysAvailable($schedule);
    }

    public function getScheduleForADay(string $day)
    {
        return $this->daysAvailableModel->getScheduleForADay($day);
    }
}
