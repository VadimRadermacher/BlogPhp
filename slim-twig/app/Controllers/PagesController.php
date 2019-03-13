<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesController {

  private $container;

  public function __construct($container) {
    
    $this->container = $container;
  }

  public function home(RequestInterface $request, ResponseInterface $response) {
      
    $result = $this->container->db->query("SELECT * FROM articles ORDER BY article_date DESC LIMIT 5")->fetchAll();
    //  var_dump($result[0]["article_date"]);
    $this->container->view->render($response, 'pages/home.twig', ['result' => $result]);
  }

  public function signup(RequestInterface $request, ResponseInterface $response) {
    
    $this->container->view->render($response, 'pages/signup.twig');
  }
  
  public function register(RequestInterface $request, ResponseInterface $response) {
    $user = $request->getParam("Pseudo");
    $pwd = $request->getParam("Password");
    $email = $request->getParam("Email");
    //var_dump($user, $pwd, $email);
    $result = $this->container->db->query("SELECT user_name, user_pwd FROM users WHERE user_name = '$user' ")->fetchAll();
    
    if ($result[0]['user_name'] != NULL)
      echo("username already taken");
    
    else {
      $hashed_pwd = password_hash($pwd, PASSWORD_BCRYPT);
      var_dump($result);
      $this->container->db->query("INSERT INTO users (user_name, user_pwd, user_email) VALUES ('$user', '$hashed_pwd', '$email')")->fetchAll();
    }
    $this->container->view->render($response, 'pages/home.twig');
  }

}
