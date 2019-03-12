<?php

use Slim\Http\Request;
use Slim\Http\Response;
// use App\Controllers\PagesController;

//require '../app/container.php';
// Routes


// $twig = new \Twig\Environment($loader);
// $twig->addGlobal('router', $app->getContainer()->get('router'));
// $twig->addGlobal('navbar', [
//     'signup' => 'signup;'
// ]);



// DATABASE

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
    $result = $db->query("CREATE TABLE $name (user_id serial PRIMARY KEY,
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

/*function select($db, $name, $select, $where) {

    $result = $db->query("SELECT $select FROM $name WHERE $select = '$where' ")->fetchAll(PDO::FETCH_ASSOC);
    return $result;
<<<<<<< HEAD
}
$app = new \Slim\App([
=======
}*/

$app = new \Slim\App([

'settings' => [
    'displayErrorDetails' => true
  ]
]);
require '../app/container.php';



// Register routes
//require __DIR__ . '/../src/routes.php';
$app->get('/', \App\Controllers\PagesController::class . ':home');
$app->get('/signup', \App\Controllers\PagesController::class . ':signup');




//
// $app->get('/', function (Request $request, Response $response) {
//     //global $twig;
//     // $string = password_hash("nabilaimecafe", PASSWORD_BCRYPT);
//     // var_dump($string);
//     // $args['string'] = $string;
//
//
//     // if (password_verify("nabilaimecafe", $string)) {
//     //     $response->write("<h1>ntm joe</h1>");
//     // } else {
//     //     echo 'Le mot de passe est invalide.';
//     // }
//     // if (!tableExists($this->db, 'vadimpout'))
//     //     createTable($this->db, 'vadimpout');
//     $args['user_name'] = 'vadim';
//     $args['pwd'] = 'deschosesavecstephanie';
//     $args['user_email'] = 'vad@pout.pout';
//     $result = select($this->db, 'users', 'user_pwd', 'ALLHAILPOUTINE');
//     var_dump($result[0]['user_pwd']);
//
//
// //     insertIntoUsers($this->db, $args);
// //     //$args['users'] = $this->db->query('INSERT INTO users (user_name, user_pwd, user_email) VALUES ("nabil", $string, "test@gmail.com")')->fetchAll(PDO::FETCH_ASSOC);
// //     return $response->getBody()->write($twig->render('home.twig', $args));
// });//->setName('home');

/*$app->get('/signup', function (Request $request, Response $response, array $args) {

// TEST

$app->get('/', function (Request $request, Response $response) {
    global $twig;


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
<<<<<<< HEAD
    //$result = select($this->db, 'users', 'user_name', 'vadim');

=======
    $result = select($this->db, 'users', 'user_name', 'nabi');
    var_dump($result);
<<<<<<< HEAD
>>>>>>> faf49a1721c689b1c7efff86aed1a03aedd1fac6

=======

>>>>>>> bb41f71cac5e471cbd63ef60df4f0e9361cef695
    //insertIntoUsers($this->db, $args);
    return $response->getBody()->write($twig->render('home.twig'));
})->setName('home');


<<<<<<< HEAD
$app->get('/signup', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = "signup";
    return $response->getBody()->write($twig->render('signup.twig'));
    })->setName('signup');
=======
$app->get('/signup', function (Request $request, Response $response) {
    global $twig;
    $args['pagename'] = "signup";
    return $response->getBody()->write($twig->render('signup.twig'));
})->setName('signup');*/


function debug($var) {
	$debug = debug_backtrace();
	echo '<p>&nbsp;</p><p><a href="#" onclick="$(this).parent().next(\'ol\').slideToggle(); return false;"><strong>' . $debug[0]['file'] . ' </strong> l.' . $debug[0]['line'] . '</a></p>';
	echo '<ol style="display:none;">';
	foreach ($debug as $k => $v) {
		if ($k > 0) {
			echo '<li><strong>' . $v['file'] . '</strong> l.' . $v['line'] . '</li>';
		}
	}
	echo '</ol>';
	echo '<pre>';
	print_r($var);
	echo '</pre>';		
}

function login(){
//     $request = Slim::getInstance()->request();
//     $user = json_decode($request->getBody());
//     $user_name= "nabil";//$user->email;
//     $user_pwd= "pass";//$user->password;
//     debug($user);
//     echo($user_name);
// if(!empty($user_name)&&!empty($user_pwd)){
//         $sql="SELECT user_name, user_pwd FROM users WHERE user_name='$user_name' and user_pwd='$user_pwd'";
//         $db = getConnection();
//     try {
//         $result=$db->query($sql); 
//                 if (!$result) { // add this check.
//                       die('Invalid query: ' . mysql_error());
//                 }
//         $row["user"]= $result->fetchAll(PDO::FETCH_OBJ);
//         $db=null;
//         echo json_encode($row);
//     } catch(PDOException $e) 
//     {
//         error_log($e->getMessage(), 3, '/var/tmp/php.log');
//         echo '{"error":{"text":'. $e->getMessage() .'}}'; 
//     }
//     }
}
function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="root";
    $dbpass="";
    $dbname="TQA";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
