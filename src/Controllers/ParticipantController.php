<?php

namespace App\Controllers;

use App\Models\Participant;

class ParticipantController
{
    private $participantModel;

    public function __construct($db)
    {
        $this->participantModel = new Participant($db);
    }

    public function checkDuplicate($phone, $program_id)
    {
        return $this->participantModel->isDuplicate($phone, $program_id);
    }

    public function registerParticipant($name, $email, $phone, $branch, $sem, $college, $program_id, $user_id)
    {
        return $this->participantModel->register($name, $email, $phone, $branch, $sem, $college, $program_id, $user_id);
    }
}