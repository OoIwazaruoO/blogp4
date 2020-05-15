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



try{
	$app = new Router("App\\Controllers\\");
}
catch(Exception $e){
	require "../App/Views/404.php";
	exit;
}