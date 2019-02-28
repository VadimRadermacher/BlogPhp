<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('router', $app->getContainer()->get('router'));

// check if a table exists

function tableExists($db, $table) {

    // Try a select statement against the table
    // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        $result = $db->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}

// create a table

function createTable($db, $name) {
    $sresult = $db->query("CREATE TABLE $name (user_id serial PRIMARY KEY, 
                                user_name VARCHAR(255) UNIQUE NOT NULL,
                                user_pwd VARCHAR(255) NOT NULL,
                                user_email VARCHAR(255) NOT NULL)");

}


// can insert new users in the users table
// takes the db as argument and 'user_name', 'user_pwd' (which will be hashed), 'user_email' in the args array

function insertIntoUsers($db, $args) {
    $pwd = password_hash($args['pwd'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (user_name, user_pwd, user_email) VALUES (?,?,?)";
    $stmt= $db->prepare($sql);
    $stmt->execute([$args['user_name'], $pwd, $args['user_email']]);

}


// select tamer

function select($db, $name, $select, $where) {

    $result = $db->query("SELECT $select FROM $name WHERE $select = $where ")->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}





$app->get('/', function (Request $request, Response $response) {
    global $twig;
    // $string = password_hash("nabilaimecafe", PASSWORD_BCRYPT);
    // var_dump($string);
    // $args['string'] = $string;
    

    // if (password_verify("nabilaimecafe", $string)) {
    //     $response->write("<h1>ntm joe</h1>");
    // } else {
    //     echo 'Le mot de passe est invalide.';
    // }
    // if (!tableExists($this->db, 'vadimpout'))
    //     createTable($this->db, 'vadimpout');
    $args['user_name'] = 'vadim';
    $args['pwd'] = 'cafe';
    $args['user_email'] = 'test@test.test';
    $result = select($this->db, 'users', 'user_name', 'vadim');
    var_dump($result);
    
    //insertIntoUsers($this->db, $args);
    //$args['users'] = $this->db->query('INSERT INTO users (user_name, user_pwd, user_email) VALUES ("nabil", $string, "test@gmail.com")')->fetchAll(PDO::FETCH_ASSOC);
    return $response->getBody()->write($twig->render('home.twig', $args));
})->setName('home');


$app->get('/signup', function (Request $request, Response $response) {
    global $twig;
    return $response->getBody()->write($twig->render('signup.twig'));
})->setName('signup');
