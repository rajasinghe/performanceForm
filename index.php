<?php

require_once './Controllers/Controller.php';
require_once './Foundation/Router.php';
require_once './Controllers/ViewsController.php';
require_once './Controllers/PerformanceController.php';
require_once './Foundation/Request.php';
require_once './Database/DB.php';
/*
//load the dot env
//DIR means look the same directory as the
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//eloquent orm initilaization
$capsule = new Capsule;


$capsule->addConnection([
    'driver'    => $_ENV['DB_DRIVER'],
    'host'      => $_ENV['DATABASE_HOST'],
    'database'  => $_ENV['DATABASE_NAME'],
    'username'  => $_ENV['DATABASE_USERNAME'],
    'password'  => $_ENV['DATABASE_PASSWORD'],
    'charset'   => $_ENV['CHARSET'],
    'collation' => $_ENV['COLLATION'],
    'prefix'    => $_ENV['PREFIX'],
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$user = new User();
$user->name = 'John Doe';
$user->save();
*/
//router initialization

Router::initializeRouter();
