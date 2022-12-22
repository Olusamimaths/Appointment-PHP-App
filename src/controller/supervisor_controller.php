<?php

require_once 'src/model/supervisor_model.php';

class SupervisorController
{
    private $supervisorModel = null;

    public function __construct()
    {
        $this->supervisorModel = new SupervisorModel();
    }

    public function createSchedule($schedule)
    {
        $this->supervisorModel->createSchedule($schedule);
    }
}
