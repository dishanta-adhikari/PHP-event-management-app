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
}