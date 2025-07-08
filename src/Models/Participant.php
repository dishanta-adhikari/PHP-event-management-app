<?php

namespace App\Models;

class Participant
{
    private $con;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function isDuplicate($phone, $program_id)
    {
        $stmt = $this->con->prepare("SELECT participant_id FROM participant WHERE phone = ? AND program_id = ?");
        $stmt->bind_param("si", $phone, $program_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result && $result->num_rows > 0;
    }

    public function register($name, $email, $phone, $branch, $sem, $college, $program_id, $user_id)
    {
        $stmt = $this->con->prepare("INSERT INTO participant (name, email, phone, branch, sem, college, program_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssii", $name, $email, $phone, $branch, $sem, $college, $program_id, $user_id);
        return $stmt->execute();
    }

    public function getAllParticipants()
    {
        $stmt = $this->con->prepare("SELECT * FROM participant");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getParticipantsByProgramId($program_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM participant WHERE program_id = ?");
        $stmt->bind_param("i", $program_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function deleteParticipantById($participant_id)
    {
        $stmt = $this->con->prepare("DELETE FROM participant WHERE participant_id = ?");
        $stmt->bind_param("i", $participant_id);
        return $stmt->execute();
    }
}
