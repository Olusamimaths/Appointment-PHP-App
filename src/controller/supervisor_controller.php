<?php

require_once 'src/model/supervisor_model.php';
require_once 'src/model/available_days_model.php';

class SupervisorController
{
    private $supervisorModel = null;
    private $availableDaysModel = null;

    public function __construct()
    {
        $this->supervisorModel = new SupervisorModel();
    }

    public function createSchedule($schedule)
    {
        $this->availableDaysModel->createDaysAvailable($schedule);
    }
}
