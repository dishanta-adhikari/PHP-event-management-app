<?php

namespace App\Models;

class User
{
    private $con;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM user";
        return $this->con->query($query);
    }

    public function findByEmail($email)
    {
        $stmt = $this->con->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findById($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM user WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getUserNameById($user_id)
    {
        $stmt = $this->con->prepare("SELECT name FROM user WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;
        return $row ? $row['name'] : '';
    }

    public function create($user_name, $name, $email, $phone, $pass, $user_type)
    {
        $stmt = $this->con->prepare("INSERT INTO user (user_name, name, email, phone, pass, user_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $user_name, $name, $email, $phone, $pass, $user_type);
        return $stmt->execute();
    }

    public function updatePassword($user_id, $new_password)
    {
        $stmt = $this->con->prepare("UPDATE user SET pass = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_password, $user_id);
        return $stmt->execute();
    }

    public function findByUsername($user_name)
    {
        $stmt = $this->con->prepare("SELECT * FROM user WHERE user_name = ?");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
