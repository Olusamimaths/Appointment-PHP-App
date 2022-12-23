<?php

require_once 'base_controller.php';
require_once 'src/model/database.php';
require_once 'src/model/available_days_model.php';

class DaysAvailabaleController extends Controller
{
    private $daysAvailableModel = null;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->daysAvailableModel = new DaysAvailableModel($this->db);
        $this->appointmentRequestModel = new AppointmentRequestModel();
    }

    public function createSchedule($schedules)
    {
        try {
            foreach ($schedules as $schedule) {
                var_dump($schedule->supervisor_id);

                $days_available= new DaysAvailable(
                    $schedule->supervisor_id,
                    $schedule->max_student,
                    $schedule->day,
                    $schedule->start_time,
                    $schedule->end_time
                );
                var_dump($days_available);
                $result = $this->daysAvailableModel->createDaysAvailable($days_available);
                var_dump($result);
            }
            
            return true;
        } catch (Exception $e) {
            printf($e->getMessage());
            return null;
        }
    }

    public function getAllSchedules() {
        try {
            $schedules = $this->daysAvailableModel->getDaysAvailable();
            var_dump($schedules);
            return $schedules;
        } catch (Exception $e) {
            printf($e->getMessage());
            return null;
        }
    }

}
