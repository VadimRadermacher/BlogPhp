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
    //var_dump($_SESSION);
    $this->container->view->render($response, 'pages/home.twig', ['result' => $result, 'session' => $_SESSION]);
  }

  public function signup(RequestInterface $request, ResponseInterface $response) {
    $on_signup = 'yes';
    $this->container->view->render($response, 'pages/signup.twig', ['on_signup' => $on_signup]);
  }

// public function login(RequestInterface $request, ResponseInterface $response, array $args){
//   $user_name = 'nabil';
//   $user_pwd = '$2y$10$sDRivHCkv8S7VW25inLkIesYDoko8oUSM9kn1dPs4hk3.ZU77JV/W';
//   // $user_name = $request->getParam('user_name');
//   // $user_pwd = $request->getParam('user_pwd');
//       $sql="SELECT user_name, user_pwd FROM users WHERE user_name=:user_name";
//       $result = $this->container->db->prepare($sql);
//       $result->bindValue('user_name', $user_name, \PDO::PARAM_STR);
//   try {
//       $result->execute();
//       $user = $result->fetch(\PDO::FETCH_ASSOC);
//       $_SESSION['auth'] = $user;
//   } catch(PDOException $e) {
//       error_log($e->getMessage(), 3, '/var/tmp/php.log');
//       echo '{"error":{"text":'. $e->getMessage() .'}}';
//   }
//   return $response->withRedirect($this->container->router->pathFor('/'),301);
//   }
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
    return $response->withRedirect($this->container->router->pathFor('/'),301);
  }

  public function login(RequestInterface $request, ResponseInterface $response){
    //$user_name = 'nabil';
    //$user_pwd = '$2y$10$sDRivHCkv8S7VW25inLkIesYDoko8oUSM9kn1dPs4hk3.ZU77JV/W';
    if ($_SESSION['auth'] != NULL) {
      $_SESSION['auth'] = NULL;
      return $response->withRedirect($this->container->router->pathFor('/'),301);
    }

    
    $user_name = $request->getParam('Pseudo');
    $user_pwd = $request->getParam('Password');
    $sql="SELECT user_name, user_pwd FROM users WHERE user_name=:user_name";
    $result = $this->container->db->prepare($sql);
    $result->bindValue('user_name', $user_name, \PDO::PARAM_STR);
    
    try {
      $result->execute();
      $user = $result->fetch(\PDO::FETCH_ASSOC);
      
      if(password_verify($user_pwd, $user['user_pwd']))
        $_SESSION['auth'] = $user['user_name'];
    } catch(PDOException $e) {
      error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    return $response->withRedirect($this->container->router->pathFor('/'),301);
  }


}
