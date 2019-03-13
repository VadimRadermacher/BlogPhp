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
  //  var_dump($result[0]["article_date"]);
    $this->container->view->render($response, 'pages/home.twig', ['result' => $result]);
    }
  public function signup(RequestInterface $request, ResponseInterface $response){
    $this->container->view->render($response, 'pages/signup.twig');
    }
  public function register(RequestInterface $request, ResponseInterface $response){
    $this->container->view->render($response, 'pages/home.twig');
  }

  
public function login(RequestInterface $request, ResponseInterface $response, array $args){
  $user_name = 'nabil';
  $user_pwd = '$2y$10$sDRivHCkv8S7VW25inLkIesYDoko8oUSM9kn1dPs4hk3.ZU77JV/W';
  //$user_name = $request->getParam('user_name');
  //$user_pwd = $request->getParam('user_pwd');
      $sql="SELECT user_name, user_pwd FROM users WHERE user_name=:user_name";
      $result = $this->container->db->prepare($sql);
      $result->bindValue('user_name', $user_name, \PDO::PARAM_STR);
  try {
      $result->execute();
      $user = $result->fetch(\PDO::FETCH_ASSOC);
      $_SESSION['auth'] = $user;
  } catch(PDOException $e) {
      error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
  return $response->withRedirect($this->container->router->pathFor('/'),301);
  }  
}
