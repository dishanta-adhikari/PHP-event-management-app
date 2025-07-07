<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function getUsers()
    {
        return $this->userModel->getAllUsers();
    }

    public function getUserById($user_id)
    {
        return $this->userModel->findById($user_id);
    }

    public function getUserByEmail($email)
    {
        return $this->userModel->findByEmail($email);
    }

    public function getUserNameById($user_id)
    {
        return $this->userModel->getUserNameById($user_id);
    }

    public function createUser($name, $email, $pass, $user_type)
    {
        return $this->userModel->create($name, $email, $pass, $user_type);
    }

}