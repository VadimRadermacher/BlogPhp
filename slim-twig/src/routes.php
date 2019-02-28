<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('router', $app->getContainer()->get('router'));


$app->get('/', function (Request $request, Response $response) {
    global $twig;
    $string = password_hash("nabilaimecafe", PASSWORD_BCRYPT);
    var_dump($string);
    $args['string'] = $string;


    if (password_verify("nabilaimecafe", $string)) {
        $response->write("<h1>ntm joe</h1>");
    } else {
        echo 'Le mot de passe est invalide.';
    }

    $sql = "INSERT INTO users (user_name, user_pwd, user_email) VALUES (?,?,?)";
    $stmt= $this->db->prepare($sql);
    $stmt->execute(["nabi", $string, "wo@gmail.com"]);
    //$args['users'] = $this->db->query('INSERT INTO users (user_name, user_pwd, user_email) VALUES ("nabil", $string, "test@gmail.com")')->fetchAll(PDO::FETCH_ASSOC);
    return $response->getBody()->write($twig->render('home.twig', $args));
})->setName('home');


$app->get('/signup', function (Request $request, Response $response) {
    global $twig;
    return $response->getBody()->write($twig->render('signup.twig'));
})->setName('signup');
