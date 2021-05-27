<?php

use App\Core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application;

$app->router->get('/', function () {
    return "Hello World";
});

$app->router->get('/contact', function () {
    return "this is the contact page";
});

$app->run();
