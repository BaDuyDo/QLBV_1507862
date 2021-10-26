<?php

namespace App\Controllers;

use \App\Models\User1507862;

class AccountController1507862 extends \Core\Controller
{
    public function validateEmailAction()
    {
        $is_valid = ! User1507862::emailExists($_GET['email']);
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
}