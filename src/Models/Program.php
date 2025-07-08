<?php

namespace App\Models;

class Program
{
    private $con;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function getAllPrograms()
    {
        $query = "SELECT * FROM program ORDER BY program_id DESC";
        $result = $this->con->query($query);
        return $result;
    }

    public function getProgramById($program_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM program WHERE program_id = ? LIMIT 1");
        $stmt->bind_param("i", $program_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function getProgramsByUserId($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM program WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getProgramImage($program_id)
    {
        $stmt = $this->con->prepare("SELECT image FROM program WHERE program_id = ?");
        $stmt->bind_param("i", $program_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function isDuplicateProgram($name, $time, $venue)
    {
        $stmt = $this->con->prepare("SELECT * FROM program WHERE name = ? AND time = ? AND venue = ?");
        $stmt->bind_param("sss", $name, $time, $venue);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function addProgram($program_data)
    {
        $stmt = $this->con->prepare("INSERT INTO program (name, date, time, venue, image, staff_coordinator, phone1, student_coordinator, phone2, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssi", $program_data['name'], $program_data['date'], $program_data['time'], $program_data['venue'], $program_data['image'], $program_data['staff_coordinator'], $program_data['phone1'], $program_data['student_coordinator'], $program_data['phone2'], $program_data['user_id']);
        return $stmt->execute();
    }

    public function deleteProgram($program_id)
    {
        $stmt = $this->con->prepare("DELETE FROM program WHERE program_id = ?");
        $stmt->bind_param("i", $program_id);
        return $stmt->execute();
    }
}
