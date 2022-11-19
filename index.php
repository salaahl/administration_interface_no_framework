<?php


if ($_SERVER["SERVER_NAME"] !== "localhost") {
  ini_set('display_errors', 'Off');
  ini_set('log_errors', 'On');
  ini_set("error_log", "./back-end/errors/error_log");
} else {
  ini_set('display_errors', 'On');
}

require_once './back-end/database/db_connection.php';
$db = OpenCon();
require 'vendor/autoload.php';
if ($_SERVER["SERVER_NAME"] == "localhost") {
  include_once 'config_mail.php';
}

foreach (glob("./back-end/CRUD/*") as $dossier) {
  foreach (glob($dossier . '/*.php') as $fichier) {
    require_once $fichier;
  }
}

require_once './back-end/session_timeout.php';




exit();
