<?php

namespace App\Controllers;

use App\Models\User;

class LoginController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function login($values)
    {

        if (empty($values['email']) || empty($values['pass'])) {
            return "Please fill in all fields.";
        }

        $email = trim($values['email']);
        $pass = trim($values['pass']);

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return false;
        }
        if (md5($pass) == $user['pass']) {
            $_SESSION['user_id'] = $user['user_id'];
            return $user;
        }
        return false;
    }
}

