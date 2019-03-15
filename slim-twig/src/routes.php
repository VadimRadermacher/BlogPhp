<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controllers\PagesController;

$app = new \Slim\App([

'settings' => [
    'displayErrorDetails' => true
  ]
]);
require '../app/container.php';

$app->get('/', \App\Controllers\PagesController::class . ':home')->setName('/');
$app->get('/logout', \App\Controllers\PagesController::class . ':logout')->setName('/logout');
$app->get('/signup', \App\Controllers\PagesController::class . ':signup')->setName('/signup');
$app->get('/articles', \App\Controllers\PagesController::class . ':articles')->setName('/articles');
$app->get('/users', \App\Controllers\PagesController::class . ':users')->setName('/users');
$app->get('/users/change/{name}/{permission}', \App\Controllers\PagesController::class . ':changePermission');
$app->get('/dashboard', \App\Controllers\PagesController::class . ':dashboard')->setName('/dashboard');
$app->get('/dashboard/delete/article/{id}', \App\Controllers\PagesController::class . ':deleteArticle');

$app->post('/articles', \App\Controllers\PagesController::class . ':createArticle')->setName('/articles');
$app->post('/dashboard', \App\Controllers\PagesController::class . ':createArticle')->setName('/dashboard');
$app->post('/signup', \App\Controllers\PagesController::class . ':register')->setName('/signup');
$app->post('/', \App\Controllers\PagesController::class . ':login');
