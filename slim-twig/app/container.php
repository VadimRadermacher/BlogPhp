<?php
// DIC configuration

$container = $app->getContainer();
 $container['view'] = function ($container) {
   $dir = dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir . '/app/views', [
    'cache' => false //$dir . '/tmp/cache'
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    //     $view->offsetSet('session', $_SESSION);
     return $view;
 };
// view renderer
// $container['renderer'] = function ($c) {
//     $settings = $c->get('settings')['renderer'];
//     return new Slim\Views\PhpRenderer($settings['template_path']);
// };
//
// // monolog
// $container['logger'] = function ($c) {
//     $settings = $c->get('settings')['logger'];
//     $logger = new Monolog\Logger($settings['name']);
//     $logger->pushProcessor(new Monolog\Processor\UidProcessor());
//     $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
//     return $logger;
// };

$container['db'] = function($c) {
    // $settings = $c->get('settings')['db'];
    // var_dump($settings);
    // $connstring = $settings['dbType'] . ':';
    // unset($settings['dbType']);
    // foreach ($settings as $key => $value) {
    //     $connstring .= "$key=$value;";
    // }
    return new PDO("pgsql:host=localhost;port=5432;dbname=becode;user=becode;password=becode");
};
