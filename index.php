<?php

if ($_SERVER["SERVER_NAME"] == "localhost") {
  require_once 'env.php';
}
require_once 'vendor/autoload.php';
require_once './model/database/db_connection.php';
$conn = new Database(getenv("DB_HOST"), getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_CONN"));
$db = $conn->conn();

if ($_SERVER["SERVER_NAME"] !== "localhost") {
  ini_set('display_errors', 'Off');
  ini_set('log_errors', 'On');
  ini_set("error_log", "./model/errors/error_log");
} else {
  ini_set('display_errors', 'On');
}

// takes raw data from the request 
$json = file_get_contents('php://input');
// Converts it into a PHP object 
$_POST = json_decode($json, true);

foreach (glob("./model/CRUD/*") as $dossier) {
  foreach (glob($dossier . '/*.php') as $fichier) {
    require_once $fichier;
  }
}

require_once './model/session_timeout.php';

exit();
