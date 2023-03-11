<?php

require_once 'env.php';
require_once 'vendor/autoload.php';
require_once './model/database/db_connection.php';
$db = OpenCon();

if ($_SERVER["SERVER_NAME"] !== "localhost") {
  ini_set('display_errors', 'Off');
  ini_set('log_errors', 'On');
  ini_set("error_log", "./model/errors/error_log");
} else {
  ini_set('display_errors', 'On');
}

foreach (glob("./model/CRUD/*") as $dossier) {
  foreach (glob($dossier . '/*.php') as $fichier) {
    require_once $fichier;
  }
}

require_once './model/session_timeout.php';

exit();