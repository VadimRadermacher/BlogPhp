<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controllers\PagesController;

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

$app = new \Slim\App([

'settings' => [
    'displayErrorDetails' => true
  ]
]);
require '../app/container.php';



// Register routes
$app->get('/', \App\Controllers\PagesController::class . ':home');
$app->get('/signup', \App\Controllers\PagesController::class . ':signup');
$app->post('/', \App\Controllers\PagesController::class . ':login')->setName('/');
$app->post('/signup', \App\Controllers\PagesController::class . ':register');
