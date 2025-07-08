<?php

namespace App\Controllers;

use App\Models\Club;

class ClubController
{
    private $clubModel;

    public function __construct($db)
    {
        $this->clubModel = new Club($db);
    }

    public function getClubs()
    {
        return $this->clubModel->getAllClubs();
    }

    public function getClubById($user_id)
    {
        return $this->clubModel->getClubById($user_id);
    }

    public function createClub($user_name, $name, $email, $phone, $user_id)
    {
        return $this->clubModel->createClub($user_name, $name, $email, $phone, $user_id);
    }

    public function deleteClubById($club_id)
    {
        return $this->clubModel->deleteClubById($club_id);
    }

    public function deleteClub($club_id)
    {
        return $this->clubModel->deleteClub($club_id);
    }

}