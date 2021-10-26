<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User1507862;
use \App\Auth;

class LoginController1507862 extends \Core\Controller
{
    public function indexAction()
    {
        View::renderTemplate('Login/index1507862.html');
    }

    public function signinAction()
    {
        $user = User1507862::authenticate($_POST['email'],$_POST['password']);
        if ($user) {
            Auth::login($user);
            $this->redirect(Auth::getReturnPage());
        } else {
            View::renderTemplate('Login/index1507862.html', [
                'email' -> $_POST['email'],
            ]);        
        }
    }

    public function signoutAction()
    {
        Auth::logout();
        $this->redirect('/');
    }
}