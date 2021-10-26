<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User1507862;

class SignupController1507862 extends \Core\Controller
{
    public function indexAction()
    {
        View::renderTemplate('Signup/index1507862.html');
    }

    public function createAction()
    {
        $user = new User1507862($_POST);
        if ($user->save()) {
            $this->redirect('/signup/success');
        } else {
            View::renderTemplate('Signup/index1507862.html', [
                'user' => $user
            ]);
        }
    }

    public function successAction()
    {
        View::renderTemplate('Signup/success1507862.html');
    }
}