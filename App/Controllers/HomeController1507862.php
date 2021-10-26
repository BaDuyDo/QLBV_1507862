<?php

namespace App\Controllers;

use \Core\View;

class HomeController1507862 extends \Core\Controller
{
    public function indexAction()
    {
        View::renderTemplate('Home/index1507862.html');
    }

    protected function after()
    {
        // echo "(after)";
    }

    protected function before()
    {
        // echo "(before)";
        return true;
    }
}