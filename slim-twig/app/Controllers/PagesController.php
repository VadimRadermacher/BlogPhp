<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesController {

private $container;

public function __construct($container) {
  $this->container = $container;
  }
public function home(RequestInterface $request, ResponseInterface $response){
  $result = $this->container->db->query("SELECT * FROM articles ORDER BY article_date DESC LIMIT 5")->fetchAll();
  var_dump($result[0]["article_date"]);
  $this->container->view->render($response, 'pages/home.twig');
  }
  public function signup(RequestInterface $request, ResponseInterface $response){
    $this->container->view->render($response, 'pages/signup.twig');
    }
 }
