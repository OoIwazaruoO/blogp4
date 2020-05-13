<?php
use Core\Router;

require __DIR__ . "/../Vendors/Loader/SplClassLoader.php";

$coreLoader = new SplClassLoader('Core', __DIR__ . '/..');
$controllersLoader = new SplClassLoader('Controllers', __DIR__ . '/../App');
$managersLoader      = new SplClassLoader('Models', __DIR__ . '/../App/Models/Entities');
$entitiesLoader     = new SplClassLoader('Entities', __DIR__ . '/../App/Models/Managers');

$coreLoader->register();
$controllersLoader->register();
$entitiesLoader->register();
$managersLoader->register();



$app = new Router("App\\Controllers\\");