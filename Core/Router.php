<?php

namespace Core;

class Router
{

    protected $routes = [];

    protected $params = [];

    public function add($route, $params = [], $middleware = [])
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z-]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z-]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        $params["middleware"] = $middleware;
        $this->routes[$route] = $params;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    public function dispatch($url)
    {
        // loai bo querystring
        $url = $this->removeQueryStringVariables($url);
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller) . "Controller1507862";
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);
                if (preg_match('/action$/i', $action) == 0) {
                    $args = [];
                    $i = 0;
                    foreach ($this->params as $param) {
                        if ($i > 2) {
                            $args[] = $param;
                        }
                        $i++;
                    }
                    empty($args)
                        ? $controller_object->$action()
                        : $controller_object->$action(...$args);
                } else {
                    throw new \Exception("Method $action in controller $controller cannot be called directly");
                }
            } else {
                // echo "Controller class $controller not found";
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            // echo "No route matched";
            throw new \Exception("No route matched", 404);
        }
    }

    private function convertToStudlyCaps($string)
    {
        return str_replace('-', '', ucwords($string, "-"));
    }

    private function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    private function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    private function getNamespace()
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }

    public function getParams()
    {
        return $this->params;
    }
}