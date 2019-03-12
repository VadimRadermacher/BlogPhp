<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesController {

private $container;

public function __construct($container) {
  $this->container = $container;
  }
public function home(RequestInterface $request, ResponseInterface $response, array $args){
  $this->container->view->render($response, 'pages/home.twig', array("user"=>$_SESSION['auth']));
  }
public function signup(RequestInterface $request, ResponseInterface $response){
  $this->container->view->render($response, 'pages/signup.twig');
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
  return $response->withRedirect($this->container->router->pathFor('app.home'),301);
  }  
}
