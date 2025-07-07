<?php

namespace App\Models;

class Club
{
    private $con;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function getAllClubs()
    {
        $query = "SELECT user_id, name FROM user WHERE user_type = 'club'";
        return $this->con->query($query);
    }

    public function getClubById($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM user WHERE user_id = ? AND user_type = 'club'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }
}