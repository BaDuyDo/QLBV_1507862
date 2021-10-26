<?php

/**
 * Composer
 */
require '../vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting('E_ALL');
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Session
 */
session_start();

/**
 * Routing
 */
$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);




$router->add("{controller}/{action}");

$router->add('signup', ['controller' => 'Signup', 'action' => 'index']);

$router->add('login', ['controller' => 'Login', 'action' => 'index']);


$router->add('post1507862', ['controller' => 'Post', 'action' => 'index1507862']);
//$router->add('post1507862/{keyword:.*}', ['controller' => 'Post', 'action' => 'index1507862']);
$router->add('post1507862-create/{id:\d+}', ['controller' => 'Post', 'action' => 'create1507862']);
$router->add('post1507862-create', ['controller' => 'Post', 'action' => 'create1507862']);
$router->add('post1507862-save', ['controller' => 'Post', 'action' => 'save1507862']);
$router->add('post1507862-delete/{id:\d+}', ['controller' => 'Post', 'action' => 'delete1507862']);
// $router->add("{controller}/{id:\d+}/{action}");

$router->dispatch($_SERVER["QUERY_STRING"]);
