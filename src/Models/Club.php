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

    public function createClub($user_name, $name, $email, $phone, $user_id)
    {
        $stmt = $this->con->prepare("INSERT INTO club (user_name, name, email, phone, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $user_name, $name, $email, $phone, $user_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function deleteClubById($club_id)
    {
        $stmt = $this->con->prepare("DELETE FROM club WHERE club_id = ?");
        $stmt->bind_param("i", $club_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function deleteClub($club_id)
    {
        $stmt = $this->con->prepare("DELETE FROM club WHERE club_id = ?");
        $stmt->bind_param("i", $club_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

}