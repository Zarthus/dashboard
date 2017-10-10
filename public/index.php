<?php

use Symfony\Component\HttpFoundation\Request;
use Zarthus\Dashboard\Core\Kernel;
use Zarthus\Dashboard\Core\Router;

require __DIR__ . '/../vendor/autoload.php';

$kernel = new Kernel();
$kernel->boot();

$router = new Router($kernel);
$response = $router->index(Request::createFromGlobals());

echo $response->getContent();
