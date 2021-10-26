<?php

namespace Core;

use \App\Auth;
use App\Middleware;
use Exception;

abstract class Controller
{
    protected $route_params = [];

    public function __call($name, $args)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                $this->check();
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            // echo "Method $method not found in controller ".get_class($this);
            throw new Exception("Method $method not found in controller " . get_class($this));
        }
    }

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    protected function before()
    {
    }

    protected function after()
    {
    }

    protected function check()
    {
        $middlewares = $this->route_params['middleware'];
        foreach ($middlewares as $m) {
            if (!Middleware::init()[$m]) {
                throw new Exception("Don't have permission", 401);
            }
        }
    }

    public function redirect($url)
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit;
    }

    public function requireLogin()
    {
        if (!Auth::getUser()) {
            Auth::rememberRequestedPage();
            $this->redirect('/login');
        }
    }
}