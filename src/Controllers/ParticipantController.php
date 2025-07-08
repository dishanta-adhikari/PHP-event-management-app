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

    public function getAllParticipants()
    {
        return $this->participantModel->getAllParticipants();
    }

    public function getParticipantsByProgramId($program_id)
    {
        return $this->participantModel->getParticipantsByProgramId($program_id);
    }

    public function checkDuplicate($phone, $program_id)
    {
        return $this->participantModel->isDuplicate($phone, $program_id);
    }

    public function registerParticipant($name, $email, $phone, $branch, $sem, $college, $program_id, $user_id)
    {
        return $this->participantModel->register($name, $email, $phone, $branch, $sem, $college, $program_id, $user_id);
    }

    public function deleteParticipantsByProgramId($program_id)
    {
        return $this->participantModel->deleteParticipantsByProgramId($program_id);
    }

    public function deleteParticipantById($participant_id)
    {
        return $this->participantModel->deleteParticipantById($participant_id);
    }
}
