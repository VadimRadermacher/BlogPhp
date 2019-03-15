<?php
// DIC configuration

$container = $app->getContainer();
 $container['view'] = function ($container) {
   $dir = dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir . '/app/views', [
    'cache' => false //$dir . '/tmp/cache'
    ]);

    // Instantiate and add Slim specific extension
    $router = $container['router'];
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    $view->getEnvironment()->addGlobal('session',$_SESSION);
    return $view;
 };



$container['db'] = function($c) {
    
    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=becode;user=becode;password=becode");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
