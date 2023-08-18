<?php

use App\App;
use App\Container;
use App\Controller\HomeController;
use App\Exceptions\RouteNotFoundException;
use App\Router;
use Dotenv\Dotenv;

require __DIR__ .'/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

/*
echo "<pre>";
var_dump($_SERVER);
echo "<pre>";
*/

$container = new Container;

$router = new Router($container);


$router->get('/', [\App\Controller\HomeController::class, 'index']);
$router->get('/users/register', [\App\Controller\UserController::class, 'create']);
$router->get('/users/welcome', [\App\Controller\UserController::class, 'register']);

$request = ["REQUEST_METHOD" => $_SERVER["REQUEST_METHOD"],"REQUEST_URI" => $_SERVER["REQUEST_URI"]];

(new App($router, $request, $container))->run();




