<?php

namespace App\Controllers;

use App\Models\Program;

class ProgramController
{
    private $programModel;

    public function __construct($db)
    {
        $this->programModel = new Program($db);
    }

    public function getPrograms()
    {
        return $this->programModel->getAllPrograms();
    }

    public function getProgramById($program_id)
    {
        return $this->programModel->getProgramById($program_id);
    }

    public function getProgramsByUserId($user_id)
    {
        return $this->programModel->getProgramsByUserId($user_id);
    }

    public function getUserIdByProgramId($program_id)
    {
        $program = $this->programModel->getProgramById($program_id);
        return $program ? $program['user_id'] : null;
    }

    public function getProgramImage($program_id)
    {
        return $this->programModel->getProgramImage($program_id);
    }

    public function deleteProgram($program_id)
    {
        return $this->programModel->deleteProgram($program_id);
    }
}
