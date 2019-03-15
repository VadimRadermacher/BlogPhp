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

    $result = $this->container->db->query("SELECT *
                                           FROM articles NATURAL JOIN users
                                           ORDER BY article_date DESC LIMIT 5")->fetchAll();
    $this->container->view->render($response, 'pages/home.twig', ['result' => $result, 'session' => $_SESSION]);
  }

  public function logout(RequestInterface $request, ResponseInterface $response) {

    if (isset($_SESSION['permission'])) {
      unset($_SESSION['permission']);
      unset($_SESSION['user_name']);
    }

    return $response->withRedirect($this->container->router->pathFor('/'),301);
  }

  public function signup(RequestInterface $request, ResponseInterface $response) {

    $on_signup = 'yes';
    $this->container->view->render($response, 'pages/signup.twig', ['on_signup' => $on_signup]);
  }

  public function articles(RequestInterface $request, ResponseInterface $response) {

    if(!isset($_SESSION['permission']) || $_SESSION['permission'] == 'admin')
      return $response->withRedirect($this->container->router->pathFor('/'),301);

    $result = $this->container->db->query("SELECT *
                                           FROM articles NATURAL JOIN users
                                           ORDER BY article_date DESC")->fetchAll();

    $this->container->view->render($response, 'pages/articles.twig', ['result' => $result, 'session' => $_SESSION]);
  }

  public function users(RequestInterface $request, ResponseInterface $response) {

    if($_SESSION['permission'] != 'admin')
      return $response->withRedirect($this->container->router->pathFor('/'),301);

    $result = $this->container->db->query("SELECT user_name, user_email, user_permission
                                           FROM users ORDER BY user_name")->fetchAll();

    $this->container->view->render($response, 'pages/users.twig', ['result' => $result, 'session' => $_SESSION]);
  }

  public function changePermission(RequestInterface $request, ResponseInterface $response, $args) {

    if($_SESSION['permission'] != 'admin')
      return $response->withRedirect($this->container->router->pathFor('/'),301);

    $user_name = $args['name'];
    $permission = $args['permission'];

    if($permission == 0) {
      $this->container->db->query("UPDATE users SET user_permission=1
                                   WHERE user_name='$user_name' ")->fetchAll();
    }

    else if($permission == 1){
      $this->container->db->query("UPDATE users SET user_permission=0
                                   WHERE user_name='$user_name' ")->fetchAll();
    }

    else {
      $this->container->db->query("UPDATE users SET user_permission=2
                                   WHERE user_name='$user_name' ")->fetchAll();
    }

    return $response->withRedirect($this->container->router->pathFor('/users'),301);
  }

  public function dashboard(RequestInterface $request, ResponseInterface $response) {

    if($_SESSION['permission'] != 'admin')
      return $response->withRedirect($this->container->router->pathFor('/'),301);

    $result = $this->container->db->query("SELECT *
                                           FROM articles NATURAL JOIN users
                                           ORDER BY article_date DESC")->fetchAll();

    $this->container->view->render($response, 'pages/dashboard.twig', ['result' => $result, 'session' => $_SESSION]);
  }

  public function deleteArticle(RequestInterface $request, ResponseInterface $response, $args) {

    if($_SESSION['permission'] != 'admin')
      return $response->withRedirect($this->container->router->pathFor('/'),301);

    $article_id = $args['id'];
    $result = $this->container->db->query("DELETE FROM articles
                                           WHERE article_id='$article_id' ")->fetchAll();
    return $response->withRedirect($this->container->router->pathFor('/dashboard'),301);
  }

  public function editArticle(RequestInterface $request, ResponseInterface $response) {

    if($_SESSION['permission'] != 'admin')
      return $response->withRedirect($this->container->router->pathFor('/dashboard'),301);
    $article_id = $request->getParam('id');
    $title = $request->getParam('title');
    $content = $request->getParam('content');
    $user_name = $_SESSION['user_name'];
   $sql ="UPDATE articles SET article_title=:title, article_content =:content
                                           WHERE article_id=:article_id ";
   $result = $this->container->db->prepare($sql);
   $result->bindValue('title', $title, \PDO::PARAM_STR);
   $result->bindValue('content', $content, \PDO::PARAM_STR);
   $result->bindValue('article_id', $article_id, \PDO::PARAM_INT);
    try {
      $result->execute();
      $user = $result->fetch(\PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
      error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

    return $response->withRedirect($this->container->router->pathFor('/dashboard'),301);
  }

  public function createArticle(RequestInterface $request, ResponseInterface $response) {
    if($request->getParam('id') != NULL)
      return $this->editArticle($request, $response);

    $title = $request->getParam('title');
    $content = $request->getParam('content');
    $time = getdate();
    $user_name = $_SESSION['user_name'];
    $result = $this->container->db->query("SELECT user_id FROM users WHERE user_name='$user_name' ")->fetchAll();
    $user_id = $result[0]['user_id'];

    $sql = ("INSERT INTO articles (article_title, article_content, article_date, user_id) VALUES (:title, :content, NOW(), :user_id)");
    $result = $this->container->db->prepare($sql);
    $result->bindValue('title', $title, \PDO::PARAM_STR);
    $result->bindValue('content', $content, \PDO::PARAM_STR);
    $result->bindValue('user_id', $user_id, \PDO::PARAM_INT);
    try {
      $result->execute();
      $user = $result->fetch(\PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
      error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

    return $response->withRedirect($this->container->router->pathFor('/'),301);
  }

  public function register(RequestInterface $request, ResponseInterface $response) {

    $user = $request->getParam("Pseudo");
    $pwd = $request->getParam("Password");
    $email = $request->getParam("Email");
    $result = $this->container->db->query("SELECT user_name, user_pwd
                                                                                FROM users
                                                                                WHERE user_name = '$user' ")->fetchAll();

    if ($result[0]['user_name'] != NULL) {
      $error = 'username already taken';
      return   $this->container->view->render($response, 'pages/signup.twig', ['result' => $result, 'error' => $error]);
    }
    else {
      $hashed_pwd = password_hash($pwd, PASSWORD_BCRYPT);
      $sql="INSERT INTO users ( user_name, user_pwd, user_email)
                  VALUES ( :user_name, :hashed_pwd, :email)";
      $result = $this->container->db->prepare($sql);
      $result->bindValue('user_name', $user, \PDO::PARAM_STR);
      $result->bindValue('hashed_pwd', $hashed_pwd, \PDO::PARAM_STR);
      $result->bindValue('email', $email, \PDO::PARAM_STR);
      try {
        $result->execute();
        $user = $result->fetch(\PDO::FETCH_ASSOC);
      } catch(PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
    }

    return $response->withRedirect($this->container->router->pathFor('/'),301);
  }

  public function login(RequestInterface $request, ResponseInterface $response){

    $user_name = $request->getParam('Pseudo');
    $user_pwd = $request->getParam('Password');
    $sql="SELECT user_name, user_pwd, user_permission
          FROM users
          WHERE user_name=:user_name";

    $result = $this->container->db->prepare($sql);
    $result->bindValue('user_name', $user_name, \PDO::PARAM_STR);

    try {
      $result->execute();
      $user = $result->fetch(\PDO::FETCH_ASSOC);

      if(password_verify($user_pwd, $user['user_pwd'])) {
        $_SESSION['user_name'] = $user['user_name'];

        if($user['user_permission'] == 2)
          $_SESSION['permission'] = 'admin';

        else if ($user['user_permission'] == 1)
          $_SESSION['permission'] = 'author';

        else
          $_SESSION['permission'] = 'user';
      }
    } catch(PDOException $e) {
      error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

    return $response->withRedirect($this->container->router->pathFor('/'),301);
  }
}
