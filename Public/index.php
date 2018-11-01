<?php

// require the controller class
//require "../app/Controllers/Posts.php";

//require "../Core/Router.php";

//require_once dirname(__DIR__).'/Vendor/twig/twig/lib/Twig/Autoloader.php';

require "../vendor/autoload.php";
Twig_Autoloader::register();

/**
 * autoload
 */
//spl_autoload_register(function ($class) {
//    $root = dirname(__DIR__); // get the parent directory;
//    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
//    if (is_readable($file)) {
//        require $file;
//    }
//
//});

/**
 * Error and Exception handling
 */
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


$router = new Core\Router();
//echo get_class($router);

//Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);

$router->add("{controller}/{action}");
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);


$router->dispatch($_SERVER['QUERY_STRING']);