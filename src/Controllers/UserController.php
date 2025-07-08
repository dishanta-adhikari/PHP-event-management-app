<?php

namespace App\Controllers;

require_once __DIR__ . '/../_init.php';

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

    public function getUserByEmailAndId($email, $user_id)
    {
        return $this->userModel->findByEmailandID($email, $user_id);
    }

    public function getUserNameById($user_id)
    {
        return $this->userModel->getUserNameById($user_id);
    }

    public function findByUsername($user_name)
    {
        return $this->userModel->findByUsername($user_name);
    }

    public function create($user_name, $name, $email, $phone, $pass, $user_type)
    {
        return $this->userModel->create($user_name, $name, $email, $phone, $pass, $user_type);
    }

    public function updatePassword($values)
    {
        if (empty($values['email']) || empty($values['pass']) || empty($values['newpass']) || empty($values['confpass'])) {
            return "All fields are required.";
        }

        $email = trim($values['email']);
        $currentPassword = $values['pass'];
        $newPassword = $values['newpass'];
        $confirmPassword = $values['confpass'];

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return "No user found with this email.";
        }

        if ($newPassword !== $confirmPassword) {
            return "New password and confirm password do not match.";
        }

        if (strlen($newPassword) < 6) {
            return "New password must be at least 6 characters long.";
        }

        if (!md5($currentPassword) == $user['pass']) {
            return "Current password is incorrect.";
        }

        if (md5($newPassword) == $user['pass']) {
            return "New password cannot be the same as the current password.";
        }

        $hashedPassword = md5($newPassword);
        $updated = $this->userModel->updatePassword($user['user_id'], $hashedPassword);

        if ($updated) {
            return "Password changed successfully.";
        } else {
            return "Failed to change password. Please try again.";
        }
    }

    public function deleteUserByIdAndEmail($values)
    {
        if (empty($values['username']) || empty($values['email']) || empty($values['pass'])) {
            return "Please fill in all fields.";
        }

        $username = trim($values['username']);
        $email = trim($values['email']);
        $pass = $values['pass'];

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return "No user found with this email.";
        }
        
        if (md5($pass) !== $user['pass']) {
            return "Incorrect password.";
        }

        $result = $this->userModel->deleteUserByIdAndEmail($user['user_id']);

        if ($result === true) {
            return "Account deleted successfully.";
        } else {
            return "Failed to delete account. Please try again.";
        }
    }
    
    
}