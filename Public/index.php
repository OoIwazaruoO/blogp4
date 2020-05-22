<?php
define("__ROOT__", __DIR__);

use Core\Router;

require __DIR__ . "/../Vendors/Loader/SplClassLoader.php";

$coreLoader = new SplClassLoader('Core', __DIR__ . '/..');
$controllersLoader = new SplClassLoader('Controllers', __DIR__ . '/../App');
$managersLoader = new SplClassLoader('Managers', __DIR__ . '/../App/Models');
$entitiesLoader = new SplClassLoader('Entities', __DIR__ . '/../App/Models');

$coreLoader->register();
$controllersLoader->register();
$entitiesLoader->register();
$managersLoader->register();

try {
	$app = new Router("Controllers\\");

} catch (Exception $e) {
	require "../App/Views/404.php";
}