<?php

namespace App\Controllers;

abstract class AuthenticatedController1507862 extends \Core\Controller
{
    protected function before()
    {
        $this->requireLogin();
    }
}