<?php

use App\Controllers\PagesController;
require '../vendor/autoload.php';
require '../src/routes.php';

// Set up dependencies

// if (PHP_SAPI == 'cli-server') {
//     // To help the built-in PHP dev server, check if the request was actually for
//     // something which should probably be served as a static file
//     $url  = parse_url($_SERVER['REQUEST_URI']);
//     $file = __DIR__ . $url['path'];
//     if (is_file($file)) {
//         return false;
//     }
// }


session_start();

// Instantiate the app
//$settings = require __DIR__ . '/../src/settings.php';


// Run app
$app->run();
