<?php

// LOGIN :
if (isset($_POST['login_mail']) && isset($_POST['password'])) {

  $mail = mysqli_real_escape_string($db, $_POST['login_mail']);
  $password = $_POST['password'];
  $response = [];

  $admin = $db->prepare(
    "SELECT password, rights FROM admin WHERE mail = ?"
  );
  $admin->bind_param("s", $mail);
  $admin->execute();
  $admin->store_result();
  $admin->bind_result($admin_password, $admin_rights);

  if (isset($admin)) {
    $admin->fetch();
  }

  $partner = $db->prepare(
    "SELECT city, password, rights, first_connection FROM partner WHERE mail = ?"
  );
  $partner->bind_param("s", $mail);
  $partner->execute();
  $partner->store_result();
  $partner->bind_result($partner_city, $partner_password, $partner_rights, $partner_first_connection);

  if (isset($partner)) {
    $partner->fetch();
  }

  $structure = $db->prepare(
    "SELECT city, password, rights, first_connection FROM structure WHERE mail = ?"
  );
  $structure->bind_param("s", $mail);
  $structure->execute();
  $structure->store_result();
  $structure->bind_result($structure_city, $structure_password, $structure_rights, $structure_first_connection);

  if (isset($structure)) {
    $structure->fetch();
  }

  $admin->close();
  $partner->close();
  $structure->close();

  // LOGIN ADMIN :
  if (isset($admin_password) && password_verify($password, $admin_password)) {
    session_start();
    $_SESSION['admin_mail'] = htmlspecialchars($mail);
    $_SESSION['admin'] = 'initialize';
    $_SESSION['rights'] = htmlspecialchars($admin_rights);
    $response['rights'] = htmlspecialchars($admin_rights);
    echo json_encode($response);
    die();
  }

  // LOGIN PARTENAIRE :
  if (isset($partner_password) && password_verify($password, $partner_password)) {
    session_start();
    $_SESSION['partner_mail'] = htmlspecialchars($mail);
    $_SESSION['city'] = htmlspecialchars($partner_city);
    $_SESSION['rights'] = htmlspecialchars($partner_rights);
    $response['rights'] = htmlspecialchars($partner_rights);
    $response['city'] = htmlspecialchars($partner_city);
    $response['first_connection'] = htmlspecialchars($partner_first_connection);
    echo json_encode($response);
    die();
  }

  // LOGIN STRUCTURE :
  if (isset($structure_password) && password_verify($password, $structure_password)) {
    session_start();
    $_SESSION['structure_mail'] = htmlspecialchars($mail);
    $_SESSION['rights'] = htmlspecialchars($structure_rights);
    $response['rights'] = htmlspecialchars($structure_rights);
    $response['mail'] = htmlspecialchars($mail);
    $response['city'] = htmlspecialchars($structure_city);
    $response['first_connection'] = htmlspecialchars($structure_first_connection);
    echo json_encode($response);
    die();
  }

  $response['droits'] = 'Identifiants inconnus. Veuillez réessayer.';
  echo json_encode($response);
}
